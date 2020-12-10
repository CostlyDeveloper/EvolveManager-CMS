<?php
define("FRONTEND", true);
$portal_ID = '1';  // define portal
require_once("system/config.php");

ob_start();

?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title><?php lang('website_title') ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="<?php lang('site_description') ?>" />
    <meta name="author" content="<?php echo $data['company_name'] ?>" />
    <meta property="og:title" content="<?php lang('website_title') ?>" />
    <meta property="og:description" content="<?php lang('site_description') ?>" />
    <meta property="og:image" content="<?php echo FRONTEND_URL ?>/media/upload/site/<?php echo $data['og_img'] ?>" />
    <meta property="og:url" content="<?php echo getAddress() ?>" />
    <meta property="og:locale" content="hr_HR" />
    <!-- Favicon - ICONS -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo FRONTEND_URL; ?>assets/pages/img/favicon/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo FRONTEND_URL; ?>assets/pages/img/favicon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo FRONTEND_URL; ?>assets/pages/img/favicon/favicon-16x16.png" />
    <link rel="manifest" href="<?php echo FRONTEND_URL; ?>assets/pages/img/favicon/site.webmanifest" />
    <link rel="mask-icon" href="<?php echo FRONTEND_URL; ?>assets/pages/img/favicon/safari-pinned-tab.svg" color="#5bbad5" />
    <link rel="shortcut icon" href="<?php echo FRONTEND_URL; ?>assets/pages/img/favicon/favicon.ico" />
    <meta name="msapplication-TileColor" content="#da532c" />
    <meta name="msapplication-config" content="<?php echo FRONTEND_URL; ?>assets/pages/img/favicon/browserconfig.xml" />
    <meta name="theme-color" content="#ffffff" />
    <!-- / Favicon - ICONS  -->


    <!-- Fonts START -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|PT+Sans+Narrow|Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all" rel="stylesheet" type="text/css">
    <!-- Fonts END -->

    <!-- Global styles START -->
    <link href="<?php echo FRONTEND_URL; ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo FRONTEND_URL; ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Global styles END -->

    <!-- Page level plugin styles START -->
    <link href="<?php echo FRONTEND_URL; ?>assets/pages/css/animate.css" rel="stylesheet">
    <link href="<?php echo FRONTEND_URL; ?>assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet">
    <link href="<?php echo FRONTEND_URL; ?>assets/plugins/owl.carousel/assets/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo FRONTEND_URL; ?>assets/plugins/owl.carousel/assets/owl.theme.default.min.css" rel="stylesheet">
    <!-- swipebox-master -->
    <link href="<?php echo FRONTEND_URL; ?>assets/plugins/swipebox-master/src/css/swipebox.min.css" rel="stylesheet" type="text/css" />
    <!-- Page level plugin styles END -->

    <!-- Theme styles START -->
    <link href="<?php echo FRONTEND_URL; ?>assets/pages/css/components.css" rel="stylesheet">
    <link href="<?php echo FRONTEND_URL; ?>assets/pages/css/slider.css" rel="stylesheet">
    <link href="<?php echo FRONTEND_URL; ?>assets/corporate/css/style.css?<?php echo get_evolve_caching_suffix(); ?>" rel="stylesheet">
    <link href="<?php echo FRONTEND_URL; ?>assets/corporate/css/style-responsive.css?<?php echo get_evolve_caching_suffix(); ?>" rel="stylesheet">
    <link href="<?php echo FRONTEND_URL; ?>assets/corporate/css/themes/<?php echo $data['css'] ?>.css?<?php echo get_evolve_caching_suffix(); ?>" rel="stylesheet" id="style-color">
    <link href="<?php echo FRONTEND_URL; ?>assets/corporate/css/custom.css?<?php echo get_evolve_caching_suffix(); ?>" rel="stylesheet">
    <!-- Theme styles END -->


</head>
<!-- END HEAD -->

<!-- BODY -->
<body>
<?php include(FRONTEND_PATH . 'construction/after_body_opening.php');//Facebook script etc. ?>

<!--========== HEADER ==========-->
<?php include(FRONTEND_PATH . 'layout/top_bar.php');
include(FRONTEND_PATH . 'layout/top_navigation.php');

$buffer = ob_get_contents();
ob_end_clean();
if ($level_1_seo or $level_2_seo or $keyword_seo) {
    include(FRONTEND_PATH . 'construction/get.php');//PRETTY URL ENGINE
} else {
    //HOMEPAGE
    set_website_head('', '', '', '', '', '');
    include(FRONTEND_PATH . 'pages/home.php');
    // /HOMEPAGE
}

?>
<!-- Footer -->
<?php include(FRONTEND_PATH . 'layout/footer.php'); ?>

<!--[if lt IE 9]>
<script src="assets/plugins/respond.min.js"></script>
<![endif]-->
<script src="<?php echo FRONTEND_URL; ?>assets/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo FRONTEND_URL; ?>assets/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo FRONTEND_URL; ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo FRONTEND_URL; ?>assets/corporate/scripts/back-to-top.js?<?php echo time('timestamp'); ?>" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
<!-- swipebox-master -->
<script src="<?php echo FRONTEND_URL; ?>assets/plugins/swipebox-master/src/js/jquery.swipebox.min.js" type="text/javascript"></script>
<script src="<?php echo FRONTEND_URL; ?>assets/plugins/owl.carousel/owl.carousel.min.js" type="text/javascript"></script><!-- slider for products -->

<script src="<?php echo FRONTEND_URL; ?>assets/corporate/scripts/layout.js?<?php echo time('timestamp'); ?>" type="text/javascript"></script>
<script src="<?php echo FRONTEND_URL; ?>assets/pages/scripts/bs-carousel.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        Layout.init();
        Layout.initOWL();
        Layout.initSwipebox();
        //$(".temp_hidden").delay( 1500 ).fadeIn( 600 );

        //Layout.initTwitter();
        //Layout.initFixHeaderWithPreHeader(); /* Switch On Header Fixing (only if you have pre-header) */
        //Layout.initNavScrolling();

    });
</script>
<!-- END PAGE LEVEL JAVASCRIPTS -->


</body>
<!-- END BODY -->
</html>
