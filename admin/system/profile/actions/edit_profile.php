<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");

//echo pr($_POST);


if (isset($_POST['instanceID'])) {
  $instance_id           = $mysqli->real_escape_string($_POST['instanceID']);
  $token                 = $mysqli->real_escape_string($_POST['profile_token']);
  $email                 = $mysqli->real_escape_string($_POST['email']);
  $first_name            = $mysqli->real_escape_string($_POST['first_name']);
  $last_name             = $mysqli->real_escape_string($_POST['last_name']);
  $company               = $mysqli->real_escape_string($_POST['company']);
  $mobile_number         = $mysqli->real_escape_string($_POST['mobile_number']);
  $password              = $mysqli->real_escape_string($_POST['password']);
  $password2             = $mysqli->real_escape_string($_POST['password2']);
  
  $pass = '';
  if ($password) {
    
    if ($password == $password2) {
      
      $password = encrypt($password);
      $pass = "password = '$password',";
      
    }else
    {
       die(header("HTTP/1.0 404 Not Found")); //Throw an error on failure
    }
  
  }

    $sql = $mysqli->query("     
        UPDATE evolve_users
        SET 
        first_name             = '$first_name',
        last_name              = '$last_name',
        company                = '$company',
        $pass
        mobile_number          = '$mobile_number'
        WHERE id = '$instance_id' AND token = '$token' ");
    if(!$sql) print_r($mysqli->error);    
            
    //render response data in JSON format
    echo json_encode($response);

}
?>