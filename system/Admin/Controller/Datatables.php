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

}
?>