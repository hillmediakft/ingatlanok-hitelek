<?php use System\Libs\Language as Lang; ?>
<div class="widget main-filter-widget gray-bg">
    <div class="widget-entry">
        <div class="filter-label-block">
            <span class="filter-label">Find Your Home</span>
        </div>
        <form action="ingatlanok" class="filter-form">
            <div class="row">
                <div class="col-sm-12">
                    <?php 
                        $selected_elado = 'selected';
                        $selected_kiado = '';
                        if ($this->request->has_query('tipus')) {
                            $selected_elado = ($this->request->get_query('tipus') == 1) ? 'selected' : '';
                            $selected_kiado = ($this->request->get_query('tipus') == 2) ? 'selected' : '';
                        }
                    ?>
                    <span class="item-label"><?php echo Lang::get('kereso_elado'); ?>/<?php echo Lang::get('kereso_kiado'); ?></span>
                    <div class="form-group">
                        <select name="tipus" id="tipus_select" class="form-control">
                            <option <?php echo $selected_elado; ?> value="1"><?php echo Lang::get('kereso_elado'); ?></option>
                            <option <?php echo $selected_kiado; ?> value="2"><?php echo Lang::get('kereso_kiado'); ?></option>
                        </select>
                    </div> 

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">

                    <span class="item-label"><?php echo Lang::get('kereso_varos'); ?></span>
                    <div class="form-group">
                        <select name="varos" id="varos" class="form-control" >
                            <option value="">-- <?php echo Lang::get('kereso_mindegy'); ?> --</option>
                            <?php echo $city_list; ?>
                        </select>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">

                    <span class="item-label"><?php echo Lang::get('kereso_kerulet'); ?></span>
                    <div class="form-group">
                        <select disabled="disabled" id="district" name="kerulet" class="form-control" >
                            <option value="">-- <?php echo Lang::get('kereso_mindegy'); ?> --</option>
                            <?php echo $district_list; ?>
                        </select>
                    </div>
 
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">

                    <span class="item-label"><?php echo Lang::get('kereso_kategoria'); ?></span>
                    <div class="form-group">
                        <select id="category_select" name="kategoria" class="form-control">
                            <option value="">-- <?php echo Lang::get('kereso_mindegy'); ?> --</option>
                            <?php foreach ($category_list as $value) : ?>
                                <option value="<?php echo $value['kat_id']; ?>"><?php echo $value['kat_nev_' . LANG]; ?></option>
                                <?php endforeach ?>
                        </select>
                    </div>

                </div>
            </div>


<!--
            <div class="row">
                <div class="col-sm-12">

                    <span class="item-label"><?php //echo Lang::get('kereso_min_ar'); ?></span>
                    <div class="form-group">
                        <div class="input-group">
                            <input name="min_ar" type="text" class="form-control">
                            <div class="input-group-addon">Ft</div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">

                    <span class="item-label"><?php //echo Lang::get('kereso_max_ar'); ?></span>
                    <div class="form-group">
                        <div class="input-group">
                            <input name="max_ar" type="text" class="form-control">
                            <div class="input-group-addon">Ft</div>
                        </div>
                    </div>

                </div>
            </div>
-->
            
<div class="empty-space-10"></div>

            <!-- ALAPTERÜLET SLIDER -->
            <div class="row">
                <div class="col-sm-12">
                    <!--
                    <span class="item-label"><?php //echo Lang::get('kereso_alapterulet'); ?></span>
                    <div class="form-group">
                        <div class="input-group">
                            <input name="min_terulet" type="text" class="form-control">
                            <div class="input-group-addon">m<sup>2</sup></div>
                        </div>
                    </div>
                    -->
                    <div id="terulet_slider_wrapper">
                        <span class="item-label"><?php echo Lang::get('kereso_alapterulet'); ?></span>
                        <div class="range-wrap">
                            <div class="range-fields">
                                <input type="text" id="min_terulet" name="min_alapterulet"/>
                                <span class="delimiter"></span>
                                <input type="text" id="max_terulet" name="max_alapterulet"/>
                            </div>
                            <div id="terulet_slider" class="slider"></div>
                            <div class="scale">
                                <span class="min-value"></span>
                                <span class="max-value"></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

<div class="empty-space-30"></div>

            <!-- ÁR SLIDER -->
            <div class="row">
                <div class="col-sm-12">

                    <div id="ar_slider_wrapper">
                        <span class="item-label">Ár</span>
                        <div class="range-wrap">
                            <div class="range-fields">
                                <input type="text" id="min_ar" name="min_ar"/>
                                <span class="delimiter"></span>
                                <input type="text" id="max_ar" name="max_ar"/>
                            </div>
                            <div id="ar_slider" class="slider"></div>
                            <div class="scale">
                                <span class="min-value"></span>
                                <span class="max-value"></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <nav id="rotate_btn_find" class="rotate_btn_find">
                        <button class="find-now-btn"><?php echo Lang::get('kereso_kereses'); ?></button>
                    </nav>
                </div>
            </div>
        </form>
    </div>
</div>