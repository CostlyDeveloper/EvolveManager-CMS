<?php
$get_article_rubrics = $mysqli->query("
      SELECT evolve_article_rubrics.*, evolve_article_rubrics_data.*, 
        evolve_article_rubrics_data.title as rubric_title,
        evolve_article_rubrics.id as article_id
        
      FROM evolve_article_rubrics
      
      LEFT JOIN evolve_article_rubrics_data
      ON evolve_article_rubrics_data.for_instance_id = evolve_article_rubrics.id
        AND evolve_article_rubrics_data.lang =  '$default_language'
  
      ");

$get_cd_cody_list = $mysqli->query("
      SELECT evolve_cd_cody_list.*, evolve_cd_cody_data.*, 
        evolve_cd_cody_data.title as estate_title,
        evolve_cd_cody_list.id as estate_id
        
      FROM evolve_cd_cody_list
      
      LEFT JOIN evolve_cd_cody_data
      ON evolve_cd_cody_data.for_instance = evolve_cd_cody_list.id
        AND evolve_cd_cody_data.lang =  '$default_language'
  
      ");

$get_shop_list = $mysqli->query("
      SELECT evolve_product_category.*, evolve_product_category_data.*, 
        evolve_product_category_data.title as shop_title,
        evolve_product_category.id as shop_id
        
      FROM evolve_product_category
      
      LEFT JOIN evolve_product_category_data
      ON evolve_product_category_data.for_instance = evolve_product_category.id
        AND evolve_product_category_data.lang =  '$default_language'
  
      ");


// if (!$get_cd_cody_list) print_r($mysqli->error);

?>
<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3><?php echo $lang['evolve_general']; ?></h3>
        <ul class="nav side-menu">
            <li>
                <a><i class="fa fa-paper-plane"></i> <?php echo $lang['menu_live'] ?> <span
                            class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php foreach ($portals as $portal) { ?>

                        <li><a href="<?php echo $portal->url ?>"
                               target="_blank"><?php echo $portal->url ?></a></li>
                    <?php } ?>
                </ul>
            </li>
            <!-- home -->
            <li class="<?php echo (!($_GET)) ? 'current-page' : '' ?>"><a href="index.php"><i
                            class="fa fa-home"></i><?php echo $lang['menu_evolve_home']; ?></a></li>

            <?php
            //SOCIAL
            $module_id = find_module('sprofile')['id'];
            if (evolveAllow($data_user_id, $module_id)) { ?>

                <li class="<?php echo (allow_if_module_is_loaded('evolve_social')) ? 'current-page' : '' ?>">
                    <a><i class="fa fa-user"></i> <?php echo $lang['social_menu']; ?> <span
                                class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li>
                            <a href="index.php?sprofile=<?php echo $data_user_id; ?>"><?php echo $lang['s_edit_profile']; ?></a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <?php
            //ARTICLES
            $module_id = find_module('article')['id'];
            if (evolveAllow($data_user_id, $module_id)) { ?>

                <li class="<?php echo (allow_if_module_is_loaded('articles')) ? 'current-page' : '' ?>">
                    <a><i class="fa fa-file-text-o"></i> <?php echo $lang['menu_evolve_articles']; ?> <span
                                class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <?php while ($rubric = $get_article_rubrics->fetch_assoc()) { ?>
                            <li>
                                <a href="index.php?article_list=<?php echo $rubric['article_id']; ?>"><?php echo $rubric['rubric_title']; ?></a>
                            </li>
                        <?php } ?>
                        <li class="divider-dashed"></li>
                        <li><a href="index.php?article_rubrics"><?php echo $lang['menu_article_rubrics']; ?></a></li>
                    </ul>
                </li>
            <?php } ?>

            <?php
            //MEDIA
            $module_id = find_module('media')['id'];
            if (evolveAllow($data_user_id, $module_id)) { ?>

                <li class="<?php echo (allow_if_module_is_loaded('media')) ? 'current-page' : '' ?>">
                    <a><i class="fa fa-image"></i> <?php echo $lang['menu_admin_media']; ?> <span
                                class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="index.php?media"><?php echo $lang['menu_media_library']; ?></a></li>
                        <li><a href="index.php?galleries"><?php echo $lang['menu_manage_galleries']; ?></a></li>
                        <li><a href="index.php?video"><?php echo $lang['menu_manage_video']; ?></a></li>
                    </ul>
                </li>
            <?php } ?>

            <?php
            //SLIDERS
            $module_id = find_module('slides')['id'];
            if (evolveAllow($data_user_id, $module_id)) {

                $get_sliders = $mysqli->query("
            SELECT evolve_sliders_cat.*
            FROM evolve_sliders_cat
        ");
                ?>
                <li class="<?php echo (allow_if_module_is_loaded('sliders')) ? 'current-page' : '' ?>">
                    <a><i class="fa fa-clone"></i> <?php echo $lang['menu_sliders'] ?> <span
                                class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <?php while ($sli = $get_sliders->fetch_assoc()) { ?>
                            <li><a href="index.php?slides=<?php echo $sli['id'] ?>"><?php echo $sli['name'] ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
            <?php }
            //TESTIMONIALS
            $module_id = find_module('testimonial')['id'];
            if (evolveAllow($data_user_id, $module_id)) {

            $get_sliders = $mysqli->query("
            SELECT evolve_sliders_cat.*
            FROM evolve_sliders_cat
            ");
            ?>
            <li class="<?php echo (allow_if_module_is_loaded('testimonial')) ? 'current-page' : '' ?>">
                <a href="index.php?testimonial=1"><i class="fa fa-id-card-o"></i> <?php echo $lang['menu_testimonial'] ?></a>
            </li>
            <?php } ?>

            <?php
            //ESTATE
            $module_id = find_module('estate')['id'];
            if (evolveAllow($data_user_id, $module_id)) { ?>

                <li class="<?php echo (allow_if_module_is_loaded('estate')) ? 'current-page' : '' ?>">
                    <a><i class="fa fa-bed"></i> <?php echo $lang['menu_evolve_estate']; ?> <span
                                class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <?php while ($cody_CD_module = $get_cd_cody_list->fetch_assoc()) { ?>
                            <li>
                                <a href="index.php?cd_cody_licence_list=<?php echo $cody_CD_module['estate_id']; ?>"><?php echo $cody_CD_module['estate_title']; ?></a>
                            </li>
                        <?php } ?>
                        <li class="divider-dashed"></li>
                        <li><a href="index.php?estate"><?php echo $lang['menu_cd_cody_list']; ?></a></li>
                    </ul>
                </li>
            <?php } ?>

            <?php
            //SHOP
            $module_id = find_module('article')['id'];
            if (evolveAllow($data_user_id, $module_id)) { ?>

                <li class="<?php echo (allow_if_module_is_loaded('shop')) ? 'current-page' : '' ?>">
                    <a><i class="fa fa-shopping-cart"></i> <?php echo $lang['menu_evolve_shop']; ?> <span
                                class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <?php while ($shop = $get_shop_list->fetch_assoc()) { ?>
                            <li>
                                <a href="index.php?product_list=<?php echo $shop['shop_id']; ?>"><?php echo $shop['shop_title']; ?></a>
                            </li>
                        <?php } ?>
                        <li class="divider-dashed"></li>
                        <li><a href="index.php?product_category"><?php echo $lang['menu_product_category']; ?></a></li>
                    </ul>
                </li>
            <?php } ?>

	        <?php
	        //SHOP
	        $module_id = find_module('topten_item')['id'];
	        if (evolveAllow($data_user_id, $module_id)) { ?>

                <li class="<?php echo (allow_if_module_is_loaded('topten_item')) ? 'current-page' : '' ?>">
                    <a><i class="fa fa-trophy"></i> <?php echo $lang['menu_evolve_topten']; ?> <span
                                class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">

                        <li><a href="index.php?topten_category"><?php echo $lang['menu_tt_item_category']; ?></a></li>
                    </ul>
                </li>
	        <?php } ?>

            <?php
            //WEBCAM
            $module_id = find_module('webcam')['id'];
            if (evolveAllow($data_user_id, $module_id)) { ?>
                <li class="<?php echo (allow_if_module_is_loaded('webcams')) ? 'current-page' : '' ?>">
                    <a><i class="fa fa-video-camera"></i> <?php echo $lang['menu_webcams_dd']; ?> <span
                                class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="index.php?webcam"><?php echo $lang['menu_webcams']; ?></a></li>
                        <li><a href="index.php?webcam_cat"><?php echo $lang['menu_wcam_cat']; ?></a></li>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<!-- /sidebar menu -->
