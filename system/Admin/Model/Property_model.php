<?php
namespace System\Admin\Model;
use System\Core\AdminModel;
use \PDO;
use System\Libs\Session;
use System\Libs\Auth;

class Property_model extends AdminModel {

    protected $table = 'ingatlanok';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * INSERT
     */
    public function insert($data)
    {
       return $this->query->insert($data);
    }

    /**
     * UPDATE
     */
    public function update($id, $data)
    {
        $this->query->set_where('id', '=', $id);
        return $this->query->update($data);
    }

    /**
     * DELETE
     */
    public function delete($id)
    {
        $this->query->set_where('id', '=', $id);
        return $this->query->delete();
    }

    /**
     *  Ügynök azonosító módosítása a megadott id-jű rekordoknál
     *
     * @param array     $id_arr - rekordok id-je, ahol módosítani kell a referens id-t
     * @param inerger   $ref_id - referens id, amire módosítani kell
     * @return integer || false
     */
    public function changeAgent(array $id_arr, $ref_id)
    {
        $this->query->set_where('id', 'in', $id_arr);
        return $this->query->update(array('ref_id' => $ref_id));
    }


/* ------------------*/

    /**
     * 	A lakások listájához kérdezi le az adatokat
     */
    public function all_property_query()
    {
// $this->query->debug(true);
        $this->query->set_columns(array(
            'ingatlanok.id',
            'ingatlanok.ref_num',
            'ingatlanok.kepek',
            'ingatlanok.kategoria',
            'ingatlanok.status',
            'ingatlanok.kiemeles',
            'ingatlanok.tipus',
            'ingatlanok.ar_elado',
            'ingatlanok.ar_kiado',
            'ingatlanok.alapterulet',
            'ingatlanok.szobaszam',
            'ingatlanok.megtekintes',
            'ingatlan_kategoria.kat_nev_hu',
            'users.first_name',
            'users.last_name',
            'district_list.district_name',
            'city_list.city_name'
        ));

        $this->query->set_join('left', 'ingatlan_kategoria', 'ingatlanok.kategoria', '=', 'ingatlan_kategoria.kat_id');
        $this->query->set_join('left', 'users', 'ingatlanok.ref_id', '=', 'users.id');
        $this->query->set_join('left', 'district_list', 'ingatlanok.kerulet', '=', 'district_list.district_id');
        $this->query->set_join('left', 'city_list', 'ingatlanok.varos', '=', 'city_list.city_id');
//csökkenő sorrendben adja vissza
        $this->query->set_orderby(array('id'), 'DESC');
        return $this->query->select();
    }

