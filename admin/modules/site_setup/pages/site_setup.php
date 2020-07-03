<?php defined('ADMIN') or die(); //prevent direct open
$instance_id = 1;
$get_dim_rel = $mysqli->query("
  SELECT evolve_dimensions_relations.*, evolve_dimensions_img.*
  FROM evolve_dimensions_relations
      
  LEFT JOIN evolve_dimensions_img
  ON evolve_dimensions_img.id = evolve_dimensions_relations.for_dimension
  WHERE evolve_dimensions_relations.for_module = '$module_id'
");
$get_img = $mysqli->query("
  SELECT evolve_site_images.*
  FROM evolve_site_images
          
  WHERE id = '$instance_id'
");
//if(!$get_img) print_r($mysqli->error);
$img = $get_img->fetch_array(MYSQLI_ASSOC);

$get_settings = $mysqli->query("
  SELECT evolve_settings.*
  FROM evolve_settings
          
  WHERE evolve_settings.id = '$instance_id'
");

//if(!$get_settings) print_r($mysqli->error);

$row = $get_settings->fetch_array(MYSQLI_ASSOC);

$tabs = ['social','settings','seo','frontend_home']; ?>
<!-- page content -->
<form id="edit_site_setup_form"  method="POST">
  <input type="hidden" name="page_title" value="<?php echo $lang['site_setup'] ?>" />
  <input type="hidden" name="instanceID" value="<?php echo $instance_id; ?>" />
  <input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_id; ?>" />
  <div class="right_col" role="main">
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $lang['site_setup'] ?></h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="x_content">
    <div id="ajax"></div>
      <!-- Tabs Editing -->
      <div class="" role="tabpanel" data-example-id="togglable-tabs">
        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
          <?php $i = 0;
foreach($tabs as $slug) { ?>
          <li role="presentation" class="<?php echo $i == 0?'active':''; ?>">
            <a href="#tab_content<?php echo $slug; ?>" id="tab_con<?php echo $slug; ?>" role="tab" data-toggle="tab" aria-expanded="true"><?php echo $lang['ss_tab_'.$slug]; ?></a>
          </li>
          <?php $i++;
} ?>
        </ul>
        <div id="myTabContent" class="tab-content">
          <?php $i2 = 0;
foreach($tabs as $slug) { ?>
          <div role="tabpanel" class="tab-pane fade <?php echo $i2 == 0?'active':''; ?> in" id="tab_content<?php echo $slug; ?>" aria-labelledby="tab_con<?php echo $slug; ?>" />
            <?php include (ADMIN_PATH.'/modules/site_setup/layout/tab_'.$slug.'.php'); ?> 
          </div>
          <?php $i2++;
} ?>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
  </div>
</form>
<!-- /page content -->