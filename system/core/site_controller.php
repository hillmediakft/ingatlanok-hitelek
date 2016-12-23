<?php

namespace System\Core;

class Site_controller extends Controller {

    protected $global_data = array();
    
    public function __construct() {
        parent::__construct();

        // settings betöltése és hozzárendelése a controllereken belül elérhető a global_data változóhoz
        $this->loadModel('settings_model');
        $this->global_data['settings'] = $this->settings_model->get_settings();

 // var_dump($this->global_data['settings']);
 // die();
    }
}
?>