<?php use System\Libs\Language as Lang; ?>
<div id="content" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumbs">
                    <span class="clickable"><a href="<?php echo $this->request->get_uri('site_url');?>"><?php echo Lang::get('menu_home'); ?></a></span>
                    <span class="delimiter">/</span>
                    <span class="active-page"><?php echo $page_title; ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                        
                <div class="row">
                    <div class="col-sm-12">
                        <div class="empty-space-30"></div>
                    </div>
                </div>

                <?php echo $body; ?>
            </div>
        </div>
    </div>
</div>