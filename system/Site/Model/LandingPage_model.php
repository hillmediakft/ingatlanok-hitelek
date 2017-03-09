<?php
namespace System\Site\Model;
use System\Core\SiteModel;

class LandingPage_model Extends SiteModel {

	function __construct()
	{
		parent::__construct();
	}

    /**
     * 	'landing' oldal tartalmak lekérdezése
     *
     * 	@param	string	$page_name (az oldal friendlyurl-je a landing_pages táblában)
     * 	@return array
     */
    public function getLandingPageData($page_name)
    {
        $this->query->set_table(array('landing_pages'));
        $this->query->set_columns('*');
        $this->query->set_where('friendlyurl_' . LANG, '=', $page_name);
        $result = $this->query->select();
        return (isset($result[0])) ? $result[0] : false;
        //return $result[0];
    }

}
?>