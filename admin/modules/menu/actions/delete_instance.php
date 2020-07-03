<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root . "/system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])) {
    die_500();
}
security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check

if (isset($_POST['instanceID'])) {

    $instance_id = $mysqli->real_escape_string($_POST['instanceID']);

    $sql = $mysqli->query("
    DELETE FROM evolve_menus_relations
    WHERE id = '$instance_id'
  ");
    $sql = $mysqli->query("
    DELETE FROM evolve_menus_data
    WHERE for_instance = '$instance_id'
  ");
}
?>