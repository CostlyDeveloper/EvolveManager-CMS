<?php
define("ADMIN", true);
require_once("../../../../system/config.php");

  if(!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); }
  security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
  evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check
  
$email                 = $mysqli->real_escape_string($_POST['email']);
$password              = $mysqli->real_escape_string($_POST['pass']);
$password              = encrypt($password);
$message = '';
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  die(header("HTTP/1.0 404 Not Found")); //Throw an error on failure
}

//CREATE NEW ARTICLE
$sql = $mysqli->query("  
  INSERT INTO evolve_users (email, password) 
  VALUES ('$email', '$password')      
");
//if(!$sql) print_r($mysqli->error);
if($sql){
  $id = $mysqli->insert_id; //Get ID of last inserted row from MySQL  

  $response['load_new'] = $domain.'/admin/index.php?users='.$id;
  echo json_encode($response);
}  
?>