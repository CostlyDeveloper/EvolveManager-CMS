<?php
define("ADMIN", true);
require_once("../../../../system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check

if (isset($_POST['articleID'])) {
  $article_id            = $mysqli->real_escape_string($_POST['articleID']);
  $user_id               = $mysqli->real_escape_string($_POST['userID']);
  $publishing_date       = $mysqli->real_escape_string($_POST['datetimepicker_article_publishing']);
  $publishing_date       = strtotime($publishing_date);
  $publishing_date       = date ("Y-m-d H:i:s", $publishing_date);
  $schedule              = $mysqli->real_escape_string($_POST['art_schedule']);
  $schedule              = strtotime($schedule);
  $schedule              = date ("Y-m-d H:i:s", $schedule);
  
  $galery_attached = '';
  if (isset($_POST['gal_id'])) {
    $gallery_id = $mysqli->real_escape_string($_POST['gal_id']);
    $galery_attached = "gallery_id            = '$gallery_id',";
  }
    
  
  //ADRTICLE DATA - MULTILANG
  $slugs_arr = languages();
  foreach($slugs_arr as $slug){
          
    $slug                = $slug['slug'];
    $seoID               = seo_id($mysqli->real_escape_string($_POST['articleSeoid_'.$slug]));
    $articleTitle        = $mysqli->real_escape_string($_POST['articleTitle_'.$slug]);
    $articleTagline      = $mysqli->real_escape_string($_POST['articleTagline_'.$slug]);
    $articleDescription  = $mysqli->real_escape_string($_POST['articleDescription_'.$slug]);
    $articleContent      = $mysqli->real_escape_string($_POST['articleContent_'.$slug]);
    $articleKeywords     = $mysqli->real_escape_string($_POST['articleKeywords_'.$slug]);
      
  
      $unique = $mysqli->query("
          CREATE UNIQUE INDEX art_index 
          ON evolve_articles_data (for_article,lang)");        
      //if(!$unique) print_r($mysqli->error);
      $sql = $mysqli->query("  
          INSERT INTO evolve_articles_data (for_article, lang, seo_id, title, tagline, description, content, keywords) 
          VALUES ('$article_id', '$slug', '$seoID', '$articleTitle', '$articleTagline', '$articleDescription', '$articleContent', '$articleKeywords')
          ON DUPLICATE KEY UPDATE
          seo_id              = '$seoID', 
          title               = '$articleTitle',
          tagline             = '$articleTagline',
          description         = '$articleDescription',
          content             = '$articleContent',
          keywords            = '$articleKeywords'    
          ");
      
      $unique = $mysqli->query("
              ALTER TABLE evolve_articles_data
              DROP INDEX art_index;");
      
      $response['articleSeoid_'.$slug] = $seoID;
      }
    // /$_POST DATA - MULTILANG
    
  //ARTICLE INFO
  //Checkboxed    
  if (isset($_POST['published'])) {
    $published = 1;} else{ $published = 0; }
  if (isset($_POST['featured'])) {
    $featured = 1;} else{ $featured = 0; }
  if (isset($_POST['promoted'])) {
    $promoted = 1;} else{ $promoted = 0; } 
  if (isset($_POST['show_date'])) {
    $show_date = 1;} else{ $show_date = 0; }
  if (isset($_POST['show_date'])) {
    $show_date = 1;} else{ $show_date = 0; }
  if (isset($_POST['activate_schedule'])) {
    $activate_schedule = 1;} else{ $activate_schedule = 0; }
  if (isset($_POST['show_cover_img'])) {
    $show_cover_img = 1;} else{ $show_cover_img = 0; } 
    


    $sql = $mysqli->query("     
        UPDATE evolve_articles
        SET 
        published             = '$published',
        featured              = '$featured', 
        promoted              = '$promoted',
        date                  = '$publishing_date',
        schedule              = '$schedule',
        activate_schedule     = '$activate_schedule',
        show_date             = '$show_date',
        last_edit_user        = '$user_id',
        show_cover_img        = '$show_cover_img',
        $galery_attached
        last_edit_time        =  CURRENT_TIMESTAMP
        WHERE id = '$article_id' ");
    //if(!$sql) print_r($mysqli->error);    
        
    
    // /ARTICLE INFO
            
  
    //render response data in JSON format
    echo json_encode($response);

}
?>