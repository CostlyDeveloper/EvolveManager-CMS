<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } 
security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check

$ml = $_POST['ml'];

$_POST = array_diff($_POST, array('langs_length', $ml, $_POST['moduleID'], $_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts']));

$unique = $mysqli->query("
  CREATE UNIQUE INDEX ml_index 
  ON evolve_frontend_lang_strings (string_name, for_lang)
");  
        
foreach($_POST as $key => $val){

  $sql = $mysqli->query("  
    INSERT INTO evolve_frontend_lang_strings (string_name, string_value, for_lang) 
    VALUES ('$key', '$val', '$ml')
    ON DUPLICATE KEY UPDATE
    string_value        = '$val' 
  ");
   //if(!$sql) print_r($mysqli->error);     
}
$unique = $mysqli->query("
  ALTER TABLE evolve_frontend_lang_strings
  DROP INDEX ml_index;
");
?>