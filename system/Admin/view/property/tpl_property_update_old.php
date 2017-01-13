<!-- BEGIN CONTENT -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->

        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="admin/home">Kezdőoldal</a> 
                </li>
                <li>
                    <i class="fa fa-angle-right"></i>
                    <a href="admin/property">Ingatlanok listája</a>
                </li>
                <li>
                    <i class="fa fa-angle-right"></i>
                    <span>Ingatlan adatok módosítása</span>
                </li>
            </ul>
        </div>

        <!-- END PAGE HEADER-->

        <div class="margin-bottom-20"></div>

        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">

                <div id="ajax_message"></div> 	
                <?php $this->renderFeedbackMessages(); ?>			

                <!-- PORTLET 1 -->
                <div class="portlet">

                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-edit"></i>Ingatlan adatok módosítása</div>
                        <div class="actions">
                            <!-- Adatok elküldése UPDATE és kilépés -->
                            <button class="btn green" id="data_update_ajax" data-id="<?php echo $this->content['id']; ?>" type="button" name="save_data">Mentés és kilépés <i class="fa fa-check"></i></button>
                            <a class="btn default" id="button_megsem" href="admin/property">Kilépés <i class="fa fa-times"></i></a>
                        </div>								
                    </div>

                    <div class="portlet-body">

                        <form action="" method="POST" id="upload_data_form">	

                            <div class="tabbable-custom ">
                                <ul class="nav nav-tabs ">
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab">
                                            Alap adatok </a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_2" data-toggle="tab">
                                            Cím adatok </a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_3" data-toggle="tab">
                                            Leírás </a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_4" data-toggle="tab">
                                            Jellemzők </a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_5" data-toggle="tab">
                                            Tulajdonos adatai </a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_6" data-toggle="tab">
                                            Képek </a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_7" data-toggle="tab">
                                            Dokumentumok </a>
                                    </li>
                                </ul>
                                <div class="tab-content">

                                    <!-- ÜZENET DOBOZOK -->
                                    <div class="alert alert-danger display-hide">
                                        <button class="close" data-close="alert"></button>
                                        <span><!-- ide jön az üzenet--></span>
                                    </div>
                                    <div class="alert alert-success display-hide">
                                        <button class="close" data-close="alert"></button>
                                        <span><!-- ide jön az üzenet--></span>
                                    </div>

                                    <!-- ALAPBEÁLLÍTÁSOK -->
                                    <div class="tab-pane active" id="tab_1_1">

                                        <!--
                                        <input type="hidden" id="current_id" value="<?php echo $this->content['id']; ?>" />
                                        -->

                                        <!-- REFERENS KÓD -->	
                                        <div class="form-group">
                                            <label for="ref_id" class="control-label">Referens kód</label>
                                            <input type="text" value="<?php echo $this->content['ref_id']; ?>" class="form-control input-xlarge" disabled />
                                            <input type="hidden" name="ref_id" value="<?php echo $this->content['ref_id']; ?>" />
                                        </div>
                                        <!-- STÁTUSZ -->	

                                        <div class="form-group">
                                            <label for="status" class="control-label">Státusz <span></span>
                                            </label>
                                            <select name="status" class="form-control input-xlarge">
                                                <option value="1" <?php echo ($this->content['status'] == 1) ? 'selected' : ''; ?>>Aktív</option>
                                                <option value="0" <?php echo ($this->content['tipus'] == 0) ? 'selected' : ''; ?>>Inaktív</option>
                                            </select>
                                        </div>
                                        <!-- ÜGYLET TÍPUSA -->	
                                        <div class="form-group">
                                            <label for="tipus" class="control-label">Eladó / kiadó <span class="required">*</span></label>
                                            <select name="tipus" id="tipus" class="form-control input-xlarge">
                                                <option value="">-- válasszon --</option>

                                                <option value="1" <?php echo ($this->content['tipus'] == 1) ? 'selected' : ''; ?>>Eladó</option>
                                                <option value="2" <?php echo ($this->content['tipus'] == 2) ? 'selected' : ''; ?>>Kiadó</option>

                                            </select>
                                        </div>	
                                        <!-- KIEMELÉS -->	
                                        <div class="form-group">
                                            <label for="kiemeles" class="control-label">Kiemelés <span></span></label>
                                            <select name="kiemeles" id="kiemeles" class="form-control input-xlarge">
                                                <option value="0" <?php echo ($this->content['kiemeles'] == 0) ? 'selected' : ''; ?>>Nincs kiemelve</option>
                                                <?php if (Session::get('user_role_id') == 1) : ?>  
                                                    <option value="1" <?php echo ($this->content['tipus'] == 1) ? 'selected' : ''; ?>>Kiemelés</option>
                                                <?php endif; ?>

                                                <?php if (Session::get('user_role_id') > 1) : ?>  
                                                    <option value="2" <?php echo ($this->content['tipus'] == 2) ? 'selected' : ''; ?>>Kiemelés</option>
                                                <?php endif; ?>
                                            </select>
                                        </div>	
                                        <!-- LAKÁS FAJTÁJA -->	
                                        <div class="form-group">
                                            <label for="kategoria" class="control-label">Lakás fajtája <span class="required">*</span></label>
                                            <select name="kategoria" id="kategoria" class="form-control input-xlarge">
                                                <option value="">Válasszon</option>
                                                <?php foreach ($this->ingatlan_kat_list as $value) { ?>
                                                    <option value="<?php echo $value['kat_id']; ?>" <?php echo ($value['kat_id'] == $this->content['kategoria']) ? 'selected' : ''; ?>><?php echo $value['kat_nev']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>	

                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- ÁR_ELADó -->	
                                                <div style="float:left; padding-right:20px;">
                                                    <div class="form-group">
                                                        <label for="ar_elado" class="control-label">Eladási ár (Ft) <span class="required">*</span></label>
                                                        <div class="input-group">
                                                            <input type="text" name="ar_elado" id="ar_elado" value="<?php echo $this->content['ar_elado']; ?>" class="form-control input-small" disabled/>
                                                            <div class="input-group-addon">Ft</div>
                                                        </div>
                                                    </div>	
                                                </div>		
                                                <div style="display:inline-block;">
                                                    <!-- ÁR_KIADÓ -->
                                                    <div class="form-group">
                                                        <label for="ar_kiado" class="control-label">Bérleti díj (Ft) <span class="required">*</span></label>
                                                        <div class="input-group">
                                                            <input type="text" name="ar_kiado" id="ar_kiado" value="<?php echo $this->content['ar_kiado']; ?>" class="form-control input-small" disabled/>
                                                            <div class="input-group-addon">Ft</div>
                                                        </div>
                                                    </div>
                                                </div>		
                                            </div>		
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- ALAPTERÜLET -->	
                                                <div style="float:left; padding-right:20px;">
                                                    <div class="form-group">
                                                        <label for="alapterulet" class="control-label">Alapterület</label>
                                                        <input value="<?php echo $this->content['alapterulet']; ?>" type="text" name="alapterulet" id="alapterulet" placeholder="" class="form-control input-small" />
                                                    </div>
                                                </div>
                                                <!-- SZOBÁK SZÁMA -->	
                                                <div style="display:inline-block;">		
                                                    <div class="form-group">
                                                        <label for="szobaszam" class="control-label">Szobák száma</label>
                                                        <input value="<?php echo $this->content['szobaszam']; ?>" type="text" name="szobaszam" id="szobaszam" placeholder="" class="form-control input-small" />
                                                    </div>	
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- KÖZÖS KÖLTSÉG -->
                                                <div style="float:left; padding-right:20px;">													
                                                    <div class="form-group">
                                                        <label for="kozos_koltseg" class="control-label">Közös költség</label>
                                                        <input value="<?php echo $this->content['kozos_koltseg']; ?>" type="text" name="kozos_koltseg" id="kozos_koltseg" placeholder="" class="form-control input-small" />
                                                    </div>	
                                                </div>	
                                                <!-- ÁTLAGOS REZSI -->
                                                <div style="display:inline-block;">	
                                                    <div class="form-group">
                                                        <label for="rezsi" class="control-label">Átlagos rezsi</label>
                                                        <input value="<?php echo $this->content['rezsi']; ?>" type="text" name="rezsi" id="rezsi" placeholder="" class="form-control input-small" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- CÍM ADATOK -->
                                    <div class="tab-pane" id="tab_1_2">
                                        <!-- MEGYE MEGADÁSA -->	
                                        <div class="form-group" id="megye_div">
                                            <label for="megye" class="control-label">Megye</label>
                                            <select name="megye" id="megye_select" class="form-control input-xlarge">
                                                <option value="">-- válasszon --</option>
                                                <?php foreach ($this->county_list as $value) { ?>
                                                    <option value="<?php echo $value['county_id']; ?>" <?php echo ($value['county_id'] == $this->content['megye']) ? 'selected' : ''; ?>><?php echo $value['county_name']; ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>                                        


                                        <!-- VÁROS MEGADÁSA -->	
                                        <div class="form-group" id="varos_div">
                                            <label for="varos" class="control-label">Város</label>
                                            <select name="varos" id="varos_select" data-selected="<?php echo $this->content['varos']; ?>" class="form-control input-xlarge">

                                            </select>
                                        </div>	                                        
<!--
                                        <script>
                                           // $("#varos option").prop("selected", false).filter('[value="<?php //echo $this->content['varos']; ?>"]').prop("selected", true);
                                        </script>
-->
                                        <!-- KERÜLET MEGADÁSA -->	
                                        <div class="form-group" id="district_div">
                                            <label for="kerulet" class="control-label">Kerület <span></span></label>
                                            <select name="kerulet" id="district_select" class="form-control input-xlarge" disabled>
                                                <option value="">-- válasszon --</option>
                                                <?php foreach ($this->district_list as $value) { ?>
                                                    <option value="<?php echo $value['district_id']; ?>" <?php echo ($value['district_id'] == $this->content['kerulet']) ? 'selected' : ''; ?>><?php echo $value['district_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>	
                                        <!-- UTCA MEGADÁSA -->	
                                        <div class="form-group">
                                            <label for="utca" class="control-label">Utca</label>
                                            <input type="text" name="utca" id="utca" value="<?php echo $this->content['utca']; ?>" class="form-control input-xlarge" />
                                        </div>
                                        <!-- IRANYITOSZAM -->	
                                        <div class="form-group">
                                            <label for="iranyitoszam" class="control-label">Irányítószám</label>
                                            <input type="text" name="iranyitoszam" id="iranyitoszam" value="<?php echo $this->content['iranyitoszam']; ?>" class="form-control input-small" />
                                        </div>	

                                        <!-- HAZSZAM -->	
                                        <div class="form-group">
                                            <label for="hazszam" class="control-label">Házszám</label>
                                            <input type="text" name="hazszam" id="hazszam" value="<?php echo $this->content['hazszam']; ?>" class="form-control input-xlarge" />
                                        </div>	
                                        <!-- EMELET -->	
                                        <div class="form-group">
                                            <label for="emelet" class="control-label">Emelet</label>
                                            <select name="emelet" id="emelet" class="form-control input-xlarge">
                                                <option value="">-- válasszon --</option>

                                                <option value="1" <?php echo ($this->content['emelet'] == 1) ? 'selected' : ''; ?>>1. emelet</option>
                                                <option value="2" <?php echo ($this->content['emelet'] == 2) ? 'selected' : ''; ?>>2. emelet</option>
                                                <option value="3" <?php echo ($this->content['emelet'] == 3) ? 'selected' : ''; ?>>3. emelet</option>
                                                <option value="4" <?php echo ($this->content['emelet'] == 4) ? 'selected' : ''; ?>>4. emelet</option>

                                                <option value="5" <?php echo ($this->content['emelet'] == 5) ? 'selected' : ''; ?>>5. emelet</option>
                                                <option value="6" <?php echo ($this->content['emelet'] == 6) ? 'selected' : ''; ?>>6. emelet</option>
                                                <option value="7" <?php echo ($this->content['emelet'] == 7) ? 'selected' : ''; ?>>7. emelet</option>
                                                <option value="8" <?php echo ($this->content['emelet'] == 8) ? 'selected' : ''; ?>>8. emelet</option>

                                                <option value="9" <?php echo ($this->content['emelet'] == 9) ? 'selected' : ''; ?>>9. emelet</option>
                                                <option value="10" <?php echo ($this->content['emelet'] == 10) ? 'selected' : ''; ?>>10. emelet</option>
                                                <option value="11" <?php echo ($this->content['emelet'] == 11) ? 'selected' : ''; ?>>10. emelet felett</option>

                                            </select>
                                        </div>                                        
                                        <!-- EMELET/AJTÓ -->	
                                        <div class="form-group">
                                            <label for="emelet_ajto" class="control-label">Ajtó</label>
                                            <input type="text" name="emelet_ajto" id="emelet_ajto" value="<?php echo $this->content['emelet_ajto']; ?>" class="form-control input-xlarge" />
                                        </div>
                                        <!-- ÉPÜLET SZINTJEINEK SZÁMA -->	
                                        <div class="form-group">
                                            <label for="epulet_szintjei" class="control-label">Épület szinjei</label>
                                            <select name="epulet_szintjei" id="epulet_szintjei" class="form-control input-xlarge">
                                                <option value="">-- válasszon --</option>

                                                <option value="1" <?php echo ($this->content['epulet_szintjei'] == 1) ? 'selected' : ''; ?>>1 emelet</option>
                                                <option value="2" <?php echo ($this->content['epulet_szintjei'] == 2) ? 'selected' : ''; ?>>2 emelet</option>
                                                <option value="3" <?php echo ($this->content['epulet_szintjei'] == 3) ? 'selected' : ''; ?>>3 emelet</option>
                                                <option value="4" <?php echo ($this->content['epulet_szintjei'] == 4) ? 'selected' : ''; ?>>4 emelet</option>

                                                <option value="5" <?php echo ($this->content['epulet_szintjei'] == 5) ? 'selected' : ''; ?>>5 emelet</option>
                                                <option value="6" <?php echo ($this->content['epulet_szintjei'] == 6) ? 'selected' : ''; ?>>6 emelet</option>
                                                <option value="7" <?php echo ($this->content['epulet_szintjei'] == 7) ? 'selected' : ''; ?>>7 emelet</option>
                                                <option value="8" <?php echo ($this->content['epulet_szintjei'] == 8) ? 'selected' : ''; ?>>8 emelet</option>

                                                <option value="9" <?php echo ($this->content['epulet_szintjei'] == 9) ? 'selected' : ''; ?>>9 emelet</option>
                                                <option value="10" <?php echo ($this->content['epulet_szintjei'] == 10) ? 'selected' : ''; ?>>10 emelet</option>
                                                <option value="11" <?php echo ($this->content['epulet_szintjei'] == 11) ? 'selected' : ''; ?>>10 emelet felett</option>

                                            </select>
                                        </div>                                        
                                        <!-- CHECKBOX-OK -->

                                        <div class="form-group">
                                            <div class="checkbox-list">
                                                <label><input type="checkbox" name="utca_megjelenites" <?php echo ($this->content['utca_megjelenites'] == 1) ? 'checked="checked"' : ''; ?>> Utca megjelenítése az adatlapon</label>
                                                <label><input type="checkbox" name="hazszam_megjelenites" <?php echo ($this->content['hazszam_megjelenites'] == 1) ? 'checked="checked"' : ''; ?>> Házszám megjelenítése az adatlapon</label>
                                                <label><input type="checkbox" name="terkep" <?php echo ($this->content['terkep'] == 1) ? 'checked="checked"' : ''; ?>> Térképes megjelenítés az adatlapon</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- LEÍRÁS -->
                                    <div class="tab-pane" id="tab_1_3">

                                        <div class="portlet">
                                            <!-- LAKÁS NEV -->	
                                            <div class="form-group">
                                                <label for="ingatlan_nev" class="control-label">Ingatlan név</label>
                                                <input value="<?php echo $this->content['ingatlan_nev']; ?>" type="text" name="ingatlan_nev" id="ingatlan_nev" placeholder="" class="form-control input-xlarge" />
                                            </div>
                                            <!-- LAKÁS LEIRAS -->	
                                            <div class="form-group">
                                                <label for="leiras" class="control-label">Leírás</label>
                                                <textarea name="leiras" id="leiras" placeholder="" class="form-control input-xlarge" rows="10"><?php echo $this->content['leiras']; ?></textarea>
                                            </div>	
                                        </div>


                                    </div>

                                    <!-- JELLEMZŐK -->	
                                    <div class="tab-pane" id="tab_1_4">
                                        <!-- JELLEMZŐK -->
                                        <div style="height:8px;"></div>

                                        <div class="row">

                                            <div class="col-md-3 col-sm-5 col-xs-8" >
                                                <!-- INGATLAN ÁLLAPOTA -->	
                                                <div class="form-group">
                                                    <label for="allapot">Állapot</label>
                                                    <select name="allapot" id="allapot" class="form-control">
                                                        <option value="">-- válasszon --</option>
                                                        <?php foreach ($this->ingatlan_allapot_list as $value) { ?>
                                                            <option value="<?php echo $value['all_id']; ?>" <?php echo ($value['all_id'] == $this->content['allapot']) ? 'selected' : ''; ?>><?php echo $value['all_leiras']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div> 
                                            </div>

                                            <div class="col-md-3 col-sm-5 col-xs-8" >
                                                <div class="form-group">
                                                    <label for="futes">Fűtés</label>
                                                    <select class="form-control" name='futes' id='futes'>
                                                        <option value="">-- válasszon --</option>
                                                        <?php foreach ($this->ingatlan_futes_list as $value) { ?>
                                                            <option value="<?php echo $value['futes_id']; ?>" <?php echo ($value['futes_id'] == $this->content['futes']) ? 'selected' : ''; ?>><?php echo $value['futes_leiras']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="col-md-3 col-sm-5 col-xs-8" >
                                                <div class="form-group">
                                                    <label for="parkolas">Parkolás</label>
                                                    <select class="form-control" name='parkolas' id='parkolas'>
                                                        <option value="">-- válasszon --</option>
                                                        <?php foreach ($this->ingatlan_parkolas_list as $value) { ?>
                                                            <option value="<?php echo $value['parkolas_id']; ?>" <?php echo ($value['parkolas_id'] == $this->content['parkolas']) ? 'selected' : ''; ?>><?php echo $value['parkolas_leiras']; ?></option>
                                                        <?php } ?>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-5 col-xs-8" >
                                                <div class="form-group">
                                                    <label for="kilatas">Kilátás</label>
                                                    <select class="form-control" name='kilatas' id='kilatas'>
                                                        <option value="">-- válasszon --</option>
                                                        <?php foreach ($this->ingatlan_kilatas_list as $value) { ?>
                                                            <option value="<?php echo $value['kilatas_id']; ?>" <?php echo ($value['kilatas_id'] == $this->content['kilatas']) ? 'selected' : ''; ?>><?php echo $value['kilatas_leiras']; ?></option>
                                                        <?php } ?> 

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-5 col-xs-8" >
                                                <div class="form-group">
                                                    <label for="lift">Lift</label>
                                                    <select class="form-control" name='lift' id='lift'>
                                                        <option value="0">nincs</option>
                                                        <option value="1">van</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-5 col-xs-8" >
                                                <div class="form-group">
                                                    <label for="butor">Bútorozott</label>
                                                    <select class="form-control" name='butor' id='butor'>
                                                        <option value="0">nem</option>
                                                        <option value="1">igen</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-5 col-xs-8" >
                                                <div class="form-group">
                                                    <label for="energetika">Energetikai tanúsítvány</label>
                                                    <select class="form-control" name='energetika' id='energetika'>
                                                        <option value="">-- válasszon --</option>
                                                        <?php foreach ($this->ingatlan_energetika_list as $value) { ?>
                                                            <option value="<?php echo $value['energetika_id']; ?>" <?php echo ($value['energetika_id'] == $this->content['energetika']) ? 'selected' : ''; ?>><?php echo $value['energetika_leiras']; ?></option>
                                                        <?php } ?> 
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-5 col-xs-8" >
                                                <div class="form-group">
                                                    <label for="kert">Kert</label>
                                                    <select class="form-control" name='kert' id='kert'>
                                                        <option value="">-- válasszon --</option>
                                                        <?php foreach ($this->ingatlan_kert_list as $value) { ?>
                                                            <option value="<?php echo $value['kert_id']; ?>" <?php echo ($value['kert_id'] == $this->content['kert']) ? 'selected' : ''; ?>><?php echo $value['kert_leiras']; ?></option>
                                                        <?php } ?>

                                                    </select>
                                                </div>
                                            </div>                                            

                                        </div>                                       




                                        <div class="row">




                                            <div class="col-md-3 col-sm-5 col-xs-8">
                                                <div class="form-group">
                                                    <div class="checkbox">
                                                        <input type="checkbox" value="1" name="erkely" <?php echo ($this->content['erkely'] == 1) ? 'checked="checked"' : ''; ?>><label>Erkély</label>				</div>
                                                </div>
                                            </div>


                                            <div class="col-md-3 col-sm-5 col-xs-8">
                                                <div class="form-group">
                                                    <div class="checkbox">
                                                        <input type="checkbox" value="2" name="terasz" <?php echo ($this->content['terasz'] == 1) ? 'checked="checked"' : ''; ?>><label>Terasz</label>				</div>
                                                </div>
                                            </div>


                                            <div class="col-md-3 col-sm-5 col-xs-8">
                                                <div class="form-group">
                                                    <div class="checkbox">
                                                        <input type="checkbox" value="3" name="medence" <?php echo ($this->content['medence'] == 1) ? 'checked="checked"' : ''; ?>><label>Medence</label>				</div>
                                                </div>
                                            </div>


                                            <div class="col-md-3 col-sm-5 col-xs-8">
                                                <div class="form-group">
                                                    <div class="checkbox">
                                                        <input type="checkbox" value="4" name="szauna" <?php echo ($this->content['szauna'] == 1) ? 'checked="checked"' : ''; ?>><label>Szauna</label>				</div>
                                                </div>
                                            </div>


                                            <div class="col-md-3 col-sm-5 col-xs-8">
                                                <div class="form-group">
                                                    <div class="checkbox">
                                                        <input type="checkbox" value="5" name="jacuzzi" <?php echo ($this->content['jacuzzi'] == 1) ? 'checked="checked"' : ''; ?>><label>Jacuzzi</label>				</div>
                                                </div>
                                            </div>


                                            <div class="col-md-3 col-sm-5 col-xs-8">
                                                <div class="form-group">
                                                    <div class="checkbox">
                                                        <input type="checkbox" value="6" name="kandallo" <?php echo ($this->content['kandallo'] == 1) ? 'checked="checked"' : ''; ?>><label>Kandalló</label>				</div>
                                                </div>
                                            </div>


                                            <div class="col-md-3 col-sm-5 col-xs-8">
                                                <div class="form-group">
                                                    <div class="checkbox">
                                                        <input type="checkbox" value="7" name="riaszto" <?php echo ($this->content['riaszto'] == 1) ? 'checked="checked"' : ''; ?>><label>Riasztó</label>				</div>
                                                </div>
                                            </div>


                                            <div class="col-md-3 col-sm-5 col-xs-8">
                                                <div class="form-group">
                                                    <div class="checkbox">
                                                        <input type="checkbox" value="9" name="klima" <?php echo ($this->content['klima'] == 1) ? 'checked="checked"' : ''; ?>><label>Klíma</label>				</div>
                                                </div>
                                            </div>


                                            <div class="col-md-3 col-sm-5 col-xs-8">
                                                <div class="form-group">
                                                    <div class="checkbox">
                                                        <input type="checkbox" value="10" name="ontozorendszer" <?php echo ($this->content['ontozorendszer'] == 1) ? 'checked="checked"' : ''; ?>><label>Öntözőrendszer</label>				</div>
                                                </div>
                                            </div>


                                            <div class="col-md-3 col-sm-5 col-xs-8">
                                                <div class="form-group">
                                                    <div class="checkbox">
                                                        <input type="checkbox" value="11" name="automata_kapu" <?php echo ($this->content['automata_kapu'] == 1) ? 'checked="checked"' : ''; ?>><label>Automata kapu</label>				</div>
                                                </div>
                                            </div>


                                            <div class="col-md-3 col-sm-5 col-xs-8">
                                                <div class="form-group">
                                                    <div class="checkbox">
                                                        <input type="checkbox" value="12" name="elektromos_redony" <?php echo ($this->content['elektromos_redony'] == 1) ? 'checked="checked"' : ''; ?>><label>Elektromos redőny</label>				</div>
                                                </div>
                                            </div>


                                            <div class="col-md-3 col-sm-5 col-xs-8">
                                                <div class="form-group">
                                                    <div class="checkbox">
                                                        <input type="checkbox" value="13" name="konditerem" <?php echo ($this->content['konditerem'] == 1) ? 'checked="checked"' : ''; ?>><label>Konditerem</label>				</div>
                                                </div>
                                            </div>



                                        </div> 												
                                    </div>

                                    <!-- TULAJDONOS ADATAI -->
                                    <div class="tab-pane" id="tab_1_5">
                                        <!-- TULAJ NEVE -->	
                                        <div class="form-group">
                                            <label for="tulaj_nev" class="control-label">Név <span class="required">*</span></label>
                                            <input value="<?php echo $this->content['tulaj_nev']; ?>"type="text" name="tulaj_nev" id="tulaj_nev" placeholder="" class="form-control input-xlarge" />
                                        </div>	
                                        <!-- TULAJ CÍME -->	
                                        <div class="form-group">
                                            <label for="tulaj_cim" class="control-label">Cím</label>
                                            <input value="<?php echo $this->content['tulaj_cim']; ?>" type="text" name="tulaj_cim" id="tulaj_cim" placeholder="" class="form-control input-xlarge" />
                                        </div>
                                        <!-- TULAJ TELEFONSZÁM -->	
                                        <div class="form-group">
                                            <label for="tulaj_tel" class="control-label">Telefonszám <span class="required">*</span></label>
                                            <input value="<?php echo $this->content['tulaj_tel']; ?>" type="text" name="tulaj_tel" id="tulaj_tel" placeholder="" class="form-control input-xlarge" />
                                        </div>
                                        <!-- TULAJ EMAIL -->	
                                        <div class="form-group">
                                            <label for="tulaj_email" class="control-label">E-mail cím</label>
                                            <input value="<?php echo $this->content['tulaj_email']; ?>" type="text" name="tulaj_email" id="tulaj_email" placeholder="" class="form-control input-xlarge" />
                                        </div>
                                        <!-- TULAJ MEGJEGYZÉS -->	
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="tulaj_notes" class="control-label">Megjegyzés</label>
                                                    <textarea name="tulaj_notes" id="tulaj_notes" placeholder="" class="form-control" rows="6"><?php echo $this->content['tulaj_notes']; ?></textarea>

                                                </div>	
                                            </div>
                                        </div>
                                    </div>

                                    <!-- KÉPEK -->					
                                    <div class="tab-pane" id="tab_1_6">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="portlet">
                                                    <div class="portlet-body">
                                                        <h4 class="block">Feltöltött képek:</h4>
                                                        <ul id="photo_list">
                                                            <?php
                                                            $result_photos = json_decode($this->content['kepek']);
                                                            if (!empty($result_photos)) {
                                                                $counter = 0;
                                                                $file_location = Config::get('ingatlan_photo.upload_path');
                                                                foreach ($result_photos as $key => $value) {
                                                                    $counter = $key + 1;
                                                                    $file_path = Util::thumb_path($file_location . $value);
                                                                    echo '<li id="elem_' . $counter . '" class="ui-state-default"><img class="img-thumbnail" src="' . $file_path . '" alt="" /><button style="position:absolute; top:20px; right:20px; z-index:2;" class="btn btn-xs btn-default" type="button" title="Kép törlése"><i class="glyphicon glyphicon-trash"></i></button></li>' . "\n\r";
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <!-- KÉPEK FELTÖLTÉSE -->
                                                <div class="portlet">
                                                    <div class="portlet-body">
                                                        <h4 class="block">Képek hozzáadása:</h4>
                                                        <input type="file" name="new_file[]" multiple="true" id="input-4" />
                                                    </div>
                                                </div>		
                                            </div>
                                        </div> <!-- row END -->		
                                    </div>

                                    <!-- DOKUMENTUMOK -->					
                                    <div class="tab-pane" id="tab_1_7">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="portlet">
                                                    <div class="portlet-body">
                                                        <h4 class="block">Feltöltött dokumentumok:</h4>
                                                        <ul id="dokumentumok" class="list-group">
                                                            <?php
                                                            $result_docs = json_decode($this->content['docs']);
                                                            if (!empty($result_docs)) {
                                                                $counter = 0;
                                                                $file_location = Config::get('ingatlan_doc.upload_path');
                                                                foreach ($result_docs as $key => $value) {
                                                                    $counter = $key + 1;
                                                                    echo '<li id="doc_' . $counter . '" class="list-group-item"><i class="glyphicon glyphicon-file"> </i>&nbsp;' . $value . '<button type="button" class="btn btn-xs btn-default" style="position: absolute; top:8px; right:8px;"><i class="glyphicon glyphicon-trash"></i></button></li>' . "\n\r";
                                                                }
                                                            }
                                                            ?>
                                                        </ul>											
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <!-- DOKUMENTUMOK FELTÖLTÉSE -->
                                                <div class="portlet">
                                                    <div class="portlet-body">
                                                        <h4 class="block">Dokumentumok hozzáadása:</h4>
                                                        <input type="file" name="new_doc[]" multiple="true" id="input-5" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- row END -->										
                                    </div>

                                </div> <!-- tab content end -->
                            </div> <!-- tab menü end -->

                        </form>


                    </div> <!-- END PORTLET 1 BODY-->
                </div> <!-- END PORTLET 1 -->

            </div> <!-- END COL-MD-12 -->
        </div> <!-- END ROW -->	
    </div> <!-- END PAGE CONTENT-->