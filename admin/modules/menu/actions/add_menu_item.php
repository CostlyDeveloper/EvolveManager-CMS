<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root . "/system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])) {
    die_500();
}
security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check

$change_me = $lang['n_change_me'];
$instance_id = $mysqli->real_escape_string($_POST['instanceID']);
//CREATE NEW ARTICLE
$sql = $mysqli->query("  
    INSERT INTO evolve_menus_relations (for_instance, name) 
    VALUES ('$instance_id', '$change_me')      
  ");

if ($sql) {
    $new_id = $mysqli->insert_id; //Get ID of last inserted row from MySQL
    ?>
    <li id="item_<?php echo $new_id; ?>" class="list-group-item">
  <span class="pull-left margin_icon">
  <i class="fa fa-arrows"></i>
  </span>
        <span class="pull-right margin_icon">
  <a data-id="<?php echo $new_id; ?>" class="edit_menu_item btn btn-info btn-xs"><i class="fa fa-pencil"></i> </a>
  <a data-id="<?php echo $new_id; ?>" class="btn btn-danger btn-xs del_inst"><i class="fa fa-trash-o"></i> </a>
  </span>
        <div id="name_<?php echo $new_id; ?>">
            <?php echo $change_me; ?>
        </div>
        <span class="clearfix fix_height"></span>
    </li>
<?php } ?>