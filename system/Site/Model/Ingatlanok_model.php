<?php

namespace System\Site\Model;

use System\Core\SiteModel;
use System\Libs\Session;
use System\Libs\Cookie;
use \PDO;
use System\Libs\DI;

class Ingatlanok_model extends SiteModel {

    protected $table = 'ingatlanok';

    function __construct() {
        parent::__construct();
    }

    /**
     * 	Lekérdezi az ingatlanok táblából a kiemelet ingatlanokat
     * 	
     * 	@param array 
     */
    public function kiemelt_properties_query($limit = null) {
// $this->query->debug(true);
        $this->query->set_table(array('ingatlanok'));
        $this->query->set_columns(array(
            'ingatlanok.id',
            'ingatlanok.ref_num',
            'ingatlanok.ingatlan_nev_' . $this->lang,
            'ingatlanok.status',
            'ingatlanok.tipus',
            'ingatlanok.kerulet',
            'ingatlanok.ar_elado',
            'ingatlanok.ar_elado_eredeti',
            'ingatlanok.ar_kiado',
            'ingatlanok.ar_kiado_eredeti',
            'ingatlanok.alapterulet',
            'ingatlanok.szobaszam',
            'ingatlanok.kepek',
            'ingatlanok.varos',
            'ingatlan_kategoria.*',
            'city_list.city_name'
        ));

        $this->query->set_join('left', 'ingatlan_kategoria', 'ingatlanok.kategoria', '=', 'ingatlan_kategoria.kat_id');
        $this->query->set_join('left', 'city_list', 'ingatlanok.varos', '=', 'city_list.city_id');
        $this->query->set_where('ingatlanok.kiemeles', '=', 1);
        $this->query->set_where('status', '=', 1);
        if (!is_null($limit)) {
            $this->query->set_limit($limit);
        }
        $this->query->set_orderby('ingatlanok.id', 'DESC');

        return $this->query->select();
    }

    /**
     * 	Lekérdezi az ingatlanok táblából a kiemelet ingatlanokat
     * 	
     * 	@param array 
     */
    public function get_favourite_properties_data($id_array) {
// $this->query->debug(true);
        $this->query->set_columns(array(
            'ingatlanok.id',
            'ingatlanok.ref_num',
            'ingatlanok.ingatlan_nev_' . $this->lang,
            'ingatlanok.status',
            'ingatlanok.tipus',
            'ingatlanok.kerulet',
            'ingatlanok.ar_elado',
            'ingatlanok.ar_elado_eredeti',
            'ingatlanok.ar_kiado',
            'ingatlanok.ar_kiado_eredeti',
            'ingatlanok.alapterulet',
            'ingatlanok.szobaszam',
            'ingatlanok.kepek',
            'ingatlanok.varos',
            'ingatlan_kategoria.*',
            'district_list.district_name',
            'city_list.city_name'
        ));

        $this->query->set_join('left', 'ingatlan_kategoria', 'ingatlanok.kategoria', '=', 'ingatlan_kategoria.kat_id');
        $this->query->set_join('left', 'city_list', 'ingatlanok.varos', '=', 'city_list.city_id');
        $this->query->set_join('left', 'district_list', 'ingatlanok.kerulet', '=', 'district_list.district_id');
        if (is_array($id_array)) {
            foreach ($id_array as $value) {
                $this->query->set_where('id', '=', $value, 'or');
            }
        } else {
            $this->query->set_where('id', '=', $id_array);
        }
        $this->query->set_where('status', '=', 1);
        $this->query->set_orderby('ingatlanok.id', 'DESC');

        return $this->query->select();
    }

    /**
     * 	Lekérdezi egy ingatlan összes adatát id alapján
     * 	
     * 	@param array 
     */
    public function getProperty($id) {
//        $this->query->debug(true);
        $this->query->set_columns(array(
            'ingatlanok.*',
            'district_list.district_name',
            'city_list.city_name',
            'ingatlan_kategoria.*',
            'ingatlan_allapot.*',
            'ingatlan_futes.*',
            'ingatlan_parkolas.*',
            'ingatlan_kilatas.*',
            'ingatlan_energetika.*',
            'ingatlan_kert.*',
            'ingatlan_szerkezet.*',
            'ingatlan_haz_allapot_belul.*',
            'ingatlan_haz_allapot_kivul.*',
            'ingatlan_furdo_wc.*',
            'ingatlan_fenyviszony.*',
            'ingatlan_szoba_elrendezes.*',
        ));

        $this->query->set_join('left', 'city_list', 'ingatlanok.varos', '=', 'city_list.city_id');
        $this->query->set_join('left', 'district_list', 'ingatlanok.kerulet', '=', 'district_list.district_id');

        $this->query->set_join('left', 'ingatlan_kategoria', 'ingatlanok.kategoria', '=', 'ingatlan_kategoria.kat_id');
        $this->query->set_join('left', 'ingatlan_allapot', 'ingatlanok.allapot', '=', 'ingatlan_allapot.all_id');
        $this->query->set_join('left', 'ingatlan_futes', 'ingatlanok.futes', '=', 'ingatlan_futes.futes_id');
        $this->query->set_join('left', 'ingatlan_parkolas', 'ingatlanok.parkolas', '=', 'ingatlan_parkolas.parkolas_id');
        $this->query->set_join('left', 'ingatlan_kilatas', 'ingatlanok.kilatas', '=', 'ingatlan_kilatas.kilatas_id');
        $this->query->set_join('left', 'ingatlan_energetika', 'ingatlanok.energetika', '=', 'ingatlan_energetika.energetika_id');
        $this->query->set_join('left', 'ingatlan_kert', 'ingatlanok.kert', '=', 'ingatlan_kert.kert_id');
        $this->query->set_join('left', 'ingatlan_szerkezet', 'ingatlanok.szerkezet', '=', 'ingatlan_szerkezet.szerkezet_id');
        $this->query->set_join('left', 'ingatlan_haz_allapot_belul', 'ingatlanok.haz_allapot_belul', '=', 'ingatlan_haz_allapot_belul.haz_allapot_belul_id');
        $this->query->set_join('left', 'ingatlan_haz_allapot_kivul', 'ingatlanok.haz_allapot_kivul', '=', 'ingatlan_haz_allapot_kivul.haz_allapot_kivul_id');
        $this->query->set_join('left', 'ingatlan_furdo_wc', 'ingatlanok.furdo_wc', '=', 'ingatlan_furdo_wc.furdo_wc_id');
        $this->query->set_join('left', 'ingatlan_fenyviszony', 'ingatlanok.fenyviszony', '=', 'ingatlan_fenyviszony.fenyviszony_id');
        $this->query->set_join('left', 'ingatlan_szoba_elrendezes', 'ingatlanok.szoba_elrendezes', '=', 'ingatlan_szoba_elrendezes.szoba_elrendezes_id');

        $this->query->set_where('id', '=', $id);
        $this->query->set_where('status', '=', 1);

        $result = $this->query->select();
        return (isset($result[0])) ? $result[0] : $result;
    }

