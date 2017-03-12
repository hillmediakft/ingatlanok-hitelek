<?php 
namespace System\Site\Controller;

use System\Core\SiteController;
use System\Core\View;
use System\Libs\Config;
use System\Libs\Session;
use System\Libs\Message;
use System\Libs\Auth;
use System\Libs\DI;
use System\Libs\Validate;

class Profile extends SiteController {

	function __construct()
	{
		parent::__construct();
		$this->loadModel('user_model');
		$this->loadModel('kereses_model');
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

		// ingatlanok model betöltése
		$this->loadModel('ingatlanok_model');
        
        // bejelentkezett user adatainak lekérdezése
        $data['user'] = $this->user_model->selectUser($id);
        // követett ingatlanok adatainak lekérdezése
        $data['properties'] = $this->ingatlanok_model->followedByProperty($id);
        // mentett keresés adatok lekérdezése
        $url_arr = $this->kereses_model->selectSavedSearch($id);

// mentett keresés adatait állítjuk össze
        $data['saved_search'] = array();
        //$url_helper = DI::get('url_helper');
        foreach ($url_arr as $key => $url) {
        	
	        $url_parts = parse_url($url);
	        parse_str($url_parts['query'], $query_arr);
        	//$temp = $url_helper->infoFromUrl($url);
	        
        	if ($query_arr['tipus'] == 1) {
        		$tipus = (LANG == 'hu') ? 'Eladó' : 'For sale';
        	} else {
        		$tipus = (LANG == 'hu') ? 'Kiadó' : 'For rent';
        	}

	        $city_name = '';
	        if (!empty($query_arr['varos'])) {
        		$city_name = $this->ingatlanok_model->selectCityName($query_arr['varos']);
	        }

	        $string = $tipus;
	        $string .= (!empty($city_name)) ? ' - ' . $city_name : '';
        	        
	        $category_name = '';
	        if (!empty($query_arr['kategoria'])) {
        		$category_name = $this->ingatlanok_model->selectCategoryName($query_arr['kategoria']);
	        }

	        $string .= (!empty($category_name)) ? ' - ' . $category_name : '';

	        $data['saved_search'][] = array(
	        	'id' => $key,
	        	'description' => $string,
	        	'url' => $url
	        	);
        }


        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper', 'num_helper', 'html_helper'));

//$this->view->debug(true); 
        $view->add_links(array('validation'));
        $view->add_link('js', SITE_JS . 'pages/profile.js');
        $view->render('profile/tpl_profile', $data);        	
	}

	/**
	 * Mentett keresés törlése
	 */
	public function deleteSavedSearch()
	{
		if ($this->request->is_ajax()) {
			$record_id = $this->request->get_post('record_id');
			$user_id = (int)Auth::getUser('id');

			if (is_null($user_id)) {
				$this->response->json(array(
					'status' => 'error',
					'message' => 'Nincs bejelentkezve a felhasználó!'
					));	
			}

			$result = $this->kereses_model->deleteSavedSearch($record_id);

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

			$this->loadModel('arvaltozas_model');

			$result = $this->arvaltozas_model->deleteFollowed($property_id, $user_id);

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

	/**
	 * Jelszó megváltoztatása
	 */
	public function changePassword()
	{
		if ($this->request->is_ajax()) {

			$password_new = $this->request->get_post('password_new');
			$password_new_again = $this->request->get_post('password_new_again');
			$password_old = $this->request->get_post('password_old');

			if (empty($password_new) || empty($password_new_again) || empty($password_old)) {
				$this->response->json(array(
					'status' => 'error',
					'message' => 'Minden jelszó mezőt ki kell töltenie!'
					));
		    }
		    if ($password_new != $password_new_again) {
				$this->response->json(array(
					'status' => 'error',
					'message' => 'A két új jelszónak meg kell egyeznie!'
					));
		    }


			//bejelentkezett user id-je
			$user_id = Auth::getUser('id');
			// user adatainak lekérdezése
			$user_data = $this->user_model->selectUser($user_id);

			// jelszó kompatibilitás library betöltése régebbi php verzió esetén
			$this->user_model->load_password_compatibility();
			// crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character
			// hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4,
			// by the password hashing compatibility library. the third parameter looks a little bit shitty, but that's
			// how those PHP 5.5 functions want the parameter: as an array with, currently only used with 'cost' => XX
			$hash_cost_factor = (Config::get('hash_cost_factor') !== null) ? Config::get('hash_cost_factor') : null;


			// régi jelszó tesztelése
			if (!password_verify($password_old, $user_data['password_hash'])) {
				$this->response->json(array(
					'status' => 'error',
					'message' => 'A régi jelszó nem helyes!'
					));
			}

			// új jelszó titkosítva
			$new_password_hash = password_hash($password_new, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));

			// új password hash adatbázisba írása
			$result = $this->user_model->update($user_id, array('password_hash' => $new_password_hash));

			if ($result !== false) {
				$this->response->json(array(
					'status' => 'success',
					'message' => 'Új jelszó mentése sikeres!'
					));
			} else {
				$this->response->json(array(
					'status' => 'error',
					'message' => Message::show('unknown_error')
					));				
			}

		} else {
			$this->response->redirect('error');
		}
		
	}

	/**
	 * Felhasználói név vagy email cím megváltoztatása
	 */
	public function changeUserdata()
	{
		if ($this->request->is_ajax()) {
			$new_name = $this->request->get_post('name');
			$new_email = $this->request->get_post('email');
			
			//bejelentkezett user id-je
			$user_id = Auth::getUser('id');
			//Megvizsgáljuk, hogy van-e már ilyen nevű user, de nem az amit módosítani akarunk
			$result_name = $this->user_model->checkUserNoLoggedIn($user_id, $new_name);
			
			if ($result_name) {
				$this->response->json(array(
					'status' => 'error',
					'message' => 'Már létezik ilyen felhasználó név!'
					));
			}

			//Megvizsgáljuk, hogy van-e már ilyen email cím (de nem az amit módosítani akarunk)
			$result_email = $this->user_model->checkEmailNoLoggedIn($user_id, $new_email);
			if ($result_email) {
				$this->response->json(array(
					'status' => 'error',
					'message' => 'Már létezik ilyen e-mail cím!'
					));
			}

			// update rekord
			$update = $this->user_model->update($user_id, array(
				'name' => $new_name,
				'email' => $new_email
				));

			if ($update !== false) {

		        Session::set('user_data.name', $new_name);				
		        Session::set('user_data.email', $new_email);				

				$this->response->json(array(
					'status' => 'success',
					'message' => 'A felhasználó adatai módosítva!',
					'new_name' => $new_name
					));
			}


		} else {
			$this->response->redirect('error');
		}
		
	}

}
?>