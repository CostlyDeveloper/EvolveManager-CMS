<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");

?>

<form id="confirm_box_form" class="form-horizontal form-label-left" method="POST">
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $lang['grp_name'] ?> </label>
      <div class="col-md-9 col-sm-9 col-xs-12">
        <input type="text" class="lang form-control" name="group_name" value="" required="" autocomplete="false" />
      </div>
    </div>
  </form>
                      
                      
                      
        
