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
				<a href="admin/blog">Blogok kezelése</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li><span>Blogbejegyzés módosítása</span></li>
		</ul>
	</div>
	<!-- END PAGE TITLE & BREADCRUMB-->
	<!-- END PAGE HEADER-->

	<div class="margin-bottom-20"></div>

	<!-- BEGIN PAGE CONTENT-->
	<div class="row">
		<div class="col-md-12">

			<!-- echo out the system feedback (error and success messages) -->
			<?php $this->renderFeedbackMessages(); ?>			

			<form action="" method="POST" id="update_blog_form" enctype="multipart/form-data">	
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet">

                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-film"></i> 
                            Blog bejegyzés módosítása
                        </div>
                        <div class="actions">
                            <button class="btn green btn-sm" type="submit" name="submit_update_blog"><i class="fa fa-check"></i> Mentés</button>
                            <a class="btn default btn-sm" href="admin/blog"><i class="fa fa-close"></i> Mégsem</a>
                        </div>
                    </div>

					<div class="portlet-body">

						<div class="row">	
							<div class="col-md-12">						
							
								<!-- bootstrap file upload -->
								<div class="form-group">
									<label class="control-label">Kép</label>
									<div class="fileupload fileupload-new" data-provides="fileupload">
										<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php echo $this->getConfig('blogphoto.upload_path') . $blog['picture'];?>" alt=""/></div>
										<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
										<div>
											<span class="btn default btn-file"><span class="fileupload-new">Kiválasztás</span><span class="fileupload-exists">Módosít</span><input id="uploadprofile" class="img" type="file" name="upload_blog_picture"></span>
											<a href="#" class="btn btn-warning fileupload-exists" data-dismiss="fileupload">Töröl</a>
										</div>
									</div>
								</div>
								<!-- bootstrap file upload END -->
																	
								<div class="clearfix"></div>

								<div class="note note-info">
									Kattintson a kiválasztás gombra! Ha másik képet szeretne kiválasztani, kattintson a módosít gombra! Ha mégsem kívánja a kiválasztott képet feltölteni, kattintson a töröl gombra!
								</div>

<div class="margin-bottom-40"></div>

								<div class="form-group">
									<label for="blog_category">Kategória</label>
									<select name="blog_category" class="form-control input-xlarge">
										<option value="0">Válasszon kategóriát</option>
									<?php foreach($category_list as $category) { ?>
										<option value="<?php echo $category['id']?>" <?php echo ($blog['category_name_hu'] == $category['category_name_hu']) ? "selected" : "";?>><?php echo $category['category_name_hu']?></option>
									<?php } ?>
									</select>
								</div>

<div class="margin-bottom-40"></div>


								<div class="portlet">
								    <!--<div class="portlet-title"></div>-->
								    <div class="portlet-body">

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
													<label for="blog_title_hu" class="control-label">Cím</label>
													<input type="text" name="blog_title_hu" id="blog_title_hu" value="<?php echo $blog['title_hu'];?>" class="form-control input-xlarge" />
												</div>
												<div class="form-group">
													<label for="blog_body_hu" class="control-label">Szöveg</label>
													<textarea name="blog_body_hu" id="blog_body_hu" class="form-control input-xlarge"><?php echo $blog['body_hu'];?></textarea>
												</div>
								            </div>
								            <div class="tab-pane fade" id="tab_1_2">
												<div class="form-group">
													<label for="blog_title_en" class="control-label">Cím</label>
													<input type="text" name="blog_title_en" id="blog_title_en" value="<?php echo $blog['title_en'];?>" class="form-control input-xlarge" />
												</div>
												<div class="form-group">
													<label for="blog_body_en" class="control-label">Szöveg</label>
													<textarea name="blog_body_en" id="blog_body_en" class="form-control input-xlarge"><?php echo $blog['body_en'];?></textarea>
												</div>
								            </div>
								        </div>

								    </div>
								</div>










								

								<!-- régi kép elérési útja-->
                            	<input type="hidden" name="old_img" id="old_img" value="<?php echo $blog['picture']; ?>">
							</div>
							
						</div>	

					</div> <!-- END USER GROUPS PORTLET BODY-->
				</div> <!-- END USER GROUPS PORTLET-->

			</form>

		</div> <!-- END COL-MD-12 -->
	</div> <!-- END ROW -->	
</div> <!-- END PAGE CONTENT-->