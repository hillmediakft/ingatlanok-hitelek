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
				
				<?php if($insert_form == 1) { ?> 
				    <h4 class="column-title"><?php echo Lang::get('kapcsolat_email_cim'); ?></h4>
                        <div class="contacts-block">
                            <div class="contact-form">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <span class="contact-message"><?php echo Lang::get('kapcsolat_email_megjegyzes'); ?></span>
                                    </div>
                                </div>
                                <form action="<?php echo (LANG != 'hu') ? LANG . '/' : ''; ?>sendemail/init/mennyit_er_az_ingatlanom" method="POST" id="contact-form-kapcsolat">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text" name="name" class="name" placeholder="<?php echo Lang::get('kapcsolat_email_nev'); ?>" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="email" name="email" class="email" placeholder="Email" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="tel" name="phone" class="phone" placeholder="<?php echo Lang::get('kapcsolat_email_telefon'); ?>">
                                        </div>
                                    </div>
                                    <input type="text" name="mezes_bodon" id="mezes_bodon">
                                    <textarea name="message" class="message" placeholder="<?php echo Lang::get('kapcsolat_email_uzenet'); ?>" required></textarea>
                                    <button id="submit-button" class="send-btn"><?php echo Lang::get('kapcsolat_email_kuldes'); ?></button>
                                </form>
                            </div>
                        </div>
				<?php } ?>
            </div>
        </div>
    </div>
</div>