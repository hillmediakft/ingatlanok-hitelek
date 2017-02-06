<?php
namespace System\Admin\Controller;

use System\Core\AdminController;
use System\Core\View;
use System\Libs\Session;
use System\Libs\Auth;
use System\Libs\Config;
use System\Libs\Message;
use System\Libs\DI;
use System\Libs\EventManager;
use System\Libs\Geocoder;
use System\Libs\Uploader;

class Property extends AdminController {

    function __construct() {
        parent::__construct();
        $this->loadModel('property_model');
    }

    /**
     * Ingatlanok listája
     */
    public function index()
    {
        $view = new View();

        $data['is_superadmin'] = (Auth::isSuperadmin()) ? true : false;
        $data['filter'] = array();
        $data['title'] = 'Ingatlanok oldal';
        $data['description'] = 'Ingatlanok oldal description';

        //$this->loadModel('users_model');
        $data['users'] = $this->property_model->usersList();
        $data['county_list'] = $this->property_model->countyList();
        // kerületek nevének és id-jének lekérdezése az option listához
        $data['district_list'] = $this->property_model->list_query('district_list');
        // ingatlan kategóriák lekérdezése
        $data['ingatlan_kat_list'] = $this->property_model->list_query('ingatlan_kategoria');

        if (!$data['is_superadmin']) {
            $view->add_links(array('datatable', 'select2', 'bootbox', 'vframework', 'property_list'));
        } else {
            $view->add_links(array('datatable', 'select2', 'bootbox', 'vframework', 'property_list_superadmin'));
        }
// $view->debug(true);
        $view->render('property/tpl_property_list', $data);
    }

    /**
     * Ingatlan részletek
     */
    public function details($id) {
        // $id = (int) $this->request->get_params('id');
        $id = (int) $id;

        $view = new View();

        $data['title'] = 'Ingatlan részletek oldal';
        $data['description'] = 'Ingatlan részletek oldal description';
        $data['property_data'] = $this->property_model->getPropertyDetails($id);
        $data['photos'] = json_decode($data['property_data']['kepek']);
        $data['docs'] = json_decode($data['property_data']['docs']);
        //$view->debug(true);

        $view->setHelper(array('url_helper'));
        $view->add_links(array('fancybox', 'property_details'));
        $view->render('property/tpl_property_details', $data);
    }

    public function search() {
        die('work in progress');
    }

