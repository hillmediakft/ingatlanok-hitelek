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
                                <span class="desc"><?php echo $agent['title_' . LANG]; ?></span>
                                <span class="properties"><?php echo $agent['property'];?> <?php echo Lang::get('referens_ingatlan'); ?></span>
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
                                            <a href="mailto:<?php echo $agent['email']; ?>" class="mail"><?php echo $agent['email']; ?></a>
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
                            <h4 class="column-title"><?php echo Lang::get('referens_cim_bemutatkozas'); ?></h4>
                            <p class="descr-text"><?php echo $agent['description_' . LANG]; ?></p>
                        </div>
                        <div class="question-container">
                            <h4 class="column-title"><?php echo Lang::get('referens_cim_kapcsolat'); ?></h4>
                            <div class="contacts-block" style="padding-bottom: 0px;">
                                <div class="message-form">
                                    <form action="<?php echo (LANG != 'hu') ? LANG . '/' : ''; ?>sendemail/init/agent_info" method="post" id="contact-form-agent">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="text" class="name" name="name" placeholder="<?php echo Lang::get('kapcsolat_email_nev'); ?> *" required oninvalid="this.setCustomValidity('Töltse ki ezt a mezőt!')" oninput="setCustomValidity('')">

                                                <input type="text" name="mezes_bodon" id="mezes_bodon">
                                                <input type="hidden" name="agent_name" value="<?php echo $agent['first_name'] . ' ' . $agent['last_name']; ?>">
                                                <input type="hidden" name="agent_email" value="<?php echo $agent['email']; ?>">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="email" class="email" name="email" placeholder="E-mail *" required oninvalid="this.setCustomValidity('Adjon meg egy email címet!')" oninput="setCustomValidity('')">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" class="phone" name="phone" placeholder="<?php echo Lang::get('kapcsolat_email_telefon'); ?>">
                                            </div>
                                        </div>
                                        <textarea class="message" name="message" placeholder="<?php echo Lang::get('kapcsolat_email_uzenet'); ?> *" required oninvalid="this.setCustomValidity('Töltse ki ezt a mezőt!')" oninput="setCustomValidity('')"></textarea>
                                        <button type="submit" class="send-btn" id="submit-button"><?php echo Lang::get('kapcsolat_email_kuldes'); ?></button>
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
                            <div class="empty-space-20"></div>
                        </div>
                    </div>


                    <?php if ($data['filter_params']['view'] == 'grid') { ?>

                    <!-- INGATALANOK LISTÁJA GRID -->
                    <div class="objects-block with-sidebar">
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

                                                <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.ingatlanok.adatlap.' . LANG) . '/' . $value['id'] . '/' . $this->str_helper->stringToSlug($value['ingatlan_nev_' . LANG]); ?>">
                                                <?php if (!is_null($value['kepek'])) { ?>
                                                    <img src="<?php echo $this->url_helper->thumbPath(Config::get('ingatlan_photo.upload_path') . $photo_array[0], false, 'small'); ?>" alt="<?php echo $value['ingatlan_nev_' . LANG]; ?>">
                                                <?php } else { ?>
                                                    <img src="<?php echo Config::get('ingatlan_photo.upload_path') . 'placeholder.jpg'; ?>" alt="<?php echo $value['ingatlan_nev_' . LANG]; ?>">
                                                <?php } ?>
                                                </a>                                        

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
                                $photo_array = json_decode($value['kepek']);
                            ?>
                            <div class="col-sm-12">
                                <div class="item">
                                    <div class="preview">
                                        <?php $this->html_helper->showLowerPriceIcon($value);?>

                                        <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.ingatlanok.adatlap.' . LANG) . '/' . $value['id'] . '/' . $this->str_helper->stringToSlug($value['ingatlan_nev_' . LANG]); ?>">
                                        <?php if (!is_null($value['kepek'])) { ?>
                                            <img src="<?php echo $this->url_helper->thumbPath(Config::get('ingatlan_photo.upload_path') . $photo_array[0], false, 'small'); ?>" alt="<?php echo $value['ingatlan_nev_' . LANG]; ?>">
                                        <?php } else { ?>
                                            <img src="<?php echo Config::get('ingatlan_photo.upload_path') . 'placeholder.jpg'; ?>" alt="<?php echo $value['ingatlan_nev_' . LANG]; ?>">
                                        <?php } ?>
                                        </a>                                        

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
                                        <span class="item-title"><a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.ingatlanok.adatlap.' . LANG) . '/' . $value['id'] . '/' . $this->str_helper->stringToSlug($value['ingatlan_nev_' . LANG]); ?>"><?php echo $value['ingatlan_nev_' . LANG]; ?></a></span>
                                        <p class="item-text"><p><?php
                                            echo $value['city_name'];
                                            echo (isset($value['kerulet'])) ? ', ' . $value['kerulet'] . ' kerület' : '';
                                            ?></p></p>
                                    </div>
                                </div>
                            </div>       
                            <?php } ?>
                        </div>
                    </div> 

                    <?php } ?>


                    <div class="objects-block with-sidebar">
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
                <div class="col-md-3 col-sm-12">
                    <aside class="sidebar main-sidebar">
                        <!-- KIEMELT INGATLANOK DOBOZ -->
                        <?php include($this->path('tpl_modul_banner_berbeadoknak')); ?>
                        <!-- KIEMELT INGATLANOK DOBOZ -->
                        <?php include($this->path('tpl_modul_banner_befektetoknek')); ?>
                        <!-- KIEMELT INGATLANOK DOBOZ -->
                        <?php include($this->path('tpl_modul_banner_mennyiterazingatlanom')); ?>
                    </aside>        
                </div> <!-- SIDEBAR END -->
            
            </div>
        





  









    </div> <!-- END CONTAINER -->

</div> <!-- END CONTENT -->