    /**
     * 	Ingatlanok lekéderzése szűrési feltételekkel
     *
     * @param integer $limit
     * @param integer $offset
     * @param array $params - a lekérdezéshez szükséges paramétereket tartalmazza
     */
    public function properties_filter_query($limit = null, $offset = null, $params)
    {
/* SORREND MEGADÁSA HA NINCS A QUERY STRINGBEN */        
        // ha nincs a query stringben sorrendre vonatkozó paraméter    
        if ( (!isset($params['order']) && !isset($params['order_by'])) ) {

            // sorrendre vonatkozó információt a session-ből veszi, ha nincs a query stringben, de van a session-ben
            if (Session::has('ingatlan_filter.order')) {
                $order_temp = Session::get('ingatlan_filter.order');
            }
            if (Session::has('ingatlan_filter.order_by')) {
                $order_by_temp = Session::get('ingatlan_filter.order_by');
            }

            // ha van a sessionben sorrendre vonatkozó paraméter
            if (isset($order_temp) && isset($order_by_temp)) {
                $params['order'] = $order_temp;
                $params['order_by'] = $order_by_temp;
            }
            // ha nincs a query stringben és a sessionben sem sorrendre vonatkozó paraméter
            if (!isset($order_temp) && !isset($order_by_temp)) {
                $params['order'] = 'desc';
                $params['order_by'] = 'datum';
            }
        }
/* SORREND MEGADÁSA HA NINCS A QUERY STRINGBEN VÉGE */        

        // berakjuk az új keresési paramétereket a session-be    
        Session::set('ingatlan_filter', $params);

        $num_helper = DI::get('num_helper');

        // Ár mezők adatit alakítjuk át
        if (isset($params['tipus']) && $params['tipus'] == 1) {

            if ((isset($params['min_ar']) && ($params['min_ar']) !== '')) {
                $params['min_ar'] = intval($num_helper->stringToNumber($params['min_ar']) * 1000000);
            }
            if ((isset($params['max_ar']) && ($params['max_ar']) !== '')) {
                $params['max_ar'] = intval($num_helper->stringToNumber($params['max_ar']) * 1000000);
            }
        } elseif (isset($params['tipus']) && $params['tipus'] == 2) {

            if ((isset($params['min_ar']) && ($params['min_ar']) !== '')) {
                $params['min_ar'] = intval($num_helper->stringToNumber($params['min_ar']) * 1000);
            }
            if ((isset($params['max_ar']) && ($params['max_ar']) !== '')) {
                $params['max_ar'] = intval($num_helper->stringToNumber($params['max_ar']) * 1000);
            }
        }

        // alapterület mezők adatát alakítjuk át számmá    
        if ((isset($params['min_alapterulet']) && ($params['min_alapterulet']) !== '')) {
            $params['min_alapterulet'] = intval($num_helper->stringToNumber($params['min_alapterulet']));
        }
        if ((isset($params['max_alapterulet']) && ($params['max_alapterulet']) !== '')) {
            $params['max_alapterulet'] = intval($num_helper->stringToNumber($params['max_alapterulet']));
        }


        // eltávolítjuk a nem numerikus karaktereket    
        /*
          if (isset($params['min_ar'])) {
          $params['min_ar'] = (int) preg_replace('/\D/', '', $params['min_ar']);
          }
          if (isset($params['max_ar'])) {
          $params['max_ar'] = (int) preg_replace('/\D/', '', $params['max_ar']);
          }
          if (isset($params['min_alapterulet'])) {
          $params['min_alapterulet'] = (int) preg_replace('/\D/', '', $params['min_alapterulet']);
          }
          if (isset($params['max_alapterulet'])) {
          $params['max_alapterulet'] = (int) preg_replace('/\D/', '', $params['max_alapterulet']);
          }
         */
// var_dump($params);die;
// üres stringet tartalamzó paraméterek eltávolítása
        /*
          foreach ($params as $key => $value) {
          if ($value === '') {
          unset($params[$key]);
          }
          }
         */


        $this->query->set_columns("SQL_CALC_FOUND_ROWS 
          `ingatlanok`.`id`,
          `ingatlanok`.`ref_num`,
          `ingatlanok`.`ingatlan_nev_" . $this->lang . "`,
          `ingatlanok`.`status`,
          `ingatlanok`.`tipus`,
          `ingatlanok`.`kerulet`,
          `ingatlanok`.`ar_elado`,
          `ingatlanok`.`ar_elado_eredeti`,
          `ingatlanok`.`ar_kiado`,
          `ingatlanok`.`ar_kiado_eredeti`,
          `ingatlanok`.`alapterulet`,
          `ingatlanok`.`szobaszam`,
          `ingatlanok`.`kepek`,
          `ingatlanok`.`varos`,
          `ingatlan_kategoria`.*,
          `district_list`.`district_name`,
          `city_list`.`city_name`"
        );

        if (!is_null($limit)) {
            $this->query->set_limit($limit);
        }
        if (!is_null($offset)) {
            $this->query->set_offset($offset);
        }

        $this->query->set_join('left', 'ingatlan_kategoria', 'ingatlanok.kategoria', '=', 'ingatlan_kategoria.kat_id');
        $this->query->set_join('left', 'city_list', 'ingatlanok.varos', '=', 'city_list.city_id');
        $this->query->set_join('left', 'district_list', 'ingatlanok.kerulet', '=', 'district_list.district_id');

        $this->query->set_where('status', '=', 1);

        /*         * ** ÉRTÉKESÍTŐ SZERINT **** */
        if (isset($params['ref_id']) && $params['ref_id'] !== '') {
            $this->query->set_where('ref_id', '=', (int)$params['ref_id']);
        }

        /*         * ** TÍPUS SZERINT **** */
        if (isset($params['tipus']) && !empty($params['tipus'])) {
            $this->query->set_where('tipus', '=', (int)$params['tipus']);
        }

        /*         * ** KATEGÓRIA SZERINT **** */
        if (isset($params['kategoria']) && !empty($params['kategoria'])) {
            if (is_array($params['kategoria'])) {
                $this->query->set_where('kategoria', 'in', $params['kategoria']);
            } else {
                $this->query->set_where('kategoria', '=', $params['kategoria']);
            }
        }
        /*
          if (isset($params['megye']) && !empty($params['megye'])) {
          $this->query->set_where('megye', '=', $params['megye']);
          }
         */
        // ha van város és kerület
        if ((isset($params['varos']) && !empty($params['varos'])) && (isset($params['kerulet']) && !empty($params['kerulet']))) {
            if (is_array($params['varos'])) {
                $this->query->set_where('AND (');
                $this->query->set_where('varos', 'in', $params['varos']);
            } else {
                $this->query->set_where('AND (');
                $this->query->set_where('varos', '=', $params['varos']);
            }
            if (is_array($params['kerulet'])) {
                $this->query->set_where('kerulet', 'in', $params['kerulet'], 'and');
                $this->query->set_where(')');
            } else {
                $this->query->set_where('kerulet', '=', $params['kerulet'], 'and');
                $this->query->set_where(')');
            }
        }

        // ha van város, de nincs kerület
        if ((isset($params['varos']) && !empty($params['varos'])) && (!isset($params['kerulet']) || (isset($params['kerulet']) && empty($params['kerulet'])) )) {
            if (is_array($params['varos'])) {
                $this->query->set_where('varos', 'in', $params['varos']);
            } else {
                $this->query->set_where('varos', '=', $params['varos']);
            }
        }


        // ha nincs város, de van kerület
        /*
          if (isset($params['kerulet']) && !isset($params['varos'])) {
          if (is_array($params['kerulet'])) {
          $this->query->set_where('kerulet', 'in', $params['kerulet']);
          } else {
          $this->query->set_where('kerulet', '=', $params['kerulet']);
          }
          var_dump('van kerulet nincs varos');
          }
         */


        // ************************* ÁR ALAPJÁN KERESÉS **************************** 
        // csak minimum ár van megadva
        if ((isset($params['min_ar']) && ($params['min_ar']) !== '' ) && ( $params['min_ar'] >= 0) && ( isset($params['max_ar']) && $params['max_ar'] === '')) {

            if (isset($params['tipus']) && $params['tipus'] == 1) {
                $this->query->set_where('ar_elado', '>=', $params['min_ar']);
            } elseif (isset($params['tipus']) && $params['tipus'] == 2) {
                $this->query->set_where('ar_kiado', '>=', $params['min_ar']);
            }
        }

        // csak maximum ár van megadva
        if ((isset($params['max_ar']) && ($params['max_ar']) !== '') && ( $params['max_ar'] >= 0) && ( isset($params['min_ar']) && $params['min_ar'] === '')) {
            if (isset($params['tipus']) && $params['tipus'] == 1) {
                $this->query->set_where('ar_elado', '<=', $params['max_ar']);
            } elseif (isset($params['tipus']) && $params['tipus'] == 2) {
                $this->query->set_where('ar_kiado', '<=', $params['max_ar']);
            }
        }

        // minimum és maximum ár is meg van adva
        if ((isset($params['min_ar']) && ($params['min_ar']) !== '') && ( $params['min_ar'] >= 0) && ( isset($params['max_ar']) && ($params['max_ar']) !== '') && ( $params['max_ar'] > 0)) {
            if (isset($params['tipus']) && $params['tipus'] == 1) {
                $this->query->set_where('AND (');
                $this->query->set_where('ar_elado', 'between', array($params['min_ar'], $params['max_ar']));
                $this->query->set_where(')');
                //$this->query->set_where('ar_elado', '>=', $params['min_ar']);
                //$this->query->set_where('ar_elado', '<=', $params['max_ar']);
            } elseif (isset($params['tipus']) && $params['tipus'] == 2) {
                $this->query->set_where('AND (');
                $this->query->set_where('ar_kiado', 'between', array($params['min_ar'], $params['max_ar']));
                $this->query->set_where(')');
                // $this->query->set_where('ar_kiado', '>=', $params['min_ar']);
                // $this->query->set_where('ar_kiado', '<=', $params['max_ar']);
            }
        }


        /*
          // minimum és maximum ár is meg van adva
          if (isset($params['min_ar']) && isset($params['max_ar'])) {
          if (isset($params['tipus']) && $params['tipus'] == 1) {
          // if ($params['min_ar'] != 0 && $params['max_ar'] != 50000000) {}
          $this->query->set_where('AND (');
          $this->query->set_where('ar_elado', 'between', array($params['min_ar'], $params['max_ar']));
          $this->query->set_where(')');
          }
          elseif (isset($params['tipus']) && $params['tipus'] == 2) {
          //$params['min_ar'] = (empty($params['min_ar'])) ? 0 : (int)$params['min_ar'];
          //$params['max_ar'] = (empty($params['max_ar'])) ? 0 : (int)$params['max_ar'];
          if ($params['min_ar'] <= $params['max_ar']) {
          $this->query->set_where('AND (');
          $this->query->set_where('ar_kiado', 'between', array($params['min_ar'], $params['max_ar']));
          $this->query->set_where(')');
          }
          }
          }
         */


        /*         * ************************ TERÜLET ALAPJÁN KERESÉS **************************** */
        // csak minimum terület van megadva
        if ((isset($params['min_alapterulet']) && ($params['min_alapterulet']) !== '') AND ( $params['min_alapterulet'] > 0) AND ( isset($params['max_alapterulet']) AND $params['max_alapterulet'] === '')) {
            $this->query->set_where('alapterulet', '>=', $params['min_alapterulet']);
        }

        // csak maximum terulet van megadva
        if ((isset($params['max_alapterulet']) && ($params['max_alapterulet']) !== '') AND ( $params['max_alapterulet'] > 0) AND ( isset($params['min_alapterulet']) AND $params['min_alapterulet'] === '')) {
            $this->query->set_where('alapterulet', '<=', $params['max_alapterulet']);
        }
        // minimum és maximum terület is meg van adva
        if (( isset($params['min_alapterulet']) && ($params['min_alapterulet']) !== '' ) && ( isset($params['max_alapterulet']) && ($params['max_alapterulet']) !== '' )) {
            $this->query->set_where('AND (');
            $this->query->set_where('alapterulet', 'between', array($params['min_alapterulet'], $params['max_alapterulet']));
            $this->query->set_where(')');
        }


        /*         * ************************ SZOBASZÁM ALAPJÁN KERESÉS **************************** */

        // csak minimum terület van megadva
        if ((isset($params['min_szobaszam']) && !empty($params['min_szobaszam'])) AND ( $params['min_szobaszam'] > 0) AND ( isset($params['max_szobaszam']) AND $params['max_szobaszam'] == 0)) {
            $this->query->set_where('szobaszam', '>=', $params['min_szobaszam']);
        }

        // csak maximum terulet van megadva
        if ((isset($params['max_szobaszam']) && !empty($params['max_szobaszam'])) AND ( $params['max_szobaszam'] > 0) AND ( isset($params['min_szobaszam']) AND $params['min_szobaszam'] == 0)) {
            $this->query->set_where('szobaszam', '<=', $params['max_szobaszam']);
        }
        // minimum és maximum ár is meg van adva
        if ((isset($params['min_szobaszam']) && !empty($params['min_szobaszam'])) AND ( $params['min_szobaszam'] > 0) AND ( isset($params['max_szobaszam']) && !empty($params['max_szobaszam'])) AND ( $params['max_szobaszam'] > 0)) {
            $this->query->set_where('szobaszam', 'between', array($params['min_szobaszam'], $params['max_szobaszam']));
        }

/** JELLEMZŐK **/
        // állapot
        if ((isset($params['allapot']) && !empty($params['allapot']))) {
            $this->query->set_where('allapot', '=', $params['allapot']);
        }

        // fűtés
        if ((isset($params['futes']) && !empty($params['futes']))) {
            $this->query->set_where('futes', '=', $params['futes']);
        }

/** EXTRÁK **/
        // Bútorozott
        if ((isset($params['ext_butor']) && ($params['ext_butor'] == 1))) {
            $this->query->set_where('ext_butor', '=', 1);
        }
        // Erkély
        if ((isset($params['erkely']) && ($params['erkely'] == 1))) {
            $this->query->set_where('erkely', '=', 1);
        }

/** EGYÉB KERESÉS **/
        // Referencia szám
        if (isset($params['ref_num']) && $params['ref_num'] !== '') {
            $params['ref_num'] = intval(preg_replace('~\D~', '', $params['ref_num']));
            $this->query->set_where('ref_num', '=', (int)$params['ref_num']);
        }
        // Ingatlan név hu
        if (isset($params['ingatlan_nev_hu']) && $params['ingatlan_nev_hu'] !== '') {
            $this->query->set_where('ingatlan_nev_hu', 'LIKE', '%' . $params['ingatlan_nev_hu'] . '%');
        }
        // Ingatlan név en
        if (isset($params['ingatlan_nev_en']) && $params['ingatlan_nev_en'] !== '') {
            $this->query->set_where('ingatlan_nev_en', 'LIKE', '%' . $params['ingatlan_nev_en'] . '%');
        }
        // Utca
        if (isset($params['utca']) && $params['utca'] !== '') {
            $this->query->set_where('utca', 'LIKE', '%' . $params['utca'] . '%');
        }
  

/** SORREND **/
        // ár szerint
        if (isset($params['order']) && !empty($params['order']) && isset($params['order_by']) && $params['order_by'] == 'ar') {
            if (isset($params['tipus']) && $params['tipus'] == 1) {
                $this->query->set_orderby(array('ar_elado'), $params['order']);
            } elseif (isset($params['tipus']) && $params['tipus'] == 2) {
                $this->query->set_orderby(array('ar_kiado'), $params['order']);
            } else {
                $this->query->set_orderby(array('ar_elado'), $params['order']);
            }
        }
        // dátum szerint
        elseif (isset($params['order']) && !empty($params['order']) && isset($params['order_by']) && $params['order_by'] == 'datum') {
            $this->query->set_orderby(array('hozzaadas_datum'), $params['order']);
        }
        // a metodus elejen van beállított szerint
        else {
            $this->query->set_orderby($params['order'], $params['order_by']);
        }

//$this->query->debug(true);        
//var_dump($params);

        return $this->query->select();
    }

