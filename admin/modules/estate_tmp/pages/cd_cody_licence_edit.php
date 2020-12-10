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
    SELECT evolve_cd_cody_licences.*, evolve_cd_cody_licences_data.*, evolve_cd_cody_data.*, evolve_cd_cody_licences_data.domain, evolve_cd_cody_data.title as category_title
    FROM evolve_cd_cody_licences
      
    LEFT JOIN evolve_cd_cody_data
    ON evolve_cd_cody_data.for_instance = evolve_cd_cody_licences.category
      AND evolve_cd_cody_data.lang =  '$default_language'
      
    LEFT JOIN evolve_cd_cody_licences_data
    ON evolve_cd_cody_licences_data.for_instance = evolve_cd_cody_licences.id
      AND evolve_cd_cody_licences_data.lang =  '$default_language'  
    WHERE evolve_cd_cody_licences.id = '$instance_id'
  ");
if ($developing) if (!$get_instance) print_r($mysqli->error);


$get_module = $mysqli->query("
    SELECT evolve_modules.name
    FROM evolve_modules       
    WHERE evolve_modules.id = '$module_id'
  ");
$item_name = 'cd_cody_licence_edit';
$category_name = 'estate';

$mod = $get_module->fetch_array(MYSQLI_ASSOC);
$item = $get_instance->fetch_array(MYSQLI_ASSOC);
$category = $item['category'];
$publishing_date = strtotime($item['date']);
$publishing_date = date("d.m.Y. H:i", $publishing_date);
$last_edit_date = strtotime($item['last_edit_time']);
$last_edit_date = date("d.m.Y. H:i", $last_edit_date);
$module_child = 2;

//if($developing) prb($item).prb($mod);
?>
<!-- page content -->
<form id="edit_<?php echo $item_name ?>_form" method="POST">
    <input type="hidden" name="page_title" value="<?php echo $mod['name'] . ' - ' . $item['domain']; ?>"/>
    <input type="hidden" name="itemID" value="<?php echo $instance_id; ?>"/>
    <input type="hidden" name="instanceID" value="<?php echo $instance_id; ?>"/>
    <input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_id; ?>"/>
    <input type="hidden" id="ch_moduleID" name="ch_moduleID" value="<?php echo $module_child ?>"/>
    <div class="right_col" role="main">
        <div class="">
            <a href="index.php?<?php echo $item_name ?>_list=<?php echo $category ?>" class="btn btn-default"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
            <button id="add_new_<?php echo $item_name ?>" type="button" class="btn btn-primary"><?php echo $lang['button_add_new'] ?></button>
            <div class="page-title">
                <div class="title_left">
                    <h3>
                        <small><?php echo $item['category_title']; ?> /</small> <?php echo $item['domain']; ?></h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
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
                        SELECT evolve_cd_cody_licences.*, evolve_cd_cody_licences_data.*, evolve_cd_cody_licences_data.seo_id as product_seoid, evolve_cd_cody_data.seo_id as catseo
                        FROM evolve_cd_cody_licences
                        
                        LEFT JOIN evolve_cd_cody_data
                        ON evolve_cd_cody_data.for_instance = evolve_cd_cody_licences.category
                        AND evolve_cd_cody_data.lang = '$slug'
                        
                        LEFT JOIN evolve_cd_cody_licences_data
                        ON evolve_cd_cody_licences_data.for_instance = evolve_cd_cody_licences.id
                          AND evolve_cd_cody_licences_data.lang = '$slug'
                          
                        WHERE evolve_cd_cody_licences.id = '$instance_id'
                        ");
                                        //if(!$get_product) print_r($mysqli->error);

                                        $cat_item = $get_instance->fetch_array(MYSQLI_BOTH);
                                        ?>
                                        <div role="tabpanel" class="tab-pane fade <?php echo $i == 0 ? 'active' : ''; ?> in" id="tab_content<?php echo $slug; ?>" aria-labelledby="tab_con<?php echo $slug; ?>">
                                            <!-- LANG Tabs Editing -->
                                            <div class="form-group">
                                                <label>Domain</label>
                                                <input name="domain_<?php echo $slug; ?>" class="form-control" value="<?php echo $cat_item['domain']; ?>" type="text" autocomplete="off"/>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $lang[$category_name . '_token']; ?></label>
                                                <input name="token_<?php echo $slug; ?>" class="form-control" value="<?php echo $cat_item['token']; ?>" type="text" autocomplete="off"/>
                                            </div>

                                            <div class="form-group">
                                                <label>Licence</label>
                                                <input name="licence_<?php echo $slug; ?>" class="form-control" value="<?php echo $cat_item['licence']; ?>" type="text" autocomplete="off"/>
                                            </div>


                                            <div class="form-group">
                                                <label>Price</label>
                                                <input name="price_<?php echo $slug; ?>" class="form-control" value="<?php echo $cat_item['price']; ?>" type="text" autocomplete="off"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Provision</label>
                                                <input name="provision_<?php echo $slug; ?>" class="form-control" value="<?php echo $cat_item['provision']; ?>" type="text" autocomplete="off"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Agent</label>
                                                <input name="agent_<?php echo $slug; ?>" class="form-control" value="<?php echo $cat_item['agent']; ?>" type="text" autocomplete="off"/>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $lang[$category_name . '_content']; ?></label>
                                                <textarea name="content_<?php echo $slug; ?>" class="tinymce form-control"><?php echo $cat_item['content']; ?></textarea>
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
                            <h2><?php echo $lang[$category_name . '_options']; ?></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="">
                                <input type="checkbox" class="publish_switch publish-sw" data-id="<?php echo $instance_id; ?>" name="is_legal" <?php echo checked($item['is_legal']); ?> />
                                <label>
                                    Legal
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="featured" name="featured" <?php echo checked($item['featured']); ?>
                                           class="flat"/> Special conditions
                                </label>
                            </div>
                            <div class="checkbox">
                                <label> <input type="checkbox" name="trouble" <?php echo checked($item['trouble']); ?>
                                               class="flat"/> Trouble
                                </label>
                            </div>
                            <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
                        </div>
                    </div>
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
                                <div class="form-group">
                                    <div class="project_detail">
                                        <p class="title">Server IP</p>
                                        <p><?php echo $item['server_ip'] ?> </p>
                                        <p class="title"><?php echo $lang['last_edited']; ?></p>
                                        <p><?php echo get_username($item['last_edit_user']) . ' / ' . $last_edit_date ?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- /Publishing date -->
                        </div>
                    </div>

                </div>
                <!-- /Select gallery -->
            </div>
        </div>
    </div>
</form><!-- /page content -->
