<?php
namespace System\Site\Controller;
use System\Core\SiteController;
use System\Libs\Emailer;
use System\Libs\Language as Lang;

class SendEmail extends SiteController {

    // fogadó email címe 
    private $to_email;
    // fogadó neve
    private $to_name;
    // levél tárgya
    private $subject;
    // Template file neve tpl_ előtag és kiterjesztés nélkül
    private $template;
    // küldő email címe
    private $from_email;
    // küldő neve
    private $from_name;

    function __construct() {
        parent::__construct();
    }

    /**
     * A paraméterként kapott string alapján beállítja az email küldés adatait
     *
     * @param string $template
     */
    public function init($template)
    {
        if ($this->request->is_ajax() && $this->request->get_post('name') !== '') {

            $data = $this->addGlobalData();
            $this->attachment = array();

            if (isset($_FILES['fileupload']) && $_FILES['fileupload']['error'] == 0) {
                $this->attachment['tmp_name'] = $_FILES['fileupload']['tmp_name'];
                $this->attachment['name'] = $_FILES['fileupload']['name'];
            }
            if ($this->request->get_post('mezes_bodon') === '') {
                if ($template == "contact") {
                    $this->to_email = $data['settings']['email'];
                    $this->to_name = $data['settings']['ceg'];
                    $this->subject = 'Érdeklődés';
                    $this->template = $template;
                    $this->from_email = $this->request->get_post('email');
                    $this->from_name = $this->request->get_post('name');
                } elseif ($template == "allas") {
                    $this->to_email = $data['settings']['email'];
                    $this->to_name = $data['settings']['ceg'];
                    $this->subject = 'Állás érdeklődés';
                    $this->template = $template;
                    $this->from_email = $this->request->get_post('email');
                    $this->from_name = $this->request->get_post('name');
                
                } elseif ($template == "mennyit_er_az_ingatlanom") {
                    $this->to_email = $data['settings']['email'];
                    $this->to_name = $data['settings']['ceg'];
                    $this->subject = 'Ingatlanbecslés';
                    $this->template = $template;
                    $this->from_email = $this->request->get_post('email');
                    $this->from_name = $this->request->get_post('name');

                } elseif ($template == "landing_page") {
                    $this->to_email = $data['settings']['email'];
                    $this->to_name = $data['settings']['ceg'];
                    $this->subject = 'Információ';
                    $this->template = $template;
                    $this->from_email = $this->request->get_post('email');
                    $this->from_name = $this->request->get_post('name');

                } elseif ($template == "agent") {
                    $this->to_email = $this->request->get_post('agent_email');
                    $this->to_name = $this->request->get_post('agent_name');
                    $this->subject = 'Érdeklődés';
                    $this->template = $template;
                    $this->from_email = $this->request->get_post('email');
                    $this->from_name = $this->request->get_post('name');
                } elseif ($template == "agent_info") {
                    $this->to_email = $this->request->get_post('agent_email');
                    $this->to_name = $this->request->get_post('agent_name');
                    $this->subject = 'Érdeklődés';
                    $this->template = $template;
                    $this->from_email = $this->request->get_post('email');
                    $this->from_name = $this->request->get_post('name');
                } elseif ($template == "seller") {
                    $this->to_email = $data['settings']['email'];
                    $this->to_name = $data['settings']['ceg'];
                    $this->subject = 'Eladó ingatlan';
                    $this->template = $template;
                    $this->from_email = $this->request->get_post('email');
                    $this->from_name = $this->request->get_post('name');
                } elseif ($template == "tanusitvany") {
                    $this->to_email = $data['settings']['email'];
                    $this->to_name = $data['settings']['ceg'];
                    $this->subject = 'Energetikai tanusítvány rendelés';
                    $this->template = $template;
                    $this->from_email = $this->request->get_post('email');
                    $this->from_name = $this->request->get_post('name');
                } elseif ($template == "on_hirdetese") {
                    $this->to_email = $data['settings']['email'];
                    $this->to_name = $data['settings']['ceg'];
                    $this->subject = 'Hirdetni szeretnék';
                    $this->template = $template;
                    $this->from_email = $this->request->get_post('email');
                    $this->from_name = $this->request->get_post('name');

                } elseif ($template == "ingyenes_elemzes") {
                    $this->to_email = $data['settings']['email'];
                    $this->to_name = $data['settings']['ceg'];
                    $this->subject = 'Ingyenes elemzést kérek';
                    $this->template = $template;
                    $this->from_email = $this->request->get_post('email');
                    $this->from_name = $this->request->get_post('name');
                } else {
                    exit;
                }
                $this->send();
            } else {
                exit;
            }
        }
    }

    /**
     * Email küldése
     */
    public function send()
    {   
        // paraméterek: ($from_email, $from_name, $to_email, $to_name, $subject, $form_data, $template)
        $emailer = new Emailer($this->from_email, $this->from_name, $this->to_email, $this->to_name, $this->subject, $this->request->get_post(), $this->template, $this->attachment);

        // SMTP beallitasok visszaadása (ami a global_data-ban már szerepel)
        $global_data = $this->addGlobalData();
        // SMTP beállítások a settings táblából
        
        $emailer->setSmtpSettings(array(
            'smtp_host' => $global_data['settings']['smtp_host'],
            'smtp_username' => $global_data['settings']['smtp_username'],
            'smtp_password' => $global_data['settings']['smtp_password'],
            'smtp_port' => $global_data['settings']['smtp_port'],
            'smtp_encryption' => $global_data['settings']['smtp_encryption']
        ));

        if ($emailer->send()) {
            $this->response->json(array(
                'status' => 'success',
                'title' => Lang::get('kapcsolat_email_kuldes_siker_cim'),
                'message' => Lang::get('kapcsolat_email_kuldes_siker_uzenet')
            ));
        } else {
            $this->response->json(array(
                'status' => 'error',
                'title' => Lang::get('kapcsolat_email_kuldes_hiba_cim'),
                'message' => Lang::get('kapcsolat_email_kuldes_hiba_uzenet')
            ));
        }
    }

}
?>