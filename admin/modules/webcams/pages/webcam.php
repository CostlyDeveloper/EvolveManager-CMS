<?php
defined('ADMIN') or die();//prevent direct open
$get_dim_rel = $mysqli->query("
    SELECT evolve_dimensions_relations.*, evolve_dimensions_img.*
    FROM evolve_dimensions_relations
      
    LEFT JOIN evolve_dimensions_img
    ON evolve_dimensions_img.id = evolve_dimensions_relations.for_dimension
    WHERE evolve_dimensions_relations.for_module = '$module_id'
  ");

$get_module = $mysqli->query("
    SELECT evolve_modules.*
    FROM evolve_modules       
    WHERE evolve_modules.id = '$module_id'
  ");
$mod = $get_module->fetch_array(MYSQLI_BOTH);

$get_webcam = $mysqli->query("
    SELECT evolve_webcams.*, evolve_webcams_data.*
    FROM evolve_webcams
      
    LEFT JOIN evolve_webcams_data
    ON evolve_webcams_data.for_wcam = evolve_webcams.id
      AND evolve_webcams_data.lang =  '$default_language'
        
    WHERE evolve_webcams.id = '$webcam_id'
  ");
//if(!$get_webcam) print_r($mysqli->error);

$select_cat = $mysqli->query("
     SELECT evolve_webcam_cat_data.*, evolve_webcam_cat.*, evolve_webcam_cat. id as cat_id
     FROM evolve_webcam_cat
      
     LEFT JOIN evolve_webcam_cat_data
     ON evolve_webcam_cat_data.for_instance_id = evolve_webcam_cat.id
       AND evolve_webcam_cat_data.lang =  '$default_language'
     
     GROUP BY evolve_webcam_cat.id 
   ");

$webcam = $get_webcam->fetch_array(MYSQLI_ASSOC);
$hosted_imgsrc = $domain . module_media_folder($module_id) . $webcam['hosted_folder'] . $webcam['hosted_image'];
$wcam_title = $webcam['title'];
$wcam_title = get_available_name($webcam_id);
$publishing_date = strtotime($webcam['date_start']);
$publishing_date = date("d.m.Y.", $publishing_date);
$finishing_date = strtotime($webcam['date_end']);
$finishing_date = date("d.m.Y.", $finishing_date);
$last_edit_date = strtotime($webcam['last_edit_time']);
$last_edit_date = date("d.m.Y. H:i", $last_edit_date);
$module_child = 2;
?>
<!-- page content -->
<form id="edit_webcam_form" action="modules/webcams/actions/edit_webcam.php" method="POST">
    <input type="hidden" name="page_title" value="<?php echo $mod['name'] . ' - ' . $wcam_title; ?>"/>
    <input type="hidden" name="instanceID" value="<?php echo $webcam_id; ?>"/>
    <input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_id; ?>"/>
    <input type="hidden" id="ch_moduleID" name="ch_moduleID" value="<?php echo $module_child ?>"/>
    <div class="right_col" role="main">
        <div class="">
            <div class="input-group">
                <a href="index.php?webcam" class="btn btn-default"><i class="fa fa-chevron-left"
                                                                      aria-hidden="true"></i> <?php echo $lang['menu_webcams'] ?>
                </a>
                <button id="add_new_webcam" type="button"
                        class="btn btn-info"><?php echo $lang['button_add_new'] ?></button>
            </div>
            <div class="page-title">
                <div class="title_left">
                    <h3><?php echo $wcam_title; ?></h3>
                </div>
                <div class="title_right">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-12 pull-left">
                    <!--  Webcam manage -->
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?php echo $lang['webcam_general']; ?></h2>
                            <ul class="nav navbar-right panel_toolbox hidden">
                                <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <!--  left block -->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label"><?php echo $lang['webcam_choose_cat']; ?></label>
                                    <div>
                                        <select class="webcam_categories select2_group form-control" name="categories[]"
                                                multiple="multiple">
                                            <?php while ($cat = $select_cat->fetch_assoc()) { ?>
                                                <option value="<?php echo $cat['cat_id']; ?>" <?php echo get_selected_webcams($webcam_id, $cat['cat_id']); ?>><?php echo $cat['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $lang['webcam_city']; ?></label>
                                    <input name="wcamCity" class="form-control" value="<?php echo $webcam['city']; ?>"
                                           type="text" autocomplete="off"/>
                                </div>
                                <div class="form-group">
                                    <div>
                                        <label><?php echo $lang['webcam_stream_set']; ?></label>
                                        <div class="col-md-7 col-sm-7 col-xs-12 form-group pull-right text-right row">
                                            <button type="button"
                                                    class="btn btn-info btn-xs add_field"><?php echo $lang['webcam_add_multi']; ?></button>
                                        </div>
                                        <div id="single_stream"
                                             class="form-group <?php echo ($webcam['multi_stream']) ? 'hidden' : ''; ?>">
                                            <input name="single_stream" <?php echo disabled($webcam['multi_stream']) ?>
                                                   class="form-control"
                                                   placeholder="<?php echo $lang['webcam_stream_id'] ?>"
                                                   value="<?php echo $webcam['stream_id']; ?>" type="text"
                                                   autocomplete="off"/>
                                        </div>
                                        <ul id="stream_dragable" class="dragable_list nav-list fields">
                                            <?php if ($webcam['multi_stream']) {
                                                $get_multi_stream = $mysqli->query("
                          SELECT stream_id, stream_name
                          FROM evolve_webcam_stream_relations
                          WHERE evolve_webcam_stream_relations.for_webcam = '$webcam_id'
                          ORDER BY -position DESC
                        ");
                                                $i = 1;
                                                while ($str = $get_multi_stream->fetch_assoc()) {
                                                    ?>
                                                    <li data-id="<?php echo $i ?>" class="added_wids">
                                                        <div class="clearfix"></div>
                                                        <div class="row">
                                                            <div class="text-left col-md-1 col-sm-1 col-xs-2 form-group dragable_arrows">
                                                                <i class="fa fa-arrows"></i></div>
                                                            <div class="col-md-5 col-sm-5 col-xs-6 row form-group">
                                                                <input name="multiID[]" class="form-control"
                                                                       placeholder="<?php echo $lang['webcam_stream_id'] ?>"
                                                                       value="<?php echo $str['stream_id'] ?>"
                                                                       type="text" autocomplete="off"/>
                                                            </div>
                                                            <div class="col-md-5 col-sm-5 col-xs-6 form-group">
                                                                <input name="multiName[]" class="form-control"
                                                                       placeholder="<?php echo $lang['webcam_stream_name'] ?>"
                                                                       value="<?php echo $str['stream_name'] ?>"
                                                                       type="text" autocomplete="off"/>
                                                            </div>
                                                            <div class="col-md-1 col-sm-1 col-xs-2">
                                                                <a href="index.php?webcam"
                                                                   class="remove_field btn btn-default">
                                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </li>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--  left block -->
                            <!--  right block -->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-6 col-sm-12 col-xs-8">
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-8">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $lang['webcam_publ_date']; ?></label>
                                    <div class="input-group date" id="publishing_date">
                                        <input id="p_date" name="publishing_date" type="text" class="form-control"
                                               value="<?php echo $publishing_date; ?>"/>
                                        <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $lang['webcam_fins_date']; ?></label>
                                    <div class="input-group date" id="finishing_date">
                                        <input id="f_date" name="finishing_date" type="text"
                                               class="form-control hide_readonly_text" <?php echo readonly($webcam['show_date_end']) ?>
                                               value="<?php echo $finishing_date; ?>"/>
                                        <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                                        <span class="input-group-addon">
                    <input type="checkbox" id="make_historic"
                           name="show_date_end" <?php echo checked($webcam['show_date_end']); ?> class="flat"/>
                    </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $lang['webcam_password']; ?></label>
                                    <input name="wcamPassword" class="form-control"
                                           value="<?php echo $webcam['password']; ?>" type="text" autocomplete="off"/>
                                </div>
                            </div>
                            <!--  right block -->
                            <div class="clearfix"></div>
                            <button type="submit"
                                    class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
                        </div>
                    </div>
                    <!-- / Webcam manage -->
                    <!--  Text Fields -->
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?php echo $lang['webcam_editing']; ?></h2>
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
                                            <a href="#tab_content<?php echo $slug['slug']; ?>"
                                               id="tab_con<?php echo $slug['slug']; ?>" role="tab" data-toggle="tab"
                                               aria-expanded="true"><?php echo $slug['lang_name']; ?></a>
                                        </li>
                                        <?php $i++;
                                    } ?>
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <?php $slugs_arr = languages();
                                    $i = 0;
                                    foreach ($slugs_arr

                                    as $slug){
                                    $slug = $slug['slug'];

                                    //echo '-----'.$slug.'<br>';

                                    $get_wcams = $mysqli->query("
                        SELECT evolve_webcams_data.*, evolve_webcams_data.seo_id as webcam_seoid
                        FROM evolve_webcams
                      
                        LEFT JOIN evolve_webcams_data
                        ON evolve_webcams_data.for_wcam = evolve_webcams.id
                          AND evolve_webcams_data.lang = '$slug'
                          
                        WHERE evolve_webcams.id = '$webcam_id'
                        ");
                                    if (!$get_wcams) print_r($mysqli->error);

                                    $wcam = $get_wcams->fetch_array(MYSQLI_BOTH);
                                    ?>
                                    <div role="tabpanel" class="tab-pane fade <?php echo $i == 0 ? 'active' : ''; ?> in"
                                         id="tab_content<?php echo $slug; ?>"
                                         aria-labelledby="tab_con<?php echo $slug; ?>"/>
                                    <!-- LANG Tabs Editing -->
                                    <div class="form-group">
                                        <label><?php echo $lang['webcam_tagline']; ?></label>
                                        <input name="wcamTagline_<?php echo $slug; ?>" class="form-control"
                                               value="<?php echo $wcam['tagline']; ?>" type="text" autocomplete="off"/>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $lang['webcam_title']; ?></label>
                                        <input name="wcamTitle_<?php echo $slug; ?>" class="form-control"
                                               value="<?php echo $wcam['title']; ?>" type="text" autocomplete="off"/>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $lang['webcam_seoid']; ?> <a data-toggle="tooltip"
                                                                                       data-placement="top"
                                                                                       title="<?php echo $lang['webcam_seo_q']; ?>"><i
                                                        class="fa fa-question-circle"
                                                        aria-hidden="true"></i></a></label>
                                        <div class="input-group">
                                            <input name="wcamSeoid_<?php echo $slug; ?>"
                                                   class="form-control <?php echo (empty($wcam['webcam_seoid'])) ? 'parsley-error' : ''; ?> seoid"
                                                   value="<?php echo $wcam['webcam_seoid']; ?>" type="text"
                                                   autocomplete="off"/>
                                            <?php if (!empty($wcam['webcam_seoid'])) { //IF SEO ID IS NOT EMPTY SHOW LINK ?>
                                                <span class="input-group-btn">
                          <?php
                          $selected_cat = $mysqli->query("
                              SELECT seo_id
                              FROM evolve_webcams_seoid
                            
                              WHERE evolve_webcams_seoid.lang = '$slug'                            
                              
                             ");
                          $cat = $selected_cat->fetch_array(MYSQLI_BOTH);

                          if (count($portals) > 1) { ?>
                              <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="true"><i class="fa fa-eye"> </i> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                              <?php foreach ($portals as $portal) {
                                  $frontend_url = $portal->url . '/' . $cat['seo_id'] . '/' . $wcam['webcam_seoid']; ?>
                                  <li><a target="_blank" href="<?php echo $frontend_url ?>"
                                         m="1"><?php echo $portal->url; ?></a>
                              </li>
                              <?php } ?>
                            </ul>
                          </div>
                          <?php } else {
                            foreach ($portals as $portal) {
                              $frontend_url = $portal->url . '/' . $cat['seo_id'] . '/' . $wcam['webcam_seoid']; ?>
                              <a target="_blank" href="<?php echo $frontend_url ?>" class="btn btn-default"><i
                                          class="fa fa-eye"></i></a>
                          <?php }
                          } ?>
                        </span>
                                            <?php }// /IF SEO ID IS NOT EMPTY SHOW LINK
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $lang['webcam_description']; ?></label>
                                        <textarea name="wcamDescription_<?php echo $slug; ?>"
                                                  class="resizable_textarea form-control"><?php echo $wcam['description']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $lang['webcam_content']; ?></label>
                                        <textarea name="wcamContent_<?php echo $slug; ?>"
                                                  class="tinymce form-control"><?php echo $wcam['content']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $lang['webcam_tags']; ?> </label>
                                        <input name="wcamKeywords_<?php echo $slug; ?>" type="text"
                                               class="tags form-control tags_keywords"
                                               value="<?php echo $wcam['keywords']; ?>" autocomplete="off"/>
                                        <div style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                    </div>
                                    <button type="submit"
                                            class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
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
            <!-- / Text Fields -->
            <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?php echo $lang['webcam_options']; ?></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row form-group">
                            <input type="checkbox" id="published" class="js-switch publish_switch"
                                   name="published" <?php echo checked($webcam['published']); ?> />
                            <label>
                                <?php echo $lang['switch_publish']; ?>
                            </label>
                        </div>
                        <div class="row form-group">
                            <div class="btn-group btn-block btn-group-justified" data-toggle="buttons">
                                <label class="btn btn-default <?php echo active_class($webcam['featured']); ?>">
                                    <input type="checkbox" id="featured"
                                           name="featured" <?php echo checked($webcam['featured']); ?> /> <?php echo $lang['webcam_featured']; ?>
                                </label>
                                <label class="btn btn-default <?php echo active_class($webcam['promoted']); ?>">
                                    <input type="checkbox"
                                           name="promoted" <?php echo checked($webcam['promoted']); ?> /> <?php echo $lang['webcam_promoted']; ?>
                                </label>
                                <label class="btn btn-default <?php echo active_class($webcam['history']); ?>">
                                    <input type="checkbox"
                                           name="history" <?php echo checked($webcam['history']); ?> /> <?php echo $lang['webcam_history']; ?>
                                </label>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <button type="submit"
                                class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
                    </div>
                </div>
                <!-- Add videos -->
                <?php echo get_add_video_block($module_id, $module_child, $webcam_id) ?>
                <!-- /Add videos -->
                <!-- cover picture -->
                <div class="x_panel upload_block" id="cover_image">
                    <div class="x_title">
                        <h2><?php echo $lang['webcam_cover']; ?></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <?php if ($get_dim_rel->num_rows > 0) { ?>
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-sm"
                                        type="button" aria-expanded="false"><i
                                            class="fa fa-picture-o m-right-xs"></i> <?php echo $lang['cover_img_select'] ?>
                                    <span class="caret"></span>
                                </button>
                                <ul role="menu" class="dropdown-menu">
                                    <?php while ($dim = $get_dim_rel->fetch_assoc()) { ?>
                                        <li><a id="dim_<?php echo $dim['for_dimension']; ?>"
                                               class="select_cover"><?php echo $dim['name']; ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } else {
                            echo $lang['please_make_dim']; ?>
                            <a href="index.php?dimensions"><?php echo $lang['set_dimensions_dd']; ?></a>
                        <?php } ?>
                        <div id="delete_cover"
                             class="cover_exist btn-group <?php echo (empty($webcam['image'])) ? 'hidden' : ''; ?>">
                            <button class="delete_cover btn btn-danger dropdown-toggle btn-sm" type="button"><i
                                        class="fa fa-trash-o m-right-xs"></i> <?php echo $lang['cover_img_delete'] ?>
                            </button>
                        </div>
                        <div class="x_content">
                            <div class="cover_preview">
                                <?php if ($webcam['image']) {
                                    $imgsrc = $domain . module_media_folder($module_id) . $webcam['folder'] . $webcam['image'];
                                    ?>
                                    <img class="cover_img img-responsive"
                                         src="<?php echo $imgsrc; ?>?<?php echo time('timestamp'); ?>"
                                         alt="<?php echo $imgsrc; ?>"/>
                                <?php } ?>
                            </div>
                        </div>
                        <button type="submit"
                                class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
                    </div>
                </div>
                <!-- /cover picture -->
                <!-- hosted by -->
                <div class="x_panel upload_block" id="hosted_by">
                    <div class="x_title">
                        <h2><?php echo $lang['webcam_hosted_by']; ?></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <?php
                        mysqli_data_seek($get_dim_rel, 0);
                        if ($get_dim_rel->num_rows > 0) {
                            ?>
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-sm"
                                        type="button" aria-expanded="false"><i
                                            class="fa fa-picture-o m-right-xs"></i> <?php echo $lang['cover_img_select'] ?>
                                    <span class="caret"></span>
                                </button>
                                <ul role="menu" class="dropdown-menu">
                                    <?php while ($dim = $get_dim_rel->fetch_assoc()) { ?>
                                        <li>
                                            <a id="dim_<?php echo $dim['for_dimension']; ?>" class="select_cover">
                                                <?php echo $dim['name']; ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } else {
                            echo $lang['please_make_dim']; ?>
                            <a href="index.php?dimensions"><?php echo $lang['set_dimensions_dd']; ?></a>
                        <?php } ?>
                        <div id="delete_cover"
                             class="cover_exist btn-group <?php echo (empty($webcam['hosted_image'])) ? 'hidden' : ''; ?>">
                            <button class="delete_cover btn btn-danger dropdown-toggle btn-sm" type="button"><i
                                        class="fa fa-trash-o m-right-xs"></i> <?php echo $lang['cover_img_delete'] ?>
                            </button>
                        </div>
                        <div class="x_content">
                            <div class="cover_preview">
                                <?php if ($webcam['hosted_image']) { ?>
                                    <img class="cover_img img-responsive"
                                         src="<?php echo $hosted_imgsrc; ?>?<?php echo time('timestamp'); ?>"
                                         alt="<?php echo $hosted_imgsrc; ?>"/>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label><?php echo $lang['webcam_hosted_name']; ?></label>
                                <input name="hosted_name" class="form-control"
                                       value="<?php echo $webcam['hosted_name']; ?>" type="text" autocomplete="off"/>
                            </div>
                            <div class="form-group">
                                <label><?php echo $lang['webcam_hosted_url']; ?></label>
                                <input name="hosted_url" class="form-control"
                                       value="<?php echo $webcam['hosted_url']; ?>" type="text" autocomplete="off"/>
                            </div>
                        </div>
                        <button type="submit"
                                class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
                    </div>
                </div>
                <!-- /hosted by -->
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
                                if ($webcam['gallery_id']) {
                                    get_gallery_selected_data($webcam['gallery_id']);
                                } ?>
                            </div>
                            <label><?php echo $lang['gallery_select']; ?></label>
                            <input id="select_gallery" name="select_gallery" class="form-control" value="" type="text"
                                   autocomplete="off"/>
                            <ul id="gallery_results"></ul>
                        </div>
                        <button type="submit"
                                class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
                    </div>
                </div>
            </div>
            <!-- /Select gallery -->
        </div>
    </div>
    </div>
</form>
<!-- /page content -->