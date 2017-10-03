<?php

namespace System\Admin\Controller;

use System\Core\AdminController;
//use System\Libs\DI;
//use System\Libs\Message;
use System\Libs\Cookie;
use System\Core\View;

class Ingatlan_ajanlasok extends AdminController {

    function __construct() {
        parent::__construct();
        $this->loadModel('ingatlan_ajanlasok_model');
    }

    public function index() {


        $data['title'] = 'Ingatlan ajanlasok';
        $data['description'] = 'Ingatlan ajanlasok';
        // userek adatainak lekérdezése
        $data['ajanlasok'] = $this->ingatlan_ajanlasok_model->getAjanlasok();
        //var_dump($data);die;
        $view = new View();
        $view->add_links(array('datatable', 'vframework', 'ajanlasok'));
//$view->debug(true);   
        $view->render('ajanlasok/tpl_ingatlan_ajanlasok', $data);
    }

    public function showAjanlas() {
        if ($this->request->is_ajax()) {

            $id = $this->request->get_post('id', 'integer');

            // userek adatainak lekérdezése
            $data = $this->ingatlan_ajanlasok_model->getAjanlas($id);
            $this->response->json(array(
                "name" => $data['name'],
                "email" => $data['email'],
                "html_data" => $data['html_data']
            ));
        }
    }

}

?>