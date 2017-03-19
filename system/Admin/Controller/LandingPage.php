<?php

namespace System\Admin\Controller;

use System\Core\AdminController;
use System\Core\View;
use System\Libs\Auth;
use System\Libs\Message;
use System\Libs\DI;

class LandingPage extends AdminController {

    function __construct() {
        parent::__construct();
        $this->loadModel('LandingPage_model');
    }

    public function index() {
        //Auth::hasAccess('landing_pages.index', $this->request->get_httpreferer());

        $view = new View();

        $data['title'] = 'Admin landing pages oldal';
        $data['description'] = 'Admin landing pages oldal description';
        $data['all_pages'] = $this->LandingPage_model->allPages();
        // var_dump($data);die;
        $view->add_links(array('vframework', 'pages'));
        $view->render('landing_page/tpl_landing_pages', $data);
    }

    /**
     * 	Új oldalhozzáadása
     */
    public function insert() {
        //Auth::hasAccess('landing_pages.insert', $this->request->get_httpreferer());
        $string_helper = DI::get('str_helper');

        if ($this->request->is_post()) {

            $data['status'] = $this->request->get_post('status', 'integer');

            $data['title_hu'] = $this->request->get_post('page_title_hu');

            $data['friendlyurl_hu'] = $string_helper->stringToSlug($this->request->get_post('page_metatitle_hu'));
            $data['friendlyurl_en'] = $string_helper->stringToSlug($this->request->get_post('page_metatitle_en'));

            $data['body_hu'] = $this->request->get_post('page_body_hu', 'strip_danger_tags');
            $data['body_en'] = $this->request->get_post('page_body_en', 'strip_danger_tags');
            $data['metatitle_hu'] = $this->request->get_post('page_metatitle_hu');
            $data['metatitle_en'] = $this->request->get_post('page_metatitle_en');
            $data['metadescription_hu'] = $this->request->get_post('page_metadescription_hu');
            $data['metadescription_en'] = $this->request->get_post('page_metadescription_en');
            $data['metakeywords_hu'] = $this->request->get_post('page_metakeywords_hu');
            $data['metakeywords_en'] = $this->request->get_post('page_metakeywords_en');
            // létrehozás - timestamp
            $data['creation_time'] = time();

            // új adatok beírása az adatbázisba (update) a $data tömb tartalmazza a frissítendő adatokat 
            $result = $this->LandingPage_model->insert($data);

            if ($result !== false) {
                Message::set('success', 'Művelet végrehajtva.');
            } else {
                Message::set('error', 'unknown_error');
            }

            $this->response->redirect('admin/landingpage');
        }

        $view = new View();

        $data['title'] = 'Oldal szerkesztése';
        $data['description'] = 'Oldal szerkesztése description';

        $view->add_links(array('bootbox', 'ckeditor', 'vframework'));
        $view->add_link('js', ADMIN_JS . 'pages/landing_page_insert.js');
        $view->render('landing_page/tpl_landing_page_insert', $data);
    }

    /**
     * 	Oldal adatainak módosítása
     */
    public function update($id) {
        //Auth::hasAccess('landing_pages.update', $this->request->get_httpreferer());
        $string_helper = DI::get('str_helper');
        $id = (int) $id;

        if ($this->request->is_post()) {

            $data['status'] = $this->request->get_post('status', 'integer');

            $data['title_hu'] = $this->request->get_post('page_title_hu');

            $data['friendlyurl_hu'] = $string_helper->stringToSlug($this->request->get_post('page_metatitle_hu'));
            $data['friendlyurl_en'] = $string_helper->stringToSlug($this->request->get_post('page_metatitle_en'));

            $data['body_hu'] = $this->request->get_post('page_body_hu', 'strip_danger_tags');
            $data['body_en'] = $this->request->get_post('page_body_en', 'strip_danger_tags');
            $data['metatitle_hu'] = $this->request->get_post('page_metatitle_hu');
            $data['metatitle_en'] = $this->request->get_post('page_metatitle_en');
            $data['metadescription_hu'] = $this->request->get_post('page_metadescription_hu');
            $data['metadescription_en'] = $this->request->get_post('page_metadescription_en');
            $data['metakeywords_hu'] = $this->request->get_post('page_metakeywords_hu');
            $data['metakeywords_en'] = $this->request->get_post('page_metakeywords_en');
            // módosítás - timestamp
            $data['modification_time'] = time();

            // új adatok beírása az adatbázisba (update) a $data tömb tartalmazza a frissítendő adatokat 
            $result = $this->LandingPage_model->update($id, $data);

            if ($result !== false) {
                Message::set('success', 'page_update_success');
                $this->response->redirect('admin/landingpage');
            } else {
                Message::set('error', 'unknown_error');
                $this->response->redirect('admin/landingpage/update/' . $id);
            }
        }

        $view = new View();

        $data['title'] = 'Oldal szerkesztése';
        $data['description'] = 'Oldal szerkesztése description';
        $data['page'] = $this->LandingPage_model->onePage($id);

        $view->add_links(array('bootbox', 'ckeditor', 'vframework'));
        $view->add_link('js', ADMIN_JS . 'pages/landing_page_update.js');
        $view->render('landing_page/tpl_landing_page_update', $data);
    }

}

?>