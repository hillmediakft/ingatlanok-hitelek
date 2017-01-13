<?php
namespace System\Admin\Controller;
use System\Core\AdminController;
use System\Libs\Session;
/**
 * Ingatlan tábla adatainak exportálása
 * PHPreport osztály és PHPexcel package használatával 
 * PHPreport: https://github.com/vernes/PHPReport
 * PHPExcel: https://github.com/PHPOffice/PHPExcel
 */
class Report extends AdminController {
    /**
     * Az ingatlan tábla importálásához szükséges konfiguráció
     * Id: minden táblázatnak rendelkezni kell id-vel
     * header: a fejléc oszlopok elnevezési
     * config-data: oszlopok igazítása (0-val kezdődően)
     * format: oszlopok formázása
     */

    public $property_config = array(
        'id' => 'ingatlanok',
        'header' => array(
            '#Id', 'Referens', 'Város', 'Kerület', 'Típus', 'Kategória', 'Állapot', 'Alapterület', 'Szobaszám', 'Eladási ár', 'Bérleti díj', 'Státusz'
        ),
        'config' => array(
            'data' => array(
                0 => array('align' => 'left'),
                7 => array('align' => 'right'),
                9 => array('align' => 'right')
            )
        ),
        'format' => array(
            7 => array('number' => array('sufix' => ' m2', 'decimals' => 2)),
            9 => array('number' => array('sufix' => ' Ft', 'decimals' => 1))
        )
    );
    // bejelentkezett felhasználó adatait tároló változók
    private $user_name;
    private $user_id;
    private $user_role_id;

    /**
     * A bejelentkezett felhasználó adatainak változókba írása 
     */
    function __construct()
    {
        parent::__construct();

        $this->user_name = Session::get('user_data.name');
        $this->user_id = Session::get('user_data.id');
        $this->user_role_id = Session::get('user_data.role_id');
        $this->loadModel('report_model');
    }

    /**
     * Az export gombra kattintással meghívott action
     * Beolvassa az ingatlanokat a bejelentkezett felhasználó (user_id) 
     * és az utolsó szűrési feltételek szerint
     * 
     * Az eredményül kapott tömböt a header elemeknek megfelelóen konvertálja,
     * és az így kapott tömböt összeolvasztja a config tömbbel. Az így kapott
     * tömböt és az export módját (excel) átadja a meghívott generate_report metódusnak
     *   
     */

    public function property()
    {
        $properties = $this->report_model->get_properties();
        $properties = $this->convert_properties_array($properties);

        $data = array('data' => $properties);
        $data = array_merge($this->property_config, $data);

        $this->generate_report($data, 'excel');
    }

    /**
     * A PHPReport objektum a paraméterként átadott adatokkal és a 
     * riport típusával generálja az xls fájlt, majd elküldi a böngészőnek.
     * @param array $data az adatok tömbje.
     * @param string $type a jelentés típusa (excel, pdf, html).
     */
    public function generate_report($data, $type)
    {
        $R = new PHPReport();
        $R->load(array($data));
        $R->setHeading('Ingatlanok listája / ' . date("Y-m-d") . ' / ' . $this->user_name);
        echo $R->render($type);
        exit();
    }
    
    /**
     * Az adatbázis lekérdezésből kapott tömb átalakítása a kívánt formára. 
     * @param array $original az ingatlanok tömbje.
     * @return array $array az átalakított tömb.
     */
    public function convert_properties_array($original)
    {
        foreach ($original as $key => $value) {
            $array[$key]['id'] = $value['id'];
            $array[$key]['referens'] = $value['user_first_name'] . ' ' . $value['user_first_name'];
            $array[$key]['varos'] = $value['city_name'];
            $array[$key]['kerulet'] = $value['district_name'];
            if ($value['tipus'] == 1) {
                $array[$key]['tipus'] = 'Eladó';
            } else {
                $array[$key]['tipus'] = 'Kiadó';
            }
            $array[$key]['kategoria'] = $value['kat_nev'];
            $array[$key]['allapot'] = $value['all_leiras'];
            $array[$key]['alapterulet'] = $value['alapterulet'];
            $array[$key]['szobaszam'] = $value['szobaszam'];
            $array[$key]['ar_elado'] = $value['ar_elado'];
            $array[$key]['ar_kiado'] = $value['ar_kiado'];
            if ($value['status'] == 1) {
                $array[$key]['status'] = 'Aktív';
            } else {
                $array[$key]['status'] = 'Inaktív';
            }
        }
        return $array;
    }

}
?>