    /**
     * 	Lekérdezi az ingatlanok összes adatát id alapján
     * 	
     * 	@param array 
     */
    public function getPropertyDetails($id)
    {
// $this->query->debug(true);
        $this->query->set_columns(array(
            'ingatlanok.*',
            'ingatlan_kategoria.kat_nev_hu',
            'district_list.district_name',
            'city_list.city_name',
            'county_list.county_name',
            
            'ingatlan_allapot.all_leiras_hu',
            'ingatlan_futes.futes_leiras_hu',
            'ingatlan_parkolas.parkolas_leiras_hu',
            'ingatlan_kilatas.kilatas_leiras_hu',
            'ingatlan_energetika.energetika_leiras_hu',
            'ingatlan_kert.kert_leiras_hu',
            
            'users.first_name',
            'users.last_name'
        ));

        $this->query->set_join('left', 'city_list', 'ingatlanok.varos', '=', 'city_list.city_id');
        $this->query->set_join('left', 'county_list', 'ingatlanok.megye', '=', 'county_list.county_id');
        $this->query->set_join('left', 'district_list', 'ingatlanok.kerulet', '=', 'district_list.district_id');
        
        $this->query->set_join('left', 'ingatlan_allapot', 'ingatlanok.allapot', '=', 'ingatlan_allapot.all_id');
        $this->query->set_join('left', 'ingatlan_emelet', 'ingatlanok.emelet', '=', 'ingatlan_emelet.emelet_id');
        $this->query->set_join('left', 'ingatlan_energetika', 'ingatlanok.energetika', '=', 'ingatlan_energetika.energetika_id');
        $this->query->set_join('left', 'ingatlan_fenyviszony', 'ingatlanok.fenyviszony', '=', 'ingatlan_fenyviszony.fenyviszony_id');
        $this->query->set_join('left', 'ingatlan_furdo_wc', 'ingatlanok.furdo_wc', '=', 'ingatlan_furdo_wc.furdo_wc_id');
        $this->query->set_join('left', 'ingatlan_futes', 'ingatlanok.futes', '=', 'ingatlan_futes.futes_id');
        $this->query->set_join('left', 'ingatlan_haz_allapot_belul', 'ingatlanok.haz_allapot_belul', '=', 'ingatlan_haz_allapot_belul.haz_allapot_belul_id');
        $this->query->set_join('left', 'ingatlan_haz_allapot_kivul', 'ingatlanok.haz_allapot_kivul', '=', 'ingatlan_haz_allapot_kivul.haz_allapot_kivul_id');
        $this->query->set_join('left', 'ingatlan_kategoria', 'ingatlanok.kategoria', '=', 'ingatlan_kategoria.kat_id');
        $this->query->set_join('left', 'ingatlan_kert', 'ingatlanok.kert', '=', 'ingatlan_kert.kert_id');
        $this->query->set_join('left', 'ingatlan_kilatas', 'ingatlanok.kilatas', '=', 'ingatlan_kilatas.kilatas_id');
        $this->query->set_join('left', 'ingatlan_parkolas', 'ingatlanok.parkolas', '=', 'ingatlan_parkolas.parkolas_id');
        $this->query->set_join('left', 'ingatlan_szerkezet', 'ingatlanok.szerkezet', '=', 'ingatlan_szerkezet.szerkezet_id');
        $this->query->set_join('left', 'ingatlan_szoba_elrendezes', 'ingatlanok.szoba_elrendezes', '=', 'ingatlan_szoba_elrendezes.szoba_elrendezes_id');
        
        $this->query->set_join('left', 'users', 'ingatlanok.ref_id', '=', 'users.id');

        $this->query->set_where('ingatlanok.id', '=', $id);

        //$this->query->set_where('status', '=', 1);
        $result = $this->query->select();
        return (empty($result)) ? $result : $result[0];
    }

    /**
     * 	Lakás adatainak módosításához kérdezi le az összes adatot a táblából
     */
    public function getPropertyAlldata($id)
    {
        $this->query->set_where('id', '=', $id);
        $result = $this->query->select();
        return $result[0];
    }

    /**
     * 	Lekérdez minden adatot a megadott táblából (pl.: az option listához)
     * 	
     * 	@param	string	$table 		(tábla neve)
     * 	@return	array
     */
    public function list_query($table)
    {
        $this->query->set_table(array($table));
        $this->query->set_columns('*');
        return $this->query->select();
    }

    /**
     * Az ingatlanhoz tartozó file-ok nevének lekérdezése
     * A második paraméterben megadhatjuk, hogy csak a képeket, vagy a dokumentumokat akarjuk megkapni
     * Ha nincs második paraméter, akkor visszad egy asszociatív tömböt, amiben megtalálható egy 'kepek' és egy 'docs' tömb
     *
     * @param integer $id
     * @param string $type (értéke: 'kepek' vagy 'docs')
     * @return array 
     */
    public function getFilenames($id, $type = null)
    {
        $this->query->set_columns(array('kepek', 'docs'));
        $this->query->set_where('id', '=', $id);
        $result = $this->query->select();

        $photos_arr = array();
        $docs_arr = array();

        if (!empty($result[0]['kepek'])) {
            //képek nevét tartalmazó tömb
            $photos_arr = json_decode($result[0]['kepek']);
        }
        if (!empty($result[0]['docs'])) {
            //dokumentumok nevét tartalmazó tömb
            $docs_arr = json_decode($result[0]['docs']);
        }

        if ($type == 'kepek') {
            return $photos_arr;
        }
        elseif ($type == 'docs') {
            return $docs_arr;
        }
        else {
            return array('kepek' => $photos_arr, 'docs' => $docs_arr);
        }
    }

    /**
     *  Lekérdezi a városok nevét és id-jét a city_list táblából (az option listához)
     *  A paraméter megadja, hogy melyik megyében lévő városokat adja vissza        
     *  @param integer  $id     egy megye id-je (county_id)
     *  @return array
     */
    public function streetList($id = null)
    {
        $this->query->set_table(array('street_list'));
        $this->query->set_columns(array('street_id', 'street_name', 'zip_code'));
        if (!is_null($id)) {
            $this->query->set_where('district', '=', $id);
        }
        return $this->query->select();
    }

