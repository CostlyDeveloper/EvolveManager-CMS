<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");

  if(!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); }
  security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
  evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check
 
foreach($_POST['postData'] as $position=>$id ){
           
  $sql = $mysqli->query("     
    UPDATE evolve_webcam_cat
    SET 
    position             = '$position'
    WHERE id = '$id' ");
  
}
?>