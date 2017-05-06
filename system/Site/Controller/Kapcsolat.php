<?php
namespace System\Site\Controller;

use System\Core\SiteController;
use System\Core\View;

class Kapcsolat extends SiteController {

    function __construct()
    {
        parent::__construct();
        $this->loadModel('kapcsolat_model');
        $this->loadModel('ingatlanok_model');
    }

    public function index()
    {
        $page_data = $this->kapcsolat_model->getPageData('kapcsolat');
        
        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle_' . $this->lang];
        $data['description'] = $page_data['metadescription_' . $this->lang];
        $data['keywords'] = $page_data['metakeywords_' . $this->lang];
        
        
        // a keresőhöz szükséges listák alőállítása
  //      $data['city_list'] = $this->ingatlanok_model->city_list_query_with_prop_no();
 //       $data['category_list'] = $this->ingatlanok_model->list_query('ingatlan_kategoria');
 //       $data['district_list'] = $this->ingatlanok_model->district_list_query_with_prop_no();
// kiemelt ingatlanok
            $data['kiemelt_ingatlanok'] = $this->ingatlanok_model->kiemelt_properties_query(4);
		
        // ingatlan értékesítők
        $data['agents'] = $this->ingatlanok_model->get_agent();
        // csak azok az ügynökök jelennek meg, akiknek van ingatlanjuk
        foreach ($data['agents'] as $key => $value) {
            if ($value['property'] == 0) {
                unset($data['agents'][$key]);
            }
        }        
        shuffle($data['agents']);

        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper'));

        //$view->setLazyRender();
//$this->view->debug(true); 
        $view->add_links(array('google-maps-site'));
        $view->add_link('js', SITE_JS . 'pages/kapcsolat.js');
        $view->render('kapcsolat/tpl_kapcsolat', $data);
    }
}
?>