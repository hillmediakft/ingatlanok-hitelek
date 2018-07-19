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
            <li><span>Budapest kerületek</span></li>
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
                        <div class="caption"><i class="fa fa-file-text-o"></i>Budapest kerület lista</div>

                        <div class="actions">
                            <div class="btn-group">
                                    <button id="insert_button" class="btn blue">
                                        <i class="fa fa-plus"></i> Új kerület 
                                    </button>
                                </div>
                            

                        </div>

                    </div>
                <div class="portlet-body">

                    <table class="table table-striped table-hover table-bordered" id="districts">
                        <thead>
                            <tr class="heading">
                                <th>
                                    Kerület
                                </th>
                                <th>
                                    Referens
                                </th>
                                <th style="width:0px; min-width:100px;"></th>
                                <th style="width:0px; min-width:100px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php foreach ($districts as $district) { ?>
                            <tr data-id="<?php echo $district['district_id'];?>">
                                <td>
                                    <?php echo $district['district_name'];?>
                                </td>
                                <td data-agent-id="<?php echo $district['agent_id']; ?>">
                                    <?php
                                        foreach ($agents as $agent) {
                                            if ($agent['id'] == $district['agent_id']) {
                                                echo $agent['first_name'] . ' ' . $agent['last_name'];
                                            }
                                        }
                                    ?>
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
<script type="text/javascript">
    var global_agents_list = <?php echo json_encode($agents); ?>;
</script>