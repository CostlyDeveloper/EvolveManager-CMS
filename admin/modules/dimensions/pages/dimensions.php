<?php 
  defined('ADMIN') or die();//prevent direct open
      
    $get_modules = $mysqli->query("
      SELECT evolve_modules.*, evolve_dimensions_relations.*, evolve_modules.id as module_id
      FROM evolve_modules 
      
      LEFT JOIN evolve_dimensions_relations
      ON evolve_dimensions_relations.for_dimension = '$dim_id'
        and evolve_dimensions_relations.for_module = evolve_modules.id 
      WHERE evolve_modules.dimensions = 1
      ORDER BY module_id ASC
      ");
     
    $get_dimensions = $mysqli->query("
      SELECT evolve_dimensions_img.*
      FROM evolve_dimensions_img 
      WHERE evolve_dimensions_img.id = '$dim_id'     
      ");
    $dim = $get_dimensions->fetch_array(MYSQLI_ASSOC);
   
   $get_big = $mysqli->query("
      SELECT evolve_dimensions_data.*
      FROM evolve_dimensions_data 
      WHERE evolve_dimensions_data.for_dimension = '$dim_id' 
        and evolve_dimensions_data.type = 1
      ");
   $big = $get_big->fetch_array(MYSQLI_ASSOC);
  
   $get_small = $mysqli->query("
      SELECT evolve_dimensions_data.*
      FROM evolve_dimensions_data 
      WHERE evolve_dimensions_data.for_dimension = '$dim_id' 
        and evolve_dimensions_data.type = 2
      ");
   $small = $get_small->fetch_array(MYSQLI_ASSOC);
   
   $options = [10,20,30,40,50,60,70,80,90,100];
   $positions = [0=>$lang['dim_wmark_center'],1=>$lang['dim_wmark_tl'],2=>$lang['dim_wmark_tr'],3=>$lang['dim_wmark_br'],4=>$lang['dim_wmark_bl']]; // watermark
   $ratio = [1=>$lang['wmark_full_width'],2=>'2 '.$lang['wmark_times_smaller'],3=>'3 '.$lang['wmark_times_smaller'],4=>'4 '.$lang['wmark_times_smaller'],5=>'5 '.$lang['wmark_times_smaller'],6=>'6 '.$lang['wmark_times_smaller'],7=>'7 '.$lang['wmark_times_smaller'],8=>'8 '.$lang['wmark_times_smaller'],9=>'9 '.$lang['wmark_times_smaller'],10=>'10 '.$lang['wmark_times_smaller']]; // watermark
  ?>
<!-- page content -->
<form id="edit_dimensions_form" action="settings/dimensions/actions/edit_dimension.php" method="POST">
  <input type="hidden" name="page_title" value="<?php echo $lang['dimensions_editing'].' - '.$dim['name'] ?>" />
  <input type="hidden" name="moduleID" id="moduleID" value="<?php echo $module_id; ?>" />
  <input type="hidden" name="dimensionID" value="<?php echo $dim_id; ?>" />
  <div class="right_col" role="main">
    <div class="">
    <div class="input-group">
        <a href="index.php?dimensions" class="btn btn-default"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
        <button id="create_dimension" type="button" class="btn btn-primary"><?php echo $lang['button_add_new']?></button>
      </div>
      <div class="page-title">
        <div class="title_left">
          <h3><?php echo $dim['name']; ?></h3>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-8 col-sm-8 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2><?php echo $lang['dimensions_editing'];?></h2>
              <ul class="nav navbar-right panel_toolbox hidden">
                <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label><?php echo $lang['img_diension_title'];?></label>
                <?php if($dim_id == 1){?>
                <input name="dimName" class="form-control" readonly="readonly" value="<?php echo $lang['dim_general_upl'] ?>" type="text" autocomplete="off" />
                <?php }
                  elseif($dim_id == 2){?>
                <input name="dimName" class="form-control" readonly="readonly" value="<?php echo $lang['dim_video_upl'] ?>" type="text" autocomplete="off" />
                <?php }
                  else{ ?>
                <input name="dimName" class="form-control" value="<?php echo $dim['name'] ?>" type="text" autocomplete="off" />
                <?php } ?>
              </div>
              <!-- Start to do list -->
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_title">
                  <h2><?php echo $lang['img_dim_enb_mod']?></h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="">
                    <ul class="to_do">
                      <?php if($dim_id == 1){?>
                      <li>
                        <p>
                          <input type="checkbox" disabled="disabled" checked="checked" class="flat" /> <?php echo $lang['dim_general_upl']; ?> 
                        </p>
                        <input name="module_1" type="hidden" value="1" />
                      </li>
                      <?php }
                        elseif($dim_id == 2){?>
                      <li>
                        <p>
                          <input type="checkbox" disabled="disabled" checked="checked" class="flat" /> <?php echo $lang['dim_video_upl']; ?> 
                        </p>
                        <input name="module_2" type="hidden" value="1" />
                      </li>
                      <?php }
                        else{
                          while($mod = $get_modules->fetch_assoc()){?>   
                      <li>
                        <p>
                          <input name="module_<?php echo $mod['module_id']; ?>" type="checkbox" <?php echo checked($mod['for_dimension']); ?> class="flat"/> <?php echo $mod['name']; ?> 
                        </p>
                      </li>
                      <?php } } ?>
                    </ul>
                  </div>
                </div>
              </div>
              <!-- End to do list -->
              <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
            </div>
          </div>
        </div>
        <!-- Big image -->
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2><?php echo $lang['img_dim_set_big'] ; ?></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                <label><?php echo $lang['img_dim_width'];?></label>
                <input name="widthBig" value="<?php echo $big['width'];?>" type="text" class="form-control">
              </div>
              <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                <label><?php echo $lang['img_dim_height'];?></label>
                <input name="heightBig" value="<?php echo $big['height'];?>" type="text" class="form-control">
              </div>
              <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <label><?php echo $lang['img_dim_quality'];?></label>
                <select name="qualityBig" class="form-control">
                  <?php foreach($options as $val){?>
                  <option <?php echo ($big['quality'] == $val) ? 'selected' : '';?> value="<?php echo $val?>"><?php echo $val?>%</option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label>
                <input type="checkbox" name="cropBig" <?php echo checked($big['crop']); ?> class="flat"/> <?php echo $lang['img_dim_crop']; ?>
                </label>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label>
                <input type="checkbox" name="grayBig" <?php echo checked($big['gray']); ?> class="flat"/> <?php echo $lang['img_dim_gray']; ?>
                </label>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label>
                <input type="checkbox" id="watermark_enableBig" name="watermark_enableBig" <?php echo checked($big['watermark_enable']); ?> class="flat"/> <?php echo $lang['dim_wmark_enable']; ?>
                </label>
              </div>
              <div id="watermark_1" data-type="1" class="col-md-12 col-sm-12 col-xs-12 watermark_block" <?php echo ($big['watermark_enable']) ? '' : 'style="display:none;"';?>>
                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <label><?php echo $lang['dim_wmark_position'];?></label>
                  <select name="wmark_positionBig" class="form-control">
                    <?php foreach($positions as $key => $val){?>
                    <option <?php echo ($big['watermark_position'] == $key) ? 'selected' : '';?> value="<?php echo $key?>"><?php echo $val?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <label><?php echo $lang['img_dim_opacity'];?></label>
                  <select name="wmark_opacityBig" class="form-control">
                    <?php foreach($options as $val){?>
                    <option <?php echo ($big['watermark_opacity'] == $val) ? 'selected' : '';?> value="<?php echo $val?>"><?php echo $val?>%</option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                  <label><?php echo $lang['dim_wmark_ratio'];?></label>
                  <p class="font-gray-dark">
                    <?php echo $lang['dim_wmark_ratio_d']; ?>
                  </p>
                  <select name="wmark_ratioBig" class="form-control">
                    <?php foreach($ratio as $key => $val){?>
                    <option <?php echo ($big['watermark_ratio'] == $key) ? 'selected' : '';?> value="<?php echo $key?>"><?php echo $val?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                  <label class="btn btn-default"> <?php echo $lang['img_browse']; ?>
                  <input type="file" name="fileInput" class="hidden" id="fileInput" />
                  </label> 
                  <div class="text-center success_upload">
                    <?php if($big['watermark']){?>
                    <img src="<?php echo $domain.$big['watermark_folder'].$big['watermark']; ?>" alt="image"/>
                    <?php }?>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
            </div>
          </div>
        </div>
        <!-- / Big image -->
        <!-- Small image -->
        <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
          <div class="x_panel">
            <div class="x_title">
              <h2><?php echo $lang['img_dim_set_small']; ?></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <input type="checkbox" name="enableSmall" class="js-switch" <?php echo($get_small->num_rows > 0) ? 'checked':'';?> /> 
                <label> 
                <?php echo $lang['img_dim_enb_small']; ?>
                </label>
              </div>
              <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                <label><?php echo $lang['img_dim_width'];?></label>
                <input name="widthSmall" value="<?php echo $small['width'];?>" type="text" class="form-control">
              </div>
              <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                <label><?php echo $lang['img_dim_height'];?></label>
                <input name="heightSmall" value="<?php echo $small['height'];?>" type="text" class="form-control">
              </div>
              <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <label><?php echo $lang['img_dim_quality'];?></label>
                <select name="qualitySmall" class="form-control">
                  <?php foreach($options as $val){?>
                  <option <?php echo ($small['quality'] == $val) ? 'selected' : '';?> value="<?php echo $val?>"><?php echo $val?>%</option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label>
                <input type="checkbox" name="cropSmall" <?php echo checked($small['crop']); ?> class="flat"/> <?php echo $lang['img_dim_crop']; ?>
                </label>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label>
                <input type="checkbox" name="graySmall" <?php echo checked($small['gray']); ?> class="flat"/> <?php echo $lang['img_dim_gray']; ?>
                </label>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label>
                <input type="checkbox" id="watermark_enableSmall" name="watermark_enableSmall" <?php echo checked($small['watermark_enable']); ?> class="flat"/> <?php echo $lang['dim_wmark_enable']; ?>
                </label>
              </div>
              <div id="watermark_2" data-type="2" class="col-md-12 col-sm-12 col-xs-12 watermark_block" <?php echo ($small['watermark_enable']) ? '' : 'style="display:none;"';?>>
                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <label><?php echo $lang['dim_wmark_position'];?></label>
                  <select name="wmark_positionSmall" class="form-control">
                    <?php foreach($positions as $key => $val){?>
                    <option <?php echo ($small['watermark_position'] == $key) ? 'selected' : '';?> value="<?php echo $key?>"><?php echo $val?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <label><?php echo $lang['img_dim_opacity'];?></label>
                  <select name="wmark_opacitySmall" class="form-control">
                    <?php foreach($options as $val){?>
                    <option <?php echo ($small['watermark_opacity'] == $val) ? 'selected' : '';?> value="<?php echo $val?>"><?php echo $val?>%</option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                  <label><?php echo $lang['dim_wmark_ratio'];?></label>
                  <p class="font-gray-dark">
                    <?php echo $lang['dim_wmark_ratio_d']; ?>
                  </p>
                  <select name="wmark_ratioSmall" class="form-control">
                    <?php foreach($ratio as $key => $val){?>
                    <option <?php echo ($small['watermark_ratio'] == $key) ? 'selected' : '';?> value="<?php echo $key?>"><?php echo $val?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                  <label class="btn btn-default"> <?php echo $lang['img_browse']; ?>
                  <input type="file" name="fileInput2" class="hidden" id="fileInput2" />
                  </label> 
                  <div class="text-center success_upload">
                    <?php if($small['watermark']){?>
                    <img src="<?php echo $domain.$small['watermark_folder'].$small['watermark']; ?>" alt="image"/>
                    <?php }?>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
            </div>
          </div>
        </div>
        <!-- / Small image -->
      </div>
    </div>
  </div>
</form>
<!-- /page content -->