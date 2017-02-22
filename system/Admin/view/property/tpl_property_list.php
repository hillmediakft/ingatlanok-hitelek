    <div class="page-content">

        <div class="row">
            <div class="col-md-12">

                <!-- ÜZENETEK MEGJELENÍTÉSE -->
                <div id="ajax_message"></div> 						
                <?php $this->renderFeedbackMessages(); ?>				

                <div class="portlet portlet-datatable">
                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-list"></i>Ingatlanok listája</div>
                        <div class="actions">

                            <a href="admin/property/insert" class="btn blue btn-sm"><i class="fa fa-plus"></i> Új ingatlan</a>

                            <button id="show_filter_td" class="btn btn-sm grey-cascade" title="Szűrési feltételek megjelenítése"><i class="fa fa-search"></i> Szűrési feltételek</button>

                            <!-- <a href="admin/property" class="btn blue-madison btn-sm"><i class="fa fa-repeat"></i> Szűrés törlése</a> -->
                            <!-- <button class="btn red btn-sm" name="delete_property_submit" value="submit" type="submit"><i class="fa fa-trash"></i> Csoportos törlés</button> -->
                            <div class="btn-group">
                                <a data-toggle="dropdown" href="#" class="btn btn-sm default">
                                    <i class="fa fa-wrench"></i> Eszközök <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="#" id="print_property"><i class="fa fa-print"></i> Nyomtat </a>
                                    </li>
                                    <li>
                                        <a href="admin/report/property" id="export_property"><i class="fa fa-file-excel-o"></i> Export XLS </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                    
