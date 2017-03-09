<?php 
namespace System\Admin\Model;
use System\Core\AdminModel;

class LandingPage_model extends AdminModel {

	protected $table = 'landing_pages';

	/**
     * Constructor, létrehozza az adatbáziskapcsolatot
     */
	function __construct()
	{
		parent::__construct();
	}
	
	public function allPages()
	{
		$this->query->set_orderby('id', 'desc');
		return $this->query->select(); 
	}

	/**
	 *	Egy oldal adatait kérdezi le az adatbázisból (pages tábla)
	 *
	 *	@param	integer $id
	 *	@return	array
	 */
	public function onePage($id)
	{
		$this->query->set_where('id', '=', $id);
		$result = $this->query->select();
		return $result[0];
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
		$this->query->set_where('id', '=', $id);
		return $this->query->update($data);		
	}
		
}
?>