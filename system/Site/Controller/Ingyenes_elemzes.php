<?php
namespace System\Site\Controller;
use System\Core\SiteController;
use System\Core\View;

class Ingyenes_elemzes extends SiteController {

    function __construct()
    {
        parent::__construct();
        $this->loadModel('ingyenes_elemzes_model');
    }

    public function index()
    {
        $page_data = $this->ingyenes_elemzes_model->getPageData('ingyenes-elemzes');
        
        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle_' . $this->lang];
        $data['description'] = $page_data['metadescription_' . $this->lang];
        $data['keywords'] = $page_data['metakeywords_' . $this->lang];
        $data['body'] = $page_data['body_' . $this->lang];


        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper'));
		$view->add_link('js', SITE_JS . 'pages/ingyenes_elemzes.js');
        $view->set_layout('tpl_layout_ingyenes_elemzes');
        $view->render('ingyenes_elemzes/tpl_ingyenes_elemzes', $data);
    }

}
?>