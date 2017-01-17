<?php
namespace System\Site\Controller;

use System\Core\SiteController;
use System\Core\View;

class IngatlanErtekesitoink extends SiteController {

    function __construct()
    {
        parent::__construct();
        $this->loadModel('ingatlan_ertekesitoink_model');
        $this->loadModel('ingatlanok_model');
    }

    public function index()
    {
        $page_data = $this->ingatlan_ertekesitoink_model->getPageData('ingatlan-ertekesitoink');
        
        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle_' . $this->lang];
        $data['description'] = $page_data['metadescription_' . $this->lang];
        $data['keywords'] = $page_data['metakeywords_' . $this->lang];
        
        
        // a keresőhöz szükséges listák alőállítása
        $data['city_list'] = $this->ingatlanok_model->city_list_query_with_prop_no();
 //       $data['category_list'] = $this->ingatlanok_model->list_query('ingatlan_kategoria');
        $data['district_list'] = $this->ingatlanok_model->district_list_query_with_prop_no();
// kiemelt ingatlanok
            $data['kiemelt_ingatlanok'] = $this->ingatlanok_model->kiemelt_properties_query(4);
		// ingatlan értékesítők
        $data['agents'] = $this->ingatlanok_model->get_agent();
        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper'));

        //$view->setLazyRender();
//$this->view->debug(true); 
 //       $view->add_link('js', SITE_JS . 'pages/ingatlan_ertekesitoink.js');
        $view->render('ingatlan_ertekesitoink/tpl_ingatlan_ertekesitoink', $data);
    }
}
?>