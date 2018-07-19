<?php 
namespace System\Site\Controller;
use System\Core\SiteController;
use System\Libs\DI;
use System\Libs\Config;
use System\Libs\EventManager;
use System\Libs\Uploader;
//use System\Libs\Geocoder;

/**
* XML fajlt konvertál
*/
class XmlConvert extends SiteController
{
	/**
	 * dunahouse xml file letöltés linkek
	 * @var array
	 */
	private $dh_links = array(
		'agents' => 'http://export.dh.hu/ep/agents.xml',
		'offices' => 'http://export.dh.hu/ep/offices.xml',
		'options' => 'http://export.dh.hu/ep/options.xml',
		'regions' => 'http://export.dh.hu/ep/regions.xml',
		'properties' => 'http://export.dh.hu/ep/properties.xml' 
	);

	/**
	 * dunahouse xml file letöltés hitelesítési adatok
	 * @var array
	 */
	private $dh_username = 'ZANY9Y';
	private $dh_password = '5b608b8224';


	// xml behívás után a megyéket tartalamazza
	private $counties = array();

	// xml behívás után a városokat tartalamazza
	private $cities = array();

	// xml behívás után az opciókat tartalamazza (eladó,kiadó, ... felújított, új építésű ... stb.)
	private $options = array();

	// xml behívás után az ingatlanok adatait tartalamazza
	private $properties = array();

    // ha nincs a városhoz, kerülethez referens rendelve ez a referens lesz hozzárendelve
    private $default_agent_id = 57;

// -------------------------------------

    /**
     * Megyék párosítva
     * Kulcs: külső kód
     * Érték: saját kód 
     * @var array
     */
    private $regions_paired = array(
        // 'LCN0000000000RG' => 1, // Bács-Kiskun
        // 'LCN0000000000RI' => 2, // Baranya
        // 'LCN0000000000RH' => 3, // Békés
        // 'LCN0000000000RJ' => 4, // Borsod-Abaúj-Zemplén
        'LCN000000000B9L' => 5, // Budapest
        // 'LCN0000000000RL' => 6, // Csongrád
        // 'LCN0000000000RM' => 7, // Fejér
        // 'LCN0000000000RN' => 8, // Győr-Moson-Sopron
        // 'LCN0000000000RO' => 9, // Hajdú-Bihar
        // 'LCN0000000000RP' => 10, // Heves
        // 'LCN0000000000RQ' => 11, // Jász-Nagykun-Szolnok
        // 'LCN0000000000RR' => 12, // Komárom-Esztergom
        // 'LCN0000000000RS' => 13, // Nógrád
        // 'LCN0000000000RT' => 14, // Pest
        // 'LCN0000000000RU' => 15, // Somogy
        // 'LCN0000000000RV' => 16, // Szabolcs-Szatmár-Bereg
        // 'LCN0000000000RW' => 17, // Tolna
        // 'LCN0000000000RX' => 18, // Vas
        // 'LCN0000000000RY' => 19, // Veszprém
        // 'LCN0000000000RZ' => 20  // Zala       
    );

