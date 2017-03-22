<?php
use System\Libs\Config;
use System\Libs\Language as Lang;
?>
<div class="home-banner style-2">
    <div class="container">

        <div class="banner-content">
            <form class="filter-form" action="<?php echo (LANG != 'hu') ? LANG . '/' . Config::get('url.ingatlanok.index.' . LANG) : 'ingatlanok'; ?>">
                <div class="row">
                    <div class="col-sm-12">

                        <!-- FELSŐ SOR -->
                        <div class="row">

                            <!-- ELADÓ/KIADÓ -->
                            <div class="col-sm-2">
                                <span class="item-label"><?php echo Lang::get('kereso_elado'); ?>/<?php echo Lang::get('kereso_kiado'); ?></span>
                                <div id="tipus_select_div" class="ui-front">
                                    <select name="tipus" id="tipus_select" data-icon="false" class="select filter-select">
                                        <option <?php echo (isset($filter_params['tipus']) && $filter_params['tipus'] == 1) ? 'selected' : ''; ?> value="1"><?php echo Lang::get('kereso_elado'); ?></option>
                                        <option <?php echo (isset($filter_params['tipus']) && $filter_params['tipus'] == 2) ? 'selected' : ''; ?> value="2"><?php echo Lang::get('kereso_kiado'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <!-- VÁROS LISTA -->
                            <div class="col-sm-2">
                                <span class="item-label"><?php echo Lang::get('kereso_varos'); ?></span>
                                <div id="varos_select_div" class="ui-front">
                                    <select name="varos" id="varos_select" data-icon="false" class="select filter-select">
                                        <option value="">-- <?php echo Lang::get('kereso_mindegy'); ?> --</option>
                                        <?php echo $city_list; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- KERÜLET LISTA -->
                            <div class="col-sm-2">
                                <span class="item-label"><?php echo Lang::get('kereso_kerulet'); ?></span>
                                <div id="district_select_div">
                                    <select name="kerulet[]" id="district_select" class="selectpicker" data-selected-text-format="count" multiple disabled="disabled" title="-- <?php echo Lang::get('kereso_mindegy'); ?> --">
                                        <!-- <option value="">-- <?php //echo Lang::get('kereso_mindegy'); ?> --</option> -->
                                        <?php echo $district_list; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- KATEGÓRIA -->
                            <div class="col-sm-2">
                                <?php
                                $selected_kategoria = isset($filter_params['kategoria']) ? $filter_params['kategoria'][0]['kat_id'] : '';
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
                            
                            <div class="col-sm-3">
                                <span class="item-label"><?php echo Lang::get('kereso_ar'); ?></span>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input name="min_ar" type="text" class="form-control" placeholder="minimum" value="<?php echo (isset($filter_params['min_ar'])) ? $filter_params['min_ar'] : ''; ?>">
                                        <div class="input-group-addon input-group-addon-hypen" id="ar_min_mertek">-</div>
                                        <input name="max_ar" type="text" class="form-control" placeholder="maximum" value="<?php echo (isset($filter_params['max_ar'])) ? $filter_params['max_ar'] : ''; ?>">
                                        <div class="input-group-addon" id="ar_mertek">M Ft</div>
                                    </div>
                                </div>
                            </div>                            

                            
                            <div class="col-sm-1">
                                <button class="find-now-btn"><i class="fa fa-search"></i></button>
      <!--          <a href="#" class="visible-xs find-now-btn"><?php Lang::get('kereso_kereses');  ?></a> -->
                            </div>                            
                            
                        </div>

                        <!-- ALSÓ SOR 
                        <div class="row">

                           
                            <div class="col-sm-4">
                                <span class="item-label"><?php echo Lang::get('kereso_alapterulet'); ?></span>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input name="min_alapterulet" type="text" class="form-control" placeholder="minimum" value="<?php echo (isset($filter_params['min_alapterulet'])) ? $filter_params['min_alapterulet'] : ''; ?>">
                                        <div class="input-group-addon input-group-addon-hypen">-</div>
                                        <input name="max_alapterulet" type="text" class="form-control" placeholder="maximum" value="<?php echo (isset($filter_params['max_alapterulet'])) ? $filter_params['max_alapterulet'] : ''; ?>">
                                        <div class="input-group-addon">m<sup>2</sup></div>
                                    </div>
                                </div>
                            </div>

                        
                            <div class="col-sm-4">
                                <span class="item-label"><?php echo Lang::get('kereso_ar'); ?></span>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input name="min_ar" type="text" class="form-control" placeholder="minimum" value="<?php echo (isset($filter_params['min_ar'])) ? $filter_params['min_ar'] : ''; ?>">
                                        <div class="input-group-addon input-group-addon-hypen" id="ar_min_mertek">-</div>
                                        <input name="max_ar" type="text" class="form-control" placeholder="maximum" value="<?php echo (isset($filter_params['max_ar'])) ? $filter_params['max_ar'] : ''; ?>">
                                        <div class="input-group-addon" id="ar_mertek">M Ft</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <button class="find-now-btn"><?php echo Lang::get('kereso_kereses'); ?></button>
                <a href="#" class="visible-xs find-now-btn"><?php Lang::get('kereso_kereses');  ?></a>
                            </div>

                        </div> -->
                    </div>

                </div>
            </form>

        </div> <!-- banner content END -->

    </div>
</div>