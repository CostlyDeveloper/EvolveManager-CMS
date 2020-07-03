<?php
  define("ADMIN", true);
  $to_root = '../../../..';
  require_once($to_root."/system/config.php");
  
  if(!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } 
  security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
  evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check
  
  $author_id           = $mysqli->real_escape_string($_POST['userID']);
  $name                = $mysqli->real_escape_string($_POST['name']);
  $for_instance        = $mysqli->real_escape_string($_POST['for_instance']);
  
  //CREATE NEW 
  $sql = $mysqli->query("  
    INSERT INTO evolve_sliders (name, for_instance, author) 
    VALUES ('$name', '$for_instance', '$author_id')      
  ");
  //if(!$sql) print_r($mysqli->error);
  
  if($sql)
  {
  $new_id   = $mysqli->insert_id; 
  ?>
<li class="list-group-item" data-id="<?php echo $new_id;?>" id="instanceID_<?php echo $new_id; ?>">
  <div class="col-xs-2 col-md-1 pull-left">
    <i class="fa fa-arrows"></i>
  </div>
  <div class="col-xs-2 col-md-1 pull-left text-center">
    <a data-toggle="tooltip" data-placement="top" title="<?php echo $lang['switch_publish'] ?>">
    <input data-id="<?php echo $new_id; ?>" type="checkbox" name="published" class="js-switch publish_switch">
    </a>
  </div>
  <div class="col-xs-8 col-md-7 pull-left">
    <?php echo $name; ?> 
  </div>
  <div class="col-xs-4 col-md-2 pull-right text-right">
    <a href="index.php?slide=<?php echo $new_id; ?>" class="btn_in_item btn-info btn-xs"><i class="fa fa-pencil"></i> <?php echo $lang['button_edit']; ?> </a>
    <a data-id="<?php echo $new_id; ?>" class="btn_in_item btn-danger btn-xs del_instance pointer"><i class="fa fa-trash-o"></i> <?php echo $lang['button_delete']; ?> </a>
  </div>
  <div class="clearfix"></div>
</li>
<?php } ?>
