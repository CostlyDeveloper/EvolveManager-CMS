<!-- BEGIN SIDEBAR & CONTENT -->
<div class="content container">
  <div class="row margin-bottom-40">
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-sm-12">
      <h1><?php echo $row['title'] ?></h1>
      <div class="content-page margin-bottom-40">
        <div class="row">
          <!-- BEGIN LEFT SIDEBAR -->  
          <div class="col-md-9 col-sm-9 col-xs-12 blog-item">
            <?php if ($row['show_cover_img']){
              include(FRONTEND_PATH.$layout_path.'cover.php');
              } ?>                       
            <h2><?php echo $row['tagline'] ?></h2>
            <?php include(FRONTEND_PATH.$layout_path.'info.php'); ?> 
            <p><strong><?php echo $row['description'] ?></strong></p>

            <?php include(FRONTEND_PATH.$layout_path.'gallery_carousel.php'); ?>           
            <?php echo $row['content'] ?>
          </div>
          <!-- END LEFT SIDEBAR -->
          <!-- BEGIN RIGHT SIDEBAR -->            
          <div class="col-md-3 col-sm-3 col-xs-12 blog-sidebar">
            <?php if (get_ad('articles_top_aside')){ ?>
            <div class="row margin-bottom-40 section-seperator">
              <?php echo get_ad('articles_top_aside');?>
            </div>
            <?php }?>
            <?php include(FRONTEND_PATH.$layout_path.'/rest_featured_articles.php');?>
            
            <!-- BEGIN BLOG TAGS -->
            <?php include(FRONTEND_PATH.$layout_path.'tags.php'); ?>
            <!-- END BLOG TAGS -->
            <?php if (get_ad('articles_bottom_aside')){ ?>
            <div class="row margin-bottom-40 section-seperator">
              <?php echo get_ad('articles_bottom_aside');?>
            </div>
            <?php }?>
          </div>
          <!-- END RIGHT SIDEBAR -->            
        </div>
      </div>
      <!-- VIDEO -->
      <?php include(FRONTEND_PATH.$layout_path.'video_carousel.php'); ?>
      <!--/VIDEO -->
    </div>
    <!-- END CONTENT -->
  </div>
  <!-- END SIDEBAR & CONTENT -->
</div>