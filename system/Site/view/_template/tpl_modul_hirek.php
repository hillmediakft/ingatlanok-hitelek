<?php 
use System\Libs\Config;
use System\Libs\Language as Lang;
?>
<div class="widget popular-posts">
	<div class="heading">
		<span class="widget-title"><?php echo Lang::get('hirek_oldalsav_cim'); ?></span>
	</div>
	<div class="widget-entry">
		<div class="popular-posts-widget">
			
			<?php foreach ($blogs as $blog) { ?>
			<div class="single-widget-post">
				<div class="preview">
					<img style="height:55px;" alt="" src="<?php echo $this->url_helper->thumbPath(Config::get('blogphoto.upload_path') . $blog['picture']); ?>">
				</div>
				<div class="descr">
					<span class="title"><a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.hirek.index.' . LANG) . '/' . $this->str_helper->stringToSlug($blog['title_' . LANG]) . '/' . $blog['id']; ?>"><?php echo $blog['title_' . LANG]; ?></a></span>
					<div class="item-thumbnail">
						<div class="single-item date">
							<i class="fa fa-calendar"></i>
							<span class="value" href=""><?php echo $blog['add_date']; ?></span>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>

		</div>
		<nav class="rotate_btn">
			<a href="<?php echo $this->request->get_uri('site_url') . Config::get('url.hirek.index.' . LANG); ?>" class="all-posts-btn"><?php echo Lang::get('hirek_minden_hir_gomb'); ?></a>
		</nav>
	</div>
</div>