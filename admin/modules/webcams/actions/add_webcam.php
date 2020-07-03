<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");

  if(!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); }
  security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
  evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check
 
$lang_arr = json_decode(stripslashes($_POST['data']), true);
$author_id = $_POST['userID'];

//CREATE NEW ARTICLE
$sql = $mysqli->query("  
  INSERT INTO evolve_webcams (created_by) 
  VALUES ('$author_id')      
");
if(!$sql) print_r($mysqli->error);
if($sql){
  $id = $mysqli->insert_id; //Get ID of last inserted row from MySQL  
  foreach($lang_arr as $slug ){
    $title        = $slug['title'];
    $slug         = $slug['slug'];
    $seo_id       = seo_id($title);
    $check_seo_id = $mysqli->query("
      SELECT evolve_webcams_data.*
      FROM evolve_webcams_data
      WHERE evolve_webcams_data.seo_id = '$seo_id'
    ");
    //if(!$check_seo_id) print_r($mysqli->error);
    $check_seo = $check_seo_id->fetch_array(MYSQLI_BOTH);
    if($check_seo){
      $seo_id = $seo_id.time('timestamp');
    }
    $sql = $mysqli->query("  
      INSERT INTO evolve_webcams_data (for_wcam, lang, seo_id, title) 
      VALUES ('$id', '$slug', '$seo_id', '$title')      
    ");
    //if(!$sql) print_r($mysqli->error);
    
  }
  $response['load_new'] = $domain.'/admin/index.php?webcam='.$id;
    echo json_encode($response);
}
?>