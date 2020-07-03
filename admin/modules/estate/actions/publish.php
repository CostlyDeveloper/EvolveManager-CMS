<?php
define("ADMIN", true);
require_once("../../../../system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check

if (isset($_POST['itemID'])) {
  $item_id            = $mysqli->real_escape_string($_POST['itemID']);
    
  //ITEM INFO

  //Checkboxed    
  if (($_POST['is_legal']) == 1) {
    $is_legal = 1;} else{ $is_legal = 0; }

    $sql = $mysqli->query("     
        UPDATE evolve_cd_cody_licences
        SET 
        is_legal             = '$is_legal'
        WHERE id = '$item_id' ");
    // if(!$sql) print_r($mysqli->error);
        
    // echo $item_id;
    // /ITEM INFO

}
?>
