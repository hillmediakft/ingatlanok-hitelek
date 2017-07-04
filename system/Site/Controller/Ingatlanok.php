<?php

namespace System\Site\Controller;

use System\Core\SiteController;
use System\Core\View;
use System\Libs\Auth;
use System\Libs\Config;
use System\Libs\Session;
use System\Libs\Paginator;
use System\Libs\Cookie;

class Ingatlanok extends SiteController {

    function __construct() {
        parent::__construct();
        $this->loadModel('ingatlanok_model');
    }

    public function index() {
        $page_data = $this->ingatlanok_model->getPageData('ingatlanok');

        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle_' . $this->lang];
        $data['description'] = $page_data['metadescription_' . $this->lang];
        $data['keywords'] = $page_data['metakeywords_' . $this->lang];


// paginátor objektum létrehozása
        $pagine = new Paginator('p', $data['settings']['pagination']);
// limit-el lekérdezett adatok szűréssel (paraméterek bekerülnek a 'ingatlan_filter' session elembe)
// A LIMIT ÉS AZ OFFSET MÓDOSÍTÁSA A BANNER MIATT
// a limitbő k ikell vonni egyet, mert az egyik elem a banner lesz
        $limit = ((int) $pagine->get_limit() - 1);
        $offset = $pagine->get_offset();
// az aktuális oldal szamabol kivonunk 1-et, hogy megkapjuk, hogy mennyi elemmel kell csökkenteni az offset-et, hiszen az ez előtti oldalakon egyel kevesebb elem jelent meg
        $kimaradt_elem = $pagine->getPageId() - 1;
        $offset = ($offset > 0) ? ($offset - $kimaradt_elem) : $offset;

        $data['properties_all'] = $this->ingatlanok_model->properties_filter_query(100, $offset, $this->request->get_query());
        if(!empty($data['properties_all'])) {
        foreach($data['properties_all'] as $key => $value) {
            $list[] = array(
                'id' => $value['id'],
                'ingatlan_nev_' . LANG => $value['ingatlan_nev_' . LANG]); 
        }
        } else {
            $list = array();
        }
        Session::set('talalati_lista', $list);
        Session::set('talalati_lista_url', $this->request->get_uri('current_url'));

        
  //      Session::seet('ingatlan_pager') = 
        
        $data['properties'] = $this->ingatlanok_model->properties_filter_query($limit, $offset, $this->request->get_query());
 
// összes elem, ami a szűrési feltételnek megfelel (vagy a tábla összes rekordja, ha nincs szűrés)
        $data['filtered_count'] = $this->ingatlanok_model->properties_filter_count_query();

// meghatározzuk a bannerek nélküli oldalak számát (ennyi banner lesz)
        $banner_number = $pagine->getNumberOfPages($data['filtered_count'], $pagine->get_limit());
        // összes elem megadása a paginátor objektumnak
        // az összes rekord számát növelni kell a bekerülő bannerek számával
        $pagine->set_total($data['filtered_count'] + $banner_number);

// lapozó linkek visszadása (paraméter a path_full)
        $data['pagine_links'] = $pagine->page_links($this->request->get_uri('path_full'));

        // a keresőhöz szükséges listák alőállítása
        $data['city_list'] = $this->ingatlanok_model->city_list_query_with_prop_no();
        $data['district_list'] = $this->ingatlanok_model->district_list_query_with_prop_no();
        $data['category_list'] = $this->ingatlanok_model->list_query('ingatlan_kategoria');

        // hirek az oldalsávba
        $this->loadModel('blog_model');
        $data['blogs'] = $this->blog_model->getBlogSidebar(3);

        // összes ingatlan száma a táblában
        $data['no_of_properties'] = $this->ingatlanok_model->get_count();
        // szűrési paramétereket tartalmazó tömb
        $data['filter_params'] = $this->ingatlanok_model->get_filter_params(Session::get('ingatlan_filter'));
//var_dump($data['filter_params']);        
        // kiemelt ingatlanok
        $data['kiemelt_ingatlanok'] = $this->ingatlanok_model->kiemelt_properties_query(4);

        $data['agents'] = $this->ingatlanok_model->get_agent();
        // csak azok az ügynökök jelennek meg, akiknek van ingatlanjuk
        foreach ($data['agents'] as $key => $value) {
            if ($value['property'] == 0) {
                unset($data['agents'][$key]);
            }
        }
        shuffle($data['agents']);



        /*         * ** BANNER  beszúrunk a tömbbe egy elemet **** */
// elemek száma
        $count = count($data['properties']);
        if ($count > 0) {
            // ha az elemek száma 1, vagy 2, akkor vagy a 2. vagy a 3. elem lesz 
            if ($count < 3) {
                array_splice($data['properties'], $count, 0, 'banner');
            }
            // ha az elemek száma több mint 3, akkor a 3. elem lesz
            else {
                array_splice($data['properties'], 2, 0, 'banner');
            }
        }
        /*         * ** BANNER **** */



//var_dump($data['properties']);die;

        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper', 'html_helper'));

        //$view->setLazyRender();
//$this->view->debug(true); 
        $view->add_links(array('bootstrap-select'));
        $view->add_link('js', SITE_JS . 'pages/handle_search.js');
        $view->add_link('js', SITE_JS . 'pages/ingatlanok.js');
        //$view->add_link('js', SITE_JS . 'kedvencek.js');
        $view->render('ingatlanok/tpl_ingatlanok', $data);
    }

