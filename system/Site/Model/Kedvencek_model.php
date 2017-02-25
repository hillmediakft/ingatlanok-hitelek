<?php

namespace System\Site\Model;

use System\Core\SiteModel;
use System\Libs\Session;
use System\Libs\Cookie;
use \PDO;

class Kedvencek_model extends SiteModel {

    function __construct() {
        parent::__construct();
    }

    /**
     * 	Lekérdezi az ingatlanok táblából a kiemelet ingatlanokat
     * 	
     * 	@param array 
     */
    public function get_favourite_properties($id_array) {
// $this->query->debug(true);
        $this->query->set_table('ingatlanok');
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
     * 	Frissíti a cookie-t a kedvencekhez
     */
    public function refresh_kedvencek_cookie($id) {
        $kedvencek_array = json_decode(Cookie::get('kedvencek'));

        if (is_array($kedvencek_array) && !in_array($id, $kedvencek_array)) {
            $kedvencek_array[] = $id;
            $kedvencek_json = json_encode($kedvencek_array);
            Cookie::set('kedvencek', $kedvencek_json);
            return true;

            //       echo $this->favourite_property_html($id);
        } elseif ($kedvencek_array == null) {
            $kedvencek_array[] = $id;
            $kedvencek_json = json_encode($kedvencek_array);
            Cookie::set('kedvencek', $kedvencek_json);
            return true;
            //        echo $this->favourite_property_html($id);
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
        return true;
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
        $string .= '<div class="col-md-5 col-sm-5">';
        $string .= '<div class="properties__thumb">';
        $string .= '<img src="' . Util::thumb_path(Config::get('ingatlan_photo.upload_path') . $photo_array[0]) . '" alt="' . $property_data['ingatlan_nev'] . '" title="' . $property_data['ingatlan_nev'] . '" />';
        $string .= '<div id="delete_kedvenc_' . $property_data['id'] . '" data-id="' . $property_data['id'] . '" class="favourite-delete"><i class="fa fa-trash"></i></div>';
        $string .= '</div>';
        $string .= '</div>'; // col-md-5
        $string .= '<div class="col-md-7 col-sm-7">';
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

}

?>