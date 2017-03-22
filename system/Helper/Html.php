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
    
    /**
     * Közösségi média megosztási gombok
     *  
     * @return  string  a html
     */
    public function socialMediaShare() {
        $html = '';

        $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; // a megjelenített URL

        $html .= "<div  style='height: 20px; float: left; margin-top: 10px; margin-left: 0px; border-right-width: 0px; margin-right: 10px'>";
        $html .= "<div class='fb-like' data-href='$url' data-send='false' data-layout='button_count' data-width='130' data-show-faces='false' data-font='arial' data-action='recommend'></div>";
        $html .= "</div>";

        $html .= "<div  style='height: 20px; float: left; margin-bottom: 10px; margin-left: 0px; border-right-width: 0px; margin-left: 10px'>";
        $html .= "<div class='g-plusone' data-size='medium'></div>";
        $html .= "<script type='text/javascript'>
  window.___gcfg = {lang: 'hu'};

  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>";
        $html .= "</div>";
        return $html;
    }

}

?>