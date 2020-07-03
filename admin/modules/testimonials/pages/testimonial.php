<?php
defined('ADMIN') or die();//prevent direct open
$get_dim_rel = $mysqli->query("
    SELECT evolve_dimensions_relations.*, evolve_dimensions_img.*
    FROM evolve_dimensions_relations
        
    LEFT JOIN evolve_dimensions_img
    ON evolve_dimensions_img.id = evolve_dimensions_relations.for_dimension
    WHERE evolve_dimensions_relations.for_module = '$module_id'
  ");

$get_testimonial = $mysqli->query("
    SELECT img, folder, name, published, for_instance
    FROM evolve_testimonials
    WHERE evolve_testimonials.id = '$testimonial_id'
  ");

$row = $get_testimonial->fetch_array(MYSQLI_ASSOC);
$imgsrc = $domain . module_media_folder($module_id) . $row['folder'] . $row['img'];
?>
<!-- page content -->
<form id="edit_testimonial_form" method="POST">
    <input type="hidden" name="page_title" value="<?php echo $lang['testimonial_editing'] . ' - ' . $row['name']; ?>"/>
    <input type="hidden" name="instanceID" value="<?php echo $testimonial_id; ?>"/>
    <input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_id; ?>"/>
    <input type="hidden" id="ch_moduleID" name="ch_moduleID" value="2"/>
    <div class="right_col" role="main">
        <div class="">
            <div class="input-group">
                <a href="index.php?testimonial=<?php echo $row['for_instance'] ?>" class="btn btn-default"><i
                            class="fa fa-chevron-left" aria-hidden="true"></i></a>
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
                            <h2><?php echo $lang['testimonial_editing']; ?></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="form-group">
                                <label><?php echo $lang['person_name'] ?></label>
                                <input name="person_name" class="form-control" value="<?php echo $row['name']; ?>"
                                       type="text" autocomplete="off"/>
                            </div>
                        </div>
                        <!--  Text Fields -->
                        <div class="x_content">
                            <span id="span"></span>
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
                                    $get_sl = $mysqli->query("
                        SELECT                        
                        evolve_testimonials_data.occupation,
                        evolve_testimonials_data.job_title,
                        evolve_testimonials_data.city,
                        evolve_testimonials_data.web_name,
                        evolve_testimonials_data.web_url,
                        evolve_testimonials_data.rating,
                        evolve_testimonials_data.message
                    
                        FROM evolve_testimonials
                        LEFT JOIN evolve_testimonials_data
                        ON evolve_testimonials_data.for_instance = evolve_testimonials.id
                          AND evolve_testimonials_data.lang = '$slug'
                          
                        WHERE evolve_testimonials.id = '$testimonial_id'
                        ");
                                    //if(!$get_sl) print_r($mysqli->error);

                                    $slid = $get_sl->fetch_array(MYSQLI_ASSOC); ?>
                                    <div role="tabpanel" class="tab-pane fade <?php echo $i == 0 ? 'active' : ''; ?> in"
                                         id="tab_content<?php echo $slug; ?>"
                                         aria-labelledby="tab_con<?php echo $slug; ?>"/>
                                    <!-- LANG Tabs Editing -->
                                    <div class="form-group">
                                        <label><?php echo $lang['job_title']; ?></label>
                                        <input name="testimonialJobTitle_<?php echo $slug; ?>" class="form-control"
                                               value="<?php echo $slid['job_title']; ?>" type="text"
                                               autocomplete="off"/>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $lang['occupation']; ?></label>
                                        <input name="testimonialOccupation_<?php echo $slug; ?>" class="form-control"
                                               value="<?php echo $slid['occupation']; ?>" type="text"
                                               autocomplete="off"/>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $lang['city']; ?></label>
                                        <input name="testimonialCity_<?php echo $slug; ?>"
                                               class="resizable_textarea form-control"
                                               value="<?php echo $slid['city']; ?>" type="text" autocomplete="off"/>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $lang['testimonial_web_name']; ?></label>
                                        <input name="testimonialWebName_<?php echo $slug; ?>" class="form-control"
                                               value="<?php echo $slid['web_name']; ?>" type="text" autocomplete="off"/>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $lang['testimonial_web_url']; ?></label>
                                        <input name="testimonialWebUrl_<?php echo $slug; ?>" class="form-control"
                                               value="<?php echo $slid['web_url']; ?>" type="text" autocomplete="off"/>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $lang['testimonial_rating']; ?></label>
                                        <input name="testimonialRating_<?php echo $slug; ?>" class="form-control"
                                               value="<?php echo $slid['rating']; ?>" type="number" autocomplete="off"/>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $lang['testimonial_message']; ?></label>
                                        <textarea name="testimonialMessage_<?php echo $slug; ?>"
                                                  class="resizable_textarea form-control"><?php echo $slid['message']; ?></textarea>

                                    </div>
                                    <!-- / LANG Tabs Editing -->
                                </div>
                                <?php $i++;
                                } ?>
                            </div>
                        </div>
                        <!-- / Tabs Editing -->
                        <button type="submit"
                                class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
                    </div>
                </div>
            </div>
            <!-- / Text Fields -->
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?php echo $lang['block_options'] ?></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <input type="checkbox" data-id="<?php echo $testimonial_id; ?>"
                                   class="js-switch publish_switch"
                                   name="published" <?php echo checked($row['published']); ?> />
                            <label>
                                <?php echo $lang['switch_published'] ?>
                            </label>
                        </div>
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
                        <?php if ($get_dim_rel->num_rows > 0) { ?>
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-sm"
                                        type="button" aria-expanded="false"><i
                                            class="fa fa-picture-o m-right-xs"></i> <?php echo $lang['select_img'] ?>
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
                             class="cover_exist btn-group <?php echo (empty($row['img'])) ? 'hidden' : ''; ?>">
                            <button class="delete_cover btn btn-danger dropdown-toggle btn-sm" type="button"><i
                                        class="fa fa-trash-o m-right-xs"></i> <?php echo $lang['delete_img_button'] ?>
                            </button>
                        </div>
                        <div class="x_content">
                            <div class="cover_preview">
                                <?php
                                if ($row['img']) {
                                    ?>
                                    <img class="cover_img img-responsive"
                                         src="<?php echo $imgsrc; ?>?<?php echo time('timestamp'); ?>"
                                         alt="<?php echo $imgsrc; ?>"/>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="checkbox cover_exist <?php echo (empty($row['img'])) ? 'hidden' : ''; ?>">
                        </div>
                        <button type="submit"
                                class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
                    </div>
                </div>
            </div>
            <!-- /cover picture -->
        </div>
    </div>
    </div>
</form>
<!-- /page content -->