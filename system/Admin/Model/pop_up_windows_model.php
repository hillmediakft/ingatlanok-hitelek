<?php

class Pop_up_windows_model extends Model {

    /**
     * Constructor, létrehozza az adatbáziskapcsolatot
     */
    function __construct() {
        parent::__construct();
    }

    public function all_pop_up_windows() {
        // a query tulajdonság ($this->query) tartalmazza a query objektumot
        $this->query->set_table(array('pop_up_windows'));
        $this->query->set_columns(array('id', 'status', 'title', 'content', 'description'));
        $result = $this->query->select();

        return $result;
    }
    
    /**
     * Ajánlat update
     * 	
     * @param 	int 	$id	ajánlat id-je
     * @return 	string 	üzenet
     */
    public function insert_pop_up_window() {

        $data = $_POST;
        unset($data['submit_new_pop_up_window']);

        // új adatok beírása az adatbázisba (update) a $data tömb tartalmazza a frissítendő adatokat 
        $this->query->reset();
        $this->query->set_table(array('pop_up_windows'));
        $result = $this->query->insert($data);

        return $result;
    }    

    /**
     * Ajánlat update
     * 	
     * @param 	int 	$id	ajánlat id-je
     * @return 	string 	üzenet
     */
    public function update_pop_up_window($id) {

        $data = $_POST;
        unset($data['submit_update_pop_up_window']);

        // új adatok beírása az adatbázisba (update) a $data tömb tartalmazza a frissítendő adatokat 
        $this->query->reset();
        $this->query->set_table(array('pop_up_windows'));
        $this->query->set_where('id', '=', $id);
        $result = $this->query->update($data);

        return $result;
    }

    /**
     * 	Az ajánlatokat kérdezi le az adatbázisból (pop_up_windows tábla)
     *
     * 	@param	$id String or Integer
     * 	@return	az adatok tömbben
     */
    public function pop_up_window_data_query($id) {
        $this->query->reset();
        $this->query->set_table(array('pop_up_windows'));
        $this->query->set_columns('*');
        $this->query->set_where('id', '=', $id);

        return $this->query->select();
    }

    /**
     * 	Az ajánlatokat kérdezi le az adatbázisból (pop_up_windows tábla)
     *
     * 	@param	$id String or Integer
     * 	@return	az adatok tömbben
     */
    public function delete_pop_up_window($id) {
        $this->query->reset();
        $this->query->set_table(array('pop_up_windows'));
        $result = $this->query->delete('id', '=', $id);
        if ($result !== false) {
            // ha a törlési sql parancsban nincs hiba
            if ($result > 0) {
                //sikeres törlés
                return true;
            } else {
                //sikertelen törlés
                return false;
            }
        } else {
            // ha a törlési sql parancsban hiba van
            throw new Exception('Hibas sql parancs: nem sikerult a DELETE lekerdezes az adatbazisbol!');
            return false;
        }
    }

}

?>