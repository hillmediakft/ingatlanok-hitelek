<?php

namespace System\Site\Model;

use System\Core\SiteModel;
use System\Libs\Session;
use System\Libs\Cookie;
use \PDO;

class GetPhoneNumber_model extends SiteModel {

    function __construct() {
        parent::__construct();
    }

    /**
     * 	Lekérdezi a telefonszámot
     * 	
     * 	@param $user_id az ingatlan referens id-je
	 *  @return string a telefonszám
     */
    public function get_phone($user_id) {
        $this->query->reset();
        $this->query->set_table(array('users'));
        $this->query->set_columns('phone');
        $this->query->set_where('id', '=', $user_id);
        $result = $this->query->select();
        return $result;
    }
}
?>