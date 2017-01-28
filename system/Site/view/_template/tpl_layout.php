<?php use System\Libs\Auth; ?>
<!DOCTYPE html>
<html lang="<?php echo LANG;?>">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title><?php echo $title;?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="description" content="<?php echo $description;?>" />
        <meta name="keywords" content="<?php echo $keywords; ?>" />
        <base href="<?php echo BASE_URL; ?>">
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <!-- <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" /> -->
        <!-- BOOTSTRAP CSS v3.3.5 -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo SITE_CSS; ?>bootstrap.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo SITE_ASSETS; ?>fonts/font-awesome-4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo SITE_ASSETS; ?>vendors/jquery-ui-1.11.4/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo SITE_ASSETS; ?>vendors/jcarousel/css/jquery.jcarousel.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo SITE_ASSETS; ?>vendors/toastr/toastr.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->url_helper->autoversion(SITE_CSS . 'main-red.css');?>" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->url_helper->autoversion(SITE_CSS . 'custom.css');?>" />
        <link rel="shortcut icon" href="<?php echo SITE_IMAGE; ?>favicon.ico" />
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
        <?php $this->get_css_link(); ?>
        <!-- END PAGE LEVEL PLUGIN STYLES -->

        <?php if (ENV == "production") { ?>
            <script>
    // Google analytics
            </script>			

        <?php } ?>  
    </head>
    <!-- END HEAD -->

    <body>
    <!--   	<div class="loader">
		<div class="loader_inner"></div>
	</div>  -->
            <?php include($this->path('tpl_head')); ?>
             <?php include($this->path('content')); ?>
             <?php include($this->path('tpl_foot')); ?>
       
        
        <script type="text/javascript" src="<?php echo SITE_JS; ?>jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo SITE_JS; ?>main.js"></script>
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
                 <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/toastr/toastr.min.js"></script>
                	
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <?php $this->get_js_link(); ?>
        <!-- END PAGE LEVEL SCRIPTS -->
    </body>
</html>