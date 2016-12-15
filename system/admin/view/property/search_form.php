<!-- KERESŐ FORM -->
<div class="search-portlet">
    <div class="portlet light bg-inverse">
        <div class="portlet-title">
            <div class="caption"><i class="fa fa-search font-green-haze"></i>
                <span class="caption-subject bold font-green-haze"> Szűrés </span>
            </div>
            <div class="tools">
                <a class="expand" href="javascript:;" data-original-title="" title=""> </a>
            </div>
        </div>
        <div class="portlet-body form" id="search-portlet" style="display:none;">
            <form class="horizontal-form" method="GET" id="property_search_form" action="admin/property">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Ingatlan #id</label>
                                <input type="text" placeholder="" class="form-control input-sm" name="id" id="id">
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Státusz</label>
                                <select name="status" id="status" class="form-control input-sm">
                                    <option value="">-- mindegy --</option>
                                    <option value="1" <?php echo (!empty($this->filter) && ($this->filter['status'] != '') && $this->filter['status'] == 1) ? 'selected' : '';?>>Aktív</option>
                                    <option value="0" <?php echo (!empty($this->filter) && ($this->filter['status'] != '') && $this->filter['status'] == 0) ? 'selected' : '';?>>Inaktív</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Kiemelés</label>
                                <select name="kiemeles" id="kiemeles" class="form-control input-sm">
                                    <option value="">-- mindegy --</option>
                                    <option value="1" <?php echo (!empty($this->filter) && ($this->filter['kiemeles'] != '') && $this->filter['kiemeles'] == 1) ? 'selected' : '';?>>Kiemelt</option>
                                    <option value="0" <?php echo (!empty($this->filter) && ($this->filter['kiemeles'] != '') && $this->filter['kiemeles'] == 0) ? 'selected' : '';?>>Nem kiemelt</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Referens</label>
                                <select name="ref_id" id="ref_id" class="form-control input-sm">
                                    <option value="">-- mindegy --</option>
                                    <?php foreach ($this->users as $value) { ?>
                                        <option value="<?php echo $value['user_id']; ?>" <?php echo (!empty($this->filter['ref_id']) && $this->filter['ref_id'] == $value['user_id']) ? 'selected' : '';?>><?php echo $value['user_first_name'] . ' ' . $value['user_last_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Eladó / kiadó</label>
                                <select name="tipus" id="tipus" class="form-control input-sm">
                                    <option value="">-- mindegy --</option>
                                    <option value="1" <?php echo (!empty($this->filter) && ($this->filter['tipus'] != '') && $this->filter['tipus'] == 1) ? 'selected' : '';?>>Eladó</option>
                                    <option value="2" <?php echo (!empty($this->filter) && ($this->filter['tipus'] != '') && $this->filter['tipus'] == 2) ? 'selected' : '';?>>Kiadó</option>

                                </select>
                            </div>
                        </div>
                        <!--/span-->

                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Ingatlan fajta</label>
                                <select name="kategoria" id="kategoria" class="form-control input-sm">
                                    <option value="">-- mindegy --</option>
                                    <?php foreach ($this->ingatlan_kat_list as $value) { ?>
                                        <option value="<?php echo $value['kat_id']; ?>" <?php echo (!empty($this->filter) && ($this->filter['kategoria'] != '') && $this->filter['kategoria'] == $value['kat_id']) ? 'selected' : '';?>><?php echo $value['kat_nev']; ?></option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-2">
                            <div class="form-group" id="megye_div">
                                <label for="megye" class="control-label">Megye</label>
                                <select name="megye" id="megye_select" class="form-control input-sm">
                                    <option value="">-- mindegy --</option>
                                    <?php foreach ($this->county_list as $value) { ?>
                                        <option value="<?php echo $value['county_id']; ?>" <?php echo (!empty($this->filter) && ($this->filter['megye'] != '') && $this->filter['megye'] == $value['county_id']) ? 'selected' : '';?>><?php echo $value['county_name']; ?></option>
                                    <?php } ?>
                                </select>

                            </div>
                        </div>

                        <!-- VÁROS MEGADÁSA -->
                        <div class="col-md-2">

                            <div class="form-group" id="varos_div">
                                <label for="varos" class="control-label">Város</label>
                                <select name="varos" id="varos_select" class="form-control input-sm">

                                </select>
                            </div>	
                        </div>
                        <!-- KERÜLET MEGADÁSA -->
                        <div class="col-md-2">
                            <div class="form-group" id="district_div">
                                <label for="kerulet" class="control-label">Kerület <span></span></label>
                                <select name="kerulet" id="district_select" class="form-control input-sm" disabled>
                                    <option value="">-- mindegy --</option>
                                    <?php foreach ($this->district_list as $value) { ?>
                                        <option value="<?php echo $value['district_id']; ?>"><?php echo $value['district_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>


                    </div>
                    <!--/row-->
                    <!-- *********** kereső doboz 2. sor **************** -->

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Minimum ár</label>
                                <input type="text" class="form-control input-sm" name="min_ar" id="min_ar" value="<?php echo (!empty($this->filter) && ($this->filter['min_ar'] != '')) ? $this->filter['min_ar'] : '';?>">
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Maximum ár</label>
                                <input type="text" placeholder="" class="form-control input-sm" name="max_ar" id="max_ar" value="<?php echo (!empty($this->filter) && ($this->filter['max_ar'] != '')) ? $this->filter['max_ar'] : '';?>">
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Min. szobaszám</label>
                                <select name="szobaszam" id="szobaszam" class="form-control input-sm">
                                    <option value="">-- mindegy --</option>
                                    <option value="1" <?php echo (!empty($this->filter) && ($this->filter['szobaszam'] != '') && $this->filter['szobaszam'] == 1) ? 'selected' : '';?>>1</option>
                                    <option value="2" <?php echo (!empty($this->filter) && ($this->filter['szobaszam'] != '') && $this->filter['szobaszam'] == 2) ? 'selected' : '';?>>2</option>
                                    <option value="3" <?php echo (!empty($this->filter) && ($this->filter['szobaszam'] != '') && $this->filter['szobaszam'] == 3) ? 'selected' : '';?>>3</option>
                                    <option value="4" <?php echo (!empty($this->filter) && ($this->filter['szobaszam'] != '') && $this->filter['szobaszam'] == 4) ? 'selected' : '';?>>4</option>
                                    <option value="5" <?php echo (!empty($this->filter) && ($this->filter['szobaszam'] != '') && $this->filter['szobaszam'] == 5) ? 'selected' : '';?>>5</option>
                                    <option value="6" <?php echo (!empty($this->filter) && ($this->filter['szobaszam'] != '') && $this->filter['szobaszam'] == 6) ? 'selected' : '';?>>6</option>
                                    <option value="7" <?php echo (!empty($this->filter) && ($this->filter['szobaszam'] != '') && $this->filter['szobaszam'] == 7) ? 'selected' : '';?>>7</option>
                                    <option value="8" <?php echo (!empty($this->filter) && ($this->filter['szobaszam'] != '') && $this->filter['szobaszam'] == 8) ? 'selected' : '';?>>8</option>
                                    <option value="9" <?php echo (!empty($this->filter) && ($this->filter['szobaszam'] != '') && $this->filter['szobaszam'] == 9) ? 'selected' : '';?>>9</option>
                                    <option value="10" <?php echo (!empty($this->filter) && ($this->filter['szobaszam'] != '') && $this->filter['szobaszam'] == 10) ? 'selected' : '';?>>10</option>
                                </select>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Min. terület</label>
                                <input type="text" class="form-control input-sm" name="min_alapterulet" id="min_alapterulet" value="<?php echo (!empty($this->filter) && ($this->filter['min_alapterulet'] != '')) ? $this->filter['min_alapterulet'] : '';?>">
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Max. terület</label>
                                <input type="text" placeholder="" class="form-control input-sm" name="max_alapterulet" id="max_alapterulet" value="<?php echo (!empty($this->filter) && ($this->filter['max_alapterulet'] != '')) ? $this->filter['max_alapterulet'] : '';?>">
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Tulajdonos</label>
                                <input type="text" placeholder="" class="form-control input-sm" name="tulaj_nev" id="tulaj_nev" value="<?php echo (!empty($this->filter) && ($this->filter['tulaj_nev'] != '')) ? $this->filter['tulaj_nev'] : '';?>">
                            </div>
                        </div>
                    </div>
                    <!--/row-->


                </div>
                
                <input type="hidden" name="action" value="search">
                <div class="form-actions right">
                    <button class="btn default btn-sm" id="reset_search_form" type="button">Törlés</button>
                    <button class="btn blue btn-sm" name="search_submit" type="submit"><i class="fa fa-check"></i> Keresés</button>
                </div>
            </form>

        </div>
    </div>
</div><!-- KERESŐ FORM END-->