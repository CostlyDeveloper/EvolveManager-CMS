<?php define("ADMIN",true);
$to_root = '../../../..';
require_once ($to_root."/system/config.php");

  if(!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } 
  security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
  evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check
  
if(isset($_POST['instanceID'])) {
  $instance_id    = $mysqli->real_escape_string($_POST['instanceID']);
  $user_id        = $mysqli->real_escape_string($_POST['userID']);
  $name           = $mysqli->real_escape_string($_POST['original_title']);
  // DATA - MULTILANG
  $slugs_arr = languages();
  foreach($slugs_arr as $slug) {
    $slug         = $slug['slug'];
    $title        = $mysqli->real_escape_string($_POST['slideTitle_'.$slug]);
    $tagline      = $mysqli->real_escape_string($_POST['slideTagline_'.$slug]);
    $description  = $mysqli->real_escape_string($_POST['slideDescription_'.$slug]);
    $uri          = $mysqli->real_escape_string($_POST['slideUri_'.$slug]);
    $url          = $mysqli->real_escape_string($_POST['slideUrl_'.$slug]);
    $btn_text     = $mysqli->real_escape_string($_POST['slideBtntext_'.$slug]);
    $unique       = $mysqli->query("
      CREATE UNIQUE INDEX slide_index 
      ON evolve_sliders_data (for_instance,lang)");
    //if(!$unique) print_r($mysqli->error);
    $sql = $mysqli->query("  
      INSERT INTO evolve_sliders_data (for_instance, lang, title, tagline, description, uri, url, button_text) 
      VALUES ('$instance_id', '$slug', '$title', '$tagline', '$description', '$uri', '$url', '$btn_text')
      ON DUPLICATE KEY UPDATE 
      title       = '$title',
      tagline     = '$tagline',
      description = '$description',
      uri         = '$uri',
      url         = '$url',
      button_text = '$btn_text'
    ");
    $unique = $mysqli->query("
      ALTER TABLE evolve_sliders_data
      DROP INDEX slide_index;
    ");
  }
  // /$_POST DATA - MULTILANG
  // INFO
  //Checkboxed
  if(isset($_POST['published'])) {
    $published = 1;
  } else {
    $published = 0;
  }
  $sql = $mysqli->query("     
    UPDATE evolve_sliders
    SET 
    published    = '$published',
    name         = '$name'
    WHERE id     = '$instance_id'
  ");
  //if(!$sql) print_r($mysqli->error);
  // /INFO
} ?>