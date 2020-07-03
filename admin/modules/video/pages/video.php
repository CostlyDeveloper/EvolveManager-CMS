<?php 
  defined('ADMIN') or die();//prevent direct open
  $get_dim_rel = $mysqli->query("
    SELECT evolve_dimensions_relations.*, evolve_dimensions_img.*
    FROM evolve_dimensions_relations
      
    LEFT JOIN evolve_dimensions_img
    ON evolve_dimensions_img.id = evolve_dimensions_relations.for_dimension
    WHERE evolve_dimensions_relations.for_module = '$module_id'
  ");
         
  $get_video = $mysqli->query("
    SELECT evolve_video.*, evolve_video_data.*
    FROM evolve_video
          
    LEFT JOIN evolve_video_data
    ON evolve_video_data.for_video = evolve_video.id
      AND evolve_video_data.for_lang =  '$default_language'
        
    WHERE evolve_video.id = '$video_id'
  ");
  //if(!$get_video) print_r($mysqli->error);
  
  $vid             = $get_video->fetch_array(MYSQLI_ASSOC);
  $imgsrc          = $domain.module_media_folder($module_id).$vid['folder'].$vid['image'];
  $publishing_date = strtotime($vid['date']);
  $publishing_date = date("d.m.Y. H:i", $publishing_date);
  $type            = $vid['type'];
  $vid_url         = find_video_id(NULL, $vid['pub_video_id'], $type, 2);
  ?>
<!-- page content -->
<form id="edit_video_form" action="modules/video/actions/edit_video.php" method="POST">
  <input type="hidden" name="page_title" value="<?php echo $lang['manage_video_title'] . ' - '. $vid['title']; ?>" />
  <input type="hidden" name="instanceID" value="<?php echo $video_id; ?>" />
  <input type="hidden" name="typeID" value="<?php echo $type; ?>" />
  <input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_id; ?>" />
  <input type="hidden" id="ch_moduleID" name="ch_moduleID" value="1" />
  <div class="right_col" role="main">
    <div class="">
    <div class="input-group">
      <a href="index.php?video" class="btn btn-default"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
      <button id="add_new_video" type="button" class="btn btn-primary"><?php echo $lang['button_add_new']?></button>
    </div>
      <div class="page-title">
        <div class="title_left">
          <h3><?php echo $vid['original_title']; ?></h3>
        </div>
        <div class="title_right">
          <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-8 col-sm-8 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2><?php echo $lang['video_editing'];?></h2>
              <ul class="nav navbar-right panel_toolbox hidden">
                <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="form-group">
                <label><?php echo $lang['vid_e_url'];?></label>
                <input name="videoURL" class="form-control" value="<?php echo $vid_url; ?>" type="text" autocomplete="off" />
              </div>
              <div class="form-group">
                <label><?php echo $lang['original_title'] ;?></label>
                <input name="original_title" class="form-control" value="<?php echo $vid['original_title']; ?>" type="text" autocomplete="off" />
              </div>
              <?php $slugs_arr = languages();
                foreach($slugs_arr as $slug){
                $slug_key = $slug['slug']; 
                
                $get_video = $mysqli->query("
                      SELECT evolve_video_data.title
                      FROM evolve_video
                      
                      LEFT JOIN evolve_video_data
                      ON evolve_video_data.for_video = evolve_video.id
                        AND evolve_video_data.for_lang = '$slug_key'
                        
                      WHERE evolve_video.id = '$video_id'
                      ");
                      if(!$get_video) print_r($mysqli->error);
                  
                  $vide = $get_video->fetch_array(MYSQLI_ASSOC);
                ?>
              <div class="form-group">
                <label><?php echo $slug['lang_name'];?> / <?php echo $lang['vid_e_title'];?></label>
                <input name="videoTitle_<?php echo $slug_key;?>" class="form-control" value="<?php echo $vide['title']; ?>" type="text" autocomplete="off" />
              </div>
              <?php }?>
              <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2><?php echo $lang['vid_e_options'] ; ?></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="">
                <input type="checkbox" data-id="<?php echo $video_id; ?>" class="js-switch publish_switch" name="published" <?php echo checked($vid['published']); ?> /> 
                <label> 
                <?php echo $lang['vid_e_publish']; ?>
                </label>
              </div>
              <div class="checkbox">
                <label>
                <input type="checkbox" id="featured" name="featured" <?php echo checked($vid['featured']); ?> class="flat" /> <?php echo $lang['vid_e_featured']; ?>
                </label>
              </div>
              <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
          <!-- cover picture -->
          <div class="x_panel upload_block" id="cover_image">
            <div class="x_title">
              <h2><?php echo $lang['video_thumb']; ?></h2>
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
                  <?php while($dim = $get_dim_rel->fetch_assoc()){?>
                  <li><a id="dim_<?php echo $dim['for_dimension'];?>" class="select_cover" ><?php echo $dim['name'];?></a>
                  </li>
                  <?php }?> 
                </ul>
              </div>
              <?php }else{
                echo $lang['please_make_dim'];?>
              <a href="index.php?dimensions"><?php echo $lang['set_dimensions_dd'];?></a>
              <?php }?>
              <div id="delete_cover" class="cover_exist btn-group <?php echo (empty($vid['image'])) ? 'hidden' : '';?>">
                <button class="delete_cover btn btn-danger dropdown-toggle btn-sm" type="button"><i class="fa fa-trash-o m-right-xs"></i> <?php echo $lang['delete_img_button']?> 
                </button>
              </div>
              <div class="x_content">
                <div class="cover_preview">
                  <?php 
                    if($vid['image']){?>
                  <img class="cover_img img-responsive" src="<?php echo $imgsrc; ?>?<?php echo time('timestamp'); ?>" alt="<?php echo $imgsrc; ?>" />
                  <?php }?> 
                </div>
              </div>
              <div class="checkbox cover_exist <?php echo (empty($vid['image'])) ? 'hidden' : '';?>">
              </div>
              <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
            </div>
          </div>
        </div>
        <!-- /cover picture -->
      </div>
    </div>
  </div>
</form>
<!-- /page content -->