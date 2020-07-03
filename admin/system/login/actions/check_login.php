<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");

$email                 = $mysqli->real_escape_string($_POST['email']);
$password              = $mysqli->real_escape_string(encrypt($_POST['password']));
$message = '';
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $message = $lang['er_invalid_email'];
}
else{  
  $query = $mysqli->query("
    SELECT evolve_users.*
    FROM evolve_users
    WHERE email='$email' AND password='$password'
  ");
   //if(!$query) print_r($mysqli->error);
  
  //
  if ($query->num_rows > 0){
    $row = $query->fetch_array(MYSQLI_BOTH);
    
    $instance_id           = $row['id'];
    $new_token             = encrypt(time('timestamp'));//Generate new token
    
    
    //echo pr($row);
    setcookie("ev_userid", $row['id'], time() + (86400 * 30), "/"); 
    setcookie("ev_tok", $row['password'], time() + (86400 * 30), "/");
    $response['load_admin'] = $domain.'/admin/index.php';
    
    $sql = $mysqli->query("     
        UPDATE evolve_users
        SET 
        token                  = '$new_token'
        WHERE id = '$instance_id' ");
    //if(!$sql) print_r($mysqli->error);    
    
    
  }
  else{
    $message = $lang['er_cant_find_usr'];
  }

}
if($message){
  $response['message'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$message.'</div>';
}
  

  echo json_encode($response);

?>