    /**
     *  (AJAX) Az ingatlanok listáját adja vissza és kezeli a csoportos művelteket is
     */
    public function getPropertyList()
    {
        if ($this->request->is_ajax()) {

            $request_data = $this->request->get_post();

            // csoportos műveletek üzenetei
            $custom_action_message = '';
            // berakjuk session-be a request adatokat
            Session::set('property_filter', $request_data);

            // csoportos műveletek kezelése
            if (isset($request_data['customActionType']) && isset($request_data['customActionName'])) {

                switch ($request_data['customActionName']) {

                    case 'group_delete':
                        // az id-ket tartalmazó tömböt kapja paraméterként
                        $result = $this->_delete($request_data['id']);

                        if ($result !== false) {
                            $custom_action_message = $result . ' ingatlan törölve.';
                            EventManager::trigger('delete_property', array('delete', $result . ' ingatlan törlése'));
                        } else {
                            $custom_action_message = Message::show('Adatbázis lekérdezési hiba!');
                        }
                        break;

                    case 'group_make_active':

                        $result = $this->_status_kiemeles_update($request_data['id'], 'status', 1);

                        if ($result >= 0) {
                            $custom_action_message = $result . ' rekord státusza aktívra változott.';
                        } else if ($result === false) {
                            $custom_action_message = Message::show('Adatbázis lekérdezési hiba!');
                        }
                        break;

                    case 'group_make_inactive':

                        $result = $this->_status_kiemeles_update($request_data['id'], 'status', 0);

                        if ($result >= 0) {
                            $custom_action_message = $result . ' rekord státusza inaktívra változott.';
                        } else if ($result === false) {
                            $custom_action_message = Message::show('Adatbázis lekérdezési hiba!');
                        }
                        break;

                    case 'group_make_highlight':

                        $result = $this->_status_kiemeles_update($request_data['id'], 'kiemeles', 1);

                        if ($result >= 0) {
                            $custom_action_message = $result . ' elem kiemelve.';
                        } else if ($result === false) {
                            $custom_action_message = Message::show('Adatbázis lekérdezési hiba!');
                        }
                        break;

                    case 'group_delete_highlight':

                        $result = $this->_status_kiemeles_update($request_data['id'], 'kiemeles', 0);

                        if ($result >= 0) {
                            $custom_action_message = $result . ' elem kiemelés törölve.';
                        } else if ($result === false) {
                            $custom_action_message = Message::show('Adatbázis lekérdezési hiba!');
                        }
                        break;
                }
            }


            //összes sor számának lekérdezése
            $total_records = $this->property_model->count('ingatlanok');

            $display_length = intval($request_data['length']);
            $display_length = ($display_length < 0) ? $total_records : $display_length;
            $display_start = intval($request_data['start']);
            $display_draw = intval($request_data['draw']);

            // adatok lekérdezése SQL_CALC_FOUND_ROWS kulcsszóval
            $result = $this->property_model->filteredPropertys($request_data, $display_start, $display_length);
            // szűrés utáni visszaadott eredmények száma
            $filtered_records = $this->property_model->foundRows();

            // ebbe a tömbbe kerülnek az elküldendő adatok
            $data = array();

            $num_helper = DI::get('num_helper');

            foreach ($result as $value) {

                // id attribútum hozzáadása egy sorhoz 
                //$temp['DT_RowId'] = 'ez_az_id_' . $value['job_id'];
                // class attribútum hozzáadása egy sorhoz 
                //$temp['DT_RowClass'] = 'proba_osztaly';
                // csak a datatables 1.10.5 verzió felett
                //$temp['DT_RowAttr'] = array('data-proba' => 'ertek_proba');

            // 1. Checkbox oszlop    
                $temp['checkbox'] = (1) ? '<input type="checkbox" class="checkboxes" name="ingatlan_id_' . $value['id'] . '" value="' . $value['id'] . '"/>' : '';

            // 2. id oszlop    
                $temp['id'] = '#' . $value['id'] . '<br>';
                if ($value['kiemeles'] == 1) {
                    $temp['id'] .= '<span class="label label-sm label-success">Kiemelt</span>';
                }
                if ($value['kiemeles'] == 2) {
                    $temp['id'] .= '<span class="label label-sm label-warning">Kiemelt</span>';
                }

            // 3. Referenci szám oszlop    
                $temp['ref_num'] = $value['ref_num'];


            // 4. Képek oszlop    
                if (!empty($value['kepek'])) {
                    $photo_names = json_decode($value['kepek']);
                    //$photo_name = array_shift($photo_names);
                    //unset($photo_names);      
                    $url_helper = DI::get('url_helper');
                    $temp['kepek'] = '<img src="' . $url_helper->thumbPath(Config::get('ingatlan_photo.upload_path') . $photo_names[0]) . '" alt="" />';
                } else {
                    $temp['kepek'] = '<img src="' . ADMIN_ASSETS . 'img/placeholder_80x60.jpg" alt="" />';
                }


            // 5. Referens oszlop    
                $temp['ref_name'] = $value['first_name'] . '<br>' . $value['last_name'];
                
            // 6. Típus oszlop    
                $temp['tipus'] = ($value['tipus'] == 1) ? 'eladó' : 'kiadó';

            // 7. Kategória oszlop    
                $temp['kategoria'] = $value['kat_nev_hu'];
                
            // 8. Város oszlop    
                $kerulet = !empty($value['kerulet']) ? '<br>' . $value['kerulet'] . '. kerület' : '';
                $temp['varos'] = $value['city_name'] . $kerulet . '<br>' . $value['utca'];

            // 9. Alapterület oszlop    
                $temp['alapterulet'] = $value['alapterulet'];

        //$temp['szobaszam'] = $value['szobaszam'];

            // 10. Megtekintés oszlop    
                $temp['megtekintes'] = $value['megtekintes'];

            // 11. Ár oszlop    
                $temp['ar'] = (!empty($value['ar_elado'])) ? $num_helper->niceNumber($value['ar_elado']) : $num_helper->niceNumber($value['ar_kiado']);

            // 12. Status oszlop    
                $temp['status'] = ($value['status'] == 1) ? '<span class="label label-sm label-success">Aktív</span>' : '<span class="label label-sm label-danger">Inaktív</span>';


            //----- 13. MENU HTML -----------------

                $temp['menu'] = '           
                  <div class="actions">
                    <div class="btn-group">';

                $temp['menu'] .= '<a class="btn btn-sm grey-steel" title="Műveletek" href="#" data-toggle="dropdown">
                    <i class="fa fa-cogs"></i>
                      </a>          
                      <ul class="dropdown-menu pull-right">
                    <li><a href="' . $this->request->get_uri('site_url') . 'property/details/' . $value['id'] . '"><i class="fa fa-eye"></i> Részletek</a></li>';

                // update
                // if (Auth::hasAccess('property.update')) {}    
                    $temp['menu'] .= '<li><a href="' . $this->request->get_uri('site_url') . 'property/update/' . $value['id'] . '"><i class="fa fa-pencil"></i> Szerkeszt</a></li>';

                // törlés
                if (Auth::hasAccess('property.delete')) {
                    $temp['menu'] .= '<li><a href="javascript:;" class="delete_item" data-id="' . $value['id'] . '"> <i class="fa fa-trash"></i> Töröl</a></li>';
                    //$temp['menu'] .= '<li class="disabled-link"><a href="javascript:;" title="Nincs jogosultsága törölni" class="disable-target"><i class="fa fa-trash"></i> Töröl</a></li>';
                }

                // kiemelés
                if (Auth::hasAccess('property.kiemeles')) {
                    if ($value['kiemeles'] == 0) {
                        $temp['menu'] .= '<li><a data-id="' . $value['id'] . '" href="javascript:;" class="change_kiemeles" data-action="add_kiemeles"><i class="fa fa-plus-circle"></i> Kiemelés</a></li>';
                    }
                    if ($value['kiemeles'] > 0) {
                        $temp['menu'] .= '<li><a data-id="' . $value['id'] . '" href="javascript:;" class="change_kiemeles" data-action="delete_kiemeles"><i class="fa fa-minus-circle"></i> Kiemelés törlése</a></li>';
                    }
                }

                // status
                if (Auth::hasAccess('property.change_status')) {
                    if ($value['status'] == 0) {
                        $temp['menu'] .= '<li><a data-id="' . $value['id'] . '" href="javascript:;" class="change_status" data-action="make_active"><i class="fa fa-check"></i> Aktivál</a></li>';
                    } else {
                        $temp['menu'] .= '<li><a data-id="' . $value['id'] . '" href="javascript:;" class="change_status" data-action="make_inactive"><i class="fa fa-ban"></i> Blokkol</a></li>';
                    }
                }
                
                $temp['menu'] .= '</ul></div></div>';


                // adatok berakása a data tömbbe
                $data[] = $temp;
            }

            // adatok a javascriptnek        
            $json_data = array(
                "draw" => $display_draw,
                "recordsTotal" => $total_records,
                "recordsFiltered" => $filtered_records,
                "data" => $data
                    //"customActionStatus" => 'OK',
                    //"customActionMessage" => $custom_action_message
            );

            if (isset($request_data['customActionType']) && isset($request_data['customActionName'])) {
                $json_data["customActionStatus"] = 'OK';
                $json_data["customActionMessage"] = $custom_action_message;
            }


            // adatok visszaküldése a javascriptnek
            $this->response->json($json_data);
        } else {
            $this->response->redirect('admin/error');
        }
    }

