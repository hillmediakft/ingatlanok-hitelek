<?php use System\Libs\Language as Lang; ?>
<div class="widget main-filter-widget gray-bg">
    <div class="widget-entry">
        <div class="filter-label-block">
            <span class="filter-label">Find Your Home</span>
        </div>
        <form action="ingatlanok" class="filter-form">
            
            <!-- ELADÓ/KIADÓ -->
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
                    <div id="tipus_select_div" class="ui-front">
                        <select name="tipus" id="tipus_select" data-icon="false" class="select filter-select">
                            <option <?php echo $selected_elado; ?> value="1"><?php echo Lang::get('kereso_elado'); ?></option>
                            <option <?php echo $selected_kiado; ?> value="2"><?php echo Lang::get('kereso_kiado'); ?></option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- VÁROS LISTA -->
            <div class="row">
                <div class="col-sm-12">
                    <span class="item-label"><?php echo Lang::get('kereso_varos'); ?></span>
                    <div id="varos_select_div" class="ui-front">
                        <select name="varos" id="varos_select" data-icon="false" class="select filter-select">
                            <option value="">-- <?php echo Lang::get('kereso_mindegy'); ?> --</option>
                            <?php echo $city_list; ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- KERÜLET LISTA -->
<!-- 
            <div class="row">
                <div class="col-sm-12">
                    <span class="item-label"><?php //echo Lang::get('kereso_kerulet'); ?></span>
                    <div id="district_select_div" class="ui-front">
                        <select disabled="disabled" name="kerulet" id="district_select" data-icon="false" class="select filter-select">
                            <option value="">-- <?php //echo Lang::get('kereso_mindegy'); ?> --</option>
                            <?php //echo $district_list; ?>
                        </select>
                    </div>
                </div>
            </div>
 -->            
            


<div class="row">
    <div class="col-sm-12">
        <span class="item-label"><?php echo Lang::get('kereso_kerulet'); ?></span>
        <div id="district_select_div">
            <select name="kerulet[]" id="district_select" class="selectpicker" data-selected-text-format="count" multiple disabled="disabled" title="-- <?php echo Lang::get('kereso_mindegy'); ?> --">
                <!-- <option value="">-- <?php //echo Lang::get('kereso_mindegy'); ?> --</option> -->
                <?php echo $district_list; ?>
            </select>
        </div>
    </div>
</div>








            <!-- KATEGÓRIA -->
            <div class="row">
                <div class="col-sm-12">
                    <?php 
                        $selected_kategoria = ($this->request->has_query('kategoria')) ? (int)$this->request->get_query('kategoria') : '';
                    ?>
                    <span class="item-label"><?php echo Lang::get('kereso_kategoria'); ?></span>
                    <div id="category_select_div" class="ui-front">
                        <select name="kategoria" id="category_select" data-icon="false" class="select filter-select">
                            <option value="">-- <?php echo Lang::get('kereso_mindegy'); ?> --</option>
                            <?php foreach ($category_list as $value) : ?>
                                <option value="<?php echo $value['kat_id']; ?>" <?php echo ($selected_kategoria == $value['kat_id']) ? 'selected' : ''; ?>><?php echo $value['kat_nev_' . LANG]; ?></option>
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

                    <?php 
                        $min_terulet = $this->request->has_query('min_alapterulet') ? $this->request->get_query('min_alapterulet') : "";
                        $max_terulet = $this->request->has_query('max_alapterulet') ? $this->request->get_query('max_alapterulet') : "";
                    ?>
                    <div id="terulet_slider_wrapper" data-min="<?php echo $min_terulet; ?>" data-max="<?php echo $max_terulet; ?>">
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








            <!-- BUTTON -->
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





<!-- 

<span class="item-label">Property Type</span>
<div id="select-type-holder3" class="ui-front">
    <select name="prop-select" data-icon="false" class="select filter-select">
        <option selected="selected">Any</option>
        <option>1</option>
        <option>2</option>
        <option>3</option>
    </select>
</div>
 -->