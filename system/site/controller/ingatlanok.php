<?php
namespace System\Site\Controller;

use System\Core\Site_controller;
use System\Core\View;

class Ingatlanok extends Site_controller {

    function __construct()
    {
        parent::__construct();
        $this->loadModel('ingatlanok_model');
    }

    public function index()
    {
        $page_data = $this->ingatlanok_model->getPageData('ingatlanok');
        
        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle_' . $this->lang];
        $data['description'] = $page_data['metadescription_' . $this->lang];
        $data['keywords'] = $page_data['metakeywords_' . $this->lang];
        
        
        // a keresőhöz szükséges listák alőállítása
        $data['city_list'] = $this->ingatlanok_model->city_list_query_with_prop_no();

        $data['category_list'] = $this->ingatlanok_model->list_query('ingatlan_kategoria');

        $view = new View();
        $view->setHelper(array('url_helper'));

        //$view->setLazyRender();
//$this->view->debug(true); 
        $view->add_link('js', SITE_ASSETS . 'pages/ingatlanok.js');
        $view->render('ingatlanok/tpl_ingatlanok', $data);
    }
}
?>