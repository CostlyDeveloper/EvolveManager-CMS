<?php
define("ADMIN", true);
require_once("../../../../system/config.php");

if (isset($_POST['instanceID'])) {
  $instanceID           = $mysqli->real_escape_string($_POST['instanceID']);

  //Checkboxed    
  if (($_POST['published']) == 1) {
    $published = 1;} else{ $published = 0; }

    $sql = $mysqli->query("     
        UPDATE evolve_ads_data
        SET 
        published             = '$published'
        WHERE id = '$instanceID' ");
}
?>