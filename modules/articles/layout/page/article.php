<?php 
  //pr($row ); 
  
  $feat_news = $mysqli->query("
         SELECT evolve_articles.*, 
           evolve_articles.published, 
           evolve_articles.featured,
           evolve_articles.promoted, 
           evolve_articles.date, 
           evolve_articles.show_date, 
           evolve_articles.thumb_img, 
           evolve_articles.folder, 
           evolve_articles.show_cover_img, 
           evolve_articles_data.title,
           evolve_articles_data.seo_id,
           evolve_articles_data.tagline,
           evolve_articles_data.description,
           evolve_articles_data.keywords,
           evolve_articles.id as article_id
         FROM evolve_articles
         
         INNER JOIN evolve_articles_data
         ON evolve_articles_data.for_article = evolve_articles.id
           AND evolve_articles_data.lang =  '$language'
           
         WHERE evolve_articles.category = '$category'
           AND evolve_articles.published = '1'
           AND evolve_articles.id != '$art_id'
         ORDER BY evolve_articles.date DESC
         
         LIMIT 5
         ");
  ?>
<!-- BEGIN SIDEBAR & CONTENT -->
<div class="content container">
  <div class="row margin-bottom-40">
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-sm-12">
      <h1><?php echo $row['title'] ?></h1>
      <div class="content-page margin-bottom-40">
        <div class="row"> 
          <div class="col-md-12 col-sm-12 col-xs-12 blog-item">
            <?php if ($row['show_cover_img']){
              include(FRONTEND_PATH.$layout_path.'cover.php');
              } ?>                       
            <h2><?php echo $row['tagline'] ?></h2>
            <?php include(FRONTEND_PATH.$layout_path.'info.php'); ?> 
            <p><strong><?php echo $row['description'] ?></strong></p>

            <?php include(FRONTEND_PATH.$layout_path.'gallery_carousel.php'); ?>           
            <?php echo $row['content'] ?>
          </div>
       
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