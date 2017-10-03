<?php

namespace System\Admin\Model;

use System\Core\AdminModel;
use \PDO;
use System\Libs\Session;
use System\Libs\Auth;

class Ingatlan_ajanlasok_model extends AdminModel {

    protected $table = 'ingatlan_ajanlasok';

    function __construct() {
        parent::__construct();
    }

    /**
     * INSERT
     */
    public function insert($data) {
        return $this->query->insert($data);
    }

    /* ------------------ */

    /**
     * 	A lakások listájához kérdezi le az adatokat
     */
    public function getAjanlasok() {
        $this->query->debug(false);
        $this->query->set_columns(array(
            'id',
            'email',
            'name',
            'html_data',
            'date',
            'ref_name'
        ));
        $this->query->set_orderby(array('id'), 'DESC');
        $result = $this->query->select();
        return $result;
    }

    /**
     * 	A lakások listájához kérdezi le az adatokat
     */
    public function getAjanlas($id) {
        $this->query->debug(false);
        $this->query->set_columns(array(
            'id',
            'email',
            'name',
            'html_data',
            'date',
            'ref_name'
        ));
        $this->query->set_where('id', '=', $id);
        $result = $this->query->select();
        return $result[0];
    }

}

?>