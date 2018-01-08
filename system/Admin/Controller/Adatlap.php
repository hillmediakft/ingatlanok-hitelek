<?php

namespace System\Admin\Controller;

use System\Core\AdminController;
use System\Libs\Config;
use System\Helper\Str;
use System\Libs\Language as Lang;
use System\Libs\DI;

class Adatlap extends AdminController {

    function __construct() {
        parent::__construct();
        $this->loadModel('property_model');
        $this->str_helper = DI::get('str_helper');
    }

    /**
     * Ingatlan adatlap pdf generálása és küldése a böngészőnek
     *  
     * @param $id integer   ingatlan id
     * @return void 
     */
    public function index($id) {
        $id = (int) $id;
        $data = $this->addGlobalData();

        $agent_id = $this->request->get_post('agent_id', 'integer');

        $agent = $this->property_model->get_agent($agent_id);
        $ingatlan = $this->property_model->getPropertyDetails($id);
        $alaprajzok = json_decode($ingatlan['alaprajzok']);
        $all_photos = json_decode($ingatlan['kepek']);
        $photos = array_slice($all_photos, 0, 2);
        $photos2 = array_slice($all_photos, 0, 8);


        $ingatlan['leiras_' . LANG] = strip_tags($ingatlan['leiras_' . LANG]);

        if ($ingatlan['tipus'] == 1) {
            $elado = 'eladó';
        } else {
            $elado = 'kiadó';
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
            $parkolas = $ingatlan['parkolas_leiras_' . LANG];
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

        if ($ingatlan['ext_butor'] == 0) {
            $butor = '+';
        } else {
            $butor = '-';
        }

        $extrak = '';

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
        if ($ingatlan['ext_automata_kapu']) {
            $extrak .= 'automata kapu, ';
        }
        if ($ingatlan['ext_elektromos_redony']) {
            $extrak .= 'elektromos redőny, ';
        }
        if ($ingatlan['ext_konditerem']) {
            $extrak .= 'konditerem, ';
        }
        if ($ingatlan['ext_galeria']) {
            $extrak .= 'galéria, ';
        }
        if ($ingatlan['ext_furdoben_kad']) {
            $extrak .= 'fürdőben kád, ';
        }
        if ($ingatlan['ext_furdoben_zuhany']) {
            $extrak .= 'fürdőben zuhany, ';
        }
        if ($ingatlan['ext_masszazskad']) {
            $extrak .= 'masszázskád, ';
        }
        if ($ingatlan['ext_amerikaikonyha']) {
            $extrak .= 'amerikai konyha, ';
        }
        if ($ingatlan['ext_konyhaablak']) {
            $extrak .= 'konyhaablak, ';
        }
        if ($ingatlan['ext_kamra']) {
            $extrak .= 'kamra, ';
        }
        if ($ingatlan['ext_pince']) {
            $extrak .= 'pince, ';
        }
        if ($ingatlan['ext_panorama']) {
            $extrak .= 'panoráma, ';
        }
        if ($ingatlan['ext_biztonsagi_ajto']) {
            $extrak .= 'biztonsági ajtó, ';
        }
        if ($ingatlan['ext_redony']) {
            $extrak .= 'redőny, ';
        }
        if ($ingatlan['ext_racs']) {
            $extrak .= 'rács, ';
        }
        if ($ingatlan['ext_video_kaputelefon']) {
            $extrak .= 'videó kaputelefon, ';
        }
        if ($ingatlan['ext_porta_szolgalat']) {
            $extrak .= 'porta szolgálat, ';
        }
        if ($ingatlan['ext_beepitett_szekreny']) {
            $extrak .= 'beépített szekrény, ';
        }
        if ($ingatlan['ext_tarolo_helyiseg']) {
            $extrak .= 'tároló helyiség, ';
        }

        if ($ingatlan['erkely']) {
            $extrak .= 'erkély, ';
        }
        if ($ingatlan['terasz']) {
            $extrak .= 'terasz, ';
        }


        $extrak = rtrim($extrak, ", ");

        if (isset($ingatlan['ar_elado'])) {
            $price = number_format($ingatlan['ar_elado'], 0, '.', ' ') . ' Ft';
        } elseif (isset($ingatlan['ar_kiado'])) {
            $price = number_format($ingatlan['ar_kiado'], 0, '.', ' ') . ' Ft / ';
        }

        if (!is_null($ingatlan['belmagassag'])) {
            $belmagassag = $ingatlan['belmagassag'] . ' cm';
        } else {
            $belmagassag = 'n.a.';
        }

        if (!is_null($ingatlan['kozos_koltseg'])) {
            $kozos_koltseg = $ingatlan['kozos_koltseg'] . ' Ft';
        } else {
            $kozos_koltseg = 'n.a.';
        }

        //      define('FPDF_FONTPATH','/home/www/font');
        //Instanciation of inherited class
        $pdf = new \FPDF();
        //      $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->AddFont('arial', '', 'arial.php');
        $pdf->AddFont('arialb', '', 'arialb.php');


        // link, x, y, width
        $pdf->Image('public/site_assets/images/logo_pdf.png', 10, 10, 35);
        $pdf->SetFont('arialb', '', 9);
        $pdf->Cell(0, 43, $this->utf8_to_latin2_hun('Ingatlan - hitel - befektetés'), 0, 0, 'L', 0);




        /*         * ***** képek megjelenítése ******** */
        $i = 55;
        foreach ($photos as $value) {

            $pdf->Image(Config::get('ingatlan_photo.upload_path') . '/' . $value, 120, $i, 80);
            $i = $i + 62;
        }
        /*
         * Névjegykártya
         */
        // névjegykártya keret
        $pdf->Image('public/site_assets/images/border.png', 134, 7, 67);
        $pdf->SetXY(135, 14);
        $pdf->SetDrawColor(200, 200, 200);

        $pdf->SetFont('arial', '', 6);
        $pdf->Cell(0, 3, $this->utf8_to_latin2_hun('1095 Budapest, Bakáts u. 1.'), 0, 2, 'L', 0);
        $pdf->Cell(0, 3, $this->utf8_to_latin2_hun('Tel: 06-1-215-1490'), 0, 2, 'L', 0);
        $pdf->Cell(0, 3, $this->utf8_to_latin2_hun('Mobil: ') . $this->utf8_to_latin2_hun($agent['phone']), 0, 2, 'L', 0);
        $pdf->Cell(0, 3, $this->utf8_to_latin2_hun('E-mail: ' . $this->utf8_to_latin2_hun($agent['email'])), 0, 2, 'L', 0);
        $pdf->SetXY(175, 14);
        $pdf->SetFont('arial', '', 7);
        $pdf->Cell(0, 3, '', 0, 2, 'L', 0);
        $pdf->Cell(0, 3, $this->utf8_to_latin2_hun($agent['first_name']) . ' ' . $this->utf8_to_latin2_hun($agent['last_name']), 0, 2, 'L', 0);
        $pdf->Cell(0, 3, $this->utf8_to_latin2_hun('Ingatlan tanácsadó'), 0, 2, 'L', 0);
        $pdf->SetXY(135, 28);
        $pdf->SetFillColor(158, 40, 40);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(0, 5, 'https://ingatlanok-hitelek.hu', 0, 2, 'C', 1);

        // Cell(szélesség, magasság, "szöveg", border (0-L-T-R-B), új pozíció 1- új sor, align, háttérszín, link  )
        //Set x and y position for the main text, reduce font size and write content
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(10, 35);
        $pdf->SetFont('arial', '', 10);



        $pdf->SetFillColor(230, 230, 230);

        $pdf->Cell(0, 1, '', 0, 0, 'L', 1);
        $pdf->Ln(5);

        $pdf->SetFont('arialb', '', 12);
        if (isset($ingatlan['kerulet']) && ($ingatlan['utca_megjelenites'] == 1)) {
            $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($this->utf8_to_latin2_hun($ingatlan['city_name']) . ', ' . $kerulet . '. ' . $this->utf8_to_latin2_hun('kerület') . ', ' . $this->utf8_to_latin2_hun($utca)), 0, 1, 'C', 0);
        } elseif (isset($ingatlan['kerulet']) && $ingatlan['utca_megjelenites'] == null) {
            $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($this->utf8_to_latin2_hun($ingatlan['city_name'])) . ' ' . $kerulet . '. ' . $this->utf8_to_latin2_hun('kerület'), 0, 1, 'C', 0);
        } elseif (!isset($ingatlan['kerulet']) && ($ingatlan['utca_megjelenites'] == 1)) {
            $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($this->utf8_to_latin2_hun($ingatlan['city_name']) . ', ' . $this->utf8_to_latin2_hun($utca)), 0, 1, 'C', 0);
        } elseif (!isset($ingatlan['kerulet']) && !isset($ingatlan['utca_megjelenites'])) {
            $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($this->utf8_to_latin2_hun($ingatlan['city_name'])), 0, 1, 'C', 0);
        } else {
            $pdf->Cell(0, 5, $this->utf8_to_latin2_hun($this->utf8_to_latin2_hun($ingatlan['city_name'])), 0, 1, 'C', 0);
        }
        $pdf->MultiCell(0, 8, $this->utf8_to_latin2_hun($ingatlan['ingatlan_nev_' . LANG]), 0, 'C', 0);
        $pdf->Ln(2);
        $pdf->SetFont('arialb', '', 11);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->SetXY(10, 58);
        //$pdf->Cell(0, 5, $this->utf8_to_latin2_hun('Ref. szám: ' . $ingatlan['ref_num']), 0, 1, 'L', 0);
        $pdf->Cell(105, 5, $this->utf8_to_latin2_hun($elado) . ' | ' . $this->utf8_to_latin2_hun($ingatlan['kat_nev_' . LANG]) . ' | ' . $price, 0, 1, 'L', true);
        $pdf->Ln(2);

        $pdf->Ln(5);
        $pdf->SetFont('arial', '', 8);
        $pdf->MultiCell(90, 4, $this->str_helper->substrWord($this->utf8_to_latin2_hun($ingatlan['leiras_' . LANG]), 1400), 0, 'L', 0);

        $pdf->Ln(5);

        /*
         * ************ADATOK *******************
         */
        $pdf->SetXY(10, 185);
        $pdf->SetFont('arial', 'B', 9);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->Cell(90, 5, utf8_decode('Adatok:'), 0, 1, 'L', true);
        $pdf->SetFont('arial', '', 8);

        $pdf->Cell(30, 4, utf8_decode('Ref. szám:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($ingatlan['ref_num']), 0, 1, 'L', 0);

        $pdf->Cell(30, 4, utf8_decode('Elhelyezkedés:'), 0, 0, 'L', 0);

        if (isset($ingatlan['kerulet']) && ($ingatlan['utca_megjelenites'] == 1)) {
            $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($this->utf8_to_latin2_hun($ingatlan['city_name']) . ' ' . $kerulet . '. ' . $this->utf8_to_latin2_hun('kerület') . ' ' . $this->utf8_to_latin2_hun($utca)), 0, 1, 'L', 0);
        } elseif (isset($ingatlan['kerulet']) && $ingatlan['utca_megjelenites'] == null) {
            $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($this->utf8_to_latin2_hun($ingatlan['city_name'])) . ' ' . $kerulet . '. ' . $this->utf8_to_latin2_hun('kerület'), 0, 1, 'L', 0);
        } elseif (!isset($ingatlan['kerulet']) && ($ingatlan['utca_megjelenites'] == 1)) {
            $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($this->utf8_to_latin2_hun($ingatlan['city_name']) . ', ' . $this->utf8_to_latin2_hun($utca)), 0, 1, 'L', 0);
        } elseif (!isset($ingatlan['kerulet']) && !isset($ingatlan['utca_megjelenites'])) {
            $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($this->utf8_to_latin2_hun($ingatlan['city_name'])), 0, 1, 'L', 0);
        } else {
            $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($this->utf8_to_latin2_hun($ingatlan['city_name'])), 0, 1, 'L', 0);
        }

        $pdf->Cell(30, 4, utf8_decode('Megbízás típusa:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($elado), 0, 1, 'L', 0);
        $pdf->Cell(30, 4, utf8_decode('Ingatlan típusa:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($ingatlan['kat_nev_' . LANG]), 0, 1, 'L', 0);

        $pdf->Cell(30, 4, utf8_decode('Állapot:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($ingatlan['all_leiras_' . LANG]), 0, 1, 'L', 0);

        $pdf->Cell(30, 4, $this->utf8_to_latin2_hun('Állapot kívűl:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($ingatlan['haz_allapot_kivul_leiras_' . LANG]), 0, 1, 'L', 0);

        $pdf->Cell(30, 4, utf8_decode('Terület:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($ingatlan['alapterulet']) . ' nm', 0, 1, 'L', 0);

        $pdf->Cell(30, 4, utf8_decode('Belmagasság:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 4, $belmagassag, 0, 1, 'L', 0);

        $pdf->Cell(30, 4, utf8_decode('Közös költség:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 4, $kozos_koltseg, 0, 1, 'L', 0);


        $pdf->Cell(30, 4, utf8_decode('Szobák száma:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($ingatlan['szobaszam']), 0, 1, 'L', 0);
        if (isset($ingatlan['emelet'])) {
            $pdf->Cell(30, 4, utf8_decode('Emelet:'), 0, 0, 'L', 0);
            $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($ingatlan['emelet_leiras_' . LANG]), 0, 1, 'L', 0);
            $pdf->Cell(30, 4, utf8_decode('Épület szintjei:'), 0, 0, 'L', 0);
            $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($ingatlan['epulet_szintjei_leiras_' . LANG]), 0, 1, 'L', 0);
        }

        if (isset($ingatlan['ar_elado'])) {
            $pdf->Cell(30, 4, utf8_decode('Ár:'), 0, 0, 'L', 0);
            $pdf->Cell(0, 4, $this->utf8_to_latin2_hun(number_format($ingatlan['ar_elado'], 0, ',', '.')) . ' Ft', 0, 1, 'L', 0);
        } elseif (isset($ingatlan['ar_kiado'])) {
            $pdf->Cell(30, 4, utf8_decode('Bérleti díj:'), 0, 0, 'L', 0);
            $pdf->Cell(0, 4, $this->utf8_to_latin2_hun(number_format($ingatlan['ar_kiado'], 0, ',', '.')) . ' Ft', 0, 1, 'L', 0);
        }


        $pdf->Ln(5);

        /*
         * ******************** JELLEMZŐK *************************
         */
        $pdf->SetXY(110, 185);
        $pdf->SetFont('arialb', '', 9);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun('Jellemzők:'), 0, 2, 'L', true);
        $pdf->SetFont('arial', '', 8);

        /*         * ************ JELLEMZŐK ************** */
        $pdf->SetXY(110, 190);
        $pdf->Cell(30, 4, $this->utf8_to_latin2_hun('Fűtés:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($futes), 0, 0, 'L', 0);

        $pdf->SetXY(110, 194);
        $pdf->Cell(30, 4, utf8_decode('Kilátás:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($kilatas), 0, 0, 'L', 0);

        $pdf->SetXY(110, 198);
        $pdf->Cell(30, 4, utf8_decode('Bútorozott:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($butor), 0, 0, 'L', 0);

        $pdf->SetXY(110, 202);
        $pdf->Cell(30, 4, utf8_decode('Parkolás:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($parkolas), 0, 0, 'L', 0);

        $pdf->SetXY(110, 206);
        $pdf->Cell(30, 4, $this->utf8_to_latin2_hun('Lift:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($lift), 0, 0, 'L', 0);

        $pdf->SetXY(110, 210);
        $pdf->Cell(30, 4, $this->utf8_to_latin2_hun('Energetikai tan.:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($energetika), 0, 0, 'L', 0);

        $pdf->SetXY(110, 214);
        $pdf->Cell(30, 4, $this->utf8_to_latin2_hun('Kert:'), 0, 0, 'L', 0);
        $pdf->Cell(0, 4, $this->utf8_to_latin2_hun($kert), 0, 2, 'L', 0);


        $pdf->SetFont('arialb', '', 9);


        /*
         * **************EXTRÁK *********************
         */
        $pdf->SetXY(110, 220);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->Cell(0, 5, $this->utf8_to_latin2_hun('Extrák:'), 0, 2, 'L', true);
        $pdf->SetFont('arial', '', 8);
        $pdf->MultiCell(0, 5, $this->utf8_to_latin2_hun($extrak), 0, 'L', 0);



        $pdf->SetXY(10, 245);
        $pdf->Ln(5);
        /*
         * ****************** INGATLAN REFERENS KAPCSOLAT
         */

        $pdf->SetFont('arialb', '', 9);
        $pdf->MultiCell(0, 5, $this->utf8_to_latin2_hun('További információért keresse ingatlan referensünket:'), 0, 'C', 0);
        $pdf->SetFont('arial', '', 8);
        $pdf->MultiCell(0, 5, $this->utf8_to_latin2_hun($agent['first_name']) . ' ' . $this->utf8_to_latin2_hun($agent['last_name']) . $this->utf8_to_latin2_hun(' | Tel: ') . $this->utf8_to_latin2_hun($agent['phone']) . $this->utf8_to_latin2_hun(' | E-mail: ' . $this->utf8_to_latin2_hun($agent['email'])), 0, 'C', 0);

        $pdf->Ln(2);
        $pdf->SetFont('arialb', '', 10);
        $pdf->Cell(0, 6, $this->utf8_to_latin2_hun('TOVÁBBI KÉPEK A KÖVETKEZŐ OLDALON!'), 0, 2, 'C', 0);


        /*
         * ************** MÁSODIK OLDAL *********************
         */
        $pdf->AddPage();
        // link, x, y, width
        /*       $pdf->Image('public/site_assets/images/logo_pdf.png', 10, 10, 35);
          $pdf->SetFont('arialb', '', 9);
          $pdf->Cell(0, 43, $this->utf8_to_latin2_hun('Ingatlan - hitel - befektetés'), 0, 0, 'L', 0);

         */


        /*
         * Névjegykártya
         */
        // névjegykártya keret
        /*       $pdf->Image('public/site_assets/images/border.png', 134, 7, 67);
          $pdf->SetXY(135, 14);
          $pdf->SetDrawColor(200, 200, 200);

          $pdf->SetFont('arial', '', 6);
          $pdf->Cell(0, 3, $this->utf8_to_latin2_hun('1095 Budapest, Bakáts u. 1.'), 0, 2, 'L', 0);
          $pdf->Cell(0, 3, $this->utf8_to_latin2_hun('Tel: 06-1-215-1490'), 0, 2, 'L', 0);
          $pdf->Cell(0, 3, $this->utf8_to_latin2_hun('Mobil: ') . $this->utf8_to_latin2_hun($agent['phone']), 0, 2, 'L', 0);
          $pdf->Cell(0, 3, $this->utf8_to_latin2_hun('E-mail: ' . $this->utf8_to_latin2_hun($agent['email'])), 0, 2, 'L', 0);
          $pdf->SetXY(175, 14);
          $pdf->SetFont('arial', '', 7);
          $pdf->Cell(0, 3, '', 0, 2, 'L', 0);
          $pdf->Cell(0, 3, $this->utf8_to_latin2_hun($agent['first_name']) . ' ' . $this->utf8_to_latin2_hun($agent['last_name']), 0, 2, 'L', 0);
          $pdf->Cell(0, 3, $this->utf8_to_latin2_hun('Ingatlan tanácsadó'), 0, 2, 'L', 0);
          $pdf->SetXY(135, 28);
          $pdf->SetFillColor(158, 40, 40);
          $pdf->SetTextColor(255, 255, 255);
          $pdf->Cell(0, 5, 'https://ingatlanok-hitelek.hu', 0, 2, 'C', 1);

          $pdf->SetXY(10, 35);
          $pdf->SetFillColor(230, 230, 230);

          $pdf->Cell(0, 1, '', 0, 2, 'L', true);
          $pdf->Ln(5); */

        /*         * ***** képek megjelenítése ******** */
        $pdf->SetTextColor(0, 0, 0);
        $x = 10;
        $y = 15;
        $k = 1;
        foreach ($photos2 as $value) {
            if ($k % 2 == 0) {

                $x = 100;


                //      $pdf->Cell(0, 5, 'k: ' . $k . ' x= ' . $x . ' y= ' . $y, 0, 2, 'L', 0);

                $pdf->Image(Config::get('ingatlan_photo.upload_path') . '/' . $value, $x, $y, 80);
                $y = $y + 65;
            } else {
                $x = 10;

                //        $pdf->Cell(0, 5, 'k: ' . $k . ' x= ' . $x . ' y= ' . $y, 0, 2, 'L', 0);

                $pdf->Image(Config::get('ingatlan_photo.upload_path') . '/' . $value, $x, $y, 80);
            }

            $k = $k + 1;
        }





        /*         * ************* MÁSODIK OLDAL VÉGE ********* */


        /*
         * ************** Harmadik OLDAL *********************
         */
        if (!empty($alaprajzok)) {
            $pdf->AddPage();

            $pdf->SetTextColor(0, 0, 0);


            $x = 10;
            $y = 15;
            $max = (count($alaprajzok) <= 3) ? count($alaprajzok) : 3;
            for ($k = 1; $k <= $max; $k++) {
                //      $pdf->Cell(0, 5, 'k: ' . $k . ' x= ' . $x . ' y= ' . $y, 0, 2, 'L', 0);

                $pdf->Image(Config::get('ingatlan_photo_floor_plan.upload_path') . '/' . $alaprajzok[$k - 1], $x, $y, 110);
                $y = $y + 90;
            }

            /* alaprajzok megjelenítése két oszlopban */
            /*
              $x = 10;
              $y = 15;
              $k = 1;
              foreach ($alaprajzok as $value) {
              if ($k % 2 == 0) {

              $x = 100;


              //      $pdf->Cell(0, 5, 'k: ' . $k . ' x= ' . $x . ' y= ' . $y, 0, 2, 'L', 0);

              $pdf->Image(Config::get('ingatlan_photo_floor_plan.upload_path') . '/' . $value, $x, $y, 80);
              $y = $y + 65;
              } else {
              $x = 10;

              //        $pdf->Cell(0, 5, 'k: ' . $k . ' x= ' . $x . ' y= ' . $y, 0, 2, 'L', 0);

              $pdf->Image(Config::get('ingatlan_photo_floor_plan.upload_path') . '/' . $value, $x, $y, 80);
              }

              $k = $k + 1;
              } */
        }
        /*         * ************* HARMADIK OLDAL VÉGE ********* */


        $pdf->Output('adatlap_' . $id . '.pdf', 'D');
        exit();
    }

    public function utf8_to_latin2_hun($str) {
        return str_replace(
                array("\xc2\xa0", "\xc3\xb6", "\xc3\xbc", "\xc3\xb3", "\xc5\x91", "\xc3\xba", "\xc3\xa9", "\xc3\xa1", "\xc5\xb1", "\xc3\xad", "\xc3\x96", "\xc3\x9c", "\xc3\x93", "\xc5\x90", "\xc3\x9a", "\xc3\x89", "\xc3\x81", "\xc5\xb0", "\xc3\x8d"), array("\x20", "\xf6", "\xfc", "\xf3", "\xf5", "\xfa", "\xe9", "\xe1", "\xfb", "\xed", "\xd6", "\xdc", "\xd3", "\xd5", "\xda", "\xc9", "\xc1", "\xdb", "\xcd"), $str
        );

        // U+00A0       \xc2\xa0    &#xA0;      NO-BREAK SPACE
        // \x20 space karakter
        // U+00C2   Â   \xc3\x82    &#xC2;  Â   LATIN CAPITAL LETTER A WITH CIRCUMFLEX        
    }

}

?>