<?php
(defined('ADMIN') || defined('FRONTEND')) or die();//prevent direct open

require(SYSTEM_PATH . '/database.php'); //DATABASE LOGIN
if (!isset($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME)) {
    return;
}
$mysqli = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); //DB CON
$mysqli->set_charset("utf8");
if ($mysqli->connect_error) {
    trigger_error($mysqli->connect_error, E_USER_ERROR);
}

if (isset($_COOKIE['ev_userid']) && isset($_COOKIE['ev_tok'])) {
    //UESR IS LOGGED
    $ident = $_COOKIE['ev_userid'];
    $cpass = $_COOKIE['ev_tok'];
    $get_data = $mysqli->query("
    SELECT 
     evolve_multilang.*,
     evolve_settings.*,
     evolve_site_images.*, 
     evolve_users.*,
     evolve_frontend_themes.css
   
    FROM evolve_users, evolve_settings, evolve_multilang, evolve_frontend_themes, evolve_site_images
    
    WHERE evolve_users.id = '$ident' 
      AND evolve_users.password = '$cpass' 
      AND evolve_settings.language = evolve_multilang.slug
      AND evolve_frontend_themes.id = evolve_settings.theme
  ");
    // if(!$get_data) print_r($mysqli->error);

    if ($get_data->num_rows > 0) {
        $data = $get_data->fetch_array(MYSQLI_ASSOC);
        $data_user_id = $data['id'];
        $default_language = $data['language'];
        $first_name = $data['first_name'];
        $reg_date_ts = strtotime($data['reg_date']);
        $last_uri = $_SERVER['REQUEST_URI'];
    } else {
        setcookie("ev_userid", "", time() - 100000, '/');
        setcookie("ev_tok", "", time() - 100000, '/');
        header("Refresh:0");
    }
    // /UESR IS LOGGED
} else {
    // /UESR IS NOT LOGGED
    setcookie("ev_userid", "", time() - 100000, '/');
    setcookie("ev_tok", "", time() - 100000, '/');
    $get_data = $mysqli->query("
    SELECT 
      evolve_multilang.*,
      evolve_settings.*,
      evolve_site_images.*,
      evolve_frontend_themes.css
      
    FROM evolve_multilang, evolve_settings, evolve_frontend_themes, evolve_site_images
    
    WHERE evolve_settings.language = evolve_multilang.slug
    AND evolve_frontend_themes.id = evolve_settings.theme
  ");
    //if(!$get_data) print_r($mysqli->error);

    if ($get_data->num_rows > 0) {
        $data = $get_data->fetch_array(MYSQLI_ASSOC);
    }
    $data['user_rank'] = false;
    // /UESR IS NOT LOGGED
}

?>