    /**
     * Ingatlan adatlap
     * @param integer $id
     */
    public function adatlap($id) {
        $id = (int) $id;

        $page_data = $this->ingatlanok_model->getPageData('ingatlanok');

        $data = $this->addGlobalData();


        // ingatlani adatainak lekérdezése
        $data['ingatlan'] = $this->ingatlanok_model->getProperty($id);

        // ha az ingatlan kategória 1 akkor 225, egyébként 450
        $data['ingatlan']['map_circle_size'] = ($data['ingatlan']['kategoria'] === '1') ? 225 : 450;

        // ha nem létező id-jű ingatlant akarunk megjeleníteni
        if (empty($data['ingatlan'])) {
            $this->response->redirect('ingatlanok/nem-talalhato-az-ingatlan');
        }

        // ingatlanhoz tartozó képek
        $data['pictures'] = json_decode($data['ingatlan']['kepek']);

        // ha van a query stringben referensre vonatkozó adat
        if ($this->request->has_query('referens')) {
            $agent_id = $this->request->get_query('referens');
        } else {
            $agent_id = $data['ingatlan']['ref_id'];
        }
        // ügynök adatai
        $data['agent'] = $this->ingatlanok_model->get_agent($agent_id);
        if ($data['agent'] === false) {
            $data['agent'] = $this->ingatlanok_model->get_agent($data['ingatlan']['ref_id']);
        }


        // Árváltozás értesítés gomb állapotának beállításához kell (disable/enable)
        if (Auth::isUserLoggedIn()) {
            $user_id = Auth::getUser('id');

            $this->loadModel('arvaltozas_model');

            $data['ertesites_arvaltozasrol'] = $this->arvaltozas_model->selectPriceChange((int) $user_id, (int) $data['ingatlan']['id']);
        } else {
            $data['ertesites_arvaltozasrol'] = false;
        }


        // csak a valóban létező extrák db nevét tartalamzó tömb elem legyártása
        $data['features'] = array();
        $features_temp = Config::get('extra');
        foreach ($data['ingatlan'] as $key => $value) {
            if (in_array($key, $features_temp) && $value == 1) {
                $data['features'][] = $key;
            }
        }

        // ar változó a hasonló ingatlanok lekérdezéshez
        $ar = ($data['ingatlan']['tipus'] == 1) ? $data['ingatlan']['ar_elado'] : $data['ingatlan']['ar_kiado'];
        // hasonló ingatlanok
        $data['hasonlo_ingatlan'] = $this->ingatlanok_model->hasonloIngatlanok($id, $data['ingatlan']['tipus'], $data['ingatlan']['kategoria'], $data['ingatlan']['varos'], $ar);
        // nemrég megtekintett ingatlanok

        $data['nemreg_megtekintett_ingatlanok'] = $this->nemregMegtekintett();
        $this->addToNemregMegtekintett($id);
        // Megtekintések számának növelése
        $this->ingatlanok_model->increase_no_of_clicks($id);

        $kerulet = ($data['ingatlan']['kerulet']) ? $data['ingatlan']['kerulet'] . ' kerület, ' : '';
        $tipus = ($data['ingatlan']['tipus'] == 1) ? 'eladó' : 'kiadó' . ', ';
        $data['title'] = $data['ingatlan']['ingatlan_nev_' . $this->lang] . ', ' . $tipus . ', ' . $data['ingatlan']['city_name'] . ', ' . $kerulet . $data['ingatlan']['kat_nev_' . $this->lang] . ', ' . $data['ingatlan']['ar_elado'] . ' Ft';
        $data['description'] = $data['ingatlan']['ingatlan_nev_' . $this->lang] . ', ' . $tipus . ', ' . $data['ingatlan']['city_name'] . ', ' . $kerulet . $data['ingatlan']['kat_nev_' . $this->lang] . ', ' . $data['ingatlan']['ar_elado'] . ' Ft';
        $data['keywords'] = $tipus . ', ' . $data['ingatlan']['city_name'] . ', ' . $kerulet . $data['ingatlan']['kat_nev_' . $this->lang];

        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper', 'num_helper', 'html_helper'));
//$this->view->debug(true); 
        
        

        $view->add_links(array('google-maps-site'));
        $view->add_link('js', SITE_JS . 'pages/kedvencek.js');
        $view->add_link('js', SITE_JS . 'pages/adatlap.js');

        $view->render('ingatlanok/tpl_adatlap_v1', $data);
        //$view->render('ingatlanok/tpl_adatlap_v2', $data);
    }

