<?php
namespace System\Site\Controller;

use System\Core\SiteController;
use System\Core\View;
use System\Libs\Config;
use System\Libs\Cookie;
use System\Libs\Session;
use System\Libs\Paginator;

class Kereses extends SiteController {

    public function __construct() {
        parent::__construct();
        $this->loadModel('kereses_model');
        $this->loadModel('ingatlanok_model');
    }

    public function index()
    {
        $page_data = $this->ingatlanok_model->getPageData('kereses');

        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle_' . $this->lang];
        $data['description'] = $page_data['metadescription_' . $this->lang];
        $data['keywords'] = $page_data['metakeywords_' . $this->lang];

        // a keresőhöz szükséges listák alőállítása
        $data['city_list'] = $this->ingatlanok_model->city_list_query_with_prop_no();
        $data['district_list'] = $this->ingatlanok_model->district_list_query_with_prop_no();
        $data['category_list'] = $this->ingatlanok_model->list_query('ingatlan_kategoria');
        $data['allapot_list'] = $this->ingatlanok_model->list_query('ingatlan_allapot');
        $data['futes_list'] = $this->ingatlanok_model->list_query('ingatlan_futes');
        $data['szerkezet_list'] = $this->ingatlanok_model->list_query('ingatlan_szerkezet');
        $data['energetika_list'] = $this->ingatlanok_model->list_query('ingatlan_energetika');
        $data['kilatas_list'] = $this->ingatlanok_model->list_query('ingatlan_kilatas');
        $data['kert_list'] = $this->ingatlanok_model->list_query('ingatlan_kert');

        // szűrési paramétereket tartalmazó tömb
        $data['filter_params'] = $this->ingatlanok_model->get_filter_params(Session::get('ingatlan_filter'));
        // kiemelt ingatlanok
        $data['kiemelt_ingatlanok'] = $this->ingatlanok_model->kiemelt_properties_query(4);
        // referens adatok lekérdezése
        $data['agents'] = $this->ingatlanok_model->get_agent();
// var_dump($data);die;

        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper', 'num_helper'));

        //$view->setLazyRender();
//$this->view->debug(true); 
        $view->add_links(array('bootstrap-select'));
        $view->add_link('js', SITE_JS . 'pages/handle_search.js');
        //$view->add_link('js', SITE_JS . 'kereses.js');
        $view->render('kereses/tpl_kereses', $data);
    }

}

?>