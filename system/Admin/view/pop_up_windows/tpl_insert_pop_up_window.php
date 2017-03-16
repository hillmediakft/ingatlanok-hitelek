<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <!-- <h3 class="page-title">Új akció <small>hozzáadása</small></h3> -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="admin/home">Kezdőoldal</a> 
                <i class="fa fa-angle-right"></i>
                <i class="fa fa-windows"></i>
                <a href="admin/pop_up_windows">Pop up elemek listája</a>                 
                <i class="fa fa-angle-right"></i>
            </li>
            <li><span>Pop up ablak elem hozzáadása</span></li>
        </ul>
    </div>
    <!-- END PAGE TITLE & BREADCRUMB-->
    <!-- END PAGE HEADER-->

    <div class="margin-bottom-20"></div>

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">

            <!-- echo out the system feedback (error and success messages) -->
            <div id="ajax_message"></div>
            <?php $this->renderFeedbackMessages(); ?>           
                            
            <form action="" method="POST" id="new_pop_up_window" enctype="multipart/form-data">	

                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-windows"></i>
                            Új felugró ablak
                        </div>
                        <div class="actions">
                            <!-- <button class="btn green submit" type="submit" value="submit" name="submit_new_pop_up_window">Mentés <i class="fa fa-check"></i></button> -->
                            <button class="btn green btn-sm" type="submit"><i class="fa fa-check"></i> Mentés</button>
                            <a class="btn default btn-sm" href="admin/pop_up_windows"><i class="fa fa-close"></i> Mégsem</a>
                        </div>                    
                    </div>
                    <div class="portlet-body">
                        <div class="row">   
                            <div class="col-md-12">                     

                                <div class="form-group">
                                    <label for="title" class="control-label">Cím</label>
                                    <input type="text" name="title" id="title" placeholder="A felugró ablak címe" class="form-control input-xlarge" />
                                </div>

                                <div class="form-group">
                                    <label for="promotion_text" class="control-label">Leírás</label>
                                    <input type="text" name="description" id="description" placeholder="A felugró ablak leírása" class="form-control input-xlarge" />                         
                                </div>

                                <div class="form-group">
                                    <label for="promotion_status">Státusz</label>
                                    <select name='status' id='status' class="form-control input-xlarge">
                                        <option value="0">Inaktív</option>
                                        <option value="1">Aktív</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="promotion_text" class="control-label">Tartalom</label>
                                        <textarea name="content" id="content" placeholder="" class="form-control input-xlarge"></textarea>
                                </div>

                            </div>
                        </div>  

                    </div> <!-- END USER GROUPS PORTLET BODY-->
                </div> <!-- END USER GROUPS PORTLET-->

            </form>

        </div> <!-- END COL-MD-12 -->
    </div> <!-- END ROW -->	
</div> <!-- END PAGE CONTENT-->    