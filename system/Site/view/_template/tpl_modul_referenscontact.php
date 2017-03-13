<?php
use System\Libs\Config;
use System\Libs\Language as Lang;
?>
<div class="widget agents">
    <div class="heading">
        <span class="widget-title"><?php echo Lang::get('menu_ertekesitoink'); ?></span>
        <div class="jcarousel-arrows">
            <a href="#" class="prev-slide"><i class="fa fa-angle-left"></i></a>
            <a href="#" class="next-slide"><i class="fa fa-angle-right"></i></a>
        </div>
    </div>
    <div class="widget-entry">
        <div class="wg-ag-carousel carousel">
            <ul>

                <?php foreach ($agents as $agent) { ?>
                    <li>
                        <div class="item">
                            <div class="item-heading">
                                <div class="preview" style="overflow: hidden;">
                                    <img src="<?php echo $this->getConfig('user.upload_path') . $agent['photo']; ?>" alt="">
                                    <div class="overlay">
                                        <a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.ingatlanok.ertekesito.' . LANG) . '/' . $this->str_helper->stringToSlug($agent['first_name']) . '-' . $this->str_helper->stringToSlug($agent['last_name']) . '/' . $agent['id']; ?>"><i class="fa fa-search-plus"></i></a>
                                    </div>
                                </div>
                                <div class="descr">
                                    <span class="name"><?php echo (LANG == 'hu') ? $agent['first_name'] . ' '. $agent['last_name'] : $agent['last_name'] . ' ' . $agent['first_name']; ?></span>
                                    <span class="properties"><?php echo $agent['property']; ?> ingatlan</span>
                                </div>
                            </div>
                            <ul class="contact-listing">
                                <li>
                                    <span class="icon"><i class="fa fa-phone"></i></span>
                                    <span class="phone"><?php echo $agent['phone']; ?></span>
                                </li>
                                <li>
                                    <span class="icon"><i class="fa fa-envelope"></i></span>
                                    <a href="mailto:<?php echo $agent['email']; ?>" class="mail"><?php echo $agent['email']; ?></a>
                                </li>
                                <!--
                                <li>
                                    <span class="icon"><i class="fa fa-globe"></i></span>
                                    <a href="#" class="site">infoexample.com</a>
                                </li>
                                -->
                            </ul>
                        </div>
                    </li>
                <?php } ?>

            </ul>
        </div>
    </div>
</div>


