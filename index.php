<?php
define("FRONTEND", true);
$portal_ID = '1';  // define portal
require_once("system/config.php");
ob_start();

?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php lang('website_title')?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php lang('site_description')?>"/>
    <!--TODO keywords-->
    <meta name="keywords" content=""/>
    <meta name="author" content="<?php echo $data['company_name']?>"/>


    <!-- Facebook and Twitter integration -->

    <meta property="og:title" content="<?php lang('website_title') ?>"/>
    <meta property="og:description" content="<?php lang('site_description') ?>"/>
    <meta property="og:image" content="<?php echo FRONTEND_URL ?>/media/upload/site/<?php echo $data['og_img'] ?>"/>
    <meta property="og:url" content="<?php echo getAddress() ?>"/>
    <meta property="og:locale" content="hr_HR"/>
    <meta property="og:site_name" content="<?php lang('website_title') ?>"/>
    <meta name="twitter:title" content="<?php lang('website_title') ?>"/>
    <meta name="twitter:image" content="<?php echo FRONTEND_URL ?>/media/upload/site/<?php echo $data['og_img'] ?>"/>
    <meta name="twitter:url" content="<?php echo getAddress() ?>"/>
    <meta name="twitter:card" content=""/>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--TODO icon-->
    <link rel="shortcut icon" href="favicon.ico">

    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600,400italic,700' rel='stylesheet'
          type='text/css'>

    <!-- Animate.css -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- Icomoon Icon Fonts-->
    <link rel="stylesheet" href="css/icomoon.css">
    <!-- Simple Line Icons -->
    <link rel="stylesheet" href="css/simple-line-icons.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="css/magnific-popup.css">
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- ion.rangeSlider -->
    <link rel="stylesheet" href="vendors/ion.rangeSlider/css/ion.rangeSlider.css">
    <!-- jquery-confirm -->
    <link rel="stylesheet" href="vendors/jquery-confirm/jquery-confirm.min.css">

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/style4.css">


    <!-- Modernizr JS -->
    <script src="js/modernizr-2.6.2.min.js"></script>
    <!-- FOR IE9 below -->
    <!--[if lt IE 9]>
    <script src="js/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<?php include(FRONTEND_PATH.'construction/after_body_opening.php');//Facebook script etc. ?>
<!--========== HEADER ==========-->
<?php include(FRONTEND_PATH.'layout/top_bar.php');

$buffer = ob_get_contents();
ob_end_clean();
if ($level_1_seo OR $level_2_seo OR $keyword_seo){
    include(FRONTEND_PATH.'construction/get.php');//PRETTY URL ENGINE
}else{
    //HOMEPAGE
    set_website_head('','','','','','');
    include(FRONTEND_PATH.'pages/home.php');
    // /HOMEPAGE
}

?>
<!-- Footer -->
<?php include(FRONTEND_PATH.'layout/footer.php'); ?>


<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<!-- jQuery Easing -->
<script src="js/jquery.easing.1.3.js"></script>
<!-- Bootstrap -->
<script src="js/bootstrap.min.js"></script>
<!-- Waypoints -->
<script src="js/jquery.waypoints.min.js"></script>
<!-- Stellar Parallax -->
<script src="js/jquery.stellar.min.js"></script>
<!-- Counter -->
<script src="js/jquery.countTo.js"></script>
<!-- Magnific Popup -->
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/magnific-popup-options.js"></script>
<!-- Google Map -->
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCefOgb1ZWqYtj7raVSmN4PL2WkTrc-KyA&sensor=false"></script>
<script src="js/google_map.js"></script>-->
<!-- ion.rangeSlider -->
<script src="vendors/ion.rangeSlider/js/ion.rangeSlider.min.js"></script>
<!-- jquery-confirm -->
<script src="vendors/jquery-confirm/jquery-confirm.min.js"></script>

<!-- Main JS (Do not remove) -->
<script src="js/main.js"></script>

<script type="text/javascript">

</script>

</body>
</html>

