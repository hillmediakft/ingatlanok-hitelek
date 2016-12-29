<?php
namespace System\Site\Controller;

use System\Core\Site_controller;
use System\Core\View;

class Home extends Site_controller {

    function __construct() {
        parent::__construct();
        $this->loadModel('home_model');
    }

    public function index() {
        $page_data = $this->home_model->getPageData('kezdo_oldal');

        $data['title'] = $page_data['metatitle'];
        $data['description'] = $page_data['metadescription'];
        $data['keywords'] = $page_data['metakeywords'];
     
        foreach ($this->global_data as $key => $value) {
            $data[$key] = $value;
        }

        $view = new View();
        $view->setHelper(array('url_helper'));

        //$view->setLazyRender();
//$this->view->debug(true); 
        $view->add_link('js', SITE_ASSETS . 'pages/home.js');
        $view->render('home/tpl_home', $data);
    }
}
?>