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
		$this->loadModel('ingatlanok_model');
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

        $id = (int)Auth::getUser('id');
        // ha nincs bejelentkezve
        if (is_null($id)) {
        	$this->response->redirect('error');
        }

        $data['user'] = $this->user_model->selectUser($id);

        $data['properties'] = $this->ingatlanok_model->followedByProperty($id);

        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper', 'num_helper', 'html_helper'));

//$this->view->debug(true); 
        //$view->add_links(array('bootstrap-select'));
        $view->add_link('js', SITE_JS . 'pages/profile.js');
        $view->render('profile/tpl_profile', $data);        	
	}

	/**
	 * Követett ingatlan törlése
	 */
	public function deleteFollowed()
	{
		if ($this->request->is_ajax()) {
			$property_id = $this->request->get_post('ingatlan_id', 'integer');
			$user_id = (int)Auth::getUser('id');

			if (is_null($user_id)) {
				$this->response->json(array(
					'status' => 'error',
					'message' => 'Nincs bejelentkezve a felhasználó!'
					));	
			}

			$result = $this->ingatlanok_model->deleteFollowed($property_id, $user_id);

			if ($result === 1) {
				$this->response->json(array(
					'status' => 'success',
					'message' => ''
					));
			} else {
				$this->response->json(array(
					'status' => 'error',
					'message' => 'Adatbázis lekérdezési hiba!'
					));				
			}

		} else {
			$this->response->redirect('error');
		}
	}

}
?>