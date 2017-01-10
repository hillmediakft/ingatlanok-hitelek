<?php 
use System\Libs\Config;
use System\Libs\Language as Lang; 
?>
<div class="extra-header">
    <div class="container">
        <div class="left-part">
            <div class="extra-item sociable">
                <ul class="sociable-listing">
                    <?php if($settings['facebook']) { ?>
                    <li class="sociable-item">
                        <a href="<?php echo $settings['facebook']; ?>" class="social-icon"><i class="fa fa-facebook"></i></a>
                    </li>
                    <?php } ?>
                    <?php if($settings['linkedin']) { ?>
                    <li class="sociable-item">
                        <a href="<?php echo $settings['linkedin']; ?>" class="social-icon"><i class="fa fa-linkedin"></i></a>
                    </li>
                    <?php } ?>
                     <?php if($settings['twitter']) { ?>
                    <li class="sociable-item">
                        <a href="<?php echo $settings['twitter']; ?>" class="social-icon"><i class="fa fa-twitter"></i></a>
                    </li>
                    <?php } ?>
                     <?php if($settings['googleplus']) { ?>
                    <li class="sociable-item">
                        <a href="<?php echo $settings['googleplus']; ?>" class="social-icon"><i class="fa fa-google-plus"></i></a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="right-part">
            <div class="extra-item login">
                <span class="event-entry"><a href="#"><i class="fa fa-heart"></i><?php echo Lang::get('header_top_kedvencek'); ?></a></span>
            </div>
            <div class="extra-item event">
                <div class="country-select">

                    <?php if ($this->request->get_uri('langcode') == "en") { ?>
                        <a href="/"><img alt="" class="flag" src="<?php echo SITE_IMAGE; ?>flag_hu.jpg"> Magyar</a>
                    <?php } ?>
                    <?php if ($this->request->get_uri('langcode') == "hu") { ?>
                        <a href="/en"><img alt="" class="flag" src="<?php echo SITE_IMAGE; ?>flag_en.jpg">English</a>
                    <?php } ?>

                </div>
            </div>

            <div class="extra-item login">
                <a href="#"><i class="fa fa-user"></i><?php echo Lang::get('header_top_bejelentkezes'); ?></a>
            </div>
        </div>
    </div>
</div>
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="logo">
                    <a href="<?php echo $this->request->get_uri('site_url');?>"><img src="<?php echo SITE_IMAGE; ?>logo.png" alt=""></a>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="contact">
                    <div class="icon">
                        <i class="fa fa-phone"></i>
                    </div>
                    <div class="descr">
                        <span class="box-title"><?php echo Lang::get('header_telefon'); ?>:</span>
                        <span class="box-text"><?php echo $settings['tel']; ?></span>
                        <span class="box-text"><?php echo $settings['mobil']; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="contact">
                    <div class="icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="descr">
                        <span class="box-title">E-mail:</span>
                        <a href="#" class="box-text"><?php echo $settings['email']; ?></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="contact">
                    <div class="icon">
                        <i class="fa fa-map-marker"></i>
                    </div>
                    <div class="descr">
                        <span class="box-title"><?php echo Lang::get('header_irodank'); ?>:</span>
                        <span class="box-text"><?php echo $settings['cim']; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="nav-block">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <nav class="main-navigation">
                    <ul class="navigation-listing hidden-xs">
                        <li class="navigation-item">
                            <a href=""><i class="fa fa-home"></i></a>
                            <div class="overlay"></div>
                        </li>
                        <li class="navigation-item">
                            <a href="javascript:void(0)"><?php echo Lang::get('menu_ingatlanok'); ?></a>
                            <div class="overlay"></div>
                        </li>
                        <li class="navigation-item">
                            <a href="javascript:void(0)"><?php echo Lang::get('menu_magunkrol'); ?></a>
                            <div class="overlay"></div>
                            <ul class="subnav">
                                <li class="subnav-item">
                                    <a href="<?php echo Config::get('url.rolunk.' . LANG);?>"><?php echo Lang::get('menu_rolunk'); ?></a>
                                    <div class="overlay"></div>
                                </li>
                                <li class="subnav-item">
                                    <a href="<?php echo Config::get('url.ingatlan-ertekesitoink.' . LANG);?>"><?php echo Lang::get('menu_ertekesitoink'); ?></a>
                                    <div class="overlay"></div>
                                </li>

                            </ul>
                        </li>
                        <li class="navigation-item">
                            <a href="kapcsolat"><?php echo Lang::get('menu_kapcsolat'); ?></a>
                            <div class="overlay"></div>
                        </li>
                        <li class="navigation-item">
                            <a href="hitel"><?php echo Lang::get('menu_hitel'); ?></a>
                            <div class="overlay"></div>
                        </li>
                        <li class="navigation-item">
                            <a href="allas"><?php echo Lang::get('menu_allas'); ?></a>
                            <div class="overlay"></div>
                        </li>
                        <li class="navigation-item">
                            <a href="hirek"><?php echo Lang::get('menu_hirek'); ?></a>
                            <div class="overlay"></div>
                        </li>                        


                    </ul>
                    <button class="mobile_menu_btn toggle-nav visible-xs">
                        <span class="sandwich">
                            <span class="sw-topper"></span>
                            <span class="sw-bottom"></span>
                            <span class="sw-footer"></span>
                        </span>
                    </button>
                </nav>
                <a href="kereses" class="submit-nav hidden-xs"><i class="fa fa-search"></i> <?php echo Lang::get('menu_kereses'); ?></a>
            </div>
        </div>
    </div>
</div>
<div class="mobile-block">

</div>