    /**
     * Párosított opciók
     * Kulcs: külső kód
     * Érték: saját kód
     * @var array
     */
    private $options_paired = array(
        // ingatlan_kategoria tábla
        "property-type" => array(
            "SPV0000000000Y6" => 1, //lakás
            "SPV0000000000Y7" => 3, //ház
            "SPV0000000000Y8" => 12, //telek
            "SPV0000000000Y9" => 8, //garázs
            //"SPV0000000000YA" => "tároló",
            "SPV0000000000YB" => 13, //üzlethelyiség
            "SPV000000000TQ5" => 15, //iroda
            "SPV0000000NRI90" => 19, //étterem
            //"SPV00000009Q21Y" => "fejlesztési terület",
            //"SPV00000009L8LE" => "irodaház",
            //"SPV00000009PYT4" => "ipari ingatlan",
            "SPV0000000NR89G" => 16, //szálloda, hotel, panzió
            //"SPV00000009Q211" => "logisztika",
            //"SPV0000000KFXI9" => "kereskedelmi központ",
            "SPV00000009Q20K" => 13 //üzlethelyiség
        ), 

/*      
        "currency" => array(
            "CUR00000000015F"=> "HUF",
            "CUR00000000015G"=> "EUR",
            "CUR00000000015H"=> "USD",
            "CUR00000002FSXU"=> "JPY",
            "CUR00000002FSY8"=> "CHF"
        ),
*/

        //ingatlanok tábla - tipus
        "agreement-type" => array(
            "SPV00000000010J" => 1, //eladó
            "SPV00000000010K" => 2 //kiadó
        ),
    
        // ingatlan_allapot tábla
        "property-condition" => array(
            "SPV00000009L8V9" => 9, //új
            "SPV0000000001KZ" => 8, //1 - Lakhatatlan - (bontandó)
            "SPV00000009L8VA" => 6, //használt - (közepes)
            "SPV0000000001L0" => 7, //2 - Felújítandó
            "SPV0000000001L1" => 6, //3 - Lakható - (közepes)
            "SPV0000000001L2" => 2, //4 - Jó
            "SPV0000000001L3" => 1, //5 - Nagyon jó - (kiváló)
            "SPV0000000001L4" => 1, //Nagyon jó - (kiváló)
            "SPV0000000001L5" => 4 //újépítésű - (újszerű)
        ),
    
        // ingatlan_allapot_belul tábla
        "building-condition-in" => array(
            //"SPV0000000001KZ" => "1 - Lakhatatlan",
            "SPV0000000001L0" => 1, //2 - Felújítandó
            "SPV0000000001L1" => 2, //3 - Lakható - (átlagos)
            "SPV0000000001L2" => 3, //4 - Jó - (felújított)
            "SPV0000000001L3" => 3, //5 - Nagyon jó - (felújított)
            "SPV0000000001L4" => 3, //Nagyon jó - (felújított)
            "SPV0000000001L5" => 3, //újépítésű - (felújított)
        ),
    
        // ingatlan_allapot_kivul tábla
        "building-condition-out" => array(
            "SPV0000000001KZ" => 8, //1 - Lakhatatlan
            "SPV0000000001L0" => 7, //2 - Felújítandó
            "SPV0000000001L1" => 6, //3 - Lakható - (közepes)
            "SPV0000000001L2" => 4, //4 - Jó
            "SPV0000000001L3" => 1, //5 - Nagyon jó - (kiváló)
            "SPV0000000001L4" => 1, //Nagyon jó - (kiváló)
            "SPV0000000001L5" => 3, //újépítésű - (újszerű)
        ),

        // ingatlan_kilatas tábla
        "facing" => array(
            "SPV0000000001KW" => 1, //utca
            "SPV0000000001KX" => 2, //udvar
            "SPV0000000001KY" => 4 //zöldudvar / kert
        ),

        // inagatlanok tábla - emelet
        "floor" => array(
            "SPV0000000001J9" => 2, //pinceszint
            //"SPV0000000001K0" => "-5",
            //"SPV0000000001K1" => "-4",
            //"SPV0000000001K2" => "-3",
            //"SPV0000000001K3" => "-2",
            //"SPV0000000001K4" => "-1",
            "SPV0000000001K5" => 1, //alagsor
            "SPV0000000001K6" => 3, //szuterén
            "SPV0000000001K7" => 3, //félszuterén (???)
            "SPV0000000001K8" => 4, //földszint
            "SPV0000000001K9" => 5, //magasföldszint
            "SPV0000000001KA" => 6, //félemelet
            "SPV0000000001KB" => 7, //1
            "SPV0000000001KC" => 8, //2
            "SPV0000000001KD" => 9, //3
            "SPV0000000001KE" => 10, //4
            "SPV0000000001KF" => 11, //5
            "SPV0000000001KG" => 12, //6
            "SPV0000000001KH" => 13, //7
            "SPV0000000001KI" => 14, //8
            "SPV0000000001KJ" => 15, //9
            "SPV0000000001KK" => 16, //10
            "SPV0000000001KL" => 17, //11
            "SPV0000000001KM" => 17, //12
            "SPV0000000001KN" => 17, //13
            "SPV0000000001KO" => 17, //14
            "SPV0000000001KP" => 17, //15
            "SPV0000000001KQ" => 17, //16
            "SPV0000000001KR" => 17, //17
            "SPV0000000001KS" => 17, //18
            "SPV0000000001KU" => 17, //19
            "SPV0000000001KV" => 17, //20
            "SPV0000002YG2SI" => 17 //21
        ),
/*
        "plot-type" => array(
            "SPV000000000BPO" => "lakó övezet",
            "SPV000000000BPP" => "üdülő övezet",
            "SPV000000000BPQ" => "külterület",
            "SPV000000000BPR" => "egyéb"
        ),


        "water" => array(
            "SPV000000000C3O" => "van",
            "SPV000000000C3P" => "nincs adat",
            "SPV000000000C3Q" => "telken belül",
            "SPV000000000C3R" => "utcában",
            "SPV000000000C3S" => "nincs"
        ),
        "gas" => array(
            "SPV000000000C3O" => "van",
            "SPV000000000C3P" => "nincs adat",
            "SPV000000000C3Q" => "telken belül",
            "SPV000000000C3R" => "utcában",
            "SPV000000000C3S" => "nincs"
        ),

        "wastewater-drain" => array(
            "SPV000000000C3O" => "van",
            "SPV000000000C3P" => "nincs adat",
            "SPV000000000C3Q" => "telken belül",
            "SPV000000000C3R" => "utcában",
            "SPV000000000C3S" => "nincs"
        ),

        "electricity" => array(
            "SPV000000000C3O" => "van",
            "SPV000000000C3P" => "nincs adat",
            "SPV000000000C3Q" => "telken belül",
            "SPV000000000C3R" => "utcában",
            "SPV000000000C3S" => "nincs"
        ),
*/

        // inagatlan_szerkezet tábla
        "building-structure" => array(
            "SPV000000000CDI" => 2, //panel
            "SPV000000000CDJ" => 1, //tégla
            "SPV000000000E6B" => 6, //könnyűszerkezetes
            "SPV000000000FUC" => 5, //ytong - (egyéb)
            "SPV000000000FUF" => 5, //fa - (egyéb)
            "SPV000000000FUG" => 3, //csúsztatott zsalu
            "SPV000000079WHX" => 5, //vályog - (egyéb)
            "SPV000000079WHY" => 5, //vegyes falazat - (egyéb)
            "SPV000000079WHZ" => 5, //vert falazat - (egyéb)
            "SPV00000000CF01" => 5, //egyéb
        ),  

        // ingatlan_parkolás tábla
        "parking-type" => array(
            "SPV000000000TMX" => 1, //egyedülálló - (garázs)
            "SPV000000000TMY" => 2, //teremgarázs
        ),
        
        // ingatlan_kategoria tábla
        "house-type" => array(
            "SPV0000000001LJ" => 3, //családi ház
            "SPV0000000001LK" => 6, //ikerház
            "SPV0000000001LL" => 4, //sorház
            "SPV0000000001LM" => 5 //házrész
            // "SPV0000000001LN" => "tanya",
            // "SPV000000000E6E" => "kúria",
            // "SPV000000000E6F" => "kastély"
        ),

        // ingatlan_kategoria tábla
        "house-function" => array(
            // "SPV000000000BTV" => "lakóingatlan",
            "SPV000000000BTW" => 10 //nyaraló
            // "SPV00000000AS00" => "egyeb"
        ),

        // ingatlan_fenyviszony tábla
        "brightness" => array(
            "SPV0000000001L6" => 2, //gyenge
            "SPV0000000001L7" => 3, //közepes
            "SPV0000000001L8" => 3, //jó
            "SPV0000000001L9" => 1 //napfényes
        ),

        // ingatlan_futes tábla
        "heating" => array(
            "SPV000000000CDK" => 1, //gáz (cirkó)
            "SPV0000000001LA" => 2, //gáz (konvektor)
            "SPV0000000001LB" => 7, //gáz (héra)
            "SPV0000000001LC" => 11, //gáz + napkollektor
            "SPV000000000CDO" => 11, //gázkazán
            "SPV0000000001LF" => 8, //elektromos
            "SPV000000000CDN" => 11, //egyéb kazán
            "SPV000000000CDM" => 11 , //egyéb
            "SPV0000000001LE" => 6, //távfűtés
            "SPV0000000001LD" => 4, //házközponti
            "SPV000000000CDL" => 3, //házközponti egyedi méréssel
            "SPV000000000FLM" => 11, //geotermikus
            "SPV000000000TLY" => 5 //távfűtés egyedi mérővel
        ),

/*
        // tetőtér
        "attic" => array(
            "SPV0000000001LS" => "nincs adat",
            "SPV0000000001LT" => "beépített",
            "SPV0000000001LU" => "beépíthető",
            "SPV0000000001LV" => "nem beépíthető"
        ),
*/

        // ingatlanok tábla - lift
        "lift" => array(
            "SPV0000000001LG" => 0, //nincs
            "SPV0000000001LH" => 1, //kulcsos
            "SPV0000000001LI" => 1 //hívó
        ),

        // ingatlanok tábla - tajolas
        "siting" => array(
            "SPV0000000001NC" => 7, //ÉNY
            "SPV0000000001ND" => 1, //ÉK
            "SPV0000000001NE" => 2, //K
            "SPV0000000001NF" => 4, //D
            "SPV0000000001NG" => 3, //DK
            "SPV0000000001NH" => 5, //DNY
            "SPV0000000001NI" => 6, //NY
            "SPV0000000001NB" => 0 //É
        ),

/*
        "premises-type" => array(
            "SPV0000000001QX" => "szoba",
            "SPV000000000BOV" => "alkóv",
            "SPV0000000P66M9" => "autóbeálló",
            "SPV0000001F3D2X" => "bár",
            "SPV0000001F3D3J" => "bemutatóterem",
            "SPV0000001F3D35" => "bortároló",
            "SPV0000001F3D2V" => "csarnok",
            "SPV0000000C5F4J" => "eladótér",
            "SPV0000001F3D36" => "előkészítő helyiség",
            "SPV0000000001R4" => "előszoba",
            "SPV00000010096R" => "előtér",
            "SPV0000000001R5" => "erkély",
            "SPV000000000E6D" => "étkező",
            "SPV0000000P66H2" => "fedett terasz",
            "SPV0000001F3D2W" => "folyosó",
            "SPV0000001F3D38" => "főző helyiség",
            "SPV0000000001R2" => "fürdő",
            "SPV0000000001R3" => "fürdő WC-vel",
            "SPV0000001008IF" => "garázs (külön hrsz-on az ingatlannal)",
            "SPV00000000CFFW" => "garázs (egy hrsz-on az ingatlannal)",
            "SPV0000000001R9" => "gardrób",
            "SPV00000000FL7W" => "grillező",
            "SPV0000000001R7" => "hall",
            "SPV0000001008YH" => "hálófülke",
            "SPV000000024DXQ" => "háztartási helyiség",
            "SPV0000001F3D37" => "hűtőkamra",
            "SPV0000001F3D32" => "ipari park",
            "SPV00000010099F" => "irattár",
            "SPV000000100913" => "iroda",
            "SPV00000000FL97" => "játszótér",
            "SPV0000000001R0" => "kamra (ingatlanban)",
            "SPV0000001008X4" => "kamra (ingatlanon kívül)",
            "SPV00000010OJMA" => "kazánház (lakótérben)",
            "SPV00000010OJMO" => "kazánház (lakótéren kívül)",
            "SPV0000001F3D34" => "kávézó",
            "SPV0000001F3D3D" => "kerékpár tároló",
            "SPV000000000BOT" => "kert",
            "SPV0000001F3D3K" => "klubhelyiség",
            "SPV0000000001QY" => "konyha",
            "SPV0000000B76UA" => "konyha-étkező",
            "SPV0000001009A5" => "konyhatér",
            "SPV0000000001R8" => "közlekedő",
            "SPV0000000P66OQ" => "lépcsőtér",
            "SPV0000000P66H1" => "loggia",
            "SPV0000001F3D3A" => "masszázs helyiség",
            "SPV0000001F3D3B" => "meleg konyha",
            "SPV00000000FL2X" => "melléképület",
            "SPV0000000P66OR" => "mosdó",
            "SPV00000010099N" => "mosogató",
            "SPV0000001F3D33" => "műhely",
            "SPV000000000BOU" => "nappali",
            "SPV000000000FUH" => "nappali + amerikai konyha",
            "SPV0000000C5F4I" => "nyári konyha",
            "SPV0000000P66H3" => "nyitott terasz",
            "SPV00000010098N" => "öltöző",
            "SPV0000001F3D31" => "parkolóház",
            "SPV0000000001R6" => "pince",
            "SPV0000000001R1" => "raktár",
            "SPV0000001W9JJC" => "recepció",
            "SPV0000001009BK" => "ruhatár",
            "SPV0000001F3D3F" => "sífelszerelés tároló",
            "SPV00000010OJRH" => "szauna",
            "SPV0000001F3D3E" => "szeméttároló",
            "SPV0000001F3D3G" => "személyzeti helyiség",
            "SPV0000001F3D39" => "széf",
            "SPV0000001F3D2Z" => "szociális helyiség",
            "SPV0000001008ZV" => "tároló (ingatlanban)",
            "SPV000000100906" => "tároló (ingatlanon kívül)",
            "SPV0000001F3D3H" => "tárgyaló",
            "SPV0000001F3D3C" => "társalgó",
            "SPV0000001F3D2U" => "terem",
            "SPV0000000P66M8" => "teremgarázs",
            "SPV0000001F3D30" => "termelőterület",
            "SPV0000000B76UB" => "télikert",
            "SPV0000001F3D2Y" => "üzemraktár",
            "SPV0000001009BV" => "ügyféltér",
            "SPV00000010093D" => "üzlethelyiség",
            "SPV0000001F3D3I" => "vizesblokk",
            "SPV0000000001QZ" => "WC",
            "SPV0000000TNK5Q" => "wellneshelyiség",
            "SPV0000003W0KJ0" => "egyéb"
        ),

        "staircase-type" => array(
            "SPV0000000001P2" => "zárt lépcsőház",
            "SPV0000000001P1" => "körfolyosó"
        ),
*/

        "building-style" => array(
            "SPV000000000CDF" => "új építésű",
            "SPV000000000CDG" => "polgári",
            "SPV000000000CDH" => "panel / csúsztatott zsalu",
            "SPV0000005GSX1T" => "újszerű"
        ),

/*
        "hirdetheto" => array(
            "SPV0000008GPHZ1" => "Mindenhol hirdethető",
            "SPV0000008GPHZ2" => "Csak adatbázis",
            "SPV0000008GPHZ3" => "Csak az ingatlan.com-on hirdethető",
            "SPV0000008GPHZ4" => "Az ingatlan.com kivételével hirdethető",
            "SPV0000008GPHZ5" => "Csak adabázis, DH + PRIME"
        )
*/
    );

