<?php 
namespace System\Site\Controller;

use System\Core\SiteController;
use System\Core\View;
use System\Libs\Config;
use System\Libs\Message;
use System\Libs\Auth;
use System\Libs\DI;
use System\Libs\Validate;
use System\Libs\Session;

class User extends SiteController {

	private $email_verify = true;

	function __construct()
	{
		parent::__construct();
		$this->loadModel('user_model');
	}

	/**
	 *	Ne legyen 'sima' user oldal
	 */
	public function index()
	{
		$this->response->redirect('site/error');
	}

	/**
	 *	Felhasználó bejelentkezés
	 */
	public function login()
	{
		if($this->request->is_ajax()){

	        // ha elküldték a POST adatokat
	        if($this->request->has_post()) {
//echo "Siker teaszt";die;
	            
	            $username = $this->request->get_post('user_name');
	            $password = $this->request->get_post('user_password');
	            $rememberme = $this->request->has_post('user_rememberme');

	            // $auth = Auth::instance();
	            $auth = DI::get('auth');
	            $login_successful = $auth->login($username, $password, $rememberme);

				// login status vizsgálata
				if ($login_successful) {
	                // Sikeres bejelentkezés esetén ez megy vissza a javascriptnek
					$this->response->json(array(
						'status' => 'logged_in'
					));
	                //$this->response->redirect('site');
	            }
	            // Sikertelen bejelentkezés
	            else {
	                // hibaüzenetek visszaadása
	                foreach ($auth->getError() as $value) {
	                    //Message::set('error', $value);
	                    $error_messages[] = Message::show($value);
	                }
	                // üzenet a javascriptnek
	                $this->response->json(array(
						'status' => 'error',
						'message' => $error_messages
					));
	                //$this->response->redirect('site');
				}			
			}

/*
	            // bejelentkezés cookie-val
	            $auth = DI::get('auth');
	            $login_status = $auth->loginWithCookie();
	            if ($login_status) {
	                $this->response->redirect('site');
	            } else {
	                foreach ($auth->getError() as $value) {
	                   Message::set('error', $value);
	                }
	                // cookie törlése
	                $auth->deleteCookie();
	            }
*/


		} else {
			$this->response->redirect('site/error');
		}
	}
    
    /**
     * Kijelentkezés
     */
    public function logout()
    {
        DI::get('auth')->logout();
        // átirányítás a front-oldalra
        $this->response->redirect();
    }  
	
