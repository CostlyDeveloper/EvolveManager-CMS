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
//if(!$get_article_rubrics) print_r($mysqli->error);

?><!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <ul class="nav navbar-nav pull-right">
                <?php include(ADMIN_PATH . '/layout/top_navigation_message.php'); ?><?php if (!$bridge_cody_chat) { ?><?php include(ADMIN_PATH . '/layout/top_navigation_user.php'); ?><?php } ?><?php //hide menu if no items

                if (
                    evolveAllow($data_user_id, find_module('users')['id']) OR
                    evolveAllow($data_user_id, find_module('user_groups')['id']) OR
                    evolveAllow($data_user_id, find_module('dimensions')['id']) OR
                    evolveAllow($data_user_id, find_module('ads')['id']) OR
                    evolveAllow($data_user_id, find_module('site_setup')['id']) OR
                    evolveAllow($data_user_id, find_module('menu')['id']) OR
                    evolveAllow($data_user_id, find_module('languages')['id'])
                ) {
                    include(ADMIN_PATH . '/layout/top_navigation_settings.php');
                } ?>
            </ul>
        </nav>
    </div>
</div><!-- /top navigation -->
