<?php

namespace System\Libs;

use System\Libs\DI;
use System\Libs\Query;

class Language {

    public $connect; //adatbazis csatlakozas objektuma
    public $query; //adatbaziskezelő objektumot rendeljük hozzá 
    public static $translations; //a fordítások tömbje

    /**
     * Constructor
     *
     * @access	public
     */

    function __construct($lang_code) {

        $this->connect = DI::get('connect');
        $this->query = new Query($this->connect);
        Self::$translations = $this->load($lang_code);
    }

    /**
     * Language fájl betöltése az adatbázisból
     *
     * @param   string  $lang_code az aktuális nyelvi kód
     * @return  array   nyelvi tömb
     */
    public function load($lang_code) {

        $lang = array();

        $this->query->reset();
        //       $this->query->debug(true);
        $this->query->set_table('translations');
        $this->query->set_columns(array('code', $lang_code));
        $result = $this->query->select();
        foreach ($result as $row) {
            $lang[$row["code"]] = $row["{$lang_code}"];
        }
        return $lang;
    }

    /**
     * fordítás kód alapján
     *
     * @param   string  $code a szöveg elem kódja
     * @return  string   fordítás
     */
    public static function get($code) {
        return Self::$translations[$code];
    }

}

?>