<?php 
  defined('ADMIN') or die();//prevent direct open
  $get_positions = $mysqli->query("
      SELECT evolve_ads.position_name, evolve_ads.id
      FROM evolve_ads
      
      ORDER BY id
      ");
      if(!$get_positions) print_r($mysqli->error);
      
   $get_ad = $mysqli->query("
      SELECT 
      evolve_ads_data.*, 
      evolve_ads.*
      
      FROM evolve_ads_data
      
      LEFT JOIN evolve_ads
      ON evolve_ads.id = evolve_ads_data.for_instance
      
      WHERE evolve_ads_data.id = '$instance_id'
      ");
      if(!$get_ad) print_r($mysqli->error);
      
  $row = $get_ad->fetch_array(MYSQLI_BOTH);
  $imgsrc = $domain.module_media_folder($module_id).$row['folder'].$row['img'];
  ?>
<!-- page content -->
<form id="edit_ad_form"  method="POST"> 
  <input type="hidden" name="page_title" value="<?php echo $row['name']; ?>" />
  <input type="hidden" name="instanceID" value="<?php echo $instance_id; ?>" />
  <input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_id; ?>" />
  <input type="hidden" id="ch_moduleID" name="ch_moduleID" value="2" />
  <div class="right_col" role="main">
    <div class="">
     <div class="input-group">
        <a href="index.php?ads" class="btn btn-default"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
        <button id="add_new_ad" type="button" class="btn btn-primary"><?php echo $lang['button_add_new']?></button>
      </div>
      <div class="page-title">
        <div class="title_left">
          <h3><?php echo $row['name']; ?></h3>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-8 col-sm-8 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2><?php echo $lang['ads_title'];?></h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="form-group">
                <label><?php echo $lang['ad_name'] ?></label>
                <input name="name" class="form-control" value="<?php echo $row['name']; ?>" type="text" autocomplete="off" />
              </div>
              <!--  Text Fields -->
              <div class="form-group">
                <label><?php echo $lang['ad_content'];?></label>
                <textarea name="content" class="resizable_textarea form-control" ><?php echo $row['content']; ?></textarea>
              </div>
              <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
            </div>
          </div>
        </div>
      
      <!-- / Text Fields -->                    
      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $lang['block_options']  ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="form-group">
              <input type="checkbox" data-id="<?php echo $instance_id; ?>" class="js-switch publish_switch" name="published" <?php echo checked($row['published']); ?> /> 
              <label> 
              <?php echo $lang['switch_published'] ?>
              </label>
            </div>
            <div class="form-group">
              <label class="control-label"><?php echo $lang['select_position']?></label>
              <div>
                <select name="position_id" class="form-control">
                  <?php while($the = $get_positions->fetch_assoc()){?>
                  <option value="<?php echo $the['id']?>" <?php echo ($the['id'] == $row['for_instance'] ? 'selected="selected"' : '')?>><?php echo $the['position_name']?></option>
                  <?php }?> 
                </select>
              </div>
            </div>
            <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
          </div>
        </div>
      </div>

    </div>
  </div>
  </div>
</form>
<!-- /page content -->