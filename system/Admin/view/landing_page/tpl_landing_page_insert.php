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
            <li><span>Érkezési oldal hozzáadása</span></li>
        </ul>
    </div>
    <!-- END PAGE TITLE & BREADCRUMB-->
    <!-- END PAGE HEADER-->

    <div class="margin-bottom-20"></div>
	
	<!-- BEGIN PAGE CONTENT-->
	<div class="row">
		<div class="col-md-12">
            <form action="" id="page_insert_form" name="page_insert_form" method='POST'>

				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet">

                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i> 
                                Érkezési oldal hozzáadása
                            </div>
                            <div class="actions">
                                <button class="btn green btn-sm" type="submit" name="page_insert_submit"><i class="fa fa-check"></i> Mentés</button>
                                <a class="btn default btn-sm" href="admin/landingpage"><i class="fa fa-close"></i> Mégsem</a>
                            </div>							
                        </div>                        
                                        
					    <div class="portlet-body">

                            <div class="form-group">
                                <label for="status">Státusz</label>
                                <select name="status" class="form-control input-small">
                                    <option value="0">Inaktív</option>
                                    <option value="1">Aktív</option>
                                </select>
                            </div>

                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_1_1" data-toggle="tab"> Magyar </a>
                                </li>
                                <li>
                                    <a href="#tab_1_2" data-toggle="tab"> Angol </a>
                                </li>

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="tab_1_1">

                                    <div class="form-group">
                                        <label for="page_title_hu">Az oldal neve</label>   
                                        <input type='text' name='page_title_hu' class='form-control' required>
                                    </div>

                                    <div class="form-group">
                                        <label for="page_friendlyurl_">Url (csak ékezet nélküli kisbetűt, számot és kötőjelet tartalamzhat)</label> 
                                        <input type='text' name='page_friendlyurl_hu' class='form-control' pattern="[\-a-z0-9]+" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="page_metatitle_hu">Az oldal címe (metacím)</label>   
                                        <input type='text' name='page_metatitle_hu' class='form-control' value=""/>
                                    </div>

                                    <div class="form-group">
                                        <label for="page_metadescription_hu">Az oldal leírása (metaleírás)</label>  
                                        <input type='text' name='page_metadescription_hu' class='form-control' value="">
                                    </div>

                                    <div class="form-group">
                                        <label for="page_metakeywords_hu">Kulcsszavak</label>
                                        <input type='text' name='page_metakeywords_hu' class='form-control' value="">
                                    </div>

                                    <div class="form-group">
                                        <label for="page_body_hu">Tartalom</label>
                                        <textarea type="text" name="page_body_hu" class="form-control"></textarea>
                                    </div>
                                    
                                </div>
                                <div class="tab-pane fade" id="tab_1_2">
                        
                                    <div class="form-group">
                                        <label for="page_title_en">Az oldal neve</label>   
                                        <input type='text' name='page_title_en' class='form-control'>
                                    </div>

                                    <div class="form-group">
                                        <label for="page_frendlyurl_en">Url</label> 
                                        <input type='text' name='page_friendlyurl_en' class='form-control'>
                                    </div>

                                    <div class="form-group">
                                        <label for="page_metatitle_en">Az oldal címe</label>   
                                        <input type='text' name='page_metatitle_en' class='form-control' value=""/>
                                    </div>

                                    <div class="form-group">
                                        <label for="page_metadescription_en">Az oldal leírása</label>  
                                        <input type='text' name='page_metadescription_en' class='form-control' value="">
                                    </div>

                                    <div class="form-group">
                                        <label for="page_metakeywords_en">Kulcsszavak</label>
                                        <input type='text' name='page_metakeywords_en' class='form-control' value="">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="page_body_en">Tartalom</label>
                                        <textarea type="text" name="page_body_en" class="form-control"></textarea>
                                    </div>

                                </div>
                            </div> <!-- TAB-CONTENT END-->

					    </div> <!-- END USER GROUPS PORTLET BODY-->
				</div> <!-- END USER GROUPS PORTLET-->
            </form>									
		</div> <!-- END COL-MD-12 -->
	</div> <!-- END ROW -->	
</div> <!-- END PAGE CONTENT-->