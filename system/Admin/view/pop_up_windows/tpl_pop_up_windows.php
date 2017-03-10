<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Felugró ablakok <small>Kezelése</small>
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="admin/home">Kezdőoldal</a> 
                    <i class="fa fa-angle-right"></i>
                </li>
                <li><a href="#">Felugró ablakok szerkesztése</a></li>
            </ul>
        </div>
        <!-- END PAGE TITLE & BREADCRUMB-->
        <!-- END PAGE HEADER-->


        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">

                <!-- echo out the system feedback (error and success messages) -->
                <?php $this->renderFeedbackMessages(); ?>	

                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-windows"></i>Felugró ablakok</div>
                        <div class="actions">
                            <a class="btn blue btn-sm" href="admin/pop_up_windows/insert"><i class="fa fa-plus"></i> Új felugró ablak</a>
                        </div>
                    </div>
                    <div class="portlet-body">


                        <table class="table table-striped table-bordered table-hover" id="content">
                            <thead>
                                <tr class="heading">
                                    <th style="width:50px">#id</th>
                                    <th>Cím</th>
                                    <th>Leírás</th>
                                    <th style="width:50px">Státusz</th>
                                    <th style="width:110px"></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($all_pop_up_windows as $value) { ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $value['id']; ?></td>

                                        <td><?php echo $value['title']; ?></td>
                                        <td><?php echo $value['description']; ?></td>
                                        <?php if ($value['status'] == 1) { ?>
                                            <td><span class="label label-sm label-success">Aktív</span></td>
                                        <?php } ?>
                                        <?php if ($value['status'] == 0) { ?>
                                            <td><span class="label label-sm label-danger">Inaktív</span></td>
                                        <?php } ?>

                                        <td>
                                            <div class="actions">
                                                <div class="btn-group">
                                                    <a class="btn btn-sm green" href="#" data-toggle="dropdown">
                                                        <i class="fa fa-cogs"></i> Műveletek
                                                        <i class="fa fa-angle-down"></i>
                                                    </a>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li><a href="admin/pop_up_windows/edit/<?php echo $value['id']; ?>"><i class="fa fa-pencil"></i> Szerkeszt</a></li>
                                                        <li><a href="admin/pop_up_windows/delete/<?php echo $value['id']; ?>" id="delete_<?php echo $value['id']; ?>"><i class="fa fa-trash"></i> Töröl</a></li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                <?php } ?>					

                            </tbody>
                        </table>
                    </div> <!-- END USER GROUPS PORTLET BODY-->
                </div> <!-- END USER GROUPS PORTLET-->
            </div> <!-- END COL-MD-12 -->
        </div> <!-- END ROW -->	
    </div> <!-- END PAGE CONTENT-->    
</div> <!-- END PAGE CONTENT WRAPPER -->
</div> <!-- END CONTAINER -->