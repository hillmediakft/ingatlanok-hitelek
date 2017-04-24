<?php

namespace System\Site\Controller;

use System\Core\SiteController;

class GetPhoneNumber extends SiteController {

    public function __construct() {
        parent::__construct();
        $this->loadModel('GetPhoneNumber_model');
    }

	/**
     * 	Telefonszám lekérdezése és visszaadása
	 * 	@return string a telefonszám
     */
    public function index() {
		if ($this->request->is_ajax() && $this->request->has_post('id')) {
			$phone_number = $this->GetPhoneNumber_model->get_phone($this->request->get_post('id'));
            echo $phone_number[0]['phone'];
		}
    }
}
?>