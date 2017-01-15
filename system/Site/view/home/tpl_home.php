<?php

use System\Libs\Config;
use System\Libs\Language as Lang;
?>
<div class="home-banner style-2">
    <div class="container">
        <div class="banner-content">
            <div class="banner-message">
                <div class="banner-entry">
                    <span class="entry-title">Lorem ipsum</span>
                    <span class="entry-message">Dolem dolores ipsum</span>
                </div>
            </div>
            <div class="main-filter hidden-xs">
                <form class="filter-form" action="ingatlanok">
                    <div class="row">
                        <div class="filter-column-3">
                            <span class="item-label"><?php echo Lang::get('kereso_elado'); ?>/<?php echo Lang::get('kereso_kiado'); ?></span>
                            <div class="form-group">
                                <select name="tipus" class="form-control">
                                    <option selected="selected" value="1"><?php echo Lang::get('kereso_elado'); ?></option>
                                    <option value="2"><?php echo Lang::get('kereso_kiado'); ?></option>
                                </select>
                            </div>	
                        </div>
                        <div class="filter-column-3">
                            <span class="item-label"><?php echo Lang::get('kereso_varos'); ?></span>
                            <div class="form-group">
                                <select name="varos" id="varos" class="form-control" >
                                    <option value="">-- <?php echo Lang::get('kereso_mindegy'); ?> --</option>;
<?php echo $city_list; ?>
                                </select>
                            </div>
                        </div>
                        <div class="filter-column-3">
                            <span class="item-label"><?php echo Lang::get('kereso_kerulet'); ?></span>
                            <div class="form-group">
                                <select disabled="disabled" id="district" name="kerulet" class="form-control" >
                                    <option value="">-- <?php echo Lang::get('kereso_mindegy'); ?> --</option>
<?php echo $district_list; ?>
                                </select>
                            </div>
                        </div>                    
                        <div class="filter-column-3">
                            <span class="item-label"><?php echo Lang::get('kereso_kategoria'); ?></span>
                            <div class="form-group">
                                <select name="kategoria" class="form-control">
                                    <option value="">-- <?php echo Lang::get('kereso_mindegy'); ?> --</option>
                                    <?php foreach ($category_list as $value) : ?>
                                        <option value="<?php echo $value['kat_id']; ?>"><?php echo $value['kat_nev_' . LANG]; ?></option>
<?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="filter-column-3">
                            <span class="item-label"><?php echo Lang::get('kereso_min_ar'); ?></span>
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="min_ar" type="text" class="form-control">
                                    <div class="input-group-addon">Ft</div>
                                </div>
                            </div>
                        </div> 
                        <div class="filter-column-3">
                            <span class="item-label"><?php echo Lang::get('kereso_max_ar'); ?></span>
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="max_ar" type="text" class="form-control">
                                    <div class="input-group-addon">Ft</div>
                                </div>
                            </div>
                        </div>


                        <div class="filter-column-3">
                            <span class="item-label"><?php echo Lang::get('kereso_alapterulet'); ?></span>
                            <div class="form-group">
                                <input name="min_terulet" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="filter-column-3">
                            <button class="find-now-btn"><?php echo Lang::get('kereso_kereses'); ?></button>
                        </div>


                    </div>
                </form>
            </div>
            <a href="#" class="visible-xs find-now-btn"><?php echo Lang::get('kereso_kereses'); ?></a>
        </div>
    </div>
</div>




