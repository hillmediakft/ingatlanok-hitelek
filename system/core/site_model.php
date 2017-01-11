<?php

namespace System\Core;

// use System\Core\Model;

class Site_model extends Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * 	Oldal tartalmak lekérdezése (title, body, metatitle, metadescription, metakeywords)
     *
     * 	@param	string	$page_name (az oldal friendlyurl-je a pages táblában)
     * 	@return array
     */
    public function getPageData($page_name)
    {
        $this->query->set_table(array('pages'));
        $this->query->set_columns('*');
        $this->query->set_where('friendlyurl', '=', $page_name);
        $result = $this->query->select();
        //return (isset($result[0])) ? $result[0] : null;
        return $result[0];
    }

}
?>