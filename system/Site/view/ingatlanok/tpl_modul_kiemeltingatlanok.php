<?php use System\Libs\Language as Lang; ?>
<div class="widget featured-properties">
	<div class="heading">
		<span class="widget-title"><?php echo Lang::get('home_kiemelt_ingatlanok'); ?></span>
	</div>
	<div class="widget-entry">
		<?php
			foreach ($kiemelt_ingatlanok as $ingatlan) {
				$photo_array = json_decode($ingatlan['kepek']);
			?>
				<div class="single-prop">
					<span style="position:absolute; padding: 1px 4px; top: 0px; background-color: #C44A35; color: #ffffff;"><?php echo($ingatlan['tipus'] == 1) ? Lang::get('kereso_elado') : Lang::get('kereso_kiado'); ?></span>
					<div class="preview">
						<div style="overflow: hidden; width:85px; height:85px;">
							<?php if ($ingatlan['kepek']) { ?>
							    <img style="height:85px; width:auto;" src="<?php echo $this->url_helper->thumbPath($this->getConfig('ingatlan_photo.upload_path') . $photo_array[0], null, 'small'); ?>" alt="<?php echo $ingatlan['ingatlan_nev_' . LANG]; ?>">
							<?php } else { ?>
							    <img style="height:85px; width:auto;" src="<?php echo Config::get('ingatlan_photo.upload_path') . 'placeholder.jpg'; ?>" alt="<?php echo $ingatlan['ingatlan_nev']; ?>">
							<?php } ?>
						</div>
					</div>
					<div class="descr">
						<span class="title"><a href="#"><?php echo $ingatlan['ingatlan_nev_' . LANG] ?></a></span>
						<span class="price"><span class="value"><?php echo ($ingatlan['tipus'] == 1) ? number_format($ingatlan['ar_elado'], 0, ',', '.') : number_format($ingatlan['ar_kiado'], 0, ',', '.') ?></span> Ft</span>
					</div>
				</div>
		<?php } ?>
	</div>
</div>