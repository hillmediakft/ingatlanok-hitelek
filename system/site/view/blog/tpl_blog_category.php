<div class="center">
    <div class="container">
        <div class="row">
            <!-- BEGIN LISTING-->
            <div class="listing listing--properties-list">
                <header class="listing__header">
                    <h1 class="listing__title">Hírek</h1>
                    <h5 class="listing__headline"><em><?php echo $this->category_name; ?></em> - kategória</h5>
                </header>


                <div class="listing__main">
                    <div class="article article--details article--page">

                        <?php if (count($this->blog_list) > 0): ?> 
                            <?php foreach ($this->blog_list as $value) : ?>  

                                <article class="article__item">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <img src="<?php echo Config::get('blogphoto.upload_path') . $value['blog_picture']; ?>" class="img-responsive img-thumbnail" alt="<?php echo $value['blog_title']; ?>">
                                        </div>
                                        <div class="col-md-9">
                                            <a class="article__comment" href="<?php echo $this->registry->site_url . 'hirek/' . $value['blog_slug'] . '/' . $value['blog_id']; ?>"><i class="fa fa-calendar"></i><?php echo $value['blog_add_date']; ?></a>

                                            <h3 class="article__item-title"><a href="<?php echo $this->registry->site_url . 'hirek/' . $value['blog_slug'] . '/' . $value['blog_id']; ?>"><?php echo $value['blog_title']; ?></a></h3>
                                            <div class="article__tags">Kategória:<a href="<?php echo $this->registry->site_url . 'hirek/kategoria/' . $value['blog_category']; ?>"><?php echo $value['category_name']; ?></a>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="article__intro">
                                                <p><?php echo Util::sentence_trim($value['blog_body'], 3); ?><a href="<?php echo $this->registry->site_url . 'hirek/' . $value['blog_slug'] . '/' . $value['blog_id']; ?>"> [tovább...]</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </article> 
                                <hr>

                            <?php endforeach ?>
                        <?php endif ?>
                        <?php if (count($this->blog_list) == 0): ?>
                            <div class="alert alert-info"><p><i class="fa fa-exclamation-triangle"></i> Nincs bejegyzés a kategóriában!</p></div>
                        <?php endif ?>
                    </div>
                </div>                
                <?php echo $this->pagine_links; ?>

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