    /**
     * 	Új lakás hozzáadása
     */
    public function insert()
    {
        // adatok bevitele a view objektumba
        $data['title'] = 'Új lakás oldal';
        $data['description'] = 'Új lakás description';
        // Megyék adatainak lekérdezése az option listához
        $data['county_list'] = $this->property_model->countyList();
        // kerületek nevének és id-jének lekérdezése az option listához
        $data['district_list'] = $this->property_model->list_query('district_list');
        
        // admin user-ek listája
        $data['referens_list'] = $this->property_model->usersList();
        
        // ingatlan kategóriák lekérdezése
        $data['ingatlan_kat_list'] = $this->property_model->list_query('ingatlan_kategoria');
        $data['ingatlan_allapot_list'] = $this->property_model->list_query('ingatlan_allapot');
        $data['ingatlan_futes_list'] = $this->property_model->list_query('ingatlan_futes');
        $data['ingatlan_parkolas_list'] = $this->property_model->list_query('ingatlan_parkolas');
        $data['ingatlan_kilatas_list'] = $this->property_model->list_query('ingatlan_kilatas');
        $data['ingatlan_energetika_list'] = $this->property_model->list_query('ingatlan_energetika');
        $data['ingatlan_kert_list'] = $this->property_model->list_query('ingatlan_kert');
        $data['ingatlan_szerkezet_list'] = $this->property_model->list_query('ingatlan_szerkezet');
        $data['ingatlan_emelet_list'] = $this->property_model->list_query('ingatlan_emelet');
        $data['ingatlan_szoba_elrendezes_list'] = $this->property_model->list_query('ingatlan_szoba_elrendezes');
        $data['ingatlan_haz_allapot_belul_list'] = $this->property_model->list_query('ingatlan_haz_allapot_belul');
        $data['ingatlan_haz_allapot_kivul_list'] = $this->property_model->list_query('ingatlan_haz_allapot_kivul');
        $data['ingatlan_furdo_wc_list'] = $this->property_model->list_query('ingatlan_furdo_wc');
        $data['ingatlan_fenyviszony_list'] = $this->property_model->list_query('ingatlan_fenyviszony');

        $view = new View();
//$view->debug(true);
        $view->add_links(array('jquery-ui', 'select2', 'validation', 'ckeditor', 'kartik-bootstrap-fileinput', 'google-maps', 'property_insert', 'autocomplete'));
        $view->render('property/tpl_property_insert', $data);
    }

    /**
     * 	Lakás adatainak módosítása oldal	
     */
    public function update($id)
    {
        // $id = (int) $this->request->get_params('id');
        $id = (int) $id;
        
        $data['title'] = 'Ingatlan adatok módosítás oldal';
        $data['description'] = 'Ingatlan adatok módosítás description';
        // a lakás összes adatának lekérdezése az ingatlanok táblából
        $data['content'] = $this->property_model->getPropertyAlldata($id);

        // ha nem superadmin, és az ingatlan ref_id-je nem egyezik a bejelentkezett user id-jével 
        if ( !Auth::isSuperadmin() && ($data['content']['ref_id'] != Auth::getUser('id')) ) {
            Message::set('error', 'Nincs engedélye módosítani az ingatlan adatait!');
            $this->response->redirectBack('admin/property');
        }

        // Megyék adatainak lekérdezése az option listához
        $data['county_list'] = $this->property_model->countyList();
        // kerületek nevének és id-jének lekérdezése az option listához
        $data['district_list'] = $this->property_model->list_query('district_list');
        // admin user-ek listája
        $data['referens_list'] = $this->property_model->usersList();
        // ingatlan kategóriák lekérdezése
        $data['ingatlan_kat_list'] = $this->property_model->list_query('ingatlan_kategoria');
        $data['ingatlan_allapot_list'] = $this->property_model->list_query('ingatlan_allapot');
        $data['ingatlan_futes_list'] = $this->property_model->list_query('ingatlan_futes');
        $data['ingatlan_parkolas_list'] = $this->property_model->list_query('ingatlan_parkolas');
        $data['ingatlan_kilatas_list'] = $this->property_model->list_query('ingatlan_kilatas');
        $data['ingatlan_energetika_list'] = $this->property_model->list_query('ingatlan_energetika');
        $data['ingatlan_kert_list'] = $this->property_model->list_query('ingatlan_kert');
        $data['ingatlan_szerkezet_list'] = $this->property_model->list_query('ingatlan_szerkezet');
        $data['ingatlan_emelet_list'] = $this->property_model->list_query('ingatlan_emelet');
        $data['ingatlan_szoba_elrendezes_list'] = $this->property_model->list_query('ingatlan_szoba_elrendezes');
        $data['ingatlan_haz_allapot_belul_list'] = $this->property_model->list_query('ingatlan_haz_allapot_belul');
        $data['ingatlan_haz_allapot_kivul_list'] = $this->property_model->list_query('ingatlan_haz_allapot_kivul');
        $data['ingatlan_furdo_wc_list'] = $this->property_model->list_query('ingatlan_furdo_wc');
        $data['ingatlan_fenyviszony_list'] = $this->property_model->list_query('ingatlan_fenyviszony');

        $view = new View();
        // helperek beállítása
        $view->setHelper(array('url_helper'));
//$view->debug(true);
        $view->add_links(array('jquery-ui', 'select2', 'validation', 'ckeditor', 'kartik-bootstrap-fileinput', 'google-maps', 'property_update', 'autocomplete'));
        $view->render('property/tpl_property_update', $data);
        
    }

    /**
     * 	(AJAX) Lakás részletek (modal-ba)
     */
    public function view_property_ajax($id)
    {
        if ($this->request->is_ajax()) {
            // $id = (int) $this->request->get_params('id');
            $id = (int) id;
            $data['content'] = $this->property_model->getPropertyDetails($id);

            //$this->view->debug(true);			
            //$data['location'] = $data['content']['county_name'] . $data['content']['city_name'] . $data['content']['district_name'];
            $view = new View();
            $view->render('property/tpl_property_view_modal', $data);
        } else {
            $this->response->redirect('admin/error');
        }
    }

    /* ------- AJAX hívások --------------------------------------- */

