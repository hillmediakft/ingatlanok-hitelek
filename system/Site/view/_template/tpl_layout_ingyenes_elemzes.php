<!DOCTYPE html>
<html lang="<?php echo LANG; ?>">
<head>
        <meta charset="utf-8" />
        <title><?php echo $title; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="description" content="<?php echo $description; ?>" />
        <meta name="keywords" content="<?php echo $keywords; ?>" />
        <base href="<?php echo BASE_URL; ?>">

        <link rel="shortcut icon" href="<?php echo SITE_IMAGE; ?>favicon.ico" />

        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo SITE_CSS; ?>bootstrap.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->url_helper->autoversion(SITE_CSS . 'main-red.css'); ?>" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->url_helper->autoversion(SITE_CSS . 'custom.css'); ?>" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo SITE_ASSETS; ?>vendors/toastr/toastr.css">


        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
        <?php $this->get_css_link(); ?>
        <!-- END PAGE LEVEL PLUGIN STYLES -->

</head>
<body style="background-color: #000;">

	<!-- TARTALOM -->
	<?php include($this->path('content')); ?>


    <script type="text/javascript" src="<?php echo SITE_JS; ?>jquery.min.js"></script>

    <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/languageswitcher/languageswitcher.js"></script>

    <!-- BOOTSTRAP JS v3.3.5 -->
    <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/bootstrap/js/bootstrap.min.js"></script>

    <!-- Form validátor -->
    <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/jquery-validation/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/jquery-validation/additional-methods.min.js"></script>
    <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/jquery-validation/localization/messages_hu.js"></script>
    <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/jquery-validation/localization/methods_hu.js"></script>
    <script type="text/javascript" src="<?php echo SITE_ASSETS; ?>vendors/toastr/toastr.min.js"></script>


    <!-- <script src="<?php //echo SITE_JS; ?>cookie_consent.js"></script> -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <?php $this->get_js_link(); ?>
    <!-- END PAGE LEVEL SCRIPTS -->
</body>
</html>