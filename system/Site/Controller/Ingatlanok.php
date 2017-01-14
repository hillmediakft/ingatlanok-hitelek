<?php
namespace System\Site\Controller;

use System\Core\SiteController;
use System\Core\View;
use System\Libs\Paginator;

class Ingatlanok extends SiteController {

    function __construct()
    {
        parent::__construct();
        $this->loadModel('ingatlanok_model');
    }

    public function index()
    {
        $page_data = $this->ingatlanok_model->getPageData('ingatlanok');
        
        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle_' . $this->lang];
        $data['description'] = $page_data['metadescription_' . $this->lang];
        $data['keywords'] = $page_data['metakeywords_' . $this->lang];
        
        
        // a keresőhöz szükséges listák alőállítása
        $data['city_list'] = $this->ingatlanok_model->city_list_query_with_prop_no();
        $data['category_list'] = $this->ingatlanok_model->list_query('ingatlan_kategoria');








            // paginátor objektum létrehozása
                    $pagine = new Paginator('oldal', $data['settings']['pagination']);
            // limit-el lekérdezett adatok
                    $data['properties'] = $this->ingatlanok_model->properties_filter_query($pagine->get_limit(), $pagine->get_offset(), $this->request->get_query());
            // összes elem, ami a szűrési feltételnek megfelel (vagy a tábla összes rekordja, ha nincs szűrés)
                    $data['filtered_count'] = $this->ingatlanok_model->properties_filter_count_query();
            // összes elem megadása a paginátor objektumnak
                    $pagine->set_total($data['filtered_count']);
            // lapozó linkek visszadása (paraméter az uri path)
                    $data['pagine_links'] = $pagine->page_links($this->request->get_uri('path'));


// var_dump($data['propertys']);die;

    // összes ingatlan száma a táblában
    //$data['no_of_properties'] = $this->ingatlanok_model->get_count();












        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper'));

        //$view->setLazyRender();
//$this->view->debug(true); 
        $view->add_link('js', SITE_JS . 'pages/ingatlanok.js');
        $view->render('ingatlanok/tpl_ingatlanok', $data);
    }
}
?>