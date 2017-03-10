<?php
namespace System\Site\Model;
use System\Core\SiteModel;

class Arvaltozas_model extends SiteModel {

	protected $table = 'arvaltozas';

	function __construct()
	{
		parent::__construct();
	}

    /**
     * Az arvaltozas táblából kérdezi le, hogy van-e olyan rekor, ahol a user_id és a property_id egyezik
     * (vagyis a user kért-e már az árváltozásról értesítést)
     *
     * @param integer $user_id
     * @param integer $property_id
     * @return bool
     */
    public function selectPriceChange($user_id, $property_id)
    {
        $this->query->set_table('arvaltozas');
        $this->query->set_where('user_id', '=', $user_id);
        $this->query->set_where('property_id', '=', $property_id);
        $result = $this->query->select();
        return (empty($result)) ? false : true;
    }

    /**
     * Az arvaltozas tablaba ír be egy új rekordot
     *
     * @param array $data
     */
    public function insertPriceChange($user_id, $property_id)
    {
        $this->query->set_table('arvaltozas');
        return $this->query->insert(array('user_id' => $user_id, 'property_id' => $property_id));
    }

    /**
     * A felhasználó által árváltozás értesítésre kijelölt ingatlanthoz
     * tartozó rekordot törli az arvaltozas tablabol
     *
     * @param integer $property_id 
     * @param integer $user_id
     */
    public function deleteFollowed($property_id, $user_id)
    {
        $this->query->set_table('arvaltozas');
        $this->query->set_where('property_id', '=', $property_id);
        $this->query->set_where('user_id', '=', $user_id, 'and');
        return $this->query->delete();
    }


}
?>