<?php
$to_root = '../../..';
require_once($to_root."/system/config.php");

$response['status'] = 'err';

if(isset($_POST["cookie_name"]))
{
  $webcam_id = $_POST["cookie_name"];
  $password = $_POST['pass'];
  $cookie_name = 'project_'.$webcam_id;
    
  $query = $mysqli->query("
    SELECT evolve_webcams.id, evolve_webcams.password
    FROM evolve_webcams
        
    WHERE evolve_webcams.id = '$webcam_id'
      AND evolve_webcams.password = '$password'
  ");
 

  if ($query->num_rows > 0) {
    setcookie($cookie_name, $password, time() + (86400 * 30), "/"); // 86400 = 1 day  
    $response['status'] = 'ok';
           
  }  
 
$mysqli->close();  

}

echo json_encode($response); 
?>