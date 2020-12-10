<div class="main">
    <div class="container">

        <?php //include(FRONTEND_PATH.'layout/service_box.php');
        //include(FRONTEND_PATH.'layout/blocks/recent_active_users.php');
        include(FRONTEND_PATH . 'layout/blocks/news_events_block.php');
        //include(FRONTEND_PATH.'layout/blocks/tabs_block.php');
        if (get_ad('home_center_top')) {
            include(FRONTEND_PATH . 'layout/blocks/ad_center_top.php');
        }
        include(FRONTEND_PATH . 'layout/blocks/blockquote_block.php');
        // include(FRONTEND_PATH.'layout/blocks/live_stream.php');
        include(FRONTEND_PATH . 'layout/blocks/partners_slider.php');//preporuke
        include(FRONTEND_PATH . 'layout/blocks/featured_video.php');
        //include(FRONTEND_PATH.'layout/blocks/featured_articles.php');

        ?>

    </div>
</div>
<!--========== END PAGE LAYOUT ==========-->
