<?php
namespace System\Site\Controller;

use System\Core\SiteController;
use System\Core\View;
use System\Libs\Paginator;
use System\Libs\Language as Lang;

class Hirek extends SiteController {

    function __construct()
    {
        parent::__construct();
        $this->loadModel('blog_model');
        $this->loadModel('ingatlanok_model');
    }

    public function index()
    {
        $page_data = $this->blog_model->getPageData('hirek');

        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle_' . $this->lang];
        $data['description'] = $page_data['metadescription_' . $this->lang];
        $data['keywords'] = $page_data['metakeywords_' . $this->lang];
        $data['content'] = $page_data['body_' . $this->lang];

        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper'));

        // kiemelt ingatlanok
        //       $data['kiemelt_ingatlanok'] = $this->ingatlanok_model->kiemelt_properties_query(10);
        // blog kategóriák
        $data['blog_categories'] = $this->blog_model->get_blog_categories();
        // blogok
        $data['blogs'] = $this->blog_model->getBlogPosts();
        //      $data['kedvencek'] = $this->kedvencek_list;
        $pagine = new Paginator(Lang::get('lapozas'), $data['settings']['pagination']);
        // adatok lekérdezése limittel
        $data['blog_list'] = $this->blog_model->blog_pagination_query($pagine->get_limit(), $pagine->get_offset());

        // szűrési feltételeknek megfelelő összes rekord száma
        $blog_count = $this->blog_model->blog_pagination_count_query();

        $pagine->set_total($blog_count);

        $data['pagine_links'] = $pagine->page_links($this->request->get_uri('path_full'));


        ////$view->setLazyRender();
//$this->view->debug(true); 
        $view->add_link('js', SITE_JS . 'pages/hirek.js');
        $view->render('blog/tpl_blog', $data);
    }

    public function reszletek($title, $id)
    {
        $id = (int)$id;	

        $data = $this->addGlobalData();

        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper'));

         // blog kategóriák
        $data['blog_categories'] = $this->blog_model->get_blog_categories();
        // kiemelt ingatlanok
 //       $this->view->kiemelt_ingatlanok = $this->ingatlanok_model->kiemelt_properties_query(4);

        $content = $this->blog_model->getBlogPosts($id);

        if (empty($content)) {
            $this->response->redirect($this->request->get_uri('site_url') . 'error');
        }
        // meta adatok
        $data['title'] = $content['title_' . $this->lang];
        $data['description'] = $view->str_helper->sentenceTrim($content['body_' . $this->lang], 1);
        $data['keywords'] = "";
        $data['blog'] = $content;

        $view->render('blog/tpl_show_blog', $data);
    }

    public function kategoria($id)
    {

        $id = (int)$id;
        
        $page_data = $this->blog_model->getPageData('hirek');

        $data = $this->addGlobalData();

        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper'));

        // kiemelt ingatlanok
        //       $data['kiemelt_ingatlanok'] = $this->ingatlanok_model->kiemelt_properties_query(10);
        // blog kategóriák
        $data['blog_categories'] = $this->blog_model->get_blog_categories();
        $category_data = $this->blog_model->blog_category_query($id);
        $data['category_name'] = $category_data['category_name_' . $this->lang];
        
        //      $data['kedvencek'] = $this->kedvencek_list;
        $pagine = new Paginator(Lang::get('lapozas'), $data['settings']['pagination']);
        // adatok lekérdezése limittel
        $data['blogs'] = $this->blog_model->blog_query_by_category_pagination($id, $pagine->get_limit(), $pagine->get_offset());

        // szűrési feltételeknek megfelelő összes rekord száma
        $blog_count = $this->blog_model->blog_pagination_count_query();

        $pagine->set_total($blog_count);

        $data['pagine_links'] = $pagine->page_links($this->request->get_uri('path_full'));

        
        $data['title'] = $data['category_name'];
        $data['description'] = $data['category_name'];
        $data['keywords'] = 'blog: ' . $data['category_name'];        
        
        ////$view->setLazyRender();
//$this->view->debug(true); 
        $view->add_link('js', SITE_JS . 'pages/hirek.js');
        $view->render('blog/tpl_blog_category', $data);        
    }
}
?>