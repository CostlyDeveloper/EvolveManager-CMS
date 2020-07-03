<?php define("ADMIN",true);
require_once ("../../../../system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check
  
if(isset($_POST['media_id'])) {
  $media_id = $mysqli->real_escape_string($_POST['media_id']);
  $slugs_arr = languages();
  foreach($slugs_arr as $slug) {
    if(isset($_POST['media_alt_'.$slug['slug']])) {
      $alt_name  = $mysqli->real_escape_string($_POST['media_alt_'.$slug['slug']]);
      $slug      = $slug['slug'];

      $unique    = $mysqli->query("
        CREATE UNIQUE INDEX unique_index 
        ON evolve_media_alt (for_media,for_lang)
      ");
      $sql       = $mysqli->query("  
        INSERT INTO evolve_media_alt (for_lang, for_media, content) 
        VALUES ('$slug', '$media_id','$alt_name')
        ON DUPLICATE KEY UPDATE
        content='$alt_name'        
      ");
      $unique    = $mysqli->query("
        ALTER TABLE evolve_media_alt
        DROP INDEX unique_index;
        ");
    }
  } 
}
?>