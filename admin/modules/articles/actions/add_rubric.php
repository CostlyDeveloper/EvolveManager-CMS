<?php
define("ADMIN", true);
require_once("../../../../system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check

if (isset($_POST['userID'])) {

//CREATE NEW ARTICLE
$sql = $mysqli->query("  
        INSERT INTO evolve_article_rubrics () 
        VALUES ()      
        ");
	if($sql)
  {
    $id = $mysqli->insert_id; //Get ID of last inserted row from MySQL
    
    $response['load_new'] = $domain.'/admin/index.php?article_rubrics='.$id;
    echo json_encode($response);
}
}
?>