<!-- BEGIN SIDEBAR-->
<div class="sidebar">
    <!-- BEGIN SEARCH-->
    <button type="button" data-toggle-target=".js-search-form" data-toggle-hide="Hide Filter" data-toggle-show="Show Filter" class="button__toggle js-toggle-btn">Szűrés</button>
    <div class="search js-search-form search--sidebar sidebar--listing">
        <div class="container">
            <div class="search__header">
                <h3 class="search__title">Keresés</h3>
                <h4 class="search__headline">Szűkítse a találati listát!</h4>
            </div>
            <!-- end of block .search__header-->
            <form id="search-form" action="ingatlanok" class="search__form">
                <div class="search__row">
                    <div class="search__form-group form-group">
                        <label for="in-contract-type" class="search__form-label control-label">Eladó / kiadó</label>
                        <select id="in-contract-type" name="tipus" data-placeholder="-- válasszon --" class="search__form-control search__form-control--select form-control js-in-select">
                            <option value="1" <?php echo(isset($this->filter['tipus']) && $this->filter['tipus'] == 'Eladó') ? 'selected' : '' ?>>Eladó</option>
                            <option value="2" <?php echo(isset($this->filter['tipus']) && $this->filter['tipus'] == 'Kiadó') ? 'selected' : '' ?>>Kiadó</option>
                        </select>
                    </div>
                    <div class="search__form-group form-group"><span class="search__form-label control-label">Település</span>
                        <div class="dropdown dropdown--select">
                            <button type="button" data-toggle="dropdown" data-placeholder="-- mindegy --" class="dropdown-toggle js-select-checkboxes-btn">-- válasszon --</button>
                            <div class="dropdown-menu js-dropdown-menu js-select-checkboxes">
                                <div class="region-select">
                                    <ul id="region" class="bonsai region-select__list">


                                        <li>
                                            <input id="scom-property-map-1_treeterm_37" type="checkbox" name="varos[]" value="budapest" class="in-checkbox">
                                            <label for="scom-property-map-1_treeterm_37" data-toggle="tooltip" data-placement="top" title="Budapest" class="in-label">Budapest</label>
                                            <ul>
                                                <?php for ($i = 1; $i <= 23; $i++) { ?>
                                                    <li>
                                                        <input id="scom-property-map-1_treeterm_<?php echo $i; ?>" type="checkbox" name="kerulet[]" value="<?php echo $i; ?>" class="in-checkbox" <?php echo (Util::in_filter('kerulet', $i)) ? 'checked' : ''; ?>>
                                                        <label for="scom-property-map-1_treeterm_<?php echo $i; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $i; ?>. kerület" class="in-label"><?php echo $i; ?>. kerület</label>
                                                    </li>
                                                <?php } ?>

                                            </ul>
                                        </li>
                                        <?php $map = 2; ?>
                                        <?php $treeterm = $i; ?>
                                        <?php foreach ($this->city_list as $key => $value) : ?>

                                            <li>
                                                <input id="scom-property-map-<?php echo $map; ?>_treeterm_<?php echo $treeterm; ?>" type="checkbox" name="megye[]" value="<?php echo $key; ?>" class="in-checkbox">
                                                <label for="scom-property-map-<?php echo $map; ?>_treeterm_<?php echo $treeterm; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $key; ?>" class="in-label"><?php echo $key; ?></label>

                                                <ul>
                                                    <?php foreach ($value as $city) { ?>
                                                        <?php $treeterm++; ?>
                                                        <li>
                                                            <input id="scom-property-map-<?php echo $map; ?>_treeterm_<?php echo $treeterm; ?>" type="checkbox" name="varos[]" value="<?php echo $city['city_id']; ?>" class="in-checkbox" <?php echo (Util::in_filter('varos', $city['city_id'])) ? 'checked' : ''; ?>>
                                                            <label for="scom-property-map-<?php echo $map; ?>_treeterm_<?php echo $treeterm; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $city['city_name']; ?>" class="in-label"><?php echo $city['city_name']; ?></label>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                            <?php $map++; ?>
                                        <?php endforeach ?>
                                    </ul>
                                    <div class="region-select__buttons">
                                        <button type="button" class="region-select__btn region-select__btn--reset js-select-checkboxes-reset">Törlés</button>
                                        <button type="button" class="region-select__btn js-select-checkboxes-accept">OK</button>
                                    </div>
                                </div>
                                <!-- end of block .region-select-->
                            </div>
                            <!-- end of block .dropdown-menu-->
                        </div>
                    </div>
                    <div class="search__form-group form-group"><span class="search__form-label control-label">Ingatlan típus</span>
                        <div class="dropdown dropdown--select">
                            <button type="button" data-toggle="dropdown" data-placeholder="---" class="dropdown-toggle js-select-checkboxes-btn">-- válasszon --</button>
                            <div class="dropdown-menu js-dropdown-menu js-select-checkboxes">
                                <ul>
                                    <?php $i = 1; ?>
                                    <?php foreach ($this->ingatlan_kat_list as $value) : ?>
                                        <li>
                                            <input id="kategoria_<?php echo $i; ?>" type="checkbox" name="kategoria[]" class="in-checkbox" value="<?php echo $value['kat_id']; ?>" <?php echo (Util::in_filter('kategoria', $value['kat_id'])) ? 'checked' : ''; ?>>
                                            <label for="kategoria_<?php echo $i; ?>" data-toggle="tooltip" data-placement="left" title="<?php echo $value['kat_nev']; ?>" class="in-label"><?php echo $value['kat_nev']; ?></label>
                                        </li>
                                        <?php $i++; ?>
                                    <?php endforeach ?> 

                                </ul>
                                <!-- end of block .dropdown-menu-->
                            </div>
                        </div>
                    </div>


                    <div class="search__form-group form-group">
                        <label for="range_price" class="search__form-label control-label">Ár</label>
                        <div class="search__ranges">
                            <input id="range_price" name="range_price" class="js-search-range search__ranges-in">
                        </div>
                    </div>
                    <div class="search__form-group form-group">
                        <label for="range_area" class="search__form-label control-label">Alapterület</label>
                        <div class="search__ranges">
                            <input id="range_area" name="range_area" class="js-search-range search__ranges-in">
                        </div>
                    </div>
                    <div class="search__form-group form-group">
                        <label for="range_room" class="search__form-label control-label">Szobák száma</label>
                        <div class="search__ranges">
                            <input id="range_room" name="range_room" class="js-search-range search__ranges-in">
                        </div>
                    </div>
                </div>
                <input id="action" type="hidden" name="action" value="search">
                <div class="search__row search__row--buttons">
                    <div class="search__buttons">
                        <button type="button" class="search__btn search__btn--reset js-form-reset">Töröl</button>
                        <button type="submit" class="search__btn search__btn--action">Keresés</button>
                    </div>
                </div>
            </form>
            <!-- end of block .search__form#search-form-->
        </div>
    </div>
    <!-- END SEARCH-->
    <!-- BEGIN PROPERTIES-->
    <div class="properties js-unhide-block properties--sidebar">
        <button type="button" class="widget__show js-unhide">Kiemelt ingatlanok</button>
        <div class="properties__header">
            <h3 class="properties__title">Kiemelt ingatlanok</h3>
            <!--         <h4 class="properties__headline">Find your apartment or house on the exact key parameters.</h4> -->
        </div>
        <!-- end of block  .properties__header-->
        <div class="properties__list">

            <?php foreach ($this->kiemelt_ingatlanok as $value) { ?>
                <?php $photo_array = json_decode($value['kepek']); ?>
                <div class="properties__item">
                    <div class="properties__thumb"><a href="ingatlanok/adatlap/<?php echo $value['id'] . '/' . Replacer::filterName($value['ingatlan_nev']); ?>" class="item-photo item-photo--static">
                            <?php if ($value['kepek']) { ?>
                                <img src="<?php echo Util::small_path(Config::get('ingatlan_photo.upload_path') . $photo_array[0]); ?>" alt="<?php echo $value['ingatlan_nev']; ?>">
                            <?php } ?>
                            <?php if ($value['kepek'] == null) { ?>
                                <img src="<?php echo Config::get('ingatlan_photo.upload_path') . 'placeholder.jpg'; ?>" alt="<?php echo $value['ingatlan_nev']; ?>">
                            <?php } ?>
                            <figure class="item-photo__hover"><span class="item-photo__more">Részletek</span></figure></a>
                    </div>
                    <!-- end of block .properties__thumb-->
                    <div class="properties__info">
                        
                        <a href="ingatlanok/adatlap/<?php echo $value['id'] . '/' . Replacer::filterName($value['ingatlan_nev']); ?>" class="properties__address">
                            <span class="properties__address-city">
                            <?php
                            echo $value['city_name'];
                            echo (isset($value['kerulet'])) ? ', ' . $value['kerulet'] . ' kerület' : '';
                            ?>
                        </span>
                            <?php echo $value['ingatlan_nev']; ?>
                        </a>
                        <span class="properties__price">
                            <?php echo ($value['tipus'] == 1) ? number_format($value['ar_elado'], 0, ',', '.') : number_format($value['ar_kiado'], 0, ',', '.') ?> Ft
                        </span>
                    </div>
                    <!-- end of block .properties__info-->
                </div>
            <?php } ?>
            <!-- end of block .properties__item-->

        </div>
        <!-- end of block  .properties__list-->
    </div>
    <!-- END PROPERTIES-->

    <!-- BEGIN SECTION ARTICLE-->
    <section class="article js-unhide-block article--sidebar">
        <button type="button" class="widget__show js-unhide">Hírek</button>
        <div class="article__header">
            <h3 class="article__title">Hírek</h3>
            <h4 class="article__headline">hírek az ingatlanok világából.</h4>
        </div>
        <!-- end of block .article__header-->
        <div class="article__list">
            
            <?php foreach ($this->blogs as $value) { ?> 
            <div class="article__item">
                <div class="article__details">
                    <a href="<?php echo $this->registry->site_url . 'blog/' . $value['blog_slug'] . '/' . $value['blog_id']; ?>" class="article__item-title">
                        <?php echo $value['blog_title']; ?>
                    </a>
                    <div class="article__intro">
                        <p><?php echo Util::sentence_trim($value['blog_body'], 1); ?> ...</p>
                    </div><a href="<?php echo $this->registry->site_url . 'blog/' . $value['blog_slug'] . '/' . $value['blog_id']; ?>" class="article__more">Részletek</a>
                </div>
            </div>
            <?php } ?>
            <!-- end of block .article__item-->
        </div>
        <!-- end of block .article__list-->
    </section>
    <!-- END SECTION ARTICLE-->
</div>
<!-- END SIDEBAR-->
<div class="clearfix"></div>