    /**
     *  (AJAX) Lakás törlése
     */
    public function delete()
    {
        if ($this->request->is_ajax()) {
            if (Auth::hasAccess('property.delete')) {

                // a POST-ban kapott item_id tömb 
                $id_data = $this->request->get_post('item_id');

                // rekord törlése
                $result = $this->_delete($id_data);

                if ($result !== false) {
                    EventManager::trigger('delete_property', array('delete', $result . ' ingatlan törlése'));

                    $this->response->json(array(
                        "status" => 'success',
                        "message_success" => $result . 'ingatlan törölve.'
                    ));
                } else {
                    // ha a törlési sql parancsban hiba van
                    $this->response->json(array(
                        "status" => 'error',
                        "message" => 'Adatbázis lekérdezési hiba!'
                    ));
                }
            } else {
                $this->response->json(array(
                    'status' => 'error',
                    'message' => 'Nincs engedélye a művelet végrehajtásához!'
                ));
            }
        } else {
            $this->response->redirect('admin/error');
        }
    }

    /**
     * Rekord(ok) törlése
     * @param array $id_data
     * @return integer || false
     */
    private function _delete($id_data)
    {
        // a sikeres törlések számát tárolja
        $success_counter = 0;
        // a sikertelen törlések számát tárolja
        $fail_counter = 0;

        // tömbösítjük, ha nem tömb az $id_data
        $id_data = (!is_array($id_data)) ? (array) $id_data : $id_data;

        foreach ($id_data as $id) {

            $id = (int) $id;
            // filenevek lekérdezése
            $files_arr = $this->property_model->getFilenames($id);
            $photos_arr = $files_arr['kepek'];
            $docs_arr = $files_arr['docs'];

            //lakás törlése 
            $result = $this->property_model->delete($id);

            // ha a törlési sql parancsban nincs hiba
            if ($result !== false) {
                if ($result > 0) {
                    //sikeres törlés
                    $file_helper = DI::get('file_helper');

                    //ha az adatbázisban léteznek képek
                    if (!empty($photos_arr)) {

                        $url_helper = DI::get('url_helper');
                        $photo_path = Config::get('ingatlan_photo.upload_path');
                        //képek törlése
                        foreach ($photos_arr as $filename) {
                            $normal_path = $photo_path . $filename;
                            $thumb_path = $url_helper->thumbPath($photo_path . $filename);
                            $small_path = $url_helper->thumbPath($photo_path . $filename, false, 'small');
                            // képek törlése
                            $file_helper->delete(array($normal_path, $thumb_path, $small_path));
                        }
                    }
                    // ha az adatbázisban léteznek dokumentumok
                    if (!empty($docs_arr)) {
                        $docs_path = Config::get('ingatlan_doc.upload_path');
                        //dokumentumok törlése
                        foreach ($docs_arr as $filename) {
                            $file_helper->delete($docs_path . $filename);
                        }
                    }

                    // sikeres törlés
                    $success_counter += $result;
                } else {
                    //sikertelen törlés (0 sor lett törölve)
                    $fail_counter++;
                }
            } else {
                // ha a törlési sql parancsban hiba van
                return false;
            }
        } // end foreach

        return $success_counter + $fail_counter;
    }

    /**
     *  (AJAX) Lakás nem végleges törlése
     */
    public function softDelete()
    {
        if ($this->request->is_ajax()) {
            if (Auth::hasAccess('property.delete')) {

                $id = $this->request->get_post('item_id');

                $result = $this->property_model->update($id, array('deleted' => 1));

                if ($result !== false) {
                    $this->response->json(array(
                        "status" => 'success',
                        "message_success" => 'Ingatlan törölve.'
                    ));
                } else {
                    $this->response->json(array(
                        "status" => 'error',
                        "message" => 'Adatbázis lekérdezési hiba!'
                    ));
                }
            } else {
                $this->response->json(array(
                    'status' => 'error',
                    'message' => 'Nincs engedélye a művelet végrehajtásához!'
                ));
            }
        } else {
            $this->response->redirect('admin/error');
        }
    }