    /**
     *  és visszaadja a limittel lekérdezett de a szűrésnek megfelelő összes sor számát
     */
    public function properties_filter_count_query() {
        return $this->query->found_rows();
    }

    /**
     * 	Az ingatlanok táblában szereplő aktív ingatlanok számát adja vissza
     *  @return integer
     */
    public function get_count() {
        $this->query->set_columns('id');
        $this->query->set_where('status', '=', 1);
        $result = $this->query->select();
        return count($result);
    }

    /**
     * 	Lekérdez minden adatot a megadott táblából (pl.: az option listához)
     * 	
     * 	@param	string	$table 		(tábla neve)
     * 	@return	array
     */
    public function list_query($table) {
        $this->query->set_table(array($table));
        $this->query->set_columns('*');
        return $this->query->select();
    }

    /**
     * 	Lekérdezi a városok nevét és id-jét a city_list táblából (az option listához)
     * 	A paraméter megadja, hogy melyik megyében lévő városokat adja vissza 		
     * 	@param integer	$id 	egy megye id-je (county_id)
     */
    public function city_list_query($id = null) {
        $this->query->set_table(array('city_list'));
        $this->query->set_columns(array('city_id', 'city_name'));
        if (!is_null($id)) {
            $this->query->set_where('county_id', '=', $id);
        }

        return $this->query->select();
    }

