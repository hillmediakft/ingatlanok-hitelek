<?php

use System\Libs\Language as Lang; ?>
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
                                <a href="#"><?php echo $settings['email']; ?></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="hidden-sm col-md-3">
                <div class="widget latest-tweets">
                    <span class="widget-title"><?php echo Lang::get('footer_ingatlanok'); ?></span>
                    <ul class="property-listing">
                        <li><a class="author" href="#">Budapest 3. kerület</a></li>
                        <li><a class="author" href="#">Budapest 10. kerület</a></li>
                        <li><a class="author" href="#">Budapest 5. kerület</a></li>
                        <li><a class="author" href="#">Budapest eladó lakás</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-4 col-md-3">
                <div class="widget">
                    <span class="widget-title"><?php echo Lang::get('footer_regisztracio'); ?></span>
                    <p><?php echo Lang::get('footer_regisztracio_szoveg'); ?></p>
                    <div class="newsletter">
                        <a class="simple-btn sm-button filled red" href="<?php echo $this->request->get_uri('site_url');?>regisztracio"><?php echo Lang::get('footer_regisztracio_gomb'); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="bottom-footer">
                    <span class="copy">© <?php echo date('Y') . ' ' . $settings['ceg']; ?> – <?php echo Lang::get('footer_jog'); ?> | <a href="http://www.onlinemarketingguru.hu/weboldal-keszites.html"><?php echo Lang::get('footer_weboldal_keszites'); ?></a></span>
                </div>
            </div>
        </div>
    </div>
</footer>