    /**
     *  (AJAX) Új lakás adatok bevitele adatbázisba,
     *  Lakás adatok módosítása az adatbázisban
     */
    public function insert_update()
    {
        if ($this->request->is_ajax()) {
            
            if ($this->request->has_post()) {
                //megadja, hogy update, vagy insert lesz
                $update_marker = false;
                //megadja, hogy insert utáni update, normál update lesz (modositas_datum megadása miatt)
                $update_real = false;

                $data = $this->request->get_post(null, 'strip_danger_tags');

                //echo json_encode($data);
                // megvizsgáljuk, hogy a post adatok között van-e update_id
                // update-nél a javasriptel hozzáadunk a post adatokhoz egy update_id elemet
                if (isset($data['update_id'])) {
                    //beállítjuk, hogy update-elni kell az adatbázist
                    $update_marker = true;
                    $id = (int) $data['update_id'];
                    unset($data['update_id']);

                    //megvizsgáljuk, hogy adatbevitelkori update, vagy "rendes" update
                    // "rendes" update-nél a javasriptel hozzáadunk a post adatokhoz egy update_status elemet is
                    if (isset($data['update_status'])) {
                        $update_real = true;
                        unset($data['update_status']);
                    }
                }

                $error_messages = array();
                $error_counter = 0;

                // referens azonosítója
                if (isset($data['ref_id']) && $data['ref_id'] === '') {
                    $error_messages[] = Message::show('Nem adott meg referenst.');
                    $error_counter += 1;
                }
                //referencia szám
                if (empty($data['ref_num'])) {
                    $error_messages[] = Message::show('Nem adta meg az ingatlan referenciaszámát.');
                    $error_counter += 1;
                }
                //ingatlan kategória
                if (empty($data['tipus'])) {
                    $error_messages[] = Message::show('Nem adta meg az ingatlan ügylet típusát (eladó/kiadó).');
                    $error_counter += 1;
                }
                //ingatlan kategória
                if (empty($data['kategoria'])) {
                    $error_messages[] = Message::show('Nem adta meg az ingatlan fajtáját.');
                    $error_counter += 1;
                }
                //tulajdonos adatai
                /*
                if (empty($data['tulaj_nev'])) {
                    $error_messages[] = Message::show('A tulajdonos neve nem lehet üres.');
                    $error_counter += 1;
                }
                */
                // ár
                if (empty($data['ar_elado']) && empty($data['ar_kiado'])) {
                    $error_messages[] = Message::show('Nem adott meg árat.');
                    $error_counter += 1;
                }
                // cim adatok
                if (empty($data['megye'])) {
                    $error_messages[] = Message::show('Nem adta meg a cím adatoknál a megyét.');
                    $error_counter += 1;
                }

                if (empty($data['varos'])) {
                    $error_messages[] = Message::show('Nem adta meg a cím adatoknál a várost.');
                    $error_counter += 1;
                }

                if (empty($data['utca'])) {
                    $error_messages[] = Message::show('Nem adta meg a cím adatoknál az utcát.');
                    $error_counter += 1;
                }

                if ($error_counter == 0) {

                    // üres stringet tartalmazó elemek esetén az adatbázisba null érték kerül
                    /*
                      foreach ($data as $key => $value) {
                      if (isset($value) && $value == '') {
                      //unset($data[$key]);
                      $data[$key] = null;
                      }
                      }
                     */

                    // referenciaszám
                    $data['ref_num'] = (int)$data['ref_num'];

                    $data['ar_elado'] = ($data['tipus'] == 1) ? $data['ar_elado'] * 1000000 : null;
                    $data['ar_kiado'] = ($data['tipus'] == 2) ? $data['ar_kiado'] * 1000 : null;
                    $data['hazszam'] = (isset($data['hazszam'])) ? $data['hazszam'] : null;
                    $data['kerulet'] = (isset($data['kerulet'])) ? $data['kerulet'] : null;

                    // telek alapterület
                    if (isset($data['telek_alapterulet'])) {
                        $data['telek_alapterulet'] = ($data['telek_alapterulet'] !== '') ? (int)$data['telek_alapterulet'] : null;
                    }

                    // tájolás (szám kerül az adatbázisba: 0-7 ig)
                    $data['tajolas'] = ($data['tajolas'] !== '') ? $data['tajolas'] : null;
                    // emelet
                    $data['emelet'] = ($data['emelet'] !== '') ? $data['emelet'] : null;
                    // épület szintjei
                    if (isset($data['epulet_szintjei'])) {
                        $data['epulet_szintjei'] = ($data['epulet_szintjei'] !== '') ? $data['epulet_szintjei'] : null;
                    }

                    //geolocation
                    //$address = $iranyitoszam . ' ' . $varos . ' ' . $utca . ' ' . $hazszam . ' ' . $kerulet . ' kerulet';
                    $address = $data['iranyitoszam'] . ' ' . $data['varos'] . ' ' . $data['utca'] . ' ' . $data['hazszam'];
                    $loc = geocoder::getLocation($address);
                    if ($loc) {
                        $data['latitude'] = $loc['lat'];
                        $data['longitude'] = $loc['lng'];
                    } else {
                        $data['latitude'] = 0;
                        $data['longitude'] = 0;
                    }

                    $data['utca_megjelenites'] = (isset($data['utca_megjelenites'])) ? 1 : 0;
                    $data['hazszam_megjelenites'] = (isset($data['hazszam_megjelenites'])) ? 1 : 0;
                    $data['terkep'] = (isset($data['terkep'])) ? 1 : 0;
                    

                    $data['szobaszam'] = (isset($data['szobaszam'])) ? (int)$data['szobaszam'] : null;
                    $data['felszobaszam'] = (isset($data['felszobaszam'])) ? (int)$data['felszobaszam'] : null;
                    $data['kozos_koltseg'] = (isset($data['kozos_koltseg'])) ? (int)$data['kozos_koltseg'] : null;
                    $data['rezsi'] = (isset($data['rezsi'])) ? (int)$data['rezsi'] : null;
                    $data['emelet'] = (isset($data['emelet'])) ? $data['emelet'] : null;
                    $data['epulet_szintjei'] = (isset($data['epulet_szintjei'])) ? (int)$data['epulet_szintjei'] : null;

                // jellemzők
                    $data['tetoter'] = (isset($data['tetoter'])) ? 1 : 0;
                    $data['erkely'] = (isset($data['erkely'])) ? 1 : 0;
                    //erkely terulet
                    if (isset($data['erkely_terulet'])) {
                        $data['erkely_terulet'] = ($data['erkely_terulet'] !== '') ? (int)$data['erkely_terulet'] : null;
                    }
                    $data['terasz'] = (isset($data['terasz'])) ? 1 : 0;
                    //terasz terulet
                    if (isset($data['terasz_terulet'])) {
                        $data['terasz_terulet'] = ($data['terasz_terulet'] !== '') ? (int)$data['terasz_terulet'] : null;
                    }

                    // datatables jellemzők select menüből
                    $jellemzok1 = array('lift', 'allapot', 'haz_allapot_kivul', 'haz_allapot_belul', 'furdo_wc', 'fenyviszony', 'futes', 'parkolas', 'kilatas', 'szerkezet', 'energetika', 'kert', 'szoba_elrendezes');
                    foreach ($jellemzok1 as $jellemzo) {
                        $data[$jellemzo] = ($data[$jellemzo] === '') ? null : (int)$data[$jellemzo];
                    }

                    // jellemzok checkbox
                    $jellemzok2 = array('butor', 'medence', 'szauna', 'jacuzzi', 'kandallo', 'riaszto', 'klima', 'ontozorendszer', 'automata_kapu', 'elektromos_redony', 'konditerem');
                    foreach ($jellemzok2 as $jellemzo) {
                        $data[$jellemzo] = (isset($data[$jellemzo])) ? 1 : 0;
                    }


                    if ($update_marker) {
                // UPDATE
                        // az update-nél ha superadmin módosít, akkor lesz ref_id input elem
                        if (isset($data['ref_id'])) {
                            $data['ref_id'] = (int)$data['ref_id'];
                        }

                        if ($update_real) {
                            // a módosítás dátum a "rendes" módosításkor fog bekerülni az adatbázisba 
                            $data['modositas_datum'] = time();
                            // ha van új ár és nagyobb mint 0, akkor a jelenlegi ár lesz a régi ár, az új ár pedig az aktuális ár
                            if (!empty($data['ar_elado_uj']) && $data['ar_elado_uj'] > 0) {
                                $regi_ar = $data['ar_elado'];
                                $data['ar_elado'] = $data['ar_elado_uj'];
                                $data['ar_elado_regi'] = $regi_ar;

                                if (isset($data['email_kuldes_arvaltozasrol'])) {
                                    // event managerrel e-mailt küldeni azoknak, akik feliratoztak az illető ingatlan árának figyelésére
                                    // email_kuldes_arvaltozasrol elem eltávolítása a tömbból, mivel nincs ilyen oszlop az ingatlanok táblában
                                    unset($data['email_kuldes_arvaltozasrol']);
                                }
                            }
                            // ar_elado_uj elem eltávolítása a tömbból, mivel nincs ilyen oszlop az ingatlanok táblában
                            unset($data['ar_elado_uj']);
                        }

                        // adatok adatbázisba írása
                        $result = $this->property_model->update($id, $data);

                        if ($result === 0 || $result === 1) {

                            if ($update_real) {
                                Message::set('success', 'A módosítások sikeresen elmentve!');
                                EventManager::trigger('update_property', array('update', '#' . $id . ' azonosítójú ingatlan módosítása'));
                            } else {
                                Message::set('success', 'Ingatlan adatai elmentve.');
                            }

                            $this->response->json(array(
                                "status" => 'success',
                                "message" => ''
                            ));

                        } else {
                            Message::set('error', 'A módosítások mentése nem sikerült, próbálja újra!');

                            $this->response->json(array(
                                "status" => 'error',
                                "message" => ''
                            ));
                        }

                    }
                // INSERT
                    else {
                        // referens
                        $data['ref_id'] = (int)$data['ref_id'];

                        $data['hozzaadas_datum'] = time();

                        // $this->query->debug(true);
                        // a last insert id-t adja vissza
                        $last_id = $this->property_model->insert($data);
                            if ($last_id === false) {
                                $this->response->json(array(
                                    "status" => 'error',
                                    "error_messages" => array('Hiba történt az adatok adatbázisba írásakor!')
                                ));
                            }

                        EventManager::trigger('insert_property', array('insert', '#' . $last_id . ' azonosítójú ingatlan létrehozása'));

                        $this->response->json(array(
                            "status" => 'success',
                            "last_insert_id" => $last_id,
                            "message" => 'Az adatok bekerültek az adatbázisba.'
                        ));
                    }
                } else {
                    // visszaadja a hibaüzeneteket tartalmazó tömböt
                    $this->response->json(array(
                        "status" => 'error',
                        "error_messages" => $error_messages
                    ));
                }
            }
        } else {
            $this->response->redirect('admin/error');
        }
    }