    /**
     * 	Lekérdezi a városok nevét és id-jét a city_list táblából (az option listához)
     * 	A paraméter megadja, hogy melyik megyében lévő városokat adja vissza 		
     * 	@param integer	$id 	egy megye id-je (county_id)
     */
    public function cityList($id = null)
    {
        $this->query->set_table(array('city_list'));
        $this->query->set_columns(array('city_id', 'city_name'));
        if (!is_null($id)) {
            $this->query->set_where('county_id', '=', $id);
        }
        $this->query->set_orderby(array('city_name'), 'ASC');
        return $this->query->select();
    }

    /**
     * 	Lekérdezi a megyék nevét és id-jét a county_list táblából (az option listához)
     */
    public function countyList()
    {
        $this->query->set_table(array('county_list'));
        $this->query->set_columns(array('county_id', 'county_name'));
        return $this->query->select();
    }

    /**
     * 	Lekérdez miden elemet az ingatlana_allapot táblából (az option listához)
     */
    public function allapot_list_query()
    {
        $this->query->set_table(array('ingatlan_allapot'));
        $this->query->set_columns(array('all_id', 'all_leiras'));
        return $this->query->select();
    }

    /**
     * 	Lekérdez miden elemet az ingatlan_futés táblából (az option listához)
     */
    public function futes_list_query()
    {
        $this->query->set_table(array('ingatlan_futes'));
        $this->query->set_columns(array('futes_id', 'futes_leiras'));
        return $this->query->select();
    }

    /**
     * 	Lekérdez miden elemet az ingatlan ingatlan_energetika táblából (az option listához)
     */
    public function energetika_list_query()
    {
        $this->query->set_table(array('ingatlan_energetika'));
        $this->query->set_columns(array('energetika_id', 'energetika_leiras'));
        return $this->query->select();
    }

    /**
     * 	Lekérdez miden felhasználót a users táblából (az option listához)
     */
    public function usersList()
    {
        $this->query->set_table(array('users'));
        $this->query->set_columns(array('id', 'first_name', 'last_name'));
        $this->query->set_where('provider_type', '=', 'admin');
        return $this->query->select();
    }

    /**
     * 	Lekérdezi a paraméterben megadott tábla rekordjainak számát
     *
     * 	@param	string	$table
     * 	@return	integer
     */
    public function count($table)
    {
        $sth = $this->connect->query("SELECT COUNT(*) FROM `" . $table . "`");
        $result = $sth->fetch(PDO::FETCH_NUM);
        return (int) $result[0];
    }

    /**
     * A getPropertys() metodus altal lekerdezett talált sorok számát adja vissza
     */
    public function foundRows()
    {
        return $this->query->found_rows();
    }

