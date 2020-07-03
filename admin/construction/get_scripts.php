

    <?php if(allow_if_module_is_loaded('media')){//<!-- MEDIA -->?>
      <script src="modules/media/js/media<?php echo $min ?>.js?<?php echo $ver ?>"></script>

    <?php }
    elseif(allow_if_module_is_loaded('articles')){//<!-- ARTICLE -->?>
      <script src="modules/articles/js/articles<?php echo $min ?>.js?<?php echo $ver ?>"></script>

    <?php }
    elseif(allow_if_module_is_loaded('webcams')){//<!-- WEBCAM -->?>
      <script src="modules/webcams/js/webcams<?php echo $min ?>.js?<?php echo $ver ?>"></script>

    <?php }
    elseif(allow_if_module_is_loaded('dimensions')){//<!-- DIMENSIONS -->?>
      <script src="modules/dimensions/js/dimensions<?php echo $min ?>.js?<?php echo $ver ?>"></script>

    <?php }
    elseif(allow_if_module_is_loaded('languages')){//<!-- LANGUAGES -->?>
      <script src="modules/languages/js/languages<?php echo $min ?>.js?<?php echo $ver ?>"></script>

    <?php }
    elseif(allow_if_module_is_loaded('menu')){//<!-- MENU -->?>
      <script src="modules/menu/js/menu<?php echo $min ?>.js?<?php echo $ver ?>"></script>

    <?php }
    elseif(allow_if_module_is_loaded('video')){//<!-- VIDEO -->?>
      <script src="modules/video/js/video<?php echo $min ?>.js?<?php echo $ver ?>"></script>

    <?php }
    elseif(allow_if_module_is_loaded('users')){//<!-- USERS -->?>
      <script src="modules/users/js/users<?php echo $min ?>.js?<?php echo $ver ?>"></script>

    <?php }
    elseif(allow_if_module_is_loaded('user_groups')){//<!-- USER GROUPS -->?>
      <script src="modules/user_groups/js/user_groups<?php echo $min ?>.js?<?php echo $ver ?>"></script>

    <?php }
    elseif(isset($_GET["profile"])){//<!-- PROFILE -->?>
      <script src="system/profile/js/profile<?php echo $min ?>.js?<?php echo $ver ?>"></script>

    <?php }
    elseif(allow_if_module_is_loaded('site_setup')){// <!-- SITE SETUP -->?>
      <script src="modules/site_setup/js/site_setup<?php echo $min ?>.js?<?php echo $ver ?>"></script>

    <?php }
    elseif(allow_if_module_is_loaded('ads')){//<!-- ADS -->?>
      <script src="modules/ads/js/ads<?php echo $min ?>.js?<?php echo $ver ?>"></script>

    <?php }
    elseif(allow_if_module_is_loaded('evolve_social')){//<!-- SOCIAL -->?>
      <script src="modules/evolve_social/js/evolve_social<?php echo $min ?>.js?<?php echo $ver ?>"></script>
    <?php }?>


    <?php if(allow_if_module_is_loaded('sliders')){//<!-- SLIDERS -->?>
      <script src="modules/sliders/js/sliders<?php echo $min ?>.js?<?php echo $ver ?>"></script>
    <?php }?>

    <?php if(allow_if_module_is_loaded('testimonial')){//<!-- TESTIMONIALS -->?>
        <script src="modules/testimonials/js/testimonial<?php echo $min ?>.js?<?php echo $ver ?>"></script>
    <?php }?>

    <?php if(allow_if_module_is_loaded('estate')){//<!-- ESTATE -->?>
        <script src="modules/estate/js/estate<?php echo $min ?>.js?<?php echo $ver ?>"></script>
    <?php }?>

    <?php if(allow_if_module_is_loaded('shop')){//<!-- SHOP -->?>
        <script src="modules/shop/js/shop<?php echo $min ?>.js?<?php echo $ver ?>"></script>
    <?php }?>

    <?php if(allow_if_module_is_loaded('topten')){//<!-- TOP TEN -->?>
        <script src="modules/topten/js/topten<?php echo $min ?>.js?<?php echo $ver ?>"></script>
    <?php }?>
