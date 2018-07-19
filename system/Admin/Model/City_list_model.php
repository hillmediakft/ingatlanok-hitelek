<?php
namespace System\Admin\Model;
use System\Core\AdminModel;
 
class City_list_model extends AdminModel {

	protected $table = 'city_list';

	/**
     * Constructor, létrehozza az adatbáziskapcsolatot
     */
	function __construct()
	{
		parent::__construct();
	}

    /**
     * INSERT
     */
    public function insert($data)
    {
        return $this->query->insert($data);
    }

    /**
     * UPDATE
     */
    public function update($id, $data)
    {
        $this->query->set_where('city_id', '=', $id);
        return $this->query->update($data);
    }

    /**
     * DELETE
     */
    public function delete($id)
    {
        return $this->query->delete('city_id', '=', $id);        
    }	

	/**
	 *	Visszaadja a city_list tábla tartalmát
	 *	Ha kap egy id paramétert (integer), akkor csak egy sort ad vissza a táblából
	 *
	 *	@param integer 	$id  
	 */
	public function findCity($id = null)
	{
		$this->query->set_columns(
			'city_list.*,
			county_list.county_name'
		);

		$this->query->set_join('left', 'county_list', 'county_list.county_id = city_list.county_id');

		if(!is_null($id)){
			$this->query->set_where('city_id', '=', $id); 
		}
		return $this->query->select(); 
	}

	/**
	 * Lekérdezi az ingatlanok táblából a megadott városhoz tartozó rekordokat
	 *
	 * @param integer $city_id 
	 * @return boolean 
	 */
	public function isDeletable($city_id)
	{
		$this->query->set_table('ingatlanok');
		$this->query->set_columns('id');
		$this->query->set_where('varos', '=' , $city_id);
		$result = $this->query->select();
		// ha üres tömb az eredmény, akkor törölhető a város
		if (empty($result)) {
			return true;
		} else {
			return false;
		}
	} 	

}
?>