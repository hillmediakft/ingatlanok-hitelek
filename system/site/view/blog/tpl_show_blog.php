<div class="center">
    <div class="container">
        <div class="row">
            <!-- BEGIN LISTING-->
            <div class="listing listing--properties-list">
                <header class="listing__header">
                    <h1 class="listing__title">Hírek</h1>
                    <h5 class="listing__headline">Friss hírek, információk</h5>
                </header>

                <div class="listing__main">
                    <div class="article article--details article--page">
                        <article class="article__item">

                            <div class="row">
                                <div class="col-md-3">
                                    <img src="<?php echo Config::get('blogphoto.upload_path') . $this->blog['blog_picture']; ?>" class="img-responsive img-thumbnail" alt="<?php echo $this->blog['blog_title']; ?>">
                                </div>
                                <div class="col-md-9">
                                    <h3 class="article__item-title"><a href="blog_details.html"><?php echo $this->blog['blog_title']; ?></a></h3>
                                    <div class="article__tags"><i class="fa fa-folder-open-o"></i> Kategória:<a href="<?php echo $this->registry->site_url . 'hirek/kategoria/' . $this->blog['blog_category']; ?>"><?php echo $this->blog['category_name']; ?></a> | <i class="fa fa-calendar"></i> <?php echo $this->blog['blog_add_date']; ?>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="article__intro">
                                        <p><?php echo $this->blog['blog_body']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </article> 
                        <hr>


                    </div>
                </div>                

            </div>
            <!-- END LISTING-->
            <!-- SIDEBAR -->
            <?php include SITE . '/view/_template/tpl_sidebar.php'; ?>
            <!-- END SIDEBAR-->
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- END CENTER SECTION-->

