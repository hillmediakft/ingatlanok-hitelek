<?php 
use System\Libs\Config;
use System\Libs\Language as Lang;
?>
<div style="margin-top: 0;" class="widget banner">
    <div class="banner-img">
        <img src="<?php echo SITE_IMAGE; ?>mennyit-er-az-ingatlanom-banner.jpg" alt="">
    </div>
    <div class="banner-entry">
        <span class="banner-title"><?php echo Lang::get('home_szolgaltatasok_1_cim'); ?></span>
        <span class="banner-sub"><?php echo Lang::get('home_szolgaltatasok_1_szoveg'); ?></span>
        <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.mennyit-er-az-ingatlanom.index.' . LANG); ?>" class="learn-more">Tovább</a>
    </div>
</div>