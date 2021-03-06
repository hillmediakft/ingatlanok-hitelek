<?php
use System\Libs\Auth;
?>
<!DOCTYPE html>
<html lang="<?php echo LANG; ?>">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title><?php echo $title; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="description" content="<?php echo $description; ?>" />
        <meta name="keywords" content="<?php echo $keywords; ?>" />
        
        <!-- facebook megosztashoz meta adatok -->
        <meta property="og:title" content="<?php echo $title; ?>" />
        <meta property="og:type" content="property" />
        <meta property="og:url" content="<?php echo $this->request->get_uri('current_url'); ?>" />
        <?php if (isset($share_image_path)) { ?>
        <meta property="og:image" content="<?php echo $share_image_path; ?>" />
        <?php } ?>


        <base href="<?php echo BASE_URL; ?>">
		
	        <?php if (ENV == "production") { ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TM4ZP');</script>
<!-- End Google Tag Manager -->

        <?php } ?> 	
		
		<?php if(LANG == 'hu') { ?>
		<script>var valasszon = '-- válasszon --';</script>
		<?php } ?>
				<?php if(LANG == 'en') { ?>
		<script>var valasszon = '-- choose --';</script>
		<?php } ?>
		
		
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
       <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700&amp;subset=latin-ext" rel="stylesheet">
        <!-- BOOTSTRAP CSS v3.3.5 -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo SITE_CSS; ?>bootstrap.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo SITE_ASSETS; ?>fonts/font-awesome-4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo SITE_ASSETS; ?>vendors/jquery-ui-1.11.4/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo SITE_ASSETS; ?>vendors/jcarousel/css/jquery.jcarousel.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo SITE_ASSETS; ?>vendors/toastr/toastr.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo SITE_ASSETS; ?>vendors/slicknav/dist/slicknav.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->url_helper->autoversion(SITE_CSS . 'main-red.css'); ?>" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->url_helper->autoversion(SITE_CSS . 'custom.css'); ?>" />
        <link rel="shortcut icon" href="<?php echo SITE_IMAGE; ?>favicon.ico" />
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
        <?php $this->get_css_link(); ?>
        <!-- END PAGE LEVEL PLUGIN STYLES -->

 
    </head>
    <!-- END HEAD -->

    <body>
	<?php if (ENV == "production") { ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TM4ZP"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
	<?php } ?>

        <div id="fb-root"></div>
        <script>(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>

        <?php include($this->path('tpl_head')); ?>
        <?php include($this->path('content')); ?>
        <?php include($this->path('tpl_foot')); ?>
        <?php include($this->path('tpl_pop_up')); ?>

        <!-- /. Footer Start ./-->    

        <script type="text/javascript" src="<?php echo SITE_JS; ?>jquery.min.js"></script>

        <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/languageswitcher/languageswitcher.js"></script>
        <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/jcarousel/js/jquery.jcarousel.min.js"></script>
        <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/equalheights/jquery.equalheights.min.js"></script>

        <!-- Minden oldalon szükséges elemek -->
        <!-- BOOTSTRAP JS v3.3.5 -->
        <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/bootstrap/js/bootstrap.min.js"></script>
        <!-- MODAL handler -->
        <script type="text/javascript" src="<?php echo SITE_JS; ?>pages/modal_handler.js"></script>
        <!-- Form validátor -->
        <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/jquery-validation/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/jquery-validation/additional-methods.min.js"></script>
        <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/jquery-validation/localization/messages_hu.js"></script>
        <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/jquery-validation/localization/methods_hu.js"></script>
        <!-- Block UI -->
        <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/jquery.blockui.min.js"></script>
        <!-- TOASTR -->
        <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/toastr/toastr.min.js"></script>
        <!-- STICKY -->
        <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/sticky/jquery.sticky.js"></script>
        <!-- MMenu -->
        <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/slicknav/dist/jquery.slicknav.js"></script>
        <!-- Cookie consent -->
        <script src="<?php echo SITE_JS; ?>cookie_consent.js"></script>
        <!-- Main.js -->        
        <script type="text/javascript" src="<?php echo $this->url_helper->autoversion(SITE_JS . 'main.js'); ?>"></script>
        <!-- COMMON (tostr init, kedvencek)-->
        <script type="text/javascript" src="<?php echo $this->url_helper->autoversion(SITE_JS . 'pages/common.js'); ?>"></script>

        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <?php $this->get_js_link(); ?>
        <!-- END PAGE LEVEL SCRIPTS -->
    </body>
</html>