<?php 
  defined('ADMIN') or die();//prevent direct open
   
  $get_module           = $mysqli->query("
    SELECT evolve_modules.*
    FROM evolve_modules
    WHERE enabled = 1      
  ");
  $user_groups_table = 'evolve_user_groups';
  if($bridge_cody_chat){  
    $user_groups_table = 'evolve_boom_groups';
  }
  
  $get_user_groups = $mysqli->query("
    SELECT $user_groups_table.*
    FROM $user_groups_table
    WHERE id = '$instance_id'
    ");
  //if(!$get_user_groups) print_r($mysqli->error);
    
  $grp = $get_user_groups->fetch_array(MYSQLI_ASSOC);
  
  if ($grp['editable']){//If group is editable
  
  $perm = $grp['permissions'];
  $perm = json_decode($perm); // decode row
  // add modules into array
   //prb($perm);
  while($mod = $get_module->fetch_assoc()){ 
    $mods[] = $mod['id'];
    //$perm[] = $mod['id'];
  }
  
  $user_permissions           = array_diff($perm, $mods);
  $user_permissions_cleaned   = array_diff($perm, $user_permissions);
  $new_nice_array             = array_merge($user_permissions_cleaned,$mods);
  $new_nice_array = array_count_values($new_nice_array);//merge double values
  ksort($new_nice_array);//sort from low to high

  ?>
<!-- page content -->
<form id="edit_user_groups_form" action="settings/user_groups/actions/edit_user_groups.php" method="POST">
  <input type="hidden" name="page_title" value="<?php echo $lang['grp_edit'] ?>" />
  <input type="hidden" name="instanceID" value="<?php echo $instance_id; ?>" />
  <input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_id; ?>" />
  <input type="hidden" id="user_groups_table" name="user_groups_table" value="<?php echo $user_groups_table; ?>" />
  <div class="right_col" role="main">
  <div class="">
    <div class="input-group">
      <button id="add_new_user_groups" type="button" class="btn btn-primary"><?php echo $lang['button_add_new']?></button>
      <a href="index.php?user_groups" class="btn btn-default"><i class="fa fa-chevron-left" aria-hidden="true"></i> <?php echo $lang['grp_title']?></a>
    </div>
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $grp['name']?></h3>
      </div>
      <div class="title_right">
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div id="ajax" ></div>
      <div class="col-md-6 col-sm-6 col-xs-8 pull-left">
        <!--  manage -->
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $lang['grp_edit_id']?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <!--   block -->  
            <div class="col-md-12 col-sm-12 col-xs-16">
              <div class="form-group">
                <label><?php echo $lang['grp_name'];?></label>
                <input name="name" class="form-control" value="<?php echo $grp['name']; ?>" type="text" autocomplete="off" />
              </div>
              <div class="form-group">
                <label><?php echo $lang['grp_notice'];?></label>
                <input name="notice" class="form-control" value="<?php echo $grp['notice']; ?>" type="text" autocomplete="off" />
              </div>
            </div>
            <!--   block -->
            <div class="clearfix"></div>
            <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
          </div>
        </div>
        <!-- / manage -->
      </div>
      <div class="col-md-6 col-sm-6 col-xs-8 pull-right">
        <!-- permissions -->
        <div class="x_panel upload_block" id="cover_image">
          <div class="x_title">
            <h2><?php echo $lang['grp_edit'] ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="">
              <ul class="to_do">
                <?php 
                  $checked = '';
                  foreach ($new_nice_array as $modID => $nr){   
                    $checked = $nr > 1 ? 'checked' : '';
                    $module_name = get_module_name($modID); ?>
                <li>
                  <p> <input type="checkbox" name="mod_<?php echo $modID; ?>" <?php echo $checked; ?> class="flat" /> <?php echo $module_name ?> </p>
                </li>
                <?php } ?>
              </ul>
            </div>
            <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
          </div>
        </div>
        <!-- /permissions -->
      </div>
    </div>
  </div>
</form>
<!-- /page content -->
<?php }//if editable ?>