<?php

namespace System\Site\Controller;

use System\Core\SiteController;
use System\Libs\Auth;

class AjaxRequest extends SiteController {

    function __construct() {
        parent::__construct();
        //$this->loadModel('ajax_request_model');
    }

    public function index() {
        $this->response->redirect('error');
    }

    public function kedvencek() {
        if (!Auth::isUserLoggedIn()) {
            $this->response->json(array(
                "status" => 'error',
                "title" => 'Be kell jelentkeznie!',
                "message" => 'jelentkezz be a kedvencek megtekintéséhez!'
            ));
        } else {
            
            $this->response->json(array(
                "redirect" => (LANG == 'hu') ? 'kedvencek' : LANG . '/favourites'
            ));

        }
    }

}

?>