<div id="content" class="container-fluid">
    
	
<div class="row">
			<div class="our-features-banner gray-bg light">
				<div class="container">
					<h2 class="block-title"><?php echo Lang::get('home_szolgaltatasok_cim'); ?></h2>
					<span class="sub-title"><?php echo Lang::get('home_szolgaltatasok_szoveg'); ?></span>
					<div class="row">
						<div class="col-sm-3">
							<div class="single-feature">
								<div class="icon-container">
									<div class="icon-border">
									<a href="#">
										<img src="<?php echo SITE_IMAGE;?>mennyit-er-az-ingatlanom.png">
									</a>	
									</div>
								</div>
								<span class="main-title"><?php echo Lang::get('home_szolgaltatasok_1_cim'); ?></span>
								<span class="featured-sub-title colored"><?php echo Lang::get('home_szolgaltatasok_1_szoveg'); ?></span>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="single-feature">
								<div class="icon-container">
									<div class="icon-border">
									<a href="#">
										<img src="<?php echo SITE_IMAGE;?>befektetoknek.png">
									</a>	
									</div>
								</div>
								<span class="main-title"><?php echo Lang::get('home_szolgaltatasok_2_cim'); ?></span>
								<span class="featured-sub-title colored"><?php echo Lang::get('home_szolgaltatasok_2_szoveg'); ?></span>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="single-feature">
								<div class="icon-container">
									<div class="icon-border">
									<a href="#">
										<img src="<?php echo SITE_IMAGE;?>berbeadoknak.png">
									</a>	
									</div>
								</div>
								<span class="main-title"><?php echo Lang::get('home_szolgaltatasok_3_cim'); ?></span>
								<span class="featured-sub-title colored"><?php echo Lang::get('home_szolgaltatasok_3_szoveg'); ?></span>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="single-feature">
								<div class="icon-container">
									<div class="icon-border">
									<a href="#">
										<img src="<?php echo SITE_IMAGE;?>mennyit-er-az-ingatlanom.png">
									</a>
									</div>
								</div>
								<span class="main-title"><?php echo Lang::get('home_szolgaltatasok_4_cim'); ?></span>
								<span class="featured-sub-title colored"><?php echo Lang::get('home_szolgaltatasok_4_szoveg'); ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
	
	
	
	<div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="block-title"><?php echo Lang::get('home_kiemelt_ingatlanok'); ?></h2>
                <div class="object-slider latest-properties">
                    <div class="jcarousel-arrows">
                        <a href="#" class="prev-slide"><i class="fa fa-angle-left"></i></a>
                        <span class="text"><?php echo Lang::get('home_osszes_ingatlan'); ?></span>
                        <a href="#" class="next-slide"><i class="fa fa-angle-right"></i></a>
                    </div>
                    <div class="obj-carousel carousel">
                        <ul>
                            <?php foreach ($all_properties as $value) { ?>
    <?php $photo_array = json_decode($value['kepek']); ?>
                                <li>
                                    <div class="item">
                                        <div class="preview">
                                            <?php if ($value['kepek']) { ?>
                                                <img src="<?php echo $this->url_helper->thumbPath(Config::get('ingatlan_photo.upload_path') . $photo_array[0], false, 'small'); ?>" alt="<?php echo $value['ingatlan_nev_' . LANG]; ?>">
                                            <?php } ?>
                                            <?php if ($value['kepek'] == null) { ?>
                                                <img src="<?php echo Config::get('ingatlan_photo.upload_path') . 'placeholder.jpg'; ?>" alt="<?php echo $value['ingatlan_nev_' . LANG]; ?>">
    <?php } ?>
                                            <span class="like">
                                                <i class="fa fa-heart"></i>
                                            </span>
                                            <span class="price-box">
    <?php echo ($value['tipus'] == 1) ? number_format($value['ar_elado'], 0, ',', '.') : number_format($value['ar_kiado'], 0, ',', '.') ?> Ft
                                            </span>
                                        </div>
                                        <div class="item-thumbnail">
                                            <div class="single-thumbnail">
                                                <span class="value"><?php echo $value['kat_nev_' . LANG]; ?></span>
                                            </div>
                                            <div class="single-thumbnail">

                                                <span class="value"><?php echo $value['szobaszam']; ?> szoba</span>
                                            </div>
                                            <div class="single-thumbnail">
                                                <span class="value"><?php echo $value['alapterulet']; ?> m<sup>2</sup></span>
                                            </div>
                                        </div>
                                        <div class="item-entry">
                                            <span class="item-title"><a href="ingatlanok/adatlap/<?php echo $value['id'] . '/' . $this->str_helper->stringToSlug($value['ingatlan_nev_' . LANG]); ?>"><?php echo $value['ingatlan_nev_' . LANG]; ?></a></span>
                                            <p><?php
                                                echo $value['city_name'];
                                                echo (isset($value['kerulet'])) ? ', ' . $value['kerulet'] . ' kerület' : '';
                                                ?></p>

                                            <div class="item-info">
                                            </div>
                                        </div>
                                    </div>
                                </li>
<?php } ?>

                        </ul>
                    </div>
                    <p class="jcarousel-pagination"></p>
                </div>
            </div>
        </div>
    </div>





    <div class="row">
        <div class="our-agents gray-bg">
            <div class="container">
                <h2 class="block-title"><?php echo Lang::get('home_referensek'); ?></h2>
                <div class="best-agents">
                    <div class="jcarousel-arrows">
                        <a href="#" class="prev-slide"><i class="fa fa-angle-left"></i></a>

                        <a href="#" class="next-slide"><i class="fa fa-angle-right"></i></a>
                    </div>
                    <div class="ag-carousel carousel">
                        <ul>
						<?php foreach($agents as $value) : ?>
                            <li>
                                <div class="item">
                                    <div class="preview">
                                        <img src="<?php echo Config::get('user.upload_path') . $value['photo'];?>" alt="<?php echo $value['last_name'] . $value['first_name'];?>">
                                        <div class="overlay">
                                            <a href="agent-single_agent.html"><i class="fa fa-search-plus"></i></a>
                                        </div>
                                    </div>
                                    <span class="name"><?php echo $value['first_name'] . ' ' . $value['last_name'];?></span>
                                    <span class="properties"><a href="#" class="simple-btn sm-button outlined red"><?php echo $value['property'];?> ingatlan</a></span>
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
                            </li>
							<?php endforeach;?>

                           
                            
                           
                        </ul>
                    </div>
                    <p class="jcarousel-pagination"></p>
                </div>
            </div>
        </div>
    </div>

				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<div class="subscribe-banner">
								<div class="banner-text-block">
									<span class="banner-title inversed">Call to action cím</span>
									<p class="banner-text">Call to action szöveg .Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse quis iaculis mi...</p>
								</div>
								<div class="subscribe-block">
									<a href="#" class="subscribe-btn">Tovább</a>
								</div>
							</div>
						</div>
					</div>
				</div>


</div>