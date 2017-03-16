<?php
namespace System\Admin\Model;

use System\Core\AdminModel;

class Pop_up_windows_model extends AdminModel {

    protected $table = 'pop_up_windows';

    /**
     * Constructor, létrehozza az adatbáziskapcsolatot
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Minden rekord lekérdezése
     */
    public function selectAll()
    {
        return $this->query->select();
    }

    /**
     *  Az ajánlatokat kérdezi le az adatbázisból (pop_up_windows tábla)
     *
     *  @param  integer $id
     *  @return array
     */
    public function selectOne($id)
    {
        $this->query->set_where('id', '=', $id);
        return $this->query->select();
    }
    
    /**
     * Insert
     * 	
     * @param 	array 	$data
     * @return 	integer
     */
    public function insert($data)
    {
        return $this->query->insert($data);
    }    

    /**
     * Update
     * 	
     * @param   int     $id
     * @param 	array 	$data
     * @return 	integer
     */
    public function update($id, $data)
    {
        $this->query->set_where('id', '=', $id);
        return $this->query->update($data);
    }

    /**
     * 	Az ajánlatokat kérdezi le az adatbázisból (pop_up_windows tábla)
     *
     * 	@param	$id String or Integer
     * 	@return	integer || false
     */
    public function delete($id)
    {
        return $this->query->delete('id', '=', $id);
    }

}
?>