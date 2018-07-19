<?php
namespace System\Admin\Model;
use System\Core\AdminModel;
 
class District_list_model extends AdminModel {

	protected $table = 'district_list';

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
    public function update($id, $value)
    {
        $this->query->set_where('district_id', '=', $id);
        $result = $this->query->update($value);
    }

    /**
     * DELETE
     */
    public function delete($id)
    {
        return $this->query->delete('district_id', '=', $id);        
    }

	/**
	 *	Visszaadja a district_list tábla tartalmát
	 *	Ha kap egy id paramétert (integer), akkor csak egy sort ad vissza a táblából
	 *
	 *	@param integer 	$id  
	 */
	public function findDistrict($id = null)
	{
		if(!is_null($id)){
			$this->query->set_where('district_id', '=', $id); 
		}
		return $this->query->select(); 
	}

	/**
	 * Lekérdezi az ingatlanok táblából a megadott kerülethez tartozó rekordokat
	 *
	 * @param integer $district_id 
	 * @return boolean 
	 */
	public function isDeletable($district_id)
	{
		$this->query->set_table('ingatlanok');
		$this->query->set_columns('id');
		$this->query->set_where('kerulet', '=' , $district_id);
		$result = $this->query->select();
		// ha üres tömb az eredmény, akkor törölhető a kerület
		if (empty($result)) {
			return true;
		} else {
			return false;
		}
	}

}
?>