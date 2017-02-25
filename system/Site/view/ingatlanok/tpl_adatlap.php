<?php
use System\Libs\Config;
use System\Libs\Cookie;
use System\Libs\Language as Lang;
?>
<div id="content" class="container-fluid">

    <!-- BREADCRUMBS -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumbs">
                    <span class="clickable"><a href="<?php echo $this->request->get_uri('site_url'); ?>"><?php echo Lang::get('menu_home'); ?></a></span>
                    <span class="delimiter">/</span>
                    <span class="clickable"><a href="<?php echo Config::get('url.ingatlanok.' . LANG); ?>"><?php echo Lang::get('menu_ingatlanok'); ?></a></span>
                    <span class="delimiter">/</span>
                    <span class="active-page">Adatlap</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Szürke doboz felül ingatlan-info-box -->
    <div class="container">
        <div class="row">

            <div class="col-sm-12">
                
                <div class="ingatlan-info-box">
                    
                    <div class="col-sm-5">
                        <h3 class="section-title"><?php echo $ingatlan['ingatlan_nev_' . LANG]; ?></h3>
                        <h5><?php echo $ingatlan['city_name'] . ' ' . $ingatlan['district_name'] . 'kerület'; ?></h5> 
                    </div>

                    <div class="col-sm-3">
                        <h3 class="section-title"><span class="price"><span class="value">
                                    <?php
                                    if ($ingatlan['tipus'] == 1) {
                                        if ($ingatlan['ar_elado_eredeti']) {
                                            echo $this->num_helper->niceNumber($ingatlan['ar_elado']) . ' Ft ' . '<span class="line-through">' . $this->num_helper->niceNumber($ingatlan['ar_elado_eredeti']) . ' Ft</span>';
                                        } else {
                                            echo $this->num_helper->niceNumber($ingatlan['ar_elado']) . ' Ft';
                                        }
                                    } else {
                                        if ($ingatlan['ar_kiado_eredeti']) {
                                            echo $this->num_helper->niceNumber($ingatlan['ar_kiado']) . ' Ft ' . '<span class="line-through">' . $this->num_helper->niceNumber($ingatlan['ar_kiado_eredeti']) . ' Ft</span>';
                                        } else {
                                            echo $this->num_helper->niceNumber($ingatlan['ar_kiado']) . ' Ft';
                                        }
                                    }
                                    ?>
                                </span>
                            </span>
                        </h3>
                        <div class="icon-box">
                            <div class="heading">
                                <div class="icon">
                                    <i class="fa fa-home"></i>
                                </div>
                                <span class="title"><?php echo $ingatlan['kat_nev_' . LANG]; ?></span>
                            </div>
                        </div>
                        <div class="icon-box">
                            <div class="heading">
                                <div class="icon">
                                    <i class="fa fa-map-o"></i>
                                </div>
                                <span class="title"><?php echo $ingatlan['alapterulet']; ?> m<sup>2</sup></span>
                            </div>
                        </div>
                    </div> 

                    <div class="col-sm-4">
                        <div class="agent-box">
                            <div class="agent-image">
                                <img class="img-thumbnail" src="<?php echo Config::get('user.upload_path') . $agent['photo']; ?>">
                            </div>

                            <div class="agent-details">
                                <div class="agent-name">
                                    <h6><?php echo $agent['first_name'] . ' ' . $agent['last_name']; ?></h6>
                                    <div>13. kerületi ingatlanok specialistája</div>
                                </div>
                                <div>Tel: <?php echo $agent['phone']; ?></div>
                                <div class="label label-danger">Hívjon most!</div>
                            </div>
                        </div>   
                    </div>

                </div> <!-- END ingatlan-info-box -->
            
            </div> <!-- END col-sm-12 -->

        </div> <!-- END ROW -->
    </div> <!-- END CONTAINER -->


    <div class="container">
        <div class="row">
            
            <!-- TARTALOM -->
            <div class="col-sm-12 col-md-8">
                <div class="single-item-page">
                    
                    <?php if (!empty($pictures)) { ?>
                        <!-- PHOTO SLIDER -->
                        <div class="row">
                            <div class="col-sm-12">
                                                                <!-- <h3 class="section-title">Retail Space In West Side <span class="price">USD <span class="value">999,000</span></span></h3> -->
                                <div class="item-photos">

                                    <div id="slideshow-main" class="main-slides">
                                        <div id="kedvencek_<?php echo $ingatlan['id']; ?>" class="like <?php echo (Cookie::is_id_in_cookie('kedvencek', $ingatlan['id'])) ? 'active' : ''; ?>">
                                            <i class="fa fa-heart"></i>
                                        </div>

                                        <!-- eladó/kiadó cimke-->                                        
                                        <?php
                                        if ($ingatlan['tipus'] == 1) {
                                            $label = Lang::get('kereso_elado');
                                            $css_class = 'sale';
                                        } else {
                                            $label = Lang::get('kereso_kiado');
                                            $css_class = 'rest';
                                        }
                                        ?>
                                        <span class="item-label <?php echo $css_class; ?>"><?php echo $label; ?></span>

                                        <div class="jcarousel-arrows">
                                            <a href="#" class="prev-slide"><i class="fa fa-angle-left"></i></a>
                                            <a href="#" class="next-slide"><i class="fa fa-angle-right"></i></a>
                                        </div>
                                        <div class="slides-container" id="slides-to-show">
                                            <ul>
                                                <?php foreach ($pictures as $picture) { ?>
                                                    <li>
                                                        <img alt="<?php echo $ingatlan['ingatlan_nev_' . LANG]; ?>" src="<?php echo $this->getConfig('ingatlan_photo.upload_path') . $picture; ?>"/>
                                                    </li>
                                                <?php } ?>
                                            </ul>   
                                        </div>                                  
                                    </div>
                                    <div id="slideshow-carousel" class="main-thumbnail">
                                        <ul id="carousel" class="jcarousel jcarousel-skin-tango">
                                            <?php foreach ($pictures as $picture) { ?>
                                                <li>
                                                    <img alt="<?php echo $ingatlan['ingatlan_nev_' . LANG]; ?>" src="<?php echo $this->getConfig('ingatlan_photo.upload_path') . $picture; ?>"/>
                                                </li>
                                            <?php } ?>                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <!-- 
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="empty-space-25"></div>
                            </div>
                        </div>
                        -->
                    <?php } ?>

                    <!-- DETAIL INFO -->
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- <h4 class="small-section-title">Detail Information</h4> -->
                            <div class="detail-info-block">

                                <div class="column-2">
                                    <div class="info-item">
                                        <span class="label-item"><?php echo Lang::get('jell_azonosito'); ?>:</span>
                                        <span class="value"><?php echo $ingatlan['ref_num']; ?></span>
                                    </div>
                                </div>

                                <div class="column-2">
                                    <div class="info-item">
                                        <span class="label-item"><?php echo Lang::get('jell_tipus'); ?>:</span>
                                        <span class="value"><?php echo ($ingatlan['tipus'] = 1) ? Lang::get('jell_elado') : Lang::get('jell_kiado'); ?></span>
                                    </div>
                                </div>

                                <div class="column-2">
                                    <div class="info-item">
                                        <span class="label-item"><?php echo Lang::get('jell_kategoria'); ?>:</span>
                                        <span class="value"><?php echo $ingatlan['kat_nev_' . LANG]; ?></span>
                                    </div>
                                </div>

                                <div class="column-2">
                                    <div class="info-item">
                                        <span class="label-item"><?php echo Lang::get('jell_alapterulet'); ?>:</span>
                                        <span class="value"><?php echo $ingatlan['alapterulet']; ?> m<sup>2</sup></span>
                                    </div>
                                </div>

                                <?php if (!is_null($ingatlan['telek_alapterulet'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_telek_alapterulet'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['telek_alapterulet']; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['belmagassag'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_belmagassag'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['belmagassag']; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['tajolas'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_tajolas'); ?>:</span>
                                            <span class="value"><?php echo Config::get('orientation.' . LANG . '.' . $ingatlan['tajolas']); ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($ingatlan['erkely'] == 1 && !empty($ingatlan['erkely_terulet'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_erkely'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['erkely_terulet']; ?> m<sup>2</sup></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($ingatlan['terasz'] == 1 && !empty($ingatlan['terasz_terulet'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_terasz'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['terasz_terulet']; ?> m<sup>2</sup></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['szobaszam'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_szobaszam'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['szobaszam']; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['felszobaszam'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_felszobaszam'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['felszobaszam']; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>


                                <?php if (!is_null($ingatlan['kozos_koltseg'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_kozos_koltseg'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['kozos_koltseg']; ?> Ft</span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['rezsi'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_rezsi'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['rezsi']; ?> Ft</span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['szerkezet'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_szerkezet'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['szerkezet_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>                            

                                <?php if (!is_null($ingatlan['allapot'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_allapot'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['all_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>                            
                                <?php } ?>

                                <?php if (!is_null($ingatlan['futes'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_futes'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['futes_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>                                                        
                                <?php } ?>

                                <?php if (!is_null($ingatlan['energetika'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_energetika'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['energetika_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>                                                        
                                <?php } ?>

                                <?php if (!is_null($ingatlan['haz_allapot_belul'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_haz_allapot_belul'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['haz_allapot_belul_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>                                                        
                                <?php } ?>

                                <?php if (!is_null($ingatlan['haz_allapot_kivul'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_haz_allapot_kivul'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['haz_allapot_kivul_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>                                                        
                                <?php } ?>

                                <?php if (!is_null($ingatlan['parkolas'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_parkolas'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['parkolas_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['furdo_wc'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_furdo_wc'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['furdo_wc_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['fenyviszony'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_fenyviszony'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['fenyviszony_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['kilatas'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_kilatas'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['kilatas_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['kert'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_kert'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['kert_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!is_null($ingatlan['szoba_elrendezes'])) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_szoba_elrendezes'); ?>:</span>
                                            <span class="value"><?php echo $ingatlan['szoba_elrendezes_leiras_' . LANG]; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($ingatlan['lift'] == 1) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_lift'); ?>:</span>
                                            <span class="value"><i class="fa fa-check"></i></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($ingatlan['tetoter'] == 1) { ?>
                                    <div class="column-2">
                                        <div class="info-item">
                                            <span class="label-item"><?php echo Lang::get('jell_tetoter'); ?>:</span>
                                            <span class="value"><i class="fa fa-check"></i></span>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>

                    <!-- FEATURES -->
                    <?php if (!empty($features)) { ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- <h4 class="small-section-title">Features</h4> -->
                                <div class="features-info-block">
                                    <?php foreach ($features as $feature) { ?>
                                        <div class="column-2">
                                            <div class="info-item">
                                                <span class="feature-item"><?php echo Lang::get($feature); ?></span>
                                            </div>
                                        </div>
                                    <?php } ?>    
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <!-- LEÍRÁS -->
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="small-section-title">Leírás</h4>
                            <p>
                                <?php echo $ingatlan['leiras_' . LANG]; ?>
                            </p>
                        </div>
                    </div>

                    <?php if ($ingatlan['terkep'] == 1) { ?>
                        <!-- TÉRKÉP -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="small-section-title">Elhelyezkedés</h4>
                            </div>
                            <div class="col-sm-12">
                                <div class="map-container style-2">
                                    <div id="map-banner-canvas" class="map-banner" data-lat="<?php echo $ingatlan['latitude']; ?>" data-lng="<?php echo $ingatlan['longitude']; ?>">
                                        <!-- A main.js file initBannerMap1() metodusa kezeli a térkép megjelenítését -->
                                        <script>
                                            var locations = [['', <?php echo $ingatlan['latitude']; ?>, <?php echo $ingatlan['longitude']; ?>, 'public/site_assets/images/markers/banner-map/1.6.png']];
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="empty-space-25"></div>
                        </div>
                    </div>

                    <!-- HASONLÓ INGATLANOK -->
                    <?php foreach ($hasonlo_ingatlan as $value) {
                        $photo_array = json_decode($value['kepek']);
                        ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="object-slider latest-properties style-2">
                                    <div class="heading">
                                        <h4 class="small-section-title">Similar Properties</h4>
                                        <div class="jcarousel-arrows">
                                            <a href="#" class="prev-slide"><i class="fa fa-angle-left"></i></a>
                                            <a href="#" class="next-slide"><i class="fa fa-angle-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="obj-carousel carousel">
                                        <ul>
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
                                        </ul>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    <?php } ?>

                </div> <!-- single-item-page END -->
            </div>

            <!-- SIDEBAR -->
            <div class="col-sm-12 col-md-4">
                <aside class="sidebar main-sidebar" style="padding-top: 0;">

                    <div class="row">
                        <div class="col-sm-12">
                            <a id="arvaltozas_ertesites" class="simple-btn sm-button filled red <?php echo ($ertesites_arvaltozasrol) ? 'disabled' : ''; ?>" data-id="<?php echo $ingatlan['id']; ?>" href="javascript:void(0);"><i class="fa fa-envelope"></i> Értesítés árváltozásról</a>
                            <a id="kedvencekhez_<?php echo $ingatlan['id']; ?>" data-id="<?php echo $ingatlan['id']; ?>" class="simple-btn sm-button filled red <?php echo (Cookie::is_id_in_cookie('kedvencek', $ingatlan['id'])) ? 'disabled' : ''; ?>" href="javascript:void();"><i class="fa fa-heart"></i> Kedvencekhez</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <a class="simple-btn sm-button filled red" href="#"><i class="fa fa-share"></i> Megosztás</a>
                            <a class="simple-btn sm-button filled red" href="#"><i class="fa fa-print"></i> Nyomtatás</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="widget questions">
                                <div class="heading">
                                    <span class="widget-title">Kapcsolatfelvétel</span>
                                </div>
                                <div class="widget-entry gray-bg">
                                    <div class="questions-form">
                                        <form action="sendemail/init/agent" method="post" id="contact-form-agent">
                                            <input type="text" class="name" name="user_name" placeholder="<?php echo Lang::get('kapcsolat_email_nev'); ?>">
                                            <input type="email" class="email" name="user_email" placeholder="Email">
                                            <input type="text" class="name" name="user_phone" placeholder="<?php echo Lang::get('kapcsolat_email_telefon'); ?>">
                                            <textarea class="message" name="user_message" placeholder="<?php echo Lang::get('kapcsolat_email_uzenet'); ?>"></textarea>
                                            
                                            <input type="text" name="mezes_bodon" id="mezes_bodon">

                                            <input type="hidden" name="agent_name" value="">
                                            <input type="hidden" name="agent_email" value="<?php echo $agent['email']; ?>">
                                            <input type="hidden" name="property_id" value="<?php echo $ingatlan['id']; ?>">
                                            <input type="hidden" name="url" value="<?php echo $this->request->get_uri('current_url'); ?>">

                                            <button type="button" class="send-btn" id="submit-button">Küldés</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php include($this->path('tpl_modul_banner')); ?>

                </aside>
            </div>

        </div>
    </div> <!-- END CONTAINER -->

</div> <!-- Fluid container END -->