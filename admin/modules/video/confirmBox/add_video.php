<?php
define("ADMIN", true);
require_once("../../../../system/config.php");

$get_video_types = $mysqli->query("
    SELECT evolve_video_types.*
    FROM evolve_video_types     
    ");
?>
<form id="add_article_form" class="form-horizontal form-label-left" method="POST">
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $lang['add_video_url'] ; ?> </label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="text" class="form-control" id="videoURL" name="videoURL" value="" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $lang['select_publisher'];?></label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <select class="form-control" id="pub_type_id">
        <?php while($typ = $get_video_types->fetch_assoc()){?>
          <option value="<?php echo $typ['id'];?>"><?php echo $typ['publisher'];?></option>
        <?php } ?>
      </select>
    </div>
  </div>
</form>
                      
                      
                      
        
