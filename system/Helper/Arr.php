<?php

namespace System\Helper;

/**
 * Array helper
 */
class Arr {

    /**
     * 	Visszadja egy tömb megadott kulcsának értékét
     *
     * 	Példa a kulcsok megadására: (a többdimenziós tömb elemeit a . karakterrel elválasztva kell megadni, mintha egy útvonal lenne)
     * 		_get_array_value($array, 'userinput.firstname');
     *
     * 	@param   array   $array    Ebből a tömbből adjuk vissza az adatot
     * 	@param   mixed   $key      A kulcs, amit keresünk
     * 	@return  mixed
     */
    public function get($array, $key) {
        foreach (explode('.', $key) as $key_part) {
            if (!array_key_exists($key_part, $array)) {
                return false;
            }
            $array = $array[$key_part];
        }

        return $array;
    }

    /**
     * Tömb kulcsának és értékének megadása "." karakterrel megadva
     *
     * 	set($array, 'user_data.user_id', $value);
     *
     * @param   array   $array  tömb amibe az adatot rakjuk
     * @param   mixed   $key    kulcsok "." karakterrel elválasztva
     * @param   mixed   $value  érték
     * @return  void
     */
    public function set(&$array, $key, $value = null) {
        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            if (!array_key_exists($key, $array)) {
                $array[$key] = array();
            }

            $array = & $array[$key];
        }

        $array[array_shift($keys)] = $value;
    }

    /**
     * Tömb átlakítása pl. $_FILES tömb esetén multiple változatról single verzióra
     * @param array $files_array - $FILES['upload_files']
     */
    public function multipleToSingle($files_array) {
        $files = array();
        foreach ($files_array as $k => $l) {
            foreach ($l as $i => $v) {
                if (!array_key_exists($i, $files))
                    $files[$i] = array();
                $files[$i][$k] = $v;
            }
        }
        return $files;
    }

    /**
     * Megkeresi annak az elemnek a kulcsát egy mező értéke alapján  
     * @param array $files_array - $FILES['upload_files']
     */
    public function getKeyByFieldValue($array, $field, $value) {
        foreach ($array as $key => $array_value) {
            if ($array_value[$field] === $value)
                return $key;
        }
        return false;
    }

    /**
     * Előző vagy következő tömb elem megkeresése index alapján  
     * @param   integer     $key - a tömb elem indexe
     * @param   array       $hash - a teljes tömb
     * @param   integer     $increment - előző (-1) vagy következő elem (+1)    
     */
    public function getAdjascentKey($key, $hash = array(), $increment) {
        $keys = array_keys($hash);
        $found_index = array_search($key, $keys);
        if ($found_index === false) {
            return false;
        }
        $newindex = $found_index + $increment;
        // returns false if no result found
        return ($newindex >= 0 && $newindex < sizeof($hash)) ? $keys[$newindex] : false;
    }

}

?>