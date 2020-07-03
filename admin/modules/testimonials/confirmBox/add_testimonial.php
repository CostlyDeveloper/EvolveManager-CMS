<?php
define("ADMIN", true);
require_once("../../../../system/config.php");
?>
<form id="add_article_form" class="form-horizontal form-label-left" method="POST">
  <div class="form-group">
    <label class="control-label col-md-12 col-sm-12 col-xs-12"><?php echo $lang['person_name'] ; ?> </label>
    <div class="col-md-12 col-sm-12 col-xs-12">
      <input type="text" class="form-control" id="instance_name" name="instance_name" value="" />
    </div>
  </div>
</form>