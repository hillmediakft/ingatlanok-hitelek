<?php

use System\Libs\Config;
use System\Libs\Language as Lang;
?>

<!-- KERESÉS FORM -->
<div class="main-filter hidden-xs">
    <?php include($this->path('tpl_home_filter')); ?>
</div>


<!-- KERESÉS FORM MOBIL -->
<div class="main-filter hidden-sm hidden-md hidden-lg">
    <?php include($this->path('tpl_home_filter_mobile')); ?>
</div> 
<div class="nav-block">
    <div class="col-sm-12">
    <a style="float: none;" href="<?php echo $this->request->get_uri('site_url') . Config::get('url.kereses.index.' . LANG); ?>" class="submit-nav hidden-sm hidden-md hidden-lg text-center"><i class="fa fa-search"></i> <?php echo Lang::get('menu_kereses'); ?></a>
    </div>
</div>


<div id="content" class="container-fluid">


    <div class="row">
        <div class="our-features-banner gray-bg light">
            <div class="container">
                <h2 class="block-title"><?php echo Lang::get('home_szolgaltatasok_cim'); ?></h2>
                <span class="sub-title"><?php echo Lang::get('home_szolgaltatasok_szoveg'); ?></span>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="single-feature">
                            <div class="icon-container">
                                <div class="icon-border">
                                    <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.mennyit-er-az-ingatlanom.index.' . LANG); ?>">
                                        <img src="<?php echo SITE_IMAGE; ?>mennyit-er-az-ingatlanom.png">
                                    </a>	
                                </div>
                            </div>
							<a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.mennyit-er-az-ingatlanom.index.' . LANG); ?>">
								<span class="main-title"><?php echo Lang::get('home_szolgaltatasok_1_cim'); ?></span>
								<span class="featured-sub-title colored"><?php echo Lang::get('home_szolgaltatasok_1_szoveg'); ?></span>
							</a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="single-feature">
                            <div class="icon-container">
                                <div class="icon-border">
                                    <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.befektetoknek.index.' . LANG); ?>">
                                        <img src="<?php echo SITE_IMAGE; ?>befektetoknek.png">
                                    </a>	
                                </div>
                            </div>
							<a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.befektetoknek.index.' . LANG); ?>">
								<span class="main-title"><?php echo Lang::get('home_szolgaltatasok_2_cim'); ?></span>
								<span class="featured-sub-title colored"><?php echo Lang::get('home_szolgaltatasok_2_szoveg'); ?></span>
							</a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="single-feature">
                            <div class="icon-container">
                                <div class="icon-border">
                                    <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.berbeadoknak.index.' . LANG); ?>">
                                        <img src="<?php echo SITE_IMAGE; ?>berbeadoknak.png">
                                    </a>	
                                </div>
                            </div>
							<a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.berbeadoknak.index.' . LANG); ?>">
								<span class="main-title"><?php echo Lang::get('home_szolgaltatasok_3_cim'); ?></span>
								<span class="featured-sub-title colored"><?php echo Lang::get('home_szolgaltatasok_3_szoveg'); ?></span>
							</a>
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

                                            <?php if ($value['kepek']) { ?>
                                                <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.ingatlanok.adatlap.' . LANG) . '/' . $value['id'] . '/' . $this->str_helper->stringToSlug($value['ingatlan_nev_' . LANG]); ?>">
                                                    <img src="<?php echo $this->url_helper->thumbPath(Config::get('ingatlan_photo.upload_path') . $photo_array[0], false, 'small'); ?>" alt="<?php echo $value['ingatlan_nev_' . LANG]; ?>">
                                                </a>
                                            <?php } ?>
                                            <?php if ($value['kepek'] == null) { ?>
                                                <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.ingatlanok.adatlap.' . LANG) . '/' . $value['id'] . '/' . $this->str_helper->stringToSlug($value['ingatlan_nev_' . LANG]); ?>">
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
                                                <span class="value">
                                                    <?php
                                                        $felszobaszam = (!empty($value['felszobaszam'])) ? '+ ' . $value['felszobaszam'] . ' ' : '';
                                                        echo (!empty($value['szobaszam'])) ? $value['szobaszam'] . ' ' . $felszobaszam . mb_strtolower(Lang::get('jell_szobaszam'), 'UTF-8') : ''; 
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="single-thumbnail">
                                                <span class="value"><?php echo $value['alapterulet']; ?> m<sup>2</sup></span>
                                            </div>
                                        </div>
                                        <div class="item-entry">
                                            <span class="item-title">
                                                <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.ingatlanok.adatlap.' . LANG) . '/' . $value['id'] . '/' . $this->str_helper->stringToSlug($value['ingatlan_nev_' . LANG]); ?>"><?php echo $value['ingatlan_nev_' . LANG]; ?></a>
                                            </span>
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
                                                <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.ingatlanok.ertekesito.' . LANG) . '/' . $this->str_helper->stringToSlug($agent['first_name']) . '-' . $this->str_helper->stringToSlug($agent['last_name']) . '/' . $agent['id']; ?>"><i class="fa fa-search-plus"></i></a>
                                            </div>
                                        </div>
                                        <span class="name"><?php echo $agent['first_name'] . ' ' . $agent['last_name']; ?></span>
                                        <span class="properties">
                                            <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.ingatlanok.ertekesito.' . LANG) . '/' . $this->str_helper->stringToSlug($agent['first_name']) . '-' . $this->str_helper->stringToSlug($agent['last_name']) . '/' . $agent['id']; ?>" class="simple-btn sm-button outlined red"><?php echo $agent['property'] . ' ' . Lang::get('referens_ingatlan'); ?></a>
                                        </span>
                                        <ul class="contact-listing">
                                            <li>
                                                <span class="icon"><i class="fa fa-phone"></i></span>
                                                <span class="phone"><?php echo $agent['phone']; ?></span>
                                            </li>
                                            <li>
                                                <span class="icon"><i class="fa fa-envelope"></i></span>
                                                <a href="mailto:<?php echo $agent['email']; ?>" class="mail"><?php echo $agent['email']; ?></a>
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
                        <span class="banner-title inversed"><?php echo Lang::get('home_cta_title'); ?></span>
                        <p class="banner-text"><?php echo Lang::get('home_cta_body'); ?></p>
                    </div>
                    <div class="subscribe-block">
                        <a href="<?php echo Lang::get('home_cta_link'); ?>" class="subscribe-btn"><?php echo Lang::get('altalanos_gomb'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>