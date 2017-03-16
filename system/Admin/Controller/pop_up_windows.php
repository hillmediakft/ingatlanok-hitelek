<?php
namespace System\Admin\Controller;

use System\Core\AdminController;
use System\Core\View;
use System\Libs\Message;
//use System\Libs\Session;
//use System\Libs\Auth;
//use System\Libs\Config;
//use System\Libs\DI;
//use System\Libs\Language as Lang;

class Pop_up_windows extends AdminController {

    function __construct()
    {
        parent::__construct();
        $this->loadModel('pop_up_windows_model');
    }

    public function index()
    {
        //Auth::hasAccess('property.index', $this->request->get_httpreferer());

        $data['title'] = 'Felugró ablakok oldal';
        $data['description'] = 'Felugró ablakok oldal description';
        $data['all_pop_up_windows'] = $this->pop_up_windows_model->selectAll();
// var_dump($data);die;
        $view = new View();
        $view->add_links(array('bootbox', 'vframework'));
        $view->add_link('js', ADMIN_JS . 'pages/pop_up_windows.js');
        $view->render('pop_up_windows/tpl_pop_up_windows', $data);
    }
    
    /**
     * 	Felugró ablakok hozzáadása
     *
     */
    public function insert()
    {
        if ($this->request->is_post()) {

            $data['title'] = $this->request->get_post('title');
            $data['description'] = $this->request->get_post('description');
            $data['content'] = $this->request->get_post('content', 'strip_danger_tags');
            $data['status'] = $this->request->get_post('status');

            $result = $this->pop_up_windows_model->insert($data);
           
            if ($result !== false) {
                Message::set('success', 'A felugró ablak sikeresen létrehozva!');
                $this->response->redirect('admin/pop_up_windows');
            } else {
                Message::set('error', 'unknown_error');
                $this->response->redirect('admin/pop_up_windows/insert'); 
            }
        }


        $data['title'] = 'Felugró ablak létrehozása';
        $data['description'] = 'Felugró ablak létrehozása description';

        $view = new View();
        $view->add_links(array('bootbox', 'ckeditor', 'vframework'));
        $view->add_link('js', ADMIN_JS . 'pages/pop_up_windows.js');
        $view->render('pop_up_windows/tpl_insert_pop_up_window', $data);
    }    

    /**
     * 	Felugró ablakok módosítása
     *
     */
    public function update($id)
    {
        $id = (int)$id;

        if ($this->request->is_post()) {

            $data['title'] = $this->request->get_post('title');
            $data['description'] = $this->request->get_post('description');
            $data['content'] = $this->request->get_post('content', 'strip_danger_tags');
            $data['status'] = $this->request->get_post('status');

            $result = $this->pop_up_windows_model->update($id, $data);
            if ($result !== false) {
                Message::set('success', 'A felugró ablak sikeresen módosítva!');
                $this->response->redirect('admin/pop_up_windows');
            }
            else {
                Message::set('error', 'A felugró ablak módosítása nem sikerült!');
                $this->response->redirect('admin/pop_up_windows/update/' . $id); 
            }
        }

        // adatok bevitele a view objektumba
        $data['title'] = 'Felugró ablakok szerkesztése';
        $data['description'] = 'Felugró ablakok szerkesztése description';
        // visszadja a szerkesztendő oldal adatait egy tömbben (page_id, page_title ... stb.)
        $data['data_arr'] = $this->pop_up_windows_model->selectOne($id);

        $view = new View();
        $view->add_links(array('bootbox', 'ckeditor', 'vframework'));
        $view->add_link('js', ADMIN_JS . 'pages/pop_up_windows.js');
        $view->render('pop_up_windows/tpl_edit_pop_up_window', $data);
    }

    /**
     * 	pop-up window törlése
     */
    public function delete($id)
    {
        $id = (int)$id;
        $result = $this->pop_up_windows_model->delete($id);

        if ($result !== false) {
            Message::set('success', 'A felugró ablak sikeresen törölve!');
        } else {
            Message::set('success', 'unknown_error');
        }

        $this->response->redirect('admin/pop_up_windows');
    }

}
?>