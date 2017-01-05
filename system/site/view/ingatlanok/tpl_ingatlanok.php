<div class="center">
    <div class="container">
        <div class="row">
            <!-- BEGIN LISTING-->
            <div class="listing listing--properties-list">
                <header class="listing__header">
                    <h1 class="listing__title">Ingatlanok</h1>
                    <h5 class="listing__headline">Találatok száma:<strong> <?php echo $this->filtered_count; ?></strong> | Összes ingatlan: <strong><?php echo $this->no_of_properties; ?></strong></h5>
                </header>
                <div class="listing__offset"></div>
                <button type="button" data-toggle-target=".js-search-form" data-toggle-hide="Szűrő elrejtése" data-toggle-show="Szűrő mutatása" class="button__toggle listing__search-toggle js-toggle-btn">Szűrés</button>
                <div class="listing__panel listing__panel--filter js-listing-filter">
                    <div class="listing__filter">
                        <div class="listing__sort">
                            <div class="form-group">
                                <label for="in-listing-sort" class="control-label listing__filter-label">Sorrend:</label>
                                <!--div.listing__sort-wrap-->
                                <select id="in-listing-sort" class="form-control js-in-select">
                                    <option value="<?php echo Util::add_order_to_url('desc', 'ar'); ?>">Legfrissebb elöl</option>
                                    <option value="<?php echo Util::add_order_to_url('asc', 'ar'); ?>">Legrégebbi elöl</option>
                                    <option value="<?php echo Util::add_order_to_url('desc', 'ar'); ?>">Legdrágább elöl</option>
                                    <option value="<?php echo Util::add_order_to_url('asc', 'ar'); ?>">Legolcsóbb elöl</option>

                                </select>
                            </div>
                        </div>
                        <!--end of block .listing__sort-->

                        <!--end of block .listing__view-->
                        <div class="listing__show">
                            <button id="reset-filter" class="button__default button__default--reset ui__button reset-filter-button">Szűrés törlése</button>
                        </div>
                        <!--end of block .listing__show-->
                    </div>
                </div>

                <!-- FILTER -->
                <?php include SITE . '/view/ingatlanok/tpl_ingatlanok_filter.php'; ?>
                <!-- END FILTER -->

                <!--end of block .listing__param-->
                <div class="listing__main">
                    <?php if (count($this->all_property) > 0) { ?>
                        <div class="properties properties--grid">
                            <div class="properties__list">

                                <?php foreach ($this->all_property as $value) { ?>
                                    <?php $photo_array = json_decode($value['kepek']); ?>
                                    <div class="properties__item">
                                        <div class="properties__thumb">
                                            <a href="ingatlanok/adatlap/<?php echo $value['id'] . '/' . Replacer::filterName($value['ingatlan_nev']); ?>" class="item-photo">
                                                <?php if ($value['kepek']) { ?>
                                                    <img src="<?php echo Util::small_path(Config::get('ingatlan_photo.upload_path') . $photo_array[0]); ?>" alt="<?php echo $value['ingatlan_nev']; ?>">
                                                <?php } ?>
                                                <?php if ($value['kepek'] == null) { ?>
                                                    <img src="<?php echo Config::get('ingatlan_photo.upload_path') . 'placeholder.jpg'; ?>" alt="<?php echo $value['ingatlan_nev']; ?>">
                                                <?php } ?>
                                                <span class="properties__category"><?php echo($value['kat_nev']); ?></span>
                                            </a>
                                            <div id="kedvencek_<?php echo $value['id']; ?>" data-id="<?php echo $value['id']; ?>" class="properties__favourite <?php echo (Cookie::is_id_in_cookie('kedvencek', $value['id'])) ? 'selected-favourite' : ''; ?>">
                                                <i class="fa fa-heart"></i>
                                            </div>
                                            <span class="properties__ribon"><?php echo($value['tipus'] == 1) ? 'Eladó' : 'Kiadó'; ?></span>

                                        </div>
                                        <!-- end of block .properties__thumb-->
                                        <div class="properties__info">
                                            <a href="ingatlanok/adatlap/<?php echo $value['id'] . '/' . Replacer::filterName($value['ingatlan_nev']); ?>" class="properties__address">
                                                <span class="properties__address-street"><?php echo $value['ingatlan_nev']; ?></span>
                                                <span class="properties__address-city">
                                                    <?php
                                                    echo $value['city_name'];
                                                    echo (isset($value['kerulet'])) ? ', ' . $value['kerulet'] . ' kerület' : '';
                                                    ?>
                                                </span>
                                            </a>
                                            <a href="ingatlanok/adatlap/<?php echo $value['id'] . '/' . Replacer::filterName($value['ingatlan_nev']); ?>" class="properties__more">Részletek <i class="fa fa-chevron-right"></i></a>
                                            <!-- end of block .properties__param--><span class="properties__price"><?php echo ($value['tipus'] == 1) ? number_format($value['ar_elado'], 0, ',', '.') : number_format($value['ar_kiado'], 0, ',', '.') ?> Ft</span>
                                        </div>
                                        <!-- end of block .properties__info-->
                                    </div>
                                <?php } ?>
                                <!-- end of block .properties__item-->


                            </div>
                        </div>
                    <?php } ?>
                    <?php if (count($this->all_property) == 0) : ?>
                        <div class="listing__empty">

                            <h4 class="listing__empty-title"><i class="fa fa-exclamation-circle"></i> A keresési feltételeknek egyetlen ingatlan sem felel meg!</h4><span class="listing__empty-headline">
                                Bővítse a szűkítési paramétereket.</span>
                        </div>
                    <?php endif ?>
                </div>
                <div class="listing__footer">
                    <!-- BEGIN PAGINATION-->
                    <nav class="listing__pagination">
                        <?php echo $this->pagine_links; ?>
                    </nav>
                    <!-- END PAGINATION-->
                </div>
            </div>
            <!-- END LISTING-->
            <!-- SIDEBAR -->
            <?php include SITE . '/view/ingatlanok/tpl_ingatlanok_sidebar.php'; ?>
            <!-- END SIDEBAR-->
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- END CENTER SECTION-->

