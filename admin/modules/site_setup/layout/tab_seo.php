<div class="row">
  <div class="col-md-8 col-sm-8 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2><?php echo $lang['block_general'] ?></h2>
        <div class="clearfix"></div>
      </div>
      <div class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <strong><?php echo $lang['meta_alert_str']?> </strong> <?php echo $lang['meta_alert']?>
      </div>
      <div class="x_title">
        <h2><?php echo $lang['block_scripts'] ?></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="">
          <div class="form-group">
            <label><?php echo $lang['header_script'];?></label>
            <textarea name="header_script" class="resizable_textarea form-control" ><?php echo $row['header_script']; ?></textarea>
          </div>
          <div class="form-group">
            <label><?php echo $lang['footer_script'];?></label>
            <textarea name="footer_script" class="resizable_textarea form-control" ><?php echo $row['footer_script']; ?></textarea>
          </div>
        </div>
      </div>
      <div class="x_title">
        <h2><?php echo $lang['block_verifivation'] ?></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="">
          <div class="form-group">
            <label><?php echo $lang['google_verif'];?></label>
            <input name="google_verif" class="resizable_textarea form-control" value="<?php echo $row['google_verif']; ?>" />
          </div>
          <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-4 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2><?php echo $lang['block_about']  ?></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="">
          <div class="form-group">
            <label><?php echo $lang['company_name'];?></label>
            <input name="company_name" class="form-control" value="<?php echo $row['company_name']; ?>" type="text" autocomplete="off" />
          </div>
          <div class="form-group">
            <label><?php echo $lang['company_email'];?></label>
            <input name="company_email" class="form-control" value="<?php echo $row['company_email']; ?>" type="text" autocomplete="off" />
          </div>
          <div class="form-group">
            <label><?php echo $lang['company_tel'];?></label>
            <input name="company_tel" class="form-control" value="<?php echo $row['company_tel']; ?>" type="text" autocomplete="off" />
          </div>
          <div class="form-group">
            <label><?php echo $lang['skype'];?></label>
            <input name="skype" class="form-control" value="<?php echo $row['skype']; ?>" type="text" autocomplete="off" />
          </div>
          <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
        </div>
      </div>
    </div>
    <!-- cover picture -->
    <div class="x_panel upload_block" id="og_image">
      <div class="x_title">
        <h2><?php echo $lang['og_image']; ?></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <?php if ($get_dim_rel->num_rows > 0){?>
        <div class="btn-group">
          <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-sm" type="button" aria-expanded="false"><i class="fa fa-picture-o m-right-xs"></i> <?php echo $lang['select_img']?> <span class="caret"></span>
          </button> 
          <ul role="menu" class="dropdown-menu">
            <?php mysqli_data_seek($get_dim_rel,0);
              while($dim = $get_dim_rel->fetch_assoc()){?>
            <li><a id="dim_<?php echo $dim['for_dimension'];?>" class="select_cover" ><?php echo $dim['name'];?></a>
            </li>
            <?php }?> 
          </ul>
        </div>
        <?php }else{
          echo $lang['please_make_dim'];?>
        <a href="index.php?dimensions"><?php echo $lang['set_dimensions_dd'];?></a>
        <?php }?>
        <div id="delete_cover" class="cover_exist btn-group <?php echo (empty($row['img'])) ? 'hidden' : '';?>">
          <button class="delete_cover btn btn-danger dropdown-toggle btn-sm" type="button"><i class="fa fa-trash-o m-right-xs"></i> <?php echo $lang['delete_img_button']?> 
          </button>
        </div>
        <div class="x_content">
          <div class="cover_preview">
            <?php 
              if($img['og_img']){
              $imgsrc = $domain.module_media_folder($module_id).'/'.$img['og_img'];
              ?>
            <img class="cover_img img-responsive" src="<?php echo $imgsrc; ?>?<?php echo time('timestamp'); ?>" alt="<?php echo $imgsrc; ?>" />
            <?php }?> 
          </div>
        </div>
        <div class="checkbox cover_exist <?php echo (empty($img['og_img'])) ? 'hidden' : '';?>">
        </div>
        <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
      </div>
    </div>
    <!-- /cover picture --> 
  </div>
  <div class="clearfix"></div>
</div>