<?php 
$page_exist = '';
          /** LEVEL 1 ONLY **/
          if(empty($level_2_seo)){ 
      
            $tables = array(
                 "evolve_article_rubrics_data"    => "article_rubric",
                 "evolve_webcam_cat_data"         => "webcam_cat"
               );   
               
            foreach($tables as $t => $b){
              $query = $mysqli->query(" 
                SELECT $t.seo_id, $t.lang, $t.title
                FROM $t    
                WHERE $t.seo_id = '$level_1_seo'
              ");
              if($query->num_rows > 0){
                $row = $query->fetch_array(MYSQLI_ASSOC);
                $innstance_lang = $row['lang'];
                //if Lang is enabled in db
                 $chk_lang_is_enabled = $mysqli->query("
                    SELECT evolve_multilang.id
                    FROM evolve_multilang
                  
                    WHERE slug = '$innstance_lang'
                      AND enabled = '1'
                  ");
              
                 if($chk_lang_is_enabled->num_rows > 0){
                  
                  
                  if ($b == 'article_rubric'){ // 
                    $instance_seo_id   = $row['seo_id'];
                    include(FRONTEND_PATH.'modules/articles/pages/article_category.php');
                    $page_exist .= 'exist';
                  }
                  if ($b == 'webcam_cat'){ // 
                    $instance_seo_id   = $row['seo_id'];                    
                    include(FRONTEND_PATH.'modules/webcams/pages/webcam_category.php');
                    $page_exist .= 'exist';
                  }
                }//if lang is not enable return false / skip
                 
              }// if exist 
            }//foreach 
           
             
          }//level 2 is not set
          
          /** /LEVEL 1 ONLY **/
          elseif(!empty($level_2_seo)){
          /** LEVEL 2 **/
          if ($level_1_seo == 'projekt'){
            $query = $mysqli->query("
              SELECT seo_id, title
              FROM evolve_webcams_data
                  
              WHERE seo_id = '$level_2_seo'
            ");
            if($query->num_rows > 0){
              $row = $query->fetch_array(MYSQLI_ASSOC);
              $instance_seo_id   = $row['seo_id'];//article ID
              include(FRONTEND_PATH.'modules/webcams/pages/webcam.php');
              $page_exist .= 'exist';
            }
          }else{
          ///////////////////////ARTICLES///////////////////////
            $tables = array(
                 "evolve_articles_data"    => "article"
               );      
            foreach($tables as $t => $b){
            if ($b == 'article'){ //
              $query = $mysqli->query(" 
                SELECT $t.seo_id, $t.for_article, $t.title
                FROM $t    
                WHERE $t.seo_id = '$level_2_seo'
              ");
              if($query->num_rows > 0){
                $row = $query->fetch_array(MYSQLI_ASSOC);
                  $instance_seo_id   = $row['seo_id'];//article ID
                  if(article_category_slug($instance_seo_id) == $level_1_seo){  
                  include(FRONTEND_PATH.'modules/articles/pages/article.php');
                  $page_exist .= 'exist';  
                  }
                  
                 
                }// if exist
              
              }//if article
               
            }//foreach  
          ///////////////////////ARTICLES///////////////////////
          }
            
          }//level 2 is set
            
        /** /LEVEL 2 **/
 if (empty($page_exist)){ 
  set_website_head(lang_return('error404'),'','','','','');
  include(FRONTEND_PATH.'pages/404.php');   }
?>