<!-- *************************** INGATLANOK TÁBLA *********************************** -->		
                        <div class="table-container">
                            
                            <div class="table-actions-wrapper">
                                <span>
                                </span>
                                <select class="table-group-action-input form-control input-inline input-small input-sm">
                                    <option value="">Válasszon</option>
                                    <option value="group_make_active">Aktív</option>
                                    <option value="group_make_inactive">Inaktív</option>
                                    <option value="group_make_highlight">Kiemelés</option>
                                    <option value="group_delete_highlight">Kiemelés törlése</option>
                                    <option value="group_delete">Töröl</option>

                                    <?php if ($is_superadmin) { ?>
                                        <optgroup label="Áthelyezés referenshez">
                                            <?php foreach ($users as $user) { ?>
                                                <option value="<?php echo $user['first_name'] . ' ' . $user['last_name'] . '@' . $user['id']; ?>"><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></option>
                                            <?php } ?>
                                        </optgroup>
                                    <?php } ?>


                                </select>
                                <button class="btn btn-sm grey-cascade table-group-action-submit" title="Csoportos művelet végrehajtása"><i class="fa fa-check"></i> Csoportművelet</button>
                            </div>


                            <table class="table table-striped table-bordered table-hover table-checkable" id="property">
                            
                                <thead>

                                    <tr role="row" class="heading">
                                        <th width="1%">
                                            <input type="checkbox" class="group-checkable" data-set="#property .checkboxes"/>
                                        </th>
                                        <th width="1%" title="Az ingatlan azonosító száma">id</th>

                                        <th width="1%" title="Az ingatlan referencia száma">ref.szám</th>
                                        
                                        <th width="1%">Kép</th>
                                        <?php if($is_superadmin) { ?>
                                        <th width="1%">Referens</th>
                                        <?php } ?>
                                        <th width="1%">Típus</th>
                                        <th width="1%">Kategória</th>
                                        <th>Város</th>
                                        <th width="1%">m<sup>2</sup></th>
                                        <th width="1%"><i class="fa fa-eye"></i></th>
                                        <th width="1%">Ár(Ft)</th>
                                        <th width="1%"></th>
                                        <th width="1%"></th>
                                    </tr>

                                    <tr role="row" class="filter">
                                        <td colspan="<?php echo ($is_superadmin === true) ? '13' : '12'; ?>" id="filter_td" style="display:none;">
                                            
                                            <div class="portlet">
                                                
                                            <!--
                                                <div class="portlet-title">
                                                    <div class="caption">
                                                        <i class="fa fa-gift"></i>Szűrés
                                                    </div>
                                                    <div class="tools">
                                                        <a href="javascript:;" class="expand"> </a>
                                                    </div>
                                                </div>
                                            -->    
                                                <!-- display-hide -->
                                                <div class="portlet-body" style="padding:0px 6px 0px 6px;">
                                                
                                                    <div class="row">

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="ref_num" class="control-label">Referenciaszám</label>
                                                                <input type="text" class="form-control form-filter input-sm" name="ref_num" id="ref_num">                            
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="status" class="control-label">Státusz</label>
                                                                <select name="status" class="form-control form-filter input-sm">
                                                                    <option value="">-- mindegy --</option>
                                                                    <option value="1">Aktív</option>
                                                                    <option value="0">Inaktív</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="kiemeles" class="control-label">Kiemelés</label>
                                                                <select name="kiemeles" id="kiemeles" class="form-control form-filter input-sm">
                                                                    <option value="">-- mindegy --</option>
                                                                    <option value="1">Kiemelt</option>
                                                                    <option value="0">Nem kiemelt</option>
                                                                </select> 
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="ref_id" class="control-label">Referens</label>
                                                                <select name="ref_id" id="ref_id" class="form-control form-filter input-sm">
                                                                    <option value="">-- mindegy --</option>
                                                                    <?php foreach ($users as $user) { ?>
                                                                    <option value="<?php echo $user['id']; ?>"><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>                    

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class="control-label">Eladó / kiadó</label>
                                                                <select name="tipus" id="tipus" class="form-control form-filter input-sm">
                                                                    <option value="">-- mindegy --</option>
                                                                    <option value="1" selected>Eladó</option>
                                                                    <option value="2">Kiadó</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class="control-label">Ingatlan fajta</label>
                                                                <select class="form-control form-filter input-sm" name="kategoria" id="kategoria">
                                                                    <option value="">-- mindegy --</option>
                                                                    <?php foreach ($ingatlan_kat_list as $kategoria) { ?>
                                                                        <option value="<?php echo $kategoria['kat_id']; ?>"><?php echo $kategoria['kat_nev_hu']; ?></option>
                                                                    <?php } ?>
                                                                </select>                              
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group" id="megye_div">
                                                                <label for="megye" class="control-label">Megye</label>
                                                                <select name="megye" id="megye_select" class="form-control form-filter input-sm">
                                                                    <option value="">-- mindegy --</option>
                                                                    <?php foreach ($county_list as $county) { ?>
                                                                        <option value="<?php echo $county['county_id']; ?>" <?php echo (!empty($filter) && ($filter['megye'] != '') && $filter['megye'] == $county['county_id']) ? 'selected' : '';?>><?php echo $county['county_name']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group" id="varos_div">
                                                                <label for="varos" class="control-label">Város</label>
                                                                <select name="varos" id="varos_select" class="form-control form-filter input-sm">
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group" id="district_div">
                                                                <label for="kerulet" class="control-label">Kerület <span></span></label>
                                                                <select name="kerulet" id="district_select" class="form-control form-filter input-sm" disabled>
                                                                    <option value="">-- mindegy --</option>
                                                                    <?php foreach ($district_list as $district) { ?>
                                                                        <option value="<?php echo $district['district_id']; ?>"><?php echo $district['district_name']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    
                                                    <div class="row">

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class="control-label">Minimum ár</label>
                                                                <input type="text" placeholder="Minimum" class="form-control form-filter input-sm" name="min_ar" value=""> 
                                                            </div>
                                                        </div>
                                                    
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class="control-label">Maximum ár</label>
                                                                <input type="text" placeholder="Maximum" class="form-control form-filter input-sm" name="max_ar" value="">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class="control-label">Min. szobaszám</label>
                                                                <select name="szobaszam" class="form-control form-filter input-sm">
                                                                    <option value="">-- mindegy --</option>
                                                                    <?php for($i=1; $i<11; $i++) { ?>
                                                                        <option value=" <?php echo $i; ?> " ><?php echo $i; ?></option>
                                                                    <?php    } ?>
                                                                </select> 
                                                            </div>
                                                        </div>                

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class="control-label">Min. terület</label>
                                                                <input type="text" placeholder="Minimum" class="form-control form-filter input-sm" name="min_alapterulet" value="">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class="control-label">Max. terület</label>
                                                                <input type="text" placeholder="Maximum" class="form-control form-filter input-sm" name="max_alapterulet" value="">
                                                            </div>
                                                        </div>
                                                      
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class="control-label">Tulajdonos</label>
                                                                <input type="text" class="form-control form-filter input-sm" name="tulaj_nev" id="tulaj_nev" value="">
                                                            </div>
                                                        </div>                    
                                                    </div>

                                                    <div class="row">
                                                        <div>
                                                            <button class="btn btn-sm grey-cascade filter-submit margin-bottom" title="Szűrés indítása"><i class="fa fa-search"></i> Szűrés indítása</button>
                                                            <button class="btn btn-sm grey-cascade filter-cancel" title="Szűrési feltételek törlése"><i class="fa fa-times"></i> Szűrés törlése</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div> <!-- Kereső portlet END -->

                                        </td>
                                    </tr>

                                </thead>

                                <tbody></tbody>

                            </table>	

                        </div> <!-- END TABLE CONTAINER-->

                    </div> <!-- END PORTLET BODY -->
                </div> <!-- END PORTLET -->

            </div>
        </div>
    </div> <!-- END PAGE CONTENT