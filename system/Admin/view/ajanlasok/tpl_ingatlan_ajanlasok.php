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
                <span>Elküldött ingatlan ajanlasok</span>
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

            <form class="horizontal-form" id="ajanlasok_form" method="POST" action="">

                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-envelope"></i>Elküldött ingatlan ajánlások</div>

                        <div class="actions">

                            <div class="btn-group">
                                <a data-toggle="dropdown" class="btn btn-sm default">
                                    <i class="fa fa-wrench"></i> Eszközök <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a id="print_ajanlasok"><i class="fa fa-print"></i> Nyomtat </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="portlet-body">

                        <!-- *************************** USERS TÁBLA *********************************** -->                        

                        <table class="table table-striped table-bordered table-hover" id="ajanlasok">
                            <thead>
                                <tr class="heading">
                                    <th>Dátum</th>
                                    <th>Név</th>
                                    <th>Email</th>
                                    <th>Referens</th>
                                    <th style="width: 1%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ajanlasok as $ajanlas) { ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo date('Y-m-d', $ajanlas['date']); ?></td>
                                        <td><?php echo $ajanlas['name']; ?></td>
                                        <td><?php echo $ajanlas['email']; ?></td>
                                        <td><?php echo $ajanlas['ref_name']; ?></td>
                                        <td><a class="btn btn-sm grey-steel" data-id="<?php echo $ajanlas['id']; ?>" data-action="show" id="show_modal_<?php echo $ajanlas['id']; ?>"><i class="fa fa-eye"></i></a></td>
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

</div><!-- END PAGE CONTENT--> 
<div class="modal fade" tabindex="-1" role="dialog" id="ajanlas_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Elküldött ajánlatok</h4>
            </div>
            <div class="modal-body">
                <div id="ajanlas_modal_content"></div>
            </div>
            <div class="modal-footer">
                <button id="print_ajanlasok_modal" type="button" class="btn blue">Nyomtatás</button>
                <button type="button" class="btn default" data-dismiss="modal">Bezár</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->