    /**
     * 	(AJAX) File listát jeleníti (frissíti) meg feltöltéskor (képek)
     */
    public function show_file_list() {
        if ($this->request->is_ajax()) {
            // db rekord id-je
            $id = $this->request->get_post('id', 'integer');
            // típus: kepek vagy docs
            $type = $this->request->get_post('type');

            //file adatok lekérdezése (kepek és docs tömbelemekbe kerülnek a megfelelő képek illetve dokumentumok nevei)
            $files_arr = $this->property_model->getFilenames($id);

            // lista HTML generálása
            $html = '';
            $counter = 0;

            $url_helper = DI::get('url_helper');


            if ($type == 'kepek') {
                $file_location = Config::get('ingatlan_photo.upload_path');

                foreach ($files_arr['kepek'] as $key => $value) {
                    $counter = $key + 1;
                    $file_path = $url_helper->thumbPath($file_location . $value);
                    $html .= '<li id="elem_' . $counter . '" class="ui-state-default"><img class="img-thumbnail" src="' . $file_path . '" alt="" /><button style="position:absolute; top:20px; right:20px; z-index:2;" class="btn btn-xs btn-default" type="button" title="Kép törlése"><i class="glyphicon glyphicon-trash"></i></button></li>' . "\n\r";
                }
            }
            if ($type == 'docs') {
                $file_location = Config::get('ingatlan_doc.upload_path');

                foreach ($files_arr['docs'] as $key => $value) {
                    $counter = $key + 1;
                    $file_path = $url_helper->thumbPath($file_location . $value);
                    $html .= '<li id="doc_' . $counter . '" class="list-group-item"><i class="glyphicon glyphicon-file"> </i>&nbsp;' . $value . '<button type="button" class="btn btn-xs btn-default" style="position: absolute; top:8px; right:8px;"><i class="glyphicon glyphicon-trash"></i></button></li>' . "\n\r";
                }
            }

            // lista visszaküldése a javascriptnek
            echo $html;
        } else {
            $this->response->redirect('admin/error');
        }
    }

    /**
     * 	Képek sorbarendezése (AJAX)
     */
    public function photo_sort()
    {
        if ($this->request->is_ajax()) {

            $id = $this->request->get_post('id', 'integer');
            // json string: elem_1[]=3,elem_2[]=1,elem_3[]=2
            $sort_json = $this->request->get_post('sort');

            // képek adatainak lekérdezése
            $photo_arr = $this->property_model->getFilenames($id, 'kepek');
            // sorrendet tartalamzó string átalakítása tömb formára
            parse_str($sort_json, $key_array);
            // új sorrendet tartalmazó tömb ($result_arr) létrehozása 
            $result_arr = array();
            //a $key_array tartalama pl.: 'elem' => array(1,5,3,4,2)
            //a $sort_array tartalma pl.: array(1,5,3,4,2)
            foreach ($key_array as $key => $sort_array) {
                foreach ($sort_array as $index => $value) {
                    $new_index = $value - 1;
                    $result_arr[] = $photo_arr[$new_index];
                }
            }

            $data['kepek'] = json_encode($result_arr);

            // beírjuk az adatbázisba
            $result = $this->property_model->update($id, $data);

            if ($result === 1) {
                $this->response->json(array('status' => 'success'));
            } else {
                $this->response->json(array('status' => 'error'));
            }
        } else {
            $this->response->redirect('admin/error');
        }
    }

