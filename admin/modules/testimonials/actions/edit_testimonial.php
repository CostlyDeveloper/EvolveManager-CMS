<?php define("ADMIN",true);
$to_root = '../../../..';
require_once ($to_root."/system/config.php");

  if(!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } 
  security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
  evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check
  
if(isset($_POST['instanceID'])) {
  $instance_id    = $mysqli->real_escape_string($_POST['instanceID']);
  $user_id        = $mysqli->real_escape_string($_POST['userID']);
  $name           = $mysqli->real_escape_string($_POST['person_name']);
  // DATA - MULTILANG
  $slugs_arr = languages();
  foreach($slugs_arr as $slug) {
    $slug         = $slug['slug'];
    $occupation   = $mysqli->real_escape_string($_POST['testimonialOccupation_'.$slug]);
    $job_title    = $mysqli->real_escape_string($_POST['testimonialJobTitle_'.$slug]);
    $city         = $mysqli->real_escape_string($_POST['testimonialCity_'.$slug]);
    $web_name     = $mysqli->real_escape_string($_POST['testimonialWebName_'.$slug]);
    $web_url      = $mysqli->real_escape_string($_POST['testimonialWebUrl_'.$slug]);
    $rating       = $mysqli->real_escape_string($_POST['testimonialRating_'.$slug]);
    $message      = $mysqli->real_escape_string($_POST['testimonialMessage_'.$slug]);
    $unique       = $mysqli->query("
      CREATE UNIQUE INDEX testimonial_index 
      ON evolve_testimonials_data (for_instance,lang)");
    //if(!$unique) print_r($mysqli->error);
    $sql = $mysqli->query("  
      INSERT INTO evolve_testimonials_data (for_instance, lang, occupation, job_title, city, web_name, web_url, rating, message) 
      VALUES ('$instance_id', '$slug', '$occupation', '$job_title', '$city', '$web_name', '$web_url', '$rating', '$message')
      ON DUPLICATE KEY UPDATE 
      occupation  = '$occupation',
      job_title   = '$job_title',
      city        = '$city',
      web_name    = '$web_name',
      web_url     = '$web_url',
      rating      = '$rating',
      message     = '$message'
    ");
    $unique = $mysqli->query("
      ALTER TABLE evolve_testimonials_data
      DROP INDEX testimonial_index;
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
    UPDATE evolve_testimonials
    SET 
    published    = '$published',
    name         = '$name'
    WHERE id     = '$instance_id'
  ");
  //if(!$sql) print_r($mysqli->error);
  // /INFO
} ?>