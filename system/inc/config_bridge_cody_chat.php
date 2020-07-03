<?php 
(defined('ADMIN') || defined('FRONTEND')) or die();//prevent direct open


define('CHAT_PATH', realpath(__DIR__ . '/../..').'/chat/');
require(CHAT_PATH.'system/database.php'); //DATABASE LOGIN

$mysqli            = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); //DB CON
$mysqli->set_charset("utf8");
if ($mysqli->connect_error) { trigger_error($mysqli->connect_error, E_USER_ERROR);}

if(isset($_COOKIE['bc_userid']) && isset($_COOKIE['bc_utk'])){ 
  //UESR IS LOGGED
	$ident              = $_COOKIE['bc_userid'];
	$pass               = $_COOKIE['bc_utk'];
  $get_data           = $mysqli->query("
    SELECT 
     evolve_multilang.*,
     evolve_site_images.*,
     boom_users.*,
     evolve_settings.*, 
     evolve_frontend_themes.css
    FROM boom_users, evolve_settings, evolve_multilang, evolve_frontend_themes, evolve_site_images
    WHERE boom_users.user_id = '$ident' 
      AND boom_users.user_password = '$pass' 
      AND evolve_settings.language = evolve_multilang.slug
      AND evolve_frontend_themes.id = evolve_settings.theme
  ");
  if($get_data->num_rows > 0){
		$data                = $get_data->fetch_array(MYSQLI_ASSOC);
    $data_user_id        = $data['user_id'];
    $default_language    = $data['language'];
    $first_name          = $data['user_name'];
	}
  // /UESR IS LOGGED
}
else{
  // /UESR IS NOT LOGGED
  setcookie("bc_userid","",time()-100000,'/');
  setcookie("bc_utk","",time()-100000,'/');
  $get_data = $mysqli->query("
    SELECT evolve_multilang.*, evolve_settings.*, evolve_site_images.*, evolve_frontend_themes.css
    FROM evolve_multilang, evolve_settings, evolve_frontend_themes, evolve_site_images
    WHERE evolve_settings.language = evolve_multilang.slug
    AND evolve_frontend_themes.id = evolve_settings.theme
  ");
  if($get_data->num_rows > 0){
		$data = $get_data->fetch_array(MYSQLI_ASSOC);
  }
  $data['user_rank'] = false;
  // /UESR IS NOT LOGGED
}

?>