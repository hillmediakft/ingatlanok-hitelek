<?php

use System\Libs\Config;
use System\Libs\Language as Lang;
?>
<div class="scroll-container">
    <div class="container">
        <a href="#" class="scroll-top-btn"><i class="fa fa-angle-double-up"></i></a>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-md-3">
                <div class="widget">
                    <span class="widget-title"><?php echo Lang::get('footer_rolunk_cim'); ?></span>
                    <p class="text"><?php echo Lang::get('footer_rolunk_szoveg'); ?></p>
                    <div class="social-block">
                        <ul class="sociable-listing">
                            <?php if ($settings['facebook']) { ?>
                                <li class="sociable-item">
                                    <a href="<?php echo $settings['facebook']; ?>" class="social-icon"><i class="fa fa-facebook"></i></a>
                                </li>
                            <?php } ?>
                            <?php if ($settings['linkedin']) { ?>
                                <li class="sociable-item">
                                    <a href="<?php echo $settings['linkedin']; ?>" class="social-icon"><i class="fa fa-linkedin"></i></a>
                                </li>
                            <?php } ?>
                            <?php if ($settings['twitter']) { ?>
                                <li class="sociable-item">
                                    <a href="<?php echo $settings['twitter']; ?>" class="social-icon"><i class="fa fa-twitter"></i></a>
                                </li>
                            <?php } ?>
                            <?php if ($settings['googleplus']) { ?>
                                <li class="sociable-item">
                                    <a href="<?php echo $settings['googleplus']; ?>" class="social-icon"><i class="fa fa-google-plus"></i></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-3">
                <div class="widget contact">
                    <span class="widget-title"><?php echo Lang::get('footer_kapcsolat'); ?></span>
                    <ul class="contacts-listing">
                        <li>
                            <div class="icon">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div class="descr">
                                <span><?php echo $settings['cim']; ?></span>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="descr">
                                <span><?php echo $settings['tel']; ?></span>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="descr">
                                <a href="mailto:<?php echo $settings['email']; ?>"><?php echo $settings['email']; ?></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="hidden-sm col-md-3">
                <div class="widget latest-tweets">
                    <span class="widget-title"><?php echo Lang::get('footer_ingatlanok'); ?></span>
                    <ul class="property-listing">
                        <?php
                        $url_path = (LANG != 'hu') ? LANG . '/' : '';
                        $url_path .= Config::get('url.ingatlanok.index.' . LANG);
                        ?>
                        <li><a class="author" href="<?php echo $url_path; ?>?tipus=1&varos=88&kategoria=1&min_alapterulet=&max_alapterulet=&min_ar=&max_ar=">Budapest <?php echo mb_strtolower(Lang::get('jell_elado'), 'UTF-8'); ?><?php echo (LANG == 'hu') ? ' lakás' : ' apartman'; ?>  </a></li>
                        <li><a class="author" href="<?php echo $url_path; ?>?tipus=2&varos=88&kategoria=1&min_alapterulet=&max_alapterulet=&min_ar=&max_ar=">Budapest <?php echo mb_strtolower(Lang::get('jell_kiado'), 'UTF-8'); ?><?php echo (LANG == 'hu') ? ' lakás' : ' apartman'; ?>  </a></li>
                        <li><a class="author" href="<?php echo $url_path; ?>?tipus=1&varos=88&kerulet%5B%5D=5&kategoria=1&min_alapterulet=&max_alapterulet=&min_ar=&max_ar=">Budapest 5. <?php echo Lang::get('adatlap_kerulet'); ?></a></li>
                        <li><a class="author" href="<?php echo $url_path; ?>?tipus=1&varos=88&kerulet%5B%5D=6&kategoria=1&min_alapterulet=&max_alapterulet=&min_ar=&max_ar=">Budapest 6. <?php echo Lang::get('adatlap_kerulet'); ?></a></li>
                        <li><a class="author" href="<?php echo $url_path; ?>?tipus=1&varos=88&kerulet%5B%5D=7&kategoria=1&min_alapterulet=&max_alapterulet=&min_ar=&max_ar=">Budapest 7. <?php echo Lang::get('adatlap_kerulet'); ?></a></li>
                        <li><a class="author" href="<?php echo $url_path; ?>?tipus=1&varos=88&kerulet%5B%5D=9&kategoria=1&min_alapterulet=&max_alapterulet=&min_ar=&max_ar=">Budapest 9. <?php echo Lang::get('adatlap_kerulet'); ?></a></li>
                        <li><a class="author" href="<?php echo $url_path; ?>?tipus=1&varos=88&kerulet%5B%5D=11&kategoria=1&min_alapterulet=&max_alapterulet=&min_ar=&max_ar=">Budapest 11. <?php echo Lang::get('adatlap_kerulet'); ?></a></li>
                        <li><a class="author" href="<?php echo $url_path; ?>?tipus=1&varos=88&kerulet%5B%5D=21&kategoria=1&min_alapterulet=&max_alapterulet=&min_ar=&max_ar=">Budapest 21. <?php echo Lang::get('adatlap_kerulet'); ?></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-4 col-md-3">
                <div class="widget">
                    <span class="widget-title"><?php echo Lang::get('footer_regisztracio'); ?></span>
                    <p><?php echo Lang::get('footer_regisztracio_szoveg'); ?></p>
                    <div class="newsletter">
                        <!-- <a class="simple-btn sm-button filled red" href="<?php echo $this->request->get_uri('site_url'); ?>regisztracio"><?php echo Lang::get('footer_regisztracio_gomb'); ?></a> -->
                        <a class="simple-btn sm-button filled red" data-toggle="modal" data-target="#modal_register" href="#"><?php echo Lang::get('footer_regisztracio_gomb'); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="bottom-footer">
                <div class="col-sm-6">
                    <div class="copy">
                        <span>© <?php echo date('Y') . ' ' . $settings['ceg']; ?> – <?php echo Lang::get('footer_jog'); ?> | <a href="http://www.onlinemarketingguru.hu/weboldal-keszites.html"><?php echo Lang::get('footer_weboldal_keszites'); ?></a>
                        </span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="policies">
                        <span><a href="/uploads/files/adatvedelemi-szabalyzat.pdf"><?php echo Lang::get('footer_adatvedelem'); ?></a> | <a href="/uploads/files/penzkezelesi-szabalyzat.pdf"><?php echo Lang::get('footer_penzkezeles'); ?></a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>