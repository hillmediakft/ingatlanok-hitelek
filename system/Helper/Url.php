<?php

namespace System\Helper;

use System\Libs\DI;
use System\Libs\Config;

/**
 * Url és link helper
 */
class Url {

    /**
     * Egy kép elérési útvonalából generál egy elérési útvonalat a bélyegképéhez
     * Minta: path/to/file/filename.jpg -> path/to/file/filename_thumb.jpg
     * 
     * @param   string  $path (a file elérési útja)
     * @param   bool    $dir (hozzárak az elérési út végéhez egy mappát, amit a $suffix paraméterben kap meg a metódus)
     * @param   string  $suffix (fájl nevének utótagja)
     * @return  string  a bélyegkép elérési útvonala
     */
    public function thumbPath($path, $dir = false, $suffix = 'thumb') {
        $path_parts = pathinfo($path);
        $dirname = (isset($path_parts['dirname'])) ? $path_parts['dirname'] : '';
        $filename = (isset($path_parts['filename'])) ? $path_parts['filename'] : '';
        $extension = (isset($path_parts['extension'])) ? $path_parts['extension'] : '';

        if (!$dir) {
            if (($dirname == '.') || ($dirname == '\\')) {
                $new_path = $filename . '_' . $suffix . '.' . $extension;
            } else {
                $new_path = $dirname . '/' . $filename . '_' . $suffix . '.' . $extension;
            }
        } else {
            if (($dirname == '.') || ($dirname == '\\')) {
                $new_path = $suffix . '/' . $filename . '_' . $suffix . '.' . $extension;
            } else {
                $new_path = $dirname . '/' . $suffix . '/' . $filename . '_' . $suffix . '.' . $extension;
            }
        }
        return $new_path;
    }

    /**
     * A fájl nevéhez hozzáilleszt egy query stringet (pl: style.css?v=2314564321
     * A szám a fájl utolsó módosításának timestamp-je
     *  
     * @param   string  $uri  a file elérési útvonala pl.: valami.hu/public/site_assets/css/style.css
     * @return  string  a fájl verzióval ellátott elérési útvonala
     */
    public function autoVersion($uri) {
        //ha külső forrásra mutat a link
		if(strpos($uri,'http') !== false) {
			return $uri;
		} else {
			if (substr($uri, 0, 1) == "/") {
				// relatív URI
				$fname = $_SERVER["DOCUMENT_ROOT"] . $uri;
			} else {
				// abszolút URI
				$fname = $uri;
			}
			$ftime = filemtime($fname);
			return $uri . '?v=' . $ftime;
		}
    }