    /**
     * Városok párosítva
     */
    private $cities_paired = array(
    );


	
	function __construct()
	{
        parent::__construct();
        $this->loadModel('ingatlanok_model');
        $this->loadModel('city_model');
	}

	/**
	 * Ingatlanok hozzáadása DunaHouse XML file alapján 
	 */
	public function index()
	{
        // Ingatlanok a DunaHouse oldalról
        $this->dunahouse();
	}

    /**
     * File beolvasása külső weboldalról (pl.: xml)
     */
    private function getFromWeb($url, $username = null, $password = null)
    {
        // ha kell username és password
        if (!is_null($username) && !is_null($password)) {
            
            $opts = array(
                'http' => array (
                    'method'  => 'GET',
                    'header' => 'Authorization: Basic ' . base64_encode($username . ':' . $password)
                )
            );

            $context = stream_context_create($opts);
            $result =  file_get_contents($url, false, $context);

        } else {
            $result =  file_get_contents($url);
        }

        return $result;
    }

    /**
     * dunahouse xml-ek feldolgozása
     */
    private function dunahouse()
    {
        // az adatbázisban már szereplő kulső forrásból származó ingatlanok azonosítói
        $outer_properties_ref_nums = $this->ingatlanok_model->getOutherProperties();

        // saját város lista lekérdezése
        $own_cities = $this->city_model->cityList();
        // saját kerület lista lekérdezése
        $own_districts = $this->city_model->districtList();
        // Városokat tartalamzó tömb ($this->cities, $this->counties) feltöltése az xml-fájlból és a saját adatokból (paraméterként kapja a saját városokat és kerületeket tartalmazó tömböket)
        $this->dh_regions($own_cities, $own_districts);
//echo "<pre>"; print_r($this->counties); echo "</pre>"; die;
//echo "<pre>"; print_r($this->cities); echo "</pre>"; die;

        // Megfelelő ingatlanok feldolgozása és adatbázisba írása
        $this->dh_properties($outer_properties_ref_nums);        
    }


// **********************************************************


