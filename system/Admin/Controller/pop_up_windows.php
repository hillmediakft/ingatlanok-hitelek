<?php

class Pop_up_windows extends Controller {

    function __construct() {
        parent::__construct();
        $this->loadModel('pop_up_windows_model');
        Auth::handleLogin();
    }

    public function index() {
        /* 		Auth::handleLogin();

          if (!Acl::create()->userHasAccess('home_menu')) {
          exit('nincs hozzáférése');
          }

         */
        // adatok bevitele a view objektumba
        $this->view->title = 'Felugró ablakok oldal';
        $this->view->description = 'Felugró ablakok oldal description';

        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootbox/bootbox.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/pop_up_windows.js');

        $this->view->all_pop_up_windows = $this->pop_up_windows_model->all_pop_up_windows();

        $this->view->render('pop_up_windows/tpl_pop_up_windows');
    }
    
    /**
     * 	Felugró ablakok módosítása
     *
     */
    public function insert() {

        if (isset($_POST['submit_new_pop_up_window'])) {
            $result = $this->pop_up_windows_model->insert_pop_up_window();
           
            if ($result) {
                $_SESSION["feedback_positive"][] = 'A felugró ablak sikeresen létrehozva!';
                Util::redirect('pop_up_windows');
            }
            else {
                $_SESSION["feedback_negative"][] = 'A felugró ablak létrehozása nem sikerült!';
                Util::redirect('pop_up_windows/insert'); 
            }
        }

        // adatok bevitele a view objektumba
        $this->view->title = 'Felugró ablak létrehozása';
        $this->view->description = 'Felugró ablak létrehozása description';
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/ckeditor/ckeditor.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootbox/bootbox.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/new_pop_up_window.js');

        $this->view->render('pop_up_windows/tpl_insert_pop_up_window');
    }    

    /**
     * 	Felugró ablakok módosítása
     *
     */
    public function edit() {
        if (!isset(Active::$params['id'])) {
            throw new Exception('Nincs "id" nevű eleme az Active::$params tombnek! (lekerdezes nem hajthato vegre id alapjan)');
            return false;
        }
        $id = (int) Active::$params['id'];
        if (isset($_POST['submit_update_pop_up_window'])) {


            $result = $this->pop_up_windows_model->update_pop_up_window($id);
            if ($result) {
                $_SESSION["feedback_positive"][] = 'A felugró ablak sikeresen módosítva!';
                Util::redirect('pop_up_windows');
            }
            else {
                $_SESSION["feedback_negative"][] = 'A felugró ablak módosítása nem sikerült!';
                Util::redirect('pop_up_windows/edit/' . $id); 
            }
        }

        // adatok bevitele a view objektumba
        $this->view->title = 'Felugró ablakok szerkesztése';
        $this->view->description = 'Felugró ablakok szerkesztése description';
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/ckeditor/ckeditor.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootbox/bootbox.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/edit_pop_up_window.js');

        // visszadja a szerkesztendő oldal adatait egy tömbben (page_id, page_title ... stb.)
        $this->view->data_arr = $this->pop_up_windows_model->pop_up_window_data_query($id);

        $this->view->render('pop_up_windows/tpl_edit_pop_up_window');
    }

    /**
     * 	pop-up window törlése
     */
    public function delete() {
        
        if (!isset(Active::$params['id'])) {
            throw new Exception('Nincs "id" nevű eleme a $params tombnek! (a lekerdezes nem hajthato vegre)');
            return false;
        }

        $id = (int) Active::$params['id'];
        $result = $this->pop_up_windows_model->delete_pop_up_window($id);

        // visszatérés üzenetekkel
        if ($result) {
            $_SESSION["feedback_positive"][] = 'A felugró ablak sikeresen törölve!';
        } else {
            $_SESSION["feedback_negative"][] = 'A felugró ablak törlése nem sikerült!';
        }

        Util::redirect('pop_up_windows');
    }

}

?>