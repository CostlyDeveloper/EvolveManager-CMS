<?php
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
    
  WHERE evolve_articles.category = '1'
    AND evolve_articles.published = '1'
    AND evolve_articles.id != '$art_id'
  ORDER BY evolve_articles.date DESC
  
  LIMIT 5
  ");
  if ($feat_news->num_rows > 0) { 
  ?>
<div class="col-md-12 col-sm-12 margin-bottom-40">
  <h4><?php lang('rest_news')?></h4>
  <div class="row">
    <?php
      while($news = $feat_news->fetch_assoc()){
      $cat_seo_id          = article_category_slug($news['seo_id']).'/';
      $item_id             = $news['id'];
      $thumb_imgsrc        = $upload_folder.$news['folder'].$news['thumb_img'];
      if(!$news['thumb_img'] || !$news['show_cover_img']){
        $thumb_imgsrc   = FRONTEND_URL.'media/upload/site/'.$data['og_thumb_img'];
      }
      ?>
    <div class="margin-bottom-5 section-seperator ">
      <div class="col-md-5 col-sm-5 col-xs-5 row margin-bottom-5">
        <div class="wow zoomIn" data-wow-duration=".3" data-wow-delay=".1s">
          <a href="<?php echo $cat_seo_id.$news['seo_id'] ?>">
          <img class="img-responsive" alt="<?php echo $news['title'] ?>" src="<?php echo $thumb_imgsrc ?>" />
          </a>
        </div>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-7 margin-bottom-5">
        <h5><?php echo $news['title'] ?></h5>
      </div>
      <div class="clearfix"></div>
    </div>
    <?php } ?>
  </div>
</div>

<?php } ?>