<?php
define("ADMIN", true);
require_once("../../../../system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check



if (isset($_POST['instanceID'])) {
  $instance_id            = $mysqli->real_escape_string($_POST['instanceID']);
  $user_id                = $mysqli->real_escape_string($_POST['userID']);

  //DATA - MULTILANG
  $slugs_arr = languages();
  foreach($slugs_arr as $slug){      
    $slug                = $slug['slug'];
    $seoID               = seo_id($mysqli->real_escape_string($_POST['seoId_'.$slug]));
    $title               = $mysqli->real_escape_string($_POST['title_'.$slug]);
    $description         = $mysqli->real_escape_string($_POST['description_'.$slug]);

	  if (!$seoID) {
		  if ($title) {
			  $seoID = seo_id($title);
		  }
	  }
      
    $unique = $mysqli->query("
      CREATE UNIQUE INDEX cat_index 
      ON evolve_cd_cody_data (for_instance,lang)
    ");        
    //if(!$unique) print_r($mysqli->error);
    $sql = $mysqli->query("  
      INSERT INTO  evolve_cd_cody_data (for_instance, lang, seo_id, title, description) 
      VALUES ('$instance_id', '$slug', '$seoID', '$title', '$description')
      ON DUPLICATE KEY UPDATE
      seo_id              = '$seoID', 
      title               = '$title',
      description         = '$description'   
    ");
    if($developing) if(!$sql) print_r($mysqli->error);
    $unique = $mysqli->query("
      ALTER TABLE evolve_cd_cody_data
      DROP INDEX cat_index;
    ");
      
    $response['seoId_'.$slug] = $seoID;
  }
// /DATA - MULTILANG


  //render response data in JSON format
  echo json_encode($response);
}
