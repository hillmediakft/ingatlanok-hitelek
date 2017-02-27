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

        <div class="objects-block with-sidebar">
        <!-- <div class="agency-container listing with-sidebar"> -->
            <div class="row">

                <div class="col-md-9 col-sm-12">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="empty-space"></div>
                        </div>
                    </div>


                    <!-- REFERENS INFÓK -->
                    <div class="agent-single-item">
                        <div class="top">
                            <div class="left">
                                <div class="preview">
                                    <img src="<?php echo Config::get('user.upload_path') . $agent['photo']; ?>" alt="">
                                </div>
                            </div>
                            <div class="middle">
                                <span class="name"><?php echo $agent['first_name'] . ' ' . $agent['last_name']; ?></span>
                                <span class="desc">Ingatlan értékesítő</span>
                                <span class="properties"><?php echo $agent['property'];?> ingatlan</span>
                                <!-- 
                                <div class="social-block">
                                    <ul class="sociable-listing">
                                        <li class="sociable-item">
                                            <a href="#" class="social-icon"><i class="fa fa-facebook"></i></a>
                                        </li>
                                        <li class="sociable-item">
                                            <a href="#" class="social-icon"><i class="fa fa-linkedin"></i></a>
                                        </li>
                                        <li class="sociable-item">
                                            <a href="#" class="social-icon"><i class="fa fa-twitter"></i></a>
                                        </li>
                                        <li class="sociable-item">
                                            <a href="#" class="social-icon"><i class="fa fa-google-plus"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                -->

                            </div>
                            <div class="right">
                                <ul class="contact-listing">
                                    <li>
                                        <div class="item-container">
                                            <span class="icon"><i class="fa fa-phone"></i></span>
                                            <span class="phone"><?php echo $agent['phone']; ?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="item-container">
                                            <span class="icon"><i class="fa fa-envelope"></i></span>
                                            <a href="#" class="mail"><?php echo $agent['email']; ?></a>
                                        </div>
                                    </li>
                                    <!-- 
                                    <li>
                                        <div class="item-container">
                                            <span class="icon"><i class="fa fa-globe"></i></span>
                                            <a href="#" class="site">infoexample.com</a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="item-container">
                                            <span class="icon"><i class="fa fa-skype"></i></span>
                                            <span class="skype">djonekollins</span>
                                        </div>
                                    </li>
                                    -->
                                </ul>
                            </div>
                        </div>
                        <div class="descr">
                            <h4 class="column-title">About Me</h4>
                            <p class="descr-text">Cras pulvinar diam quis neque vehicula, nec mattis ligula suscipit. Nullam eget egestas nibh. Sed pharetra accumsan enim sed tincidunt. Donec sit amet lectus pulvinar, placerat lectus id, dapibus urna. In malesuada tincidunt aliquam. Ut ut congue massa, at dignissim elit. Vestibulum efficitur cursus lectus a tincidunt. Curabitur sagittis, massa id euismod egestas, magna mauris venenatis augue, quis varius nibh erat vitae ligula. Duis sit amet massa nec mi dignissim.</p>
                        </div>
                        <div class="question-container">
                            <h4 class="column-title">Have a Questions?</h4>
                            <div class="contacts-block" style="padding-bottom: 0px;">
                                <div class="message-form">
                                    <form action="#">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="text" class="name" placeholder="Name">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="email" class="email" placeholder="Email">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" class="phone" placeholder="Phone Number">
                                            </div>
                                        </div>
                                        <textarea name="name1" class="message" placeholder="Message *"></textarea>
                                        <button class="send-btn">Send Message</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="empty-space-20"></div>
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

                                            <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.ingatlanok.adatlap.' . LANG) . '/' . $value['id'] . '/' . $this->str_helper->stringToSlug($value['ingatlan_nev_' . LANG]); ?>">
                                            <?php if (!is_null($value['kepek'])) { ?>
                                                <img src="<?php echo $this->url_helper->thumbPath(Config::get('ingatlan_photo.upload_path') . $photo_array[0], false, 'small'); ?>" alt="<?php echo $value['ingatlan_nev_' . LANG]; ?>">
                                            <?php } else { ?>
                                                <img src="<?php echo Config::get('ingatlan_photo.upload_path') . 'placeholder.jpg'; ?>" alt="<?php echo $value['ingatlan_nev_' . LANG]; ?>">
                                            <?php } ?>
                                            </a>

                                            <span class="like">
                                                <i class="fa fa-heart"></i>
                                            </span>
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

                                            <div class="item-info"></div>
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

                <!-- SIDEBAR -->
                <div class="col-md-3 col-sm-12">
                    <aside class="sidebar main-sidebar">
                        <!-- KERESŐ DOBOZ -->
                        <?php //include($this->path('tpl_ingatlanok_filter'));  ?>
                        <!-- KIEMELT INGATLANOK DOBOZ -->
                        <?php include($this->path('tpl_modul_banner')); ?>
                    </aside>        
                </div> <!-- SIDEBAR END -->
            
            </div>
        </div>

    </div> <!-- END CONTAINER -->

</div> <!-- END CONTENT -->