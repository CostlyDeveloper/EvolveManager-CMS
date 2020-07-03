<?php
  define("ADMIN", true);
  $to_root = '../../../..';
  require_once($to_root."/system/config.php");
  
  ?>
<form id="confirm_box_form" class="form-horizontal form-label-left" method="POST">
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $lang['usr_email'] ?> </label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="text" class="lang form-control" id="newEmail" name="email" value="" required="" autocomplete="false" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $lang['usr_pass'] ?> </label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="password" class="lang form-control" id="pass" name="pass" value="" required="" />
    </div>
  </div>
</form>