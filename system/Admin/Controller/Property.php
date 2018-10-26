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
//use System\Libs\Geocoder;
use System\Libs\Uploader;
use System\Libs\Emailer;
use System\Libs\Language as Lang;

class Property extends AdminController {

    function __construct() {
        parent::__construct();
        $this->loadModel('property_model');
    }

    /**
     * Ingatlanok listája
     */
    public function index() {
        Auth::hasAccess('property.index', $this->request->get_httpreferer());

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

        $view = new View();
        $view->add_links(array('datatable', 'select2', 'bootbox', 'vframework', 'property_list'));
// $view->debug(true);
        $view->render('property/tpl_property_list', $data);
    }

    /**
     * Ingatlan részletek
     */
    public function details($id) {
        // $id = (int) $this->request->get_params('id');
        $id = (int) $id;


        $data['title'] = 'Ingatlan részletek oldal';
        $data['description'] = 'Ingatlan részletek oldal description';
        $data['property_data'] = $this->property_model->getPropertyDetails($id);

        // készíítünk egy a létező extrák db nevét tartalamzó tömb elemet
        $data['features'] = array();
        $features_temp = Config::get('extra');
        foreach ($data['property_data'] as $key => $value) {
            if (in_array($key, $features_temp) && $value == 1) {
                $data['features'][] = $key;
            }
        }
        if (!empty($data['features'])) {
            // az extrák listájához az elemek nevét a translation táblából kapjuk meg
            Lang::init('hu', DI::get('connect'));
        }


        $data['photos'] = json_decode($data['property_data']['kepek']);
        $data['docs'] = json_decode($data['property_data']['docs']);

        $view = new View();
        //$view->debug(true);
        $view->setHelper(array('url_helper'));
        $view->add_links(array('fancybox', 'property_details'));
        $view->render('property/tpl_property_details', $data);
    }

