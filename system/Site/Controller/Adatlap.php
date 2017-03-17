<?php
namespace System\Site\Controller;

use System\Core\SiteController;
use System\Libs\Config;
use System\Libs\Language as Lang;

class Adatlap extends SiteController {

    function __construct()
    {
        parent::__construct();
        $this->loadModel('ingatlanok_model');
        
    }
    
    /**
     * Ingatlan adatlap pdf generálása és küldése a böngészőnek
     * 	
     * @param $id integer   ingatlan id
     * @return void 
     */
    public function index($id)
    {
        $id = (int)$id;
        $data = $this->addGlobalData();

        
        $ingatlan = $this->ingatlanok_model->getProperty($id);

        $photos = json_decode($ingatlan['kepek']);
        $photos = array_slice($photos, 0, 3);

        $ingatlan['leiras_' . LANG] = strip_tags($ingatlan['leiras_' . LANG]);

        if ($ingatlan['tipus'] == 1) {
            $elado = Lang::get('kereso_elado');
        } else {
            $elado = Lang::get('kereso_kiado');
        }

        if ($ingatlan['kerulet'] == NULL) {
            $kerulet = '';
        } else {
            $kerulet = $ingatlan['kerulet'];
        }

        if ($ingatlan['utca_megjelenites'] == 0) {
            $utca = '';
        } else {
            $utca = $ingatlan['utca'];
        }

        if ($ingatlan['lift'] == 0) {
            $lift = 'nincs';
        } else {
            $lift = 'van';
        }

        if ($ingatlan['ext_butor'] == 0) {
            $butor = '+';
        } else {
            $butor = '-';
        }

        if ($ingatlan['allapot']) {
            $allapot = $ingatlan['all_leiras_' . LANG];
        } else {
            $allapot = 'n.a.';
        }

        if ($ingatlan['kilatas']) {
            $kilatas = $ingatlan['kilatas_leiras_' . LANG];
        } else {
            $kilatas = 'n.a.';
        }

        if ($ingatlan['futes']) {
            $futes = $ingatlan['futes_leiras_' . LANG];
        } else {
            $futes = 'n.a.';
        }

        if ($ingatlan['parkolas']) {
            $parkolas = $ingatlan['parkolas_leiras_'  . LANG];
        } else {
            $parkolas = 'n.a.';
        }

        if ($ingatlan['energetika']) {
            $energetika = $ingatlan['energetika_leiras_' . LANG];
        } else {
            $energetika = 'n.a.';
        }

        if ($ingatlan['kert']) {
            $kert = $ingatlan['kert_leiras_' . LANG];
        } else {
            $kert = 'n.a.';
        }

        $extrak = '';

        if ($ingatlan['erkely']) {
            $extrak .= 'erkély, ';
        }

        if ($ingatlan['terasz']) {
            $extrak .= 'terasz, ';
        }

        if ($ingatlan['ext_medence']) {
            $extrak .= 'medence, ';
        }

        if ($ingatlan['ext_szauna']) {
            $extrak .= 'szauna, ';
        }

        if ($ingatlan['ext_jacuzzi']) {
            $extrak .= 'jacuzzi, ';
        }

        if ($ingatlan['ext_kandallo']) {
            $extrak .= 'kandalló, ';
        }

        if ($ingatlan['ext_riaszto']) {
            $extrak .= 'riasztó, ';
        }

        if ($ingatlan['ext_klima']) {
            $extrak .= 'klíma, ';
        }

        if ($ingatlan['ext_ontozorendszer']) {
            $extrak .= 'öntözőrendszer, ';
        }

        if ($ingatlan['ext_elektromos_redony']) {
            $extrak .= 'elektromos redőny, ';
        }

        if ($ingatlan['ext_konditerem']) {
            $extrak .= 'konditerem, ';
        }

        $extrak = rtrim($extrak, ", ");


        //		define('FPDF_FONTPATH','/home/www/font');

        //Instanciation of inherited class
        $pdf = new \FPDF();
  //      $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->AddFont('courier', '');
        $pdf->AddFont('courierb', '');
        $pdf->SetFont('courierb', '', 12);
        $pdf->SetXY(50, 20);
        $pdf->SetDrawColor(200, 200, 200);

        // Cell(szélesség, magasság, "szöveg", border (0-L-T-R-B), új pozíció 1- új sor, align, háttérszín, link  )
        $pdf->Cell(120, 10, 'Ingatlan nyilvántartási szám: ' . $ingatlan['id'], 1, 0, 'C', 0);



        //Set x and y position for the main text, reduce font size and write content
        $pdf->SetXY(10, 35);
        $pdf->SetFont('courier', '', 10);



        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(0, 1, '', 0, 0, 'L', 1);
        $pdf->Ln(5);

        $pdf->SetFont('courierb', '', 13);
        $pdf->MultiCell(0, 8, $this->utf8_to_latin2_hun($ingatlan['ingatlan_nev_' . LANG]), 0, 'L', 0);

        $pdf->Ln(5);
        $pdf->SetFont('courier', '', 9);
        $pdf->MultiCell(90, 6, $this->utf8_to_latin2_hun($ingatlan['leiras_' . LANG]), 0, 'J', 0);

        $pdf->Ln(5);

        $pdf->SetFont('courier', 'B', 9);
        $pdf->Cell(0, 6, utf8_decode('Adatok:'), 0, 1, 'L', 0);
        $pdf->SetFont('courier', '', 9);
        $pdf->Cell(30, 5, utf8_decode('Elhelyezkedés:'), 0, 0, 'L', 0);

        if (isset($ingatlan['kerulet']) && ($ingatlan['utca_megjelenites'] == 1)) {
            $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($this->utf8_to_latin2_hun($ingatlan['city_name']) . ' ' . $kerulet . '. kerület ' . $this->utf8_to_latin2_hun($utca)), 0, 1, 'L', 0);
        } elseif (isset($ingatlan['kerulet']) && $ingatlan['utca_megjelenites'] == null) {
            $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($this->utf8_to_latin2_hun($ingatlan['city_name'])) . ' ' . $kerulet . '. kerület ', 0, 1, 'L', 0);
        } elseif (!isset($ingatlan['kerulet']) && ($ingatlan['utca_megjelenites'] == 1)) {
            $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($this->utf8_to_latin2_hun($ingatlan['city_name']) . ', ' . $this->utf8_to_latin2_hun($utca)), 0, 1, 'L', 0);
        } elseif (!isset($ingatlan['kerulet']) && !isset($ingatlan['utca_megjelenites'])) {
            $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($this->utf8_to_latin2_hun($ingatlan['city_name'])), 0, 1, 'L', 0);
        } else {
            $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($this->utf8_to_latin2_hun($ingatlan['city_name'])), 0, 1, 'L', 0);
        }

        $pdf->Cell(30, 5, utf8_decode('Megbízás típusa:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($elado), 0, 1, 'L', 0);
        $pdf->Cell(30, 5, utf8_decode('Ingatlan típusa:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($ingatlan['kat_nev_' . LANG]), 0, 1, 'L', 0);

        $pdf->Cell(30, 5, utf8_decode('Állapot:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($ingatlan['all_leiras_' . LANG]), 0, 1, 'L', 0);

        $pdf->Cell(30, 5, utf8_decode('Terület:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($ingatlan['alapterulet']) . ' nm', 0, 1, 'L', 0);



        $pdf->Cell(30, 5, utf8_decode('Szobák száma:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($ingatlan['szobaszam']), 0, 1, 'L', 0);
        if (isset($ingatlan['emelet'])) {
            $pdf->Cell(30, 5, utf8_decode('Emelet:'), 0, 0, 'L', 0);
            $pdf->Cell(0, 5, $ingatlan['emelet'], 0, 1, 'L', 0);
            $pdf->Cell(30, 5, utf8_decode('Épület szintjei:'), 0, 0, 'L', 0);
            $pdf->Cell(0, 5, $ingatlan['epulet_szintjei'], 0, 1, 'L', 0);
        }

        if (isset($ingatlan['ar_elado'])) {
            $pdf->Cell(30, 5, utf8_decode('Ár:'), 0, 0, 'L', 0);
            $pdf->Cell(0, 5, $this->utf8_to_latin2_hun(number_format($ingatlan['ar_elado'], 0, ',', '.')) . ' Ft', 0, 1, 'L', 0);
        } elseif (isset($ingatlan['ar_kiado'])) {
            $pdf->Cell(30, 5, utf8_decode('Bérleti díj:'), 0, 0, 'L', 0);
            $pdf->Cell(0, 5, $this->utf8_to_latin2_hun(number_format($ingatlan['ar_kiado'], 0, ',', '.')) . ' Ft', 0, 1, 'L', 0);
        }


        $pdf->Ln(5);


        $pdf->SetFont('courierb', '', 9);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun('Jellemzők:'), 0, 1, 'L', 0);
        $pdf->SetFont('courier', '', 9);

        /*         * ************ JELLEMZŐK ************** */
        $pdf->Cell(30, 5, $this->utf8_to_latin2_hun('Fűtés:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($futes), 0, 1, 'L', 0);

        $pdf->Cell(30, 5, utf8_decode('Kilátás:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($kilatas), 0, 1, 'L', 0);

        $pdf->Cell(30, 5, utf8_decode('Bútorozott:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($butor), 0, 1, 'L', 0);

        $pdf->Cell(30, 5, utf8_decode('Parkolás:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($parkolas), 0, 1, 'L', 0);


        $pdf->Cell(30, 5, $this->utf8_to_latin2_hun('Lift:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($lift), 0, 1, 'L', 0);

        $pdf->Cell(30, 5, $this->utf8_to_latin2_hun('Energetikai tan.:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($energetika), 0, 1, 'L', 0);

        $pdf->Cell(30, 5, $this->utf8_to_latin2_hun('Kert:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($kert), 0, 1, 'L', 0);

        $pdf->Ln(5);


        $pdf->SetFont('courierb', '', 9);




        $pdf->MultiCell(0, 5, $this->utf8_to_latin2_hun('Extrák:'), 0, 'L', 0);
        $pdf->SetFont('courier', '', 9);
        $pdf->MultiCell(100, 5, $this->utf8_to_latin2_hun($extrak), 0, 'L', 0);




        $agent = $this->ingatlanok_model->get_agent($ingatlan['ref_id']);

        $pdf->Ln(5);


        $pdf->SetFont('courierb', '', 9);
        $pdf->MultiCell(0, 5, $this->utf8_to_latin2_hun('További információért keresse ingatlan referensünket:'), 0, 'L', 0);
        $pdf->SetFont('courier', '', 9);
        $pdf->MultiCell(0, 5, $this->utf8_to_latin2_hun($agent['first_name']) . ' ' . $this->utf8_to_latin2_hun($agent['last_name']) . $this->utf8_to_latin2_hun(' | Tel: ') . $this->utf8_to_latin2_hun($agent['phone']), 0, 'L', 0);
        $pdf->MultiCell(0, 5, $this->utf8_to_latin2_hun('E-mail: ' . $this->utf8_to_latin2_hun($agent['email'])), 0, 'L', 0);




        //		$pdf->Image(UPLOADS_PATH . $ingatlan['kezdo_kep'],120,55,80);


        $i = 55;

        foreach ($photos as $value) {

            $pdf->Image(Config::get('ingatlan_photo.upload_path') . '/' . $value, 120, $i, 80);
            $i = $i + 65;
        }


        $pdf->Output('adatlap_' . $id . '.pdf', 'D');
        exit();
    }



    /**
     * Ingatlan adatlap
     * @param integer $id
     */
    public function adatlap($id)
    {
        $id = (int)$id;
        $page_data = $this->ingatlanok_model->getPageData('ingatlanok');
        
        $data = $this->addGlobalData();
        $data['title'] = $page_data['metatitle_' . $this->lang];
        $data['description'] = $page_data['metadescription_' . $this->lang];
        $data['keywords'] = $page_data['metakeywords_' . $this->lang];

        // ingatlani adatainak lekérdezése
        $data['ingatlan'] = $this->ingatlanok_model->getProperty($id);
        $data['ingatlan']['ref_num'] = 'S-' . $data['ingatlan']['ref_num'];
        
        // ingatlanhoz tartozó képek
        $data['pictures'] = json_decode($data['ingatlan']['kepek']);
        // ügynök adatai
        $data['agent'] = $this->ingatlanok_model->get_agent($data['ingatlan']['ref_id']);
        
        // Árváltozás értesítés gomb állapotának beállításához kell (disable/enable)
        if (Auth::isUserLoggedIn()) {
            $user_id = Auth::getUser('id');
            
            $this->loadModel('arvaltozas_model');

            $data['ertesites_arvaltozasrol'] = $this->arvaltozas_model->selectPriceChange((int)$user_id, (int)$data['ingatlan']['id']);
        } else {
            $data['ertesites_arvaltozasrol'] = false;
        }


        // csak a valóban létező extrák db nevét tartalamzó tömb elem legyártása
        $data['features'] = array();
        $features_temp = Config::get('extra');
        foreach ($data['ingatlan'] as $key => $value) {
            if (in_array($key, $features_temp) && $value == 1) {
                $data['features'][] = $key;
            }
        }

        // ar változó a hasonló ingatlanok lekérdezéshez
        $ar = ($data['ingatlan']['tipus'] == 1) ? $data['ingatlan']['ar_elado'] : $data['ingatlan']['ar_kiado'];
        // hasonló ingatlanok
        $data['hasonlo_ingatlan'] = $this->ingatlanok_model->hasonloIngatlanok($id, $data['ingatlan']['tipus'], $data['ingatlan']['kategoria'], $data['ingatlan']['varos'], $ar);

        // Megtekintések számának növelése
        $this->ingatlanok_model->increase_no_of_clicks($id);

        $view = new View();
        $view->setHelper(array('url_helper', 'str_helper', 'num_helper', 'html_helper'));
//$this->view->debug(true); 

        $view->add_links(array('google-maps-site'));
        $view->add_link('js', SITE_JS . 'pages/kedvencek.js');
        $view->add_link('js', SITE_JS . 'pages/adatlap.js');
        
        $view->render('ingatlanok/tpl_adatlap', $data);
    }


    

    
     public function utf8_to_latin2_hun($str) {
        return str_replace(array("\xc3\xb6", "\xc3\xbc", "\xc3\xb3", "\xc5\x91", "\xc3\xba", "\xc3\xa9", "\xc3\xa1", "\xc5\xb1", "\xc3\xad", "\xc3\x96", "\xc3\x9c", "\xc3\x93", "\xc5\x90", "\xc3\x9a", "\xc3\x89", "\xc3\x81", "\xc5\xb0", "\xc3\x8d"), array("\xf6", "\xfc", "\xf3", "\xf5", "\xfa", "\xe9", "\xe1", "\xfb", "\xed", "\xd6", "\xdc", "\xd3", "\xd5", "\xda", "\xc9", "\xc1", "\xdb", "\xcd"), $str);
    }   


}
?>