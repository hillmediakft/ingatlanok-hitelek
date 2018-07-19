<?php
namespace System\Site\Model;
use System\Core\SiteModel;

class City_model extends SiteModel {

	protected $table = 'city_list';

	function __construct()
	{
		parent::__construct();
	}

    /**
     * 	Lekérdezi a városok nevét és id-jét a city_list táblából (az option listához)
     * 	A paraméter megadja, hogy melyik megyében lévő városokat adja vissza 		
     * 	@param integer	$id 	egy megye id-je (county_id)
     */
    public function cityList($county_id = null)
    {
        if (!is_null($county_id)) {
            $this->query->set_where('county_id', '=', $county_id);
        }
        $this->query->set_orderby(array('city_name'), 'ASC');
        return $this->query->select();
    }

    /**
     *  Lekérdezi a kerület adatokat
     */
    public function districtList()
    {
        $this->query->set_table('district_list');
        return $this->query->select();
    }

}
?>