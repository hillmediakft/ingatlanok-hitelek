<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <!-- <h3 class="page-title">felugró ablak <small>szerkesztése</small></h3> -->
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
            <li><span>Felugró ablakok szerkesztése</span></li>
        </ul>
    </div>
    <!-- END PAGE TITLE & BREADCRUMB-->
    <!-- END PAGE HEADER-->

    <div class="margin-bottom-20"></div>

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">

            <!-- ÜZENETEK -->
            <div id="ajax_message"></div> 
            <?php $this->renderFeedbackMessages(); ?>

            <form action="" method="POST" id="update_pop_up_window">	

                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-edit"></i>
                            Felugró ablak szerkesztése
                        </div>
                        <div class="actions">
                            <!-- <button class="btn green submit" type="submit" value="submit" name="submit_update_pop_up_window">Mentés <i class="fa fa-check"></i></button> -->
                            <button class="btn green btn-sm" type="submit"><i class="fa fa-check"></i> Mentés</button>
                            <a class="btn default btn-sm" href="admin/pop_up_windows"><i class="fa fa-close"></i> Mégsem</a>
                        </div>
                    </div>

                    <div class="portlet-body">

                        <div class="row">   
                            <div class="col-md-12">                     

                                <div class="form-group">
                                    <label for="title" class="control-label">Cím</label>
                                    <input type="text" name="title" id="title" value="<?php echo $data_arr[0]['title']; ?>" class="form-control input-xlarge" />
                                </div>

                                <div class="form-group">
                                    <label for="promotion_text" class="control-label">Leírás</label>
                                    <input type="text" name="description" id="description" value="<?php echo $data_arr[0]['description']; ?>" class="form-control input-xlarge" />                         
                                </div>

                                <div class="form-group">
                                    <label for="promotion_status">Státusz</label>
                                    <select name='status' id='status' class="form-control input-xlarge">
                                        <option value="0" <?php echo($data_arr[0]['status'] == 0) ? 'selected' : '';?>>Inaktív</option>
                                        <option value="1" <?php echo($data_arr[0]['status'] == 1) ? 'selected' : '';?>>Aktív</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="promotion_text" class="control-label">Tartalom</label>
                                    <textarea name="content" id="content" class="form-control input-xlarge"><?php echo $data_arr[0]['content']; ?></textarea>
                                </div>

                            </div>
                        </div>                        

                    </div> <!-- END USER GROUPS PORTLET BODY-->
                </div> <!-- END USER GROUPS PORTLET-->

            </form>

        </div> <!-- END COL-MD-12 -->
    </div> <!-- END ROW -->	
</div> <!-- END PAGE CONTENT-->    