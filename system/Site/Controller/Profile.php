<?php 
namespace System\Site\Controller;

use System\Core\SiteController;
use System\Core\View;
use System\Libs\Config;
use System\Libs\Auth;
use System\Libs\DI;
use System\Libs\Validate;

class Profile extends SiteController {

	function __construct()
	{
		parent::__construct();
		$this->loadModel('user_model');
	}

	/**
	 *	Profil oldal
	 */
	public function index()
	{
        $page_data = $this->user_model->getPageData('profil');
        
        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle_' . $this->lang];
        $data['description'] = $page_data['metadescription_' . $this->lang];
        $data['keywords'] = $page_data['metakeywords_' . $this->lang];	


        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper'));

//$this->view->debug(true); 
        //$view->add_links(array('bootstrap-select'));
        //$view->add_link('js', SITE_JS . 'pages/profile.js');
        $view->render('profile/tpl_profile', $data);        	
	}

}
?>