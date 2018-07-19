<?php
namespace System\Admin\Controller;
use System\Core\AdminController;
use System\Core\View;
//use System\Libs\Auth;
//use System\Libs\DI;
//use System\Libs\Config;
//use System\Libs\Message;

class Datatables extends AdminController {

    function __construct()
    {
        parent::__construct();
        $this->loadModel('datatables_model');
    }

    public function index()
    {
    }

    /**
     * Ingatlan állapot
     *
     * @return void
     */
    public function ingatlan_allapot()
    {
        $view = new View();    

        $data['title'] = 'Állapot oldal';
        $data['description'] = 'Állapot oldal description';
        $data['allapot'] = $this->datatables_model->get_jellemzo_list('ingatlan_allapot');

        $view->add_links(array('datatable', 'bootbox', 'datatable_lists'));
        $view->render('datatables/tpl_allapot', $data);
    }
    
    
    /**
     * Ingatlan kategoria
     *
     * @return void
     */
    public function ingatlan_kategoria()
    {
        $view = new View();

        $data['title'] = 'kategória oldal';
        $data['description'] = 'Kategória oldal description';
        $data['kategoriak'] = $this->datatables_model->get_jellemzo_list('ingatlan_kategoria');
        
        //$view->add_links(array('datatable', 'bootbox', 'kategoria'));
        $view->add_links(array('datatable', 'bootbox', 'datatable_lists'));
        $view->render('datatables/tpl_kategoria', $data);
    }
    
    /**
     * Ingatlan fűtés
     *
     * @return void
     */
    public function ingatlan_futes()
    {
        $view = new View();

        $data['title'] = 'Fűtés oldal';
        $data['description'] = 'Fűtés oldal description';
        $data['futes'] = $this->datatables_model->get_jellemzo_list('ingatlan_futes');

        $view->add_links(array('datatable', 'bootbox', 'datatable_lists'));
        $view->render('datatables/tpl_futes', $data);
    } 
    
    /**
     * Ingatlan energetikai besorolás
     *
     * @return void
     */
    public function ingatlan_energetika()
    {
        $view = new View();

        $data['title'] = 'Energetika oldal';
        $data['description'] = 'Energetika oldal description';
        $data['energetika'] = $this->datatables_model->get_jellemzo_list('ingatlan_energetika');

        $view->add_links(array('datatable', 'bootbox', 'datatable_lists'));
        $view->render('datatables/tpl_energetika', $data);
    } 
    
    /**
     * Ingatlan kert kategória
     *
     * @return void
     */
    public function ingatlan_kert()
    {
        $view = new View();
        
        $data['title'] = 'Kert oldal';
        $data['description'] = 'Kert description';
        $data['kert'] = $this->datatables_model->get_jellemzo_list('ingatlan_kert');

        $view->add_links(array('datatable', 'bootbox', 'datatable_lists'));
        $view->render('datatables/tpl_kert', $data);
    }      

    /**
     * Ingatlan kilátás kategória
     *
     * @return void
     */
    public function ingatlan_kilatas()
    {
        $view = new View();

        $data['title'] = 'Kilátás oldal';
        $data['description'] = 'Kilátás description';
        $data['kilatas'] = $this->datatables_model->get_jellemzo_list('ingatlan_kilatas');

        $view->add_links(array('datatable', 'bootbox', 'datatable_lists'));
        $view->render('datatables/tpl_kilatas', $data);
    }    
    
    /**
     * Ingatlan parkolás kategória
     *
     * @return void
     */
    public function ingatlan_parkolas()
    {
        $view = new View();

        $data['title'] = 'Parkolás oldal';
        $data['description'] = 'Parkolás description';
        $data['parkolas'] = $this->datatables_model->get_jellemzo_list('ingatlan_parkolas');

        $view->add_links(array('datatable', 'bootbox', 'datatable_lists'));
        $view->render('datatables/tpl_parkolas', $data);
    }
    
