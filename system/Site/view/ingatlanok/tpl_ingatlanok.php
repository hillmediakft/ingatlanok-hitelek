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
                    <span class="active-page"><?php echo Lang::get('menu_ingatlanok'); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8">

                <!-- TALÁLT ELEMEK ÉS SORBARENDEZÉS -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="sort-block extended gray-bg">
                            <div class="left">
                                <span class="founded"><?php echo Lang::get('kereso_talalatok_szama'); ?>: <span class="value"><?php echo $filtered_count; ?></span></span>
                            </div>
                            <div class="right">
                                <div class="sort-item order">

                                    <?php
                                    $order = (isset($filter_params['order'])) ? $filter_params['order'] : false;
                                    $order_by = (isset($filter_params['order_by'])) ? $filter_params['order_by'] : false;
                                    ?>
                                    <span class="sort-label"><?php echo Lang::get('kereso_sorrend'); ?>:</span>
                                    <div class="select-container">
                                        <div id="select-type-holder1" class="ui-front">
                                            <select id="sorrend_select" name="sorrend_select" class="select filter-select" data-icon="false">
                                                <option <?php echo ($order_by == 'datum' && $order == 'desc') ? 'selected' : ''; ?> value="<?php echo $this->url_helper->add_order_to_url('desc', 'datum'); ?>"><?php echo Lang::get('kereso_legfrissebb_elol'); ?></option>
                                                <option <?php echo ($order_by == 'datum' && $order == 'asc') ? 'selected' : ''; ?> value="<?php echo $this->url_helper->add_order_to_url('asc', 'datum'); ?>"><?php echo Lang::get('kereso_legregebbi_elol'); ?></option>
                                                <option <?php echo ($order_by == 'ar' && $order == 'desc') ? 'selected' : ''; ?> value="<?php echo $this->url_helper->add_order_to_url('desc', 'ar'); ?>"><?php echo Lang::get('kereso_legdragabb_elol'); ?></option>
                                                <option <?php echo ($order_by == 'ar' && $order == 'asc') ? 'selected' : ''; ?> value="<?php echo $this->url_helper->add_order_to_url('asc', 'ar'); ?>"><?php echo Lang::get('kereso_legolcsobb_elol'); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="sort-item view-block">
                                    <a href="<?php echo $this->url_helper->addToQueryString(array('view' => 'grid')); ?>" class="grid <?php echo ($filter_params['view'] == 'grid') ? 'active' : ''; ?>">
                                        <i class="menu fa fa-th"></i>
                                    </a>
                                    <a href="<?php echo $this->url_helper->addToQueryString(array('view' => 'list')); ?>" class="list <?php echo ($filter_params['view'] == 'list') ? 'active' : ''; ?>">
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
  
                <?php if ($data['filter_params']['view'] == 'grid') { ?>
                 <!-- INGATALANOK LISTÁJA GRID -->
                <div class="objects-block with-sidebar">
                    <div class="property-list" id="equalheight-property-list">
                        <div class="row">
                            <?php
                                foreach ($properties as $value) {
                            ?>
                            

<?php
if ($value == 'banner') { ?>
<div class="col-lg-4 col-md-6">
    <div class="item">
        <div class="banner-wrapper">
            <div class="banner-title">
                <h3><?php echo Lang::get('ingatlanok_hirdetes_title'); ?></h3>
            </div>
            <div class="banner-text">
                <?php echo Lang::get('ingatlanok_hirdetes_body'); ?>
            </div>
            <div>
                <a href="<?php echo Lang::get('ingatlanok_hirdetes_link'); ?>" class="simple-btn sm-button filled red"><?php echo Lang::get('altalanos_gomb'); ?></a>
            </div>
        </div>
    </div>
</div>
<?php continue; } ?>

                            <?php     
                                $photo_array = json_decode($value['kepek']);
                            ?>
                            <div class="col-lg-4 col-md-6">
                                
                              <a class="item-anchor" href="<?php echo $this->request->get_uri('site_url') . Config::get('url.ingatlanok.adatlap.' . LANG) . '/' . $value['id'] . '/' . $this->str_helper->stringToSlug($value['ingatlan_nev_' . LANG]); ?>">

                                <div class="item">
                                    <div class="preview">
                                        <?php $this->html_helper->showLowerPriceIcon($value); ?>

                                            <!-- <a href="<?php //echo $this->request->get_uri('site_url') . Config::get('url.ingatlanok.adatlap.' . LANG) . '/' . $value['id'] . '/' . $this->str_helper->stringToSlug($value['ingatlan_nev_' . LANG]); ?>"></a>                                         -->
                                            <?php if (!is_null($value['kepek'])) { ?>
                                                <img src="<?php echo $this->url_helper->thumbPath(Config::get('ingatlan_photo.upload_path') . $photo_array[0], false, 'small'); ?>" alt="<?php echo $value['ingatlan_nev_' . LANG]; ?>">
                                            <?php } else { ?>
                                                <img src="<?php echo Config::get('ingatlan_photo.upload_path') . 'placeholder.jpg'; ?>" alt="<?php echo $value['ingatlan_nev_' . LANG]; ?>">
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

                                            <span class="value"><?php echo (!empty($value['szobaszam'])) ? $value['szobaszam'] . ' ' . mb_strtolower(Lang::get('jell_szobaszam'), 'UTF-8') : ''; ?></span>
                                        </div>
                                        <div class="single-thumbnail">
                                            <span class="value"><?php echo $value['alapterulet']; ?> m<sup>2</sup></span>
                                        </div>
                                    </div>
                                    
                                    <div class="item-entry">
                                        <span class="item-title">
                                            <?php echo $value['ingatlan_nev_' . LANG]; ?>
                                        </span>
                                        <p><?php
                                            echo $value['city_name'];
                                            echo (isset($value['kerulet'])) ? ', ' . $value['kerulet'] . '. ' . Lang::get('adatlap_kerulet') : '';
                                            ?></p>

                                        <div class="item-info">
                                        </div>
                                    </div>
                                </div>

                              </a>

                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>                    
                <?php } else { ?>
                <!-- INGATALANOK LISTÁJA LIST -->
                <div class="objects-block list-sidebar">    
                    <div class="row">
                        <?php
                        foreach ($properties as $value) {
                        ?>



<?php
if ($value == 'banner') { ?>
<div class="col-sm-12">
    <div class="banner-wrapper-list">
        <div class="banner-title">
            <h3><?php echo Lang::get('ingatlanok_hirdetes_title'); ?></h3>
        </div>
        <div class="banner-text">
            <?php echo Lang::get('ingatlanok_hirdetes_body'); ?>
        </div>
        <div>
            <a href="<?php echo Lang::get('ingatlanok_hirdetes_link'); ?>" class="simple-btn sm-button filled red"><?php echo Lang::get('altalanos_gomb'); ?></a>
        </div>
    </div>
</div>
<?php continue; } ?>

                        <?php 
                            $photo_array = json_decode($value['kepek']);
                        ?>
                        <div class="col-sm-12">
                            
                          <a class="item-anchor" href="<?php echo $this->request->get_uri('site_url') . Config::get('url.ingatlanok.adatlap.' . LANG) . '/' . $value['id'] . '/' . $this->str_helper->stringToSlug($value['ingatlan_nev_' . LANG]); ?>">

                            <div class="item">
                                <div class="preview">
                                    <?php $this->html_helper->showLowerPriceIcon($value);?>

                                    <!-- <a href="<?php //echo $this->request->get_uri('site_url') . Config::get('url.ingatlanok.adatlap.' . LANG) . '/' . $value['id'] . '/' . $this->str_helper->stringToSlug($value['ingatlan_nev_' . LANG]); ?>"></a>                                         -->
                                    <?php if (!is_null($value['kepek'])) { ?>
                                        <img src="<?php echo $this->url_helper->thumbPath(Config::get('ingatlan_photo.upload_path') . $photo_array[0], false, 'small'); ?>" alt="<?php echo $value['ingatlan_nev_' . LANG]; ?>">
                                    <?php } else { ?>
                                        <img src="<?php echo Config::get('ingatlan_photo.upload_path') . 'placeholder.jpg'; ?>" alt="<?php echo $value['ingatlan_nev_' . LANG]; ?>">
                                    <?php } ?>

                                </div>
                                <div class="thumbnail-container">
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
                                    <div class="item-info">
                                        <span class="price"> 
                                            <?php $this->html_helper->showPrice($value);?>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="item-entry">
                                    <span class="item-title">
                                        <?php echo $value['ingatlan_nev_' . LANG]; ?>
                                    </span>
                                    <p class="item-text"><p><?php
                                        echo $value['city_name'];
                                        echo (isset($value['kerulet'])) ? ', ' . $value['kerulet'] . '. ' . Lang::get('adatlap_kerulet') : '';
                                        ?></p></p>
                                </div>
                            </div>

                          </a>

                        </div>       
                        <?php } ?>
                    </div>
                </div>    
                <?php } ?>

                <div class="objects-block width-sidebar">    
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

                    <div class="row">
                        <div class="col-sm-12">
                            <!-- <a id="save_search" href="javascript:void(0);" class="simple-btn lg-button outlined red" style="margin-top: 33px;"><?php //echo Lang::get('kereso_kereses_mentese_gomb'); ?></a> -->
                            <button id="save_search" class="save_search_button"><?php echo Lang::get('kereso_kereses_mentese_gomb'); ?></button>
                        </div>
                    </div>
                    <!-- KIEMELT INGATLANOK DOBOZ -->
                    <?php include($this->path('tpl_modul_kiemeltingatlanok')); ?>
                    <!-- HIREK -->
                    <?php include($this->path('tpl_modul_hirek')); ?>

                    <?php include($this->path('tpl_modul_banner_mennyiterazingatlanom')); ?>
                    <?php include($this->path('tpl_modul_banner_befektetoknek')); ?>

                    <!-- BANNER -->
                    <?php include($this->path('tpl_modul_banner_berbeadoknak')); ?>
                    <!-- REFERENSEK DOBOZ -->
                    <?php //include($this->path('tpl_modul_referenscontact')); ?>

                </aside>        
            </div> <!-- SIDEBAR END -->

        </div>
    </div>
</div>