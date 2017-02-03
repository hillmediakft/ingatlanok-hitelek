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
            <li><span>Jellemzők - fűtés kategória</span></li>
        </ul>
    </div>
    <!-- END PAGE TITLE & BREADCRUMB-->
    <!-- END PAGE HEADER-->

    <div class="margin-bottom-20"></div>

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            
            <!-- ÜZENETEK MEGJELENÍTÉSE -->
            <div id="ajax_message"></div> 
            
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-file-text-o"></i>Ingatlan fűtés kategória lista</div>

                        <div class="actions">
                            <div class="btn-group">
                                    <button id="futes_new" class="btn blue">
                                        <i class="fa fa-plus"></i> Új fűtés kategória 
                                    </button>
                                </div>
                        </div>

                    </div>
                <div class="portlet-body">

                    <!-- ennek a div elemnek a data-marker attribútuma adja meg a javascriptnek, hogy melyik lista adataival kell dolgozni -->
                    <div id="table-marker" data-marker="futes" style="display: none;"></div> 

                    <table class="table table-striped table-hover table-bordered" id="futes">
                        <thead>
                            <tr>
                                <th>
                                    #id
                                </th>
                                <th>
                                    Fűtés kategória megnevezése magyar
                                </th>
                                <th>
                                    Fűtés kategória megnevezése angol
                                </th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php foreach ($futes as $value) { ?>
                            <tr>
                                <td>
                                    <?php echo $value['futes_id'];?>
                                </td>
                                <td>
                                    <?php echo $value['futes_leiras_hu'];?>
                                </td>
                                <td>
                                    <?php echo $value['futes_leiras_en'];?>
                                </td>
                                <td>
                                    <a class="edit" href="javascript:;">
                                        <i class="fa fa-edit"></i> Szerkeszt </a>
                                </td>
                                <td>
                                    <a class="delete" href="javascript:;">
                                        <i class="fa fa-trash"></i> Töröl </a>
                                </td>
                            </tr>
                            <?php } ?>	  
                          
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div> <!-- END PAGE CONTENT -->
</div>