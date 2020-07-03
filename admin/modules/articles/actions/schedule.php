<?php
define("ADMIN", true);
require_once("../../../../system/config.php");

if (isset($_POST['articleID'])) {
  $article_id            = $mysqli->real_escape_string($_POST['articleID']);
  $schedule              = $mysqli->real_escape_string($_POST['art_schedule']);
  $schedule              = strtotime($schedule);
  $schedule              = date ("Y-m-d H:i:s", $schedule);
    
  //ARTICLE INFO

  //Checkboxed    
  if (($_POST['schedule']) == 1) {
    $activate_schedule = 1;} else{ $activate_schedule = 0; }

    $sql = $mysqli->query("     
        UPDATE evolve_articles
        SET 
        schedule             = '$schedule',
        activate_schedule     = '$activate_schedule'
        WHERE id = '$article_id' ");
    if(!$sql) print_r($mysqli->error);    
        
    
    // /ARTICLE INFO

}
?>