    /**
     * Sorrendbe rendezéshez az aktuális URL-hez adja a rendezési feltételeket
     *
     * Hosszú leírás
     *
     * @param int       $order      DESC vagy ASC
     * @param string    $order_by   mi szerint rendezzen
     * @return string   az új URL rendezés infókkal
     */
    public function add_order_to_url($order, $order_by) {

        if ((isset($_GET['order'])) && $_GET['order'] != '') {

            $string = $_SERVER['REQUEST_URI'];
            $explode_string = explode('?', $string);

            if (strpos($string, '&') === false) {
                parse_str($explode_string[1], $params);

                if (array_key_exists('order', $params)) {
                    unset($params['order']);
                }
                if (array_key_exists('order_by', $params)) {
                    unset($params['order_by']);
                }
                $url = urldecode(http_build_query($params)) . '?order=' . $order . '&order_by=' . $order_by;
                return $url;
            } else {
                parse_str($_SERVER['QUERY_STRING'], $params);
                if (array_key_exists('order', $params)) {
                    unset($params['order']);
                }
                if (array_key_exists('order_by', $params)) {
                    unset($params['order_by']);
                }

                if (empty($params)) {
                    $url = $explode_string[0] . '?order=' . $order . '&order_by=' . $order_by;
                } else {
                    $url = $explode_string[0] . '?' . urldecode(http_build_query($params)) . '&order=' . $order . '&order_by=' . $order_by;
                }
                return $url;
            }
        } else {
            $string = $_SERVER['REQUEST_URI'];
            if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '') {
                $url_with_order = $string . '&order=' . $order . '&order_by=' . $order_by;
                return $url_with_order;
            } else {
                $url_with_order = $string . '?order=' . $order . '&order_by=' . $order_by;
                return $url_with_order;
            }
        }
    }

    /**
     * URL-ben hozzáad a query stringhez elemeket 
     *
     * @param array     $data 
     * @return string   az új URL
     */
    public function addToQueryString(array $data) {
        $request_uri = urldecode($_SERVER['REQUEST_URI']);
        $request_uri = str_replace(BASE_PATH, '', trim($request_uri, '/'));
        $uri_parts = parse_url($request_uri);
        $uri_parts['path'] = (isset($uri_parts['path'])) ? $uri_parts['path'] : '';
        $uri_parts['query'] = (isset($uri_parts['query'])) ? $uri_parts['query'] : '';

        if (!empty($uri_parts['query'])) {
            parse_str($uri_parts['query'], $query_arr);
        } else {
            $query_arr = array();
        }

        // értéket adunk
        foreach ($data as $key => $value) {
            $query_arr[$key] = $value;
        }

        return $uri_parts['path'] . '?' . http_build_query($query_arr);
    }

    /**
     * Spamektől védett e-mail linket generál Javascripttel
     *
     * @param   string  $email: e-mail cím
     * @param   string  $title: title
     * @param   mixed   $attributes: attribútumok
     * @return  string
     */
    public function safe_mailto($email, $title = '', $attributes = '') {
        $title = (string) $title;

        if ($title == "") {
            $title = $email;
        }

        for ($i = 0; $i < 16; $i++) {
            $x[] = substr('<a href="mailto:', $i, 1);
        }

        for ($i = 0; $i < strlen($email); $i++) {
            $x[] = "|" . ord(substr($email, $i, 1));
        }

        $x[] = '"';

        if ($attributes != '') {
            if (is_array($attributes)) {
                foreach ($attributes as $key => $val) {
                    $x[] = ' ' . $key . '="';
                    for ($i = 0; $i < strlen($val); $i++) {
                        $x[] = "|" . ord(substr($val, $i, 1));
                    }
                    $x[] = '"';
                }
            } else {
                for ($i = 0; $i < strlen($attributes); $i++) {
                    $x[] = substr($attributes, $i, 1);
                }
            }
        }

        $x[] = '>';

        $temp = array();
        for ($i = 0; $i < strlen($title); $i++) {
            $ordinal = ord($title[$i]);

            if ($ordinal < 128) {
                $x[] = "|" . $ordinal;
            } else {
                if (count($temp) == 0) {
                    $count = ($ordinal < 224) ? 2 : 3;
                }

                $temp[] = $ordinal;
                if (count($temp) == $count) {
                    $number = ($count == 3) ? (($temp['0'] % 16) * 4096) + (($temp['1'] % 64) * 64) + ($temp['2'] % 64) : (($temp['0'] % 32) * 64) + ($temp['1'] % 64);
                    $x[] = "|" . $number;
                    $count = 1;
                    $temp = array();
                }
            }
        }

        $x[] = '<';
        $x[] = '/';
        $x[] = 'a';
        $x[] = '>';

        $x = array_reverse($x);
        ob_start();
        ?><script type="text/javascript">
            //<![CDATA[
            var l = new Array();
        <?php
        $i = 0;
        foreach ($x as $val) {
            ?>l[<?php echo $i++; ?>] = '<?php echo $val; ?>';<?php } ?>

                for (var i = l.length - 1; i >= 0; i = i - 1) {
                    if (l[i].substring(0, 1) == '|')
                        document.write("&#" + unescape(l[i].substring(1)) + ";");
                    else
                        document.write(unescape(l[i]));
                }
                //]]>
        </script><?php
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }

    /**
     * Az adatlap oldalon az előző ingatlan URL-jének generálása
     * 
     * @param   int     $id az adatlapon megjelenített ingatlan id-je
     * @param   array   $talalati_lista a találati listában szereplő ingatlanok tömbje
     * @param   string  $lang nyelvi kód
     * @return  string  a link
     */
    public function talalatiListaElozo($id, $lang, $talalati_lista) {

        $str_helper = DI::get('str_helper');
        $arr_helper = DI::get('arr_helper');
        $request = DI::get('request');
        $key = $arr_helper->getKeyByFieldValue($talalati_lista, 'id', $id);
        $previous = $arr_helper->getAdjascentKey($key, $talalati_lista, -1);

        if ($previous != false) {
            $link = $request->get_uri('site_url') . Config::get('url.ingatlanok.adatlap.' . LANG) . '/' . $talalati_lista[$previous]['id'] . '/' . $str_helper->stringToSlug($talalati_lista[$previous]['ingatlan_nev_' . $lang]);
        } else {

            $link = "javascript:void();";
        }
        return $link;
    }

    /**
     * Az adatlap oldalon az előző ingatlan URL-jének generálása
     * 
     * @param   int     $id az adatlapon megjelenített ingatlan id-je
     * @param   array   $talalati_lista a találati listában szereplő ingatlanok tömbje
     * @param   string  $lang nyelvi kód
     * @return  string  a link
     */
    public function talalatiListaKovetkezo($id, $lang, $talalati_lista) {

        $str_helper = DI::get('str_helper');
        $arr_helper = DI::get('arr_helper');
        $request = DI::get('request');
        $key = $arr_helper->getKeyByFieldValue($talalati_lista, 'id', $id);
        $next = $arr_helper->getAdjascentKey($key, $talalati_lista, +1);
        if ($next == max(array_keys($talalati_lista))) {
            $link = "javascript:void();";
        } else {
            $link = $request->get_uri('site_url') . Config::get('url.ingatlanok.adatlap.' . LANG) . '/' . $talalati_lista[$next]['id'] . '/' . $str_helper->stringToSlug($talalati_lista[$next]['ingatlan_nev_' . $lang]);
        }
        return $link;
    }

}
?>