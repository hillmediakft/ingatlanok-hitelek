<?php
namespace System\Core;
use System\Libs\Auth;

class SiteController extends Controller {

	/**
	 * Minden site oldalon megjelenő adatokat tartalmazó tömb
	 */
    protected $global_data = array();

    /**
     * Minden site controllerben elérhető, és a nyelvi kódot tartalmazza
     */
    protected $lang = LANG;
    
    /**
     * Minden site oldali controllerben lefut
     */
    public function __construct()
    {
        parent::__construct();

        // megnézzük, hogy be van-e jelentkezve a user 
        if (Auth::isUserLoggedIn()) {
            // megnézzük, hogy lejárt-e a session időkorlát 
            if (!Auth::checkExpire()) {
                $this->response->redirect($this->request->get_uri('current_url'));
            }
        }

        // settings betöltése és hozzárendelése a controllereken belül elérhető a global_data változóhoz
        $this->loadModel('settings_model');
        $this->global_data['settings'] = $this->settings_model->get_settings();


        $this->loadModel('pop_up_window_model');
        $pop_up_window = $this->pop_up_window_model->get_pop_up_window();
        if(!empty($pop_up_window)) {
        $this->global_data['pop_up_window_title'] = $pop_up_window['title'];
        $this->global_data['pop_up_window_content'] = $pop_up_window['content'];
        $this->global_data['pop_up'] = true;
        } else {
            $this->global_data['pop_up'] = false;
        }        
        
        
    }
}
?>