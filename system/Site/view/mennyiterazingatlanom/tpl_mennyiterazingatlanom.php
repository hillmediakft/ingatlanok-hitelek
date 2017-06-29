<?php

use System\Libs\Language as Lang; ?>
<div id="content" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumbs">
                    <span class="clickable"><a href="<?php echo $this->request->get_uri('site_url'); ?>"><?php echo Lang::get('menu_home'); ?></a></span>
                    <span class="delimiter">/</span>
                    <span class="active-page"><?php echo Lang::get('home_szolgaltatasok_1_cim'); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
<?php echo $body; ?>

                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="column-title"><?php echo Lang::get('kapcsolat_email_cim'); ?></h4>
                        <div class="contacts-block">
                            <div class="contact-form">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <span class="contact-message"><?php echo Lang::get('kapcsolat_email_megjegyzes'); ?></span>
                                    </div>
                                </div>
                                <form action="<?php echo (LANG != 'hu') ? LANG . '/' : ''; ?>sendemail/init/mennyit_er_az_ingatlanom" method="POST" id="contact-form-kapcsolat">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text" name="name" class="name" placeholder="<?php echo Lang::get('kapcsolat_email_nev'); ?> *" required oninvalid="this.setCustomValidity('Töltse ki ezt a mezőt!')" oninput="setCustomValidity('')">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="email" name="email" class="email" placeholder="Email *" required oninvalid="this.setCustomValidity('Adjon meg egy email címet!')" oninput="setCustomValidity('')">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="tel" name="phone" class="phone" placeholder="<?php echo Lang::get('kapcsolat_email_telefon'); ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="subject" class="email" placeholder="<?php echo Lang::get('kapcsolat_email_targy'); ?>">
                                        </div>
                                    </div>
                                    <input type="text" name="mezes_bodon" id="mezes_bodon">
                                    <textarea name="message" class="message" placeholder="<?php echo Lang::get('kapcsolat_email_uzenet'); ?> *" required oninvalid="this.setCustomValidity('Töltse ki ezt a mezőt!')" oninput="setCustomValidity('')"></textarea>
                                    <button id="submit-button" class="send-btn"><?php echo Lang::get('kapcsolat_email_kuldes'); ?></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>                

            </div>
        </div>
    </div>
</div>