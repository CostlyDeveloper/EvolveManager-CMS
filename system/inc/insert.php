<?php
if (evolveLogged()){
(defined('ADMIN') || defined('FRONTEND')) or die();//prevent direct open
 
  $last_ip             = GetIP();
  $set_new_token = '';
    
  if($data['token'] != $cses_id){
    $set_new_token = "token                 = '$ses_id',";
  }
  $insert_user_log = $mysqli->query("  
    UPDATE evolve_users
    SET 
      $set_new_token
      last_ip      = '$last_ip',
      last_uri     = '$last_uri',
      last_active  = CURRENT_TIMESTAMP
    WHERE id = '$data_user_id'  
  ");
  //if(!$insert_user_log) print_r($mysqli->error);
  //if(!$insert_seesion){ die();}
}
?>