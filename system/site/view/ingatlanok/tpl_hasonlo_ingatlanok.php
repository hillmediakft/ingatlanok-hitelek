                <div class="properties properties--similar">
                    <div class="container">
                        <button type="button" class="widget__show js-unhide">Hasonló ingatlanok</button>
                        <header class="properties__header">
                            <h1 class="properties__title">hasonló ingatlanok</h1>
                        </header>
                        <div class="properties__list">
                            <div id="owl-properties" class="owl-carousel owl-theme">

                                <?php foreach ($this->kiemelt_ingatlanok as $value) { ?>
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
                                            </a>
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
                    </div>
                </div>

