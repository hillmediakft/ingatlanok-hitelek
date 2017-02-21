<?php

namespace System\Site\Controller;

use System\Core\SiteController;
use System\Libs\Config;
use System\Libs\Cookie;
use System\Libs\Session;
use System\Libs\Paginator;

class Kedvencek extends SiteController {

    public function __construct() {
        parent::__construct();
        // kedvencek lekérdezése
        $this->loadModel('ingatlanok_model');
    }
    
    public function index()
    {
        $page_data = $this->ingatlanok_model->getPageData('ingatlanok');
        
        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle_' . $this->lang];
        $data['description'] = $page_data['metadescription_' . $this->lang];
        $data['keywords'] = $page_data['metakeywords_' . $this->lang];


// paginátor objektum létrehozása
        $pagine = new Paginator('p', $data['settings']['pagination']);
// limit-el lekérdezett adatok szűréssel (paraméterek bekerülnek a 'ingatlan_filter' session elembe)
        $data['properties'] = $this->ingatlanok_model->properties_filter_query($pagine->get_limit(), $pagine->get_offset(), $this->request->get_query());
// összes elem, ami a szűrési feltételnek megfelel (vagy a tábla összes rekordja, ha nincs szűrés)
        $data['filtered_count'] = $this->ingatlanok_model->properties_filter_count_query();
// összes elem megadása a paginátor objektumnak
        $pagine->set_total($data['filtered_count']);
// lapozó linkek visszadása (paraméter az uri path)
        $data['pagine_links'] = $pagine->page_links($this->request->get_uri('path'));

        // a keresőhöz szükséges listák alőállítása
        $data['city_list'] = $this->ingatlanok_model->city_list_query_with_prop_no();
        $data['district_list'] = $this->ingatlanok_model->district_list_query_with_prop_no();
        $data['category_list'] = $this->ingatlanok_model->list_query('ingatlan_kategoria');


        // összes ingatlan száma a táblában
        $data['no_of_properties'] = $this->ingatlanok_model->get_count();
        // szűrési paramétereket tartalmazó tömb
        $data['filter_params'] = $this->ingatlanok_model->get_filter_params(Session::get('ingatlan_filter'));
//var_dump($data['filter_params']);        
        // kiemelt ingatlanok
        $data['kiemelt_ingatlanok'] = $this->ingatlanok_model->kiemelt_properties_query(4);

        $data['agents'] = $this->ingatlanok_model->get_agent();
// var_dump($data);die;


        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper'));

        //$view->setLazyRender();
//$this->view->debug(true); 
        $view->add_links(array('bootstrap-select'));
        $view->add_link('js', SITE_JS . 'pages/handle_search.js');
        $view->add_link('js', SITE_JS . 'pages/ingatlanok.js');
        $view->add_link('js', SITE_JS . 'kedvencek.js');
        $view->render('ingatlanok/tpl_ingatlanok', $data);
    }    
    

    /**
     * 	lekérdezi a kedvencek cookie-ban szereplő kedvencekat 
     */
    public function get_favourite_properties() {

        $id_array = json_decode(Cookie::get('kedvencek'));

        if ($id_array) {
            $result = $this->ingatlanok_model->get_favourite_properties_data($id_array);
            return $result;
        } else {
            return array();
        }
    }

    /**
     * 	hozzáadja az ingatlan id-t a kedvencek cookie-hoz  
     */
    public function add_property_to_cookie() {
        if ($this->request->is_ajax() && $this->request->has_post('ingatlan_id')) {
            $id = $this->request->get_post('ingatlan_id', 'integer');
            $this->ingatlanok_model->refresh_kedvencek_cookie($id);
        } else {
            exit();
        }
    }

    /**
     * 	törli az ingatlan id-t a kedvencek cookie-ból  
     */
    public function delete_property_from_cookie() {
        if ($this->request->is_ajax() && $this->request->has_post('ingatlan_id')) {
            $id = $this->request->get_post('ingatlan_id', 'integer');
            $this->kedvencek_model->delete_property_from_cookie($id);
        } else {
            exit();
        }
    }

}

?>