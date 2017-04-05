<?php
namespace System\Admin\Controller;
use System\Core\AdminController;
use System\Libs\DI;
use System\Libs\Message;
use System\Libs\Cookie;
use System\Core\View;

class Login extends AdminController {
    /**
     * Construct this object by extending the basic Controller class
     */
    function __construct()
    {
        parent::__construct();
        //$this->loadModel('login_model');
    }

	
    /**
     * Default action
	 *
	 * Ez a metódus jeleníti meg a bejelentkezési oldalt!
	 * Ha a bejelentkezési adatok helyesek, bejelentkezteti a felhasználót	
     */
    public function index()
    {
  
        // ha elküldték a POST adatokat
        if($this->request->has_post()) {
            
            $username = $this->request->get_post('user_name');
            $password = $this->request->get_post('user_password');
            $rememberme = $this->request->has_post('user_rememberme');

            // $auth = Auth::instance();
            $auth = DI::get('auth');
            $login_successful = $auth->login($username, $password, $rememberme);

            // login status vizsgálata
            if ($login_successful) {



// log id cookie-ba
$this->loadModel('logs_model');
if (Cookie::exists('last_log_id')) {
    $last_log_id = (int)Cookie::get('last_log_id');
    $last_log_number = $this->logs_model->lastLogs($last_log_id);
    if ($last_log_number > 0) {
        $last_log_number = $last_log_number + Cookie::get('last_log_number');
        Cookie::set('last_log_number', $last_log_number, -1);
        $last_log_id = $this->logs_model->lastLogId();
        Cookie::set('last_log_id', $last_log_id, -1);
    }

} else {
    $last_log_number = $this->logs_model->lastLogs();
    Cookie::set('last_log_number', $last_log_number, -1);
    
    $last_log_id = $this->logs_model->lastLogId();
    Cookie::set('last_log_id', $last_log_id, -1);
}                


                // Sikeres bejelentkezés
                $this->response->redirect('admin');
            }
            // Sikertelen bejelentkezés
            else {
                // hibaüzenetek visszaadása
                foreach ($auth->getError() as $value) {
                    Message::set('error', $value);
                }
                // visszairányítás
                $this->response->redirect('admin/login');
			}			
		}

/*
            // bejelentkezés cookie-val
            $auth = DI::get('auth');
            $login_status = $auth->loginWithCookie();
            if ($login_status) {
                $this->response->redirect('admin');
            } else {
                foreach ($auth->getError() as $value) {
                   Message::set('error', $value);
                }
                // cookie törlése
                $auth->deleteCookie();
            }
*/

        $view = new View();
        $view->set_layout(null);
		$view->render('login/tpl_login');
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

}
?>