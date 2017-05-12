<?php
namespace System\Site\Controller;

use System\Core\SiteController;
use System\Core\View;

class Error extends SiteController {

    function __construct()
    {
        parent::__construct();
        $this->loadModel('error_model');
    }

    public function index() {
        
        $page_data = $this->error_model->getPageData('error');
        
        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle_' . $this->lang];
        $data['description'] = $page_data['metadescription_' . $this->lang];
        $data['keywords'] = $page_data['metakeywords_' . $this->lang];
        
        $view = new View();
        $view->setHelper(array('url_helper'));

        //$view->setLazyRender();
//$this->view->debug(true); 
        $this->response->setHeader('HTTP/1.0', '404 Not Found');
        $this->response->sendHeaders();
        $view->render('error/404', $data);
    }
	
    public function nem_talalhato_az_ingatlan() {
        
        $page_data = $this->error_model->getPageData('error');
        
        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle_' . $this->lang];
        $data['description'] = $page_data['metadescription_' . $this->lang];
        $data['keywords'] = $page_data['metakeywords_' . $this->lang];
        
        $view = new View();
        $view->setHelper(array('url_helper'));
		
        //$view->setLazyRender();
//$this->view->debug(true); 
        $this->response->setHeader('HTTP/1.0', '404 Not Found');
        $this->response->sendHeaders();
        $view->render('error/nem_talalhato_az_ingatlan', $data);
    }	

}

?>