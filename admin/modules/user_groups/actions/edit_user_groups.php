<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");

  if(!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } 
  security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
  evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check
  
if (isset($_POST['instanceID'])) {
  $instance_id           = $mysqli->real_escape_string($_POST['instanceID']);
  $name                  = $mysqli->real_escape_string($_POST['name']);
  $notice                = $mysqli->real_escape_string($_POST['notice']);
  $user_groups_table     = $mysqli->real_escape_string($_POST['user_groups_table']);
  
    //$perm = new stdClass();
  //find all Post variabla that starts with mod_
  foreach($_POST as $key => $value) {
    $pos = strpos($key , "mod_");
    if ($pos === 0){
      
      $mod = explode('mod_', $key);    
        //$perm->$key = $mod[1];
      $perm[] = $mod[1];
    }
  }// end foreach
  
  if (isset($perm)){
    $json = json_encode($perm);
  }else{
    $json = '';
  }

  $sql = $mysqli->query("     
        UPDATE $user_groups_table
        SET 
        name                   = '$name',
        notice                 = '$notice',
        permissions            = '$json'
        WHERE id = '$instance_id' ");
    //if(!$sql) print_r($mysqli->error); 
          
    //render response data in JSON format
    //echo json_encode($response);

}
?>