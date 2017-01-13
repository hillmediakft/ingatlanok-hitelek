<?php
namespace System\Admin\Model;
use System\Core\Admin_model;
use System\Libs\Session;

/**
 * Report model
 */
class Report_model extends Admin_model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Ingatlanok lekérdezése referens (user_id) szerint, 
     * az utolsó szűrési feltételekkel
     * @return array ingatlanok tömbje
     */
    public function get_properties()
    {
        $request_data = Session::get('property_filter');
// $this->query->debug(true);
        $this->query->set_table(array('ingatlanok'));
        $this->query->set_columns(array(
            'ingatlanok.id',
            'ingatlanok.kategoria',
            'ingatlanok.status',
            'ingatlanok.kiemeles',
            'ingatlanok.tipus',
            'ingatlanok.ar_elado',
            'ingatlanok.ar_kiado',
            'ingatlanok.allapot',
            'ingatlanok.alapterulet',
            'ingatlanok.szobaszam',
            'ingatlan_kategoria.kat_nev',
            'ingatlanok.megtekintes',
            'users.user_first_name',
            'users.user_last_name',
            'district_list.district_name',
            'city_list.city_name',
            'ingatlan_allapot.all_leiras'
        ));

        $this->query->set_join('left', 'ingatlan_kategoria', 'ingatlanok.kategoria', '=', 'ingatlan_kategoria.kat_id');
        $this->query->set_join('left', 'users', 'ingatlanok.ref_id', '=', 'users.user_id');
        $this->query->set_join('left', 'district_list', 'ingatlanok.kerulet', '=', 'district_list.district_id');
        $this->query->set_join('left', 'city_list', 'ingatlanok.varos', '=', 'city_list.city_id');
        $this->query->set_join('left', 'ingatlan_allapot', 'ingatlanok.allapot', '=', 'ingatlan_allapot.all_id');

        if (Session::get('user_role_id') != 1) {
            $this->query->set_where('ref_id', '=', Session::get('user_id'));
        }

        //szűrés beállítások
        if (isset($request_data['id']) && !empty($request_data['id'])) {
            $this->query->set_where('id', '=', $request_data['id']);
        }
        if (isset($request_data['status']) && ($request_data['status'] != '')) {
            $this->query->set_where('status', '=', $request_data['status']);
        }
        if (isset($request_data['kiemeles']) && ($request_data['kiemeles'] != '')) {
            $this->query->set_where('kiemeles', '=', $request_data['kiemeles']);
        }
        if (isset($request_data['ref_id']) && !empty($request_data['ref_id'])) {
            $this->query->set_where('ref_id', '=', $request_data['ref_id']);
        }
        if (isset($request_data['tipus']) && !empty($request_data['tipus'])) {
            $this->query->set_where('tipus', '=', $request_data['tipus']);
        }
        if (isset($request_data['kategoria']) && !empty($request_data['kategoria'])) {
            $this->query->set_where('kategoria', '=', $request_data['kategoria']);
        }
        if (isset($request_data['megye']) && !empty($request_data['megye'])) {
            $this->query->set_where('megye', '=', $request_data['megye']);
        }
        if (isset($request_data['varos']) && !empty($request_data['varos'])) {
            $this->query->set_where('varos', '=', $request_data['varos']);
        }
        if (isset($request_data['kerulet']) && !empty($request_data['kerulet'])) {
            $this->query->set_where('kerulet', '=', $request_data['kerulet']);
        }
        if (isset($request_data['tulaj_nev']) && !empty($request_data['tulaj_nev'])) {
            $this->query->set_where('tulaj_nev', 'LIKE', '%' . $request_data['tulaj_nev'] . '%');
        }

        /*         * ************************* ÁR ALAPJÁN KERESÉS **************************** */

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


        /*         * ************************* TERÜLET ALAPJÁN KERESÉS **************************** */

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

        /*         * ********************* MINIMUM SZOBASZÁM ********************** */
        // minimum szobaszám
        if (isset($request_data['szobaszam']) && !empty($request_data['szobaszam']) AND $request_data['szobaszam'] > 0) {
            $this->query->set_where('szobaszam', '>=', $request_data['szobaszam']);
        }

        $this->query->set_orderby(array('id'), 'DESC');
        return $this->query->select();
    }

}
?>