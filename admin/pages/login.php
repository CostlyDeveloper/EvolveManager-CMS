
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="cache-control" content="no-cache, must-revalidate, post-check=0, pre-check=0">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title><?php echo $data['title']; ?></title>


    <!-- Bootstrap -->
    <link href="<?php echo ADMIN_URL; ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo ADMIN_URL; ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo ADMIN_URL; ?>vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo ADMIN_URL; ?>vendors/animatecss/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo ADMIN_URL; ?>build/css/evolve.css" rel="stylesheet">
</head>

<body class="login">
<input type="hidden" name="page_title" value="<?php echo $data['title'] . ' - '. $lang['login_title']; ?>" />
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">

                <form id="login_form" method="POST">
                    <h1><?php echo $lang['login_title']?></h1>
                    <div id="message" class="col-md-12 col-sm-12 col-xs-16"></div>
                    <div class="clearfix"></div>
                    <div>
                        <input type="text" name="email" class="form-control" placeholder="email" required="" />
                    </div>
                    <div>
                        <input type="password" name="password" class="form-control" placeholder="Password" required="" />
                    </div>
                    <div>
                        <button type="submit" class="btn btn-default submit" ><?php echo $lang['button_log_in']; ?></button>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">

                        <br />

                        <div>
                            <h1><i class="fa fa-paper-plane"></i> <?php echo $lang['evolve_project']?></h1>
                            <p>©<?php echo date("Y").' '.$lang['evolve_copyright']?></p>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
<!-- jQuery -->
<script src="<?php echo ADMIN_URL; ?>vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo ADMIN_URL; ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- EVOLVE Scripts -->
<script src="<?php echo ADMIN_URL; ?>language/language.js?<?php echo time('timestamp'); ?>"></script>

<!-- Evolve Login -->
<script src="<?php echo ADMIN_URL; ?>system/login/js/login.js?<?php echo time('timestamp'); ?>"></script>
</body>
</html>
