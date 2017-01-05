<?php

use System\Libs\Config ?>
<div class="home-banner style-2">
    <div class="container">
        <div class="banner-content">
            <div class="banner-message">
                <div class="banner-entry">
                    <span class="entry-title">Lorem ipsum</span>
                    <span class="entry-message">Dolem dolores ipsum</span>
                </div>
            </div>
            <div class="main-filter hidden-xs">
                <form class="filter-form" action="ingatlanok">
                    <div class="row">
                        <div class="filter-column-3">
                            <span class="item-label">Eladó/kiadó</span>
                            <div class="form-group">
                                <select name="tipus" class="form-control">
                                    <option selected="selected" value="1">Eladó</option>
                                    <option value="2">Kiadó</option>
                                </select>
                            </div>	
                        </div>
                        <div class="filter-column-3">
                            <span class="item-label">Város</span>
                            <div class="form-group">
                                <select name="varos" id="varos" class="form-control" >
                                    <?php echo $city_list; ?>
                                </select>
                            </div>
                        </div>
                        <div class="filter-column-3">
                            <span class="item-label">Kerület</span>
                            <div class="form-group">
                                <select disabled="disabled" id="district" name="kerulet" class="form-control" >
                                    <?php echo $district_list; ?>
                                </select>
                            </div>
                        </div>                    
                        <div class="filter-column-3">
                            <span class="item-label">Kategoria</span>
                            <div class="form-group">
                                <select name="kategoria" class="form-control">
                                    <option value="">-- mindegy --</option>
                                    <?php foreach ($category_list as $value) : ?>
                                        <option value="<?php echo $value['kat_id']; ?>"><?php echo $value['kat_nev']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="filter-column-3">
                            <span class="item-label">Minimum ár</span>
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="min_ar" type="text" class="form-control">
                                    <div class="input-group-addon">Ft</div>
                                </div>
                            </div>
                        </div> 
                        <div class="filter-column-3">
                            <span class="item-label">Maximum ár</span>
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="max_ar" type="text" class="form-control">
                                    <div class="input-group-addon">Ft</div>
                                </div>
                            </div>
                        </div>


                        <div class="filter-column-3">
                            <span class="item-label">Alapterület</span>
                            <div class="form-group">
                                <input name="min_terulet" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="filter-column-3">
                            <button class="find-now-btn">Keresés</button>
                        </div>


                    </div>
                </form>
            </div>
            <a href="#" class="visible-xs find-now-btn">Keresés</a>
        </div>
    </div>
</div>

