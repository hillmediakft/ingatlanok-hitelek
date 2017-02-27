<?php

use System\Libs\Language as Lang; ?>
<div id="content" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumbs">
                    <span class="clickable"><a href="<?php echo $this->request->get_uri('site_url'); ?>"><?php echo Lang::get('menu_kereses'); ?></a></span>
                    <span class="delimiter">/</span>
                    <span class="active-page"><?php echo Lang::get('menu_kereses'); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1><i class="fa fa-search"></i> Részletes keresés</h1>
                <div class="well search-page">
                    <div class="main-filter">

                        <form class="filter-form" action="ingatlanok">
                            <div class="row">
                                <div class="col-sm-12">

                                    <!-- FELSŐ SOR -->
                                    <div class="row">
                                        <fieldset>
                                            <legend>Alap adatok / elhelyezkedés</legend>
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

                                            <div class="col-sm-2">
                                                <span class="item-label"><?php echo Lang::get('kereso_kerulet'); ?></span>
                                                <div id="district_select_div">
                                                    <select name="kerulet[]" id="district_select" class="selectpicker" data-selected-text-format="count" multiple disabled="disabled" title="-- <?php echo Lang::get('kereso_mindegy'); ?> --">
                                                        <!-- <option value="">-- <?php //echo Lang::get('kereso_mindegy');       ?> --</option> -->
                                                        <?php echo $district_list; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- KATEGÓRIA -->
                                            <div class="col-sm-3">
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
                                            
                                            <!-- ÁLLAPOT -->
                                            <div class="col-sm-3">
                                                <?php
                                                $selected_allapot = isset($filter_params['allapot']) ? $filter_params['allapot'][0]['all_id'] : '';
                                                ?>
                                                <span class="item-label"><?php echo Lang::get('jell_allapot'); ?></span>
                                                <div id="category_select_div" class="ui-front">
                                                    <select name="allapot" id="category_select" data-icon="false" class="select filter-select">
                                                        <option value="">-- <?php echo Lang::get('kereso_mindegy'); ?> --</option>
                                                        <?php foreach ($allapot_list as $value) : ?>
                                                            <option value="<?php echo $value['all_id']; ?>" <?php echo ($selected_allapot == $value['all_id']) ? 'selected' : ''; ?>><?php echo $value['all_leiras_' . LANG]; ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>					
                                            </div>                                            
                                            
                                        </fieldset>
                                    </div>

                                    <!-- ALSÓ SOR -->
                                    <div class="row">
                                        <fieldset>
                                            <legend>Ár / alapterület / szobaszám</legend>
                                            
                                            <!-- ÁR -->
                                            <div class="col-sm-3">
                                                <span class="item-label"><?php echo Lang::get('kereso_ar'); ?></span>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input name="min_ar" type="text" class="form-control" placeholder="minimum" value="<?php echo (isset($filter_params['min_ar'])) ? $filter_params['min_ar'] : ''; ?>">                                                       
                                                        <span class="input-group-addon">-</span>
                                                        <input name="max_ar" type="text" class="form-control" placeholder="maximum" value="<?php echo (isset($filter_params['max_ar'])) ? $filter_params['max_ar'] : ''; ?>">
                                                    </div>
                                                </div>
                                            </div>                                            
                                            
                                            
                                            <!-- ALAPTERÜLET -->
                                            <div class="col-sm-3">
                                                <span class="item-label"><?php echo Lang::get('kereso_alapterulet'); ?> (m<sup>2</sup>)</span>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input name="min_alapterulet" type="text" class="form-control" placeholder="minimum" value="<?php echo (isset($filter_params['min_alapterulet'])) ? $filter_params['min_alapterulet'] : ''; ?>">
                                                        <span class="input-group-addon">-</span>
                                                        <input name="max_alapterulet" type="text" class="form-control" placeholder="maximum" value="<?php echo (isset($filter_params['max_alapterulet'])) ? $filter_params['max_alapterulet'] : ''; ?>">
                                                    </div>
                                                </div>
                                            </div>    
                                            
                                            
                                            <!-- SZOBASZÁM -->
                                            <div class="col-sm-3">
                                                <span class="item-label"><?php echo Lang::get('kereso_szobaszam'); ?> (m<sup>2</sup>)</span>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input name="min_szobaszam" type="text" class="form-control" placeholder="minimum" value="<?php echo (isset($filter_params['min_szobaszam'])) ? $filter_params['min_szobaszam'] : ''; ?>">
                                                        <span class="input-group-addon">-</span>
                                                        <input name="max_szobaszam" type="text" class="form-control" placeholder="maximum" value="<?php echo (isset($filter_params['max_szobaszam'])) ? $filter_params['max_szobaszam'] : ''; ?>">
                                                    </div>
                                                </div>
                                            </div>                                              
                                            
	                                       
                                        </fieldset>
                                    </div>


                                    <!-- JELLEMZŐK SOR -->
                                    <div class="row">
                                        <fieldset>
                                            <legend>Jellemzők</legend>


                                            <!-- FŰTÉS -->
                                            <div class="col-sm-3">
                                                <?php
                                                $selected_futes = isset($filter_params['futes']) ? $filter_params['futes'][0]['futes_id'] : '';
                                                ?>
                                                <span class="item-label"><?php echo Lang::get('jell_futes'); ?></span>
                                                <div id="category_select_div" class="ui-front">
                                                    <select name="futes" id="category_select" data-icon="false" class="select filter-select">
                                                        <option value="">-- <?php echo Lang::get('kereso_mindegy'); ?> --</option>
                                                        <?php foreach ($futes_list as $value) : ?>
                                                            <option value="<?php echo $value['futes_id']; ?>" <?php echo ($selected_futes == $value['futes_id']) ? 'selected' : ''; ?>><?php echo $value['futes_leiras_' . LANG]; ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>					
                                            </div>

                                            <!-- SZERKEZET -->
                                            <div class="col-sm-3">
                                                <?php
                                                $selected_szerkezet = isset($filter_params['szerkezet']) ? $filter_params['szerkezet'][0]['szerkezet_id'] : '';
                                                ?>
                                                <span class="item-label"><?php echo Lang::get('jell_szerkezet'); ?></span>
                                                <div id="category_select_div" class="ui-front">
                                                    <select name="szerkezet" id="category_select" data-icon="false" class="select filter-select">
                                                        <option value="">-- <?php echo Lang::get('kereso_mindegy'); ?> --</option>
                                                        <?php foreach ($szerkezet_list as $value) : ?>
                                                            <option value="<?php echo $value['szerkezet_id']; ?>" <?php echo ($selected_szerkezet == $value['szerkezet_id']) ? 'selected' : ''; ?>><?php echo $value['szerkezet_leiras_' . LANG]; ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>					
                                            </div>

                                            <!-- ENERGETKA -->
                                            <div class="col-sm-3">
                                                <?php
                                                $selected_energetika = isset($filter_params['energetika']) ? $filter_params['energetika'][0]['energetika_id'] : '';
                                                ?>
                                                <span class="item-label"><?php echo Lang::get('jell_energetika'); ?></span>
                                                <div id="category_select_div" class="ui-front">
                                                    <select name="energetika" id="category_select" data-icon="false" class="select filter-select">
                                                        <option value="">-- <?php echo Lang::get('kereso_mindegy'); ?> --</option>
                                                        <?php foreach ($energetika_list as $value) : ?>
                                                            <option value="<?php echo $value['energetika_id']; ?>" <?php echo ($selected_energetika == $value['energetika_id']) ? 'selected' : ''; ?>><?php echo $value['energetika_leiras_' . LANG]; ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>					
                                            </div>

                                            <!-- LIFT -->
                                            <div class="col-sm-3">
                                                <?php
                                                $selected_lift = isset($filter_params['lift']) ? $filter_params['lift'] : '';
                                                ?>
                                                <span class="item-label"><?php echo Lang::get('jell_lift'); ?></span>
                                                <div id="lift_select_div" class="ui-front">
                                                    <select name="lift" id="lift_select" data-icon="false" class="select filter-select">
                                                        <option value="">-- <?php echo Lang::get('kereso_mindegy'); ?> --</option>
                                                            <option value="1" <?php echo ($selected_lift == 1) ? 'selected' : ''; ?>><?php echo Lang::get('jell_van'); ?></option>
                                                            <option value="0" <?php echo ($selected_lift === 0) ? 'selected' : ''; ?>><?php echo Lang::get('jell_nincs'); ?></option>
                                                    </select>
                                                </div>					
                                            </div>  

                                            <!-- LIFT -->
                                            <div class="col-sm-3">
                                                <?php
                                                $selected_kilatas = isset($filter_params['kilatas']) ? $filter_params['kilatas'][0]['kilatas_id'] : '';
                                                ?>
                                                <span class="item-label"><?php echo Lang::get('jell_kilatas'); ?></span>
                                                <div id="kilatas_select_div" class="ui-front">
                                                    <select name="lift" id="kilatas_select" data-icon="false" class="select filter-select">
                                                        <option value="">-- <?php echo Lang::get('kereso_mindegy'); ?> --</option>
                                                        <?php foreach ($kilatas_list as $value) : ?>
                                                            <option value="<?php echo $value['kilatas_id']; ?>" <?php echo ($selected_kilatas == $value['kilatas_id']) ? 'selected' : ''; ?>><?php echo $value['kilatas_leiras_' . LANG]; ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>					
                                            </div>   
                                            
                                            <!-- KERT -->
                                            <div class="col-sm-3">
                                                <?php
                                                $selected_kert = isset($filter_params['kert']) ? $filter_params['kert'][0]['kert_id'] : '';
                                                ?>
                                                <span class="item-label"><?php echo Lang::get('jell_kert'); ?></span>
                                                <div id="kilatas_select_div" class="ui-front">
                                                    <select name="kert" id="kert_select" data-icon="false" class="select filter-select">
                                                        <option value="">-- <?php echo Lang::get('kereso_mindegy'); ?> --</option>
                                                        <?php foreach ($kert_list as $value) : ?>
                                                            <option value="<?php echo $value['kert_id']; ?>" <?php echo ($selected_kilatas == $value['kert_id']) ? 'selected' : ''; ?>><?php echo $value['kert_leiras_' . LANG]; ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>					
                                            </div>                                             

                                        </fieldset>
                                    </div>                                    


                                    <div class="row">

                                        <div class="col-sm-2">
                                            <button class="find-now-btn"><?php echo Lang::get('kereso_kereses'); ?></button>
                            <!-- <a href="#" class="visible-xs find-now-btn"><?php //echo Lang::get('kereso_kereses');       ?></a> -->
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </form>                
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>