	/**
	 *	Új felhasználó regisztrációja
	 */
	public function register()
	{
		if($this->request->has_post('submit_new_user')) {

	        // adatok a $_POST tömbből
	        $post_data = $this->request->get_post();

	        // validátor objektum létrehozása
	        $validate = new Validate();

	        // szabályok megadása az egyes mezőkhöz (mező neve, label, szabály)
	        $validate->add_rule('name', 'username', array(
	            'required' => true,
	            'min' => 2
	        ));
	        $validate->add_rule('first_name', 'userfirstname', array(
	            'required' => true,
	            'min' => 2
	        ));
	        $validate->add_rule('last_name', 'userlastname', array(
	            'required' => true,
	            'min' => 2
	        ));
	        $validate->add_rule('password', 'password', array(
	            'required' => true,
	            'min' => 6
	        ));
	        $validate->add_rule('password_again', 'password_again', array(
	            'required' => true,
	            'matches' => 'password'
	        ));
	        $validate->add_rule('email', 'email', array(
	            'required' => true,
	            'email' => true
	            // 'max' => 64
	        ));        

	        // üzenetek megadása az egyes szabályokhoz (szabály_neve, üzenet)
	        $validate->set_message('required', ':label_field_empty');
	        $validate->set_message('min', ':label_too_short');
	        $validate->set_message('matches', ':label_repeat_wrong');
	        $validate->set_message('email', ':label_does_not_fit_pattern');
	        //$validate->set_message('max', ':label_too_long');

	        // mezők validálása
	        $validate->check($post_data);

	        // HIBAELLENŐRZÉS - ha valamilyen hiba van a form adataiban
	        if(!$validate->passed()){
	            foreach ($validate->get_error() as $error_msg) {
	                Message::set('error', $error_msg);
	            }
	            $this->response->redirect('admin/user/insert');
	        }
	        else {
	        // végrehajtás, ha nincs hiba 
	            $user = array();
	            $user['name'] = $this->request->get_post('name');
	            $user['first_name'] = $this->request->get_post('first_name');
	            $user['last_name'] = $this->request->get_post('last_name');
	            $user['email'] = $this->request->get_post('email');
	            $user['phone'] = $this->request->get_post('phone');

	            if (empty($this->request->get_post('img_url'))) {
	                $user['photo'] = Config::get('user.default_photo');
	            } else {
	                $path_parts = pathinfo($this->request->get_post('img_url'));
	                $user['photo'] = $path_parts['filename'] . '.' . $path_parts['extension'];
	            }

	            $user['role_id'] = $this->request->get_post('user_group', 'integer');
	            $user['provider_type'] = ($this->request->get_uri('area') == 'admin') ? 'admin' : null;

	                // jelszó kompatibilitás library betöltése régebbi php verzió esetén
	                $this->user_model->load_password_compatibility();
	                // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character
	                // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4,
	                // by the password hashing compatibility library. the third parameter looks a little bit shitty, but that's
	                // how those PHP 5.5 functions want the parameter: as an array with, currently only used with 'cost' => XX
	                $hash_cost_factor = (Config::get('hash_cost_factor') !== null) ? Config::get('hash_cost_factor') : null;

	            $user['password_hash'] = password_hash($this->request->get_post('password'), PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));

	                // ellenőrzés, hogy létezik-e már ilyen felhasználói név az adatbázisban
	                if ($this->user_model->checkUsername($user['name'])) {
	                    Message::set('error', 'username_already_taken');
	                    $this->response->redirect('admin/user/insert');
	                }

			        if(!is_null($user['email'])){
		                // ellenőrzés, hogy létezik-e már ilyen email cím az adatbázisban
		                if ($this->user_model->checkEmail($user['email'])) {
		                    Message::set('error', 'user_email_already_taken');
		                    $this->response->redirect('admin/user/insert');
		                }
			        }

	            // ha be van állítva e-mail ellenőrzéses regisztráció
	            if ($this->email_verify === true) {
	                // generate random hash for email verification (40 char string)
	                $user['activation_hash'] = sha1(uniqid(mt_rand(), true));
	                $user['active'] = 0;
	            } else {
	                $user['activation_hash'] = null;
	                $user['active'] = 1;
	            }
	            // generate integer-timestamp for saving of account-creating date
	            $user['creation_timestamp'] = time();


	            // Új felhasználó adatainak beírása az adatbázisba
	            $last_inserted_id = $this->user_model->insert($user);
	            if (!$last_inserted_id) {
	                Message::set('error', 'account_creation_failed');
	                $this->response->redirect('admin/user/insert');
	            }

	            // Ezután jön az ellenörző email küldés (ha az $email_verify tulajdonság értéke true)
	            // ha sikeres az ellenőrzés, visszatér true-val, ellenkező esetben a visszatér false-al
	            if ($this->email_verify === true) {

	                // ellenőrző email küldése, ha az ellenőrző email küldése sikertelen: felhasználó törlése az databázisból
	                if ($this->user_model->_sendVerificationEmail($last_inserted_id, $user['email'], $user['activation_hash'])) {
	                    Message::set('success', 'account_successfully_created');
	                } else {
	                    $this->user_model->delete($last_inserted_id);
	                    Message::set('error', 'verification_mail_sending_failed');
	                    $this->response->redirect('admin/user/insert');
	                }
	            }

	            // ha nincs email ellenőrzés, és minden ellenőrzés sikeres, akkor visszatér true-val
	            Message::set('success', 'user_successfully_created');
	            $this->response->redirect('admin/user');
	        }
		}
	}



	/**
	 *	Új jelszó küldése a felhasználónak (elfelejtett jelszó esetén)
     *  - lekérdezi, hogy van-e a $_POST-ban kapott email címmel rendelkező felhasználó
     *  - generál egy 8 karakter hosszú jelszót és egy new_password_hash-t
     *  - az új password hash-t az adatbázisba írja
     *  - elküldi email-ben az új jelszót a felhasználónak
     *  - ha az email küldése sikertelen, visszaírja az adatbázisba a régi password hash-t
	 */
	public function forgottenpw()
	{
		if($this->request->is_ajax()){
            
            // a felhasználó email címe, amire küldjük az új jelszót
            $to_email = $this->request->get_post('user_email');
            
            // lekérdezzük, hogy ehhez az email címhez tartozik-e user (lekérdezzük a nevet, és a password hash-t)
            $result = $this->user_model->getPasswordHash($to_email);
                // ha nincsen ilyen e-mail címmel regisztrált felhasználó 
                if(empty($result)){
                    $message = array(
                      'status' => 'error',
                      'message' => 'Nincsen ilyen e-mail címmel regisztrált felhasználó!'
                    );
                    echo json_encode($message);
                    exit();                
                }
            
            $to_name = $result[0]['name'];
            $old_pw = $result[0]['password_hash'];
                  
                // 8 karakter hosszú új jelszó generálása (str_shuffle összekeveri a stringet, substr levágja az első 8 karaktert)
                $new_password = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);
                $hash_cost_factor = (Config::get('hash_cost_factor') !== null) ? Config::get('hash_cost_factor') : null;
                $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));            
            
            // új jelszó hash beírása az adatbázisba
            $result = $this->user_model->setNewPassword($to_email, $new_password_hash);
                // ha hiba történt a adatbázisba íráskor
                if($result === false){
                    $message = array(
                        'status' => 'error',
                        'message' => 'Adatbázis hiba!'
                    );
                    echo json_encode($message);
                    exit();    
                }
            
            
// email küldés !!!!!!!!!!



            if ($result) {
                $message = array(
                  'status' => 'success',
                  'message' => 'Új jelszó elküldve!'
                );
                echo json_encode($message);
                exit();
            } else {
                // régi password hash visszaírása az adatbázisba
                $this->user_model->setNewPassword($to_email, $old_pw);
                
                $message = array(
                  'status' => 'error',
                  'message' => 'Az új jelszó küldése sikertelen!'
                );
                echo json_encode($message);
                exit();
            }

		} else {
			$this->response->redirect('admin/error');	
		}
		
	}   





}
?>