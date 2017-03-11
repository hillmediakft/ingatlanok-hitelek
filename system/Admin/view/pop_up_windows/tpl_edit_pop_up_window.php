<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            felugró ablak <small>szerkesztése</small>
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

                <div class="row">
                    <div class="col-lg-12 margin-bottom-20">
                        <a class ='btn btn-default' href='admin/pop_up_windows'><i class='fa fa-arrow-left'></i>  Vissza a felugró ablakokhoz</a>
                    </div>
                </div>	

                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-edit"></i>Felugró ablak szerkesztése</div>

                    </div>
                    <div class="portlet-body">

                        <div class="space10"></div>							
                        <div class="row">	
                            <div class="col-md-12">						
                                <form action="" method="POST" id="update_pop_up_window">	

                                    <div class="form-group">
                                        <label for="title" class="control-label">Felugró ablak címe</label>
                                        <input type="text" name="title" id="title" value="<?php echo $data_arr[0]['title']; ?>" class="form-control input-xlarge" />
                                    </div>
                                    <div class="form-group">
                                        <label for="promotion_text" class="control-label">Felugró ablak leírás</label>
                                        <input type="text" name="description" id="description" value="<?php echo $data_arr[0]['description']; ?>" class="form-control input-xlarge" />                         
                                    </div>

                                    <div class="form-group">
                                        <label for="promotion_text" class="control-label">Felugró ablak tartalom</label>
                                        <textarea name="content" id="content" class="form-control input-xlarge"><?php echo $data_arr[0]['content']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="promotion_status">Felugró ablak státusz</label>
                                        <select name='status' id='status' class="form-control input-xlarge">
                                            <option value="">-- Válasszon --</option>
                                            <option value="1" <?php echo($data_arr[0]['status'] == 1) ? 'selected' : '';?>>Aktív</option>
                                            <option value="0" <?php echo($data_arr[0]['status'] == 0) ? 'selected' : '';?>>Inaktív</option>
                                        </select>
                                    </div>

                                    <div class="space10"></div>
                                    <button class="btn green submit" type="submit" value="submit" name="submit_update_pop_up_window">Mentés <i class="fa fa-check"></i></button>
                                </form>
                            </div>
                        </div>                        

								

                    </div> <!-- END USER GROUPS PORTLET BODY-->
                </div> <!-- END USER GROUPS PORTLET-->
            </div> <!-- END COL-MD-12 -->
        </div> <!-- END ROW -->	
    </div> <!-- END PAGE CONTENT-->    
</div> <!-- END PAGE CONTENT WRAPPER -->
</div> <!-- END CONTAINER -->