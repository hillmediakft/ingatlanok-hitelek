<?php
use System\Libs\Config;
use System\Libs\Language as Lang;
?>
<div id="content" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumbs">
                    <span class="clickable"><a href="<?php echo $this->request->get_uri('site_url');?>"><?php echo Lang::get('menu_home'); ?></a></span>
                    <span class="delimiter">/</span>
                    <span class="active-page"><?php echo Lang::get('header_top_profil'); ?></span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="empty-space"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-9 col-sm-8">



                <div class="objects-block list-sidebar">
                    
                    <h1><i class="fa fa-line-chart"></i> <?php echo Lang::get('kovetett_ingatlanok_cim'); ?></h1>

                    <?php if (count($properties) > 0) : ?> 

                        <div id="notification-box-info-changeprice" class="notification-box info">
                            <div class="icon"><i class="fa fa-info"></i></div>
                            <div class="descr"><span class="message"><?php echo Lang::get('profil_infodoboz_kek'); ?></span></div>
                        </div>                         
                        <?php
                        foreach ($properties as $value) {
                            $photo_array = json_decode($value['kepek']);
                            ?>
                            <div class="row" id="followed_item_<?php echo $value['id']; ?>">
                                <div class="col-sm-12">
                                    <div class="item">
                                        <div class="preview">
                                            <?php $this->html_helper->showLowerPriceIcon($value);?>
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
                                                <div class="pull-right buttons">
                                                    <a href="javascript:void();" id="delete_followed_<?php echo $value['id']; ?>" data-id="<?php echo $value['id']; ?>" class="share"><i class="fa fa-trash-o fa-2x"></i></a>
                                                </div>
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
                            </div>
                        <?php } ?>

                    <?php endif ?>

                    <!-- INFO BOX - HA NINCSENEK LISTAELEMEK -->
                    <div id="notification-box-caution-changeprice" class="notification-box caution" <?php echo (count($properties) > 0) ? 'style="display: none;"' : ''; ?>>
                        <div class="icon"><i class="fa fa-info"></i></div>
                        <div class="descr"><span class="message"><?php echo Lang::get('profil_infodoboz_sarga'); ?></span></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="empty-space-25"></div>
                        </div>
                    </div>


                    <h1><i class="fa fa-search"></i> <?php echo Lang::get('mentett_keresesek_cim'); ?></h1>

                    <?php if (count($saved_search) > 0) { ?>

                        <div id="notification-box-info-savedsearch" class="notification-box info">
                            <div class="icon"><i class="fa fa-info"></i></div>
                            <div class="descr"><span class="message"><?php echo Lang::get('profil_infodoboz_kek'); ?></span></div>
                        </div> 

                        <?php foreach ($saved_search as $value) { ?>
                        <div class="saved_search_box" id="saved_search_item_<?php echo $value['id']; ?>">
                            <div class="row" >
                        <!-- 
                                <div class="col-sm-5">
                                    <div class="elem">
                                        <span class="value">Eladó - Családi ház</span>
                                    </div>
                                </div>
                         -->
                                <div class="col-sm-10">
                                    <div class="elem">
                                        <a class="link" href="<?php echo $value['url']; ?>"><?php echo $value['description']; ?></a>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="pull-right buttons elem">
                                        <a href="javascript:void();" id="delete_search_<?php echo $value['id']; ?>" data-id="<?php echo $value['id']; ?>" class="share"><i class="fa fa-trash-o fa-2x"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                    <?php } ?>

                    <!-- INFO BOX - HA NINCSENEK LISTAELEMEK -->
                    <div id="notification-box-caution-savedsearch" class="notification-box caution" <?php echo (count($saved_search) > 0) ? 'style="display: none;"' : ''; ?>>
                        <div class="icon"><i class="fa fa-info"></i></div>
                        <div class="descr"><span class="message"><?php echo Lang::get('profil_infodoboz_sarga'); ?></span></div>
                    </div>


                </div>
            </div>

            <!-- SIDEBAR -->
            <div class="col-md-3 col-sm-4">
                <aside class="sidebar main-sidebar" style="padding-top: 0;">
                    <!-- KERESŐ DOBOZ -->
                    <?php //include($this->path('tpl_ingatlanok_filter')); ?>
                    <!-- REFERENSEK DOBOZ -->
                    <?php //include($this->path('tpl_modul_referenscontact')); ?>
                    <!-- KIEMELT INGATLANOK DOBOZ -->
                    <?php //include($this->path('tpl_modul_kiemeltingatlanok')); ?>
                    <!-- KIEMELT INGATLANOK DOBOZ -->
                    <?php //include($this->path('tpl_modul_banner')); ?>


                    <h1><i class="fa fa-user"></i> <?php echo Lang::get('profil_szerkesztese_cim'); ?></h1>
                        
                        <div class="contacts-block" style="padding-bottom: 20px;">
                            <div class="contact-form">
                                <form action="profile/change_password" method="POST" id="new-password-form">

                                    <div class="form-group">
                                        <label class="control-label" for="password_new"><?php echo Lang::get('profil_uj_jelszo'); ?></label>
                                        <div class="input-group">
                                            <input type="password" name="password_new" class="form-control" id="password_new" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="password_new_again"><?php echo Lang::get('profil_jelszo_megegyszer'); ?></label>
                                        <div class="input-group">
                                            <input type="password" name="password_new_again" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="password_old"><?php echo Lang::get('profil_regi_jelszo'); ?></label>
                                        <div class="input-group">
                                            <input type="password" name="password_old" class="form-control" placeholder="">
                                        </div>
                                    </div>                                    

                                    <button type="submit" class="send-btn style-2"><?php echo Lang::get('profil_kuldes_gomb'); ?></button>

                                </form>
                               
                            </div>
                        </div>

                        <div class="contacts-block">
                            <div class="contact-form">
                                <form action="profile/change_userdata" method="POST" id="new-userdata-form">
                                    
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label class="control-label" for="name"><?php echo Lang::get('profil_felhasznalonev'); ?></label>
                                            <input type="text" class="name" name="name" placeholder="Name" value="<?php echo $user['name']; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label class="control-label" for="email">E-mail</label>
                                            <input type="email" class="email" name="email" placeholder="Email" value="<?php echo $user['email']; ?>">
                                        </div>
                                    </div>

                                    <button type="submit" class="send-btn style-2"><?php echo Lang::get('profil_kuldes_gomb'); ?></button>
                                </form> 
                            </div>
                        </div>

                </aside>        
            </div> <!-- SIDEBAR END -->

        </div>












        
    </div>
</div>