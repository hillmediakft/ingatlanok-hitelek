<?php 
use System\Libs\Config;
use System\Libs\Language as Lang;
?>
<div id="content" class="container-fluid">

        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="breadcrumbs">
                        <span class="clickable"><a href="index.html">Home</a></span>
                        <span class="delimiter">/</span>
                        <span class="clickable"><a href="index.html">Ingatlanok</a></span>
                        <span class="delimiter">/</span>
                        <span class="active-page">Adatlap</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-9 col-sm-12">

                    <div class="single-item-page">
                        
                        <!-- PHOTO SLIDER -->
                        <div class="row">
                            <div class="col-sm-12">
                                
                                <h3 class="section-title">Retail Space In West Side <span class="price">USD <span class="value">999,000</span></span></h3>
                                <div class="item-photos">
                                    <div id="slideshow-main" class="main-slides">
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
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="small-section-title"><?php echo $ingatlan['ingatlan_nev_'. LANG]; ?></h4>
                                <p>
                                    <?php echo $ingatlan['leiras_' . LANG]; ?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="small-section-title">Detail Information</h4>
                                <div class="detail-info-block">
                                    <div class="column-3">
                                        <div class="info-item">
                                            <span class="label-item">Azonosító:</span>
                                            <span class="value"><?php echo $ingatlan['id']; ?></span>
                                        </div>
                                        <div class="info-item">
                                            <span class="label-item">Alapterület:</span>
                                            <span class="value"><?php echo $ingatlan['alapterulet']; ?></span>
                                        </div>
                                        <div class="info-item">
                                            <span class="label-item">Szobák:</span>
                                            <span class="value"><?php echo $ingatlan['szobaszam']; ?></span>
                                        </div>
                                    </div>
                                    <div class="column-3">
                                        <div class="info-item">
                                            <span class="label-item">Típus:</span>
                                            <span class="value"><?php echo ($ingatlan['tipus'] = 1) ? 'Eladó' : 'Kiadó'; ?></span>
                                        </div>
                                        <div class="info-item">
                                            <span class="label-item">Kategória:</span>
                                            <span class="value"><?php echo $ingatlan['kat_nev_' . LANG]; ?></span>
                                        </div>
                                        <div class="info-item">
                                            <span class="label-item">Állapot:</span>
                                            <span class="value"><?php echo $ingatlan['all_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>
                                    <div class="column-3">
                                        <div class="info-item">
                                            <span class="label-item">Parkolás:</span>
                                            <span class="value"><?php echo $ingatlan['parkolas_leiras_' . LANG]; ?></span>
                                        </div>
                                        <div class="info-item">
                                            <span class="label-item">Fűtés:</span>
                                            <span class="value"><?php echo $ingatlan['energetika_leiras_' . LANG]; ?></span>
                                        </div>
                                        <div class="info-item">
                                            <span class="label-item">Szerkezet:</span>
                                            <span class="value"><?php echo $ingatlan['szerkezet_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>
                                    <div class="column-3">
                                        <div class="info-item">
                                            <span class="label-item">Roofing:</span>
                                            <span class="value">New</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="label-item">Structure type:</span>
                                            <span class="value">Wood</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="label-item">Basement:</span>
                                            <span class="value">1</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="small-section-title">Features</h4>
                                <div class="features-info-block">
                                    <div class="column-3">
                                        <div class="info-item">
                                            <span class="feature-item">Ocean view</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="feature-item">GYM</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="feature-item">Front yard</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="feature-item">Roof Deck</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="feature-item">Sprinklers</span>
                                        </div>
                                    </div>
                                    <div class="column-3">
                                        <div class="info-item">
                                            <span class="feature-item">Attic</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="feature-item">Basketball court</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="feature-item">Fireplace</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="feature-item">Concierge</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="feature-item">Recreation</span>
                                        </div>
                                    </div>
                                    <div class="column-3">
                                        <div class="info-item">
                                            <span class="feature-item">Private space</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="feature-item">Washer and dryer</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="feature-item">Wine cellar</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="feature-item">Big pool</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="feature-item">Panoramic balconies</span>
                                        </div>
                                    </div>
                                    <div class="column-3">
                                        <div class="info-item">
                                            <span class="feature-item">Ocean view</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="feature-item">GYM</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="feature-item">Front yard</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="feature-item">Roof Deck</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="feature-item">Sprinklers</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="small-section-title">Contact Information</h4>
                            </div>
                            <div class="col-sm-8">
                                <div class="map-container style-2">
                                    <div id="map-banner-canvas" class="map-banner">
                                        <script>
                                            var locations = [
                                                ['New York: Manhattan',40.728407, -74.010174,'images/markers/banner-map/1.6.png']
                                            ];
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="main-contact-info-block">
                                    <ul class="contact-info-listing">
                                        <li>
                                            <span class="item-label">Address:</span>
                                            <span class="item-value">Some Best Place</span>
                                        </li>
                                        <li>
                                            <span class="item-label">City:</span>
                                            <span class="item-value">Brooklyn</span>
                                        </li>
                                        <li>
                                            <span class="item-label">State:</span>
                                            <span class="item-value">New York</span>
                                        </li>
                                        <li>
                                            <span class="item-label">Zip:</span>
                                            <span class="item-value">9000</span>
                                        </li>
                                        <li>
                                            <span class="item-label">Area:</span>
                                            <span class="item-value">1000 Sq Ft</span>
                                        </li>
                                        <li>
                                            <span class="item-label">Country:</span>
                                            <span class="item-value">USA</span>
                                        </li>
                                        <li>
                                            <span class="item-label">Phone:</span>
                                            <span class="item-value">123-456-7890</span>
                                        </li>
                                        <li>
                                            <span class="item-label">Email:</span>
                                            <span class="item-value">info@yourwebsite.com</span>
                                        </li>
                                        <li>
                                            <span class="item-label">Fax:</span>
                                            <span class="item-value">123-456-7899</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
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