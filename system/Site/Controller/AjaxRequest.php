<?php
namespace System\Site\Controller;

use System\Core\SiteController;

class AjaxRequest extends SiteController {

    function __construct()
    {
        parent::__construct();
        //$this->loadModel('ajax_request_model');
    }

    public function index()
    {
        $this->response->redirect('error');
    }
  

}
?>