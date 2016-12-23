<?php

namespace System\Site\Model;

use System\Core\Site_model;

class Settings_model extends Site_model {

    protected $table = 'settings';

    /**
     * Constructor, létrehozza az adatbáziskapcsolatot
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Oldal szintű beállítások lekérdezése a settings táblából
     *
     * @return array a beállítások tömbje
     */
    public function get_settings() {
        $result = $this->query->select();
        return $result[0];
    }

}

?>