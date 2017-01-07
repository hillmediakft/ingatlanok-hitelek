<?php
use System\Libs\Language as Lang;
use System\Libs\Config;
?>
<div class="col-sm-12 col-md-3">
    <aside class="sidebar main-sidebar">
        <div class="widget categories">
            <div class="heading">
                <span class="widget-title"><?php echo Lang::get('hirek_kategoriak'); ?></span>
            </div>
            <div class="widget-entry">
                <ul class="categories-listing">
                     <?php foreach ($blog_categories as $value) { ?>
                    <li class="category-item"><a href="<?php echo $this->request->get_uri('site_url') . 'blog/kategoria/' . $value['id']; ?>"><?php echo $value['category_name_' . LANG]; ?></a></li>
                     <?php } ?>
                </ul>
            </div>
        </div>
        <div class="widget popular-posts">
            <div class="heading">
                <span class="widget-title"><?php echo Lang::get('hirek_ingatlanok'); ?></span>
            </div>
            <div class="widget-entry">
                <div class="popular-posts-widget">
                    <div class="single-widget-post">
                        <div class="preview">
                            <img alt="#" src="<?php echo SITE_IMAGE;?>latest-blog-posts/4.1.jpg">
                        </div>
                        <div class="descr">
                            <span class="title"><a href="#">Etiam Pharetraluct felis sed rhoncus</a></span>
                            <div class="item-thumbnail">
                                <div class="single-item date">
                                    <i class="fa fa-calendar"></i>
                                    <a class="value" href="">12 Oct, 06:45</a>
                                </div>
                                <div class="single-item comment">
                                    <i class="fa fa-comments"></i>
                                    <a class="value" href="#">13</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="single-widget-post">
                        <div class="preview">
                            <img alt="#" src="<?php echo SITE_IMAGE;?>latest-blog-posts/4.2.jpg">
                        </div>
                        <div class="descr">
                            <span class="title"><a href="#">Etiam Pharetraluct felis sed rhoncus</a></span>
                            <div class="item-thumbnail">
                                <div class="single-item date">
                                    <i class="fa fa-calendar"></i>
                                    <a class="value" href="">12 Oct, 06:45</a>
                                </div>
                                <div class="single-item comment">
                                    <i class="fa fa-comments"></i>
                                    <a class="value" href="#">13</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="single-widget-post">
                        <div class="preview">
                            <img alt="#" src="<?php echo SITE_IMAGE;?>latest-blog-posts/4.3.jpg">
                        </div>
                        <div class="descr">
                            <span class="title"><a href="#">Etiam Pharetraluct felis sed rhoncus</a></span>
                            <div class="item-thumbnail">
                                <div class="single-item date">
                                    <i class="fa fa-calendar"></i>
                                    <a class="value" href="">12 Oct, 06:45</a>
                                </div>
                                <div class="single-item comment">
                                    <i class="fa fa-comments"></i>
                                    <a class="value" href="#">13</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <nav class="rotate_btn">
                    <a href="#" class="all-posts-btn">All Posts</a>
                </nav>
            </div>
        </div>


    </aside>
</div>