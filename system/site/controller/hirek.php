<?php
namespace System\Site\Controller;
use System\Core\Site_controller;
use System\Core\View;
use System\Libs\Paginator;
use System\Libs\Language as Lang;

class Hirek extends Site_controller {

    function __construct() {
        parent::__construct();
        $this->loadModel('blog_model');
        $this->loadModel('ingatlanok_model');
    }

    public function index() {

        $page_data = $this->blog_model->getPageData('hirek');

        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle'];
        $data['description'] = $page_data['metadescription'];
        $data['keywords'] = $page_data['metakeywords'];
        $data['content'] = $page_data['body'];

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

    public function reszletek() {
        $id = $this->registry->params['id'];
        Session::init();
        Session::set('prev_url', $this->registry->site_url . 'blog/reszletek/' . $id);

        $this->view = new View();
        $this->view->settings = $this->settings;
        $this->view->kedvencek_list = $this->kedvencek_list;
        $this->view->blogs = $this->blogs;

        $this->ingatlanok = $this->loadmodel('ingatlanok_model');
        // kiemelt ingatlanok
        $this->view->kiemelt_ingatlanok = $this->ingatlanok_model->kiemelt_properties_query(4);

        $this->view->blog_categories = $this->blog_model->get_blog_categories();


        $content = $this->blog_model->blog_query($id);
        if (empty($content)) {
            Util::redirect('error');
        }
        $this->view->title = $content[0]['blog_title'];
        $this->view->description = $content[0]['blog_title'];
        $this->view->blog = $content[0];
        $this->view->keywords = 'hírek';

        $this->view->set_layout('tpl_layout');
        $this->view->render('blog/tpl_show_blog');
    }

    public function kategoria() {
        $category_id = (int) $this->request->get_params('id');

        $this->view = new View();
        $this->view->settings = $this->settings;
        $this->view->kedvencek_list = $this->kedvencek_list;
        $this->view->blogs = $this->blogs;

        $this->ingatlanok = $this->loadmodel('ingatlanok_model');
        // kiemelt ingatlanok
        $this->view->kiemelt_ingatlanok = $this->ingatlanok_model->kiemelt_properties_query(4);

        $this->view->blog_categories = $this->blog_model->get_blog_categories();
        $this->view->blogs_per_page = 6;

        $category_data = $this->blog_model->blog_category_query($category_id);
        $this->view->category_name = $category_data['category_name'];
        $this->view->content = $this->blog_model->blog_query_by_category($category_id);



        $pagine = new Paginator('page', $this->view->blogs_per_page);
        // adatok lekérdezése limittel
        $this->view->blog_list = $this->blog_model->blog_query_by_category_pagination($category_id, $pagine->get_limit(), $pagine->get_offset());

        // szűrési feltételeknek megfelelő összes rekord száma
        $blog_count = $this->blog_model->blog_pagination_count_query();

        $pagine->set_total($blog_count);
        // lapozó linkek
        $this->view->pagine_links = $pagine->page_links($this->registry->uri_path);

        $this->view->title = $this->view->category_name;
        $this->view->description = $this->view->category_name;
        $this->view->keywords = 'blog: ' . $this->view->category_name;

        $this->view->set_layout('tpl_layout');
        $this->view->render('blog/tpl_blog_category');
    }

}

?>