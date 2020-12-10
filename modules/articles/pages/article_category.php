<?php
  $get_article_category = $mysqli->query("
      SELECT evolve_article_rubrics.pagination,
       evolve_article_rubrics_data.for_instance_id,
       evolve_article_rubrics_data.seo_id,
       evolve_article_rubrics_data.title,
       evolve_article_rubrics_data.description,
       evolve_article_rubrics.img,
       evolve_article_rubrics.folder
        
      FROM evolve_article_rubrics_data
      
      INNER JOIN evolve_article_rubrics
      ON evolve_article_rubrics.id = evolve_article_rubrics_data.for_instance_id
      
      WHERE seo_id = '$instance_seo_id'
        AND lang =  '$language'
      ");
  $cat                      = $get_article_category->fetch_array(MYSQLI_ASSOC);
  $cat_id                   = $cat['for_instance_id'];
  $no_of_records_per_page   = $cat['pagination'];
  $cat_url                  = FRONTEND_URL.$cat['seo_id'].'/';
  
  $result_pagination = $mysqli->query("
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
        
      WHERE evolve_articles.category = '$cat_id'
        AND evolve_articles.published = '1'
      ORDER BY evolve_articles.id DESC
      ");
  //if(!$result_pagination) print_r($mysqli->error);
  
  $upload_folder       = $data['domain'].'/media/upload/articles';
  $layout_path         = 'modules/articles/layout/';
  $module              = 4;
  $module_child        = 1;
  
  /** PAGITATION QUERY **/
        if (isset($_POST['pageno'])) {
            $pageno = $_POST['pageno'];
        } else {
            $pageno = 1;
        }
        $offset = (($pageno - 1 ) * $no_of_records_per_page);
        $total_rows = $result_pagination->num_rows;
        $total_pages = ceil($total_rows / $no_of_records_per_page);
        
        $res_data = $mysqli->query("
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
                
              WHERE evolve_articles.category = '$cat_id'
                AND evolve_articles.published = '1'
              ORDER BY evolve_articles.id DESC
              
               LIMIT $offset, $no_of_records_per_page
              ");
  /** / PAGITATION QUERY **/
  
  $cover_image = '';
  if($cat['img']){
  $cover_image = $upload_folder.$cat['folder'].$cat['img'];
  } 
  set_website_head(lang_return('website_title').' | '.$cat['title'], $cat['description'], $cover_image, '', '', '');
  ?>
<div class="content container">
  <!-- BEGIN SIDEBAR & CONTENT -->
  <div class="row margin-bottomottom-40">
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-sm-12">
      <div class="content-page">
        <div class="row">
          <!-- BEGIN LEFT SIDEBAR -->            
          <div class="col-md-8 col-sm-8 blog-posts">
           <?php if($cat['img']){
              include(FRONTEND_PATH.$layout_path.'cover.php');?>
              <h1><?php echo $cat['title']; ?></h1>
              <br />
             <?php } ?>
            <!-- Items -->
            <?php include(FRONTEND_PATH.$layout_path.'cat_items.php'); ?>
            <!-- / Items -->                   
            <?php include(FRONTEND_PATH.$layout_path.'cat_pagination.php'); ?>              
          </div>
          <!-- END LEFT SIDEBAR -->
          <!-- BEGIN RIGHT SIDEBAR -->            
          <div class="col-md-4 col-sm-4 blog-sidebar">
            <?php if (get_ad('articles_top_aside')){ ?>
            <div class="row margin-bottom-40 section-seperator">
              <?php echo get_ad('articles_top_aside');?>
            </div>
            <?php }?>
            <?php if($cat_id == 1){ include(FRONTEND_PATH.$layout_path.'all_events.php');} ?>
            <?php if($cat_id == 8){ include(FRONTEND_PATH.$layout_path.'all_news.php');} ?>                                                    
            <?php if (get_ad('articles_bottom_aside')){ ?>
            <div class="row margin-bottom-40 section-seperator">
              <?php echo get_ad('articles_bottom_aside');?>
            </div>
            <?php }?>
          </div>
          <!-- END RIGHT SIDEBAR -->            
        </div>
      </div>
    </div>
    <!-- END CONTENT -->
  </div>
  <!-- END SIDEBAR & CONTENT -->
</div>