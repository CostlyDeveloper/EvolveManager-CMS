<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");

$instance_id          = $_POST["instanceID"];
$count                = $_POST["count"];
?>
<li data-id="<?php echo $count?>" class="added_color">
  <div class="clearfix"></div>
  <div class="row">
    <div class="text-left col-md-1 col-sm-1 col-xs-2 form-group dragable_arrows"><i class="fa fa-arrows"></i></div>
    <div class="col-md-5 col-sm-5 col-xs-6 row form-group">
      <input name="multiID[]" class="form-control" placeholder="<?php echo $lang['webcam_stream_id']?>" type="text" autocomplete="off" />
    </div>
    <div class="col-md-5 col-sm-5 col-xs-6 form-group">
      <input name="multiName[]" class="form-control" placeholder="<?php echo $lang['webcam_stream_name']?>" type="text" autocomplete="off" />
    </div>
    <div class="col-md-1 col-sm-1 col-xs-2">
      <a href="index.php?webcam" class="remove_field btn btn-default">
        <i class="fa fa-times" aria-hidden="true"></i>
      </a>
    </div>
  </div>
  <div class="clearfix"></div>
</li>