    /**
     * Ingatlanok lisistájának lekérdezése szűréssel
     *
     * @param $array $request_data
     * @param integer $display_start
     * @param integer $display_length
     */
    public function filteredPropertys($request_data, $display_start, $display_length)
    {
        $this->query->set_columns('SQL_CALC_FOUND_ROWS 
            `ingatlanok`.`id`,
            `ingatlanok`.`ref_num`,
            `ingatlanok`.`kepek`,
            `ingatlanok`.`kategoria`,
            `ingatlanok`.`status`,
            `ingatlanok`.`kiemeles`,
            `ingatlanok`.`tipus`,
            `ingatlanok`.`ar_elado`,
            `ingatlanok`.`ar_kiado`,
            `ingatlanok`.`alapterulet`,
            `ingatlanok`.`szobaszam`,
            `ingatlanok`.`kerulet`,
            `ingatlanok`.`utca`,
            `ingatlanok`.`megtekintes`,
            `ingatlan_kategoria`.`kat_nev_hu`,
            `users`.`first_name`,
            `users`.`last_name`,
            `district_list`.`district_name`,
            `city_list`.`city_name`'
        );

        $this->query->set_join('left', 'ingatlan_kategoria', 'ingatlanok.kategoria', '=', 'ingatlan_kategoria.kat_id');
        $this->query->set_join('left', 'users', 'ingatlanok.ref_id', '=', 'users.id');
        $this->query->set_join('left', 'district_list', 'ingatlanok.kerulet', '=', 'district_list.district_id');
        $this->query->set_join('left', 'city_list', 'ingatlanok.varos', '=', 'city_list.city_id');

        $this->query->set_offset($display_start);
        $this->query->set_limit($display_length);

        // ha nem superadmin a bejelentkezett felhasználó, akkor csak a saját ingatlanja jelennek meg
        if (!Auth::isSuperadmin()) {
            $this->query->set_where('ingatlanok.ref_id', '=', Auth::getUser('id'));
        }
        
        //$this->query->set_where('ingatlanok.deleted', '=', 0);

        //szűrés beállítások
        if (isset($request_data['action']) && $request_data['action'] == 'filter') {

            if (isset($request_data['id']) && !empty($request_data['id'])) {
                $this->query->set_where('ingatlanok.id', '=', $request_data['id']);
            }
        if (isset($request_data['ref_num']) && !empty($request_data['ref_num'])) {
            $this->query->set_where('ingatlanok.ref_num', '=', $request_data['ref_num']);
        }
            if (isset($request_data['status']) && ($request_data['status'] != '')) {
                $this->query->set_where('ingatlanok.status', '=', $request_data['status']);
            }
            if (isset($request_data['kiemeles']) && ($request_data['kiemeles'] != '')) {
                $this->query->set_where('ingatlanok.kiemeles', '=', $request_data['kiemeles']);
            }
            if (isset($request_data['ref_id']) && !empty($request_data['ref_id'])) {
                $this->query->set_where('ingatlanok.ref_id', '=', $request_data['ref_id']);
            }
            if (isset($request_data['tipus']) && !empty($request_data['tipus'])) {
                $this->query->set_where('ingatlanok.tipus', '=', $request_data['tipus']);
            }
            if (isset($request_data['kategoria']) && !empty($request_data['kategoria'])) {
                $this->query->set_where('ingatlanok.kategoria', '=', $request_data['kategoria']);
            }
            if (isset($request_data['megye']) && !empty($request_data['megye'])) {
                $this->query->set_where('ingatlanok.megye', '=', $request_data['megye']);
            }
            if (isset($request_data['varos']) && !empty($request_data['varos'])) {
                $this->query->set_where('ingatlanok.varos', '=', $request_data['varos']);
            }
            if (isset($request_data['kerulet']) && !empty($request_data['kerulet'])) {
                $this->query->set_where('ingatlanok.kerulet', '=', $request_data['kerulet']);
            }
            if (isset($request_data['tulaj_nev']) && !empty($request_data['tulaj_nev'])) {
                $this->query->set_where('ingatlanok.tulaj_nev', 'LIKE', '%' . $request_data['tulaj_nev'] . '%');
            }

            /*             * ************************* ÁR ALAPJÁN KERESÉS **************************** */

            // csak minimum ár van megadva
            if ((isset($request_data['min_ar']) && !empty($request_data['min_ar'])) AND ( $request_data['min_ar'] > 0) AND ( isset($request_data['max_ar']) AND $request_data['max_ar'] == '')) {
                if (isset($request_data['tipus']) && $request_data['tipus'] == 1) {
                    $this->query->set_where('ar_elado', '>=', $request_data['min_ar']);
                } elseif (isset($request_data['tipus']) && $request_data['tipus'] == 2) {
                    $this->query->set_where('ar_kiado', '>=', $request_data['min_ar']);
                }
            }

            // csak maximum ár van megadva
            if ((isset($request_data['max_ar']) && !empty($request_data['max_ar'])) AND ( $request_data['max_ar'] > 0) AND ( isset($request_data['min_ar']) AND $request_data['min_ar'] == '')) {
                if (isset($request_data['tipus']) && $request_data['tipus'] == 1) {
                    $this->query->set_where('ar_elado', '<=', $request_data['max_ar']);
                } elseif (isset($request_data['tipus']) && $request_data['tipus'] == 2) {
                    $this->query->set_where('ar_kiado', '<=', $request_data['max_ar']);
                }
            }
            // minimum és maximum ár is meg van adva
            if ((isset($request_data['min_ar']) && !empty($request_data['min_ar'])) AND ( $request_data['min_ar'] > 0) AND ( isset($request_data['max_ar']) && !empty($request_data['max_ar'])) AND ( $request_data['max_ar'] > 0)) {
                if (isset($request_data['tipus']) && $request_data['tipus'] == 1) {
                    $this->query->set_where('ar_elado', '>=', $request_data['min_ar']);
                    $this->query->set_where('ar_elado', '<=', $request_data['max_ar']);
                } elseif (isset($request_data['tipus']) && $request_data['tipus'] == 2) {
                    $this->query->set_where('ar_kiado', '>=', $request_data['min_ar']);
                    $this->query->set_where('ar_kiado', '<=', $request_data['max_ar']);
                }
            }


            /*             * ************************* TERÜLET ALAPJÁN KERESÉS **************************** */

            // csak minimum terület van megadva
            if ((isset($request_data['min_alapterulet']) && !empty($request_data['min_alapterulet'])) AND ( $request_data['min_alapterulet'] > 0) AND ( isset($request_data['max_alapterulet']) AND $request_data['max_alapterulet'] == '')) {
                $this->query->set_where('alapterulet', '>=', $request_data['min_alapterulet']);
            }

            // csak maximum terulet van megadva
            if ((isset($request_data['max_alapterulet']) && !empty($request_data['max_alapterulet'])) AND ( $request_data['max_alapterulet'] > 0) AND ( isset($request_data['min_alapterulet']) AND $request_data['min_alapterulet'] == '')) {
                $this->query->set_where('alapterulet', '<=', $request_data['max_alapterulet']);
            }
            // minimum és maximum ár is meg van adva
            if ((isset($request_data['min_alapterulet']) && !empty($request_data['min_alapterulet'])) AND ( $request_data['min_alapterulet'] > 0) AND ( isset($request_data['max_alapterulet']) && !empty($request_data['max_alapterulet'])) AND ( $request_data['max_alapterulet'] > 0)) {
                $this->query->set_where('alapterulet', '>=', $request_data['min_alapterulet']);
                $this->query->set_where('alapterulet', '<=', $request_data['max_alapterulet']);
            }

            /*             * ********************* MINIMUM SZOBASZÁM ********************** */
            // minimum szobaszám
            if (isset($request_data['szobaszam']) && !empty($request_data['szobaszam']) AND $request_data['szobaszam'] > 0) {
                $this->query->set_where('szobaszam', '>=', $request_data['szobaszam']);
            }
        }

        //rendezés
        if (isset($request_data['order'][0]['column']) && isset($request_data['order'][0]['dir'])) {
            $num = $request_data['order'][0]['column']; //ez az oszlop száma
            $dir = $request_data['order'][0]['dir']; // asc vagy desc
            $order = $request_data['columns'][$num]['name']; // az oszlopokat az adatbázis mezői szerint kell elnevezni (a javascript datattables columnDefs beállításában)
        
        // referenciaszám szerint rendezés    
            if ($order == "ref_num") {
                $this->query->set_orderby('ref_num', $dir);
            }            
        // referens neve szerint rendezés    
            if ($order == "ref_id") {
                //$order = array('first_name');
                $this->query->set_orderby('first_name', $dir);
                $this->query->set_orderby('last_name', 'asc');
            }
        // ingatlan tipus szerint rendezés    
            if ($order == "tipus") {
                //$order = array('kat_nev_hu');
                $this->query->set_orderby('tipus', $dir);
            }            
        // ingatlan kategória szerint rendezés    
            if ($order == "kategoria") {
                //$order = array('kat_nev_hu');
                $this->query->set_orderby('kat_nev_hu', $dir);
            }
        // város szerint rendezés    
            if ($order == "varos") {
                // $order = array('city_name');
                $this->query->set_orderby('city_name', $dir);
            }
        // alapterület szerint rendezés    
            if ($order == "alapterulet") {
                $this->query->set_orderby('alapterulet', $dir);
            }
        // status szerint rendezés    
            if ($order == "status") {
                $this->query->set_orderby('status', $dir);
            }

        }

        return $this->query->select();
    }

    /**
     * 	Lekérdezi a városok nevét és id-jét a city_list táblából (az option listához)
     * 	A paraméter megadja, hogy melyik megyében lévő városokat adja vissza 		
     * 	@param integer	$id 	egy megye id-je (county_id)
     */
    public function streetSuggestions($text)
    {
        $this->query->set_table(array('street_list'));
        $this->query->set_columns('*');
        $this->query->set_where('street_name', 'LIKE', urldecode($text) . '%');

        $this->query->set_orderby(array('street_name'), 'ASC');
        $result = $this->query->select();

        $suggestions = array();
        foreach ($result as $value) {
            $suggestions[] = array(
                "value" => $value['street_name'],
                "data" => $value['street_name'] . ' (' . $value['zip_code'] . ')'
            );
        }

        return $suggestions;
    }

}
?>