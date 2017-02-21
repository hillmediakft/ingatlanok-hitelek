<?php
namespace System\Site\Controller;

use System\Core\SiteController;
use System\Core\View;
use System\Libs\Config;
use System\Libs\Session;
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


// paginátor objektum létrehozása
        $pagine = new Paginator('p', $data['settings']['pagination']);
// limit-el lekérdezett adatok szűréssel (paraméterek bekerülnek a 'ingatlan_filter' session elembe)
        $data['properties'] = $this->ingatlanok_model->properties_filter_query($pagine->get_limit(), $pagine->get_offset(), $this->request->get_query());
// összes elem, ami a szűrési feltételnek megfelel (vagy a tábla összes rekordja, ha nincs szűrés)
        $data['filtered_count'] = $this->ingatlanok_model->properties_filter_count_query();
// összes elem megadása a paginátor objektumnak
        $pagine->set_total($data['filtered_count']);
// lapozó linkek visszadása (paraméter az uri path)
        $data['pagine_links'] = $pagine->page_links($this->request->get_uri('path'));

        // a keresőhöz szükséges listák alőállítása
        $data['city_list'] = $this->ingatlanok_model->city_list_query_with_prop_no();
        $data['district_list'] = $this->ingatlanok_model->district_list_query_with_prop_no();
        $data['category_list'] = $this->ingatlanok_model->list_query('ingatlan_kategoria');


        // összes ingatlan száma a táblában
        $data['no_of_properties'] = $this->ingatlanok_model->get_count();
        // szűrési paramétereket tartalmazó tömb
        $data['filter_params'] = $this->ingatlanok_model->get_filter_params(Session::get('ingatlan_filter'));
//var_dump($data['filter_params']);        
        // kiemelt ingatlanok
        $data['kiemelt_ingatlanok'] = $this->ingatlanok_model->kiemelt_properties_query(4);

        $data['agents'] = $this->ingatlanok_model->get_agent();
// var_dump($data);die;


        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper'));

        //$view->setLazyRender();
//$this->view->debug(true); 
        $view->add_links(array('bootstrap-select'));
        $view->add_link('js', SITE_JS . 'pages/handle_search.js');
        $view->add_link('js', SITE_JS . 'pages/ingatlanok.js');
        $view->add_link('js', SITE_JS . 'kedvencek.js');
        $view->render('ingatlanok/tpl_ingatlanok', $data);
    }

    /**
     * Ingatlan adatlap
     * @param integer $id
     */
    public function adatlap($id)
    {
        $page_data = $this->ingatlanok_model->getPageData('ingatlanok');
        
        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle_' . $this->lang];
        $data['description'] = $page_data['metadescription_' . $this->lang];
        $data['keywords'] = $page_data['metakeywords_' . $this->lang];

        // ingatlani adatainak lekérdezése
        $data['ingatlan'] = $this->ingatlanok_model->getProperty((int)$id);
        // ingatlanhoz tartozó képek
        $data['pictures'] = json_decode($data['ingatlan']['kepek']);

        // csak a valóban létező extrák db nevét tartalamzó tömb elem legyártása
        $data['features'] = array();
        $features_temp = Config::get('extra');
        foreach ($data['ingatlan'] as $key => $value) {
            if (in_array($key, $features_temp) && $value == 1) {
                $data['features'][] = $key;
            }
        }

        // ar változó a hasonló ingatlanok lekérdezéshez
        $ar = ($data['ingatlan']['tipus'] = 1) ? $data['ingatlan']['ar_elado'] : $data['ingatlan']['ar_kiado'];
        // hasonló ingatlanok
        $data['hasonlo_ingatlan'] = $this->ingatlanok_model->hasonloIngatlanok($id, $data['ingatlan']['tipus'], $data['ingatlan']['kategoria'], $data['ingatlan']['varos'], $ar);


        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper'));
//$this->view->debug(true); 

        $view->add_links(array('google-maps-site'));
        $view->add_link('js', SITE_JS . 'kedvencek.js');
        //$view->add_link('js', SITE_JS . 'pages/adatlap.js');
        
        $view->render('ingatlanok/tpl_adatlap', $data);
    }

    /**
     * Ügynök ingatlanjait jeleníti meg
     */
    public function ertekesito($title, $id)
    {
        $page_data = $this->ingatlanok_model->getPageData('ertekesito');
        
        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle_' . $this->lang];
        $data['description'] = $page_data['metadescription_' . $this->lang];
        $data['keywords'] = $page_data['metakeywords_' . $this->lang];



        $params = $this->request->get_query();
        // paraméterekhez hozzáadjuk a ref_id elemet    
        $params['ref_id'] = (int)$id;

// paginátor objektum létrehozása
        $pagine = new Paginator('p', $data['settings']['pagination']);
// limit-el lekérdezett adatok szűréssel (paraméterek bekerülnek a 'ingatlan_filter' session elembe)
        $data['properties'] = $this->ingatlanok_model->properties_filter_query($pagine->get_limit(), $pagine->get_offset(), $params);
// összes elem, ami a szűrési feltételnek megfelel (vagy a tábla összes rekordja, ha nincs szűrés)
        $data['filtered_count'] = $this->ingatlanok_model->properties_filter_count_query();
// összes elem megadása a paginátor objektumnak
        $pagine->set_total($data['filtered_count']);
// lapozó linkek visszadása (paraméter az uri path)
        $data['pagine_links'] = $pagine->page_links($this->request->get_uri('path'));





        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper'));
        $view->add_link('js', SITE_JS . 'pages/handle_search.js');
        $view->add_link('js', SITE_JS . 'pages/ertekesito_ingatlanok.js');
//$this->view->debug(true); 
        $view->render('ingatlanok/tpl_ertekesito_ingatlanok', $data);
    }
    
 


}
?>