<!-- BEGIN CONTENT -->
<div class="page-content">



    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">


            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-list"></i>Ingatlan adatai</div>
                    <div class="actions">
                        <a href="admin/property/update/<?php echo $property_data['id']; ?>" class="btn grey-steel btn-sm"><i class="fa fa-edit"></i> Adatok szerkesztése</a>
                        <a href="admin/property" class="btn blue-madison btn-sm"><i class="fa fa-arrow-left"></i> Vissza az ingatlanokhoz</a>

                    </div>
                </div>
                <div class="portlet-body">

                    <!-- **************** INGATLAN RÉSZLETEK ********************* --> 
                    <div class="row">			
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 clearfix">

                            <p class="well well-sm">Ingatlan adatok</p>

                            <div class="span12">
                                <h4><?php echo $property_data['ingatlan_nev_hu']; ?></h4>
                            </div>
                            <table class="table table-striped table-bordered table-condensed table-hover ">

                                <thead>
                                    <tr class="heading">
                                        <th colspan=2>Alap adatok</th>


                                    </tr>
                                </thead>

                                <tbody>

                                    <tr>
                                        <td>Azonosító:</td>
                                        <td><?php echo $property_data['id']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Referenciaszám:</td>
                                        <td><?php echo $property_data['ref_num']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Rögzítés / módosítás dátuma:</td>
                                        <td><?php echo date('Y-m-d H:i', $property_data['hozzaadas_datum']) . ' / ' . date('Y-m-d H:i', $property_data['modositas_datum']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Referens:</td>
                                        <td><?php echo $property_data['first_name'] . ' ' . $property_data['last_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Ingatlan státusza:</td>
                                        <td><?php echo ($property_data['status']) ? '<span class="label label-sm label-success">Aktív</span>' : '<span class="label label-sm label-danger">Inaktív</span>'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Megbízás típusa:</td>
                                        <td><?php echo ($property_data['tipus'] == '1') ? '<span class="label label-sm label-default">Eladó</span>' : '<span class="label label-sm label-primary">Kiadó</span>'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kategória:</td>
                                        <td><?php echo $property_data['kat_nev_hu']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kiemelt ajánlat:</td>
                                        <td><?php echo ($property_data['kiemeles']) ? '<span class="label label-sm label-info"><i class="fa fa-check"></i></span>' : '<span class="label label-sm label-default"><i class="fa fa-minus"></i></span>'; ?></td>
                                    </tr>

                                </tbody>
                            </table>



                            <table class="table table-striped table-bordered table-condensed table-hover ">
                                <thead>
                                    <tr class="heading">
                                        <th colspan=2>Elhelyezkedés és megjelenítés</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    if ($property_data['city_name'] != 'Budapest') {
                                        echo '<tr>';
                                        echo '<td>Megye:</td>';
                                        echo '<td>';
                                        echo $property_data['county_name'];
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                    <tr>
                                        <td>Város:</td>
                                        <td><?php echo $property_data['city_name']; ?></td>
                                    </tr>
                                    <?php
                                    if ($property_data['kerulet']) {
                                        echo '<tr>';
                                        echo '<td>Kerület:</td>';
                                        echo '<td>';
                                        echo $property_data['kerulet'] . '.';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                    <tr>
                                        <td>Irányítószám:</td>
                                        <td>
                                            <?php echo $property_data['iranyitoszam']; ?>
                                    </tr> 
                                    <tr>
                                        <td>Cím:</td>
                                        <td>
                                            <?php
                                            echo $property_data['utca'] . '&nbsp';
                                            echo $property_data['hazszam'] . '&nbsp';
                                            echo (!empty($property_data['emelet'])) ? $property_data['emelet'] . '. emelet ' : '';
                                            echo (!empty($property_data['emelet_ajto'])) ? $property_data['emelet_ajto'] : '';
                                            ?>
                                    </tr>
                                    <tr>
                                        <td>Tetőtéri lakás:</td>
                                        <td><?php echo ($property_data['tetoter']) ? '<span class="label label-sm label-info"><i class="fa fa-check"></i></span>' : '<span class="label label-sm label-default"><i class="fa fa-minus"></i></span>'; ?></td>
                                    </tr> 
                                    <tr>
                                        <td>Megjelenítés térképen:</td>
                                        <td><?php echo ($property_data['terkep']) ? '<span class="label label-sm label-info"><i class="fa fa-check"></i></span>' : '<span class="label label-sm label-default"><i class="fa fa-minus"></i></span>'; ?></td>
                                    </tr> 
                                    <tr>
                                        <td>Utca megjelenítés:</td>
                                        <td><?php echo ($property_data['utca_megjelenites']) ? '<span class="label label-sm label-info"><i class="fa fa-check"></i></span>' : '<span class="label label-sm label-default"><i class="fa fa-minus"></i></span>'; ?></td>
                                    </tr> 
                                    <tr>
                                        <td>Házszám megjelenítés:</td>
                                        <td><?php echo ($property_data['hazszam_megjelenites']) ? '<span class="label label-sm label-info"><i class="fa fa-check"></i></span>' : '<span class="label label-sm label-default"><i class="fa fa-minus"></i></span>'; ?></td>
                                    </tr>
                                </tbody>
                            </table>



                            <table class="table table-striped table-bordered table-condensed table-hover ">
                                <thead>
                                    <tr class="heading">
                                        <th colspan=2>Leírás és információk</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>Megnevezés:</td>
                                        <td><?php echo $property_data['ingatlan_nev_hu']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Leírás:</td>
                                        <td><?php echo $property_data['leiras_hu']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo ($property_data['tipus'] == '1') ? 'Eladási ár:' : 'Bérleti díj:';
                                            ?>
                                        </td>
                                        <td><b><?php echo ($property_data['tipus'] == '1') ? number_format($property_data['ar_elado'], 0, ',', '.') . ' Ft' : number_format($property_data['ar_kiado'], 0, ',', '.') . ' Ft'; ?></b></td>
                                    </tr>


                                    <tr>
                                        <td>Alapterület:</td>
                                        <td>
                                            <?php echo $property_data['alapterulet'] . ' m&sup2;'; ?>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td>Szobaszám:</td>
                                        <td><?php echo $property_data['szobaszam']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Félszobák:</td>
                                        <td><?php echo $property_data['felszobaszam']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ingatlan állapota:</td>
                                        <td><?php echo $property_data['all_leiras_hu']; ?></td>
                                    </tr>
                                    <tr> 
                                        <td>Közös költség:</td>
                                        <td><?php echo (isset($property_data['kozos_koltseg'])) ? $property_data['kozos_koltseg'] . ' Ft' : 'n.a.'; ?>
                                        </td>
                                    </tr>
                                    <tr> 
                                        <td>Átlagos rezsi:</td>
                                        <td><?php echo (isset($property_data['rezsi'])) ? $property_data['rezsi'] . ' Ft' : 'n.a.'; ?>
                                        </td>
                                    </tr>
                                    <tr> 
                                        <td>Emelet:</td>
                                        <td><?php echo (isset($property_data['emelet'])) ? $property_data['emelet'] . '.' : '-'; ?>
                                        </td>
                                    </tr>

                                    <?php
                                    if ($property_data['emelet']) {

                                        echo '<tr>';
                                        echo '<td>Épület szintjei:</td>';
                                        echo '<td>';
                                        echo ($property_data['epulet_szintjei']) ? $property_data['epulet_szintjei'] : 'n.a.';
                                        ;
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                    ?>





                                </tbody>
                            </table>

                            <table class="table table-striped table-bordered table-condensed table-hover ">
                                <thead>
                                    <tr class="heading">
                                        <th colspan=2>Jellemzők</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>Állapot:</td>
                                        <td><?php echo ($property_data['all_leiras_hu']) ? $property_data['all_leiras_hu'] : 'n.a.'; ?></td>
                                    </tr>                                        

                                    <tr>
                                        <td>Fűtés:</td>
                                        <td><?php echo ($property_data['futes_leiras_hu']) ? $property_data['futes_leiras_hu'] : 'n.a.'; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Parkolás:</td>
                                        <td><?php echo ($property_data['parkolas_leiras_hu']) ? $property_data['parkolas_leiras_hu'] : 'n.a.'; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Kilátás:</td>
                                        <td><?php echo ($property_data['kilatas_leiras_hu']) ? $property_data['kilatas_leiras_hu'] : 'n.a.'; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Energetika:</td>
                                        <td><?php echo ($property_data['energetika_leiras_hu']) ? $property_data['energetika_leiras_hu'] : 'n.a.'; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Kert:</td>
                                        <td><?php echo ($property_data['kert_leiras_hu']) ? $property_data['kert_leiras_hu'] : 'n.a.'; ?></td>
                                    </tr>                                        

                                    <tr>
                                        <td>Lift:</td>
                                        <td><?php echo ($property_data['lift'] == 1) ? '<span class="label label-sm label-info"><i class="fa fa-check"></i></span>' : '<span class="label label-sm label-default"><i class="fa fa-minus"></i></span>'; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Bútorozott:</td>
                                        <td><?php echo ($property_data['butor'] == 1) ? '<span class="label label-sm label-info"><i class="fa fa-check"></i></span>' : '<span class="label label-sm label-default"><i class="fa fa-minus"></i></span>'; ?></td>
                                    </tr>


                                </tbody>
                            </table>


                            <table class="table table-striped table-bordered table-condensed table-hover ">
                                <thead>
                                    <tr class="heading">
                                        <th colspan=2>Extrák</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan=2>
                                            <?php
                                            echo ($property_data['erkely']) ? 'erkély, ' : '';
                                            echo ($property_data['terasz']) ? 'terasz, ' : '';
                                            echo ($property_data['medence']) ? 'medence, ' : '';
                                            echo ($property_data['szauna']) ? 'szauna, ' : '';
                                            echo ($property_data['jacuzzi']) ? 'jacuzzi, ' : '';
                                            echo ($property_data['kandallo']) ? 'kandalló, ' : '';
                                            echo ($property_data['riaszto']) ? 'riasztó, ' : '';
                                            echo ($property_data['klima']) ? 'klíma, ' : '';
                                            echo ($property_data['ontozorendszer']) ? 'öntözőrendszer, ' : '';
                                            echo ($property_data['automata_kapu']) ? 'automata kapu, ' : '';
                                            echo ($property_data['elektromos_redony']) ? 'elektromos redőny, ' : '';
                                            echo ($property_data['konditerem']) ? 'konditerem ' : '';
                                            ?>	

                                        </td></tr>
                                </tbody>
                            </table>

                            <!-- ************* MÁSODIK OSZLOP KÉPEKKEL ÉS DOKUMENTUMOKKAL ******** -->                        

                        </div><!-- end of col-6 -->

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 clearfix margin-bottom-10">
                            <p class="well well-sm">Feltöltött képek</p>

                            <?php
                                if (!empty($photos)) {
                                    foreach ($photos as $img) { ?>
                                    <div class="col-lg-6 margin-bottom-10">
                                        <a class="fancybox" href="<?php echo $this->getConfig('ingatlan_photo.upload_path') . $img; ?>" rel="image-group">  
                                            <img class="img-thumbnail" src="<?php echo $this->url_helper->thumbPath($this->getConfig('ingatlan_photo.upload_path') . '/' . $img, false, 'small'); ?>" alt="">
                                        </a>
                                    </div>
                            <?php }} ?>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 clearfix">
                            <p class="well well-sm">Feltöltött dokumentumok</p>

                            <?php
                            if (count($docs) > 0) {
                                foreach ($docs as $doc) {

                                    echo '<div class="col-lg-6 margin-bottom-20">';
                                    echo '<a href="admin/property/download/' . $doc . '">';
                                    echo '<i class="fa fa-file"></i> ' . $doc . '</a>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p>Az ingatlanhoz nincs dokumentum feltöltve!</p>';
                            }
                            ?>




                        </div>


                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 clearfix ">
                            <p class="well well-sm">Ingatlan adatlap</p>
                            <p class="margin-bottom-20">
                                <a id="generate_pdf" class="print-datasheet" href="ingatlanok/adatlap_nyomtatas/<?php echo $property_data['id']; ?>"><i class="fa fa-print"></i> Adatlap nyomtatás</a>
                            </p>



                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 clearfix">
                            <p class="well well-sm">Tulajdonos adatai</p>

                            <table class="table table-striped table-bordered table-condensed table-hover ">
                                <thead>
                                    <tr class="heading">
                                        <th colspan=2>Név, elérhetőségek, feljegyzések</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>Név:</td>
                                        <td><?php echo $property_data['tulaj_nev']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Telefonszám:</td>
                                        <td><?php echo '+' . preg_replace("/-/", " ", $property_data['tulaj_tel']); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>E-mail:</td>
                                        <td><?php echo $property_data['tulaj_email']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cím:</td>
                                        <td><?php echo $property_data['tulaj_cim']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Feljegyzések:</td>
                                        <td>
                                            <?php echo $property_data['tulaj_notes']; ?>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>





                    </div> <!-- end of row -->	


                </div> <!-- END PORTLET BODY -->
            </div> <!-- END PORTLET -->



        </div>
    </div>
</div> <!-- END PAGE CONTENT-->