<?php

use System\Libs\Config;
use System\Libs\Cookie;
use System\Libs\Language as Lang;
?>
<div id="content" class="container-fluid">

    <!-- BREADCRUMBS -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumbs">
                    <span class="clickable"><a href="<?php echo $this->request->get_uri('site_url'); ?>"><?php echo Lang::get('menu_home'); ?></a></span>
                    <span class="delimiter">/</span>
                    <span class="clickable"><a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.ingatlanok.' . LANG); ?>"><?php echo Lang::get('menu_ingatlanok'); ?></a></span>
                    <span class="delimiter">/</span>
                    <span class="active-page"><?php echo Lang::get('adatlap_kenyermorzsa'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Szürke doboz felül ingatlan-info-box -->
    <div id="sticker">
        <div class="container">
            <div class="row">

                <div class="col-sm-12">

                    <div class="ingatlan-info-box" id="sticker">

                        <div class="col-sm-5 col-xs-5">
                            <h3 class="section-title"><?php echo $ingatlan['ingatlan_nev_' . LANG]; ?></h3>
                            <?php
                            $district = (!is_null($ingatlan['district_name'])) ? $ingatlan['district_name'] . ' ' . Lang::get('adatlap_kerulet') : '';
                            ?>
                            <h5><?php echo $ingatlan['city_name'] . ' ' . $district; ?></h5> 
                        </div>

                        <div class="col-sm-3 col-xs-3">
                            <h3 class="section-title">
                                <span class="price">
                                    <span class="value">
                                        <!-- ÁR MEGJELENÍTÉSE -->
                                        <?php $this->html_helper->showPrice($ingatlan); ?>
                                    </span>
                                </span>
                            </h3>
                            <div class="icon-box">
                                <div class="heading">
                                    <div class="icon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <span class="title"><?php echo $ingatlan['kat_nev_' . LANG]; ?></span>
                                </div>
                            </div>
                            <div class="icon-box">
                                <div class="heading">
                                    <div class="icon">
                                        <i class="fa fa-map-o"></i>
                                    </div>
                                    <span class="title"><?php echo $ingatlan['alapterulet']; ?> m<sup>2</sup></span>
                                </div>
                            </div>
                        </div> 

                        <div class="col-sm-4 col-xs-4">
                            <div class="agent-box">
                                <div class="agent-image">
                                    <img class="img-thumbnail" src="<?php echo Config::get('user.upload_path') . $agent['photo']; ?>">
                                </div>

                                <div class="agent-details">
                                    <div class="agent-name">
                                        <h6><?php echo $agent['first_name'] . ' ' . $agent['last_name']; ?></h6>
                                        <div><?php echo $agent['title_' . LANG]; ?></div>
                                    </div>
                                    <div>Tel: <?php echo $agent['phone']; ?></div>
                                    <div class="label label-danger"><?php echo Lang::get('adatlap_hivjon_most_cimke'); ?></div>
                                </div>
                            </div>   
                        </div>

                    </div> <!-- END ingatlan-info-box -->

                </div> <!-- END col-sm-12 -->

            </div> <!-- END ROW -->
        </div> <!-- END CONTAINER -->
    </div>


    <div class="container">
        <div class="row">

            <!-- TARTALOM -->
            <div class="col-sm-12 col-md-8">
                <div class="single-item-page">


                    <!-- GOMBOK -->
                    <div class="row">
                        <div class="col-sm-12">
                            <a id="arvaltozas_ertesites" class="simple-btn sm-button outlined red <?php echo ($ertesites_arvaltozasrol) ? 'disabled' : ''; ?>" data-id="<?php echo $ingatlan['id']; ?>" href="javascript:void(0);"><i class="fa fa-envelope"></i> <?php echo Lang::get('adatlap_arvaltozas_gomb'); ?></a>
                            <a id="kedvencekhez_<?php echo $ingatlan['id']; ?>" data-id="<?php echo $ingatlan['id']; ?>" class="simple-btn sm-button outlined red <?php echo (Cookie::is_id_in_cookie('kedvencek', $ingatlan['id'])) ? 'disabled' : ''; ?>" href="javascript:void(0);"><i class="fa fa-heart"></i> <?php echo Lang::get('adatlap_kedvencekhez_gomb'); ?></a>
                            <form style="display: inline;" id="adatlap_nyomtatas_form" method="POST" action="adatlap/<?php echo $ingatlan['id']; ?>">
                                <a id="adatlap_nyomtatas" class="simple-btn sm-button outlined red"><i class="fa fa-print"></i> <?php echo Lang::get('adatlap_nyomtatas_gomb'); ?></a>
                                <!-- <button id="adatlap_nyomtatas" type="submit" class="send-btn"><i class="fa fa-print"></i> <?php echo Lang::get('adatlap_nyomtatas_gomb'); ?></button> -->
                            </form>
                            <a id="myPopover" data-toggle="popover" title="Social share" data-placement="bottom" data-content="<?php echo $this->html_helper->socialMediaShare($this->getConfig('ingatlan_photo.upload_path') . $pictures[0],  $ingatlan['ingatlan_nev_' . LANG]); ?>" class="simple-btn sm-button outlined red" href="javascript:void(0)"><i class="fa fa-share"></i> <?php echo Lang::get('adatlap_megosztas_gomb'); ?></a>
                        </div>
                    </div>
        

                    <?php if (!empty($pictures)) { ?>
                        <!-- PHOTO SLIDER -->
                        <div class="row">
                            <div class="col-sm-12">
                                                                <!-- <h3 class="section-title">Retail Space In West Side <span class="price">USD <span class="value">999,000</span></span></h3> -->
                                <div class="item-photos">

                                    <div id="slideshow-main" class="main-slides">
                                        <div id="kedvencek_<?php echo $ingatlan['id']; ?>" class="like <?php echo (Cookie::is_id_in_cookie('kedvencek', $ingatlan['id'])) ? 'active' : ''; ?>">
                                            <i class="fa fa-heart"></i>
                                        </div>

                                        <div class="jcarousel-arrows">
                                            <a href="#" class="prev-slide"><i class="fa fa-angle-left"></i></a>
                                            <a href="#" class="next-slide"><i class="fa fa-angle-right"></i></a>
                                        </div>
                                        <div class="slides-container" id="slides-to-show">
                                            <ul>
                                                <?php foreach ($pictures as $picture) { ?>
                                                    <li>
                                                        <img alt="<?php echo $ingatlan['ingatlan_nev_' . LANG]; ?>" src="<?php echo $this->getConfig('ingatlan_photo.upload_path') . $picture; ?>"/>
                                                    </li>
                                                <?php } ?>
                                            </ul>   
                                        </div>                                  
                                    </div>
                                    <div id="slideshow-carousel" class="main-thumbnail">
                                        <ul id="carousel" class="jcarousel jcarousel-skin-tango">
                                            <?php foreach ($pictures as $picture) { ?>
                                                <li>
                                                    <img alt="<?php echo $ingatlan['ingatlan_nev_' . LANG]; ?>" src="<?php echo $this->getConfig('ingatlan_photo.upload_path') . $picture; ?>"/>
                                                </li>
                                            <?php } ?>                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <!-- 
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="empty-space-25"></div>
                            </div>
                        </div>
                        -->
                    <?php } ?>

                    <!-- DETAIL INFO -->
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- <h4 class="small-section-title">Detail Information</h4> -->
                            <div class="detail-info-block">

                                <div class="column-2">
                                    <div class="info-item">
                                        <span class="label-item"><?php echo Lang::get('jell_azonosito'); ?>:</span>
                                        <span class="value"><?php echo $ingatlan['ref_num']; ?></span>
                                    </div>
                                </div>

                                <div class="column-2">
                                    <div class="info-item">
                                        <span class="label-item"><?php echo Lang::get('jell_tipus'); ?>:</span>
                                        <span class="value"><?php echo ($ingatlan['tipus'] == 1) ? Lang::get('jell_elado') : Lang::get('jell_kiado'); ?></span>
                                    </div>
                                </div>

                                <div class="column-2">
                                    <div class="info-item">
                                        <span class="label-item"><?php echo Lang::get('jell_kategoria'); ?>:</span>
                                        <span class="value"><?php echo $ingatlan['kat_nev_' . LANG]; ?></span>
                                    </div>
                                </div>

                                <div class="column-2">
                                    <div class="info-item">
                                        <span class="label-item"><?php echo Lang::get('jell_alapterulet'); ?>:</span>
                                        <span class="value"><?php echo $ingatlan['alapterulet']; ?> m<sup>2</sup></span>
                                    </div>
                                </div>

                                <?php if (!is_null($ingatlan['telek_alapterulet'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_telek_alapterulet'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['telek_alapterulet']; ?> m<sup>2</sup></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['belmagassag'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_belmagassag'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['belmagassag']; ?> cm</span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['tajolas'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_tajolas'); ?>:</span>
                                            <span class="value"><?php echo Config::get('orientation.' . LANG . '.' . $ingatlan['tajolas']); ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($ingatlan['erkely'] == 1 && !empty($ingatlan['erkely_terulet'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_erkely'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['erkely_terulet']; ?> m<sup>2</sup></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($ingatlan['terasz'] == 1 && !empty($ingatlan['terasz_terulet'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_terasz'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['terasz_terulet']; ?> m<sup>2</sup></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['szobaszam'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_szobaszam'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['szobaszam']; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['felszobaszam'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_felszobaszam'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['felszobaszam']; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>


                                <?php if (!is_null($ingatlan['kozos_koltseg'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_kozos_koltseg'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['kozos_koltseg']; ?> Ft</span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['rezsi'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_rezsi'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['rezsi']; ?> Ft</span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['szerkezet'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_szerkezet'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['szerkezet_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>                            

                                <?php if (!is_null($ingatlan['allapot'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_allapot'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['all_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>                            
                                <?php } ?>

                                <?php if (!is_null($ingatlan['futes'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_futes'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['futes_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>                                                        
                                <?php } ?>

                                <?php if (!is_null($ingatlan['energetika'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_energetika'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['energetika_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>                                                        
                                <?php } ?>

                                <?php if (!is_null($ingatlan['haz_allapot_belul'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_haz_allapot_belul'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['haz_allapot_belul_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>                                                        
                                <?php } ?>

                                <?php if (!is_null($ingatlan['haz_allapot_kivul'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_haz_allapot_kivul'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['haz_allapot_kivul_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>                                                        
                                <?php } ?>

                                <?php if (!is_null($ingatlan['parkolas'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_parkolas'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['parkolas_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['furdo_wc'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_furdo_wc'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['furdo_wc_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['fenyviszony'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_fenyviszony'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['fenyviszony_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['kilatas'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_kilatas'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['kilatas_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['kert'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_kert'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['kert_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['szoba_elrendezes'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_szoba_elrendezes'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['szoba_elrendezes_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($ingatlan['lift'] == 1) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_lift'); ?>:</span>
                                            <span class="value"><?php echo Lang::get('jell_van'); ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($ingatlan['tetoter'] == 1) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_tetoter'); ?>:</span>
                                            <span class="value"><?php echo Lang::get('jell_van'); ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>

                    <!-- FEATURES -->
                    <?php if (!empty($features)) { ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- <h4 class="small-section-title">Features</h4> -->
                                <div class="features-info-block">
                                    <?php foreach ($features as $feature) { ?>
                                        <div class="column-2">
                                            <div class="info-item">
                                                <span class="feature-item"><?php echo Lang::get($feature); ?></span>
                                            </div>
                                        </div>
                                    <?php } ?>    
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <!-- LEÍRÁS -->
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="small-section-title"><?php echo Lang::get('adatlap_leiras_cim'); ?></h4>
                            <p>
                                <?php echo $ingatlan['leiras_' . LANG]; ?>
                            </p>
                        </div>
                    </div>

                    <?php if ($ingatlan['terkep'] == 1) { ?>
                        <!-- TÉRKÉP -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="small-section-title"><?php echo Lang::get('adatlap_terkep_cim'); ?></h4>
                            </div>
                            <div class="col-sm-12">
                                <div class="map-container style-2">
                                    <div id="map-banner-canvas" class="map-banner" data-lat="<?php echo $ingatlan['latitude']; ?>" data-lng="<?php echo $ingatlan['longitude']; ?>">
                                        <!-- A main.js file initBannerMap1() metodusa kezeli a térkép megjelenítését -->
                                        <script>
                                            var locations = [['', <?php echo $ingatlan['latitude']; ?>, <?php echo $ingatlan['longitude']; ?>, 'public/site_assets/images/markers/banner-map/1.6.png']];
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <!-- HASONLÓ INGATLANOK -->
                    <?php if (!empty($hasonlo_ingatlan)) { ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="object-slider latest-properties style-2">
                                    <div class="heading">
                                        <h4 class="small-section-title"><?php echo Lang::get('adatlap_hasonlo_ingatlan_cim'); ?></h4>
                                        <div class="jcarousel-arrows">
                                            <a href="#" class="prev-slide"><i class="fa fa-angle-left"></i></a>
                                            <a href="#" class="next-slide"><i class="fa fa-angle-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="obj-carousel carousel">
                                        <ul>
                                            <?php
                                            foreach ($hasonlo_ingatlan as $value) {
                                                $photo_array = json_decode($value['kepek']);
                                                ?>
                                                <li>
                                                    <div class="item">
                                                        <div class="preview">
                                                            <?php $this->html_helper->showLowerPriceIcon($value); ?>

                                                            <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.ingatlanok.adatlap.' . LANG) . '/' . $value['id'] . '/' . $this->str_helper->stringToSlug($value['ingatlan_nev_' . LANG]); ?>">
                                                                <?php if (!is_null($value['kepek'])) { ?>
                                                                    <img src="<?php echo $this->url_helper->thumbPath(Config::get('ingatlan_photo.upload_path') . $photo_array[0], false, 'small'); ?>" alt="<?php echo $value['ingatlan_nev_' . LANG]; ?>">
                                                                <?php } else { ?>
                                                                    <img src="<?php echo Config::get('ingatlan_photo.upload_path') . 'placeholder.jpg'; ?>" alt="<?php echo $value['ingatlan_nev_' . LANG]; ?>">
                                                                <?php } ?>
                                                            </a> 

                                                            <?php $this->html_helper->showHeartIcon($value); ?>

                                                            <span class="price-box">
                                                                <?php $this->html_helper->showPrice($value); ?>
                                                            </span>
                                                        </div>
                                                        <div class="item-thumbnail">
                                                            <div class="single-thumbnail">
                                                                <span class="value"><?php echo $value['kat_nev_' . LANG]; ?></span>
                                                            </div>
                                                            <div class="single-thumbnail">

                                                                <span class="value"><?php echo $value['szobaszam']; ?> szoba</span>
                                                            </div>
                                                            <div class="single-thumbnail">
                                                                <span class="value"><?php echo $value['alapterulet']; ?> m<sup>2</sup></span>
                                                            </div>
                                                        </div>
                                                        <div class="item-entry">
                                                            <span class="item-title"><a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.ingatlanok.adatlap.' . LANG) . '/' . $value['id'] . '/' . $this->str_helper->stringToSlug($value['ingatlan_nev_' . LANG]); ?>"><?php echo $value['ingatlan_nev_' . LANG]; ?></a></span>
                                                            <p><?php
                                                                echo $value['city_name'];
                                                                echo (isset($value['kerulet'])) ? ', ' . $value['kerulet'] . '. ' . Lang::get('adatlap_kerulet') : '';
                                                                ?></p>

                                                            <div class="item-info">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>  
                            </div>
                        </div>

                    <?php } ?>                        

                </div> <!-- single-item-page END -->
            </div>

            <!-- SIDEBAR -->
            <div class="col-sm-12 col-md-4">
                <aside class="sidebar main-sidebar" style="padding-top: 0;">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="widget questions">
                                <div class="heading">
                                    <span class="widget-title"><?php echo Lang::get('adatlap_kapcsolat_cim'); ?></span>
                                </div>
                                <div class="widget-entry gray-bg">
                                    <div class="questions-form">
                                        <form action="<?php echo (LANG != 'hu') ? LANG . '/' : ''; ?>sendemail/init/agent" method="post" id="contact-form-agent">
                                            <input type="text" class="name" name="name" placeholder="<?php echo Lang::get('kapcsolat_email_nev'); ?>" required oninvalid="this.setCustomValidity('Töltse ki ezt a mezőt!')" oninput="setCustomValidity('')">
                                            <input type="email" class="email" name="email" placeholder="Email" required oninvalid="this.setCustomValidity('Adjon meg egy email címet!')" oninput="setCustomValidity('')">
                                            <input type="text" class="name" name="phone" placeholder="<?php echo Lang::get('kapcsolat_email_telefon'); ?>">
                                            <textarea class="message" name="message" placeholder="<?php echo Lang::get('kapcsolat_email_uzenet'); ?>" required oninvalid="this.setCustomValidity('Töltse ki ezt a mezőt!')" oninput="setCustomValidity('')"></textarea>

                                            <input type="text" name="mezes_bodon" id="mezes_bodon">

                                            <input type="hidden" name="agent_name" value="<?php echo $agent['first_name'] . ' ' . $agent['last_name']; ?>">
                                            <input type="hidden" name="agent_email" value="<?php echo $agent['email']; ?>">
                                            <input type="hidden" name="ref_num" value="<?php echo $ingatlan['ref_num']; ?>">
                                            <input type="hidden" name="url" value="<?php echo $this->request->get_uri('current_url'); ?>">

                                            <button type="submit" class="send-btn" id="submit-button"><?php echo Lang::get('kapcsolat_email_kuldes'); ?></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php //include($this->path('tpl_modul_banner')); ?>
                    <?php include($this->path('tpl_modul_banner_mennyiterazingatlanom')); ?>
                    <?php include($this->path('tpl_modul_banner_befektetoknek')); ?>
                    <?php include($this->path('tpl_modul_banner_berbeadoknak')); ?>

                </aside>
            </div>

        </div>
    </div> <!-- END CONTAINER -->

</div> <!-- Fluid container END -->