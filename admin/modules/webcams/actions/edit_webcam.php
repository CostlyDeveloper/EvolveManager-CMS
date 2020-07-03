<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");

  if(!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); }
  security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
  evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check
 
if (isset($_POST['instanceID'])) {
  $instance_id           = $mysqli->real_escape_string($_POST['instanceID']);
  $user_id               = $mysqli->real_escape_string($_POST['userID']);
  $password              = $mysqli->real_escape_string($_POST['wcamPassword']);
  $hosted_name           = $mysqli->real_escape_string($_POST['hosted_name']);
  $hosted_url            = $mysqli->real_escape_string($_POST['hosted_url']);
  $city                  = $mysqli->real_escape_string($_POST['wcamCity']);
    
  //
  $publishing_date       = $mysqli->real_escape_string($_POST['publishing_date']);
  $publishing_date       = strtotime($publishing_date);
  $publishing_date       = date ("Y-m-d", $publishing_date);
  
  $finishing_date       = $mysqli->real_escape_string($_POST['finishing_date']);
  $finishing_date       = strtotime($finishing_date);
  $finishing_date       = date ("Y-m-d", $finishing_date);
  
  //
  
  if (isset($_POST['gal_id'])) {
    $gallery_id = $mysqli->real_escape_string($_POST['gal_id']);
  } else{ $gallery_id = '0';}
  //INSERT OR UPDATE STREAM RELATIONS
  $del = $mysqli->query("
      DELETE FROM evolve_webcam_stream_relations 
      WHERE for_webcam = '$instance_id'
    ");
    
  if (isset($_POST['multiID'])) {
    $multi_stream_nr = count($_POST['multiID']);
    for($i = 0; $i < $multi_stream_nr; ++$i) {
      $stream_id = $_POST['multiID'][$i];
      $stream_name = $_POST['multiName'][$i];
      $sql = $mysqli->query("  
        INSERT INTO evolve_webcam_stream_relations (stream_id,stream_name,for_webcam,position) 
        VALUES ('$stream_id', '$stream_name', '$instance_id', '$i')
      ");
    } 
  }
  // /INSERT OR UPDATE STREAM RELATIONS
  
  //INSERT OR UPDATE CATEGORIES
  $del = $mysqli->query("
      DELETE FROM evolve_webcam_cat_relations 
      WHERE for_webcam = '$instance_id'
    ");
    
  if(isset($_POST['categories'])){
    foreach($_POST['categories'] as $cat){
         
      $sql = $mysqli->query("  
        INSERT INTO evolve_webcam_cat_relations (for_webcam, for_cat) 
        VALUES ('$instance_id', '$cat')
        
      ");    
    }
  }
  // /INSERT OR UPDATE CATEGORIES
  
  //WEBCAM DATA - MULTILANG
  $slugs_arr = languages();
  foreach($slugs_arr as $slug){
          
    $slug                = $slug['slug'];
    $seoID               = seo_id($mysqli->real_escape_string($_POST['wcamSeoid_'.$slug]));
    $title               = $mysqli->real_escape_string($_POST['wcamTitle_'.$slug]);
    
    if(!$seoID){
      if($title){    
       $seoID               = seo_id($title); 
      }
    }
    
    $tagline             = $mysqli->real_escape_string($_POST['wcamTagline_'.$slug]);
    $description         = $mysqli->real_escape_string($_POST['wcamDescription_'.$slug]);
    $content             = $mysqli->real_escape_string($_POST['wcamContent_'.$slug]);
    $keywords            = $mysqli->real_escape_string($_POST['wcamKeywords_'.$slug]);
      
  
      $unique = $mysqli->query("
          CREATE UNIQUE INDEX cam_index 
          ON evolve_webcams_data (for_wcam,lang)");        
      //if(!$unique) print_r($mysqli->error);
      $sql = $mysqli->query("  
          INSERT INTO evolve_webcams_data (for_wcam, lang, seo_id, title, tagline, description, content, keywords) 
          VALUES ('$instance_id', '$slug', '$seoID', '$title', '$tagline', '$description', '$content', '$keywords')
          ON DUPLICATE KEY UPDATE
          seo_id              = '$seoID', 
          title       = '$title',
          tagline     = '$tagline',
          description = '$description',
          content     = '$content',
          keywords    = '$keywords'    
          ");
      
      $unique = $mysqli->query("
              ALTER TABLE evolve_webcams_data
              DROP INDEX cam_index;");
      
      $response['wcamSeoid_'.$slug] = $seoID;
      }
    // /$_POST DATA - MULTILANG
    
  //WEBCAM INFO
  //Checkboxed    
  if (isset($_POST['published'])) {
    $published = 1;} else{ $published = 0; }
  if (isset($_POST['featured'])) {
    $featured = 1;} else{ $featured = 0; }
  if (isset($_POST['promoted'])) {
    $promoted = 1;} else{ $promoted = 0; } 
  if (isset($_POST['history'])) {
    $history = 1;} else{ $history = 0; } 
  if (isset($_POST['show_date'])) {
    $show_date = 1;} else{ $show_date = 0; }
  if (isset($_POST['show_date_end'])) {
    $show_date_end = 1;} else{ $show_date_end = 0; }
  if (isset($_POST['activate_schedule'])) {
    $activate_schedule = 1;} else{ $activate_schedule = 0; }
  if (isset($_POST['show_cover_img'])) {
    $show_cover_img = 1;} else{ $show_cover_img = 0; } 
 //Multi stream    
   $stream_id = '';
   if (isset($_POST['single_stream'])) {
     $multi_stream = 0; 
     $stream_id = 'stream_id = "'.$_POST['single_stream'].'",';
   } else{ $multi_stream = 1; }

    $sql = $mysqli->query("     
        UPDATE evolve_webcams
        SET 
        published             = '$published',
        featured              = '$featured',
        promoted              = '$promoted',
        history               = '$history',
        city                  = '$city',
        hosted_url            = '$hosted_url',
        hosted_name           = '$hosted_name',
        multi_stream          = '$multi_stream',
        $stream_id
        date_start            = '$publishing_date',
        date_end              = '$finishing_date',
        show_date_end         = '$show_date_end',
        show_date             = '$show_date',
        password              = '$password',
        last_edit_user        = '$user_id',
        gallery_id            = '$gallery_id', 
        last_edit_time        =  CURRENT_TIMESTAMP
        WHERE id = '$instance_id' ");
    if(!$sql) print_r($mysqli->error);       
    // /WEBCAM INFO
    //render response data in JSON format
    echo json_encode($response);
}
?>