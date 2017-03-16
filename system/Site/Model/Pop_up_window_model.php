<?php
namespace System\Site\Model;

use System\Core\SiteModel;

class Pop_up_window_model extends SiteModel {

    protected $table = 'pop_up_windows';

    /**
     * Constructor, létrehozza az adatbáziskapcsolatot
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Felugró ablak tartalmának betöltése a pop_up_windows táblából
     *
     * @return array a beállítások tömbje
     */
    public function get_pop_up_window() {
        
        $this->query->set_columns(array('title', 'content'));
        $this->query->set_where('status', '=', 1);
        $result = $this->query->select();
        if(!empty($result)) {
        return $result[0];
        }
        else {
            return array();
        }
      
    }

}
?>