    /**
     * Ingatlan szerkezet kategória
     *
     * @return void
     */
    public function ingatlan_szerkezet()
    {
        $view = new View();

        $data['title'] = 'Szerkezet oldal';
        $data['description'] = 'Szerkezet description';
        $data['szerkezet'] = $this->datatables_model->get_jellemzo_list('ingatlan_szerkezet');

        $view->add_links(array('datatable', 'bootbox', 'datatable_lists'));
        $view->render('datatables/tpl_szerkezet', $data);
    }  
    
    /**
     * Ingatlan szoba_elrendezes
     *
     * @return void
     */
    public function ingatlan_szoba_elrendezes()
    {
        $view = new View();

        $data['title'] = 'Szoba elrendezés lista';
        $data['description'] = 'Szoba elrendezés lista';
        $data['szoba_elrendezes'] = $this->datatables_model->get_jellemzo_list('ingatlan_szoba_elrendezes');

        $view->add_links(array('datatable', 'bootbox', 'datatable_lists'));
        $view->render('datatables/tpl_szoba_elrendezes', $data);
    }    
    
    /**
     * Ház állípota kívül
     *
     * @return void
     */
    public function ingatlan_haz_allapot_kivul()
    {
        $view = new View();

        $data['title'] = 'Ház állapota kívül oldal';
        $data['description'] = 'Ház állapota kívül description';
        $data['haz_allapot_kivul'] = $this->datatables_model->get_jellemzo_list('ingatlan_haz_allapot_kivul');

        $view->add_links(array('datatable', 'bootbox', 'datatable_lists'));
        $view->render('datatables/tpl_haz_allapot_kivul', $data);
    }  
    
    /**
     * Ház állípota kívül
     *
     * @return void
     */
    public function ingatlan_haz_allapot_belul()
    {
        $view = new View();

        $data['title'] = 'Ház állapota belül oldal';
        $data['description'] = 'Ház állapota belül description';
        $data['haz_allapot_belul'] = $this->datatables_model->get_jellemzo_list('ingatlan_haz_allapot_belul');

        $view->add_links(array('datatable', 'bootbox', 'datatable_lists'));
        $view->render('datatables/tpl_haz_allapot_belul', $data);
    }  

    /**
     * Fürdőszoba WC
     *
     * @return void
     */
    public function ingatlan_furdo_wc()
    {
        $view = new View();

        $data['title'] = 'Fürdő WC oldal';
        $data['description'] = 'Fürdő WC description';
        $data['furdo_wc'] = $this->datatables_model->get_jellemzo_list('ingatlan_furdo_wc');

        $view->add_links(array('datatable', 'bootbox', 'datatable_lists'));
        $view->render('datatables/tpl_furdo_wc', $data);
    }     
    
    /**
     * Fényviszonyok
     *
     * @return void
     */
    public function ingatlan_fenyviszony()
    {
        $view = new View();

        $data['title'] = 'fényviszony oldal';
        $data['description'] = 'fényviszony description';
        $data['fenyviszony'] = $this->datatables_model->get_jellemzo_list('ingatlan_fenyviszony');

        $view->add_links(array('datatable', 'bootbox', 'datatable_lists'));
        $view->render('datatables/tpl_fenyviszony', $data);
    } 

    /**
     * Emeletek lista
     *
     * @return void
     */
    public function ingatlan_emelet()
    {
        $view = new View();

        $data['title'] = 'Ingatlan szintek';
        $data['description'] = 'Ingatalan emeletek listája';
        $data['epulet_emelet'] = $this->datatables_model->get_jellemzo_list('ingatlan_emelet');

        $view->add_links(array('datatable', 'bootbox', 'datatable_lists'));
        $view->render('datatables/tpl_emelet', $data);
    } 
    
    /**
     * 	Jellemző törlése törlése Ajax-szal
     */
    public function ajax_delete()
    {
        if ($this->request->is_ajax()) {
            
            if ($this->request->has_post('action') && $this->request->get_post('action') == 'delete') {
                
                $id = $this->request->get_post('id', 'integer');
                $table = $this->request->get_post('table');
                $id_name = $this->request->get_post('id_name');

                $result = $this->datatables_model->delete($id, $table, $id_name);
                if ($result !== false) {
                    $this->response->json(array("status" => 'success', "message" => 'A törlés megtörtént!'));
                } else {
                    $this->response->json(array("status" => 'error', "message" => 'Nem törölhető, mivel létezik ingatlan ezzel a jellemzővel!'));
                }
            }
        }
    }
    