<div id="content" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="block-title">Latest Properties</h2>
                <div class="object-slider latest-properties">
                    <div class="jcarousel-arrows">
                        <a href="#" class="prev-slide"><i class="fa fa-angle-left"></i></a>
                        <span class="text">All Properties</span>
                        <a href="#" class="next-slide"><i class="fa fa-angle-right"></i></a>
                    </div>
                    <div class="obj-carousel carousel">
                        <ul>
                            <?php foreach ($all_properties as $value) { ?>
                                <?php $photo_array = json_decode($value['kepek']); ?>
                                <li>
                                    <div class="item">
                                        <div class="preview">
                                            <?php if ($value['kepek']) { ?>
                                                <img src="<?php echo $this->url_helper->thumbPath(Config::get('ingatlan_photo.upload_path') . $photo_array[0], false, 'small'); ?>" alt="<?php echo $value['ingatlan_nev']; ?>">
                                            <?php } ?>
                                            <?php if ($value['kepek'] == null) { ?>
                                                <img src="<?php echo Config::get('ingatlan_photo.upload_path') . 'placeholder.jpg'; ?>" alt="<?php echo $value['ingatlan_nev']; ?>">
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
                                                <span class="value"><?php echo $value['kat_nev'];?></span>
                                            </div>
                                            <div class="single-thumbnail">
                                               
                                                <span class="value"><?php echo $value['szobaszam'];?> szoba</span>
                                            </div>
                                            <div class="single-thumbnail">
                                                <span class="value"><?php echo $value['alapterulet'];?> m<sup>2</sup></span>
                                            </div>
                                        </div>
                                        <div class="item-entry">
                                            <span class="item-title"><a href="ingatlanok/adatlap/<?php echo $value['id'] . '/' . $this->str_helper->stringToSlug($value['ingatlan_nev']); ?>"><?php echo $value['ingatlan_nev']; ?></a></span>
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
                <h2 class="block-title">Our Best Agents</h2>
                <div class="best-agents">
                    <div class="jcarousel-arrows">
                        <a href="#" class="prev-slide"><i class="fa fa-angle-left"></i></a>
                        <span class="text">All Agents</span>
                        <a href="#" class="next-slide"><i class="fa fa-angle-right"></i></a>
                    </div>
                    <div class="ag-carousel carousel">
                        <ul>
                            <li>
                                <div class="item">
                                    <div class="preview">
                                        <img src="media/images/agency/1.png" alt="">
                                        <div class="overlay">
                                            <a href="agent-single_agent.html"><i class="fa fa-search-plus"></i></a>
                                        </div>
                                    </div>
                                    <span class="name">Djohn Kollings</span>
                                    <span class="properties">5 properties</span>
                                    <ul class="contact-listing">
                                        <li>
                                            <span class="icon"><i class="fa fa-phone"></i></span>
                                            <span class="phone">+234-754-596</span>
                                        </li>
                                        <li>
                                            <span class="icon"><i class="fa fa-envelope"></i></span>
                                            <a href="#" class="mail">info@example.com</a>
                                        </li>
                                        <li>
                                            <span class="icon"><i class="fa fa-globe"></i></span>
                                            <a href="#" class="site">infoexample.com</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <div class="preview">
                                        <img src="media/images/agency/2.png" alt="">
                                        <div class="overlay">
                                            <a href="agent-single_agent.html"><i class="fa fa-search-plus"></i></a>
                                        </div>
                                    </div>
                                    <span class="name">Eline Dorther</span>
                                    <span class="properties">3 properties</span>
                                    <ul class="contact-listing">
                                        <li>
                                            <span class="icon"><i class="fa fa-phone"></i></span>
                                            <span class="phone">+234-754-596</span>
                                        </li>
                                        <li>
                                            <span class="icon"><i class="fa fa-envelope"></i></span>
                                            <a href="#" class="mail">info@example.com</a>
                                        </li>
                                        <li>
                                            <span class="icon"><i class="fa fa-globe"></i></span>
                                            <a href="#" class="site">infoexample.com</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <div class="preview">
                                        <img src="media/images/agency/3.png" alt="">
                                        <div class="overlay">
                                            <a href="agent-single_agent.html"><i class="fa fa-search-plus"></i></a>
                                        </div>
                                    </div>
                                    <span class="name">Erik Braun</span>
                                    <span class="properties">8 properties</span>
                                    <ul class="contact-listing">
                                        <li>
                                            <span class="icon"><i class="fa fa-phone"></i></span>
                                            <span class="phone">+234-754-596</span>
                                        </li>
                                        <li>
                                            <span class="icon"><i class="fa fa-envelope"></i></span>
                                            <a href="#" class="mail">info@example.com</a>
                                        </li>
                                        <li>
                                            <span class="icon"><i class="fa fa-globe"></i></span>
                                            <a href="#" class="site">infoexample.com</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <div class="preview">
                                        <img src="media/images/agency/4.png" alt="">
                                        <div class="overlay">
                                            <a href="agent-single_agent.html"><i class="fa fa-search-plus"></i></a>
                                        </div>
                                    </div>
                                    <span class="name">Djoanna Holl</span>
                                    <span class="properties">5 properties</span>
                                    <ul class="contact-listing">
                                        <li>
                                            <span class="icon"><i class="fa fa-phone"></i></span>
                                            <span class="phone">+234-754-596</span>
                                        </li>
                                        <li>
                                            <span class="icon"><i class="fa fa-envelope"></i></span>
                                            <a href="#" class="mail">info@example.com</a>
                                        </li>
                                        <li>
                                            <span class="icon"><i class="fa fa-globe"></i></span>
                                            <a href="#" class="site">infoexample.com</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <div class="preview">
                                        <img src="media/images/agency/1.png" alt="">
                                        <div class="overlay">
                                            <a href="agent-single_agent.html"><i class="fa fa-search-plus"></i></a>
                                        </div>
                                    </div>
                                    <span class="name">Djohn Kollings</span>
                                    <span class="properties">5 properties</span>
                                    <ul class="contact-listing">
                                        <li>
                                            <span class="icon"><i class="fa fa-phone"></i></span>
                                            <span class="phone">+234-754-596</span>
                                        </li>
                                        <li>
                                            <span class="icon"><i class="fa fa-envelope"></i></span>
                                            <a href="#" class="mail">info@example.com</a>
                                        </li>
                                        <li>
                                            <span class="icon"><i class="fa fa-globe"></i></span>
                                            <a href="#" class="site">infoexample.com</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <p class="jcarousel-pagination"></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="hero-banner banner-with-text">
            <div class="container">
                <div class="banner-entry pull-right">
                    <div class="logo"><img alt="img" src="images/logo/logo-green-scheme-white.png"></div>
                    <p class="banner-text">Nulla in rutrum massa. Integer urna sem, consequat at eros et, condimentum hendrerit lacus. Sed condimentum fringilla massa ac fringilla. Fusce dolor risus, varius sit amet dapibus eu, molestie sed ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse potenti.</p>
                    <a href="#" class="learn-more-btn">Learn More</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="features-gallery">
                    <h2 class="block-title">Our Features</h2>
                    <span class="sub-title">Make your life easer with “UP Real Estate.</span>
                    <div class="feauture-gallery-container">
                        <div class="main-feature-item">
                            <div class="preview">
                                <a href="#">
                                    <img alt="img" src="media/images/features-gallery/1.jpg">
                                </a>
                            </div>
                        </div>
                        <div class="small-feature-item">
                            <div class="preview">
                                <a href="#">
                                    <img alt="img" src="media/images/features-gallery/2.jpg">
                                </a>
                            </div>
                        </div>
                        <div class="small-feature-item">
                            <div class="preview">
                                <a href="#">
                                    <div class="icon-container">
                                        <i class="icon pappers"></i>
                                    </div>
                                    <div class="title-box">
                                        <span class="top-title">Hottest</span>
                                        <span class="bottom-title">Listings</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="small-feature-item">
                            <div class="preview">
                                <a href="#">
                                    <img alt="img" src="media/images/features-gallery/3.jpg">
                                </a>
                            </div>
                        </div>
                        <div class="small-feature-item">
                            <div class="preview">
                                <a href="#">
                                    <div class="icon-container">
                                        <i class="icon home"></i>
                                    </div>
                                    <div class="title-box">
                                        <span class="top-title">Exclusive</span>
                                        <span class="bottom-title">Offers</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="small-feature-item">
                            <div class="preview">
                                <a href="#">
                                    <img alt="img" src="media/images/features-gallery/4.jpg">
                                </a>
                            </div>
                        </div>
                        <div class="small-feature-item">
                            <div class="preview">
                                <a href="#">
                                    <div class="icon-container">
                                        <i class="icon human"></i>
                                    </div>
                                    <div class="title-box">
                                        <span class="top-title">Exclusive</span>
                                        <span class="bottom-title">Offers</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="featured-listings gray-bg">
            <div class="container">
                <h2 class="block-title">Featured Listings</h2>
                <div class="object-slider latest-properties">
                    <div class="jcarousel-arrows">
                        <a href="#" class="prev-slide"><i class="fa fa-angle-left"></i></a>
                        <span class="text">All Featured</span>
                        <a href="#" class="next-slide"><i class="fa fa-angle-right"></i></a>
                    </div>
                    <div class="obj-carousel carousel">
                        <ul>
                            <li>
                                <div class="item">
                                    <div class="preview">
                                        <img src="media/images/featured-listings/1.jpg" alt="">
                                        <div class="overlay">
                                            <a href="#" class="incr">
                                                <i class="fa fa-search-plus"></i>
                                            </a>
                                            <a href="agent-single_agent.html" class="link">
                                                <i class="fa fa-link"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="item-thumbnail">
                                        <div class="single-thumbnail">
                                            <i class="icon bath"></i>
                                            <span class="value">3</span>
                                        </div>
                                        <div class="single-thumbnail">
                                            <i class="icon sleep"></i>
                                            <span class="value">2</span>
                                        </div>
                                        <div class="single-thumbnail">
                                            <i class="icon corner"></i>
                                            <span class="value">190 ft²</span>
                                        </div>
                                    </div>
                                    <div class="item-entry">
                                        <span class="item-title"><a href="#">Retail Space In West Side</a></span>
                                        <p class="item-text">Phasellus vestibulum mauris leo, et ultricies sem ultrices nec. Nunc volpat tortor vitae...</p>
                                        <div class="item-info">
                                            <span class="price">USD 999,00</span>
                                            <div class="pull-right buttons">
                                                <a href="#" class="share"><i class="fa fa-share-alt"></i></a>
                                                <a href="#" class="favourite">
                                                    <i class="fa fa-star-o"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <div class="preview">
                                        <img src="media/images/featured-listings/2.jpg" alt="">
                                        <div class="overlay">
                                            <a href="#" class="incr">
                                                <i class="fa fa-search-plus"></i>
                                            </a>
                                            <a href="agent-single_agent.html" class="link">
                                                <i class="fa fa-link"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="item-thumbnail">
                                        <div class="single-thumbnail">
                                            <i class="icon bath"></i>
                                            <span class="value">3</span>
                                        </div>
                                        <div class="single-thumbnail">
                                            <i class="icon sleep"></i>
                                            <span class="value">2</span>
                                        </div>
                                        <div class="single-thumbnail">
                                            <i class="icon corner"></i>
                                            <span class="value">190 ft²</span>
                                        </div>
                                    </div>
                                    <div class="item-entry">
                                        <span class="item-title"><a href="#">Family House In Hudson</a></span>
                                        <p class="item-text">Phasellus vestibulum mauris leo, et ultricies sem ultrices nec. Nunc volpat tortor vitae...</p>
                                        <div class="item-info">
                                            <span class="price">USD 746,00</span>
                                            <div class="pull-right buttons">
                                                <a href="#" class="share"><i class="fa fa-share-alt"></i></a>
                                                <a href="#" class="favourite">
                                                    <i class="fa fa-star-o"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <div class="preview">
                                        <img src="media/images/featured-listings/3.jpg" alt="">
                                        <div class="overlay">
                                            <a href="#" class="incr">
                                                <i class="fa fa-search-plus"></i>
                                            </a>
                                            <a href="agent-single_agent.html" class="link">
                                                <i class="fa fa-link"></i>
                                            </a>
                                        </div>
                                    </div>	
                                    <div class="item-thumbnail">
                                        <div class="single-thumbnail">
                                            <i class="icon bath"></i>
                                            <span class="value">3</span>
                                        </div>
                                        <div class="single-thumbnail">
                                            <i class="icon sleep"></i>
                                            <span class="value">2</span>
                                        </div>
                                        <div class="single-thumbnail">
                                            <i class="icon corner"></i>
                                            <span class="value">190 ft²</span>
                                        </div>
                                    </div>
                                    <div class="item-entry">
                                        <span class="item-title"><a href="#">Lake View In Manhattan</a></span>
                                        <p class="item-text">Phasellus vestibulum mauris leo, et ultricies sem ultrices nec. Nunc volpat tortor vitae...</p>
                                        <div class="item-info">
                                            <span class="price">USD 234,00</span>
                                            <div class="pull-right buttons">
                                                <a href="#" class="share"><i class="fa fa-share-alt"></i></a>
                                                <a href="#" class="favourite">
                                                    <i class="fa fa-star-o"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <div class="preview">
                                        <img src="media/images/featured-listings/4.jpg" alt="">
                                        <div class="overlay">
                                            <a href="#" class="incr">
                                                <i class="fa fa-search-plus"></i>
                                            </a>
                                            <a href="agent-single_agent.html" class="link">
                                                <i class="fa fa-link"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="item-thumbnail">
                                        <div class="single-thumbnail">
                                            <i class="icon bath"></i>
                                            <span class="value">3</span>
                                        </div>
                                        <div class="single-thumbnail">
                                            <i class="icon sleep"></i>
                                            <span class="value">2</span>
                                        </div>
                                        <div class="single-thumbnail">
                                            <i class="icon corner"></i>
                                            <span class="value">190 ft²</span>
                                        </div>
                                    </div>
                                    <div class="item-entry">
                                        <span class="item-title"><a href="#">Open House South</a></span>
                                        <p class="item-text">Phasellus vestibulum mauris leo, et ultricies sem ultrices nec. Nunc volpat tortor vitae...</p>
                                        <div class="item-info">
                                            <span class="price">USD 536,00</span>
                                            <div class="pull-right buttons">
                                                <a href="#" class="share"><i class="fa fa-share-alt"></i></a>
                                                <a href="#" class="favourite">
                                                    <i class="fa fa-star-o"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <div class="preview">
                                        <img src="media/images/featured-listings/1.jpg" alt="">
                                        <div class="overlay">
                                            <a href="#" class="incr">
                                                <i class="fa fa-search-plus"></i>
                                            </a>
                                            <a href="agent-single_agent.html" class="link">
                                                <i class="fa fa-link"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="item-thumbnail">
                                        <div class="single-thumbnail">
                                            <i class="icon bath"></i>
                                            <span class="value">3</span>
                                        </div>
                                        <div class="single-thumbnail">
                                            <i class="icon sleep"></i>
                                            <span class="value">2</span>
                                        </div>
                                        <div class="single-thumbnail">
                                            <i class="icon corner"></i>
                                            <span class="value">190 ft²</span>
                                        </div>
                                    </div>
                                    <div class="item-entry">
                                        <span class="item-title"><a href="#">Retail Space In West Side</a></span>
                                        <p class="item-text">Phasellus vestibulum mauris leo, et ultricies sem ultrices nec. Nunc volpat tortor vitae...</p>
                                        <div class="item-info">
                                            <span class="price">USD 999,00</span>
                                            <div class="pull-right buttons">
                                                <a href="#" class="share"><i class="fa fa-share-alt"></i></a>
                                                <a href="#" class="favourite">
                                                    <i class="fa fa-star-o"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <p class="jcarousel-pagination"></p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="block-title ">Our Services</h2>
                <div class="accordion-control style1">
                    <h3>Donec eget leo facilisis</h3>
                    <div>
                        <p>Suspendisse rhoncus, libero ut eleifend aliquam, dui est consequat diam, vel tincidunt odio risus in tortor. Morbi accumsan leo et tincidunt facilisis. Donec aliquam, magna id blandit dapibus, risus justo venenatis felis, eget luctus nunc velit nec urna. </p>
                    </div>
                    <h3>Nunc venenatis neque vitae risus</h3>
                    <div>
                        <p>Suspendisse rhoncus, libero ut eleifend aliquam, dui est consequat diam, vel tincidunt odio risus in tortor. Morbi accumsan leo et tincidunt facilisis. Donec aliquam, magna id blandit dapibus, risus justo venenatis felis, eget luctus nunc velit nec urna. </p>
                    </div>
                    <h3>Nam ut accumsan massa</h3>
                    <div>
                        <p>Suspendisse rhoncus, libero ut eleifend aliquam, dui est consequat diam, vel tincidunt odio risus in tortor. Morbi accumsan leo et tincidunt facilisis. Donec aliquam, magna id blandit dapibus, risus justo venenatis felis, eget luctus nunc velit nec urna. </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <h2 class="block-title ">What People Say About Us</h2>
                <div class="reviews-of-people">
                    <ul class="reviews-listing">
                        <li>
                            <div class="preview">
                                <img src="media/images/what-people-say/1.png" alt="">
                            </div>
                            <div class="descr">
                                <span class="title">Hanry Ford</span>
                                <p>Nullam ac vestibulum nisl, in rutrum felis. Pellentesque quis facilisis nisl. Aliquam ut tincidunt sem. Sed at condimentum tellus, vitae elementum odio. Sed hendrerit varius lectus, venenatis blandit ligula pulvinar in. </p>
                            </div>
                        </li>
                        <li>
                            <div class="preview">
                                <img src="media/images/what-people-say/2.png" alt="">
                            </div>
                            <div class="descr">
                                <span class="title">Eline Dorther</span>
                                <p>Nullam ac vestibulum nisl, in rutrum felis. Pellentesque quis facilisis nisl. Aliquam ut tincidunt sem. Sed at condimentum tellus, vitae elementum odio. Sed hendrerit varius lectus, venenatis blandit ligula pulvinar in. </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="empty-space"></div>
    </div>
    <div class="row">
        <div class="contacts-block gray-bg">
            <div class="container">
                <div class="row">
                    <div class="col-sm-offset-2 col-sm-8">
                        <h2 class="block-title ">Our Contacts</h2>
                        <span class="sub-title">Duis a massa vitae diam maximus dictum sit amet nec purus. Morbi a nunc et sapien iaculis tincidunt nec hendrerit sapien. Cras convallis rhoncus mi eget rhoncus. In fringilla ligula mauris, sed volutpat tellus convallis vel.</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7 col-md-8 col-lg-9">
                        <div class="map-holder">
                            <div class="map-canvas" id="contact-map"></div>
                        </div>
                    </div>
                    <div class="col-sm-5 col-md-4 col-lg-3">
                        <ul class="contacts-listing">
                            <li>
                                <div class="icon-contaier">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <div class="descr">
                                    <p>Beverly Hills, CA 90210</p>
                                </div>
                            </li>
                            <li>
                                <div class="icon-contaier">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <div class="descr">
                                    <p><span>Monday - Friday</span>from 9:00 to 18:00</p>
                                </div>
                            </li>
                            <li>
                                <div class="icon-contaier">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="descr">
                                    <p>435-234-9867</p>
                                </div>
                            </li>
                            <li>
                                <div class="icon-contaier">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div class="descr">
                                    <a href="#">info@uprealestate.com</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="block-title">Our Partners</h2>
                <div class="partners-holder style-1">
                    <div class="jcarousel-arrows">
                        <a href="#" class="prev-slide"><i class="fa fa-angle-left"></i></a>
                        <span class="text">All Partners</span>
                        <a href="#" class="next-slide"><i class="fa fa-angle-right"></i></a>
                    </div>
                    <div class="partners-carousel carousel">
                        <ul>
                            <li>
                                <div class="partner-item">
                                    <div class="preview">
                                        <a href="#">
                                            <img alt="img" src="media/images/partners/1.png">
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="partner-item">
                                    <div class="preview">
                                        <a href="#">
                                            <img alt="img" src="media/images/partners/2.png">
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="partner-item">
                                    <div class="preview">
                                        <a href="#">
                                            <img alt="img" src="media/images/partners/3.png">
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="partner-item">
                                    <div class="preview">
                                        <a href="#">
                                            <img alt="img" src="media/images/partners/4.png">
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="partner-item">
                                    <div class="preview">
                                        <a href="#">
                                            <img alt="img" src="media/images/partners/5.png">
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="partner-item">
                                    <div class="preview">
                                        <a href="#">
                                            <img alt="img" src="media/images/partners/6.png">
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="partner-item">
                                    <div class="preview">
                                        <a href="#">
                                            <img alt="img" src="media/images/partners/1.png">
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="partner-item">
                                    <div class="preview">
                                        <a href="#">
                                            <img alt="img" src="media/images/partners/2.png">
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="partner-item">
                                    <div class="preview">
                                        <a href="#">
                                            <img alt="img" src="media/images/partners/3.png">
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="partner-item">
                                    <div class="preview">
                                        <a href="#">
                                            <img alt="img" src="media/images/partners/4.png">
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="partner-item">
                                    <div class="preview">
                                        <a href="#">
                                            <img alt="img" src="media/images/partners/5.png">
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="partner-item">
                                    <div class="preview">
                                        <a href="#">
                                            <img alt="img" src="media/images/partners/6.png">
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <p class="jcarousel-pagination"></p>
                </div>
            </div>
        </div>
        <div class="empty-space"></div>
    </div>
</div>