	/**
	 * Dunahouse options XML feldolgozása (NINCS HASZNÁLATBAN! mert az opciók manuálisan vannak párosítva)
	 */
	private function dh_options()
	{
        $dir = getcwd();
        $content = $this->getFromWeb($dir . '/_TEMP/xml_convert/options.xml');


		//$content = $this->getFromWeb($this->links['options'], $this->username, $this->password);
		$xml = new \SimpleXMLElement($content);

		$options_arr = array();

		// bejárjuk az xml objektumot
		foreach($xml->option as $option) {
			// opció neve
			$option_name = $option['name']->__toString();
			
			foreach($option as $v) {
				$key = $v['key']->__toString();
				$item_value = $v->__toString();
				
				$temp[] = array($key => $item_value);
			} 
			
			// opció hozzáadása a tömbhöz
			$options_arr[$option_name] = $temp;
			// átmeneti tömb ürítése
			$temp = array();
		} 

		$this->options = $options_arr;
	}	

	/**
	 * DunaHouse régiók xml feldolgozása
     * @param array $own_cities saját városok lista 
     * @param array $own_districts saját kerületek lista (a budapesti kerületeknél a referens a hozzárendelt referens meghatározásához)
	 */
	private function dh_regions($own_cities, $own_districts)
	{
        $dir = getcwd();
        $content = $this->getFromWeb($dir . '/_TEMP/xml_convert/regions.xml');

        //$content = $this->getFromWeb($this->dh_links['regions'], $this->dh_username, $this->dh_password);
        //$xml = simplexml_load_string($content);
		$xml = new \SimpleXMLElement($content);

		// megyék kódját és nevét tartalmazó tömb
		$counties = array();
		// városok nevét és egy altömbben a város és a megye kódját tartalmazó tömb 
		$cities = array();

		// bejárjuk az objektumot
		foreach ($xml->region as $region) {

			// ha az elem egy megye neve
			if ($region['level'] == 1) {
				$county_key = $region['key']->__toString();	
				$county_name = $region->__toString();	
				$counties[] = array($county_key => $county_name);
			}
			elseif($region['level'] == 2 && isset($region['parent'])) {
				$city_code = $region['key']->__toString();	
				$city_name = $region->__toString(); 
				$county_code = $region['parent']->__toString();
				

                    // megkeressük a saját városlistában, hogy mi tartozik ehhez a városhoz
                    $own_city_key = null;
                    $own_county_key = null;
                    $district = null;
                    $agent_id = $this->default_agent_id;

                    // Városnév: Budapest + kerület minta
                    $pattern = '~(Budapest) (.+). (ker.)~';

                    foreach ($own_cities as $key => $value) {

                        // Budapest és kerület meghatározása
                        preg_match($pattern, $city_name, $matches);
                        if (!empty($matches)) {
                            $own_city_key = '88'; // Budapest
                            $own_county_key = 5;
                            $district = $matches[2]; // Kerület száma
                            $city_name = 'Budapest';

                            // Referens meghatározása budapesti kerület esetén
                            foreach ($own_districts as $v) {
                                if ($district == $v['district_id'] && !empty($v['agent_id'])) {
                                    $agent_id = $v['agent_id'];
                                }
                            }
                        }
                        else {
                            // ha nem Budapest
                            if (strtolower($value['city_name']) == strtolower($city_name)) {
                                $own_city_key = $value['city_id'];
                                $own_county_key = $value['county_id'];
                                if (!empty($value['agent_id'])) {
                                    $agent_id = $value['agent_id'];
                                }
                            }
                        }
                    }

                // csak azok a városok lesznek a tömbben ami saját rendszerben szerepel
                if (is_null($own_city_key)) {
                    continue;
                }

                // város adatokat tartalmazó tömb feltöltése
                $cities[$city_code] = array(
                    'city_name' => $city_name,
                    'own_city_key' => $own_city_key,
                    'own_county_key' => $own_county_key,
                    'county_key' => $county_code,
                    'district' => $district,
                    'agent_id' => $agent_id
                );

			}

			// az eredményt átrakjuk az osztály tulajdonságba
			$this->counties = $counties;
			$this->cities = $cities;
		}

	}