    /**
     * 	(AJAX) Kép vagy dokumentum törlése a feltöltöttek listából
     */
    public function file_delete()
    {
        if ($this->request->is_ajax()) {

            $id = $this->request->get_post('id', 'integer');
            // a kapott szorszámból kivonunk egyet, mert a képeket tartalamzó tömbben 0-tól indul a számozás
            $sort_id = ($this->request->get_post('sort_id', 'integer')) - 1;
            // fájl típusa (kép vagy dokumentum)
            $type = $this->request->get_post('type');

            // fájlok nevét tartalmazó tömb
            $file_name_arr = $this->property_model->getFilenames($id, $type);
            // törlendő file neve
            $filename = $file_name_arr[$sort_id];
            // töröljük a tömbből az elemet
            unset($file_name_arr[$sort_id]);

            // ha az utolsó file-t is töröljük, akkor null értéket kell írnunk az adatbázisba
            if (empty($file_name_arr)) {
                $data[$type] = NULL;
            } else {
                // ha nem üres a tömb, akkor újraindexeljük
                $file_name_arr = array_values($file_name_arr);
                // új fájl lista átakaítása json formátumra 
                $new_file_list = json_encode($file_name_arr);
                // új flie lista az adatbázisba
                $data[$type] = $new_file_list;
            }

            // módosított file lista beírása az adatbázisba
            $result = $this->property_model->update($id, $data);

            if ($result) {
                // kép (és thumb) törlése
                $file_helper = DI::get('file_helper');

                if ($type == 'kepek') {
                    $url_helper = DI::get('url_helper');
                    $photo_path = Config::get('ingatlan_photo.upload_path') . $filename;
                    $thumb_path = $url_helper->thumbPath($photo_path);
                    $small_path = $url_helper->thumbPath($photo_path, false, 'small');
                    // képek törlése
                    $file_helper->delete(array($photo_path, $thumb_path, $small_path));
                }
                // dokumentum file törlése
                if ($type == 'docs') {
                    $docs_path = Config::get('ingatlan_doc.upload_path') . $filename;
                    //dokumentumok törlése
                    $file_helper->delete($docs_path);
                }

                // válasz küldése
                $message = Message::show('A file törölve!');
                $this->response->json(array(
                    'status' => 'success',
                    'message' => $message
                ));
            } else {
                $this->response->json(array('status' => 'error'));
            }
        } else {
            $this->response->redirect('admin/error');
        }
    }

    /**
     * 	(AJAX) File feltöltés (képek)
     */
    public function file_upload_ajax()
    {
        if ($this->request->is_ajax()) {
            //uploadExtraData beállítás küldi
            $id = $this->request->get_post('id', 'integer');

            // new_file elem a $_FILES tömbből     
            $uploaded_files = $this->request->getFiles('new_file');
            // feltöltés helye
            $upload_path = Config::get('ingatlan_photo.upload_path');
            // a feltöltött képek neveit fogja tárolni
            $new_filenames = array();

            foreach ($uploaded_files as $file_arr) {

                $imageobject = new Uploader($file_arr);

                $newfilename = $id . '_' . md5(uniqid());
                $width = Config::get('ingatlan_photo.width', 800);
                $height = Config::get('ingatlan_photo.height', 600);

                $imageobject->allowed(array('image/*'));
                $imageobject->cropToSize($width, $height);
                $imageobject->save($upload_path, $newfilename);

                // kép neve bekerül a $new_filenames tömbbe
                $new_filenames[] = $imageobject->getDest('filename');

                if ($imageobject->checkError()) {

                    $this->response->json(array(
                        'status' => 'error',
                        'message' => $imageobject->getError()
                    ));
                } else {
                    // small kép feltöltése
                    $new_small_filename = $newfilename . '_small';
                    $small_width = Config::get('ingatlan_photo.small_width', 400);
                    $small_height = Config::get('ingatlan_photo.small_height', 300);
                    $imageobject->cropToSize($small_width, $small_height);
                    $imageobject->save($upload_path, $new_small_filename);

                    // thumb kép feltöltése
                    $new_thumb_filename = $newfilename . '_thumb';
                    $thumb_width = Config::get('ingatlan_photo.thumb_width', 80);
                    $thumb_height = Config::get('ingatlan_photo.thumb_height', 60);
                    $imageobject->cropToSize($thumb_width, $thumb_height);
                    $imageobject->save($upload_path, $new_thumb_filename);
                }
            }

            // temp file-ok törlése
            $imageobject->cleanTemp();


            // kép adatok adatbázisba írása    
            // lekérdezzük a képek mező értékét
            $old_filenames = $this->property_model->getFilenames($id, 'kepek');
            // ha már tartalmaz adatot a mező összeolvasztjuk az újakkal
            if (!empty($old_filenames)) {
                $new_filenames = array_merge($old_filenames, $new_filenames);
            }

            $data['kepek_szama'] = count($new_filenames);
            // visszaalakítjuk json-ra
            $data['kepek'] = json_encode($new_filenames);
            // beírjuk az adatbázisba
            $result = $this->property_model->update($id, $data);

            if ($result !== false) {
                $this->response->json(array(
                    'status' => 'success',
                    'message' => 'Kép feltöltés sikeres.'
                ));
            } else {
                $this->response->json(array(
                    'status' => 'success',
                    'message' => 'Ismeretlen hiba.'
                ));
            }
        } else {
            $this->response->redirect('admin/error');
        }
    }

