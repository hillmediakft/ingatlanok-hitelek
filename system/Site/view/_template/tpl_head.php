<?php 
use System\Libs\Config;
use System\Libs\Auth;
use System\Libs\Cookie;
use System\Libs\Language as Lang;

// ellenőrizzük, hogy be van-e jelentkezve a felhasználó (true vagy false)
$logged_in = Auth::check(false);

// login, register, forgottenpw modal
include($this->path('tpl_login_modal'));
include($this->path('tpl_register_modal'));
include($this->path('tpl_forgottenpw_modal'));
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
                <span class="event-entry">
                    <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.kedvencek.index.' . LANG); ?>" id="kedvencek"><i class="fa fa-heart"></i><?php echo Lang::get('header_top_kedvencek'); ?>
                    <?php echo '<span class="badge badge-danger">' . count(json_decode(Cookie::get('kedvencek'))) . '</span>';?>
                    </a>
                </span>
            </div>
            <div class="extra-item event">
                <div class="country-select">

                    <?php if ($this->request->get_uri('langcode') == "en") { ?>
                        <a href="/"><img alt="" class="flag" src="<?php echo SITE_IMAGE; ?>flag_hu.jpg"> Magyar</a>
                    <?php } ?>
                    <?php if ($this->request->get_uri('langcode') == "hu") { ?>
                        <a href="/en"><img alt="" class="flag" src="<?php echo SITE_IMAGE; ?>flag_en.jpg"> English</a>
                    <?php } ?>

                </div>
            </div>


            <?php if ($logged_in === true) { ?>
            <div class="extra-item login">
                <span style="color: #ffffff;"><?php echo Auth::getUser('name'); ?>&nbsp; &raquo; &nbsp;</span><a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.user.logout.' . LANG); ?>"><?php echo Lang::get('header_top_kijelentkezes'); ?></a>
            </div>
            <?php } else { ?>
            <div class="extra-item login">
                <a data-toggle="modal" data-target="#modal_login" href="#"><i class="fa fa-user"></i><?php echo Lang::get('header_top_bejelentkezes'); ?></a>
            </div>        
            <?php } ?>
            
            <?php if (!isset($logged_in) || $logged_in === false) { ?>
            <div class="extra-item login">
                <a data-toggle="modal" data-target="#modal_register" href="#"><?php echo Lang::get('footer_regisztracio'); ?></a>
            </div>
            <?php } ?>







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
                            <a href="<?php echo $this->request->get_uri('site_url');?>"><i class="fa fa-home"></i></a>
                            <div class="overlay"></div>
                        </li>
                        <li class="navigation-item">
                            <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.ingatlanok.index.' . LANG);?>"><?php echo Lang::get('menu_ingatlanok'); ?></a>
                            <div class="overlay"></div>
                        </li>
                        <li class="navigation-item">
                            <a href="javascript:void(0)"><?php echo Lang::get('menu_magunkrol'); ?></a>
                            <div class="overlay"></div>
                            <ul class="subnav">
                                <li class="subnav-item">
                                    <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.rolunk.index.' . LANG);?>"><?php echo Lang::get('menu_rolunk'); ?></a>
                                    <div class="overlay"></div>
                                </li>
                                <li class="subnav-item">
                                    <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.ingatlan-ertekesitoink.index.' . LANG);?>"><?php echo Lang::get('menu_ertekesitoink'); ?></a>
                                    <div class="overlay"></div>
                                </li>

                            </ul>
                        </li>
                        <li class="navigation-item">
                            <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.kapcsolat.index.' . LANG);?>"><?php echo Lang::get('menu_kapcsolat'); ?></a>
                            <div class="overlay"></div>
                        </li>
                        <li class="navigation-item">
                            <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.hitel.index.' . LANG);?>"><?php echo Lang::get('menu_hitel'); ?></a>
                            <div class="overlay"></div>
                        </li>
                        <li class="navigation-item">
                            <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.allas.index.' . LANG);?>"><?php echo Lang::get('menu_allas'); ?></a>
                            <div class="overlay"></div>
                        </li>
                        <li class="navigation-item">
                            <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.hirek.index.' . LANG);?>"><?php echo Lang::get('menu_hirek'); ?></a>
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
                <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.kereses.index.' . LANG);?>" class="submit-nav hidden-xs"><i class="fa fa-search"></i> <?php echo Lang::get('menu_kereses'); ?></a>
            </div>
        </div>
    </div>
</div>
<div class="mobile-block">

</div>