	/**
	 * DunaHouse properties XML bejárása és megfelelő ingatlanok adatbázisba írása
     * 
     * @param array $outer_properties_ref_nums - a saját adabázis ezeket a referencia számú elemeket tartalamazza már
	 */
	private function dh_properties($outer_properties_ref_nums)
	{
        set_time_limit(0);

        //$dir = getcwd();
        //$content = $this->getFromWeb($dir . '/_TEMP/xml_convert/properties.xml');

		$content = $this->getFromWeb($this->dh_links['properties'], $this->dh_username, $this->dh_password);
		$xml = new \SimpleXMLElement($content);
        // num helper példányosítása
        $num_helper = DI::get('num_helper');

$i = 0; // DEBUG elem

        // ingatlan adatok bejárása
        foreach ($xml->property as $property) {
        
            $data = array();
            

                // Ha szerepel a saját adatbázisban az ingatlan
                $outer_reference_number = $property->{'reference-number'}->__toString();
                if (in_array($outer_reference_number, $outer_properties_ref_nums)) {
                    continue;
                }

                // megye
                $county_code = $property->county->__toString();
                // $this->regions_paired tömbben lévő elemek engedélyezettek
                if (!array_key_exists($county_code, $this->regions_paired)) {
                    continue;
                }

                // Ha az ár elemnek nincs currency attribútuma és az ár nem HUF-bnn van megadva
                if (!isset($property->price['currency']) || $property->price['currency'] != "CUR00000000015F") {
                    continue;
                }

            // ingatlan KATEGÓRIA meghatározása (property elem property-type attribútuma, vagy house-type elem vagy house-function elem)
                $property_type = $property['property-type']->__toString();
                // ha az ingatlan típusa NINCS benne van az option_paired['property-type'] tömbben
                if (!array_key_exists($property_type, $this->options_paired['property-type'])) {
                    continue;
                }

                // ha az ingatlan típus ház, ezért van house-type elem
                if (isset($property->{'house-type'})) {
                    $house_type = $property->{'house-type'}->__toString();
                    // ha a house-type nincs benne az option_paired['house-type'] tömbelemben
                    if (!array_key_exists($house_type, $this->options_paired['house-type'])) {
                        continue;

                    } else {
                        // ha van megfelelő ház típus a saját rendszerben
                        foreach ($this->options_paired['house-type'] as $key => $value) {
                            if ($key == $house_type) {
                                $data['kategoria'] = $value;
                            }   
                        }

                        // ház funkció meghatározása (mert lehet, hogy nyaraló)                           
                        $house_function = $property->{'house-function'}->__toString();
                        // ha a house-function NYARALÓ
                        if ($house_function == 'SPV000000000BTW') {
                            $data['kategoria'] = $this->options_paired['house-function']['SPV000000000BTW'];
                        }
                    }
                } 
                // ha nem ház
                else {
                    // ingatlan kategória ($property_type) - lakás, ház, telek, garázs stb.
                    foreach ($this->options_paired['property-type'] as $key => $value) {
                        if ($key == $property_type) {
                            $data['kategoria'] = $value;
                        }
                    }
                }

        
        // ingatlan adatok behelyezése a $data tömbbe (a kategória már megvan)
              
            // külső referencia szám
            $data['outer_reference_number'] = $property->{'reference-number'}->__toString();

            //$data['ref_id'] = 1; // referens id
            $data['ref_num'] = null; // referenciaszám
            $data['ingatlan_nev_hu'] = $property->description->__toString();
            // az angol nyelvü ingatlan megnevezés, a magyar lesz az angolnál is
            $data['ingatlan_nev_en'] = $data['ingatlan_nev_hu'];

            $data['leiras_hu'] = $property->description_long->__toString();
            $data['status'] = 1;

            // ingatlan típus (eladó / kiadó)
            $agreement_type = $property->{'agreement-type'}->__toString();
            foreach ($this->options_paired['agreement-type'] as $key => $value) {
                if ($key == $agreement_type) {
                    $data['tipus'] = $value;
                }
            }

            // ingatlan állapot
            if (isset($property->{'property-condition'})) {
                $property_condition = $property->{'property-condition'}->__toString();
                foreach ($this->options_paired['property-condition'] as $key => $value) {
                    if ($key == $property_condition) {
                        $data['allapot'] = $value;
                    }
                }
            }

            $data['kiemeles'] = 0;
            
            // megye 
            foreach ($this->regions_paired as $key => $value) {
                if ($county_code == $key) {
                    $data['megye'] = $value;
                }
            }


            // VÁROS és KERÜLET illetve REFERENS id meghatározása
            $city_code = $property->city->__toString();
            if (array_key_exists($city_code, $this->cities)) {
                // ha szerepel a  város a saját rendszerben
                if(!is_null($this->cities[$city_code]['own_city_key'])){
                    $data['varos'] = (int)$this->cities[$city_code]['own_city_key'];
                    // ha van kerület
                    if (!is_null($this->cities[$city_code]['district'])) {
                        $data['kerulet'] = (int)$this->cities[$city_code]['district'];
                    }

                    // Referens id meghatározása
                    $data['ref_id'] = (int)$this->cities[$city_code]['agent_id'];

                } else {
                    // ha nem szerepel a város a saját rendszerben, akkor a következő ingatlanra ugrik
                    continue;
                }
            } else {
                continue;
            }


            $data['utca'] = $property->street->__toString();
            $data['hazszam'] = null;
            $data['emelet_ajto'] = null;
            
            // ha van megadva emelet            
            if (isset($property->floor)) {
                $floor = $property->floor->__toString();

                if (array_key_exists($floor, $this->options_paired['floor'])) {
                    foreach ($this->options_paired['floor'] as $key => $value) {
                        if ($key == $floor) {
                            $data['emelet'] = $value;
                        }
                    }
                }
            }

            $data['tetoter'] = null;
            $data['iranyitoszam'] = $property->{'postal-code'}->__toString();
            $data['epulet_szintjei'] = null;
            $data['utca_megjelenites'] = 0;
            $data['hazszam_megjelenites'] = 0;
            $data['terkep'] = 0;
            
            // ÁR - eladó vagy kiadó
            $price = (int)$property->price->__toString();
            if ($data['tipus'] == 1) {
                $data['ar_elado_eredeti'] = $price;
                $data['ar_elado'] = $price;
            }
            if ($data['tipus'] == 2) {
                $data['ar_kiado_eredeti'] = $price;
                $data['ar_kiado'] = $price;
            }

            // alapterület
            $data['alapterulet'] = (int)$property->size->__toString();
            // telek alapterület
            if (isset($property->{'plot-size'})) {
                $data['telek_alapterulet'] = (int)$property->{'plot-size'}->__toString();
            }
            // ha létezik erkély terület
            if (isset($property->{'total-balcon-size'})) {
                $data['erkely_terulet'] = (int)$property->{'total-balcon-size'}->__toString();
            }
            
            $data['terasz_terulet'] = null;

            // belmagasság
            if (isset($property->stud)) {
                $data['belmagassag'] = intval($num_helper->stringToNumber($property->stud) * 100);
            } else {
                $data['belmagassag'] = null;
            }

            // tájolás
            if (isset($property->siting)) {
                $siting = (int)$property->siting->__toString();
                foreach ($this->options_paired['siting'] as $key => $value) {
                    if ($key == $siting) {
                        $data['tajolas'] = $value;
                    }
                }
            }

            // szobaszám
            if (isset($property->rooms)) {
                $data['szobaszam'] = (int)$property->rooms->__toString();
            }
            // félszoba szám
            if (isset($property->{'half-rooms'})) {
                $data['felszobaszam'] = (int)$property->{'half-rooms'};
            }

            $data['szoba_elrendezes'] = null;
            $data['kozos_koltseg'] = null;
            $data['rezsi'] = null;
           
            // fűtés
            if (isset($property->heating)) {
                $heating = $property->heating->__toString();
                foreach ($this->options_paired['heating'] as $key => $value) {
                    if ($key == $heating) {
                        $data['futes'] = $value;
                    }
                }
            }

            // parkolás
            if (isset($property->{'parking-type'})) {
                $parking_type = $property->{'parking-type'}->__toString();
                foreach ($this->options_paired['parking-type'] as $key => $value) {
                    if ($key == $parking_type) {
                        $data['parkolas'] = $value;
                    }
                }
            }
            
            // ingatlan szerkezet
            if (isset($property->{'building-structure'})) {
                $building_structure = $property->{'building-structure'}->__toString();
                foreach ($this->options_paired['building-structure'] as $key => $value) {
                    if ($key == $building_structure) {
                        $data['szerkezet'] = $value;
                    }
                }
            }
            
            // kilátás
            if (isset($property->facing)) {
                $facing = $property->facing->__toString();
                foreach ($this->options_paired['facing'] as $key => $value) {
                    if ($key == $facing) {
                        $data['kilatas'] = $value;
                    }
                }
            }
            
            // lift
            if (isset($property->lift)) {
                $lift = $property->lift->__toString();
                foreach ($this->options_paired['lift'] as $key => $value) {
                    if ($key == $lift) {
                        $data['lift'] = $value;
                    }
                }
            }

            // energetika
            $data['energetika'] = null;
            // kert
            $data['kert'] = null;

            // ingatlan állapot kívűl
            if (isset($property->{'building-condition-out'})) {
                $building_condition_out = $property->{'building-condition-out'}->__toString();
                foreach ($this->options_paired['building-condition-out'] as $key => $value) {
                    if ($key == $building_condition_out) {
                        $data['haz_allapot_kivul'] = $value;
                    }
                }
            }

            // ingatlan állapot belül
            if (isset($property->{'building-condition-in'})) {
                $building_condition_in = $property->{'building-condition-in'}->__toString();
                foreach ($this->options_paired['building-condition-in'] as $key => $value) {
                    if ($key == $building_condition_in) {
                        $data['haz_allapot_belul'] = $value;
                    }
                }
            }

            // fényviszonyok
            if (isset($property->brightness)) {
                $brightness = $property->brightness->__toString();
                foreach ($this->options_paired['brightness'] as $key => $value) {
                    if ($key == $brightness) {
                        $data['fenyviszony'] = $value;
                    }
                }
            }

            $data['furdo_wc'] = null;
            $data['komfort'] = null;

            // erkély
            $data['erkely'] = isset($property->balconies) ? 1 : 0;
            // terasz
            $data['terasz'] = 0;

            // kép linkek
            if (isset($property->images)) {
                foreach ($property->images->image as $image) {
                    $image_link = $image['url']->__toString();

                    if (isset($image['ground-plan'])) {
                        $photos[] = array(
                          'url' => $image_link,
                          'ground_plan' => true  
                        );
                    } else {
                        $photos[] = array(
                          'url' => $image_link,
                          'ground_plan' => false
                        );
                    }
                

                }
            } else {
                $photos = null;
            }


            // --------- INSERT ------------------------
            $data['hozzaadas_datum'] = time();

            // $this->query->debug(true);
            // a last insert id-t adja vissza
            $last_id = $this->ingatlanok_model->insert($data);
            if ($last_id === false) {
                continue;
            }


            // Képek létrehozása
            if (!empty($photos)) {
                $this->makePhotos($last_id, $photos);
            }


            EventManager::trigger('insert_property', array('insert', '#' . $last_id . ' / ' . $data['ref_num'] . ' - referencia számú ingatlan létrehozása a dunahouse oldalról'));

            // tömbök ürítése
            $data = array();
            $photos = array();


// DEBUG
$i++;
if ($i > 1) {
    break;
}
/*
*/
        }
die('Muvelet kesz! - ' . $i);

	}

