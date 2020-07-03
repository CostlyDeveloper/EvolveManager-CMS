<?php
  defined('ADMIN') or die();//prevent direct open
  $get_dim_rel = $mysqli->query("
    SELECT evolve_dimensions_relations.*, evolve_dimensions_img.*
    FROM evolve_dimensions_relations
      
    LEFT JOIN evolve_dimensions_img
    ON evolve_dimensions_img.id = evolve_dimensions_relations.for_dimension
    WHERE evolve_dimensions_relations.for_module = '$module_id'
  ");      
  $get_category = $mysqli->query("
    SELECT evolve_cd_cody_list.*, evolve_cd_cody_data.*, evolve_cd_cody_list.id as wcat_id
    FROM evolve_cd_cody_list
      
    LEFT JOIN evolve_cd_cody_data
    ON evolve_cd_cody_data.for_instance = evolve_cd_cody_list.id
      AND evolve_cd_cody_data.lang =  '$default_language'
    WHERE evolve_cd_cody_list.id = '$instance_id'
  ");
  if($developing) if(!$get_category) print_r($mysqli->error);
  $get_layout = $mysqli->query("
    SELECT evolve_cd_cody_type.id, evolve_cd_cody_type.name
    FROM evolve_cd_cody_type
    ORDER BY id
  ");
  if($developing) if(!$get_layout) print_r($mysqli->error);

$item_name = 'cd_cody_licence_edit';
$category_name = 'estate';

  $cat_item          = $get_category->fetch_array(MYSQLI_ASSOC);
  $imgsrc       = $domain.module_media_folder($module_id).$cat_item['folder'].$cat_item['img'];
  $module_child = 4;
  //if($developing) prb($cat_item);
  ?>
<!-- page content -->
<form id="edit_<?php echo $category_name ?>"  method="POST">
  <input type="hidden" name="page_title" value="<?php echo $cat_item['title']; ?>" />
  <input type="hidden" name="instanceID" value="<?php echo $instance_id; ?>" />
  <input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_id; ?>" />
  <input type="hidden" id="ch_moduleID" name="ch_moduleID" value="<?php echo $module_child ?>" />
  <div class="right_col" role="main">

      <div class="input-group">
        <a href="index.php?<?php echo $category_name ?>" class="btn btn-default"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
      </div>
      <div class="page-title">
        <div class="title_left">
          <h3><?php echo $cat_item['title']; ?></h3>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div id="ajax"></div>
            <div class="x_title">
              <h2><?php echo $lang['category_editing'];?></h2>
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
                        SELECT evolve_cd_cody_data.seo_id, evolve_cd_cody_data.description, evolve_cd_cody_data.title, evolve_cd_cody_list.id as wcat_id
                        FROM evolve_cd_cody_list
                           
                        LEFT JOIN evolve_cd_cody_data
                        ON evolve_cd_cody_data.for_instance = evolve_cd_cody_list.id
                          AND evolve_cd_cody_data.lang =  '$slug'
                          
                        WHERE evolve_cd_cody_list.id = '$instance_id'
                      ");
                      if($developing) if(!$get_wcat) print_r($mysqli->error);
                      $cat_items = $get_wcat->fetch_array(MYSQLI_ASSOC);
                    ?>
                  <div role="tabpanel" class="tab-pane fade <?php echo $i == 0 ? 'active' : '';?> in" id="tab_content<?php echo $slug;?>" aria-labelledby="tab_con<?php echo $slug;?>" />
                    <!-- LANG Tabs Editing -->
                    <div class="form-group">
                      <label><?php echo $lang['category_title'];?></label>
                      <input name="title_<?php echo $slug;?>" class="form-control" value="<?php echo $cat_items['title']; ?>" type="text" autocomplete="off" />
                    </div>
                    <div class="form-group">
                      <label><?php echo $lang['seo_id'];?> <a data-toggle="tooltip" data-placement="top" title="<?php echo $lang[$category_name . '_seo_tt']; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a></label>
                      <input name="seoId_<?php echo $slug;?>" class="form-control <?php echo (empty($cat_items['seo_id'])) ? 'parsley-error' : '' ; ?> seoid" value="<?php echo $cat_items['seo_id']; ?>" type="text" autocomplete="off" />
                    </div>
                    <div class="form-group">
                      <label><?php echo $lang['description'];?></label>
                      <textarea name="description_<?php echo $slug;?>" class="tinymce form-control" ><?php echo $cat_items['description']; ?></textarea>
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

      </div>
    </div>

</form>
<!-- /page content -->
