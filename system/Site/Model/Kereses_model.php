<?php
namespace System\Site\Model;
use System\Core\SiteModel;

class Kereses_model extends SiteModel {

	protected $table = 'keresesek';

	function __construct()
	{
		parent::__construct();
	}

    /**
     * A keresesek táblából kérdezi le, hogy van-e olyan rekor, ahol a user_id és a url egyezik
     *
     * @param integer $user_id
     * @param string $search_url
     * @return bool
     */
    public function checkSaveSearch($user_id, $search_url)
    {
        $this->query->set_table('keresesek');
        $this->query->set_where('user_id', '=', $user_id);
        $this->query->set_where('url', '=', $search_url);
        $result = $this->query->select();
        return (empty($result)) ? false : true;
    }

    /**
     * A keresesek tablaba ír be egy új rekordot
     *
     * @param array $data
     */
    public function saveSearch($user_id, $search_url)
    {
        $this->query->set_table('keresesek');
        return $this->query->insert(array('user_id' => $user_id, 'url' => $search_url));
    }


    /**
     * A felhasználó által mentett keresések url-jeit adja vissza
     *
     * @param integer $user_id
     * @return array
     */
    public function selectSavedSearch($user_id)
    {
        // user-hez tartozó url-ek lekérdezése az keresesek tablabol
        $this->query->set_table('keresesek');
        $this->query->set_columns(array('id', 'url'));
        $this->query->set_where('user_id', '=', $user_id);
        $temp = $this->query->select();
        $url_array = array();

        if(!empty($temp)) {
            foreach ($temp as $value) {
                $url_array[$value['id']] = $value['url'];
            }
            unset($temp);
        }

        return $url_array;
    }


    /**
     * A felhasználó által mentett kereséshez
     * tartozó rekordot törli az keresesek tablabol
     *
     * @param integer $id
     */
    public function deleteSavedSearch($id)
    {
    	$id = (int)$id;
        $this->query->set_table('keresesek');
        $this->query->set_where('id', '=', $id);
        return $this->query->delete();
    }

}
?>