<?php

namespace System\Site\Controller;

use System\Core\Site_controller;
use System\Core\View;

class Error extends Site_controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {

        $data['title'] = 'A keresett oldla nem található';
        $data['description'] = 'A keresett oldla nem található';
        $data['keywords'] = '404 hiba';

        foreach ($this->global_data as $key => $value) {
            $data[$key] = $value;
        }

        $view = new View();
        $view->setHelper(array('url_helper'));
        $this->response->setHeader('HTTP/1.0', '404 Not Found');
        $this->response->sendHeaders();
        $view->render('error/404', $data);
    }

}

?>