<?php
namespace System\Site\Controller;

use System\Core\SiteController;
use System\Core\View;
use System\Libs\Session;

class Home extends SiteController {

    function __construct()
    {
        parent::__construct();
        $this->loadModel('home_model');
        $this->loadModel('ingatlanok_model');
    }

    public function index()
    {
        $page_data = $this->home_model->getPageData('kezdo_oldal');
        
        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle_' . $this->lang];
        $data['description'] = $page_data['metadescription_' . $this->lang];
        $data['keywords'] = $page_data['metakeywords_' . $this->lang];
        
        // szűrési paramétereket tartalmazó tömb
        $data['filter_params'] = $this->ingatlanok_model->get_filter_params(Session::get('ingatlan_filter'));
var_dump($data['filter_params']);
        // a keresőhöz szükséges listák alőállítása
        $data['city_list'] = $this->ingatlanok_model->city_list_query_with_prop_no();
        $data['category_list'] = $this->ingatlanok_model->list_query('ingatlan_kategoria');
        $data['district_list'] = $this->ingatlanok_model->district_list_query_with_prop_no();
        
        // kiemelt ingatlanok
        $data['all_properties'] = $this->ingatlanok_model->kiemelt_properties_query(10);
		// ingatlan értékesítők
        $data['agents'] = $this->ingatlanok_model->get_agent();

        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper'));

        //$view->setLazyRender();
//$this->view->debug(true); 
        $view->add_link('js', SITE_JS . 'pages/handle_search.js');
        $view->add_link('js', SITE_JS . 'pages/home.js');
        $view->render('home/tpl_home', $data);
    }
}
?>