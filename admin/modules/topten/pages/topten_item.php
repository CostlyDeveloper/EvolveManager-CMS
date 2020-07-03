<?php
defined('ADMIN') or die();//prevent direct open

$get_dim_rel = $mysqli->query("
      SELECT evolve_dimensions_relations.for_dimension, evolve_dimensions_img.name
      FROM evolve_dimensions_relations
      
      LEFT JOIN evolve_dimensions_img
      ON evolve_dimensions_img.id = evolve_dimensions_relations.for_dimension
      WHERE evolve_dimensions_relations.for_module = '$module_id'
  ");

$get_instance = $mysqli->query("
    SELECT evolve_topten_items.*, evolve_topten_items_data.*, evolve_product_category_data.*, evolve_topten_items_data.title as product_title, evolve_product_category_data.title as category_title
    FROM evolve_topten_items
      
    LEFT JOIN evolve_product_category_data
    ON evolve_product_category_data.for_instance = evolve_topten_items.category
      AND evolve_product_category_data.lang =  '$default_language'
      
    LEFT JOIN evolve_topten_items_data
    ON evolve_topten_items_data.for_instance = evolve_topten_items.id
      AND evolve_topten_items_data.lang =  '$default_language'  
    WHERE evolve_topten_items.id = '$instance_id'
  ");
if ($developing) if (!$get_instance) print_r($mysqli->error);


$get_module = $mysqli->query("
    SELECT evolve_modules.name
    FROM evolve_modules       
    WHERE evolve_modules.id = '$module_id'
  ");
$item_name = 'product';
$category_name = 'product';

$mod = $get_module->fetch_array(MYSQLI_ASSOC);
$item = $get_instance->fetch_array(MYSQLI_ASSOC);
$category = $item['category'];
$imgsrc = $domain . module_media_folder($module_id) . $item['folder'] . $item['img'];
$publishing_date = strtotime($item['date']);
$publishing_date = date("d.m.Y. H:i", $publishing_date);
$last_edit_date = strtotime($item['last_edit_time']);
$last_edit_date = date("d.m.Y. H:i", $last_edit_date);
$module_child = 2;

//if($developing) prb($item).prb($mod);
?>
<!-- page content -->
<form id="edit_<?php echo $item_name ?>_form" method="POST">
    <input type="hidden" name="page_title" value="<?php echo $mod['name'] . ' - ' . $item['title']; ?>" />
    <input type="hidden" name="itemID" value="<?php echo $instance_id; ?>" />
    <input type="hidden" name="instanceID" value="<?php echo $instance_id; ?>" />
    <input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_id; ?>" />
    <input type="hidden" id="ch_moduleID" name="ch_moduleID" value="<?php echo $module_child ?>" />
    <div class="right_col" role="main">
        <div class="">
            <a href="index.php?<?php echo $item_name ?>_list=<?php echo $category ?>" class="btn btn-default"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
            <button id="add_new_<?php echo $item_name ?>" type="button" class="btn btn-primary"><?php echo $lang['button_add_new'] ?></button>
            <div class="page-title">
                <div class="title_left">
                    <h3>
                        <small><?php echo $item['category_title']; ?> /</small> <?php echo $item['title']; ?></h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?php echo $lang['product_editing']; ?></h2>
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
			                        foreach ($slugs_arr as $slug) {
				                        ?>
                                        <li role="presentation" class="<?php echo $i == 0 ? 'active' : ''; ?>">
                                            <a href="#tab_content<?php echo $slug['slug']; ?>" id="tab_con<?php echo $slug['slug']; ?>" role="tab" data-toggle="tab" aria-expanded="true"><?php echo $slug['lang_name']; ?></a>
                                        </li>
				                        <?php $i++;
			                        } ?>
                                </ul>
                                <div id="myTabContent" class="tab-content">
			                        <?php $slugs_arr = languages();
			                        $i = 0;
			                        foreach ($slugs_arr

			                                 as $slug) {
				                        $slug = $slug['slug'];

				                        //echo '-----'.$slug.'<br>';

				                        $get_instance = $mysqli->query("
                        SELECT evolve_topten_items.*, evolve_topten_items_data.*,evolve_topten_items_data.seo_id as product_seoid, evolve_product_category_data.seo_id as catseo
                        FROM evolve_topten_items
                        
                        LEFT JOIN evolve_product_category_data
                        ON evolve_product_category_data.for_instance = evolve_topten_items.category
                        AND evolve_product_category_data.lang = '$slug'
                        
                        LEFT JOIN evolve_topten_items_data
                        ON evolve_topten_items_data.for_instance = evolve_topten_items.id
                          AND evolve_topten_items_data.lang = '$slug'
                          
                        WHERE evolve_topten_items.id = '$instance_id'
                        ");
				                        //if(!$get_product) print_r($mysqli->error);

				                        $cat_item = $get_instance->fetch_array(MYSQLI_BOTH);
				                        ?>
                                        <div role="tabpanel" class="tab-pane fade <?php echo $i == 0 ? 'active' : ''; ?> in" id="tab_content<?php echo $slug; ?>" aria-labelledby="tab_con<?php echo $slug; ?>">
                                            <!-- LANG Tabs Editing -->
                                            <div class="form-group">
                                                <label><?php echo $lang[$item_name . '_title']; ?></label>
                                                <input name="title_<?php echo $slug; ?>" class="form-control" value="<?php echo $cat_item['title']; ?>" type="text" autocomplete="off" />
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $lang[$item_name . '_tagline']; ?></label>
                                                <input name="tagline_<?php echo $slug; ?>" class="form-control" value="<?php echo $cat_item['tagline']; ?>" type="text" autocomplete="off" />
                                            </div>

                                            <div class="form-group">
                                                <label><?php echo $lang[$item_name . '_seoid']; ?>
                                                    <a data-toggle="tooltip" data-placement="top" title="<?php echo $lang[$item_name . '_seo_tt']; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a></label>
                                                <div class="input-group">
                                                    <input name="seoid_<?php echo $slug; ?>" class="form-control <?php echo empty($cat_item['seo_id']) ? 'parsley-error' : ''; ?> seoid" value="<?php echo $cat_item['seo_id']; ?>" type="text" autocomplete="off" />
							                        <?php if (!empty($cat_item['seo_id'])) { //IF SEO ID IS NOT EMPTY SHOW LINK ?>
                                                        <span class="input-group-btn">
                          <?php
                          if (count($portals) > 1) { ?>
                              ?>
                              <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-eye"> </i> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                              <?php
                              foreach ($portals as $portal) {
	                              $frontend_url = $portal->url . '/' . $cat_item['catseo'] . '/' . $cat_item['seo_id']; ?>
                                  <li><a target="_blank" href="<?php echo $frontend_url ?>" m="1"><?php echo $portal->url; ?></a>
                              </li>
                              <?php } ?>
                            </ul>
                          </div>
                          <?php } else {

	                          $frontend_url = $portal->url . '/' . $cat_item['catseo'] . '/' . $cat_item['seo_id']; ?>
                              <a target="_blank" href="<?php echo $frontend_url ?>" class="btn btn-default"><i class="fa fa-eye"></i></a>
                          <?php } ?>
                        </span>
							                        <?php }// /IF SEO ID IS NOT EMPTY SHOW LINK
							                        ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $lang[$item_name . '_description']; ?></label>
                                                <textarea name="description_<?php echo $slug; ?>" class="resizable_textarea form-control"><?php echo $cat_item['description']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $lang[$item_name . '_content']; ?></label>
                                                <textarea name="content_<?php echo $slug; ?>" class="tinymce form-control"><?php echo $cat_item['content']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $lang[$item_name . '_tags']; ?> </label>
                                                <input name="keywords_<?php echo $slug; ?>" type="text" class="tags form-control tags_keywords" value="<?php echo $cat_item['keywords']; ?>" autocomplete="off" />
                                                <div style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                            </div>
                                            <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
                                            <!-- / LANG Tabs Editing -->
                                        </div>
				                        <?php $i++;
			                        } ?>
                                </div>
                            </div>

                            <!-- / Tabs Editing -->
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">

                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?php echo $lang[$item_name . '_options']; ?></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="">
                                <input type="checkbox" class="publish_switch publish-sw" data-id="<?php echo $instance_id; ?>" name="published" <?php echo checked($item['published']); ?> />
                                <label>
                                    <?php echo $lang['switch_publish']; ?>
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="featured" name="featured" <?php echo checked($item['featured']); ?>
                                           class="flat" /> <?php echo $lang[$item_name . '_featured']; ?>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label> <input type="checkbox" name="promoted" <?php echo checked($item['promoted']); ?>
                                               class="flat" /> <?php echo $lang[$item_name . '_promoted']; ?>
                                </label>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label><?php echo $lang[$item_name . '_price']; ?></label>
                                <input name="price" type="text" class="form-control" value="<?php echo $item['price']; ?>" />
                            </div>
                            <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
                        </div>
                    </div>
                    <!-- Add Colors -->
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?php echo $lang[$item_name . '_colors']; ?></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group row">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <button type="button" class="btn btn-info btn-xs add_field"><?php echo $lang[$item_name . '_add_multi_color']; ?></button>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-8 text-right <?php echo ($item['colors_data_json']) ? '':'none'?>" id="activate_colors">
                                    <label> <?php echo $lang[$item_name . '_activate_colors']; ?>
                                    </label>
                                    <input type="checkbox" name="activate_colors" <?php echo checked($item['activate_colors']); ?> class="flat" />

                                </div>
                                </div>

                                <br /><br />
                                <div class="clearfix"></div>
                                <ul id="color_dragable" class="dragable_list nav-list fields">
                                    <?php
                                    if ($item['colors_data_json']) {
                                        $colors_data = new stdClass();
                                        $colors_data = json_decode($item['colors_data_json']);
                                        foreach ($colors_data as $color) { ?>
                                            <li class="added_color">
                                                <div class="clearfix"></div>
                                                <div class="row">
                                                    <div class="text-left col-md-1 col-sm-1 col-xs-2 form-group dragable_arrows">
                                                        <i class="fa fa-arrows"></i></div>
                                                    <div class="col-md-5 col-sm-5 col-xs-6 row form-group">
                                                        <div class="input-group">
                                                            <input name="multiColorName[]" class="form-control" placeholder="<?php echo $lang[$item_name . '_color_name'] ?>" value="<?php echo $color->colorName ?>" type="text" autocomplete="off" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 col-sm-5 col-xs-6 form-group">
                                                        <div class="input-group colorpicker">
                                                            <input name="multiColorHex[]" type="text" value="<?php echo $color->colorHex ?>" class="form-control" />
                                                            <span class="input-group-addon"><i></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 col-sm-1 col-xs-2 remove_item_icon">

                                                        <i class="fa fa-times" aria-hidden="true"></i>

                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </li>

                                            <?php
                                        }
                                    } ?>
                                </ul>

                            </div>

                            <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
                        </div>
                    </div>
                    <!-- /Add Colors -->
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?php echo $lang['publishing_info']; ?></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="">
                                <!-- Publishing date -->
                                <label><?php echo $lang['publishing_date']; ?> </label>
                                <div class="form-group">
                                    <div class="input-group date" id="datetimepicker_publishing">
                                        <input name="datetimepicker_publishing" type="text" class="form-control" value="<?php echo $publishing_date; ?>" />
                                        <span class="input-group-addon">
                    <input type="checkbox" name="show_date" <?php echo checked($item['show_date']); ?> class="flat" />
                    </span> <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                                    </div>
                                    <div class="project_detail">
                                        <p class="title"><?php echo $lang['author']; ?></p>
                                        <p><?php echo get_username($item['author']) ?> </p>
                                        <p class="title"><?php echo $lang['last_edited']; ?></p>
                                        <p><?php echo get_username($item['last_edit_user']) . ' / ' . $last_edit_date ?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- /Publishing date -->
                        </div>
                    </div>
                    <!-- Add videos -->
                    <?php echo get_add_video_block($module_id, $module_child, $instance_id) ?>
                    <!-- /Add videos -->
                    <!-- cover picture -->
                    <div class="x_panel upload_block" id="cover_image">
                        <div class="x_title">
                            <h2><?php echo $lang['cover_image']; ?></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <?php if ($get_dim_rel->num_rows > 0) { ?>
                                <div class="btn-group">
                                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-sm" type="button" aria-expanded="false">
                                        <i class="fa fa-picture-o m-right-xs"></i> <?php echo $lang['select_cover'] ?>
                                        <span class="caret"></span>
                                    </button>
                                    <ul role="menu" class="dropdown-menu">
                                        <?php while ($dim = $get_dim_rel->fetch_assoc()) { ?>
                                            <li>
                                                <a id="dim_<?php echo $dim['for_dimension']; ?>" class="select_cover"><?php echo $dim['name']; ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } else {
                                echo $lang['please_make_dim']; ?>
                                <a href="index.php?dimensions"><?php echo $lang['set_dimensions_dd']; ?></a>
                            <?php } ?>
                            <div id="delete_cover" class="cover_exist btn-group <?php echo (empty($item['img'])) ? 'hidden' : ''; ?>">
                                <button class="delete_cover btn btn-danger dropdown-toggle btn-sm" type="button">
                                    <i class="fa fa-trash-o m-right-xs"></i> <?php echo $lang['cover_img_delete'] ?>
                                </button>
                            </div>
                            <div class="x_content">
                                <div class="cover_preview">
                                    <?php
                                    if ($item['img']) { ?>
                                        <img class="cover_img img-responsive" src="<?php echo $imgsrc; ?>?<?php echo time('timestamp'); ?>" alt="<?php echo $imgsrc; ?>" />
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="checkbox cover_exist <?php echo (empty($item['img'])) ? 'hidden' : ''; ?>">
                                <label>
                                    <input type="checkbox" name="show_cover_img" <?php echo checked($item['show_cover_img']); ?>
                                           class="flat" /> <?php echo $lang['cover_img_show'] ?>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
                        </div>
                    </div>
                    <!-- /cover picture -->
                    <!-- Select gallery -->
                    <div class="x_panel" id="gallery_panel">
                        <div class="x_title">
                            <h2><?php echo $lang['gallery_add']; ?></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="form-group">
                                <div id="choosed_gallery">
                                    <?php
                                    if ($item['gallery_id']) {
                                        get_gallery_selected_data($item['gallery_id']);
                                    } ?>
                                </div>
                                <label><?php echo $lang['gallery_select']; ?></label>
                                <input id="select_gallery" name="select_gallery" class="form-control" value="" type="text" autocomplete="off" />
                                <ul id="gallery_results"></ul>
                            </div>
                            <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
                        </div>
                    </div>
                </div>
                <!-- /Select gallery -->
            </div>
        </div>
    </div>
</form><!-- /page content -->
