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
                <div class="col-md-9 col-sm-8">
                    <div class="objects-block with-sidebar">
                        
                        <!-- KÉP SLIDER -->
                        <div class="row">
                            <div class="col-sm-12">
kép -  slider
                            </div>
                        </div>

                        <!-- JELLEMZŐK -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="empty-space-30"></div>
                            </div>
                        </div>

                        <!-- LEÍRÁS -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="property-desc">
                                    <h4 class="title">Leírás</h4>
                                    <?php echo $ingatlan['leiras_' . LANG]; ?>
                                </div>
                                <div class="empty-space-30"></div>
                            </div>
                        </div>

                        <!-- TÉRKÉP -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="empty-space"></div>
                            </div>
                        </div>

                        <!-- HASONLÓ INGATLANOK -->
                        <div class="row">
                            <div class="col-sm-12">

            <?php if (!empty($hasonlo_ingatlan)) { ?>                                

                <h2 class="block-title">Hasonló ingatlanok</h2>
                <div class="object-slider latest-properties">
                    <div class="jcarousel-arrows">
                        <a href="#" class="prev-slide"><i class="fa fa-angle-left"></i></a>
                        <a href="#" class="next-slide"><i class="fa fa-angle-right"></i></a>
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
                            <?php } ?>

                        </ul>
                    </div>
                    <p class="jcarousel-pagination"></p>
                </div>
            <?php } ?>






                            </div>
                        </div>

                    </div>
                </div>
























                <!-- SIDEBAR -->
                <div class="col-md-3 col-sm-4">
                    <aside class="sidebar main-sidebar">
                        <!-- KIEMELT INGATLANOK DOBOZ -->
                        <?php include($this->path('tpl_modul_banner')); ?>
                    </aside>        
                </div> <!-- SIDEBAR END -->

            </div>
        </div>
    </div>