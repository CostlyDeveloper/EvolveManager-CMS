<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");


foreach($_POST['postData'] as $position=>$id ){

  $unique = $mysqli->query("
    CREATE UNIQUE INDEX ads_index 
    ON evolve_ads_data (id,for_instance)");   
            
  $sql = $mysqli->query("     
    UPDATE evolve_ads_data
    SET 
    position             = '$position'
    WHERE id = '$id' ");
  
  $unique = $mysqli->query("
    ALTER TABLE evolve_ads_data
    DROP INDEX ads_index;");
}
?>