    /**
     * 	(AJAX) Dokumentum feltöltés
     */
    public function doc_upload_ajax()
    {
        if ($this->request->is_ajax()) {
            //uploadExtraData beállítás küldi
            $id = $this->request->get_post('id', 'integer');

            $uploaded_files = $this->request->getFiles('new_doc');

            // file feltöltése
            $upload_path = Config::get('ingatlan_doc.upload_path');
            $new_filenames = array();

            foreach ($uploaded_files as $file_arr) {

                $fileobject = new Uploader($file_arr);

                // új filenév
                $newfilename = $id . '_' . $fileobject->getSource('body') . '_' . uniqid();

                $fileobject->allowed(array('application/*', 'text/*', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png'));
                $fileobject->save($upload_path, $newfilename);

                $new_filenames[] = $fileobject->getDest('filename');

                if ($fileobject->checkError()) {
                    $this->response->json(array(
                        'status' => 'error',
                        'message' => $fileobject->getError()
                    ));
                }
            }

            $fileobject->cleanTemp();


            // feltöltött file nevek frissítése az adatbázisban 
            // lekérdezzük a docs mezőből a file-ok neveit
            $old_filenames = $this->property_model->getFilenames($id, 'docs');
            // ha már tartalmaz adatot a mező
            if (!empty($old_filenames)) {
                $new_filenames = array_merge($old_filenames, $new_filenames);
            }

            // visszaalakítjuk json-ra
            $data['docs'] = json_encode($new_filenames);
            // beírjuk az adatbázisba
            $result = $this->property_model->update($id, $data);

            if ($result !== false) {
                $this->response->json(array('status' => 'success', 'message' => 'File feltöltése sikeres.'));
            } else {
                $this->response->json(array('status' => 'error', 'message' => 'Ismeretlen hiba!'));
            }
        } else {
            $this->response->redirect('admin/error');
        }
    }

    /**
     *  Az ingatlanok tábla status, vagy kiemeles mezőjének értékét módosítja
     *
     *  @param  integer || array        $id_arr 
     *  @param  string                  $column (status vagy kiemeles)    
     *  @param  integer                 $data (0 vagy 1)    
     *  @return integer || false
     */
    private function _status_kiemeles_update($id_arr, $column, $data) {
        $success_counter = 0;

        $id_arr = (!is_array($id_arr)) ? (array) $id_arr : $id_arr;

        foreach ($id_arr as $id) {

            $result = $this->property_model->update($id, array($column => $data));

            if ($result !== false) {
                // ha az update sql parancsban nincs hiba
                $success_counter += $result;
            } else {
                // visszatér ha az update sql parancsban hiba van
                return false;
            }
        }
        // visszatér az update-ek számával
        return $success_counter;
    }

    /**
     * (AJAX) Az ingatlanok táblában módosítja az status mező értékét
     *  NEM CSOPORTOS MŰVELET ESETÉN!!
     *
     * @return void
     */
    public function change_status() {
        if ($this->request->is_ajax()) {

            if ($this->request->has_post('action') && $this->request->has_post('id')) {

                $id = $this->request->get_post('id', 'integer');
                $action = $this->request->get_post('action');

                if ($action == 'make_active') {
                    $result = $this->_status_kiemeles_update($id, 'status', 1);
                    if ($result !== false) {
                        $this->response->json(array(
                            "status" => 'success',
                            "message" => 'Az elem aktiválása megtörtént!'
                        ));
                    } else {
                        $this->response->json(array(
                            "status" => 'error',
                            "message" => 'Adatbázis lekérdezési hiba!'
                        ));
                    }
                }
                if ($action == 'make_inactive') {
                    $result = $this->_status_kiemeles_update($id, 'status', 0);
                    if ($result !== false) {
                        $this->response->json(array(
                            "status" => 'success',
                            "message" => 'Az elem blokkolása megtörtént!'
                        ));
                    } else {
                        $this->response->json(array(
                            "status" => 'error',
                            "message" => 'Adatbázis lekérdezési hiba!'
                        ));
                    }
                }
            } else {
                $this->response->json(array(
                    "status" => 'error',
                    "message" => 'Ismeretlen hiba!'
                ));
            }
        } else {
            $this->response->redirect('admin/error');
        }
    }

    /**
     * (AJAX) Az ingatlanok táblában módosítja az kiemeles mező értékét
     *
     * @return void
     */
    public function change_kiemeles() {
        if ($this->request->is_ajax()) {
            if ($this->request->has_post('action') && $this->request->has_post('id')) {

                $id = $this->request->get_post('id', 'integer');

                if ($this->request->get_post('action') == 'delete_kiemeles') {
                    $data = 0;
                }
                if ($this->request->get_post('action') == 'add_kiemeles') {
                    $data = 1;
                }

                $result = $this->_status_kiemeles_update($id, 'kiemeles', $data);

                if ($result !== false) {
                    $this->response->json(array("status" => 'success'));
                } else {
                    $this->response->json(array("status" => 'error'));
                }
            }
        } else {
            $this->response->redirect('admin/error');
        }
    }

    /**
     * 	(AJAX) - Visszadja a kiválasztott kerület városrészeinek option listáját  
     */
    public function kerulet_utca_list() {
        if ($this->request->is_ajax()) {
            if ($this->request->has_post('district_id')) {
                $id = $this->request->get_post('district_id', 'integer');
                $result = $this->property_model->streetList($id);

                $string = '<option value="">Válasszon</option>' . "\r\n";
                foreach ($result as $value) {
                    //$string .= '<option data-zipcode="' . $value['zip_code'] . '" value="' . $value['street_id'] . '">' . $value['street_name'] . ' &nbsp;(' . $value['zip_code'] . ')</option>' . "\r\n";
                    $string .= '<option value="' . $value['street_id'] . '-' . $value['zip_code'] . '">' . $value['street_name'] . ' (' . $value['zip_code'] . ')</option>' . "\r\n";
                }
                //válasz a javascriptnek (option lista)
                echo $string;
            }
        } else {
            $this->response->redirect('admin/error');
        }
    }

    /**
     * 	(AJAX) - Visszadja a kiválasztott megye városainak option listáját  
     */
    public function county_city_list() {
        if ($this->request->is_ajax()) {
            if ($this->request->has_post('county_id')) {
                $id = $this->request->get_post('county_id', 'integer');
                if ($id == 5) {
                    $string = '<option value="88">Budapest</option>' . "\r\n";
                } else {
                    $result = $this->property_model->cityList($id);

                    $string = '';
                    foreach ($result as $value) {
                        $string .= '<option value="' . $value['city_id'] . '">' . $value['city_name'] . '</option>' . "\r\n";
                    }
                }
                //válasz a javascriptnek (option lista)
                echo $string;
            }
        } else {
            $this->response->redirect('admin/error');
        }
    }

    /**
     * 	utca keresés autocomplete 
     */
    public function street_list()
    {
        if ($this->request->is_ajax()) {
            $text = $this->request->get_query('query');
            if ($text) {
                $result = $this->property_model->streetSuggestions($text);
                $this->response->json(array('suggestions' => $result));
            }
        }
    }

    /**
     * File letöltése
     */
    public function download() {
        $file = $this->request->get_params('file');
        $file_path = Config::get('ingatlan_doc.upload_path') . $file;
        $file_helper = DI::get('file_helper');
        $file_helper->outputFile($file_path, $file);
        exit;
    }

}

?>