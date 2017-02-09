<?php 
use System\Libs\Config;
use System\Libs\Language as Lang;
?>
<div id="content" class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="breadcrumbs">
                        <span class="clickable"><a href="index.html"><?php echo Lang::get('menu_home'); ?></a></span>
                        <span class="delimiter">/</span>
                        <span class="active-page"><?php echo Lang::get('menu_ingatlanok'); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-sm-8">
                    <div class="objects-block with-sidebar">
                        
                        <!-- TALÁLT ELEMEK ÉS SORBARENDEZÉS -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="sort-block extended gray-bg">
                                    <div class="left">
                                        <span class="founded">Találatok száma: <span class="value"><?php echo $filtered_count; ?></span></span>
                                    </div>
                                    <div class="right">
                                        <div class="sort-item order">

                                            <?php
                                                $order = ($this->request->has_query('order')) ? $this->request->get_query('order') : false;
                                                $order_by = ($this->request->has_query('order_by')) ? $this->request->get_query('order_by') : false;
                                            ?>
                                            <span class="sort-label">Sorrend:</span>
                                            <div class="select-container">
                                                <div id="select-type-holder1" class="ui-front">
                                                    <select id="sorrend_select" name="sorrend_select" class="select filter-select" data-icon="false">
                                                        <option <?php echo ($order_by == 'datum' && $order == 'desc') ? 'selected' : ''; ?> value="<?php echo $this->url_helper->add_order_to_url('desc', 'datum'); ?>">Legfrissebb elöl</option>
                                                        <option <?php echo ($order_by == 'datum' && $order == 'asc') ? 'selected' : ''; ?> value="<?php echo $this->url_helper->add_order_to_url('asc', 'datum'); ?>">Legrégebbi elöl</option>
                                                        <option <?php echo ($order_by == 'ar' && $order == 'desc') ? 'selected' : ''; ?> value="<?php echo $this->url_helper->add_order_to_url('desc', 'ar'); ?>">Legdrágább elöl</option>
                                                        <option <?php echo ($order_by == 'ar' && $order == 'asc') ? 'selected' : ''; ?> value="<?php echo $this->url_helper->add_order_to_url('asc', 'ar'); ?>">Legolcsóbb elöl</option>
                                                    </select>
                                                </div>
                                            </div>

<!-- Bootstrap select menu
                                            <?php
                                                //$order = ($this->request->has_query('order')) ? $this->request->get_query('order') : false;
                                                //$order_by = ($this->request->has_query('order_by')) ? $this->request->get_query('order_by') : false;
                                            ?>
                                            <span class="sort-label">Sorrend:</span>
                                            <div class="form-group">
                                                <select id="sorrend_select" name="sorrend_select" class="form-control">
                                                    <option <?php //echo ($order_by == 'datum' && $order == 'desc') ? 'selected' : ''; ?> value="<?php //echo $this->url_helper->add_order_to_url('desc', 'datum'); ?>">Legfrissebb elöl</option>
                                                    <option <?php //echo ($order_by == 'datum' && $order == 'asc') ? 'selected' : ''; ?> value="<?php //echo $this->url_helper->add_order_to_url('asc', 'datum'); ?>">Legrégebbi elöl</option>
                                                    <option <?php //echo ($order_by == 'ar' && $order == 'desc') ? 'selected' : ''; ?> value="<?php //echo $this->url_helper->add_order_to_url('desc', 'ar'); ?>">Legdrágább elöl</option>
                                                    <option <?php //echo ($order_by == 'ar' && $order == 'asc') ? 'selected' : ''; ?> value="<?php //echo $this->url_helper->add_order_to_url('asc', 'ar'); ?>">Legolcsóbb elöl</option>
                                                </select>
                                            </div>
 -->

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
                                            <!-- <span class="features-label <?php //echo $css_class; ?>"><?php //echo $label; ?></span> -->
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
                        <?php include($this->path('tpl_modul_referenscontact')); ?>
                        <!-- KIEMELT INGATLANOK DOBOZ -->
                        <?php include($this->path('tpl_modul_kiemeltingatlanok')); ?>
                        <!-- KIEMELT INGATLANOK DOBOZ -->
                        <?php include($this->path('tpl_modul_banner')); ?>
                    </aside>        
                </div> <!-- SIDEBAR END -->

            </div>
        </div>
    </div>