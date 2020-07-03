<?php
define("ADMIN", true);
require_once("../../../../system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check

if (isset($_POST['gallery_id'])) {
  $gallery_id = $mysqli->real_escape_string($_POST['gallery_id']);
    
  $gal_items = $mysqli->query(" 
    DELETE FROM evolve_galleries    
    WHERE evolve_galleries.id = $gallery_id
  "); 
     
  $sql = $mysqli->query("
    DELETE FROM evolve_gallery_items 
    WHERE gallery_id = $gallery_id
  ");       
}
?>