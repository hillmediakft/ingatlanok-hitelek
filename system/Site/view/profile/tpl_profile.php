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

                    <?php if (count($properties) > 0) : ?> 

                    <h1><i class="fa fa-line-chart"></i> Árváltozás értesítésre jelölt ingatlanok</h1>
                        <div class="notification-box info">
                            <div class="icon"><i class="fa fa-info"></i></div>
                            <div class="descr"><span class="message">Ingatlan eltávolításához kattintson a kuka ikonra!</span></div>
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
                    <div class="notification-box caution" <?php echo (count($properties) > 0) ? 'style="display: none;"' : ''; ?>>
                        <div class="icon"><i class="fa fa-info"></i></div>
                        <div class="descr"><span class="message">Jelenleg egyetlen ingatlan árváltozásáról sem kért értesítést!</span></div>
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
                <aside class="sidebar main-sidebar" style="padding-top: 0;">
                    <!-- KERESŐ DOBOZ -->
                    <?php //include($this->path('tpl_ingatlanok_filter')); ?>
                    <!-- REFERENSEK DOBOZ -->
                    <?php //include($this->path('tpl_modul_referenscontact')); ?>
                    <!-- KIEMELT INGATLANOK DOBOZ -->
                    <?php //include($this->path('tpl_modul_kiemeltingatlanok')); ?>
                    <!-- KIEMELT INGATLANOK DOBOZ -->
                    <?php //include($this->path('tpl_modul_banner')); ?>


                    <h1><i class="fa fa-user"></i> Profil adatok szerkesztése</h1>
                        
                        <div class="contacts-block">
                            <h5>Jelszó módosítása</h5>
                            <div class="contact-form">
                                <form action="profile/change_password" method="POST" id="new-password-form">

                                    <div class="form-group">
                                        <label for="password_new">Új jelszó</label>
                                        <div class="input-group">
                                            <input type="password" name="password_new" class="name" id="password_new" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password_new_again">Új jelszó mégegyszer</label>
                                        <div class="input-group">
                                            <input type="password" name="password_new_again" class="name" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password_old">Régi jelszó</label>
                                        <div class="input-group">
                                            <input type="password" name="password_old" class="name" placeholder="">
                                        </div>
                                    </div>                                    




                                    <button type="submit" class="send-btn style-2">Küld</button>

                                </form>
                               
                            </div>
                        </div>

                        <div class="contacts-block">
                            <h5>Felhasználói név vagy e-mail cím módosítása</h5>
                            <div class="contact-form">
                                <form action="profile/change_userdata" method="POST" id="new-userdata-form">
                                    
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="name">Név</label>
                                            <input type="text" class="name" name="name" placeholder="Name" value="<?php echo $user['name']; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="email">E-mail</label>
                                            <input type="email" class="email" name="email" placeholder="Email" value="<?php echo $user['email']; ?>">
                                        </div>
                                    </div>

                                    <button type="submit" class="send-btn style-2">Küld</button>
                                </form> 
                            </div>
                        </div>

                </aside>        
            </div> <!-- SIDEBAR END -->

        </div>












        
    </div>
</div>