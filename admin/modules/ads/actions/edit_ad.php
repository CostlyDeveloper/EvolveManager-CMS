<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check

if($developing) pr($_POST);


if (isset($_POST['instanceID'])) {
  $instance_id           = $mysqli->real_escape_string($_POST['instanceID']);
  $user_id               = $mysqli->real_escape_string($_POST['userID']);
  $name                  = $mysqli->real_escape_string($_POST['name']);
  $content               = $mysqli->real_escape_string($_POST['content']);
  $position_id           = $mysqli->real_escape_string($_POST['position_id']);
 
    
  // INFO
  //Checkboxed    
  if (isset($_POST['published'])) {
    $published = 1;} else{ $published = 0; }
    
    $sql = $mysqli->query("     
        UPDATE evolve_ads_data
        SET 
        published    = '$published',
        name         = '$name',
        content      = '$content',
        for_instance = '$position_id'
        WHERE id     = '$instance_id' ");
    //if(!$sql) print_r($mysqli->error);    
        
          

}
?>