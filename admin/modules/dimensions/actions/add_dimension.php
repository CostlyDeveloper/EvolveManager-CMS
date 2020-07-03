<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } 
security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check

$newDim = $_POST['newDim'];

//CREATE NEW DIMENSION
$sql = $mysqli->query("  
  INSERT INTO evolve_dimensions_img (name) 
  VALUES ('$newDim')      
");

	if($sql)
  {
    $new_id = $mysqli->insert_id; //Get ID of last inserted row from MySQL
    $data = $mysqli->query("  
      INSERT INTO evolve_dimensions_data (for_dimension) 
      VALUES ('$new_id')      
    ");
    $response['load_dim_url'] = 'index.php?dimensions='.$new_id; 
}    
    //render response data in JSON format
    echo json_encode($response);
?>