    /**
     * 	Lekérdezi a megyék nevét és id-jét a county_list táblából (az option listához)
     */
    public function county_list_query() {
        $this->query->reset();
        $this->query->set_table(array('county_list'));
        $this->query->set_columns(array('county_id', 'county_name'));

        return $this->query->select();
    }

    /**
     * Megye lista előállítása 
     * A megyék mellett a megyében található ingatlanok száma
     *
     * @return string 	 a városok listája html-ben, option listaként
     */
    public function county_list_query_with_prop_no() {
        $megye_lista = '';

        $this->query->set_table(array('county_list'));
        $this->query->set_columns(array('county_id', 'county_name'));
        $result = $this->query->select();

        foreach ($result as $key => $value) {
            $this->query->set_table(array('ingatlanok'));
            $this->query->set_columns(array('id'));
            $this->query->set_where('megye', '=', $result[$key]['county_id']);
            $result2 = $this->query->select();

            $county_id = $result[$key]['county_id'];
            $county_name = $result[$key]['county_name'];



            $search_filter = (self::in_filter('megye', $county_id)) ? "selected" : "";


            $number = count($result2);
            if ($number > 0) {
                $megye_lista .= '<option value="' . $county_id . '" ' . $search_filter . '>' . $county_name . ' (' . $number . ')</option>';
            }
        }

        return $megye_lista;
    }

    /**
     * Város lista előállítása 
     * A városok mellett a városban található ingatlanok számát is visszaadja
     *
     * @return string 	 a városok listája html-ben, option listaként
     */
    public function city_list_query_with_prop_no() {
        $varos_lista = '';

        // Egy lekérdezéses verzió - Time: 0.00065302848815918 seconds

        $this->query->set_table(array('ingatlanok'));
        $this->query->set_columns(array('ingatlanok.id', 'city_list.city_id', 'city_list.city_name'));
        $this->query->set_join('left', 'city_list', 'ingatlanok.varos', '=', 'city_list.city_id');

        /*
          // eladó, vagy kiadó
          if ($this->request->has_query('tipus')) {
          $tipus = $this->request->get_query('tipus');
          } else {
          $tipus = 1;
          }
          $this->query->set_where('ingatlanok.tipus', '=', $tipus);
         */

        $result = $this->query->select();

        $temp = array();
        // temp tomb feltöltése: kulcs a city_name, érték egy tömb; number: a városhoz tartozó ingatlanok száma, id: varos id-je
        foreach ($result as $value) {
            if (isset($temp[$value['city_name']])) {
                $temp[$value['city_name']]['number'] ++;
            } else {
                $temp[$value['city_name']]['number'] = 1;
                $temp[$value['city_name']]['id'] = $value['city_id'];
            }
        }

        // option lista előállítása a temp tömb felhasználásával
        foreach ($temp as $city_name => $value) {
            $search_filter = (self::in_filter('varos', $value['id'])) ? "selected" : "";
            $varos_lista .= '<option value="' . $value['id'] . '" ' . $search_filter . '>' . $city_name . ' (' . $value['number'] . ')</option>' . "\r\n";
        }


        /*
          // Sok lekérdezéses verzió - Time: 0.12254405021667 seconds

          // összes város lekérdezése
          $result = $this->city_list_query();

          foreach ($result as $key => $value) {
          $this->query->set_table(array('ingatlanok'));
          $this->query->set_columns(array('id'));
          $this->query->set_where('varos', '=', $result[$key]['city_id']);
          $result2 = $this->query->select();

          $city_id = $result[$key]['city_id'];
          $city_name = $result[$key]['city_name'];

          $search_filter = (self::in_filter('varos', $city_id)) ? "selected" : "";

          $number = count($result2);
          if ($number > 0) {
          $varos_lista .= '<option value="' . $city_id . '" ' . $search_filter . '>' . $city_name . ' (' . $number . ')</option>';
          }
          }
         */

        return $varos_lista;
    }

    /**
     * Kerület lista előállítása 
     * A városok mellett a városban található ingatlanok számát is visszaadja
     *
     * @return string 	 a városok listája html-ben, option listaként
     */
    public function district_list_query_with_prop_no() {
        $kerulet_lista = '';



// sok lekérdezéses

        $result = $this->list_query('district_list');

        foreach ($result as $key => $value) {
            $this->query->reset();
            $this->query->set_table(array('ingatlanok'));
            $this->query->set_columns(array('id'));
            $this->query->set_where('kerulet', '=', $result[$key]['district_id']);
            $result2 = $this->query->select();

            $district_id = $result[$key]['district_id'];
            $district_name = $result[$key]['district_name'];

            $search_filter = (self::in_filter('kerulet', $district_id)) ? "selected" : "";

            $number = count($result2);
            if ($number > 0) {
                $kerulet_lista .= '<option value="' . $district_id . '" ' . $search_filter . '>' . $district_name . ' (' . $number . ')</option>';
            }
        }



        return $kerulet_lista;
    }

