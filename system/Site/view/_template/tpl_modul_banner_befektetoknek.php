<?php 
use System\Libs\Config;
use System\Libs\Language as Lang;
?>
<div class="widget banner">
    <div class="banner-img">
        <img src="<?php echo SITE_IMAGE; ?>befektetoknek_banner.jpg" alt="">
    </div>
    <div class="banner-entry">
        <span class="banner-title"><?php echo Lang::get('home_szolgaltatasok_2_cim'); ?></span>
        <span class="banner-sub"><?php echo Lang::get('home_szolgaltatasok_2_szoveg'); ?></span>
        <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.befektetoknek.index.' . LANG); ?>" class="learn-more"><?php echo Lang::get('altalanos_gomb'); ?></a>
    </div>
</div>