    /**
     * [index description]
     * @return [type] [description]
     */
    private function dh_agents()
    {
        //$agents = new \SimpleXMLElement($this->links['agents']);
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    private function dh_offices()
    {
        //$offices = new \SimpleXMLElement($this->links['offices']);
    }


    /**
     *  Képek létrehozása
     *
     * @param integer $id (a rekord id-je, amihez készül a kép)
     * @param integer $photos - a képek elérési útja egy tömbben (minden tömbelem egy asszociatv tömb, amiben
     * van egy url (link) és egy ground_plan (boolean) elem)
     */
    public function makePhotos($id, $photos)
    {
        // a feltöltött képek neveit fogja tárolni
        $new_filenames = array();
        // a feltöltött alaprajz képek neveit fogja tárolni
        $new_gp_filenames = array();

        // temp file elérési útja
        //$temp_upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . Config::get('ingatlan_photo.upload_path') . 'tempfile.';

        foreach ($photos as $photo) {
/*
            // TEMP kép létrehozása (régi verziós upload class esetén 0.34-es előttieknél)
                // meghatározzuk a kép kiterjesztését (a filename alapján)
                $path_parts = pathinfo($photo);
                // létrehozunk (megnyitjuk vagy ha létezik megnyitjuk) egy átmeneti file-t
                // Open for writing only; place the file pointer at the beginning of the file and truncate the file to zero length. If the file does not exist, attempt to create it. 
                $temp_file = fopen($temp_upload_path . $path_parts['extension'], 'w');

                // változóhoz rendeljük a cél kép erőforrást és tartalmat
                $photo_resource = fopen($photo, 'r');        
                $src = stream_get_contents($photo_resource);

                // elmentjük a tempfile-ba a képet
                fwrite($temp_file, $src);

                // zárjuk a fájlokat
                fclose($temp_file);
                fclose($photo_resource);
*/


            // feltöltés helye
            if (!$photo['ground_plan']) {
                $upload_path = Config::get('ingatlan_photo.upload_path');
            } else {
                $upload_path = Config::get('ingatlan_photo_floor_plan.upload_path');
            }    

            $photo_resource = fopen($photo['url'], 'r');    
            $src = stream_get_contents($photo_resource);

            // Végleges képek létrehozása
            $imageobject = new Uploader('data:' . $src);
            // $imageobject = new Uploader($temp_upload_path . $path_parts['extension']);

            $newfilename = $id . '_' . md5(uniqid());
            $width = Config::get('ingatlan_photo.width', 800);
            $height = Config::get('ingatlan_photo.height', 600);

            $imageobject->allowed(array('image/*'));
            $imageobject->cropFillToSize($width, $height, '#fff');
            //       $imageobject->cropToSize($width, $height);
            $imageobject->save($upload_path, $newfilename);

            // A kép neve bekerül a $new_filenames vagy $new_gp_filenames (alaprajz) tömbbe
            // Ha a kép nem alaprajz, vagyis a $photo['ground_plan'] értéke false   
            if (!$photo['ground_plan']) {
                $new_filenames[] = $imageobject->getDest('filename');
            }
            // Ha a kép alaprajz
            else {
                $new_gp_filenames[] = $imageobject->getDest('filename');
            }
            
            if ($imageobject->checkError()) {
                //var_dump($imageobject->getError());
                //echo($imageobject->getLog());
                return false;

            } else {
                // small kép feltöltése
                $new_small_filename = $newfilename . '_small';
                $small_width = Config::get('ingatlan_photo.small_width', 400);
                $small_height = Config::get('ingatlan_photo.small_height', 300);
                $imageobject->cropFillToSize($small_width, $small_height);
                $imageobject->save($upload_path, $new_small_filename);

                // thumb kép feltöltése
                $new_thumb_filename = $newfilename . '_thumb';
                $thumb_width = Config::get('ingatlan_photo.thumb_width', 80);
                $thumb_height = Config::get('ingatlan_photo.thumb_height', 60);
                $imageobject->cropFillToSize($thumb_width, $thumb_height);
                $imageobject->save($upload_path, $new_thumb_filename);
            }
        }

        // temp file-ok törlése
        $imageobject->cleanTemp();



        // kép adatok adatbázisba írása    
/*
        // lekérdezzük a képek mező értékét
        $old_filenames = $this->ingatlanok_model->getFilenames($id, 'kepek');
        // ha már tartalmaz adatot a mező összeolvasztjuk az újakkal
        if (!empty($old_filenames)) {
            $new_filenames = array_merge($old_filenames, $new_filenames);
        }
*/
        // normál képek + alaprajzok száma
        $data['kepek_szama'] = (count($new_filenames) + count($new_gp_filenames));
        // visszaalakítjuk json-ra
        $data['kepek'] = json_encode($new_filenames);
        if (!empty($new_gp_filenames)) {
            $data['alaprajzok'] = json_encode($new_gp_filenames);
        }

        // beírjuk az adatbázisba
        $result = $this->ingatlanok_model->update($id, $data);

        if ($result !== false) {
            return true;
        } else {
            return false;
        }
    }

}
?>