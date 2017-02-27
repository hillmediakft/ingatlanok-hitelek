<?php

namespace System\Helper;

use System\Libs\DI;
use System\Libs\Cookie;
/**
 * Url és link helper
 */
class Html {

    /**
     * Ingatlan árának megjelenítése
     * Amennyiben csökkent az ár, a régi ár lehúzva és feketén jelenik meg
     * 
     * @param   array  $ingatlan az ingatlan adatait tartalmazó tömb
     * @return  void
     */
    public function showPrice($ingatlan) {

        $num_helper = Di::get('num_helper');

        if ($ingatlan['tipus'] == 1) {
            if (isset($ingatlan['ar_elado_eredeti']) && $ingatlan['ar_elado_eredeti'] != $ingatlan['ar_elado']) {
                $price = $num_helper->niceNumber($ingatlan['ar_elado']) . ' Ft ' . '<span class="lower-price">' . $num_helper->niceNumber($ingatlan['ar_elado_eredeti']) . ' Ft</span>';
            } else {
                $price = $num_helper->niceNumber($ingatlan['ar_elado']) . ' Ft';
            }
        } else {
            if (isset($ingatlan['ar_kiado_eredeti']) && $ingatlan['ar_kiado_eredeti'] != $ingatlan['ar_kiado']) {
                $price = $num_helper->niceNumber($ingatlan['ar_kiado']) . ' Ft ' . '<span class="lower-price">' . $num_helper->niceNumber($ingatlan['ar_kiado_eredeti']) . ' Ft</span>';
            } else {
                $price = $num_helper->niceNumber($ingatlan['ar_kiado']) . ' Ft';
            }
        }
        echo $price;
    }

    /**
     * Árcsökkentés ikon megjelenítése
     * Amennyiben csökkent az ár, egy lefelé mutató nyíl ikon + %-jel jelenik meg
     * 
     * @param   array  $ingatlan az ingatlan adatait tartalmazó tömb
     * @return  void
     */
    public function showLowerPriceIcon($ingatlan) {
        $html = '';
        if ($ingatlan['tipus'] == 1) {
            if (isset($ingatlan['ar_elado_eredeti']) && $ingatlan['ar_elado_eredeti'] != $ingatlan['ar_elado']) {
                $html .= '<span class="lower-price">% <i class="fa fa-arrow-down"></i></span>';
            }
        } elseif ($ingatlan['tipus'] == 2) {
            if (isset($ingatlan['ar_kiado_eredeti']) && $ingatlan['ar_kiado_eredeti'] != $ingatlan['ar_kiado']) {
                $html .= '<span class="lower-price">% <i class="fa fa-arrow-down"></i></span>';
            }
        }
        echo $html;
    }
    
    /**
     * Kedvencekhez adáskor egy szív ikon megjelenítése
     * 
     * 
     * @param   array  $ingatlan az ingatlan adatait tartalmazó tömb
     * @return  void
     */
    public function showHeartIcon($ingatlan) {
        $html = '';
        
        if(Cookie::is_id_in_cookie('kedvencek', $ingatlan['id'])) {
        $html .= '<div class="like"><i class="fa fa-heart"></i></div>';
        } else {
            $html .= '';
        }
        echo $html;
    }    
    


}

?>