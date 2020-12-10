<?php
  $for_category = '8';
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
         
       WHERE evolve_articles.category = '$for_category'
         AND evolve_articles.published = '1'
         AND evolve_articles.promoted = '1'
       ORDER BY evolve_articles.date DESC
       
       LIMIT 3
       ");
  //if(!$feat_news) print_r($mysqli->error);
   if($feat_news->num_rows > 0){
  
  $art_folder       = $data['domain'].'/media/upload/articles';
  ?>
        <div class="row recent-work margin-bottom-10">
          <div class="col-md-12 col-sm-12 col-xs-12 indent-20">
            <h2><?php lang('promoted_events_title')?></h2>
            <p><?php lang('promoted_events_description')?></p>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12 temp_hidden none" >
            <div class="owl-carousel owl-recent_articles">
            <?php while($news = $feat_news->fetch_assoc()){
                  $cat_seo_id          = article_category_slug($news['seo_id']).'/';
                  $item_id             = $news['article_id'];
                  $thumb_imgsrc        = $art_folder.$news['folder'].$news['thumb_img']; 
                  if(!$news['thumb_img']){
                    $thumb_imgsrc   = FRONTEND_URL.'/media/upload/site/'.$data['og_thumb_img'];
                  }?>
              <div class="recent-work-item">
                <em>
                  <img src="<?php echo $thumb_imgsrc ?>" alt="<?php echo $news['title'] ?>" class="img-responsive">
                  <a href="<?php echo $cat_seo_id.$news['seo_id'] ?>"><i class="overlay"><?php lang('read_more')?></i></a> 
                </em>
                <a class="recent-work-description colorart<?php echo $for_category?>" href="<?php echo $cat_seo_id.$news['seo_id'] ?>">
                  <strong><?php echo $news['title'] ?></strong>
                  <?php echo ($news['tagline'] ? '<b>'.$news['tagline'].'</b>' : '') ?>
                </a>
              </div>
            <?php } ?>
            </div>       
          </div>
        </div>   
<?php } ?>