<?php

namespace System\Admin\Controller;

use System\Core\AdminController;
use System\Libs\DI;
use System\Libs\Config;
use System\Libs\Emailer;
//use System\Libs\Message;
use System\Libs\Cookie;
use System\Core\View;

/*
 * Corn jobs - ütemezett feladatok 
 */

class Cron extends AdminController {

    function __construct() {
        parent::__construct();

        // biztoonsági kulcs használata annak érdekében, hogy böngőszőből ne lehessen 
        // egyszerűen futtatni a corn kontrollert, csak a biztonsági kulcs ismeretebében fusson 
        $cron_key = $this->request->get_query('key');
        if ($cron_key != 'DH7AVdT0uGeN-WfZLkgfutDfDeYrqELjjTZrnulm3RY') {
            die('No permission!');
        }
    }

    public function index() {
        
    }

    /*
     * Cron job naplózási adatok elküldéséhez
     * 
     * @param   void
     * @return  void
     */

    public function sendLogEmail() {

        $this->loadModel('logs_model');
        $this->loadModel('settings_model');
        $settings = $this->settings_model->get_settings();
        $this->loadModel('property_model');

        $daily_logs = $this->logs_model->getDailyLogs();
        $data = array();
        // módosított ingatlanok tömbjének előállítása
        foreach ($daily_logs as $key => $log) {
            //ingatlan id kinyerése a log üzenetből
            $result = explode('/', $log['message']);
            $id = substr($result[0], 1);
            $data[] = $this->property_model->getPropertyDetails($id);
            $data[$key]['message'] = $log['message'];
            $data[$key]['referens'] = $log['first_name'] . ' ' . $log['last_name'];
            
            $ingatlan = $this->property_model->getPropertyDetails($id);
            $data[$key]['kerulet'] = ($ingatlan['kerulet']) ? $ingatlan['kerulet'] . ' ker.' : '';
            $data[$key]['utca'] = $ingatlan['utca'];
            $data[$key]['alapterulet'] = $ingatlan['alapterulet'] . ' nm';
            $data[$key]['ar'] = $this->showPrice($ingatlan);
     
        }

        $photo_link = BASE_URL . UPLOADS . 'ingatlan_photo/';
        $url_helper = DI::get('url_helper');
        $str_helper = DI::get('str_helper');

        $html_data = "";
        $html_data .= "<tr style='background: #eee;'>\r\n";
        $html_data .= "<td></td>";
        $html_data .= "<td style='padding: 4px;'><strong>Ingatlan</strong></td>";
        $html_data .= "<td style='padding: 4px;'><strong>Ref.sz. | módosítás | referens</strong></td>";
        $html_data .= "<td style='padding: 4px;'><strong>Link</strong></td>";
        $html_data .= "</tr>\r\n";
        foreach ($data as $key => $value) {
            if (!empty($value['kepek'])) {
                $kep_arr = json_decode($value['kepek']);
                $img = "<img src='" . BASE_URL . $url_helper->thumbPath(Config::get('ingatlan_photo.upload_path') . $kep_arr[0]) . "' />";
            } else {
                $img = "<img src='" . BASE_URL . $url_helper->thumbPath(Config::get('ingatlan_photo.upload_path') . 'placeholder.jpg') . "' />";
            }

            $html_data .= "<tr>\r\n";
            $html_data .= "<td>" . $img . "</td>";
            $html_data .= "<td>" . $value['kerulet'] . ", " . $value['utca'] . ", " . $value['alapterulet'] . ", " . $value['ar'] . "</td>";
            $html_data .= "<td>" . $value['message'] . " | " . $value['referens'] . "</td>";
            $html_data .= "<td><a style='color:blue;' href='" . BASE_URL . 'ingatlanok/adatlap/' . $value['id'] . '/' . $str_helper->stringToSlug($value['ingatlan_nev_hu']) . "' target='_blank'>link-></a></td>";
            $html_data .= "</tr>\r\n";
        }

        // template-be kerülő változók
        $template_data = array(
            'html_data' => $html_data,
            'present_time' => date('Y-m-d h:i', time()),
            'past_time' => date('Y-m-d h:i', time() - (60 * 60 * 24))
        );

        // ingatlan üzletkötők email címének betöltése tömbbe
        $this->loadModel('user_model');
        $users = $this->user_model->selectUser();
        $to_email = array();
        foreach ($users as $user) {
            $to_email[] = $user['email'];
        }

        $to_name = '';
        $subject = 'Napi értesítés ingatlan módosításokról';
        $template = 'daily_logs_email';
        $from_email = $settings['email'];
        $from_name = $settings['ceg'];

        $emailer = new Emailer($from_email, $from_name, $to_email, $to_name, $subject, $template_data, $template);
        $emailer->setArea('admin');
        //$emailer->setDebug(true);
        // true vagy false
        $emailer->send();
    }
    
    /**
     * Ingatlan árának megjelenítése
     * Amennyiben csökkent az ár, a régi ár lehúzva és feketén jelenik meg
     * 
     * @param   array  $ingatlan az ingatlan adatait tartalmazó tömb
     * @return  void
     */
    public function showPrice($ingatlan) {

        $num_helper = DI::get('num_helper');

        if ($ingatlan['tipus'] == 1) {
            if (isset($ingatlan['ar_elado_eredeti']) && $ingatlan['ar_elado_eredeti'] != $ingatlan['ar_elado']) {
                $price = $num_helper->niceNumber($ingatlan['ar_elado']) . ' Ft';
            } else {
                $price = $num_helper->niceNumber($ingatlan['ar_elado']) . ' Ft';
            }
        } else {
            if (isset($ingatlan['ar_kiado_eredeti']) && $ingatlan['ar_kiado_eredeti'] != $ingatlan['ar_kiado']) {
                $price = $num_helper->niceNumber($ingatlan['ar_kiado']) . ' Ft';
            } else {
                $price = $num_helper->niceNumber($ingatlan['ar_kiado']) . ' Ft';
            }
        }
        return $price;
    }    

}

?>