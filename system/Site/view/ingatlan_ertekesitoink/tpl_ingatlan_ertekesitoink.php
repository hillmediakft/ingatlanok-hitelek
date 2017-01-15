<?php
use System\Libs\Config;
use System\Libs\Language as Lang;
?>
<div id="content" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumbs">
                    <span class="clickable"><a href="<?php echo $this->request->get_uri('site_url');?>"><?php echo Lang::get('menu_home'); ?></a></span>
                    <span class="delimiter">/</span>
                    <span class="active-page"><?php echo Lang::get('menu_ertekesitoink'); ?></span>
                </div>
            </div>
        </div>
    </div>
			<div class="agency-container with-sidebar column-4">
				<div class="row">
					<div class="col-sm-12 col-md-9">
					<?php foreach($agents as $value) : ?>
						<div class="col-md-4 col-sm-12">
							<div class="agent-item">
								<div class="preview">
									<div class="overlay-holder">
										<img src="<?php echo Config::get('user.upload_path') . $value['photo'];?>" alt="<?php echo $value['last_name'] . $value['first_name'];?>" alt="">
										<div class="overlay">
											<a href="agent-single_agent.html" class="incr">
												<i class="fa fa-link"></i>
											</a>
										</div>
									</div>
								</div>
								<span class="name"><?php echo $value['first_name'] . ' ' . $value['last_name'];?></span>
								 <span class="properties"><a href="#" class="simple-btn sm-button outlined red"><?php echo $value['property'];?>  ingatlan</a></span>

								<ul class="contact-listing">
									<li>
										<span class="icon"><i class="fa fa-phone"></i></span>
										<span class="phone"><?php echo $value['phone'];?></span>
									</li>
									<li>
										<span class="icon"><i class="fa fa-envelope"></i></span>
										<a href="#" class="mail"><?php echo $value['email'];?></a>
									</li>
								</ul>
							</div>
						</div>
						<?php endforeach;?>
					</div>
					<!-- SIDEBAR -->
					<div class="col-md-3 col-sm-4">
						<aside class="sidebar main-sidebar">
							<!-- KIEMELT INGATLANOK DOBOZ -->
							<?php include($this->path('tpl_modul_kiemeltingatlanok')); ?>
							<!-- KIEMELT INGATLANOK DOBOZ -->
							<?php include($this->path('tpl_modul_banner')); ?>
						</aside>        
					</div> <!-- SIDEBAR END -->
				</div>
			</div>
		</div>