    /**
     * Ügynök ingatlanjait jeleníti meg
     */
    public function ertekesito($title, $id) {
        $id = (int) $id;

        $page_data = $this->ingatlanok_model->getPageData('ertekesito');

        $data = $this->addGlobalData();




        $params = $this->request->get_query();
        // paraméterekhez hozzáadjuk a ref_id elemet    
        $params['ref_id'] = $id;

// paginátor objektum létrehozása
        $pagine = new Paginator('p', $data['settings']['pagination']);
// limit-el lekérdezett adatok szűréssel (paraméterek bekerülnek a 'ingatlan_filter' session elembe)
        $data['properties'] = $this->ingatlanok_model->properties_filter_query($pagine->get_limit(), $pagine->get_offset(), $params);
// összes elem, ami a szűrési feltételnek megfelel (vagy a tábla összes rekordja, ha nincs szűrés)
        $data['filtered_count'] = $this->ingatlanok_model->properties_filter_count_query();
// összes elem megadása a paginátor objektumnak
        $pagine->set_total($data['filtered_count']);
// lapozó linkek visszadása (paraméter az uri path)
        $data['pagine_links'] = $pagine->page_links($this->request->get_uri('path_full'));

// szűrési paramétereket tartalmazó tömb
        $data['filter_params'] = $this->ingatlanok_model->get_filter_params(Session::get('ingatlan_filter'));

// referens adatai
        $data['agent'] = $this->ingatlanok_model->get_agent($id);

        if ($data['agent'] === false) {
            $this->response->redirect('error');
        }

        $data['title'] = $data['agent']['first_name'] . ' '  . $data['agent']['last_name'] .  ' ' . $page_data['metatitle_' . $this->lang];
        $data['description'] = $data['agent']['first_name'] . ' '  . $data['agent']['last_name'] .  ' ' . $page_data['metatitle_' . $this->lang];
        $data['keywords'] = $data['agent']['first_name'] . ' '  . $data['agent']['last_name'] .  ' ' . $page_data['metatitle_' . $this->lang];

        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper', 'html_helper'));
        $view->add_link('js', SITE_JS . 'pages/handle_search.js');
        $view->add_link('js', SITE_JS . 'pages/ertekesito_ingatlanok.js');
//$this->view->debug(true); 
        $view->render('ingatlanok/tpl_ertekesito_ingatlanok', $data);
    }

    /**
     * Hozzáad az arvaltozas tablahoz egy új rekordot, ha még nem létezik a megadott user-hez a megadott ingatlan id
     */
    public function arvaltozasErtesites() {
        if ($this->request->is_ajax()) {

            if (Auth::isUserLoggedIn()) {
                $property_id = $this->request->get_post('property_id');
                $user_id = Auth::getUser('id');

                $this->loadModel('arvaltozas_model');

                // megnézzük, hogy az arvaltozas tablaban van e ennek a felhasználónak ehhez az ingatlanhoz tartozó rekordja
                // ha van ilyen rekord, akkor true, ha nincs akkor false
                $result = $this->arvaltozas_model->selectPriceChange($user_id, $property_id);
                if ($result) {
                    $this->response->json(array(
                        'status' => 'success',
                        'message' => 'Ön már aktiválta ezt a funkciót.'
                    ));
                } else {
                    // beírjuk az adatbázisba az új rekordot
                    $this->arvaltozas_model->insertPriceChange($user_id, $property_id);
                }

                $this->response->json(array(
                    'status' => 'success',
                    'message' => 'Értesítés árváltozásról funkció aktiválva.'
                ));
            }
            // ha nincs bejelentkezve a felhasználó
            else {
                $this->response->json(array(
                    'status' => 'error',
                    'message' => 'A funkció használatához be kell jelentkeznie.'
                ));
            }
        } else {
            $this->response->redirect('error');
        }
    }

    public function nemregMegtekintett() {
        $id_array = json_decode(Cookie::get('nemreg_megtekintett'));

        if ($id_array) {
            $result = $this->ingatlanok_model->get_favourite_properties_data($id_array);
            return $result;
        } else {
            return array();
        }
    }

    /**
     * 	hozzáadja az ingatlan id-t a kedvencek cookie-hoz  
     */
    public function addToNemregMegtekintett($id) {

        $result = $this->ingatlanok_model->refresh_nemreg_megtekintett_cookie($id);
    }

    public function nem_talalhato_az_ingatlan() {

        $page_data = $this->ingatlanok_model->getPageData('error');

        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle_' . $this->lang];
        $data['description'] = $page_data['metadescription_' . $this->lang];
        $data['keywords'] = $page_data['metakeywords_' . $this->lang];

        $view = new View();
        $view->setHelper(array('url_helper'));

        //$view->setLazyRender();
//$this->view->debug(true); 
        $this->response->setHeader('HTTP/1.0', '404 Not Found');
        $this->response->sendHeaders();
        $view->render('error/nem_talalhato_az_ingatlan', $data);
    }

}

?>