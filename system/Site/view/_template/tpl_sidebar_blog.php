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
                    <li class="category-item"><a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.hirek.kategoria.' . LANG) . '/' . $value['id']; ?>"><?php echo $value['category_name_' . LANG]; ?></a></li>
                     <?php } ?>
                </ul>
            </div>
        </div>

        <!-- BANNER -->
        <?php include($this->path('tpl_modul_banner_befektetoknek')); ?>
        <?php include($this->path('tpl_modul_banner_mennyiterazingatlanom')); ?>

    </aside>
</div>