    /**
     * 	Lekérdez miden elemet az ingatlan állapot táblából (az option listához)
     */
    public function allapot_list_query() {
        $this->query->set_table(array('ingatlan_allapot'));
        $this->query->set_columns('*');
        return $this->query->select();
    }

    /**
     * 	Lekérdez miden elemet az ingatlan fűtés táblából (az option listához)
     */
    public function futes_list_query() {
        $this->query->set_table(array('ingatlan_futes'));
        $this->query->set_columns('*');
        return $this->query->select();
    }

    /**
     * 	Lekérdez miden elemet az ingatlan ingatlan_energetika táblából (az option listához)
     */
    public function energetika_list_query() {
        $this->query->set_table(array('ingatlan_energetika'));
        $this->query->set_columns('*');
        return $this->query->select();
    }

    /**
     * 	Frissíti a cookie-t a kedvencekhez
     */
    public function refresh_kedvencek_cookie($id) {
        $kedvencek_array = json_decode(Cookie::get('kedvencek'));

        if (is_array($kedvencek_array) && !in_array($id, $kedvencek_array)) {
            $kedvencek_array[] = $id;
            $kedvencek_json = json_encode($kedvencek_array);
            Cookie::set('kedvencek', $kedvencek_json);
            return true;
        } elseif ($kedvencek_array == null) {
            $kedvencek_array[] = $id;
            $kedvencek_json = json_encode($kedvencek_array);
            Cookie::set('kedvencek', $kedvencek_json);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 	törli az id-t a kedvencek cookie-ból
     */
    public function delete_property_from_cookie($id) {
        $kedvencek_array = json_decode(Cookie::get('kedvencek'));

        foreach ($kedvencek_array as $key => $value) {
            if ($value == $id) {
                unset($kedvencek_array[$key]);
            }
        }

        $kedvencek_array = array_values($kedvencek_array);

        $kedvencek_json = json_encode($kedvencek_array);
        Cookie::set('kedvencek', $kedvencek_json);
    }

    /**
     * 	A kedvencekhez hozzáadott ingatlan html kódját generálja a kedvencek dobozba
     */
    public function favourite_property_html($id) {
        $property_data = $this->get_favourite_properties_data($id);
        $property_data = $property_data[0];


        $photo_array = json_decode($property_data['kepek']);

        $string = '';
        $string .= '<article class="property-item" id="favourite_property_' . $property_data['id'] . '">';
        $string .= '<div class="row">';
        $string .= '<div class="col-md-5">';
        $string .= '<div class="properties__thumb">';
        $string .= '<img src="' . Util::thumb_path(Config::get('ingatlan_photo.upload_path') . $photo_array[0]) . '" alt="' . $property_data['ingatlan_nev'] . '" title="' . $property_data['ingatlan_nev'] . '" />';
        $string .= '<div id="delete_kedvenc_' . $property_data['id'] . '" data-id="' . $property_data['id'] . '" class="favourite-delete"><i class="fa fa-trash"></i></div>';
        $string .= '</div>';
        $string .= '</div>'; // col-md-5
        $string .= '<div class="col-md-7">';
        $string .= '<div class="property-attribute">';
        if (isset($property_data['kerulet'])) {
            $string .= $property_data['city_name'] . ', ' . $property_data['district_name'];
        } else {
            $string .= $property_data['city_name'];
        }
        $string .= '<div class="price">';
        if ($property_data['tipus'] == 1) {
            $string .= '<span class="attr-pricing">' . number_format($property_data['ar_elado'], 0, ',', '.') . ' Ft</span>';
        } elseif ($property_data['tipus'] == 2) {
            $string .= '<span class="attr-pricing">' . number_format($property_data['ar_kiado'], 0, ',', '.') . ' Ft</span>';
        }
        $string .= '</div>';
        $string .= '</div>';
        $string .= '</div>';
        $string .= '<div class="col-md-12">';
        $string .= '<a href="ingatlanok/adatlap/' . $property_data['id'] . '/' . Replacer::filterName($property_data['ingatlan_nev']) . '" title="' . $property_data['ingatlan_nev'] . '" ><h5>' . $property_data['ingatlan_nev'];
        $string .= '</h5></a>';
        $string .= '</div>';


        $string .= '</div>'; //row
        $string .= '</article>';
        return $string;
    }

    /**
     * 	Lekérdezi az ingatlanok referens adatokat
     *  Hozzáadja az ügynök adataihoza a hozzá tartozó ingatlanok számát
     * 	
     *  @param integer 
     * 	@return array 
     */
    public function get_agent($id = null)
    {
        $this->query->set_table(array('users'));
        $this->query->set_columns(array(
            'users.id',
            'users.first_name',
            'users.last_name',
            'users.title_' . $this->lang,
            'users.description_' . $this->lang,
            'users.phone',
            'users.email',
            'users.photo'
        ));

        if (!is_null($id)) {
            $this->query->set_where('id', '=', $id);
        }
        $this->query->set_where('active', '=', 1);
        // csak admin felhasználók!!
        $this->query->set_where('provider_type', '=', 'admin');

        $agents = $this->query->select();
          // ha nincs a feltételeknek megfelelő referens
          if (empty($agents)) {
            return false;
          }

        // ügynökhöz tartozó ingatlanok egy lekérdezéssel (ez gyorsabb!)
        $this->query->set_columns('ref_id');
        $this->query->set_where('status', '=', 1);
        $ref_id_arr = $this->query->select();
        $temp_arr = array();
        // temp_arr tomb feltöltése: kulcs a ref_id, érték az ügynökhöz tartozó ingatlanok száma
        foreach ($ref_id_arr as $value) {
            if (isset($temp_arr[$value['ref_id']])) {
                $temp_arr[$value['ref_id']] ++;
            } else {
                $temp_arr[$value['ref_id']] = 1;
            }
        }

        // a visszaadandó tömbbe belerakjuk a property elemet
        foreach ($agents as $key => &$agent) {
            if (isset($temp_arr[$agent['id']])) {
                $agent['property'] = $temp_arr[$agent['id']];
            } else {
                $agent['property'] = 0;
            }
        }


        /*
          // ügynökhöz tartozó ingatlanok ciklusban több lekérdezéssel (ez lassabb!)
          foreach ($agents as $key => &$agent) {
          $num = $this->belongToAgent($agent['id']);
          $agent['property'] = $num;
          }
         */

        return (!is_null($id)) ? $agents[0] : $agents;
    }

    /**
     * Megadott ügynökhöz tartozó ingatlanok számát kérdezi le
     * @param integer $id
     * @return integer
     */
    public function belongToAgent($id) {
        $this->query->set_columns('COUNT(*)');
        $this->query->set_where('ref_id', '=', $id);
        $result = $this->query->select();
        return (int) $result[0]['COUNT(*)'];
    }

    /**
     * Hasonló ingatlanok
     *
     * @param int       $ingatlan_id
     * @param string    $ingatlan_tipus
     * @param string    $kategoria
     * @param string    $varos
     * @param string 	$ar
     * @return array || false 
     */
    public function hasonloIngatlanok($ingatlan_id, $ingatlan_tipus, $kategoria, $varos, $ar) {
        $min_ar = $ar - ($ar * 0.1);
        $max_ar = $ar + ($ar * 0.1);
        $price_string = ($ingatlan_tipus == 1) ? 'ar_elado' : 'ar_kiado';

        $data = array(
            ':ingatlan_tipus' => $ingatlan_tipus,
            ':kategoria' => $kategoria,
            ':varos' => $varos,
            ':price_string' => $price_string,
            ':min_ar' => $min_ar,
            ':max_ar' => $max_ar,
            ':ingatlan_id' => $ingatlan_id
        );

        /*
          $sql = "SELECT id, ingatlan_nev, tipus, ar_elado, ar_kiado, varos, kategoria, szobaszam, alapterulet, kepek, ingatlan_kategoria.kat_nev, city_list.city_name FROM ingatlanok "
          . "LEFT JOIN ingatlan_kategoria ON ingatlanok.kategoria=ingatlan_kategoria.kat_id "
          . "LEFT JOIN city_list ON ingatlanok.varos=city_list.city_id "
          . "WHERE status = 1 AND tipus = :ingatlan_tipus AND kategoria = :kategoria AND varos = :varos AND (:price_string BETWEEN :min_ar AND :max_ar) AND id != :ingatlan_id ORDER BY id DESC LIMIT 4";
         */

        $sql = "SELECT
                 ingatlanok.id,
                 ingatlanok.ref_num,
                 ingatlanok.ingatlan_nev_" . $this->lang . ",
                 ingatlanok.tipus,
                 ingatlanok.ar_elado,
                 ingatlanok.ar_kiado,
                 ingatlanok.varos,
                 ingatlanok.kategoria,
                 ingatlanok.szobaszam,
                 ingatlanok.alapterulet,
                 ingatlanok.kepek,
                 ingatlan_kategoria.*,
                 city_list.city_name
                 FROM ingatlanok 
                 LEFT JOIN ingatlan_kategoria ON ingatlanok.kategoria = ingatlan_kategoria.kat_id 
                 LEFT JOIN city_list ON ingatlanok.varos = city_list.city_id 
                 WHERE status = 1 AND tipus = :ingatlan_tipus AND kategoria = :kategoria AND varos = :varos AND (:price_string BETWEEN :min_ar AND :max_ar) AND id != :ingatlan_id ORDER BY id DESC LIMIT 4
               ";

        $sth = $this->connect->prepare($sql);
        $result = $sth->execute($data);

        if (!$result) {
            return false;
        } else {
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    /**
     * Növeli az adott ingatlan megtekintéseienk számát 1-gyel
     *  
     * @param integer $id    ingatlan id
     * @return void
     */
    public function increase_no_of_clicks($id)
    {
        $this->query->set_where('id', '=', $id);
        // a második aparaméter a 'fix' attributum
        $this->query->update(array(), array('megtekintes' => 'megtekintes+1'));
    }

    /**
     * Ingatlan adatlap pdf generálása és küldése a böngészőnek
     * 	
     * @param $id integer   ingatlan id
     * @return void 
     */
    public function generate_pdf($id, $settings) {
        $row = $this->get_property_query($id);
        $row = $row[0];

        $photos = json_decode($row['kepek']);
        $photos = array_slice($photos, 0, 3);

        $row['leiras'] = strip_tags($row['leiras']);

        if ($row['tipus'] == 1) {
            $elado = 'Eladó';
        } else {
            $elado = 'Kiadó';
        }

        if ($row['kerulet'] == NULL) {
            $kerulet = '';
        } else {
            $kerulet = $row['kerulet'];
        }

        if ($row['utca_megjelenites'] == 0) {
            $utca = '';
        } else {
            $utca = $row['utca'];
        }

        if ($row['lift'] == 0) {
            $lift = 'nincs';
        } else {
            $lift = 'van';
        }

        if ($row['butor'] == 0) {
            $butor = 'igen';
        } else {
            $butor = 'nem';
        }

        if ($row['allapot']) {
            $allapot = $row['all_leiras'];
        } else {
            $allapot = 'n.a.';
        }

        if ($row['kilatas']) {
            $kilatas = $row['kilatas_leiras'];
        } else {
            $kilatas = 'n.a.';
        }

        if ($row['futes']) {
            $futes = $row['futes_leiras'];
        } else {
            $futes = 'n.a.';
        }

        if ($row['parkolas']) {
            $parkolas = $row['parkolas_leiras'];
        } else {
            $parkolas = 'n.a.';
        }

        if ($row['energetika']) {
            $energetika = $row['energetika_leiras'];
        } else {
            $energetika = 'n.a.';
        }

        if ($row['kert']) {
            $kert = $row['kert_leiras'];
        } else {
            $kert = 'n.a.';
        }

        $extrak = '';

        if ($row['erkely']) {
            $extrak .= 'erkély, ';
        }

        if ($row['terasz']) {
            $extrak .= 'terasz, ';
        }

        if ($row['medence']) {
            $extrak .= 'medence, ';
        }

        if ($row['szauna']) {
            $extrak .= 'szauna, ';
        }

        if ($row['jacuzzi']) {
            $extrak .= 'jacuzzi, ';
        }

        if ($row['kandallo']) {
            $extrak .= 'kandalló, ';
        }

        if ($row['riaszto']) {
            $extrak .= 'riasztó, ';
        }

        if ($row['klima']) {
            $extrak .= 'klíma, ';
        }

        if ($row['ontozorendszer']) {
            $extrak .= 'öntözőrendszer, ';
        }

        if ($row['elektromos_redony']) {
            $extrak .= 'elektromos redőny, ';
        }

        if ($row['konditerem']) {
            $extrak .= 'konditerem, ';
        }

        $extrak = rtrim($extrak, ", ");


        //		define('FPDF_FONTPATH','/home/www/font');
        require(LIBS . '/fpdf.php');
        require(LIBS . '/pdf.php');

        //Instanciation of inherited class
        $pdf = new PDF($settings);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->AddFont('arial', '');
        $pdf->AddFont('arialb', '');
        $pdf->SetFont('arialb', '', 12);
        $pdf->SetXY(50, 20);
        $pdf->SetDrawColor(200, 200, 200);

        // Cell(szélesség, magasság, "szöveg", border (0-L-T-R-B), új pozíció 1- új sor, align, háttérszín, link  )
        $pdf->Cell(120, 10, $this->utf8_to_latin2_hun('Ingatlan nyilvántartási szám: ') . $row['id'], 1, 0, 'C', 0);



        //Set x and y position for the main text, reduce font size and write content
        $pdf->SetXY(10, 35);
        $pdf->SetFont('arial', '', 10);



        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(0, 1, '', 0, 0, 'L', 1);
        $pdf->Ln(5);

        $pdf->SetFont('arialb', '', 13);
        $pdf->MultiCell(0, 8, $this->utf8_to_latin2_hun($row['ingatlan_nev']), 0, 'L', 0);

        $pdf->Ln(5);
        $pdf->SetFont('arial', '', 9);
        $pdf->MultiCell(90, 6, $this->utf8_to_latin2_hun($row['leiras']), 0, 'J', 0);

        $pdf->Ln(5);

        $pdf->SetFont('arial', 'B', 9);
        $pdf->Cell(0, 6, utf8_decode('Adatok:'), 0, 1, 'L', 0);
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(30, 5, utf8_decode('Elhelyezkedés:'), 0, 0, 'L', 0);

        if (isset($row['kerulet']) && ($row['utca_megjelenites'] == 1)) {
            $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($this->utf8_to_latin2_hun($row['city_name']) . ' ' . $kerulet . '. kerület ' . $this->utf8_to_latin2_hun($utca)), 0, 1, 'L', 0);
        } elseif (isset($row['kerulet']) && $row['utca_megjelenites'] == null) {
            $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($this->utf8_to_latin2_hun($row['city_name'])) . ' ' . $kerulet . '. kerület ', 0, 1, 'L', 0);
        } elseif (!isset($row['kerulet']) && ($row['utca_megjelenites'] == 1)) {
            $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($this->utf8_to_latin2_hun($row['city_name']) . ', ' . $this->utf8_to_latin2_hun($utca)), 0, 1, 'L', 0);
        } elseif (!isset($row['kerulet']) && !isset($row['utca_megjelenites'])) {
            $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($this->utf8_to_latin2_hun($row['city_name'])), 0, 1, 'L', 0);
        } else {
            $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($this->utf8_to_latin2_hun($row['city_name'])), 0, 1, 'L', 0);
        }

