<?php 
define("ADMIN",true);
$to_root = '../../../..';
require_once ($to_root."/system/config.php");

if(!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])) {die_500();}
security($_POST['userID'],$_POST['cpass'],$_POST['token'],$_POST['rdts'],$_SERVER['REQUEST_URI'],$last_ip); //First check
evolveAllow($_POST['userID'],$_POST['moduleID'],true); //Second check

$group_name = $mysqli->real_escape_string($_POST['group_name']);
//CREATE NEW ARTICLE
$sql = $mysqli->query("  
  INSERT INTO evolve_user_groups (name) 
  VALUES ('$group_name')      
");
//if(!$sql) print_r($mysqli->error);
if($sql) {
  $id = $mysqli->insert_id; //Get ID of last inserted row from MySQL
  $response['load_new'] = $domain.'/admin/index.php?user_groups='.$id;
  echo json_encode($response);
} ?>