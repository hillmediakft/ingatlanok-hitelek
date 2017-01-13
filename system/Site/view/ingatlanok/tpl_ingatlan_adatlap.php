<div class="center">
    <div class="container">
        <div class="row">
            <!-- BEGIN PROPERTY DETAILS-->
            <div class="datasheet">
                <div class="row">
                    <div class="col-md-7">
                        <h1 class="property__title"><?php echo $this->property_data['ingatlan_nev']; ?>
                            <span class="property__city">
                                <?php
                                echo $this->property_data['city_name'];
                                echo (isset($this->property_data['kerulet'])) ? ', ' . $this->property_data['district_name'] . ' kerület' : '';
                                echo ($this->property_data['utca_megjelenites'] == 1) ? ', ' . $this->property_data['utca'] : '';
                                echo ($this->property_data['hazszam_megjelenites'] == 1) ? ' ' . $this->property_data['hazszam'] : '';
                                ?>
                            </span>
                        </h1>
                        <div class="property__price">
                            <strong> 
                                <?php echo ($this->property_data['tipus'] == 1) ? 'Ár: ' . number_format($this->property_data['ar_elado'], 0, ',', '.') : 'Bérleti díj: ' . number_format($this->property_data['ar_kiado'], 0, ',', '.'); ?> Ft
                            </strong>
                        </div>
                        <div class="social social--properties">
                            <div id="kedvencek_<?php echo $this->property_data['id']; ?>" data-id="<?php echo $this->property_data['id']; ?>" class="properties__favourite_datasheet <?php echo (Cookie::is_id_in_cookie('kedvencek', $this->property_data['id'])) ? 'selected-favourite' : ''; ?>"> <i class="fa fa-heart"></i>
                            </div>
                        </div>
                        <div class="clearfix"></div>



                        <section id="slider-section">
                            <?php if ($this->property_data['kepek'] == null) { ?> 
                                <div class="alert alert-info">Az ingatlanhoz nincsenek megjeleníthető képek!</div>
                            <?php } ?> 
                            <?php if ($this->property_data['kepek']) { ?>
                                <div id="flex-slider" class="flexslider">
                                    <div class="property__ribon"><?php echo ($this->property_data['tipus'] == 1) ? 'Eladó' : 'Kiadó'; ?></div>
                                    <ul class="slides">
                                        <?php foreach ($this->photos as $value) { ?>            
                                            <li>
                                                <img src="<?php echo Config::get('ingatlan_photo.upload_path') . $value; ?>" />
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div id="flex-carousel" class="flexslider">
                                    <ul class="slides">
                                        <?php foreach ($this->photos as $value) { ?> 
                                            <li>
                                                <img alt="" src="<?php echo Config::get('ingatlan_photo.upload_path') . $value; ?>">
                                            </li>

                                        <?php } ?>
                                    </ul>
                                </div><!-- #carousel -->
                            <?php } ?>
                        </section>






<!--
                        <?php if ($this->property_data['kepek'] == null) { ?> 
                            <div class="alert alert-info">Az ingatlanhoz nincsenek megjeleníthető képek!</div>
                        <?php } ?>  
                        <?php if ($this->property_data['kepek']) { ?>
                            <div class="property__slider">
                                <div class="property__ribon"><?php echo ($this->property_data['tipus'] == 1) ? 'Eladó' : 'Kiadó'; ?></div>
                                <div id="properties-banner" class="slider slider--small">
                                    <div class="slider__block js-slick-slider">
                                        <?php foreach ($this->photos as $value) { ?>
                                            <div class="slider__item">
                                                <div class="slider__img"><img data-lazy="<?php echo Config::get('ingatlan_photo.upload_path') . '/' . $value; ?>" src="<?php echo Config::get('ingatlan_photo.upload_path') . '/' . $value; ?>" alt=""></div>
                                            </div>
                                        <?php } ?>

                                    </div>
                                    <div class="slider__controls">
                                        <button type="button" class="slider__control slider__control--prev js-slick-prev">
                                            <svg class="slider__control-icon">
                                            <use xlink:href="#icon-arrow-left"></use>
                                            </svg>
                                        </button><span class="slider__current js-slick-current">1 /</span><span class="slider__total js-slick-total">9</span>
                                        <button type="button" class="slider__control slider__control--next js-slick-next">
                                            <svg class="slider__control-icon">
                                            <use xlink:href="#icon-arrow-right"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?> -->

                    </div> 

                    <!-- end of block .property-->
                    <!-- END PROPERTY DETAILS-->
                    <!-- BEGIN SIDEBAR-->
                    <div class="col-md-5">


                        <!-- BEGIN WORKER SIDEBAR-->


                        <!-- BEGIN SECTION ARTICLE-->
                        <section class="article">
                            <!-- end of block .article__header-->
                            <div class="article__list">
                                <div class="article__item">

                                    <div class="property__info">
                                        <div class="property__id"><span class="alert alert-info"><?php echo ($this->property_data['tipus'] == 1) ? 'Eladó' : 'Kiadó'; ?> <?php echo mb_strtolower($this->property_data['kat_nev'], 'UTF-8'); ?></span><span class="alert alert-refid">Ref. szám:<?php echo $this->property_data['id']; ?></span></div>
                                      
                                    </div>
                                    <div class="property__plan">
                                        <dl class="property__plan-item">
                                            <dd class="property__plan-title">Alapterület</dd>
                                            <dd class="property__plan-value"><?php echo $this->property_data['alapterulet']; ?> m<sup>2</sup></dd>
                                        </dl>
                                        <dl class="property__plan-item">
                                            <dd class="property__plan-title">Szobaszám</dd>
                                            <dd class="property__plan-value"><?php echo $this->property_data['szobaszam']; ?></dd>
                                        </dl>
                                        <dl class="property__plan-item">
                                            <dd class="property__plan-title">Állapot</dd>
                                            <dd class="property__plan-value"><?php echo $this->property_data['all_leiras']; ?></dd>
                                        </dl>
                                    </div>

                                    <div class="property__plan">
                                        <dl class="property__plan-item">
                                            <dd class="property__plan-title">Szerkezet</dd>
                                            <dd class="property__plan-value"><?php echo $this->property_data['szerkezet_leiras']; ?></dd>
                                        </dl>
                                        <dl class="property__plan-item">
                                            <dd class="property__plan-title">Fűtés</dd>
                                            <dd class="property__plan-value"><?php echo $this->property_data['futes_leiras']; ?></dd>
                                        </dl>
                                        <dl class="property__plan-item">
                                            <dd class="property__plan-title">Állapot</dd>
                                            <dd class="property__plan-value"><?php echo $this->property_data['all_leiras']; ?></dd>
                                        </dl>
                                    </div>                                   



                                </div>
                                <!-- end of block .article__item-->
                           
                                
                            </div>
                            <!-- end of block .article__list-->
                        </section>
                        <!-- END SECTION ARTICLE-->
                        
                        
                        <?php include SITE . "/view/ingatlanok/tpl_referens_contact_box.php";?>
                        
                        
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-7">

                        <div class="property__params">
                            <h4 class="property__subtitle">Jellemzők:</h4>
                            <table class="table table-striped property-table">
                                <tbody>
                                    <tr>
                                        <td><strong>Típus</strong></td>
                                        <td><?php echo ($this->property_data['tipus'] == 1) ? 'Eladó' : 'Kiadó'; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kategória</strong></td>
                                        <td><?php echo $this->property_data['kat_nev']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Méret</strong></td>
                                        <td><?php echo $this->property_data['alapterulet']; ?> m<sup>2</sup></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Szobaszám</strong></td>
                                        <td><?php echo $this->property_data['szobaszam']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Állapot</strong></td>
                                        <td><?php echo $this->property_data['all_leiras']; ?></td>
                                    </tr>
                                    <?php if ($this->property_data['emelet']) : ?>
                                        <tr>
                                            <td><strong>Emelet</strong></td>
                                            <td><?php echo $this->property_data['emelet']; ?></td>
                                        </tr>
                                    <?php endif ?>    
                                    <?php if ($this->property_data['epulet_szintjei']) : ?>
                                        <tr>
                                            <td><strong>Épület szintjei</strong></td>
                                            <td><?php echo $this->property_data['epulet_szintjei']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Lift</strong></td>
                                            <td><?php echo ($this->property_data['lift'] == 1) ? 'van' : 'nincs'; ?></td>
                                        </tr>
                                    <?php endif ?>
                                    <tr>
                                        <td><strong>Bútorozott</strong></td>
                                        <td><?php echo ($this->property_data['butor'] == 1) ? 'igen' : 'nem'; ?></td>
                                    </tr>
                                    <?php if ($this->property_data['futes_leiras']) : ?>
                                        <tr>
                                            <td><strong>Fűtés</strong></td>
                                            <td><?php echo $this->property_data['futes_leiras']; ?></td>
                                        </tr>
                                    <?php endif ?>
                                    <?php if ($this->property_data['energetika_leiras']) : ?>
                                        <tr>
                                            <td><strong>Energetikai tanusítvány</strong></td>
                                            <td><?php echo $this->property_data['energetika_leiras']; ?></td>
                                        </tr>
                                    <?php endif ?>
                                    <?php if ($this->property_data['parkolas_leiras']) : ?>
                                        <tr>
                                            <td><strong>Parkolás</strong></td>
                                            <td><?php echo $this->property_data['parkolas_leiras']; ?></td>
                                        </tr>
                                    <?php endif ?>
                                    <?php if ($this->property_data['kilatas_leiras']) : ?>
                                        <tr>
                                            <td><strong>Kilátás</strong></td>
                                            <td><?php echo $this->property_data['kilatas_leiras']; ?></td>
                                        </tr>
                                    <?php endif ?>
                                    <?php if ($this->property_data['kert_leiras']) : ?>
                                        <tr>
                                            <td><strong>Kert</strong></td>
                                            <td><?php echo $this->property_data['kert_leiras']; ?></td>
                                        </tr>
                                    <?php endif ?>


                                </tbody>
                            </table>
                        </div>
                        <div class="property__params">
                            <h4 class="property__subtitle">Extrák</h4>
                            <ul class="property__params-list property__params-list--options">
                                <?php echo ($this->property_data['erkely']) ? '<li> Erkély</li>' : ''; ?>
                                <?php echo ($this->property_data['terasz']) ? '<li> Terasz</li>' : ''; ?>
                                <?php echo ($this->property_data['medence']) ? '<li> Medence</li>' : ''; ?>
                                <?php echo ($this->property_data['szauna']) ? '<li> Szauna</li>' : ''; ?>
                                <?php echo ($this->property_data['jacuzzi']) ? '<li> Jacuzzi</li>' : ''; ?>
                                <?php echo ($this->property_data['kandallo']) ? '<li>Kandalló</li>' : ''; ?>
                                <?php echo ($this->property_data['riaszto']) ? '<li>Riasztó</li>' : ''; ?>
                                <?php echo ($this->property_data['klima']) ? '<li> Klíma</li>' : ''; ?>
                                <?php echo ($this->property_data['ontozorendszer']) ? '<li> Öntözőrendszer</li>' : ''; ?>
                                <?php echo ($this->property_data['automata_kapu']) ? '<li> Automata kapu</li>' : ''; ?>
                                <?php echo ($this->property_data['elektromos_redony']) ? '<li> Elektromos redőny</li>' : ''; ?>
                                <?php echo ($this->property_data['konditerem']) ? '<li> Konditerem</li>' : ''; ?>
                            </ul>
                        </div>
                        <div class="property__description js-unhide-block">
                            <h4 class="property__subtitle">Leírás</h4>
                            <div class="property__description-wrap">
                                <?php echo $this->property_data['leiras']; ?>
                            </div>
                        </div>
                        <div class="property__files js-unhide-block">
                            <h4 class="property__subtitle">Kapcsolódó dokumentumok:</h4>
                            <a href="#" class="property__files-item">
                                <svg class="property__files-icon">
                                <use xlink:href="#icon-doc"></use>
                                </svg>Pdf adatlap
                            </a>
                            <a href="#" class="property__files-item">
                                <svg class="property__files-icon">
                                <use xlink:href="#icon-doc"></use>
                                </svg>Alaprajz
                            </a>
                        </div>
                        <button type="button" class="property__files-show js-unhide">Dokumentumok</button>
                        <div class="property__map map map--properties">
                            <div class="map__buttons">
                                <button type="button" class="map__change-map js-map-btn active">Térkép</button>
                            </div>
                            <div class="map__wrap">
                                <div data-type="map" class="map__view js-map-canvas"></div>

                            </div>
                        </div>

                    </div>
                    <div class="col-md-5">


                        <!-- BEGIN SECTION ARTICLE-->
                        <section class="article js-unhide-block article--sidebar">
                            <button type="button" class="widget__show js-unhide">Hírek mutatása</button>
                            <div class="article__header">
                                <h3 class="">Hírek, hasznos infók</h3>
                            </div>
                            <!-- end of block .article__header-->
                            <div class="article__list">
                                <div class="article__item">
                                    <div class="article__details"><a href="blog_details.html" class="article__item-title">Változások a hitelezésben</a>
                                        <time datetime="2009-08-29" class="article__time">2016.09.12.</time>
                                        <div class="article__intro">
                                            <p>Aquam est tortor, sagittis in fringilla in, pellent esque nec erat. Aenean semper, neque non faucibus. tortor ...</p>
                                        </div><a href="" class="article__more">Tovább</a>
                                    </div>
                                </div>
                                <!-- end of block .article__item-->
                            </div>
                            <!-- end of block .article__list-->
                        </section>
                        <!-- END SECTION ARTICLE-->
                    </div>
                </div>                

<?php include SITE . "/view/ingatlanok/tpl_hasonlo_ingatlanok.php";?>

            </div>
        </div>
    </div>
    <!-- END CENTER SECTION-->