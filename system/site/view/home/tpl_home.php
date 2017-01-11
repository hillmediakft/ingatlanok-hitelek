<?php 
use System\Libs\Config;
use System\Libs\Language as Lang;
?>
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
                            <span class="item-label"><?php echo Lang::get('kereso_elado'); ?>/<?php echo Lang::get('kereso_kiado'); ?></span>
                            <div class="form-group">
                                <select name="tipus" class="form-control">
                                    <option selected="selected" value="1"><?php echo Lang::get('kereso_elado'); ?></option>
                                    <option value="2"><?php echo Lang::get('kereso_kiado'); ?></option>
                                </select>
                            </div>	
                        </div>
                        <div class="filter-column-3">
                            <span class="item-label"><?php echo Lang::get('kereso_varos'); ?></span>
                            <div class="form-group">
                                <select name="varos" id="varos" class="form-control" >
                                    <option value="">-- <?php echo Lang::get('kereso_mindegy');?> --</option>;
                                    <?php echo $city_list; ?>
                                </select>
                            </div>
                        </div>
                        <div class="filter-column-3">
                            <span class="item-label"><?php echo Lang::get('kereso_kerulet'); ?></span>
                            <div class="form-group">
                                <select disabled="disabled" id="district" name="kerulet" class="form-control" >
                                    <option value="">-- <?php echo Lang::get('kereso_mindegy');?> --</option>
                                    <?php echo $district_list; ?>
                                </select>
                            </div>
                        </div>                    
                        <div class="filter-column-3">
                            <span class="item-label"><?php echo Lang::get('kereso_kategoria'); ?></span>
                            <div class="form-group">
                                <select name="kategoria" class="form-control">
                                    <option value="">-- <?php echo Lang::get('kereso_mindegy');?> --</option>
                                    <?php foreach ($category_list as $value) : ?>
                                        <option value="<?php echo $value['kat_id']; ?>"><?php echo $value['kat_nev_' . LANG]; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="filter-column-3">
                            <span class="item-label"><?php echo Lang::get('kereso_min_ar'); ?></span>
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="min_ar" type="text" class="form-control">
                                    <div class="input-group-addon">Ft</div>
                                </div>
                            </div>
                        </div> 
                        <div class="filter-column-3">
                            <span class="item-label"><?php echo Lang::get('kereso_max_ar'); ?></span>
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="max_ar" type="text" class="form-control">
                                    <div class="input-group-addon">Ft</div>
                                </div>
                            </div>
                        </div>


                        <div class="filter-column-3">
                            <span class="item-label"><?php echo Lang::get('kereso_alapterulet'); ?></span>
                            <div class="form-group">
                                <input name="min_terulet" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="filter-column-3">
                            <button class="find-now-btn"><?php echo Lang::get('kereso_kereses'); ?></button>
                        </div>


                    </div>
                </form>
            </div>
            <a href="#" class="visible-xs find-now-btn"><?php echo Lang::get('kereso_kereses'); ?></a>
        </div>
    </div>
</div>

<div id="content" class="container-fluid">
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
                            <?php foreach ($all_properties as $value) { ?>
                                <?php $photo_array = json_decode($value['kepek']); ?>
                                <li>
                                    <div class="item">
                                        <div class="preview">
                                            <?php if ($value['kepek']) { ?>
                                                <img src="<?php echo $this->url_helper->thumbPath(Config::get('ingatlan_photo.upload_path') . $photo_array[0], false, 'small'); ?>" alt="<?php echo $value['ingatlan_nev_' . LANG]; ?>">
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
                                                <span class="value"><?php echo $value['kat_nev_' . LANG];?></span>
                                            </div>
                                            <div class="single-thumbnail">
                                               
                                                <span class="value"><?php echo $value['szobaszam'];?> szoba</span>
                                            </div>
                                            <div class="single-thumbnail">
                                                <span class="value"><?php echo $value['alapterulet'];?> m<sup>2</sup></span>
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
                            <li>
                                <div class="item">
                                    <div class="preview">
                                        <img src="<?php echo SITE_IMAGE;?>agency/1.png" alt="">
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
                                        <img src="<?php echo SITE_IMAGE;?>agency/2.png" alt="">
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
                                        <img src="<?php echo SITE_IMAGE;?>agency/3.png" alt="">
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
                                        <img src="<?php echo SITE_IMAGE;?>agency/4.png" alt="">
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
                                        <img src="<?php echo SITE_IMAGE;?>agency/1.png" alt="">
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
                                    <img alt="img" src="<?php echo SITE_IMAGE;?>features-gallery/1.jpg">
                                </a>
                            </div>
                        </div>
                        <div class="small-feature-item">
                            <div class="preview">
                                <a href="#">
                                    <img alt="img" src="<?php echo SITE_IMAGE;?>features-gallery/2.jpg">
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
                                    <img alt="img" src="<?php echo SITE_IMAGE;?>features-gallery/3.jpg">
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
                                    <img alt="img" src="<?php echo SITE_IMAGE;?>features-gallery/4.jpg">
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


</div>