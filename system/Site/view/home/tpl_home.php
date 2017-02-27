<?php

use System\Libs\Config;
use System\Libs\Language as Lang;
?>
<div class="home-banner style-2">
    <div class="container">

        <div class="banner-content">

            <!-- KERESÉS FORM -->
            <div class="main-filter hidden-xs">
                <?php include($this->path('tpl_home_filter')); ?>
            </div>


        </div> <!-- banner content END -->

    </div>
</div>


<div id="content" class="container-fluid">


    <div class="row">
        <div class="our-features-banner gray-bg light">
            <div class="container">
                <h2 class="block-title"><?php echo Lang::get('home_szolgaltatasok_cim'); ?></h2>
                <span class="sub-title"><?php echo Lang::get('home_szolgaltatasok_szoveg'); ?></span>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="single-feature">
                            <div class="icon-container">
                                <div class="icon-border">
                                    <a href="#">
                                        <img src="<?php echo SITE_IMAGE; ?>mennyit-er-az-ingatlanom.png">
                                    </a>	
                                </div>
                            </div>
                            <span class="main-title"><?php echo Lang::get('home_szolgaltatasok_1_cim'); ?></span>
                            <span class="featured-sub-title colored"><?php echo Lang::get('home_szolgaltatasok_1_szoveg'); ?></span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="single-feature">
                            <div class="icon-container">
                                <div class="icon-border">
                                    <a href="#">
                                        <img src="<?php echo SITE_IMAGE; ?>befektetoknek.png">
                                    </a>	
                                </div>
                            </div>
                            <span class="main-title"><?php echo Lang::get('home_szolgaltatasok_2_cim'); ?></span>
                            <span class="featured-sub-title colored"><?php echo Lang::get('home_szolgaltatasok_2_szoveg'); ?></span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="single-feature">
                            <div class="icon-container">
                                <div class="icon-border">
                                    <a href="#">
                                        <img src="<?php echo SITE_IMAGE; ?>berbeadoknak.png">
                                    </a>	
                                </div>
                            </div>
                            <span class="main-title"><?php echo Lang::get('home_szolgaltatasok_3_cim'); ?></span>
                            <span class="featured-sub-title colored"><?php echo Lang::get('home_szolgaltatasok_3_szoveg'); ?></span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="single-feature">
                            <div class="icon-container">
                                <div class="icon-border">
                                    <a href="#">
                                        <img src="<?php echo SITE_IMAGE; ?>mennyit-er-az-ingatlanom.png">
                                    </a>
                                </div>
                            </div>
                            <span class="main-title"><?php echo Lang::get('home_szolgaltatasok_4_cim'); ?></span>
                            <span class="featured-sub-title colored"><?php echo Lang::get('home_szolgaltatasok_4_szoveg'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>	



    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="block-title"><?php echo Lang::get('home_kiemelt_ingatlanok'); ?></h2>
                <div class="object-slider latest-properties">
                    <div class="jcarousel-arrows">
                        <a href="#" class="prev-slide"><i class="fa fa-angle-left"></i></a>
                        <span class="text"><?php echo Lang::get('home_osszes_ingatlan'); ?></span>
                        <a href="#" class="next-slide"><i class="fa fa-angle-right"></i></a>
                    </div>
                    <div class="obj-carousel carousel">
                        <ul>
                            <?php
                            foreach ($all_properties as $value) {
                                $photo_array = json_decode($value['kepek']);
                                ?>
                                <li>
                                    <div class="item">
                                        <div class="preview">
                                            <?php $this->html_helper->showLowerPriceIcon($value); ?>
                                            <!-- eladó/kiadó cimke-->                                        
                                            <?php
                                            if ($value['tipus'] == 1) {
                                                $label = Lang::get('kereso_elado');
                                                $css_class = 'sale';
                                            } else {
                                                $label = Lang::get('kereso_kiado');
                                                $css_class = 'rest';
                                            }
                                            ?>
                                            <span class="item-label <?php echo $css_class; ?>"><?php echo $label; ?></span>

                                            <?php if ($value['kepek']) { ?>
                                                <a href="ingatlanok/adatlap/<?php echo $value['id'] . '/' . $this->str_helper->stringToSlug($value['ingatlan_nev_' . LANG]); ?>">
                                                    <img src="<?php echo $this->url_helper->thumbPath(Config::get('ingatlan_photo.upload_path') . $photo_array[0], false, 'small'); ?>" alt="<?php echo $value['ingatlan_nev_' . LANG]; ?>">
                                                </a>
                                            <?php } ?>
                                            <?php if ($value['kepek'] == null) { ?>
                                                <a href="ingatlanok/adatlap/<?php echo $value['id'] . '/' . $this->str_helper->stringToSlug($value['ingatlan_nev_' . LANG]); ?>">
                                                    <img src="<?php echo Config::get('ingatlan_photo.upload_path') . 'placeholder.jpg'; ?>" alt="<?php echo $value['ingatlan_nev_' . LANG]; ?>">
                                                </a>
                                            <?php } ?>
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
                            <?php } ?>

                        </ul>
                    </div>
                    <p class="jcarousel-pagination"></p>
                </div>
            </div>
        </div>
    </div>





    <div class="row">
        <div class="our-agents gray-bg">
            <div class="container">
                <h2 class="block-title"><?php echo Lang::get('home_referensek'); ?></h2>
                <div class="best-agents">
                    <div class="jcarousel-arrows">
                        <a href="#" class="prev-slide"><i class="fa fa-angle-left"></i></a>

                        <a href="#" class="next-slide"><i class="fa fa-angle-right"></i></a>
                    </div>
                    <div class="ag-carousel carousel">
                        <ul>
                            <?php foreach ($agents as $agent) : ?>
                                <li>
                                    <div class="item">
                                        <div class="preview">
                                            <img src="<?php echo Config::get('user.upload_path') . $agent['photo']; ?>" alt="<?php echo $agent['last_name'] . $agent['first_name']; ?>">
                                            <div class="overlay">
                                                <a href="#"><i class="fa fa-search-plus"></i></a>
                                            </div>
                                        </div>
                                        <span class="name"><?php echo $agent['first_name'] . ' ' . $agent['last_name']; ?></span>
                                        <span class="properties"><a href="ingatlanok/ertekesito/<?php echo $this->str_helper->stringToSlug($agent['first_name']) . '-' . $this->str_helper->stringToSlug($agent['last_name']) . '/' . $agent['id']; ?>" class="simple-btn sm-button outlined red"><?php echo $agent['property']; ?> ingatlan</a></span>
                                        <ul class="contact-listing">
                                            <li>
                                                <span class="icon"><i class="fa fa-phone"></i></span>
                                                <span class="phone"><?php echo $agent['phone']; ?></span>
                                            </li>
                                            <li>
                                                <span class="icon"><i class="fa fa-envelope"></i></span>
                                                <a href="#" class="mail"><?php echo $agent['email']; ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            <?php endforeach; ?>




                        </ul>
                    </div>
                    <p class="jcarousel-pagination"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="subscribe-banner">
                    <div class="banner-text-block">
                        <span class="banner-title inversed">Call to action cím</span>
                        <p class="banner-text">Call to action szöveg .Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse quis iaculis mi...</p>
                    </div>
                    <div class="subscribe-block">
                        <a href="#" class="subscribe-btn">Tovább</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>