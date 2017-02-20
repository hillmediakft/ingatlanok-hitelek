<?php

use System\Libs\Config;
use System\Libs\Language as Lang;
?>
<div id="content" class="container-fluid">

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumbs">
                    <span class="clickable"><a href="<?php echo $this->request->get_uri('site_url'); ?>"><?php echo Lang::get('menu_home'); ?></a></span>
                    <span class="delimiter">/</span>
                    <span class="clickable"><a href="<?php echo Config::get('url.ingatlanok.' . LANG); ?>"><?php echo Lang::get('menu_ingatlanok'); ?></a></span>
                    <span class="delimiter">/</span>
                    <span class="active-page">Adatlap</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Szürke doboz felül -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="ingatlan-info-box">
                    doboz
                </div>
            </div>
        </div>
    </div>

    <aside class="sidebar main-sidebar">
        <div class="container">
            <div class="row">
                <div class="single-item-page">
                    <div class="col-md-8">
                        <?php if (!empty($pictures)) { ?>
                            <!-- PHOTO SLIDER -->
                            <div class="row">
                                <div class="col-sm-12">

                        <!-- <h3 class="section-title">Retail Space In West Side <span class="price">USD <span class="value">999,000</span></span></h3> -->
                                    <div class="item-photos">
                                        <div id="slideshow-main" class="main-slides">

                                            <!-- eladó/kiadó cimke-->                                        
                                            <?php
                                            if ($ingatlan['tipus'] == 1) {
                                                $label = Lang::get('kereso_elado');
                                                $css_class = 'sale';
                                            } else {
                                                $label = Lang::get('kereso_kiado');
                                                $css_class = 'rest';
                                            }
                                            ?>
                                            <span class="item-label <?php echo $css_class; ?>"><?php echo $label; ?></span>

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

                    </div>
                    <div class="col-md-4">      
                        <div class="row">
                            <a class="simple-btn sm-button filled red" href="#"><i class="fa fa-envelope"></i> Értesítés árváltozásról</a>
                            <a class="simple-btn sm-button filled red" href="#"><i class="fa fa-heart"></i> Kedvencekhez</a>
                        </div>
                        <div class="row">
                            <a class="simple-btn sm-button filled red" href="#"><i class="fa fa-share"></i> Megosztás</a>
                            <a class="simple-btn sm-button filled red" href="#"><i class="fa fa-print"></i> Nyomtatás</a>
                        </div>
                        <div class="row">
                            <div class="widget questions">
                                <div class="heading">
                                    <span class="widget-title">Kapcsolatfelvétel</span>
                                </div>
                                <div class="widget-entry gray-bg">
                                    <div class="questions-form">
                                        <form action="#">
                                            <input type="text" class="name" placeholder="név">
                                            <input type="email" class="email" placeholder="Email">
                                            <input type="text" class="email" placeholder="Telefonszám">
                                            <textarea class="message" placeholder="Üzenet"></textarea>
                                            <button class="send-btn">Küldés</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>


<div class="container">
    <div class="row">
        <div class="col-md-9 col-sm-12">

            <div class="single-item-page">
                <!-- DETAIL INFO -->
                <div class="row">
                    <div class="col-sm-12">
                        <!-- <h4 class="small-section-title">Detail Information</h4> -->
                        <div class="detail-info-block">
                            <div class="column-2">
                                <div class="info-item">
                                    <span class="label-item">Azonosító:</span>
                                    <span class="value"><?php echo $ingatlan['ref_num']; ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="label-item">Típus:</span>
                                    <span class="value"><?php echo ($ingatlan['tipus'] = 1) ? 'Eladó' : 'Kiadó'; ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="label-item">Kategória:</span>
                                    <span class="value"><?php echo $ingatlan['kat_nev_' . LANG]; ?></span>
                                </div>
                            </div>
                            <div class="column-2">
                                <div class="info-item">
                                    <span class="label-item">Alapterület:</span>
                                    <span class="value"><?php echo $ingatlan['alapterulet']; ?> m<sup>2</sup></span>
                                </div>
                                <div class="info-item">
                                    <span class="label-item">Szerkezet:</span>
                                    <span class="value"><?php echo $ingatlan['szerkezet_leiras_' . LANG]; ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="label-item">Állapot:</span>
                                    <span class="value"><?php echo $ingatlan['all_leiras_' . LANG]; ?></span>
                                </div>
                            </div>
                            <div class="column-2">
                                <div class="info-item">
                                    <span class="label-item">Szobák:</span>
                                    <span class="value"><?php echo $ingatlan['szobaszam']; ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="label-item">Parkolás:</span>
                                    <span class="value"><?php echo $ingatlan['parkolas_leiras_' . LANG]; ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="label-item">Fűtés:</span>
                                    <span class="value"><?php echo $ingatlan['futes_leiras_' . LANG]; ?></span>
                                </div>
                            </div>
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
                        <h4 class="small-section-title">Leírás</h4>
                        <p>
                            <?php echo $ingatlan['leiras_' . LANG]; ?>
                        </p>
                    </div>
                </div>

                <?php if ($ingatlan['terkep'] == 1) { ?>
                    <!-- TÉRKÉP -->
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="small-section-title">Elhelyezkedés</h4>
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

                <div class="row">
                    <div class="col-sm-12">
                        <div class="empty-space-25"></div>
                    </div>
                </div>

                <!-- HASONLÓ INGATLANOK -->
                <?php
                foreach ($hasonlo_ingatlan as $value) {
                    $photo_array = json_decode($value['kepek']);
                    ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="object-slider latest-properties style-2">
                                <div class="heading">
                                    <h4 class="small-section-title">Similar Properties</h4>
                                    <div class="jcarousel-arrows">
                                        <a href="#" class="prev-slide"><i class="fa fa-angle-left"></i></a>
                                        <a href="#" class="next-slide"><i class="fa fa-angle-right"></i></a>
                                    </div>
                                </div>
                                <div class="obj-carousel carousel">
                                    <ul>
                                        <li>
                                            <div class="item">
                                                <div class="preview">
                                                    <?php if ($value['kepek']) { ?>
                                                        <img src="<?php echo $this->url_helper->thumbPath(Config::get('ingatlan_photo.upload_path') . $photo_array[0], false, 'small'); ?>" alt="<?php echo $value['ingatlan_nev_' . LANG]; ?>">
                                                    <?php } ?>
                                                    <?php if ($value['kepek'] == null) { ?>
                                                        <img src="<?php echo Config::get('ingatlan_photo.upload_path') . 'placeholder.jpg'; ?>" alt="<?php echo $value['ingatlan_nev_' . LANG]; ?>">
                                                    <?php } ?>
                                                    <span class="like">
                                                        <i class="fa fa-heart"></i>
                                                    </span>
                                                    <span class="price-box">
                                                        <?php echo ($value['tipus'] == 1) ? number_format($value['ar_elado'], 0, ',', '.') : number_format($value['ar_kiado'], 0, ',', '.') ?> Ft
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
                                                    <span class="item-title"><a href="ingatlanok/adatlap/<?php echo $value['id'] . '/' . $this->str_helper->stringToSlug($value['ingatlan_nev_' . LANG]); ?>"><?php echo $value['ingatlan_nev_' . LANG]; ?></a></span>
                                                    <p><?php
                                                        echo $value['city_name'];
                                                        echo (isset($value['kerulet'])) ? ', ' . $value['kerulet'] . ' kerület' : '';
                                                        ?></p>

                                                    <div class="item-info">
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>  
                        </div>
                    </div>
                <?php } ?>

            </div> <!-- single-item-page END -->
        </div>



        <!-- SIDEBAR -->
        <div class="col-sm-12 col-md-3">
            <aside class="sidebar main-sidebar">

                <?php include($this->path('tpl_modul_banner')); ?>

            </aside>
        </div>

    </div>
</div> <!-- container vege -->
</div>