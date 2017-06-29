<?php
namespace System\Site\Controller;

use System\Core\SiteController;
use System\Core\View;

class MennyitErAzIngatlanom extends SiteController {

    function __construct()
    {
        parent::__construct();
        $this->loadModel('MennyitErAzIngatlanom_model');
        //$this->loadModel('ingatlanok_model');
    }

    public function index()
    {
        $page_data = $this->MennyitErAzIngatlanom_model->getPageData('mennyit-er-az-ingatlanom');
        
        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle_' . $this->lang];
        $data['description'] = $page_data['metadescription_' . $this->lang];
        $data['keywords'] = $page_data['metakeywords_' . $this->lang];
        
        $data['body'] = $page_data['body_' . $this->lang];
        
        // a keresőhöz szükséges listák alőállítása
        //$data['city_list'] = $this->ingatlanok_model->city_list_query_with_prop_no();
 // $data['category_list'] = $this->ingatlanok_model->list_query('ingatlan_kategoria');
        //$data['district_list'] = $this->ingatlanok_model->district_list_query_with_prop_no();
        // kiemelt ingatlanok
 // $data['all_properties'] = $this->ingatlanok_model->kiemelt_properties_query(10);

        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper'));
        
        $view->add_link('js', SITE_JS . 'pages/mennyit_er_az_ingatlanom.js');

        //$view->setLazyRender();
//$this->view->debug(true); 
 //       $view->add_link('js', SITE_JS . 'pages/hitel.js');
        $view->render('mennyiterazingatlanom/tpl_mennyiterazingatlanom', $data);
    }
}
?>