<?php 
  defined('ADMIN') or die();//prevent direct open
  $get_dim_rel = $mysqli->query("
    SELECT evolve_dimensions_relations.*, evolve_dimensions_img.*
    FROM evolve_dimensions_relations
      
    LEFT JOIN evolve_dimensions_img
    ON evolve_dimensions_img.id = evolve_dimensions_relations.for_dimension
    WHERE evolve_dimensions_relations.for_module = '$module_id'
  ");
         
  $get_webcam_cat = $mysqli->query("
    SELECT 
     evolve_webcam_cat.folder,
     evolve_webcam_cat.image,
     evolve_webcam_cat_data.name
    FROM evolve_webcam_cat
      
    LEFT JOIN evolve_webcam_cat_data
    ON evolve_webcam_cat_data.for_instance_id = evolve_webcam_cat.id
      AND evolve_webcam_cat_data.lang =  '$default_language'
        
    WHERE evolve_webcam_cat.id = '$wcat'
  ");
  //if(!$get_webcam_cat) print_r($mysqli->error);
  
  $cat          = $get_webcam_cat->fetch_array(MYSQLI_ASSOC);
  $imgsrc       = $domain.module_media_folder($module_id).$cat['folder'].$cat['image'];
  $module_child = 1;

  ?>
<!-- page content -->
<form id="edit_wcat_form" action="modules/webcams/actions/edit_wcat.php" method="POST">
  <input type="hidden" name="instanceID" value="<?php echo $wcat; ?>" />
  <input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_id; ?>" />
  <input type="hidden" id="ch_moduleID" name="ch_moduleID" value="<?php echo $module_child ?>" />
  <div class="right_col" role="main">
    <div class="">
      <div class="input-group">
        <a href="index.php?webcam_cat" class="btn btn-default"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
      </div>
      <div class="page-title">
        <div class="title_left">
          <h3><?php echo $cat['name']; ?></h3>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-8 col-sm-8 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2><?php echo $lang['wcat_editing'];?></h2>
              <ul class="nav navbar-right panel_toolbox hidden">
                <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <!-- Tabs Editing -->
              <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                  <?php $slugs_arr = languages();
                    $i = 0;
                    foreach($slugs_arr as $slug){?>
                  <li role="presentation" class="<?php echo $i == 0 ? 'active' : '';?>">
                    <a href="#tab_content<?php echo $slug['slug'];?>" id="tab_con<?php echo $slug['slug'];?>" role="tab" data-toggle="tab" aria-expanded="true"><?php echo $slug['lang_name'];?></a>
                  </li>
                  <?php $i++; }?>
                </ul>
                <div id="myTabContent" class="tab-content">
                  <?php $slugs_arr = languages();
                    $i = 0;
                    foreach($slugs_arr as $slug){
                      $slug = $slug['slug'];
                      $get_wcat = $mysqli->query("
                        SELECT evolve_webcam_cat.*, evolve_webcam_cat_data.*, evolve_webcam_cat.id as wcat_id
                        FROM evolve_webcam_cat
                        
                        LEFT JOIN evolve_webcam_cat_data
                        ON evolve_webcam_cat_data.for_instance_id = evolve_webcam_cat.id
                          AND evolve_webcam_cat_data.lang =  '$slug'
                          
                        WHERE evolve_webcam_cat.id = '$wcat'
                        ");
                        //if(!$get_wcat) print_r($mysqli->error);
                    
                    $cat = $get_wcat->fetch_array(MYSQLI_ASSOC);  
                        ?>
                  <div role="tabpanel" class="tab-pane fade <?php echo $i == 0 ? 'active' : '';?> in" id="tab_content<?php echo $slug;?>" aria-labelledby="tab_con<?php echo $slug;?>" />
                    <!-- LANG Tabs Editing -->
                    <div class="form-group">
                      <label><?php echo $lang['wcat_name'];?></label>
                      <input name="name_<?php echo $slug;?>" class="form-control" value="<?php echo $cat['name']; ?>" type="text" autocomplete="off" />
                    </div>
                    <div class="form-group">
                      <label><?php echo $lang['wcat_seo_id'];?> <a data-toggle="tooltip" data-placement="top" title="<?php echo $lang['wcat_seo_id_q']; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a></label>
                      <input name="seoid_<?php echo $slug;?>" class="form-control <?php echo (empty($cat['seo_id'])) ? 'parsley-error' : '' ; ?> seoid" value="<?php echo $cat['seo_id']; ?>" type="text" autocomplete="off" />
                    </div>
                    <div class="form-group">
                      <label><?php echo $lang['wcat_title'];?></label>
                      <input name="title_<?php echo $slug;?>" class="form-control" value="<?php echo $cat['title']; ?>" type="text" autocomplete="off" />
                    </div>
                    <div class="form-group">
                      <label><?php echo $lang['wcat_tagline'];?></label>
                      <input name="tagline_<?php echo $slug;?>" class="form-control" value="<?php echo $cat['tagline']; ?>" type="text" autocomplete="off" />
                    </div>
                    <div class="form-group">
                      <label><?php echo $lang['wcat_description'];?></label>
                      <textarea name="description_<?php echo $slug;?>" class="tinymce form-control" ><?php echo $cat['description']; ?></textarea>
                    </div>
                    <div class="form-group">
                      <label><?php echo $lang['wcat_tags'];?> </label>
                      <input name="keywords_<?php echo $slug;?>" type="text" class="tags form-control tags_keywords" value="<?php echo $cat['keywords']; ?>" autocomplete="off" />
                      <div style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                    </div>
                    <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
                    <!-- / LANG Tabs Editing -->
                  </div>
                  <?php $i++; }?>
                </div>
              </div>
              <!-- / Tabs Editing -->
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
          <!-- cover picture -->
          <div class="x_panel upload_block" id="cover_image">
            <div class="x_title">
              <h2><?php echo $lang['wcat_image']; ?></h2>
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
              <div id="delete_cover" class="cover_exist btn-group <?php echo (empty($cat['image'])) ? 'hidden' : '';?>">
                <button class="delete_cover btn btn-danger dropdown-toggle btn-sm" type="button"><i class="fa fa-trash-o m-right-xs"></i> <?php echo $lang['delete_img_button']?> 
                </button>
              </div>
              <div class="x_content">
                <div class="cover_preview">
                  <?php if($cat['image']){?>
                  <img class="cover_img img-responsive" src="<?php echo $imgsrc; ?>?<?php echo time('timestamp'); ?>" alt="<?php echo $imgsrc; ?>" />
                  <?php }?> 
                </div>
              </div>
              <div class="checkbox cover_exist <?php echo (empty($cat['image'])) ? 'hidden' : '';?>">
              </div>
            </div>
          </div>
          <!-- /cover picture -->
          <!-- Add videos -->
          <?php echo get_add_video_block($module_id, $module_child, $wcat) ?>
          <!-- Add videos -->
        </div>
      </div>
    </div>
  </div>
</form>
<!-- /page content -->