    /**
     * 	Jellemző update Ajax-szal
     */
    public function ajax_update_insert()
    {
        if ($this->request->is_ajax()) {

            if ($this->request->has_post('action') && $this->request->get_post('action') == 'update_insert') {
                
                $id = $this->request->get_post('id', 'integer');
                $table = $this->request->get_post('table');
                $id_name = $this->request->get_post('id_name');
                // magyar nyelvű oszlop neve
                $leiras_name = $this->request->get_post('leiras_name') . '_hu';
                // asszociatív tömb amelyben a kulcs a leiras_nev_ + nyelvi kód
                $data = $this->request->get_post('data');

                // ha üres string volt elküldve valamelyik nyelvnél
                foreach ($data as $value) {
                    if ($value == '') {
                        $this->response->json(array(
                            'status' => 'error',
                            'message' => 'Nem lehet üres mező!'
                        ));
                        exit;
                    }
                }

                // Kategóriák lekérdezése annak ellenőrzéséhez, hogy már létezik-e ilyen kategória (az id és magyar nyelvű oszlopot kérdezi le)
                $existing_categorys = $this->datatables_model->existingCategorys($table, $id_name, $leiras_name);
              
                // bejárjuk a kategória neveket és összehasonlítjuk az új névvel (kisbetűssé alakítjuk, hogy ne számítson a nagybetű-kisbetű eltérés)
                foreach($existing_categorys as $value) {

                    if (
                        //insert-nél ez teljesülhet
                        ( is_null($id) && strtolower($data[$leiras_name]) == strtolower($value[$leiras_name]) ) || 
                        //update-nél ez teljesülhet
                        ( !is_null($id) && $id != $value[$id_name] && strtolower($data[$leiras_name]) == strtolower($value[$leiras_name]) )
                    ) {
                            $this->response->json(array(
                                'status' => 'error',
                                'message' => 'Már létezik ' . $value[$leiras_name] . ' kategória!'
                            ));
                            exit;
                    }

                }

                $result = $this->datatables_model->update_insert($id, $table, $id_name, $leiras_name, $data);
                if ($result !== false) {
                    $this->response->json(array("status" => 'success', "message" => 'A művelet sikeresen végrehajtva!', 'last_insert_id' => $result));
                } else {
                    $this->response->json(array("status" => 'error', "message" => 'Hiba történt!'));
                }
            }
        }
    }    


/*---------- VÁROSOK LISTA -------------------- */


    /**
     * Városok lista oldal
     */ 
    public function cities()
    {
        // Auth::hasAccess('datatables.city', $this->request->get_httpreferer());
        
        $data['title'] = 'Város hozzáadása oldal';
        $data['description'] = 'Város hozzáadása oldal description';

        // Város model betöltése
        $this->loadModel('city_list_model');
        $this->loadModel('county_list_model');
        $this->loadModel('district_list_model');
        $this->loadModel('user_model');

        $data['agents'] = $this->user_model->getUsersMinData();
        $data['cities'] = $this->city_list_model->findCity();
        $data['districts'] = $this->district_list_model->findDistrict();
        $counties = $this->county_list_model->findCounty();
        $data['counties'] = json_encode($counties);
//var_dump($data);die;
        $view = new View();

        $view->add_links(array('datatable', 'bootbox', 'vframework'));
        $view->add_link('js', ADMIN_JS . 'pages/city_list.js');
        $view->render('datatables/tpl_city', $data);
    }

