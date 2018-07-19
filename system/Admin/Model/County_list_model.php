<?php
namespace System\Admin\Model;
use System\Core\AdminModel;
 
class County_list_model extends AdminModel {

	protected $table = 'county_list';

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
        $this->query->set_where('county_id', '=', $id);
        $result = $this->query->update($value);
    }

    /**
     * DELETE
     */
    public function delete($id)
    {
        return $this->query->delete('county_id', '=', $id);        
    }	

	/**
	 *	Visszaadja a county_list tábla tartalmát
	 *	Ha kap egy id paramétert (integer), akkor csak egy sort ad vissza a táblából
	 *
	 *	@param integer 	$id  
	 */
	public function findCounty($id = null)
	{
		if(!is_null($id)){
			$this->query->set_where('county_id', '=', $id); 
		}
		return $this->query->select(); 
	}
}
?>