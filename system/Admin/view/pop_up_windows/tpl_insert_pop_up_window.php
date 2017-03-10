<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Új akció <small>hozzáadása</small>
        </h3>


        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="admin/home">Kezdőoldal</a> 
                    <i class="fa fa-angle-right"></i>
                </li>
                <li><a href="#">Új akció</a></li>
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
                        <div class="caption"><i class="fa fa-film"></i>Új felugró ablak</div>

                    </div>

                    <div class="portlet-body">


                        <div class="space10"></div>							
                        <div class="row">	
                            <div class="col-md-12">						
                                <form action="" method="POST" id="new_pop_up_window" enctype="multipart/form-data">	

                                    <div class="form-group">
                                        <label for="title" class="control-label">Felugró ablak címe</label>
                                        <input type="text" name="title" id="title" placeholder="A felugró ablak címe" class="form-control input-xlarge" />
                                    </div>
                                    <div class="form-group">
                                        <label for="promotion_text" class="control-label">Felugró ablak leírás</label>
                                        <input type="text" name="description" id="description" placeholder="A felugró ablak leírása" class="form-control input-xlarge" />                         
                                    </div>

                                    <div class="form-group">
                                        <label for="promotion_text" class="control-label">Felugró ablak tartalom</label>
                                            <textarea name="content" id="content" placeholder="" class="form-control input-xlarge"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="promotion_status">Felugró ablak státusz</label>
                                        <select name='status' id='status' class="form-control input-xlarge">
                                            <option value="">-- Válasszon --</option>
                                            <option value="1">Aktív</option>
                                            <option value="0">Inaktív</option>
                                        </select>
                                    </div>

                                    <div class="space10"></div>
                                    <button class="btn green submit" type="submit" value="submit" name="submit_new_pop_up_window">Mentés <i class="fa fa-check"></i></button>
                                </form>
                            </div>
                        </div>	


                        <div id="message"></div> 


                    </div> <!-- END USER GROUPS PORTLET BODY-->
                </div> <!-- END USER GROUPS PORTLET-->
            </div> <!-- END COL-MD-12 -->
        </div> <!-- END ROW -->	
    </div> <!-- END PAGE CONTENT-->    
</div> <!-- END PAGE CONTENT WRAPPER -->
</div> <!-- END CONTAINER -->