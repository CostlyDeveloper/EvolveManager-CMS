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
  
  //ADRTICLE DATA - MULTILANG
  $slugs_arr = languages();
  foreach($slugs_arr as $slug){
          
    $slug                = $slug['slug'];
    $seoID               = seo_id($mysqli->real_escape_string($_POST['seoid_'.$slug]));
    $title               = $mysqli->real_escape_string($_POST['title_'.$slug]);
    $tagline             = $mysqli->real_escape_string($_POST['tagline_'.$slug]);
    $name                = $mysqli->real_escape_string($_POST['name_'.$slug]);
    $description         = $mysqli->real_escape_string($_POST['description_'.$slug]);
    $keywords            = $mysqli->real_escape_string($_POST['keywords_'.$slug]);
      
      $unique = $mysqli->query("
          CREATE UNIQUE INDEX wcat_index 
          ON evolve_webcam_cat_data (for_instance_id,lang)");        
      //if(!$unique) print_r($mysqli->error);
      $sql = $mysqli->query("  
          INSERT INTO evolve_webcam_cat_data (for_instance_id, lang, seo_id, title, tagline, name, description, keywords) 
          VALUES ('$instance_id', '$slug', '$seoID', '$title', '$tagline', '$name', '$description', '$keywords')
          ON DUPLICATE KEY UPDATE
          seo_id              = '$seoID', 
          title               = '$title',
          tagline             = '$tagline',
          name                = '$name',
          description         = '$description',
          keywords            = '$keywords'    
          ");
      
      $unique = $mysqli->query("
              ALTER TABLE evolve_webcam_cat_data
              DROP INDEX wcat_index;");
      
      $response['seoid_'.$slug] = $seoID;
      }
    // /$_POST DATA - MULTILANG
  
    //render response data in JSON format
    echo json_encode($response);
}
?>