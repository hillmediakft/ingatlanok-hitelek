<?php use System\Libs\Language as Lang; ?>
<div id="content" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumbs">
                    <span class="clickable"><a href="<?php echo $this->request->get_uri('site_url');?>"><?php echo Lang::get('menu_home'); ?></a></span>
                    <span class="delimiter">/</span>
                    <span class="active-page"><?php echo Lang::get('menu_kapcsolat'); ?></span>
                </div>
            </div>
        </div>
    </div>
		<div class="container">
			<div class="row">
				<div class="col-sm-8 col-md-9">
					<div class="row">
						<div class="col-sm-12">
							<div class="empty-space"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="contacts-listing">
								<div class="row">
									<div class="col-md-3 col-sm-6">
										<div class="contact-item">
											<div class="icon">
												<i class="fa fa-map-marker"></i>
											</div>
											<div class="descr">
												<span><?php echo $settings['cim']; ?></span>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="contact-item">
											<div class="icon">
												<i class="fa fa-clock-o"></i>
											</div>
											<div class="descr">
												<span><?php echo Lang::get('kapcsolat_nyitva_tartas'); ?>:<br> 9:00 - 18:00</span>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="contact-item">
											<div class="icon">
												<i class="fa fa-phone"></i>
											</div>
											<div class="descr">
												<span><?php echo $settings['tel']; ?></span>
												<span><?php echo $settings['mobil']; ?></span>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="contact-item">
											<div class="icon">
												<i class="fa fa-envelope"></i>
											</div>
											<div class="descr">
												<a href="#"><?php echo $settings['email']; ?></a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="contacts-block unmarged">
								<div class="map-holder">
									<div class="map-canvas" id="contact-map"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="empty-space-25"></div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<h4 class="column-title"><?php echo Lang::get('kapcsolat_email_cim'); ?></h4>
							<div class="contacts-block">
								<div class="contact-form">
									<div class="row">
										<div class="col-sm-12">
											<span class="contact-message"><?php echo Lang::get('kapcsolat_email_megjegyzes'); ?></span>
										</div>
									</div>
									<form action="#">
										<div class="row">
											<div class="col-sm-6">
												<input type="text" class="name" placeholder="<?php echo Lang::get('kapcsolat_email_nev'); ?> *">
											</div>
											<div class="col-sm-6">
												<input type="email" class="email" placeholder="Email *">
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<input type="tel" class="phone" placeholder="<?php echo Lang::get('kapcsolat_email_telefon'); ?>">
											</div>
											<div class="col-sm-6">
												<input type="text" class="email" placeholder="<?php echo Lang::get('kapcsolat_email_targy'); ?>">
											</div>
										</div>
										<textarea name="text1" class="message" placeholder="<?php echo Lang::get('kapcsolat_email_uzenet'); ?> *"></textarea>
										<button class="send-btn"><?php echo Lang::get('kapcsolat_email_kuldes'); ?></button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
					<!-- SIDEBAR -->
					<div class="col-md-3 col-sm-4">
						<aside class="sidebar main-sidebar">
							<!-- REFERENSEK DOBOZ -->
                            <?php include($this->path('tpl_modul_referenscontact')); ?>
							<!-- KIEMELT INGATLANOK DOBOZ -->
							<?php include($this->path('tpl_modul_kiemeltingatlanok')); ?>
							<!-- KIEMELT INGATLANOK DOBOZ -->
							<?php include($this->path('tpl_modul_banner')); ?>
						</aside>        
					</div> <!-- SIDEBAR END -->
			</div>
		</div>
</div>