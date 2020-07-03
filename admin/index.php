<?php
define("ADMIN", true);
require_once("../system/config.php");

if (evolveLogged()) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <link rel="manifest" href="images/site.webmanifest">
    <link rel="mask-icon" href="images/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <title><?php echo $data['title']; ?></title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet"/>
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet"/>
    <!-- Dropzone.js -->
    <link href="vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet"/>
    <!-- PNotify -->
    <link href="vendors/pnotify/dist/pnotify.css" rel="stylesheet"/>
    <!-- Switchery -->
    <link href="vendors/switchery/dist/switchery.min.css" rel="stylesheet"/>
    <!-- jquery-confirm -->
    <link href="vendors/jquery-confirm-master/dist/jquery-confirm.min.css" rel="stylesheet"/>

    <!-- Evolve Style -->
    <link href="build/css/evolve<?php echo $min ?>.css?<?php echo $ver ?>" rel="stylesheet"/>


    <?php include(ADMIN_PATH . '/construction/get_css.php'); //Get CSS
    ?>

</head>

<body>
<?php include(ADMIN_PATH . '/layout/loader.php'); ?>
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col left_menu hidden temp_hidden">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="<?php echo ADMIN_URL; ?>" class="site_title"><img src="images/70x70.png" width="50"/>
                        <span><?php echo $lang['evolve_project']; ?></span></a>
                </div>

                <div class="clearfix"></div>
                <?php include(ADMIN_PATH . '/layout/menu_profile_quick_info.php'); ?>
                <br/>
                <?php include(ADMIN_PATH . '/layout/sidebar_menu.php'); ?>
                <?php include(ADMIN_PATH . '/layout/menu_footer_buttons.php'); ?>
            </div>
        </div>
        <?php include(ADMIN_PATH . '/layout/top_navigation.php'); ?>
        <?php if ($developing) { ?>
            <div id="dev"></div>  <?php } ?>
        <?php //Get Variables for URI or load home page
        include(ADMIN_PATH . '/construction/get.php'); ?>
        <?php include(ADMIN_PATH . '/layout/footer_content.php'); ?>
        <form id="token_data">
            <input type="hidden" name="userID" value="<?php echo $data_user_id; ?>"/>
            <input type="hidden" name="token" value="<?php echo $cses_id; ?>"/>
            <input type="hidden" name="cpass" value="<?php echo $cpass; ?>"/>
            <input type="hidden" name="rdts" value="<?php echo $reg_date_ts; ?>"/>
        </form>
        <form>
            <?php $slugs_arr = languages();
            foreach ($slugs_arr as $slug) {
                ?>
                <input type="hidden" name="multilang_slugs_<?php echo $slug['slug']; ?>" class="multilang_slugs"
                       value="<?php echo $slug['slug']; ?>"/>
            <?php } ?>
        </form>
    </div>
</div>

<!-- jQuery -->
<script src="vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="vendors/nprogress/nprogress.js"></script>
<!-- iCheck -->
<script src="vendors/iCheck/icheck.min.js"></script>
<!-- moment -->
<script src="vendors/moment/min/moment.min.js"></script>
<!-- Dropzone.js -->
<script src="vendors/dropzone/dist/dropzone.js"></script>
<!-- jquery-confirm -->
<script src="vendors/jquery-confirm-master/dist/jquery-confirm.min.js"></script>
<!-- Lazyload -->
<script src="vendors/lazyload/lazyload.min.js"></script>
<!-- PNotify -->
<script src="vendors/pnotify/dist/pnotify.js"></script>
<!-- Switchery -->
<script src="vendors/switchery/dist/switchery.min.js"></script>
<!-- sortable -->
<script src="vendors/jquery-ui/jquery-ui.js"></script>

<?php include(ADMIN_PATH . '/construction/get_vendor_scripts.php'); //Get Variables scripts
?>

<!-- EVOLVE Scripts -->
<script src="language/language.js?<?php echo $ver ?>"></script>
<script src="build/js/evolve-general<?php echo $min ?>.js?<?php echo $ver ?>"></script>
<script src="modules/_commonScripts/js/common.js?<?php echo $ver ?>"></script>

<?php include(ADMIN_PATH . '/construction/get_scripts.php'); //Get Variables scripts
?>

</body>
    </html><?php

} else {
    include(ADMIN_PATH . '/pages/login.php');
}
?>