        $pdf->Cell(30, 5, utf8_decode('Megbízás típusa:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($elado), 0, 1, 'L', 0);
        $pdf->Cell(30, 5, utf8_decode('Ingatlan típusa:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($row['kat_nev']), 0, 1, 'L', 0);

        $pdf->Cell(30, 5, utf8_decode('Állapot:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($row['all_leiras']), 0, 1, 'L', 0);

        $pdf->Cell(30, 5, utf8_decode('Terület:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($row['alapterulet']) . ' nm', 0, 1, 'L', 0);



        $pdf->Cell(30, 5, utf8_decode('Szobák száma:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($row['szobaszam']), 0, 1, 'L', 0);
        if (isset($row['emelet'])) {
            $pdf->Cell(30, 5, utf8_decode('Emelet:'), 0, 0, 'L', 0);
            $pdf->Cell(0, 5, $row['emelet'], 0, 1, 'L', 0);
            $pdf->Cell(30, 5, utf8_decode('Épület szintjei:'), 0, 0, 'L', 0);
            $pdf->Cell(0, 5, $row['epulet_szintjei'], 0, 1, 'L', 0);
        }

        if (isset($row['ar_elado'])) {
            $pdf->Cell(30, 5, utf8_decode('Ár:'), 0, 0, 'L', 0);
            $pdf->Cell(0, 5, $this->utf8_to_latin2_hun(number_format($row['ar_elado'], 0, ',', '.')) . ' Ft', 0, 1, 'L', 0);
        } elseif (isset($row['ar_kiado'])) {
            $pdf->Cell(30, 5, utf8_decode('Bérleti díj:'), 0, 0, 'L', 0);
            $pdf->Cell(0, 5, $this->utf8_to_latin2_hun(number_format($row['ar_kiado'], 0, ',', '.')) . ' Ft', 0, 1, 'L', 0);
        }


        $pdf->Ln(5);


        $pdf->SetFont('arialb', '', 9);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun('Jellemzők:'), 0, 1, 'L', 0);
        $pdf->SetFont('arial', '', 9);

        /*         * ************ JELLEMZŐK ************** */
        $pdf->Cell(30, 5, $this->utf8_to_latin2_hun('Fűtés:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($futes), 0, 1, 'L', 0);

        $pdf->Cell(30, 5, utf8_decode('Kilátás:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($kilatas), 0, 1, 'L', 0);

        $pdf->Cell(30, 5, utf8_decode('Bútorozott:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($butor), 0, 1, 'L', 0);

        $pdf->Cell(30, 5, utf8_decode('Parkolás:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($parkolas), 0, 1, 'L', 0);


        $pdf->Cell(30, 5, $this->utf8_to_latin2_hun('Lift:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($lift), 0, 1, 'L', 0);

        $pdf->Cell(30, 5, $this->utf8_to_latin2_hun('Energetikai tan.:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($energetika), 0, 1, 'L', 0);

        $pdf->Cell(30, 5, $this->utf8_to_latin2_hun('Kert:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($kert), 0, 1, 'L', 0);

        $pdf->Ln(5);


        $pdf->SetFont('arialb', '', 9);




        $pdf->MultiCell(0, 5, $this->utf8_to_latin2_hun('Extrák:'), 0, 'L', 0);
        $pdf->SetFont('arial', '', 9);
        $pdf->MultiCell(100, 5, $this->utf8_to_latin2_hun($extrak), 0, 'L', 0);




        $agent = $this->get_agent($row['ref_id']);

        $pdf->Ln(5);


        $pdf->SetFont('arialb', '', 9);
        $pdf->MultiCell(0, 5, $this->utf8_to_latin2_hun('További információért keresse ingatlan referensünket:'), 0, 'L', 0);
        $pdf->SetFont('arial', '', 9);
        $pdf->MultiCell(0, 5, $this->utf8_to_latin2_hun($agent['user_first_name']) . ' ' . $this->utf8_to_latin2_hun($agent['user_last_name']) . $this->utf8_to_latin2_hun(' | Tel: ') . $this->utf8_to_latin2_hun($agent['user_phone']), 0, 'L', 0);
        $pdf->MultiCell(0, 5, $this->utf8_to_latin2_hun('E-mail: ' . $this->utf8_to_latin2_hun($agent['user_email'])), 0, 'L', 0);




        //		$pdf->Image(UPLOADS_PATH . $row['kezdo_kep'],120,55,80);


        $i = 55;

        foreach ($photos as $value) {

            $pdf->Image(Config::get('ingatlan_photo.upload_path') . '/' . $value, 120, $i, 80);
            $i = $i + 65;
        }






        $pdf->Output('adatlap_' . $id . '.pdf', 'D');
    }

    public function utf8_to_latin2_hun($str) {
        return str_replace(array("\xc3\xb6", "\xc3\xbc", "\xc3\xb3", "\xc5\x91", "\xc3\xba", "\xc3\xa9", "\xc3\xa1", "\xc5\xb1", "\xc3\xad", "\xc3\x96", "\xc3\x9c", "\xc3\x93", "\xc5\x90", "\xc3\x9a", "\xc3\x89", "\xc3\x81", "\xc5\xb0", "\xc3\x8d"), array("\xf6", "\xfc", "\xf3", "\xf5", "\xfa", "\xe9", "\xe1", "\xfb", "\xed", "\xd6", "\xdc", "\xd3", "\xd5", "\xda", "\xc9", "\xc1", "\xdb", "\xcd"), $str);
    }

    /**
     * 	Lekérdezi a városok nevét és id-jét a city_list táblából (az option listához)
     * 	A paraméter megadja, hogy melyik megyében lévő városokat adja vissza 		
     * 	@param integer	$id 	egy megye id-je (county_id)
     */
    public function city_list_grouped_by_county() {
        $this->query->set_table(array('city_list'));
        $this->query->set_columns('*');

        $this->query->set_join('left', 'county_list', 'city_list.county_id', '=', 'county_list.county_id');
        //       $this->query->set_orderby(array('city_name'), 'ASC');
        $result = $this->query->select();

        $arr = array();
        foreach ($result as $key => $item) {
            $arr[$item['county_name']][$key] = $item;
        }

        ksort($arr, SORT_REGULAR);
        return $arr;
    }

    /**
     * 	Lekérdezi a városok nevét és id-jét a city_list táblából (az option listához)
     * 	A paraméter megadja, hogy melyik megyében lévő városokat adja vissza 		
     * 	@param integer	$id 	egy megye id-je (county_id)
     */
    public function get_filter_params($filter) {
        $filter_with_names = array();

        if (isset($filter['tipus']) && $filter['tipus'] == 1) {
            // $filter_with_names['tipus'] = 'Eladó';
            $filter_with_names['tipus'] = 1;
        }
        if (isset($filter['tipus']) && $filter['tipus'] == 2) {
            // $filter_with_names['tipus'] = 'Kiadó';
            $filter_with_names['tipus'] = 2;
        }
        // kerület
        if (isset($filter['kerulet']) && $filter['kerulet'] !== '') {

            foreach ($filter['kerulet'] as $value) {
                $filter_with_names['kerulet'][] = 'Budapest, ' . $value . '. kerület';
            }

            //$filter_with_names['kerulet'][] = 'Budapest, ' . $filter['kerulet'] . '. kerület';
        }
        // város
        if (isset($filter['varos']) && $filter['varos'] !== '') {
            /*
              foreach ($filter['varos'] as $value) {
              $filter_with_names['varos'][] = $this->getCityNameById($value);
              }
             */
            $filter_with_names['varos'][] = $this->getCityNameById($filter['varos']);
        }
        // kategória
        if (isset($filter['kategoria']) && $filter['kategoria'] !== '') {
            /*
              foreach ($filter['kategoria'] as $value) {
              $filter_with_names['kategoria'][] = $this->getCategoryNameById($value);
              }
             */
            $filter_with_names['kategoria'][] = $this->getCategoryNameById($filter['kategoria']);
        }

        if (isset($filter['min_ar'])) {
            $filter_with_names['min_ar'] = $filter['min_ar'];
        }

        if (isset($filter['max_ar'])) {
            $filter_with_names['max_ar'] = $filter['max_ar'];
        }

        if (isset($filter['min_alapterulet'])) {
            $filter_with_names['min_alapterulet'] = $filter['min_alapterulet'];
        }

        if (isset($filter['max_alapterulet'])) {
            $filter_with_names['max_alapterulet'] = $filter['max_alapterulet'];
        }

        if (isset($filter['min_szobaszam'])) {
            $filter_with_names['min_szobaszam'] = $filter['min_szobaszam'];
        }

        if (isset($filter['max_szobaszam'])) {
            $filter_with_names['max_szobaszam'] = $filter['max_szobaszam'];
        }

        if (isset($filter['order'])) {
            $filter_with_names['order'] = $filter['order'];
        }

        if (isset($filter['order_by'])) {
            $filter_with_names['order_by'] = $filter['order_by'];
        }

        if (isset($filter['allapot']) && $filter['allapot'] !== '') {
            $filter_with_names['allapot'] = $filter['allapot'];
        }

        if (isset($filter['futes']) && $filter['futes'] !== '') {
            $filter_with_names['futes'] = $filter['futes'];
        }

        if (isset($filter['szerkezet']) && $filter['szerkezet'] !== '') {
            $filter_with_names['szerkezet'] = $filter['szerkezet'];
        }

        if (isset($filter['energetika']) && $filter['energetika'] !== '') {
            $filter_with_names['energetika'] = $filter['energetika'];
        }

        if (isset($filter['lift']) && $filter['lift'] !== '') {
            $filter_with_names['lift'] = $filter['lift'];
        }

        if (isset($filter['kilatas']) && $filter['kilatas'] !== '') {
            $filter_with_names['kilatas'] = $filter['kilatas'];
        }

        if (isset($filter['kert']) && $filter['kert'] !== '') {
            $filter_with_names['kert'] = $filter['kert'];
        }

        if (isset($filter['ref_num']) && $filter['ref_num'] !== '') {
            $filter_with_names['ref_num'] = $filter['ref_num'];
        }

        if (isset($filter['ref_id']) && $filter['ref_id'] !== '') {
            $filter_with_names['ref_id'] = $filter['ref_id'];
        }

        if (isset($filter['utca']) && $filter['utca'] !== '') {
            $filter_with_names['utca'] = $filter['utca'];
        }

        if (isset($filter['ingatlan_nev_' . LANG]) && $filter['ingatlan_nev_' . LANG] !== '') {
            $filter_with_names['ingatlan_nev_' . LANG] = $filter['ingatlan_nev_' . LANG];
        }


        return $filter_with_names;
    }

    /**
     * 
     */
    public function getCityNameById($id) {
        $this->query->set_table(array('city_list'));
        $this->query->set_columns('city_name');
        $this->query->set_where('city_id', '=', $id);
        $result = $this->query->select();
        return $result[0]['city_name'];
    }

    /**
     * ingatlan_kategoria tablabol kérdez le egy rekordot id-alapján
     * @param integer $id
     */
    public function getCategoryNameById($id) {
        $this->query->set_table(array('ingatlan_kategoria'));
        $this->query->set_where('kat_id', '=', $id);
        $result = $this->query->select();
        return $result[0];
    }

    /**
     * Megállapítja, hogy a filter paraméter létezik-e a filter session tömbben
     * Ha megyegyezik a paraméterként átadott értékkel, akkor true-t ad vissza 
     * 
     * @param	string	$filter_name a filter neve (pl: megye
     * @param	string	$value a filter elem értéke
     * @return	boolean	true, false
     */
    public static function in_filter($filter_name, $value) {
        $filter = Session::get('ingatlan_filter');

        if (isset($filter)) {
            if (isset($filter[$filter_name])) {
                if (is_array($filter[$filter_name])) {
                    if (in_array($value, $filter[$filter_name])) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    if ($filter[$filter_name] == $value) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    /**
     * A felhasználó által árváltozás értesítésre kijelölt ingatlanok adatait adja vissza
     *
     * @param integer $user_id
     * @return array
     */
    public function followedByProperty($user_id)
    {
        // user-hez tartozó ingatlan id-k lekérdezése az arvaltozas tablabol    
        $this->query->set_table('arvaltozas');
        $this->query->set_columns('property_id');
        $this->query->set_where('user_id', '=', $user_id);
        $temp = $this->query->select();
        $id_array = array();

        if(!empty($temp)) {
            foreach ($temp as $value) {
                $id_array[] = $value['property_id'];
            }
            unset($temp);
        } else {
            return $id_array;
        }

        // ingatlan adatok lekérdezése
        $this->query->set_columns(array(
            'ingatlanok.id',
            'ingatlanok.ref_num',
            'ingatlanok.ingatlan_nev_' . $this->lang,
            'ingatlanok.status',
            'ingatlanok.tipus',
            'ingatlanok.kerulet',
            'ingatlanok.ar_elado',
            'ingatlanok.ar_elado_eredeti',
            'ingatlanok.ar_kiado',
            'ingatlanok.ar_kiado_eredeti',
            'ingatlanok.alapterulet',
            'ingatlanok.szobaszam',
            'ingatlanok.kepek',
            'ingatlanok.varos',
            'ingatlan_kategoria.*',
            'district_list.district_name',
            'city_list.city_name'
        ));

        $this->query->set_join('left', 'ingatlan_kategoria', 'ingatlanok.kategoria', '=', 'ingatlan_kategoria.kat_id');
        $this->query->set_join('left', 'city_list', 'ingatlanok.varos', '=', 'city_list.city_id');
        $this->query->set_join('left', 'district_list', 'ingatlanok.kerulet', '=', 'district_list.district_id');

        $this->query->set_where('ingatlanok.id', 'in', $id_array);
        $this->query->set_where('status', '=', 1);
        $this->query->set_orderby('ingatlanok.id', 'DESC');

        return $this->query->select();
    }


}
?>