    /**
     * Város hozzáadása és módosítása (AJAX)
     */
    public function city_insert_update()
    {
        if ($this->request->is_ajax()) {
            // az id értéke lehet null is!
            $id = $this->request->get_post('id', 'integer');
            // megye id 
            $county_id = $this->request->get_post('county_id', 'integer');
            // referens id
            $agent_id = $this->request->get_post('agent_id', 'integer');

            // új városnév 
            $new_name = $this->request->get_post('city_name');
            if ($new_name === '') {
                $this->response->json(array(
                    'status' => 'error',
                    'message' => 'Nem lehet üres a város név mező!'
                ));
            }

        // városok lekérdezése (annak ellenőrzéséhez, hogy már létezik-e ilyen)
            $this->loadModel('city_list_model');
            // lekérdezzük a városokat
            $existing_city = $this->city_list_model->findCity();
            // bejárjuk a város neveket és összehasonlítjuk az új névvel (kisbetűssé alakítjuk, hogy ne számítson a nagybetű-kisbetű eltérés)
            foreach($existing_city as $value) {
                
                if (
                    // insert eset  
                    (is_null($id) && strtolower($new_name) == strtolower($value['city_name'])) ||
                    // update eset
                    (!is_null($id) && $id != $value['city_id'] && strtolower($new_name) == strtolower($value['city_name']))
                ) {
                    $this->response->json(array(
                        'status' => 'error',
                        'message' => 'Már létezik ' . $value['city_name'] . ' nevű város!'
                    ));
                }   
            } 

        //insert (ha az $id értéke null)
            if (is_null($id)) {

                // város létrehozása a city_list táblába
                $last_insert_id = $this->city_list_model->insert(
                    array(
                        'city_name' => $new_name,
                        'county_id' => $county_id,
                        'agent_id' => $agent_id
                    )
                );
                                
                if ($last_insert_id !== false) {
                    
                    $this->response->json(array(
                        'status' => 'success',
                        'message' => 'Város hozzáadva.',
                        'inserted_id' => $last_insert_id
                    ));
                } else { 
                    $this->response->json(array(
                        'status' => 'error',
                        'message' => 'Adatbázis lekérdezési hiba!'
                    ));
                }
            }
        // update
            else {

                $this->city_list_model->update($id,
                    array(
                        'city_name' => $new_name,
                        'county_id' => $county_id,
                        'agent_id' => $agent_id
                    )                    
                );

                $this->response->json(array(
                    'status' => 'success',
                    'message' => 'Város módosítva.'
                ));

            }
        }
    }

    /**
     *  Város törlése (AJAX)
     */
    public function city_delete()
    {
        if($this->request->is_ajax()){

/*
            if(!Auth::hasAccess('datatables.city_delete')){
                $this->response->json(array(
                    'status' => 'error',
                    'message' => 'Nincs engedélye a művelet végrehajtásához!'
                    ));
            }
*/
                
            // city_list model betöltése
            $this->loadModel('city_list_model');
            
            $id = $this->request->get_post('item_id', 'integer');

            // itt megnézzük, hogy törölhető-e a város (ha van hozzárendelve ingtalan, akkor nem)
            if ( !$this->city_list_model->isDeletable($id) ) {
                $this->response->json(array(
                    'status' => 'error',
                    'message' => 'A város nem törölhető, mert van ingatlan hozzárendelve.'
                ));
            }

            // város törlése
            $result = $this->city_list_model->delete($id);
            
            if($result !== false) {
                $this->response->json(array(
                    'status' => 'success',
                    'message' => 'Város törölve.'
                    ));
            }
            else {
                // ha a törlési sql parancsban hiba van
                $this->response->json(array(
                    'status' => 'error',
                    'message' => 'Adatbázis lekérdezési hiba!',                  
                    ));
            }

        } else {
            $this->response->redirect('admin/error');
        }
    }


/*---------- BUDAPEST KERÜLETEK LISTA -------------------- */


    /**
     * Budapest kerületek lista oldal
     */ 
    public function districts()
    {
        // Auth::hasAccess('datatables.city', $this->request->get_httpreferer());
        
        $data['title'] = 'Referens kerülethez rendelése hozzáadása oldal';
        $data['description'] = 'Referens kerülethez rendelése oldal description';

        $this->loadModel('district_list_model');
        $this->loadModel('user_model');

        $data['agents'] = $this->user_model->getUsersMinData();
        $data['districts'] = $this->district_list_model->findDistrict();
//var_dump($data);die;
        $view = new View();

        $view->add_links(array('datatable', 'bootbox', 'vframework'));
        $view->add_link('js', ADMIN_JS . 'pages/district_list.js');
        $view->render('datatables/tpl_district', $data);
    }

