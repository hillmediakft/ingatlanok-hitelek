<?php

namespace System\Site\Controller;

use System\Core\SiteController;
use System\Core\View;
use System\Libs\Auth;
use System\Libs\Config;
use System\Libs\Cookie;
use System\Libs\Session;
use System\Libs\Paginator;

class Kedvencek extends SiteController {

    public function __construct() {
        parent::__construct();
        $this->loadModel('kedvencek_model');
        $this->loadModel('ingatlanok_model');
    }

    public function index()
    {
        if (!Auth::isUserLoggedIn()) {
            $this->response->redirect();
        }

        $page_data = $this->ingatlanok_model->getPageData('kedvencek');

        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle_' . $this->lang];
        $data['description'] = $page_data['metadescription_' . $this->lang];
        $data['keywords'] = $page_data['metakeywords_' . $this->lang];

        if (count(json_decode(Cookie::get('kedvencek'))) > 0) {
            $data['properties'] = $this->kedvencek_model->get_favourite_properties(json_decode(Cookie::get('kedvencek')));
        } else {
            $data['properties'] = array();
        }

        // a keresőhöz szükséges listák alőállítása
        $data['city_list'] = $this->ingatlanok_model->city_list_query_with_prop_no();
        $data['district_list'] = $this->ingatlanok_model->district_list_query_with_prop_no();
        $data['category_list'] = $this->ingatlanok_model->list_query('ingatlan_kategoria');

        // szűrési paramétereket tartalmazó tömb
        $data['filter_params'] = $this->ingatlanok_model->get_filter_params(Session::get('ingatlan_filter'));
//var_dump($data['filter_params']);        
        // kiemelt ingatlanok
        $data['kiemelt_ingatlanok'] = $this->ingatlanok_model->kiemelt_properties_query(4);

        $data['agents'] = $this->ingatlanok_model->get_agent();
// var_dump($data);die;


        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper', 'num_helper', 'html_helper'));

        //$view->setLazyRender();
//$this->view->debug(true); 
        $view->add_links(array('bootstrap-select'));
        $view->add_link('js', SITE_JS . 'pages/handle_search.js');
        $view->add_link('js', SITE_JS . 'pages/kedvencek.js');
        $view->render('kedvencek/tpl_kedvencek', $data);
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
            $result = $this->ingatlanok_model->refresh_kedvencek_cookie($id);
            if ($result) {
                $this->response->json(array(
                    'status' => 'success',
                    'message' => 'Az ingatlan hozzáadása a kedvencekhez megtörtént'
                ));
            }
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
            $result = $this->kedvencek_model->delete_property_from_cookie($id);
            if ($result) {
                $this->response->json(array(
                    'status' => 'success',
                    'message' => 'Az ingatlan törlése a kedvencek közül megtörtént!'
                ));
            }
        } else {
            exit();
        }
    }

}

?>