    /**
     *  (AJAX) Az ingatlanok listáját adja vissza és kezeli a csoportos művelteket is
     */
    public function getPropertyList() {
        if ($this->request->is_ajax()) {

            $request_data = $this->request->get_post();

            // csoportos műveletek üzenetei
            $custom_action_message = '';
            // berakjuk session-be a request adatokat
            Session::set('property_filter', $request_data);

            // csoportos műveletek kezelése
            if (isset($request_data['customActionType']) && isset($request_data['customActionName'])) {

                // ha az ügynök neve és id-je a kiválasztott csoportos művelet (vagyis van a csoportművelet nevében @ karakter)
                if (strpos($request_data['customActionName'], '@') !== false) {
                    $agent_temp = explode('@', $request_data['customActionName']);
                    $agent_name = $agent_temp[0];
                    $agent_id = (int) $agent_temp[1];
                    unset($agent_temp);

                    $result = $this->property_model->changeAgent($request_data['id'], $agent_id);

                    if ($result !== false) {
                        $custom_action_status = 'OK';
                        $custom_action_message = $result . ' ingatlan áthelyezve ' . $agent_name . ' referenshez.';
                    } else {
                        $custom_action_status = 'ERROR';
                        $custom_action_message = Message::show('Adatbázis lekérdezési hiba!');
                    }
                } else {

                    switch ($request_data['customActionName']) {

                        case 'group_delete':

                            // ha nincs engedélye törölni
                            if (!Auth::hasAccess('property.softdelete')) {
                                $custom_action_status = 'ERROR';
                                $custom_action_message = Message::show('Nincs engedélye a művelet végrehajtásához!');
                            } else {
                                // az id-ket tartalmazó tömböt kapja paraméterként
                                $result = $this->_softdelete($request_data['id']);

                                if ($result !== false) {
                                    $custom_action_status = 'OK';
                                    $custom_action_message = $result . ' ingatlan áthelyezve a lomtárba.';
                                } else {
                                    $custom_action_status = 'ERROR';
                                    $custom_action_message = Message::show('Adatbázis lekérdezési hiba!');
                                }
                            }
                            break;

                        case 'group_make_active':

                            $result = $this->_status_kiemeles_update($request_data['id'], 'status', 1);

                            if ($result !== false) {
                                $custom_action_status = 'OK';
                                $custom_action_message = $result . ' rekord státusza aktívra változott.';
                            } else {
                                $custom_action_status = 'ERROR';
                                $custom_action_message = Message::show('Adatbázis lekérdezési hiba!');
                            }
                            break;

                        case 'group_make_inactive':

                            $result = $this->_status_kiemeles_update($request_data['id'], 'status', 0);

                            if ($result !== false) {
                                $custom_action_status = 'OK';
                                $custom_action_message = $result . ' rekord státusza inaktívra változott.';
                            } else {
                                $custom_action_status = 'ERROR';
                                $custom_action_message = Message::show('Adatbázis lekérdezési hiba!');
                            }
                            break;

                        case 'group_make_highlight':

                            $result = $this->_status_kiemeles_update($request_data['id'], 'kiemeles', 1);

                            if ($result !== false) {
                                $custom_action_status = 'OK';
                                $custom_action_message = $result . ' elem kiemelve.';
                            } else {
                                $custom_action_status = 'ERROR';
                                $custom_action_message = Message::show('Adatbázis lekérdezési hiba!');
                            }
                            break;

                        case 'group_delete_highlight':

                            $result = $this->_status_kiemeles_update($request_data['id'], 'kiemeles', 0);

                            if ($result !== false) {
                                $custom_action_status = 'OK';
                                $custom_action_message = $result . ' elem kiemelés törölve.';
                            } else {
                                $custom_action_status = 'ERROR';
                                $custom_action_message = Message::show('Adatbázis lekérdezési hiba!');
                            }
                            break;
                    }
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

            $logged_in_user_id = Auth::getUser('id');
            $superadmin = Auth::isSuperadmin();

            foreach ($result as $value) {
//var_dump($value);die;
                // id attribútum hozzáadása egy sorhoz 
                //$temp['DT_RowId'] = 'ez_az_id_' . $value['job_id'];
                // class attribútum hozzáadása egy sorhoz 
                //$temp['DT_RowClass'] = 'proba_osztaly';
                // csak a datatables 1.10.5 verzió felett
                //$temp['DT_RowAttr'] = array('data-proba' => 'ertek_proba');

                if (!$superadmin) {
                    // ha a bejelentkezett user megegyezik az ingatlanhoz rendelt referenssel
                    $visible = ($logged_in_user_id == $value['ref_id']) ? true : false;
                } else {
                    $visible = true;
                }

                // 1. Checkbox oszlop
                $temp['checkbox'] = ($visible) ? '<input type="checkbox" class="checkboxes" name="ingatlan_id_' . $value['id'] . '" value="' . $value['id'] . '"/>' : '';

                // 2. notice checkbox oszlop    
                $temp['notice'] = '<input type="checkbox" class="notice_checkboxes" name="notice" value="' . $value['id'] . '"/>';

                // 3. id oszlop    
                $temp['id'] = $value['id'];

                // 4. Referenci szám oszlop    
                $temp['ref_num'] = '<a href="' . $this->request->get_uri('site_url') . 'property/update/' . $value['id'] . '">#' . $value['ref_num'] . '</a><br>';
                if ($value['kiemeles'] == 1) {
                    $temp['ref_num'] .= '<span class="label label-sm label-success">Kiemelt</span>';
                }
                if ($value['kiemeles'] == 2) {
                    $temp['ref_num'] .= '<span class="label label-sm label-warning">Kiemelt</span>';
                }

                // 5. Képek oszlop    
                if (!empty($value['kepek'])) {
                    $photo_names = json_decode($value['kepek']);
                    //$photo_name = array_shift($photo_names);
                    //unset($photo_names);      
                    $url_helper = DI::get('url_helper');
                    $temp['kepek'] = '<a href="' . $this->request->get_uri('site_url') . 'property/update/' . $value['id'] . '"><img src="' . $url_helper->thumbPath(Config::get('ingatlan_photo.upload_path') . $photo_names[0]) . '" alt="" /></a>';
                } else {
                    $temp['kepek'] = '<a href="' . $this->request->get_uri('site_url') . 'property/update/' . $value['id'] . '"><img src="' . ADMIN_ASSETS . 'img/placeholder_80x60.jpg" alt="" /></a>';
                }

                // 6. Referens oszlop    
                $temp['ref_id'] = $value['first_name'] . '<br>' . $value['last_name'];

                // 7. Típus oszlop    
                $temp['tipus'] = ($value['tipus'] == 1) ? 'eladó' : 'kiadó';

                // 8. Kategória oszlop    
                $temp['kategoria'] = $value['kat_nev_hu'];

                // 9. Város oszlop    
                $kerulet = !empty($value['kerulet']) ? '<br>' . $value['kerulet'] . '. kerület' : '';
                $temp['varos'] = $value['city_name'] . $kerulet . '<br>' . $value['utca'];

                // 10. Alapterület oszlop    
                $temp['alapterulet'] = $value['alapterulet'];

                //$temp['szobaszam'] = $value['szobaszam'];
                // 11. Megtekintés oszlop    
                $temp['megtekintes'] = $value['megtekintes'];

                // 12. Ár oszlop    
                $temp['ar'] = (!empty($value['ar_elado'])) ? $num_helper->niceNumber($value['ar_elado']) : $num_helper->niceNumber($value['ar_kiado']);

                // 13. Status oszlop    
                $temp['status'] = ($value['status'] == 1) ? '<span class="label label-sm label-success">Aktív</span>' : '<span class="label label-sm label-danger">Inaktív</span>';


                //----- 14. MENU HTML -----------------

                $temp['menu'] = '           
                  <div class="actions">
                    <div class="btn-group">';

                $temp['menu'] .= '<a class="btn btn-sm grey-steel" title="Műveletek" href="#" data-toggle="dropdown">
                    <i class="fa fa-cogs"></i>
                      </a>          
                      <ul class="dropdown-menu pull-right">
                    <li><a href="' . $this->request->get_uri('site_url') . 'property/details/' . $value['id'] . '"><i class="fa fa-eye"></i> Részletek</a></li>';

                // adatlap nyomtatás form
                $temp['menu'] .= '<li>
                                <a href="javascript:;" class="generate_pdf" data-id="' . $value['id'] . '"><i class="fa fa-print"></i> Adatlap nyomtatás</a>
                                <form style="display: none;" id="generate_pdf_form_' . $value['id'] . '" method="POST" action="admin/adatlap/' . $value['id'] . '">
								<input type="hidden" name="agent_id" value="' . $value['ref_id'] . '"/>
                                </form>
                        </li>';


                // csak akkor jelenik meg, ha a bejelentkezett user megegyezik az ingatlanhoz rendelt referenssel 
                if ($visible) {
                    // update
                    // if (Auth::hasAccess('property.update')) {}
                    $temp['menu'] .= '<li><a href="' . $this->request->get_uri('site_url') . 'property/update/' . $value['id'] . '"><i class="fa fa-pencil"></i> Szerkeszt</a></li>';

                    // törlés
                    // if (Auth::hasAccess('property.delete')) { }
                    $temp['menu'] .= '<li><a href="javascript:;" class="delete_item" data-id="' . $value['id'] . '"> <i class="fa fa-trash"></i> Töröl</a></li>';
                    //$temp['menu'] .= '<li class="disabled-link"><a href="javascript:;" title="Nincs jogosultsága törölni" class="disable-target"><i class="fa fa-trash"></i> Töröl</a></li>';
                    // REKORD klónozása
                    $temp['menu'] .= '<li><a href="javascript:;" class="clone_item" data-id="' . $value['id'] . '"> <i class="fa fa-clone"></i> Klónozás</a></li>';
                    //$temp['menu'] .= '<li><a href="' . $this->request->get_uri('site_url') . 'property/clone/' . $value['id'] . '"> <i class="fa fa-trash"></i> Klónozás</a></li>';
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
                            $temp['menu'] .= '<li><a data-id="' . $value['id'] . '" href="javascript:;" class="change_status" data-action="make_inactive"><i class="fa fa-ban"></i> Inaktivál</a></li>';
                        }
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
                $json_data["customActionStatus"] = $custom_action_status;
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
    public function insert() {
        Auth::hasAccess('property.insert', $this->request->get_httpreferer());

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
        $view->add_links(array('jquery-ui', 'select2', 'validation', 'ckeditor', 'kartik-bootstrap-fileinput', 'bootstrap-toastr', 'google-maps', 'property_insert', 'autocomplete'));
        $view->render('property/tpl_property_insert', $data);
    }

    /**
     * 	Lakás adatainak módosítása oldal	
     */
    public function update($id) {
        Auth::hasAccess('property.update', $this->request->get_httpreferer());

        // $id = (int) $this->request->get_params('id');
        $id = (int) $id;

        $data['title'] = 'Ingatlan adatok módosítás oldal';
        $data['description'] = 'Ingatlan adatok módosítás description';
        // a lakás összes adatának lekérdezése az ingatlanok táblából
        $data['content'] = $this->property_model->getPropertyAlldata($id);

        // ha nem superadmin, és az ingatlan ref_id-je nem egyezik a bejelentkezett user id-jével 
        if (!Auth::isSuperadmin() && ($data['content']['ref_id'] != Auth::getUser('id'))) {
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
        $view->add_links(array('jquery-ui', 'select2', 'validation', 'ckeditor', 'kartik-bootstrap-fileinput', 'bootstrap-toastr', 'google-maps', 'property_update', 'autocomplete'));
        $view->render('property/tpl_property_update', $data);
    }

    /**
     * Ingatlan klónozása
     */
    public function cloning() {
        if ($this->request->is_ajax()) {

            if (!Auth::hasAccess('property.cloning')) {
                $this->response->json(array(
                    'status' => 'error',
                    'message' => 'Nincs engedélye a művelet végrehalytásához!'
                ));
            }

            $id = (int) $this->request->get_post('item_id');
            // Ha van kép, vagy dokumentum, akkor az értékét true-ra állítjuk
            $update_marker = false;
            // új file-ok létrehozásakor keletkező hibák tömbje
            $errors = array();

            $url_helper = DI::get('url_helper');

            $data = $this->property_model->getPropertyAlldata($id);
            unset($data['id']);

            // képek filenevek
            if (!is_null($data['kepek'])) {
                $temp = json_decode($data['kepek']);
                $kepek_arr = array();
                foreach ($temp as $kep) {
                    $small = $url_helper->thumbPath($kep, false, 'small');
                    $thumb = $url_helper->thumbPath($kep, false, 'thumb');
                    $kepek_arr[] = array($kep, $small, $thumb);
                }
            }
            unset($data['kepek']);

            // dokumentumok filenevek
            if (!is_null($data['docs'])) {
                $docs_arr = json_decode($data['docs']);
            }
            unset($data['docs']);

            // ezeknek a mezőknek integer típusú értéket kell kapniuk + a configból az extrákat tartalamazó mezők
            $integer_items = array(
                'ref_id',
                //'ref_num',
                'status',
                'kategoria',
                'tipus',
                'allapot',
                'kiemeles',
                'megye',
                'varos',
                'kerulet',
                'tetoter',
                'epulet_szintjei',
                'utca_megjelenites',
                'hazszam_megjelenites',
                'terkep',
                'ar_elado',
                'ar_elado_eredeti',
                'ar_kiado',
                'ar_kiado_eredeti',
                'alapterulet',
                'telek_alapterulet',
                'erkely_terulet',
                'terasz_terulet',
                'belmagassag',
                'tajolas',
                'szobaszam',
                'felszobaszam',
                'szoba_elrendezes',
                'kozos_koltseg',
                'rezsi',
                'futes',
                'parkolas',
                'szerkezet',
                'kilatas',
                'lift',
                'energetika',
                'kert',
                'haz_allapot_belul',
                'haz_allapot_kivul',
                'fenyviszony',
                'furdo_wc',
                'erkely',
                'terasz',
                'megtekintes',
                'kepek_szama'
            );
            // az extrákat tartalamazó mezőket is hozzáadjuk
            $integer_items = array_merge($integer_items, Config::get('extra'));

            foreach ($integer_items as $value) {
                if (!is_null($data[$value])) {
                    $data[$value] = (int) $data[$value];
                }
            }

            // a statust inaktívra állítjuk
            $data['status'] = 0;
            // létrehozzuk az új rekordot a másik rekord adataival (id, kepek, docs oszlopadatok nélkül)
            $last_insert_id = $this->property_model->insert($data);
            if ($last_insert_id === false) {
                //Message::set('Hiba az adatbázisba íráskor. Az ingatlan másolata nem jött létre!');
                $this->response->json(array(
                    'status' => 'error',
                    'message' => 'Hiba az adatbázisba íráskor. Az ingatlan másolata nem jött létre!'
                ));
            }

            // képek klónozása az új rekordhoz
            // ha létrehoztuk a $kepek_arr tömböt... mert tartoznak képek az ingatlanhoz
            if (isset($kepek_arr)) {
                // feltöltés helye
                $upload_path = Config::get('ingatlan_photo.upload_path');
                // az új képek neveit fogja tárolni
                $new_filenames = array();
                // uj kepek letrehozasa
                foreach ($kepek_arr as $kepek) {

                    $tempfilename = $last_insert_id . '_' . md5(uniqid());
                    $counter = 0;

                    foreach ($kepek as $kep) {
                        $imageobject = new Uploader($upload_path . $kep);

                        // a kepek tombben 3 elem van: normal_kep, small_kep, thumb_kep
                        if ($counter === 0) {
                            $newfilename = $tempfilename;
                        } elseif ($counter === 1) {
                            $newfilename = $tempfilename . '_small';
                        } elseif ($counter === 2) {
                            $newfilename = $tempfilename . '_thumb';
                        }

                        // új kép létrehozása
                        $imageobject->save($upload_path, $newfilename);

                        // hibaellenőrzés
                        if ($imageobject->checkError()) {
                            $errors[] = $imageobject->getError();
                        } else {
                            // ha nem volt hiba, akkor csak a normal kep neve kerül az adatbázisba                        
                            if ($counter === 0) {
                                $new_filenames[] = $imageobject->getDest('filename');
                            }
                        }

                        $counter++;
                    }
                }

                // az adatbázis kepek oszlopába kerülő adat
                $update_data['kepek'] = json_encode($new_filenames);
                $update_marker = true;
            }

            // dokumentumok klónozása az új rekordhoz
            // ha létrehoztuk a $docs_arr tömböt... mert tartoznak dokumentumok az ingatlanhoz
            if (isset($docs_arr)) {
                // feltöltés helye
                $upload_path = Config::get('ingatlan_doc.upload_path');
                // az új képek neveit fogja tárolni
                $new_docnames = array();
                // uj kepek letrehozasa
                foreach ($docs_arr as $doc) {
                    $newfilename = $last_insert_id . '_' . md5(uniqid());

                    $fileobject = new Uploader($upload_path . $doc);
                    $fileobject->save($upload_path, $newfilename);

                    // hibaellenorzes
                    if ($fileobject->checkError()) {
                        $errors[] = $fileobject->getError();
                    } else {
                        // a sikeresen létrehozott dokumentum neve bekerül a $new_docnames tömbbe
                        $new_docnames[] = $fileobject->getDest('filename');
                    }
                }

                // az adatbázis docs oszlopába kerülő adat
                $update_data['docs'] = json_encode($new_docnames);
                $update_marker = true;
            }

            // ha valamilyen hiba volt a képek másolása közben
            if (!empty($errors)) {

                // ha valamelyik kép, vagy dokumentum lemásolódott, akkor frissítjük az adatbázist
                if ((isset($new_filenames) && !empty($new_filenames)) || (isset($new_docnames) && !empty($new_docnames))) {
                    $this->property_model->update($last_insert_id, $update_data);
                }

                $update_marker = false;
                //Message::set('Hiba történt az új képek vagy dokumentumok másolása közben!');
                $this->response->json(array(
                    'status' => 'warning',
                    'message' => 'A klónozás megtörtént, de hiba történt a képek vagy dokumentumok másolása közben!'
                ));
            }

            if ($update_marker) {
                // az új képek neveivel frissítjük a rekordot
                $result = $this->property_model->update($last_insert_id, $update_data);
                if ($result === false) {
                    //Message::set('Az új képek és dokumentumok adatai nem kerületek be az adatbázisba!');
                    $this->response->json(array(
                        'status' => 'error',
                        'message' => 'Az új képek és dokumentumok adatai nem kerületek be az adatbázisba!'
                    ));
                }
            }

            //$this->response->redirect('admin/property');
            $this->response->json(array(
                'status' => 'success',
                'message' => 'Az ingatlan klónozása megtörtént'
            ));
        } else {
            $this->response->redirect('admin/error');
        }
    }

    /**
     * 	(AJAX) Lakás részletek (modal-ba)
     */
    public function view_property_ajax($id) {
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
    public function delete() {
        if ($this->request->is_ajax()) {

            if (!Auth::hasAccess('property.delete')) {
                $this->response->json(array(
                    'status' => 'error',
                    'message' => 'Nincs engedélye a művelet végrehajtásához!'
                ));
            }

            // a POST-ban kapott item_id (csoportos törlésnél tömb, egy elem törlésnél string) 
            $id_data = $this->request->get_post('item_id');

            // rekord törlése
            $result = $this->_delete($id_data);

            if ($result !== false) {
                $this->response->json(array(
                    "status" => 'success',
                    "message_success" => $result . ' ingatlan törölve.'
                ));
            } else {
                // ha a törlési sql parancsban hiba van
                $this->response->json(array(
                    "status" => 'error',
                    "message" => 'Adatbázis lekérdezési hiba!'
                ));
            }
        } else {
            $this->response->redirect('admin/error');
        }
    }

    /**
     *  (AJAX) Ingatlan nem végleges törlése
     */
    public function softDelete() {
        if ($this->request->is_ajax()) {

            if (!Auth::hasAccess('property.softdelete')) {
                $this->response->json(array(
                    'status' => 'error',
                    'message' => 'Nincs engedélye a művelet végrehajtásához!'
                ));
            }

            // a POST-ban kapott item_id (csoportos törlésnél tömb, egy elem törlésnél string) 
            $id_data = $this->request->get_post('item_id');

            // update művelet végrehajtása
            $result = $this->_softDelete($id_data);

            if ($result !== false) {
                $this->response->json(array(
                    "status" => 'success',
                    "message_success" => $result . 'ingatlan a áthelyezve a lomtárba.'
                ));
            } else {
                // ha a törlési sql parancsban hiba van
                $this->response->json(array(
                    "status" => 'error',
                    "message" => 'Adatbázis lekérdezési hiba!'
                ));
            }
        } else {
            $this->response->redirect('admin/error');
        }
    }

    /**
     * Törölt ingatlanok helyreállítása
     */
    public function cancel_delete() {
        if ($this->request->is_ajax()) {

            if (!Auth::hasAccess('property.cancel_delete')) {
                $this->response->json(array(
                    'status' => 'error',
                    'message' => 'Nincs engedélye a művelet végrehajtásához!'
                ));
            }

            // a POST-ban kapott item_id (csoportos törlésnél tömb, egy elem törlésnél string) 
            $id_data = $this->request->get_post('item_id');

            // a sikeres törlések számát tárolja
            $success_counter = 0;
            // törölt rekordok id-je
            $success_id_arr = array();
            // tömbösítjük, ha nem tömb az $id_data
            $id_data = (!is_array($id_data)) ? (array) $id_data : $id_data;

            // bejárjuk az id-ket tartalmazó tömböt
            foreach ($id_data as $id) {
                $id = (int) $id;
                // rekord deleted oszlop 0-re 
                $result = $this->property_model->update($id, array('deleted' => 0));

                // ha a törlési sql parancsban nincs hiba
                if ($result !== false) {
                    $success_counter += $result;
                    $success_id_arr[] = $id;
                } else {
                    // ha a törlési sql parancsban hiba van
                    $this->response->json(array(
                        "status" => 'error',
                        "message" => 'Adatbázis lekérdezési hiba!'
                    ));
                }
            }

            // ha nem volt hiba
            $this->response->json(array(
                "status" => 'success',
                "message_success" => $success_counter . ' ingatlan helyreállítva.'
            ));
        } else {
            $this->response->redirect('admin/error');
        }
    }

    /**
     * Rekord(ok) soft törlése (deleted oszlop = 1)
     * @param array $id_data
     * @return integer || false
     */
    private function _softDelete($id_data) {
        // a sikeres törlések számát tárolja
        $success_counter = 0;
        // törölt rekordok id-je
        $success_id_arr = array();

        // tömbösítjük, ha nem tömb az $id_data
        $id_data = (!is_array($id_data)) ? (array) $id_data : $id_data;

        foreach ($id_data as $id) {
            $id = (int) $id;
            // rekord deleted oszlop 1-re 
            $result = $this->property_model->update($id, array('deleted' => 1));

            // ha a törlési sql parancsban nincs hiba
            if ($result !== false) {
                $success_counter += $result;
                $success_id_arr[] = $id;
            } else {
                // ha a törlési sql parancsban hiba van
                return false;
            }
        }

        // log        
        if (!empty($success_id_arr)) {
            EventManager::trigger('delete_property', array('delete', 'azonosító számú ingatlan lomtárba helyezve.', $success_id_arr));
        }

        return $success_counter;
    }

    /**
     * Rekord(ok) törlése
     * @param array $id_data
     * @return integer || false
     */
    private function _delete($id_data) {
        // a sikeres törlések számát tárolja
        $success_counter = 0;
        // a sikertelen törlések számát tárolja
        $fail_counter = 0;

        $success_id_arr = array();

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
                    // hozzáadjuk az id-t törölt elemekhez                
                    $success_id_arr[] = $id;
                } else {
                    //sikertelen törlés (0 sor lett törölve)
                    $fail_counter++;
                }
            } else {
                // ha a törlési sql parancsban hiba van
                return false;
            }
        } // end foreach
        //log        
        if (!empty($success_id_arr)) {
            EventManager::trigger('delete_property', array('delete', 'azonosító számú ingatlan véglegesen törölve.', $success_id_arr));
        }

        return $success_counter + $fail_counter;
    }

    /**
     * Törölt ingatlanokat tartalmazó oldal action-ja
     */
    public function deleted_records() {
        $data['title'] = 'Törölt ingatlanok oldal';
        $data['description'] = 'Törölt ingatlanok oldal description';
        $data['ingatlanok'] = $this->property_model->deletedPropertys();

        $view = new View();
        //$view->debug(true);
        $view->setHelper(array('url_helper', 'num_helper'));
        $view->add_links(array('datatable', 'bootbox', 'vframework'));
        $view->add_link('js', ADMIN_JS . 'pages/property_list_deleted.js');
        $view->render('property/tpl_property_deleted_list', $data);
    }

    /**
     *  (AJAX) Új lakás adatok bevitele adatbázisba,
     *  Lakás adatok módosítása az adatbázisban
     */
    public function insert_update() {
        if ($this->request->is_ajax()) {

            if ($this->request->has_post()) {
                //megadja, hogy update, vagy insert lesz
                $update_marker = false;
                //megadja, hogy insert utáni update, normál update lesz (modositas_datum megadása miatt)
                $update_real = false;

                $data = $this->request->get_post(null, 'strip_danger_tags');

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

                //ingatlan megnevezése
                if (empty($data['ingatlan_nev_hu'])) {
                    $error_messages[] = Message::show('Az ingatlan magyar megnevezése nem lehet üres.');
                    $error_counter += 1;
                }

                // ár
                if (empty($data['ar_elado_eredeti']) && empty($data['ar_kiado_eredeti'])) {
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

                    // referens id  
                    $data['ref_id'] = (int) $data['ref_id'];
                    // referenciaszám
                    $data['ref_num'] = $data['ref_num'];
                    // status
                    $data['status'] = (int) $data['status'];
                    // kiemeles
                    $data['kiemeles'] = (int) $data['kiemeles'];
                    // tipus
                    $data['tipus'] = (int) $data['tipus'];
                    // kategoria
                    $data['kategoria'] = (int) $data['kategoria'];


                    // num helper példányosítása
                    $num_helper = DI::get('num_helper');

                    /*                     * **** ÁR MEZŐK ÉRTÉKÉNEK FELDOLGOZÁSA ***** */

                    // új ár módosítást jelző változók
                    $ar_elado_modosult = false;
                    $ar_kiado_modosult = false;

                    // típus eladó
                    if ($data['tipus'] == 1) {

                        $data['ar_elado_eredeti'] = intval($num_helper->stringToNumber($data['ar_elado_eredeti'], 2) * 1000000);

                        //insert és insert utáni upadate esetén
                        if (!$update_marker || ($update_marker && !$update_real)) {
                            $data['ar_elado'] = $data['ar_elado_eredeti'];
                        }
                        //valódi update esetén (csak ekkor van ar_elado_hidden mezo)
                        elseif ($update_marker && $update_real) {
                            // ha az új ár üres string volt
                            if ($data['ar_elado'] === '') {
                                //die('ha nem volt új ár, módosítaskor');
                                $data['ar_elado'] = $data['ar_elado_eredeti'];
                            }
                            // ha volt új ár módosítás
                            elseif ($data['ar_elado'] != $data['ar_elado_hidden']) {
                                //die('ar módositas történt');
                                $data['ar_elado'] = intval($num_helper->stringToNumber($data['ar_elado'], 2) * 1000000);
                                $ar_elado_modosult = true;
                            }
                            // ha nem volt változás az új árban
                            else {
                                unset($data['ar_elado']);
                            }
                        }

                        $data['ar_kiado_eredeti'] = null;
                        $data['ar_kiado'] = null;
                    }
                    // típus kiadó
                    if ($data['tipus'] == 2) {

                        $data['ar_kiado_eredeti'] = intval($num_helper->stringToNumber($data['ar_kiado_eredeti']) * 1000);

                        //insert és insert utáni upadate esetén
                        if (!$update_marker || ($update_marker && !$update_real)) {
                            $data['ar_kiado'] = $data['ar_kiado_eredeti'];
                        }
                        //update esetén
                        else {
                            // ha az új ár üres string volt
                            if ($data['ar_kiado'] === '') {
                                //die('ha nem volt új ár, módosítaskor');
                                $data['ar_kiado'] = $data['ar_kiado_eredeti'];
                            }
                            // ha volt új ár módosítás
                            elseif ($data['ar_kiado'] != $data['ar_kiado_hidden']) {
                                //die('ar módositas történt');
                                $data['ar_kiado'] = intval($num_helper->stringToNumber($data['ar_kiado']) * 1000);
                                $ar_kiado_modosult = true;
                            }
                            // ha nem volt változás az új árban
                            else {
                                unset($data['ar_kiado']);
                            }
                        }

                        $data['ar_elado_eredeti'] = null;
                        $data['ar_elado'] = null;
                    }

                    // rejtett mezőkből jövő adatelemek törlése (ezeket nem kell az adatbáziba írni, mert nincs ilyen db oszlop)
                    if (isset($data['ar_elado_hidden']) || isset($data['ar_kiado_hidden'])) {
                        unset($data['ar_elado_hidden']);
                        unset($data['ar_kiado_hidden']);
                    }

                    // ár eladó
                    // $data['ar_elado'] = ($data['tipus'] == 1) ? $data['ar_elado'] * 1000000 : null;
                    // ár kiadó
                    // $data['ar_kiado'] = ($data['tipus'] == 2) ? $data['ar_kiado'] * 1000 : null;

                    /*                     * **** ÁR MEZŐK ÉRTÉKÉNEK FELDOLGOZÁSA VÉGE ***** */


                    $data['hazszam'] = (isset($data['hazszam'])) ? $data['hazszam'] : null;
                    $data['megye'] = (isset($data['megye'])) ? (int) $data['megye'] : null;
                    $data['varos'] = (isset($data['varos'])) ? (int) $data['varos'] : null;
                    $data['kerulet'] = (isset($data['kerulet'])) ? (int) $data['kerulet'] : null;

                    // alapterület
                    $data['alapterulet'] = !empty($data['alapterulet']) ? (int) $data['alapterulet'] : null;

                    // telek alapterület
                    if (isset($data['telek_alapterulet'])) {
                        $data['telek_alapterulet'] = ($data['telek_alapterulet'] !== '') ? (int) $data['telek_alapterulet'] : null;
                    }

                    // belmagasság
                    $data['belmagassag'] = ($data['belmagassag'] !== '') ? (int) $data['belmagassag'] : null;
                    // tájolás (szám kerül az adatbázisba: 0-7 ig)
                    $data['tajolas'] = ($data['tajolas'] !== '') ? $data['tajolas'] : null;
                    // emelet
                    $data['emelet'] = ($data['emelet'] !== '') ? $data['emelet'] : null;
                    // épület szintjei
                    if (isset($data['epulet_szintjei'])) {
                        $data['epulet_szintjei'] = ($data['epulet_szintjei'] !== '') ? $data['epulet_szintjei'] : null;
                    }

                    //geolocation
                    /*
                      // lekérdezzük a város nevét az id-je alapján
                      $city_name = $this->property_model->getCityName($data['varos']);
                      $address = $data['iranyitoszam'] . ' ' . $city_name . ' ' . $data['utca'] . ' ' . $data['hazszam'];
                      $loc = Geocoder::getLocation($address);
                      if ($loc) {
                      $data['latitude'] = $loc['lat'];
                      $data['longitude'] = $loc['lng'];
                      } else {
                      $data['latitude'] = 0;
                      $data['longitude'] = 0;
                      }
                     */
                    $data['latitude'] = (!empty($data['latitude'])) ? $data['latitude'] : null;
                    $data['longitude'] = (!empty($data['longitude'])) ? $data['longitude'] : null;


                    $data['utca_megjelenites'] = (isset($data['utca_megjelenites'])) ? 1 : 0;
                    $data['hazszam_megjelenites'] = (isset($data['hazszam_megjelenites'])) ? 1 : 0;
                    $data['terkep'] = (isset($data['terkep'])) ? 1 : 0;


                    $data['szobaszam'] = ($data['szobaszam'] !== '') ? (int) $data['szobaszam'] : null;
                    $data['felszobaszam'] = ($data['felszobaszam'] !== '') ? (int) $data['felszobaszam'] : null;
                    $data['kozos_koltseg'] = ($data['kozos_koltseg'] !== '') ? (int) $data['kozos_koltseg'] : null;
                    $data['rezsi'] = ($data['rezsi'] !== '') ? (int) $data['rezsi'] : null;
                    $data['emelet'] = (isset($data['emelet'])) ? $data['emelet'] : null;
                    $data['epulet_szintjei'] = (isset($data['epulet_szintjei'])) ? (int) $data['epulet_szintjei'] : null;

                    // ha nincs megadva angol nyelvü ingatlan megnevezés, akkor a magyar lesz az angolnál is
                    if ($data['ingatlan_nev_en'] === '') {
                        $data['ingatlan_nev_en'] = $data['ingatlan_nev_hu'];
                    }

                    // jellemzők
                    $data['tetoter'] = (isset($data['tetoter'])) ? 1 : 0;
                    $data['erkely'] = (isset($data['erkely'])) ? 1 : 0;
                    //erkely terulet
                    if (isset($data['erkely_terulet'])) {
                        $data['erkely_terulet'] = ($data['erkely_terulet'] !== '') ? (int) $data['erkely_terulet'] : null;
                    }
                    $data['terasz'] = (isset($data['terasz'])) ? 1 : 0;
                    //terasz terulet
                    if (isset($data['terasz_terulet'])) {
                        $data['terasz_terulet'] = ($data['terasz_terulet'] !== '') ? (int) $data['terasz_terulet'] : null;
                    }

                    // datatables jellemzők select menüből
                    $jellemzok1 = array('lift', 'allapot', 'haz_allapot_kivul', 'haz_allapot_belul', 'furdo_wc', 'fenyviszony', 'futes', 'parkolas', 'kilatas', 'szerkezet', 'energetika', 'kert', 'szoba_elrendezes');
                    foreach ($jellemzok1 as $jellemzo) {
                        $data[$jellemzo] = ($data[$jellemzo] === '') ? null : (int) $data[$jellemzo];
                    }

                    // EXTRÁK - checkbox
                    $jellemzok2 = Config::get('extra');
                    foreach ($jellemzok2 as $jellemzo) {
                        $data[$jellemzo] = (isset($data[$jellemzo])) ? 1 : 0;
                    }

                    if ($update_marker) {
                        // UPDATE
                        // az update-nél ha superadmin módosít, akkor lesz ref_id input elem
                        if (isset($data['ref_id'])) {
                            $data['ref_id'] = (int) $data['ref_id'];
                        }

                        if ($update_real) {
                            // a módosítás dátum a "rendes" módosításkor fog bekerülni az adatbázisba 
                            $data['modositas_datum'] = time();
                        }

                        // adatok adatbázisba írása
                        $result = $this->property_model->update($id, $data);

                        if ($result === 0 || $result === 1) {

                            if ($update_real) {
                                Message::set('success', 'A módosítások sikeresen elmentve!');


                                // ha módosították az árat (nem az eredeti árat)
                                if ($ar_elado_modosult === true || $ar_kiado_modosult === true) {
                                    // lekérdezzük azoknak a felhasználóknak az id-jét, akik kérnek árváltozás értesítést erről az ingatlanról
                                    $price_change_users = $this->property_model->getPriceChangeUser($id);
                                    if (!empty($price_change_users)) {

                                        $price_change_data = array(
                                            'ingatlan_ref_id' => '#' . $data['ref_num'],
                                            'ingatlan_nev' => $data['ingatlan_nev_hu'],
                                            'ingatlan_tipus' => $data['tipus'],
                                        );

                                        if ($ar_elado_modosult === true) {
                                            $price_change_data['ar_eredeti'] = $data['ar_elado_eredeti'];
                                            $price_change_data['ar_uj'] = $data['ar_elado'];
                                        }
                                        if ($ar_kiado_modosult === true) {
                                            $price_change_data['ar_eredeti'] = $data['ar_kiado_eredeti'];
                                            $price_change_data['ar_uj'] = $data['ar_kiado'];
                                        }

                                        $price_change_data['url'] = BASE_URL . 'ingatlanok/adatlap/' . $id . '/' . DI::get('str_helper')->stringToSlug($data['ingatlan_nev_hu']);
                                        $price_change_data['user_id_array'] = $price_change_users;

                                        $this->loadModel('settings_model');
                                        $price_change_data['settings'] = $this->settings_model->get_settings();

                                        // E-mail küldése site user-ekenek
                                        EventManager::trigger('change_price', array($price_change_data));
                                    }

                                    EventManager::trigger('update_property', array('update', '#' . $id . ' / ' . $data['ref_num'] . ' - referencia számú ingatlan ára megváltozott'));
                                    // E-mail küldése admin-oknak
                                    //EventManager::trigger('send_info_email', array('ref_num' => array($data['ref_num']), 'message' => 'referencia számú ingatlan ára módosult.'));
                                } else {
                                    EventManager::trigger('update_property', array('update', '#' . $id . ' / ' . $data['ref_num'] . ' - referencia számú ingatlan módosítása'));
                                }
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
                        $data['ref_id'] = (int) $data['ref_id'];

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

                        EventManager::trigger('insert_property', array('insert', '#' . $last_id . ' / ' . $data['ref_num'] . ' - referencia számú ingatlan létrehozása'));
                        //EventManager::trigger('send_info_email', array('ref_num' => array($data['ref_num']), 'message' => 'referencia számú ingatlan létrehozva.'));

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
                    $file_path = $url_helper->thumbPath($file_location . $value, false, 'small');
                    $html .= '<li id="elem_' . $counter . '" class="ui-state-default"><img style="width:220px;" class="img-thumbnail" src="' . $file_path . '" alt="" /><button style="position:absolute; top:20px; right:20px; z-index:2;" class="btn btn-xs btn-default" type="button" title="Kép törlése"><i class="glyphicon glyphicon-trash"></i></button></li>' . "\n\r";
                }
            }
            if ($type == 'alaprajzok') {
                $file_location = Config::get('ingatlan_photo_floor_plan.upload_path');

                foreach ($files_arr['alaprajzok'] as $key => $value) {
                    $counter = $key + 1;
                    $file_path = $url_helper->thumbPath($file_location . $value, false, 'small');
                    $html .= '<li id="elem_' . $counter . '" class="ui-state-default"><img style="width:220px;" class="img-thumbnail" src="' . $file_path . '" alt="" /><button style="position:absolute; top:20px; right:20px; z-index:2;" class="btn btn-xs btn-default" type="button" title="Kép törlése"><i class="glyphicon glyphicon-trash"></i></button></li>' . "\n\r";
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
    public function photo_sort() {
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
     * 	Alaprajz Képek sorbarendezése (AJAX)
     */
    public function alaprajz_sort() {
        if ($this->request->is_ajax()) {

            $id = $this->request->get_post('id', 'integer');
            // json string: elem_1[]=3,elem_2[]=1,elem_3[]=2
            $sort_json = $this->request->get_post('sort');

            // képek adatainak lekérdezése
            $photo_arr = $this->property_model->getFilenames($id, 'alaprajzok');
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

            $data['alaprajzok'] = json_encode($result_arr);

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
    public function file_delete() {
        if ($this->request->is_ajax()) {

            if (!Auth::hasAccess('property.file_delete')) {
                $this->response->json(array(
                    'status' => 'error',
                    'message' => 'Nincs engedélye a művelet végrehajtásához!'
                ));
            }

            $id = $this->request->get_post('id', 'integer');
            // a kapott szorszámból kivonunk egyet, mert a képeket tartalamzó tömbben 0-tól indul a számozás
            $sort_id = ($this->request->get_post('sort_id', 'integer')) - 1;
            // fájl típusa (kép vagy dokumentum)
            $type = $this->request->get_post('type');

            // fájlok nevét tartalmazó tömb
            $file_name_arr = $this->property_model->getFilenames($id, $type);
            // file-ok száma
            $files_number = count($file_name_arr);
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

            // kepek esetén az adatbázisban a kepek_szama oszlop értékét is módosítani kell
            if ($type == 'kepek') {
                $data['kepek_szama'] = $files_number - 1;
            }

            // módosított file lista beírása az adatbázisba (képek esetén kepek_szama oszlop frissítése)
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
                if ($type == 'alaprajzok') {
                    $url_helper = DI::get('url_helper');
                    $photo_path = Config::get('ingatlan_photo_floor_plan.upload_path') . $filename;
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
    public function file_upload_ajax() {
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
                $imageobject->cropFillToSize($width, $height, '#fff');
                //       $imageobject->cropToSize($width, $height);
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
                    $imageobject->cropFillToSize($small_width, $small_height);
                    $imageobject->save($upload_path, $new_small_filename);

                    // thumb kép feltöltése
                    $new_thumb_filename = $newfilename . '_thumb';
                    $thumb_width = Config::get('ingatlan_photo.thumb_width', 80);
                    $thumb_height = Config::get('ingatlan_photo.thumb_height', 60);
                    $imageobject->cropFillToSize($thumb_width, $thumb_height);
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
     * 	(AJAX) Alaprajz feltöltés (képek)
     */
    public function floor_plan_upload_ajax() {
        if ($this->request->is_ajax()) {
            //uploadExtraData beállítás küldi
            $id = $this->request->get_post('id', 'integer');

            // new_file elem a $_FILES tömbből     
            $uploaded_files = $this->request->getFiles('new_file');
            // feltöltés helye
            $upload_path = Config::get('ingatlan_photo_floor_plan.upload_path');
            // a feltöltött képek neveit fogja tárolni
            $new_filenames = array();

            foreach ($uploaded_files as $file_arr) {

                $imageobject = new Uploader($file_arr);

                $newfilename = $id . '_alaprajz_' . md5(uniqid());
                $width = Config::get('ingatlan_photo_floor_plan.width', 800);
                $height = Config::get('ingatlan_photo_floor_plan.height', 600);

                $imageobject->allowed(array('image/*'));
                $imageobject->cropFillToSize($width, $height, '#fff');
                //       $imageobject->cropToSize($width, $height);
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
                    $small_width = Config::get('ingatlan_photo_floor_plan.small_width', 400);
                    $small_height = Config::get('ingatlan_photo_floor_plan.small_height', 300);
                    $imageobject->cropFillToSize($small_width, $small_height);
                    $imageobject->save($upload_path, $new_small_filename);

                    // thumb kép feltöltése
                    $new_thumb_filename = $newfilename . '_thumb';
                    $thumb_width = Config::get('ingatlan_photo_floor_plan.thumb_width', 80);
                    $thumb_height = Config::get('ingatlan_photo_floor_plan.thumb_height', 60);
                    $imageobject->cropFillToSize($thumb_width, $thumb_height);
                    $imageobject->save($upload_path, $new_thumb_filename);
                }
            }

            // temp file-ok törlése
            $imageobject->cleanTemp();


            // kép adatok adatbázisba írása    
            // lekérdezzük a képek mező értékét
            $old_filenames = $this->property_model->getFilenames($id, 'alaprajzok');
            // ha már tartalmaz adatot a mező összeolvasztjuk az újakkal
            if (!empty($old_filenames)) {
                $new_filenames = array_merge($old_filenames, $new_filenames);
            }

            // visszaalakítjuk json-ra
            $data['alaprajzok'] = json_encode($new_filenames);
            // beírjuk az adatbázisba
            $result = $this->property_model->update($id, $data);

            if ($result !== false) {
                $this->response->json(array(
                    'status' => 'success',
                    'message' => 'Alaprajz feltöltés sikeres.'
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
    public function doc_upload_ajax() {
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
        $success_id_arr = array();

        $id_arr = (!is_array($id_arr)) ? (array) $id_arr : $id_arr;

        foreach ($id_arr as $id) {

            $result = $this->property_model->update($id, array($column => $data));

            if ($result !== false) {
                // ha az update sql parancsban nincs hiba
                $success_counter += $result;

                if ($result > 0) {
                    $success_id_arr[] = $id;
                }
            } else {
                // visszatér ha az update sql parancsban hiba van
                return false;
            }
        }

// log
        if (!empty($success_id_arr)) {
            if ($data === 1 && $column == 'status') {
                EventManager::trigger('change_property_status', array('active', 'azonosító számú ingatlan státusza aktív lett.', $success_id_arr));
                //EventManager::trigger('send_info_email', array('ref_num' => $success_id_arr, 'message' => 'azonosító számú ingatlan statusza aktív lett.'));
            } elseif ($data === 0 && $column == 'status') {
                EventManager::trigger('change_property_status', array('inactive', 'azonosító számú ingatlan státusza inaktív lett.', $success_id_arr));
                //EventManager::trigger('send_info_email', array('ref_num' => $success_id_arr, 'message' => 'azonosító számú ingatlan statusza inaktív lett.'));
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

            if (!Auth::hasAccess('property.change_status')) {
                $this->response->json(array(
                    'status' => 'error',
                    'message' => 'Nincs engedélye a művelet végrehajtásához!'
                ));
            }

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

            if (!Auth::hasAccess('property.kiemeles')) {
                $this->response->json(array(
                    'status' => 'error',
                    'message' => 'Nincs engedélye a művelet végrehajtásához!'
                ));
            }

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
    public function street_list() {
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

    /**
     * E-mail küldése ingatlanokról
     */
    public function sendEmail() {
        if ($this->request->is_ajax()) {

            $this->loadModel('settings_model');
            $settings = $this->settings_model->get_settings();

            $id_array = $this->request->get_post('id_array');
            $email = $this->request->get_post('email');
            $name = $this->request->get_post('name');
            $message = $this->request->get_post('message');

            // auth objektum
            $auth = DI::get('auth');
            // bejelentkezett user id-je
            $user_id = Auth::getUser('id');
            // bejelentkezett user adatai (objektum!)
            $user = $auth->getUserDataById($user_id);

            $data = array();
            foreach ($id_array as $id) {
                $data[] = $this->property_model->getPropertyDetails($id);
            }

            $photo_link = BASE_URL . UPLOADS . 'ingatlan_photo/';
            $url_helper = DI::get('url_helper');
            $str_helper = DI::get('str_helper');
            $name = (empty($name)) ? 'érdeklődő' : $name;

            $html_data = "";
            foreach ($data as $key => $value) {

                if (!empty($value['kepek'])) {
                    $kep_arr = json_decode($value['kepek']);
                    $img = "<img src=" . BASE_URL . $url_helper->thumbPath(Config::get('ingatlan_photo.upload_path') . $kep_arr[0]) . " alt='" . $value['ingatlan_nev_hu'] . "' />";
                } else {
                    $img = "<img src=" . BASE_URL . $url_helper->thumbPath(Config::get('ingatlan_photo.upload_path') . 'placeholder.jpg') . " alt='" . $value['ingatlan_nev_hu'] . "' />";
                }

                $html_data .= "<tr>\r\n";
                $html_data .= "<td>" . $img . "</td>";
                $html_data .= "<td><strong>S-" . $value['ref_num'] . "</strong></td>";
                $html_data .= "<td>" . $value['ingatlan_nev_hu'] . "</td>";
                $html_data .= "<td><a style='color:blue;' href='" . BASE_URL . 'ingatlanok/adatlap/' . $value['id'] . '/' . $str_helper->stringToSlug($value['ingatlan_nev_hu']) . '?referens=' . $user->id . "' target='_blank'>Megtekintés</a></td>";
                $html_data .= "</tr>\r\n";
            }

            $html_data .= "<tr>\r\n";
            $html_data .= "<td colspan='4'>&nbsp;</td>\r\n";
            $html_data .= "</tr>\r\n";

            $html_data .= "<tr>\r\n";
            $html_data .= "<td colspan='4'><strong>Ingatlan referens:</strong> " . $user->first_name . ' ' . $user->last_name . "</td>\r\n";
            $html_data .= "</tr>\r\n";
            $html_data .= "<tr>\r\n";
            $html_data .= "<td colspan='4'><strong>Telefon:</strong> " . $user->phone . "</td>\r\n";
            $html_data .= "</tr>\r\n";

            // template-be kerülő változók
            $template_data = array(
                'email' => $email,
                'name' => $name,
                'message' => $message,
                'ref_name' => $user->first_name . ' ' . $user->last_name,
                'ref_email' => $user->email,
                'ref_phone' => $user->phone,
                'html_data' => $html_data
            );


            $to_email = $email;
            $to_name = '';
            $subject = 'Értesítés ingatlanokról';
            $template = 'ingatlanok_email';
            $from_email = $user->email;
            $from_name = $settings['ceg'];

            $emailer = new Emailer($from_email, $from_name, $to_email, $to_name, $subject, $template_data, $template);
            
            $emailer->setArea('admin');

            $emailer->setSmtpSettings(array(
                'smtp_host' => $settings['smtp_host'],
                'smtp_username' => $settings['smtp_username'],
                'smtp_password' => $settings['smtp_password'],
                'smtp_port' => $settings['smtp_port'],
                'smtp_encryption' => $settings['smtp_encryption']
            ));

            //$emailer->setDebug(true);
            // true vagy false
            if ($emailer->send()) {
                unset($template_data['ref_phone']);
                unset($template_data['ref_email']);
                $template_data['date'] = time();
                $this->loadModel('ingatlan_ajanlasok_model');
                $this->ingatlan_ajanlasok_model->insert($template_data);
                $this->response->json(array(
                    'status' => 'success',
                    'message' => 'Üzenet a ' . $email . ' címre sikeresen elküldve.'
                ));
            } else {
                $this->response->json(array(
                    'status' => 'error',
                    'message' => 'E-mail küldése sikertelen.'
                ));
            }
        } else {
            $this->response->redirect('admin/error');
        }
    }

}

?>