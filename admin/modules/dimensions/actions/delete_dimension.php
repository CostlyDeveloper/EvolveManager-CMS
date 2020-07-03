<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } 
security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check

if (isset($_POST['dim_id'])) {
  
  if (isset($_POST['dim_id'])) {
    $dim_id = $mysqli->real_escape_string($_POST['dim_id']);
}

$sql = $mysqli->query("
  DELETE FROM evolve_dimensions_img 
  WHERE id = '$dim_id'
");
   
$sql = $mysqli->query("
  DELETE FROM evolve_dimensions_relations 
  WHERE for_dimension = '$dim_id'
");
          
$sql = $mysqli->query("
  DELETE FROM evolve_dimensions_data 
  WHERE for_dimension = '$dim_id'
");
}
?>