    /**
     * Kerület hozzáadása és módosítása (AJAX)
     */
    public function district_insert_update()
    {
        if ($this->request->is_ajax()) {
            // az id értéke lehet null is!
            $id = $this->request->get_post('id', 'integer');

            // referens id
            $agent_id = $this->request->get_post('agent_id', 'integer');

            // új kerület név 
            $new_name = $this->request->get_post('district_name');
            if ($new_name === '') {
                $this->response->json(array(
                    'status' => 'error',
                    'message' => 'Nem lehet üres a kerület név mező!'
                ));
            }

        // Kerületek lekérdezése (annak ellenőrzéséhez, hogy már létezik-e ilyen)
            $this->loadModel('district_list_model');
            // lekérdezzük a városokat
            $existing_districts = $this->district_list_model->findDistrict();
            // bejárjuk a kerület neveket és összehasonlítjuk az új névvel (kisbetűssé alakítjuk, hogy ne számítson a nagybetű-kisbetű eltérés)
            foreach($existing_districts as $value) {
                
                if (
                    // insert eset  
                    (is_null($id) && strtolower($new_name) == strtolower($value['district_name'])) ||
                    // update eset
                    (!is_null($id) && $id != $value['district_id'] && strtolower($new_name) == strtolower($value['district_name']))
                ) {
                    $this->response->json(array(
                        'status' => 'error',
                        'message' => 'Már létezik ' . $value['district_name'] . ' nevű kerület!'
                    ));
                }   
            } 

        //insert (ha az $id értéke null)
            if (is_null($id)) {

                // kerület létrehozása a district_list táblába
                $last_insert_id = $this->district_list_model->insert(
                    array(
                        'district_name' => $new_name,
                        'agent_id' => $agent_id
                    )
                );
                                
                if ($last_insert_id !== false) {
                    
                    $this->response->json(array(
                        'status' => 'success',
                        'message' => 'Kerület hozzáadva.',
                        'inserted_id' => $last_insert_id
                    ));
                } else { 
                    $this->response->json(array(
                        'status' => 'error',
                        'message' => 'Adatbázis lekérdezési hiba!'
                    ));
                }
            }
        // update
            else {

                $this->district_list_model->update($id,
                    array(
                        'district_name' => $new_name,
                        'agent_id' => $agent_id
                    )                    
                );

                $this->response->json(array(
                    'status' => 'success',
                    'message' => 'Kerület módosítva.'
                ));

            }
        }
    }

    /**
     *  Kerület törlése (AJAX)
     */
    public function district_delete()
    {
        if($this->request->is_ajax()){

/*
            if(!Auth::hasAccess('datatables.city_delete')){
                $this->response->json(array(
                    'status' => 'error',
                    'message' => 'Nincs engedélye a művelet végrehajtásához!'
                    ));
            }
*/
                
            // district_list model betöltése
            $this->loadModel('district_list_model');
            
            $id = $this->request->get_post('item_id', 'integer');

            // itt megnézzük, hogy törölhető-e a kerület (ha van hozzárendelve ingtalan, akkor nem)
            if ( !$this->district_list_model->isDeletable($id) ) {
                $this->response->json(array(
                    'status' => 'error',
                    'message' => 'A kerület nem törölhető, mert van ingatlan hozzárendelve.'
                ));
            }

            // kerület törlése
            $result = $this->district_list_model->delete($id);
            
            if($result !== false) {
                $this->response->json(array(
                    'status' => 'success',
                    'message' => 'Kerület törölve.'
                    ));
            }
            else {
                // ha a törlési sql parancsban hiba van
                $this->response->json(array(
                    'status' => 'error',
                    'message' => 'Adatbázis lekérdezési hiba!',                  
                    ));
            }

        } else {
            $this->response->redirect('admin/error');
        }
    }


}
?>