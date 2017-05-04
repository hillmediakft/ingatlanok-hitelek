<?php 
use System\Libs\Auth;    
?>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="admin/home">Kezdőoldal</a> 
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <span>Törölt ingatlanok</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE TITLE & BREADCRUMB-->
    <!-- END PAGE HEADER-->

    <div class="margin-bottom-20"></div>

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->

            <!-- ÜZENETEK -->
            <div id="ajax_message"></div>                       
            <?php $this->renderFeedbackMessages(); ?>               

            <form class="horizontal-form" id="deleted_property_form" method="POST" action="">

                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-user"></i>Törölt ingatlanok</div>

                        <div class="actions">
                            <button class="btn red btn-sm" id="delete_group" type="button" title="Az ingatanok végleges törlése!"><i class="fa fa-trash"></i> Csoportos törlés</button>
                            <button class="btn green btn-sm" id="redo_group" type="button" title="Az ingatanok helyreállítása!"><i class="fa fa-trash"></i> Csoportos helyreállítás</button>
                        </div>

                    </div>
                    <div class="portlet-body">

                        <!-- *************************** TÖRÖLT INGATLANOK TÁBLA *********************************** -->                        

                        <table class="table table-striped table-bordered table-hover table-checkable" id="deleted_property">
                            <thead>
                                <tr>
                                    <th class="table-checkbox">
                                        <input type="checkbox" class="group-checkable" data-set="#deleted_property .checkboxes"/>
                                    </th>
                                    <th width="1%" title="Az ingatlan azonosító száma">id</th>
                                    <th width="1%" title="Az ingatlan referencia száma">ref.szám</th>
                                    <th width="1%">Kép</th>
                                    <th>Referens</th>
                                    <th width="1%">Típus</th>
                                    <th width="1%">Kategória</th>
                                    <th>Város</th>
                                    <th width="1%">Ár(Ft)</th>
                                    <!-- MENÜ -->
                                    <th width="1%"></th>
                                </tr>
                            </thead>


                            <tbody>
                                <?php foreach ($ingatlanok as $property) { ?>
                                <tr class="odd gradeX">
                                    <td>
                                        <input type="checkbox" class="checkboxes" name="property_id_<?php echo $property['id']; ?>" value="<?php echo $property['id']; ?>"/>
                                    </td>
                                    
                                    <td><?php echo $property['id']; ?></td>

                                    <td>#<?php echo $property['ref_num']; ?></td>

                                    <?php
                                        if (!empty($property['kepek'])) {
                                            $photos = json_decode($property['kepek']);
                                            $photo = $this->url_helper->thumbPath($this->getConfig('ingatlan_photo.upload_path') . $photos[0]);
                                        } else {
                                            $photo = $this->getConfig('ingatlan_photo.placeholder_thumb');
                                        } 
                                    ?>
                                    <td><img src="<?php echo $photo; ?>" width="80" height="60"/></td>
                                    
                                    <td><?php echo $property['first_name'] . ' ' . $property['last_name']; ?></td>

                                    <td><?php echo ($property['tipus'] == 1) ? 'eladó' : 'kiadó'; ?></td>

                                    <td><?php echo $property['kategoria']; ?></td>

                                    <td>
                                    <?php
                                        $kerulet = !empty($property['district_name']) ? '<br>' . $property['district_name'] . ' kerület' : '';
                                        echo $property['city_name'] . $kerulet;
                                    ?>
                                    </td>

                                    <td><?php echo (!empty($property['ar_elado'])) ? $this->num_helper->niceNumber($property['ar_elado']) : $this->num_helper->niceNumber($property['ar_kiado']); ?></td>

                                    <td>                                    
                                        <div class="actions">
                                            <div class="btn-group">

                                                <a class="btn btn-sm grey-steel" title="műveletek" data-toggle="dropdown"><i class="fa fa-cogs"></i></a>
                                                <ul class="dropdown-menu pull-right">
                                                    <li><a href="<?php echo $this->request->get_uri('site_url') . 'property/details/' . $property['id'] ?>"><i class="fa fa-eye"></i> Részletek</a></li>
                                                    <li><a class="redo_item" data-id="<?php echo $property['id']; ?>"> <i class="fa fa-trash"></i> Helyreállítás</a></li>
                                                    <li><a class="delete_item" data-id="<?php echo $property['id']; ?>"> <i class="fa fa-trash"></i> Végleges törlés</a></li>
                                                </ul>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>  
                            </tbody>

                        </table>    

                    </div>
                </div>
            </form>                 
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>

</div><!-- END PAGE CONTAINER-->    