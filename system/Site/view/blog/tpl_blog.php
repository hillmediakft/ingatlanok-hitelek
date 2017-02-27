<?php
use System\Libs\Language as Lang;
use System\Libs\Config;
?>

<div id="content" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumbs">
                    <span class="clickable"><a href="<?php echo $this->request->get_uri('site_url'); ?>"><?php echo Lang::get('menu_home'); ?></a></span>
                    <span class="delimiter">/</span>
                    <span class="active-page"><?php echo Lang::get('menu_hirek'); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <div class="blog-content column-2">
                    <div class="row">
                        <div id="equalheight">
                            <?php foreach ($blog_list as $value) { ?>
                                <div class="col-sm-6">
                                    <div class="single-blog-item">
                                        <div class="preview">
                                            <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.hirek.index.' . LANG) . '/' . $this->str_helper->stringToSlug($value['title_' . LANG]) . '/' . $value['id']; ?>" class="link">
                                                <img alt="<?php echo $value['title_' . LANG]; ?>" src="<?php echo Config::get('blogphoto.upload_path') . $value['picture']; ?>" data-original="<?php echo Config::get('blogphoto.upload_path') . $value['picture']; ?>">
                                            </a>
                                        </div>
                                        <div class="descr">
                                            <div class="item-thumbnail">
                                                <div class="single-item date">
                                                    <i class="fa fa-calendar"></i>
                                                    <?php echo date('Y-m-d', strtotime($value['add_date'])); ?>
                                                </div>
                                                <div class="single-item views">
                                                    <i class="fa fa-archive"></i>
                                                    <?php echo Lang::get('hirek_kategoria'); ?>: <a class="value" href="<?php echo $this->request->get_uri('site_url') . Config::get('url.hirek.kategoria.' . LANG) . '/' . $value['category_id']; ?>"><?php echo $value['category_name_' . LANG]; ?></a>
                                                </div>
                                            </div>
                                            <span class="title"><a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.hirek.index.' . LANG) . '/' . $this->str_helper->stringToSlug($value['title_' . LANG]) . '/' . $value['id']; ?>"><?php echo $value['title_' . LANG]; ?></a></span>
                                            <p>
                                                <?php echo $this->str_helper->sentenceTrim($value['body_' . LANG], 3); ?> <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.hirek.index.' . LANG) . '/' . $this->str_helper->stringToSlug($value['title_' . LANG]) . '/' . $value['id']; ?>"> 
                                                    [...] 
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="objects-pagination">                           
                            <?php echo $pagine_links; ?>
                        </div>
                    </div>
                </div>                 

            </div>

            <?php
                //require('system/site/view/_template/tpl_sidebar_blog.php');
                require($this->path('tpl_sidebar_blog'));
            ?>   

        </div>
    </div>
</div>