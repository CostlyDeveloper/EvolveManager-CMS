<?php
defined('ADMIN') or die();//prevent direct open

$get_dim_rel = $mysqli->query("
      SELECT evolve_dimensions_relations.for_dimension, evolve_dimensions_img.name
      FROM evolve_dimensions_relations
      
      LEFT JOIN evolve_dimensions_img
      ON evolve_dimensions_img.id = evolve_dimensions_relations.for_dimension
      WHERE evolve_dimensions_relations.for_module = '$module_id'
  ");

$get_article = $mysqli->query("
    SELECT evolve_articles.*, evolve_articles_data.*, evolve_article_rubrics_data.*, evolve_articles_data.title as article_title, evolve_article_rubrics_data.title as rubric_title
    FROM evolve_articles
      
    LEFT JOIN evolve_article_rubrics_data
    ON evolve_article_rubrics_data.for_instance_id = evolve_articles.category
      AND evolve_article_rubrics_data.lang =  '$default_language'
      
    LEFT JOIN evolve_articles_data
    ON evolve_articles_data.for_article = evolve_articles.id
      AND evolve_articles_data.lang =  '$default_language'  
    WHERE evolve_articles.id = '$instance_id'
  ");
//if($developing) if(!$get_article) print_r($mysqli->error);


$get_module = $mysqli->query("
    SELECT evolve_modules.name
    FROM evolve_modules       
    WHERE evolve_modules.id = '$module_id'
  ");
$mod = $get_module->fetch_array(MYSQLI_ASSOC);
$art = $get_article->fetch_array(MYSQLI_ASSOC);
$category = $art['category'];
$imgsrc = $domain . module_media_folder($module_id) . $art['folder'] . $art['img'];
$publishing_date = strtotime($art['date']);
$publishing_date = date("d.m.Y. H:i", $publishing_date);
$last_edit_date = strtotime($art['last_edit_time']);
$last_edit_date = date("d.m.Y. H:i", $last_edit_date);
$scheduled_date = strtotime($art['schedule']);
$scheduled_date = date("d.m.Y. H:i", $scheduled_date);
$module_child = 2;

//if($developing) prb($art).prb($mod);
?>
<!-- page content -->
<form id="edit_article_form" action="modules/articles/actions/edit_article.php" method="POST">
    <input type="hidden" name="page_title" value="<?php echo $mod['name'] . ' - ' . $art['article_title']; ?>"/>
    <input type="hidden" name="articleID" value="<?php echo $instance_id; ?>"/>
    <input type="hidden" name="instanceID" value="<?php echo $instance_id; ?>"/>
    <input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_id; ?>"/>
    <input type="hidden" id="ch_moduleID" name="ch_moduleID" value="<?php echo $module_child ?>"/>
    <div class="right_col" role="main">
        <div class="">
            <a href="index.php?article_list=<?php echo $category ?>" class="btn btn-default"><i
                        class="fa fa-chevron-left" aria-hidden="true"></i></a>
            <button id="add_new_article" type="button"
                    class="btn btn-primary"><?php echo $lang['button_add_new'] ?></button>
            <div class="page-title">
                <div class="title_left">
                    <h3>
                        <small><?php echo $art['rubric_title']; ?> /</small> <?php echo $art['article_title']; ?></h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?php echo $lang['article_editing']; ?></h2>
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

									$get_article = $mysqli->query("
                        SELECT evolve_articles.*, evolve_articles_data.*,evolve_articles_data.seo_id as article_seoid, evolve_article_rubrics_data.seo_id as catseo
                        FROM evolve_articles
                        
                        LEFT JOIN evolve_article_rubrics_data
                        ON evolve_article_rubrics_data.for_instance_id = evolve_articles.category
                        AND evolve_article_rubrics_data.lang = '$slug'
                        
                        LEFT JOIN evolve_articles_data
                        ON evolve_articles_data.for_article = evolve_articles.id
                          AND evolve_articles_data.lang = '$slug'
                          
                        WHERE evolve_articles.id = '$instance_id'
                        ");
									//if(!$get_article) print_r($mysqli->error);

									$art = $get_article->fetch_array(MYSQLI_BOTH);
									?>
                                    <div role="tabpanel" class="tab-pane fade <?php echo $i == 0 ? 'active' : ''; ?> in"
                                         id="tab_content<?php echo $slug; ?>"
                                         aria-labelledby="tab_con<?php echo $slug; ?>"/>
                                    <!-- LANG Tabs Editing -->
                                    <div class="form-group">
                                        <label><?php echo $lang['art_e_tagline']; ?></label>
                                        <input name="articleTagline_<?php echo $slug; ?>" class="form-control"
                                               value="<?php echo $art['tagline']; ?>" type="text" autocomplete="off"/>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $lang['art_e_title']; ?></label>
                                        <input name="articleTitle_<?php echo $slug; ?>" class="form-control"
                                               value="<?php echo $art['title']; ?>" type="text" autocomplete="off"/>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $lang['art_e_seoid']; ?> <a data-toggle="tooltip"
                                                                                      data-placement="top"
                                                                                      title="<?php echo $lang['art_e_seo_q']; ?>"><i
                                                        class="fa fa-question-circle"
                                                        aria-hidden="true"></i></a></label>
                                        <div class="input-group">
                                            <input name="articleSeoid_<?php echo $slug; ?>"
                                                   class="form-control <?php echo (empty($art['article_seoid'])) ? 'parsley-error' : ''; ?> seoid"
                                                   value="<?php echo $art['article_seoid']; ?>" type="text"
                                                   autocomplete="off"/>
											<?php if (!empty($art['article_seoid'])) { //IF SEO ID IS NOT EMPTY SHOW LINK ?>
                                                <span class="input-group-btn">
                          <?php
                          if (count($portals) > 1) { ?>
                              ?>
                              <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="true"><i class="fa fa-eye"> </i> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                              <?php
                              foreach ($portals as $portal) {
	                              $frontend_url = $portal->url . '/' . $art['catseo'] . '/' . $art['article_seoid']; ?>
                                  <li><a target="_blank" href="<?php echo $frontend_url ?>"
                                         m="1"><?php echo $portal->url; ?></a>
                              </li>
                              <?php } ?>
                            </ul>
                          </div>
                          <?php } else {

	                          $frontend_url = $portal->url . '/' . $art['catseo'] . '/' . $art['article_seoid']; ?>
                              <a target="_blank" href="<?php echo $frontend_url ?>" class="btn btn-default"><i
                                          class="fa fa-eye"></i></a>
                          <?php } ?>
                        </span>
											<?php }// /IF SEO ID IS NOT EMPTY SHOW LINK
											?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $lang['art_e_description']; ?></label>
                                        <textarea name="articleDescription_<?php echo $slug; ?>"
                                                  class="resizable_textarea form-control"><?php echo $art['description']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $lang['art_e_content']; ?></label>
                                        <textarea name="articleContent_<?php echo $slug; ?>"
                                                  class="tinymce form-control"><?php echo $art['content']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $lang['art_e_tags']; ?> </label>
                                        <input name="articleKeywords_<?php echo $slug; ?>" type="text"
                                               class="tags form-control tags_keywords"
                                               value="<?php echo $art['keywords']; ?>" autocomplete="off"/>
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
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?php echo $lang['art_e_options']; ?></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <input type="checkbox" class="publish_switch publish-sw"
                                   data-id="<?php echo $instance_id; ?>"
                                   name="published" <?php echo checked($art['published']); ?> />
                            <label>
								<?php echo $lang['art_e_publish']; ?>
                            </label>
                        </div>
                        <div id="schedule_parent"
                             style="<?php echo (empty($art['published'])) ? 'display:block;' : 'display:none;'; ?>">
                            <!-- Schedule publish date -->
                            <label><?php echo $lang['art_e_publ_sch']; ?> </label>
                            <div class="form-group">
                                <div class="input-group date<?php echo (empty($art['activate_schedule'])) ? '' : ' parsley-success'; ?>"
                                     id="art_schedule">
                                    <div class="form-control <?php echo (empty($art['activate_schedule'])) ? 'hidden' : ''; ?>"
                                         id="sch_paravan"><?php echo $scheduled_date; ?></div>
                                    <input type="text" data-inputmask="'mask': '99.99.9999. 99:99'" name="art_schedule"
                                           class="form-control <?php echo (!empty($art['activate_schedule'])) ? 'hidden' : ''; ?>"
                                           value="<?php echo $scheduled_date; ?>"/>
                                    <span class="input-group-addon">
                    <input type="checkbox" id="activate_schedule"
                           name="activate_schedule" <?php echo checked($art['activate_schedule']); ?> class="flat"/>
                    </span>
                                    <span id="sch_cal_ico"
                                          style="<?php echo (empty($art['activate_schedule'])) ? 'display:table-cell;' : 'display:none;'; ?>"
                                          class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Schedule publish date -->
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="featured"
                                       name="featured" <?php echo checked($art['featured']); ?>
                                       class="flat"/> <?php echo $lang['art_e_featured']; ?>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="promoted" <?php echo checked($art['promoted']); ?>
                                       class="flat"/> <?php echo $lang['art_e_promoted']; ?>
                            </label>
                        </div>
                        <button type="submit"
                                class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
                    </div>
                </div>
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?php echo $lang['art_e_publ_opt']; ?></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <!-- Publishing date -->
                            <label><?php echo $lang['art_e_publ_date']; ?> </label>
                            <div class="form-group">
                                <div class="input-group date" id="datetimepicker_article_publishing">
                                    <input name="datetimepicker_article_publishing" type="text" class="form-control"
                                           value="<?php echo $publishing_date; ?>"/>
                                    <span class="input-group-addon">
                    <input type="checkbox" name="show_date" <?php echo checked($art['show_date']); ?> class="flat"/>
                    </span>
                                    <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                                </div>
                                <div class="project_detail">
                                    <p class="title"><?php echo $lang['art_e_author']; ?></p>
                                    <p><?php echo get_username($art['author']) ?> </p>
                                    <p class="title"><?php echo $lang['art_e_lst_edt']; ?></p>
                                    <p><?php echo get_username($art['last_edit_user']) . ' / ' . $last_edit_date ?></p>
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
                        <h2><?php echo $lang['art_e_cover']; ?></h2>
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
                                            class="fa fa-picture-o m-right-xs"></i> <?php echo $lang['art_e_select_cover'] ?>
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
                             class="cover_exist btn-group <?php echo (empty($art['img'])) ? 'hidden' : ''; ?>">
                            <button class="delete_cover btn btn-danger dropdown-toggle btn-sm" type="button"><i
                                        class="fa fa-trash-o m-right-xs"></i> <?php echo $lang['cover_img_delete'] ?>
                            </button>
                        </div>
                        <div class="x_content">
                            <div class="cover_preview">
								<?php
								if ($art['img']) { ?>
                                    <img class="cover_img img-responsive"
                                         src="<?php echo $imgsrc; ?>?<?php echo time('timestamp'); ?>"
                                         alt="<?php echo $imgsrc; ?>"/>
								<?php } ?>
                            </div>
                        </div>
                        <div class="checkbox cover_exist <?php echo (empty($art['img'])) ? 'hidden' : ''; ?>">
                            <label>
                                <input type="checkbox"
                                       name="show_cover_img" <?php echo checked($art['show_cover_img']); ?>
                                       class="flat"/> <?php echo $lang['cover_img_show'] ?>
                            </label>
                        </div>
                        <button type="submit"
                                class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
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
								if ($art['gallery_id']) {
									get_gallery_selected_data($art['gallery_id']);
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
