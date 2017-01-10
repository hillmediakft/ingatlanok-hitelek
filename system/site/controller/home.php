<?php
namespace System\Site\Controller;

use System\Core\Site_controller;
use System\Core\View;

class Home extends Site_controller {

    function __construct() {
        parent::__construct();
        $this->loadModel('home_model');
        $this->loadModel('ingatlanok_model');
    }

    public function index()
    {
        $page_data = $this->home_model->getPageData('kezdo_oldal');
        
        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle'];
        $data['description'] = $page_data['metadescription'];
        $data['keywords'] = $page_data['metakeywords'];
        
        
        // a keresőhöz szükséges listák alőállítása
        $data['city_list'] = $this->ingatlanok_model->city_list_query_with_prop_no();
        $data['category_list'] = $this->ingatlanok_model->list_query('ingatlan_kategoria');
        $data['district_list'] = $this->ingatlanok_model->district_list_query_with_prop_no();
        
        // kiemelt ingatlanok
        $data['all_properties'] = $this->ingatlanok_model->kiemelt_properties_query(10);

        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper'));

        //$view->setLazyRender();
//$this->view->debug(true); 
        $view->add_link('js', SITE_JS . 'pages/home.js');
        $view->render('home/tpl_home', $data);
    }
}
?>