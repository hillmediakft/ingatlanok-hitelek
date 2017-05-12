<?php 
use System\Libs\Language as Lang; 
use System\Libs\Config as Config
?>
<div id="content" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumbs">
                    <span class="clickable"><a href="<?php echo $this->request->get_uri('site_url');?>"><?php echo Lang::get('menu_home'); ?></a></span>
                    <span class="delimiter">/</span>
                    <span class="active-page"><?php echo Lang::get('error_nem_talalhato_az_ingatlan'); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="empty-space"></div>
                <div class="error-container">
                    <div class="error-img">
                        <img src="<?php echo SITE_IMAGE;?>/404-ingatlan.jpg" alt="">
                    </div>
                    <span class="error-message"><span class="colored"><?php echo Lang::get('error_nem_talalhato_az_ingatlan_cim'); ?></span>
                    <span class="reason"><?php echo Lang::get('error_nem_talalhato_az_ingatlan_szoveg'); ?></span>
                    <a class="home-btn" href="<?php echo $this->request->get_uri('site_url') . Config::get('url.ingatlanok.index.' . LANG);?>"><?php echo Lang::get('error_tovabb_az_ingatlanokhoz'); ?></a>
                </div>
                <div class="empty-space"></div>
            </div>
        </div>
    </div>
</div>