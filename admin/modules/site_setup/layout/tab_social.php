<div class="row">
  <div class="col-md-8 col-sm-8 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2><?php echo $lang['block_general'] ?></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="">
          <div class="form-group">
            <label><?php echo $lang['facebook_block'];?></label>
            <input name="facebook_block" class="resizable_textarea form-control" value="<?php echo $row['facebook_block']; ?>" />
          </div>
        </div>
        <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
      </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-4 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2><?php echo $lang['block_social']  ?></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="">
          <div class="form-group">
            <label><?php echo $lang['facebook'];?></label>
            <input name="facebook" class="form-control" value="<?php echo $row['facebook']; ?>" type="text" autocomplete="off" />
          </div>
          <div class="form-group">
            <label><?php echo $lang['twitter'];?></label>
            <input name="twitter" class="form-control" value="<?php echo $row['twitter']; ?>" type="text" autocomplete="off" />
          </div>
          <div class="form-group">
            <label><?php echo $lang['youtube'];?></label>
            <input name="youtube" class="form-control" value="<?php echo $row['youtube']; ?>" type="text" autocomplete="off" />
          </div>
          <div class="form-group">
            <label><?php echo $lang['instagram'];?></label>
            <input name="instagram" class="form-control" value="<?php echo $row['instagram']; ?>" type="text" autocomplete="off" />
          </div>
          <div class="form-group">
            <label><?php echo $lang['googleplus'];?></label>
            <input name="googleplus" class="form-control" value="<?php echo $row['googleplus']; ?>" type="text" autocomplete="off" />
          </div>
          <div class="form-group">
            <label><?php echo $lang['dribbble'];?></label>
            <input name="dribbble" class="form-control" value="<?php echo $row['dribbble']; ?>" type="text" autocomplete="off" />
          </div>
          <div class="form-group">
            <label><?php echo $lang['linkedin'];?></label>
            <input name="linkedin" class="form-control" value="<?php echo $row['linkedin']; ?>" type="text" autocomplete="off" />
          </div>
          <div class="form-group">
            <label><?php echo $lang['github'];?></label>
            <input name="github" class="form-control" value="<?php echo $row['github']; ?>" type="text" autocomplete="off" />
          </div>
        </div>
        <div class="form-group">
          <label><?php echo $lang['dropbox'];?></label>
          <input name="dropbox" class="form-control" value="<?php echo $row['dropbox']; ?>" type="text" autocomplete="off" />
        </div>
        <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
</div>