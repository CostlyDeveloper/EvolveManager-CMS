<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");

  if(!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); }
  security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
  evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check
  
if (isset($_POST['instanceID'])) {
  $instance_id            = $mysqli->real_escape_string($_POST['instanceID']);
    

  //Checkboxed    
  if (($_POST['promoted']) == 1) {
    $promoted = 1;} else{ $promoted = 0; }

    $sql = $mysqli->query("     
        UPDATE evolve_webcams
        SET 
        promoted             = '$promoted'
        WHERE id = '$instance_id' ");
  //  if(!$sql) print_r($mysqli->error);    
        


}
?>