<?php 
use System\Libs\Config;
?>
<div id="content" class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="breadcrumbs">
                        <span class="clickable"><a href="index.html">Home</a></span>
                        <span class="delimiter">/</span>
                        <span class="active-page">Properties</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-sm-8">
                    <div class="objects-block with-sidebar">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="sort-block extended gray-bg">
                                    <div class="left">
                                        <span class="founded"><span class="value"><?php echo $filtered_count; ?></span>Properties founded</span>
                                    </div>
                                    <div class="right">
                                        <div class="sort-item order">
                                            <span class="sort-label">Order:</span>
                                            <div class="select-container">
                                                <div id="select-type-holder1" class="ui-front">
                                                    <select name="prop-select" data-icon="false" class="select filter-select">
                                                        <option selected="selected">Ascending</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sort-item sort">
                                            <span class="sort-label">Sort by:</span>
                                            <div class="select-container">
                                                <div id="select-type-holder2" class="ui-front">
                                                    <select name="prop-select" data-icon="false" class="select filter-select">
                                                        <option selected="selected">Date</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sort-item view-block">
                                            <a href="#" class="grid active">
                                                <i class="menu fa fa-th"></i>
                                            </a>
                                            <a href="#" class="list">
                                                <i class="fa fa-bars"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="empty-space-30"></div>
                            </div>
                        </div>

                        <!-- INGATALANOK LISTÁJA -->
						<div class="property-list" id="equalheight-property-list">
                        <div class="row">
                            <?php
                                foreach ($properties as $value) {
                                    $photo_array = json_decode($value['kepek']);
                            ?>
                            <div class="col-lg-4 col-md-6">
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
                            </div>
                            <?php } ?>
                        </div>
						</div>

                        <!-- LAPOZÓ -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="objects-pagination left">
                                   <?php echo $data['pagine_links']; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="empty-space"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SIDEBAR -->
                <div class="col-md-3 col-sm-4">
                    <aside class="sidebar main-sidebar">

                        <!-- KERESŐ DOBOZ -->
                        <?php include($this->path('tpl_ingatlanok_filter')); ?>
                        <!-- REFERENSEK DOBOZ -->
                        <?php include($this->path('tpl_referens_contact_box')); ?>


                        <div class="widget featured-properties">
                            <div class="heading">
                                <span class="widget-title">Featured Properties</span>
                            </div>
                            <div class="widget-entry">
                                <div class="single-prop">
                                    <div class="preview">
                                        <img alt="" src="media/images/latest-blog-posts/5.1.jpg">
                                    </div>
                                    <div class="descr">
                                        <span class="title"><a href="#">Etiam pharetra luct felis sed rhoncus</a></span>
                                        <span class="price">USD <span class="value">999,000</span></span>
                                    </div>
                                </div>
                                <div class="single-prop">
                                    <div class="preview">
                                        <img alt="" src="media/images/latest-blog-posts/5.2.jpg">
                                    </div>
                                    <div class="descr">
                                        <span class="title"><a href="#">Aliquam maga tortor, volupat vitae</a></span>
                                        <span class="price">USD <span class="value">999,000</span></span>
                                    </div>
                                </div>
                                <div class="single-prop">
                                    <div class="preview">
                                        <img alt="" src="media/images/latest-blog-posts/5.3.jpg">
                                    </div>
                                    <div class="descr">
                                        <span class="title"><a href="#">Nam faucibus iaculis pulvinar</a></span>
                                        <span class="price">USD <span class="value">999,000</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        


                        
                        <div class="widget banner">
                            <div class="banner-label-bg">
                                <div class="banner-label">
                                    <img src="images/logo/banner-white-logo.png" alt="">
                                </div>
                            </div>
                            <div class="banner-img">
                                <img src="images/banners/sidebar-banner.jpg" alt="">
                            </div>
                            <div class="banner-entry">
                                <span class="banner-title">Your Message</span>
                                <span class="banner-sub">Goes Here</span>
                                <a href="#" class="learn-more">Learn More</a>
                            </div>
                        </div>


                    </aside>        
                </div> <!-- SIDEBAR END -->


            </div>
        </div>
    </div>