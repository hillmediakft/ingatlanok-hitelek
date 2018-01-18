<?php use System\Libs\Auth; ?>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="admin/home">Kezdőoldal</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li><span>Ingatlan hozzáadása</span></li>
        </ul>
    </div>

    <!-- END PAGE HEADER-->

    <div class="margin-bottom-20"></div>

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">


            <div id="ajax_message"></div>
            <!-- echo out the system feedback (error and success messages) -->
            <?php $this->renderFeedbackMessages(); ?>


            <!-- PORTLET 1 -->
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-plus"></i>Új ingatlan</div>
                    <div class="actions">

                    </div>
                </div>

                <div class="portlet-body">

                    <form action="" method="POST" id="upload_data_form">

                        <div class="form-body">

                            <!-- ÜZENET DOBOZOK -->
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                <span><!-- ide jön az üzenet--></span>
                            </div>
                            <div class="alert alert-success display-hide">
                                <button class="close" data-close="alert"></button>
                                <span><!-- ide jön az üzenet--></span>
                            </div>

                            <!-- ********* ALAPBEÁLLÍTÁSOK ***************** -->
                            <div class="portlet light bg-inverse">
                                <div class="portlet-title">
                                    <div class="caption font-green-sharp">
                                        <i class="icon-share font-green-sharp"></i>
                                        <span class="caption-subject bold uppercase"> Alap adatok</span>
                                    </div>

                                </div>
                                <div class="portlet-body form-horizontal">

                                    <div class="row">


                                        <!-- REFERENS KÓD -->
                                        <?php if (!Auth::isSuperadmin()) { ?>
                                        <div class="form-group">
                                            <label for="ref_id" class="control-label col-md-3">Referens kód</label>
                                            <div class="col-md-9">
                                                <input type="text" value="<?php echo Auth::getUser('id'); ?>" class="form-control input-small" disabled />
                                                <input type="hidden" name="ref_id" value="<?php echo Auth::getUser('id'); ?>" />
                                            </div>
                                        </div>
                                        <?php } ?>

                                        <!-- REFERENS NÉV -->
                                        <div class="form-group">
                                            <label for="ref_name" class="control-label col-md-3">Referens név <span class="required">*</span></label>
                                            <div class="col-md-9">

                                                <?php if (Auth::isSuperadmin()) { ?>
                                                <select name="ref_id" class="form-control input-small">
                                                    <option value="">-- válasszon --</option>
                                                    <?php foreach ($referens_list as $referens) { ?>
                                                    <option value="<?php echo $referens['id']; ?>"><?php echo  '#' . $referens['id'] . ' - ' . $referens['first_name'] . ' ' . $referens['last_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <?php } else { ?>
                                                <input type="text" value="<?php echo Auth::getUser('name'); ?>" class="form-control input-small" disabled />
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <!-- REFERENCIA SZÁM -->
                                        <div class="form-group">
                                            <label for="ref_num" class="control-label col-md-3">Referencia szám <span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" name="ref_num" id="ref_num" class="form-control input-small" />
                                            </div>
                                        </div>

                                        <!-- STATUS -->
                                        <div class="form-group">
                                            <label for="status" class="control-label col-md-3">Státusz <span></span>
                                            </label>
                                            <div class="col-md-9">
                                                <select name="status" class="form-control input-small">
                                                    <option value="1">Aktív</option>
                                                    <option value="0">Inaktív</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- KIEMELÉS -->
                                        <div class="form-group">
                                            <label for="kiemeles" class="control-label col-md-3">Kiemelés <span></span></label>
                                            <div class="col-md-9">
                                                <select name="kiemeles" id="kiemeles" class="form-control input-small">
                                                    <option value="0">Nincs kiemelve</option>
                                                    <option value="1">Kiemelés</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- TÍPUS -->
                                        <div class="form-group">
                                            <label for="tipus" class="control-label col-md-3 ">Megbízás típusa <small>(Eladó / kiadó)</small><span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <select name="tipus" id="tipus" class="form-control input-small">
                                                    <!-- <option value="">-- válasszon --</option> -->
                                                    <option value="1">Eladó</option>
                                                    <option value="2">Kiadó</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- LAKÁS FAJTÁJA -->
                                        <div class="form-group">
                                            <label for="kategoria" class="control-label col-md-3">Ingatlan típusa <span class="required">*</span></label>
                                            <div class="col-md-3">
                                                <select name="kategoria" id="kategoria" class="form-control">
                                                    <option value="">-- válasszon --</option>
                                                    <?php foreach ($ingatlan_kat_list as $value) { ?>
                                                        <option value="<?php echo $value['kat_id']; ?>" <?php echo ($value['kat_nev_hu'] == 'Lakás') ? 'selected' : ''; ?>><?php echo $value['kat_nev_hu']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>


                                        <!-- EREDETI ÁR_ELADÓ -->
                                        <div class="form-group">
                                            <label for="ar_elado_eredeti" class="col-md-3 control-label">Eredeti eladási ár <span class="required">*</span></label>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input type="text" name="ar_elado_eredeti" id="ar_elado_eredeti" class="form-control"/>
                                                    <div class="input-group-addon">millió Ft</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- EREDETI ÁR_KIADÓ -->
                                        <div class="form-group">
                                            <label for="ar_kiado_eredeti" class="control-label col-md-3">Eredeti bérleti díj <span class="required">*</span></label>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input type="text" name="ar_kiado_eredeti" id="ar_kiado_eredeti" class="form-control" disabled/>
                                                    <div class="input-group-addon">ezer Ft</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ALAPTERÜLET -->
                                        <div class="form-group">
                                            <label for="alapterulet" class="control-label col-md-3">Alapterület<span class="required">*</span></label>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input type="text" name="alapterulet" id="alapterulet" class="form-control" />
                                                    <div class="input-group-addon">m<sup>2</sup></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- TELEK ALAPTERÜLET -->
                                        <div class="form-group">
                                            <label for="telek_alapterulet" class="control-label col-md-3">Telek alapterület</label>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input type="text" name="telek_alapterulet" id="telek_alapterulet" class="form-control"/>
                                                    <div class="input-group-addon">m<sup>2</sup></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- BELMAGASSÁG -->
                                        <div class="form-group">
                                            <label for="belmagassag" class="control-label col-md-3">Belmagasság</label>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input type="text" name="belmagassag" id="belmagassag" class="form-control" />
                                                    <div class="input-group-addon">cm</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- TÁJOLÁS -->
                                        <div class="form-group">
                                            <label for="tajolas" class="control-label col-md-3">Tájolás</label>
                                            <div class="col-md-3">
                                                <!-- <input type="text" name="tajolas" id="tajolas" class="form-control" /> -->
                                                <select name="tajolas" id="tajolas" class="form-control">
                                                    <option value="">-- válasszon --</option>
                                                    <option value="0">észak</option>
                                                    <option value="1">északkelet</option>
                                                    <option value="2">kelet</option>
                                                    <option value="3">délkelet</option>
                                                    <option value="4">dél</option>
                                                    <option value="5">délnyugat</option>
                                                    <option value="6">nyugat</option>
                                                    <option value="7">északnyugat</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="erkely" class="control-label col-md-3">Erkély</label>
                                            <div class="col-md-3">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="1" name="erkely" id="erkely">			
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Erkély alapterület -->
                                        <div class="form-group">
                                            <label for="erkely_terulet" class="control-label col-md-3">Erkély mérete</label>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input type="text" name="erkely_terulet" id="erkely_terulet" disabled="" class="form-control" />
                                                    <div class="input-group-addon">m<sup>2</sup></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="terasz" class="control-label col-md-3">Terasz</label>
                                            <div class="col-md-3">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="2" name="terasz" id="terasz">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Terasz alapterület -->
                                        <div class="form-group">
                                            <label for="terasz_terulet" class="control-label col-md-3">Terasz mérete</label>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input type="text" name="terasz_terulet" id="terasz_terulet" disabled="" class="form-control" />
                                                    <div class="input-group-addon">m<sup>2</sup></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- SZOBÁK SZÁMA -->
                                        <div class="form-group">
                                            <label for="szobaszam" class="control-label col-md-3">Szobák száma (12 m<sup>2</sup> felett)</label>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input type="text" name="szobaszam" id="szobaszam" class="form-control" />
                                                    <div class="input-group-addon">db</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- FÉLSZOBÁK SZÁMA -->
                                        <div class="form-group">
                                            <label for="felszobaszam" class="control-label col-md-3">Félszobák száma (6-12 m<sup>2</sup>)</label>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input type="text" name="felszobaszam" id="felszobaszam" class="form-control" />
                                                    <div class="input-group-addon">db</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- KÖZÖS KÖLTSÉG -->
                                        <div class="form-group">
                                            <label for="kozos_koltseg" class="control-label col-md-3">Közös költség</label>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input type="text" name="kozos_koltseg" id="kozos_koltseg" class="form-control" />
                                                    <div class="input-group-addon">Ft</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ÁTLAGOS REZSI -->
                                        <div class="form-group">
                                            <label for="rezsi" class="control-label col-md-3">Átlagos rezsi</label>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input type="text" name="rezsi" id="rezsi" class="form-control" />
                                                    <div class="input-group-addon">Ft</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!-- JELLEMZŐK -->
                            <div class="portlet light bg-inverse">
                                <div class="portlet-title">
                                    <div class="caption font-green-sharp">
                                        <i class="icon-share font-green-sharp"></i>
                                        <span class="caption-subject bold uppercase"> Jellemzők</span>
                                    </div>

                                </div>
                                <div class="portlet-body">

                                    <div class="row">
                                        
                                        <!-- INGATLAN ÁLLAPOTA -->
                                        <div class="col-md-3" >
                                            <div class="form-group">
                                                <label for="allapot">Ingatlan állapota</label>
                                                <select name="allapot" id="allapot" class="form-control">
                                                    <option value="">-- válasszon --</option>
                                                    <?php foreach ($ingatlan_allapot_list as $value) { ?>
                                                        <option value="<?php echo $value['all_id']; ?>"><?php echo $value['all_leiras_hu']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!-- INGATLAN ÁLLAPOTA KÍVÜL -->
                                        <div class="col-md-3" >
                                            <div class="form-group">
                                                <label for="haz_allapot_kivul">Ház állapota kívül</label>
                                                <select name="haz_allapot_kivul" id="haz_allapot_kivul" class="form-control">
                                                    <option value="">-- válasszon --</option>
                                                    <?php foreach ($ingatlan_haz_allapot_kivul_list as $value) { ?>
                                                        <option value="<?php echo $value['haz_allapot_kivul_id']; ?>"><?php echo $value['haz_allapot_kivul_leiras_hu']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!-- INGATLAN ÁLLAPOTA BELÜL -->
                                        <div class="col-md-3" >
                                            <div class="form-group">
                                                <label for="haz_allapot_belul">Ház állapota belül</label>
                                                <select name="haz_allapot_belul" id="haz_allapot_belul" class="form-control">
                                                    <option value="">-- válasszon --</option>
                                                    <?php foreach ($ingatlan_haz_allapot_belul_list as $value) { ?>
                                                        <option value="<?php echo $value['haz_allapot_belul_id']; ?>"><?php echo $value['haz_allapot_belul_leiras_hu']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div> 

                                        <!-- ENERGETIKA -->
                                        <div class="col-md-3" >
                                            <div class="form-group">
                                                <label for="energetika">Energetikai tanúsítvány</label>
                                                <select class="form-control" name='energetika' id='energetika'>
                                                    <option value="">-- válasszon --</option>
                                                    <?php foreach ($ingatlan_energetika_list as $value) { ?>
                                                        <option value="<?php echo $value['energetika_id']; ?>"><?php echo $value['energetika_leiras_hu']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- FŰTÉS -->
                                        <div class="col-md-3" >
                                            <div class="form-group">
                                                <label for="futes">Fűtés</label>
                                                <select class="form-control" name='futes' id='futes'>
                                                    <option value="">-- válasszon --</option>
                                                    <?php foreach ($ingatlan_futes_list as $value) { ?>
                                                        <option value="<?php echo $value['futes_id']; ?>"><?php echo $value['futes_leiras_hu']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>                                        
                                        
                                        <!-- FÜRDŐSZOBA -WC -->
                                        <div class="col-md-3" >
                                            <div class="form-group">
                                                <label for="furdo_wc">Fürdőszoba - WC</label>
                                                <select name="furdo_wc" id="furdo_wc" class="form-control">
                                                    <option value="">-- válasszon --</option>
                                                    <?php foreach ($ingatlan_furdo_wc_list as $value) { ?>
                                                        <option value="<?php echo $value['furdo_wc_id']; ?>"><?php echo $value['furdo_wc_leiras_hu']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div> 
                                        
                                        <!-- FÉNYVISZONYOK -->
                                        <div class="col-md-3" >
                                            <div class="form-group">
                                                <label for="fenyviszony">Fényviszonyok</label>
                                                <select name="fenyviszony" id="fenyviszony" class="form-control">
                                                    <option value="">-- válasszon --</option>
                                                    <?php foreach ($ingatlan_fenyviszony_list as $value) { ?>
                                                        <option value="<?php echo $value['fenyviszony_id']; ?>"><?php echo $value['fenyviszony_leiras_hu']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>                                         
                                        
                                        <!-- PARKOLÁS -->
                                        <div class="col-md-3" >
                                            <div class="form-group">
                                                <label for="parkolas">Parkolás</label>
                                                <select class="form-control" name='parkolas' id='parkolas'>
                                                    <option value="">-- válasszon --</option>
                                                    <?php foreach ($ingatlan_parkolas_list as $value) { ?>
                                                        <option value="<?php echo $value['parkolas_id']; ?>"><?php echo $value['parkolas_leiras_hu']; ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!-- KILÁTÁS -->
                                        <div class="col-md-3" >
                                            <div class="form-group">
                                                <label for="kilatas">Kilátás</label>
                                                <select class="form-control" name='kilatas' id='kilatas'>
                                                    <option value="">-- válasszon --</option>
                                                    <?php foreach ($ingatlan_kilatas_list as $value) { ?>
                                                        <option value="<?php echo $value['kilatas_id']; ?>"><?php echo $value['kilatas_leiras_hu']; ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!-- LIFT -->
                                        <div class="col-md-3" >
                                            <div class="form-group">
                                                <label for="lift">Lift</label>
                                                <select class="form-control" name='lift' id='lift'>
                                                    <option value="">-- válasszon --</option>
                                                    <option value="0">nincs</option>
                                                    <option value="1">van</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- SZERKEZET -->
                                        <div class="col-md-3" >
                                            <div class="form-group">
                                                <label for="szerkezet">Szerkezet</label>
                                                <select class="form-control" name="szerkezet" id="szerkezet">
                                                    <option value="">-- válasszon --</option>
                                                    <?php foreach ($ingatlan_szerkezet_list as $value) { ?>
                                                        <option value="<?php echo $value['szerkezet_id']; ?>"><?php echo $value['szerkezet_leiras_hu']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- KERT -->
                                        <div class="col-md-3" >
                                            <div class="form-group">
                                                <label for="kert">Kert</label>
                                                <select class="form-control" name='kert' id='kert'>
                                                    <option value="">-- válasszon --</option>
                                                    <?php foreach ($ingatlan_kert_list as $value) { ?>
                                                        <option value="<?php echo $value['kert_id']; ?>"><?php echo $value['kert_leiras_hu']; ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>

                                        <!-- SZOBA ELRENDEZÉS -->
                                        <div class="col-md-3" >
                                            <div class="form-group">
                                                <label for="szoba_elrendezes">Szoba elrendezes</label>
                                                <select class="form-control" name='szoba_elrendezes' id='szoba_elrendezes'>
                                                    <option value="">-- válasszon --</option>
                                                    <?php foreach ($ingatlan_szoba_elrendezes_list as $value) { ?>
                                                        <option value="<?php echo $value['szoba_elrendezes_id']; ?>"><?php echo $value['szoba_elrendezes_leiras_hu']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div> <!-- END ROW -->

                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="1" name="ext_butor"><label>Bútorozott</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="2" name="ext_medence"><label>Medence</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="3" name="ext_szauna"><label>Szauna</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="4" name="ext_jacuzzi"><label>Jacuzzi</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="5" name="ext_kandallo"><label>Kandalló</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="6" name="ext_riaszto"><label>Riasztó</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="7" name="ext_klima"><label>Klíma</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="8" name="ext_ontozorendszer"><label>Öntözőrendszer</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="9" name="ext_automata_kapu"><label>Automata kapu</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="10" name="ext_elektromos_redony"><label>Elektromos redőny</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="11" name="ext_konditerem"><label>Konditerem</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="12" name="ext_galeria"><label>Galéria</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="13" name="ext_furdoben_kad"><label>Fürdőben kád</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="14" name="ext_furdoben_zuhany"><label>Fürdőben zuhany</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="15" name="ext_masszazskad"><label>Masszázskád</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="16" name="ext_amerikaikonyha"><label>Amerikai konyha</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="17" name="ext_konyhaablak"><label>Konyhaablak</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="18" name="ext_kamra"><label>Kamra</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="27" name="ext_pince"><label>Pince</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="19" name="ext_panorama"><label>Panoráma</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="20" name="ext_biztonsagi_ajto"><label>Biztonsági ajtó</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="21" name="ext_redony"><label>Redőny</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="22" name="ext_racs"><label>Rács</label>
                                                </div>
                                            </div>
                                        </div>                                                                                  
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="23" name="ext_video_kaputelefon"><label>Videó kaputelefon</label>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="24" name="ext_porta_szolgalat"><label>Porta szolgálat</label>
                                                </div>
                                            </div>
                                        </div>                                                                                  
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="25" name="ext_beepitett_szekreny"><label>Beépített szekrény</label>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="26" name="ext_tarolo_helyiseg"><label>Tároló helyiség</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div> <!-- END ROW -->

                                </div>
                            </div>  


                            <!-- **************** CÍM ADATOK ************************ -->
                            <div class="portlet light bg-inverse">
                                <div class="portlet-title">
                                    <div class="caption font-green-sharp">
                                        <i class="icon-share font-green-sharp"></i>
                                        <span class="caption-subject bold uppercase"> Elhelyezkedés</span>
                                    </div>

                                </div>
                                <div class="portlet-body">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <!-- MEGYE MEGADÁSA -->
                                            <div class="form-group" id="megye_div">
                                                <label for="megye" class="control-label">Megye<span class="required">*</span></label>
                                                <select name="megye" id="megye_select" class="form-control">
                                                    <option value="">-- válasszon --</option>
                                                    <?php foreach ($county_list as $value) { ?>
                                                        <option value="<?php echo $value['county_id']; ?>" <?php echo ($value['county_id'] == 5) ? 'selected' : ''; ?>><?php echo $value['county_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <!-- VÁROS MEGADÁSA -->
                                            <div class="form-group" id="varos_div">
                                                <label for="varos" class="control-label">Város<span class="required">*</span></label>
                                                <select name="varos" id="varos_select" class="form-control">
                                                    <option value="88">Budapest</option>
                                                </select>
                                            </div>

                                            <!-- KERÜLET MEGADÁSA -->
                                            <div class="form-group" id="district_div">
                                                <label for="kerulet" class="control-label">Kerület <span></span></label>
                                                <select name="kerulet" id="district_select" class="form-control">
                                                    <option value="">-- válasszon --</option>
                                                    <?php foreach ($district_list as $value) { ?>
                                                        <option value="<?php echo $value['district_id']; ?>"><?php echo $value['district_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <!-- UTCA MEGADÁSA -->
                                            <div class="form-group">
                                                <label for="utca" class="control-label">Utca <small>(házszám nélkül)</small><span class="required">*</span></label>
                                                <input type="text" name="utca" id="utca_autocomplete" placeholder="" class="form-control" />
                                            </div>
                                            <!-- IRANYITOSZAM -->
                                            <div class="form-group">
                                                <label for="iranyitoszam" class="control-label">Irányítószám</label>
                                                <input type="text" name="iranyitoszam" id="iranyitoszam" placeholder="" class="form-control input-small" />
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!-- HAZSZAM -->
                                                    <div class="form-group">
                                                        <label for="hazszam" class="control-label">Házszám</label>
                                                        <input type="text" name="hazszam" id="hazszam" placeholder="" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <!-- EMELET/AJTÓ -->
                                                    <div class="form-group">
                                                        <label for="emelet" class="control-label">Emelet</label>
                                                        <select name="emelet" id="emelet" class="form-control">
                                                            <option value="">-- válasszon --</option>
                                                            <?php foreach ($ingatlan_emelet_list as $value) { ?>
                                                                <option value="<?php echo $value['emelet_id']; ?>"><?php echo $value['emelet_leiras_hu']; ?></option>
                                                            <?php } ?>                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!-- EMELET/AJTÓ -->
                                                    <div class="form-group">
                                                        <label for="emelet_ajto" class="control-label">Ajtó</label>
                                                        <input type="text" name="emelet_ajto" id="emelet_ajto" placeholder="" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <!-- ÉPÜLET SZINTJEINEK SZÁMA -->
                                                    <div class="form-group">
                                                        <label for="epulet_szintjei" class="control-label">Épület szinjei</label>
                                                        <select name="epulet_szintjei" id="epulet_szintjei" class="form-control">
                                                            <option value="">-- válasszon --</option>
                                                            <?php foreach ($ingatlan_emelet_list as $value) { ?>
                                                                <option value="<?php echo $value['emelet_id']; ?>"><?php echo $value['emelet_leiras_hu']; ?></option>
                                                            <?php } ?> 
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!-- FÖLDRAJZI SZÉLESSÉG -->
                                                    <div class="form-group">
                                                        <label for="latitude" class="control-label">Földrajzi szélesség</label>
                                                        <input type="text" name="latitude" id="latitude" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <!-- FÖLDRAJZI HOSSZÚSÁG -->
                                                    <div class="form-group">
                                                        <label for="longitude" class="control-label">Földrajzi hosszúság</label>
                                                        <input type="text" name="longitude" id="longitude" class="form-control" />
                                                    </div>
                                                </div>
                                            </div>                                            

                                            <!-- CHECKBOX-OK -->
                                            <div class="form-group">
                                                <div class="checkbox-list">
                                                    <label><input type="checkbox" name="tetoter"> Tetőtéri lakás</label>
                                                </div>
                                            </div>                                        

                                            <div class="form-group">
                                                <div class="checkbox-list">
                                                    <label><input type="checkbox" name="utca_megjelenites" checked=""> Utca megjelenítése az adatlapon</label>
                                                    <label><input type="checkbox" name="hazszam_megjelenites"> Házszám megjelenítése az adatlapon</label>
                                                    <label><input type="checkbox" name="terkep" checked=""> Térképes megjelenítés az adatlapon</label>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="col-md-6">
                                            <!-- BEGIN GEOCODING PORTLET-->
                                            <div class="note note-info">
                                                <small>A megye és város kiválasztása, valamint az utca, irónyítószám és házszám megadása után ellenőrizheti, hogy az ingatlan a megfelelő pozícióban jelenik-e meg a Google térképen.
                                                    <br /><br />
                                                    A földrajzi szélesség és földrajzi hosszúság mezők automatikusan megkapják a térképen megjelenített hely koordinátáit!
                                                </small>
                                            </div>
                                            <div class="portlet light portlet-fit bordered">
                                                <div class="portlet-title">
                                                    <div class="caption">
                                                        <i class=" icon-layers font-green"></i>
                                                        <span class="caption-subject font-green bold uppercase">Megjelenítés térképen</span>
                                                    </div>
                                                    <div class="actions">
                                                        <a class="btn btn-circle btn-icon-only btn-default" id="show_map" href="javascript:;">
                                                            <i class="icon-pin"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <div id="address_message"></div>
                                                    <div id="gmap_geocoding" class="gmaps"> </div>
                                                </div>
                                            </div>
                                            <!-- END GEOCODING PORTLET-->
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- LEÍRÁS -->


                            <div class="portlet light bg-inverse">
                                <div class="portlet-title">
                                    <div class="caption font-green-sharp">
                                        <i class="icon-share font-green-sharp"></i>
                                        <span class="caption-subject bold uppercase"> Megnevezés és leírás</span>
                                    </div>

                                </div>
                                <div class="portlet-body">

                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1_1" data-toggle="tab"> Magyar </a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_2" data-toggle="tab"> Angol </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade active in" id="tab_1_1">

                                            <!-- INGATLAN NEV -->
                                            <div class="form-group">
                                                <label for="ingatlan_nev_hu" class="control-label">Ingatlan megnevezés <small>(címként szereplő rövid leírás)</small></label>
                                                <input type="text" name="ingatlan_nev_hu" id="ingatlan_nev_hu" placeholder="" class="form-control" />
                                            </div>
                                            <!-- LAKÁS LEIRAS -->
                                            <div class="form-group">
                                                <label for="leiras_hu" class="control-label">Leírás</label>
                                                <textarea name="leiras_hu" id="leiras_hu" placeholder="" class="form-control input-xlarge" rows="10"></textarea>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="tab_1_2">

                                            <!-- INGATLAN NEV -->
                                            <div class="form-group">
                                                <label for="ingatlan_nev_en" class="control-label">Ingatlan megnevezés <small>(címként szereplő rövid leírás)</small></label>
                                                <input type="text" name="ingatlan_nev_en" id="ingatlan_nev_en" placeholder="" class="form-control" />
                                            </div>
                                            <!-- LAKÁS LEIRAS -->
                                            <div class="form-group">
                                                <label for="leiras_en" class="control-label">Leírás</label>
                                                <textarea name="leiras_en" id="leiras_en" placeholder="" class="form-control input-xlarge" rows="10"></textarea>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>





                            <div class="portlet light bg-inverse">
                                <div class="portlet-title">
                                    <div class="caption font-green-sharp">
                                        <i class="icon-share font-green-sharp"></i>
                                        <span class="caption-subject bold uppercase"> Tulajdonos adatai</span>
                                    </div>

                                </div>
                                <div class="portlet-body">
                                    <!-- TULAJDONOS ADATAI -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- TULAJ NEVE -->
                                            <div class="form-group">
                                                <label for="tulaj_nev" class="control-label">Név</label>
                                                <input type="text" name="tulaj_nev" id="tulaj_nev" placeholder="" class="form-control" />
                                            </div>
                                        </div>
                                        <!-- TULAJ CÍME -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tulaj_cim" class="control-label">Cím</label>
                                                <input type="text" name="tulaj_cim" id="tulaj_cim" placeholder="" class="form-control" />
                                            </div>
                                        </div>
                                        <!-- TULAJ TELEFONSZÁM -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tulaj_tel" class="control-label">Telefonszám</label>
                                                <input type="text" name="tulaj_tel" id="tulaj_tel" placeholder="" class="form-control" />
                                            </div>
                                        </div>
                                        <!-- TULAJ EMAIL -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tulaj_email" class="control-label">E-mail cím</label>
                                                <input type="text" name="tulaj_email" id="tulaj_email" placeholder="" class="form-control" />
                                            </div>
                                        </div>
                                        <!-- TULAJ MEGJEGYZÉS -->

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="tulaj_notes" class="control-label">Megjegyzés</label>
                                                <textarea name="tulaj_notes" id="tulaj_notes" class="form-control" rows="6"></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- KÉPEK -->
                            <div class="portlet light bg-inverse">
                                <div class="portlet-title">
                                    <div class="caption font-green-sharp">
                                        <i class="icon-share font-green-sharp"></i>
                                        <span class="caption-subject bold uppercase"> Képek feltöltése</span>
                                    </div>

                                </div>
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class ="alert alert-info">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <i class ="fa fa-info-circle"></i> Képek feltöltéséhez először mentse el az ingatlant (kattintson a "mentés és folytatás gombra") a kötelezően megadandó adatokkal, majd ezt követően tölthet fel képet. </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="portlet">
                                                <div class="portlet-body">
                                                    <h4 class="block">Feltöltött képek:</h4>
                                                    <ul id="photo_list">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">

                                            <div class="portlet">
                                                <div class="portlet-body">
                                                    <h4 class="block">Képek hozzáadása:</h4>
                                                    <input type="file" name="new_file[]" multiple="true" id="input-4" />
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- row END -->
                                </div>
                            </div>
                            
                            
                             <!-- ALAPRAJZOK -->
                            <div class="portlet light bg-inverse">
                                <div class="portlet-title">
                                    <div class="caption font-green-sharp">
                                        <i class="icon-share font-green-sharp"></i>
                                        <span class="caption-subject bold uppercase"> Alaprajzok feltöltése</span>
                                    </div>

                                </div>
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="portlet">
                                                <div class="portlet-body">
                                                    <h4 class="block">Feltöltött alaprajzok:</h4>
                                                    <ul id="alaprajz_list">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <!-- KÉPEK FELTÖLTÉSE -->
                                            <div class="portlet">
                                                <div class="portlet-body">
                                                    <h4 class="block">Alaprajz hozzáadása:</h4>
                                                    <input type="file" name="new_file[]" multiple="true" id="input-alaprajz" />
                                                </div>
                                            </div>		
                                        </div>
                                    </div> <!-- row END -->		
                                </div>
                            </div>                            
                            
                            <!-- DOKUMENTUMOK -->
                            <div class="portlet light bg-inverse">
                                <div class="portlet-title">
                                    <div class="caption font-green-sharp">
                                        <i class="icon-share font-green-sharp"></i>
                                        <span class="caption-subject bold uppercase"> Dokumentumok feltöltése</span>
                                    </div>

                                </div>
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class ="alert alert-info">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <i class ="fa fa-info-circle"></i> Dokumentumok (fájlok) feltöltéséhez először mentse el az ingatlant (kattintson a "mentés és folytatás gombra") a kötelezően megadandó adatokkal, majd ezt követően tölthet fel.  </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="portlet">
                                                <div class="portlet-body">
                                                    <h4 class="block">Feltöltött dokumentumok:</h4>
                                                    <ul id="dokumentumok" class="list-group">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">

                                            <div class="portlet">
                                                <div class="portlet-body">
                                                    <h4 class="block">Dokumentumok hozzáadása:</h4>
                                                    <input type="file" name="new_doc[]" multiple="true" id="input-5" />
                                                </div>
                                            </div>
                                        </div>

                                    </div> <!-- row END -->
                                </div>
                            </div>

                        </div>
                    </form>


                </div> <!-- END PORTLET 1 BODY-->


                <!-- Adatok "első" elküldése INSERT -->
                <button class="btn green" id="data_upload_ajax" type="button" name="save_data">Mentés és folytatás <i class="fa fa-check"></i></button>
                <!-- Adatok elküldése UPDATE és kilépés -->
                <button disabled style="display:none;" class="btn blue" id="data_update_ajax" type="button" name="update_data">Mentés és kilépés <i class="fa fa-check"></i></button>
                <!-- <button class="btn green" id="file_upload_ajax" type="button" name="save_file">Fileok <i class="fa fa-check"></i></button> -->
                <!-- <button class="btn green" type="button">Mentés <i class="fa fa-check"></i></button> -->
                <a class="btn default" id="button_megsem" href="admin/property">Mégsem <i class="fa fa-times"></i></a>


            </div> <!-- END PORTLET 1 -->

        </div> <!-- END COL-MD-12 -->
    </div> <!-- END ROW -->
</div> <!-- END PAGE CONTENT-->