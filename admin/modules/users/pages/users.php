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
    SELECT evolve_modules.name
    FROM evolve_modules       
    WHERE evolve_modules.id = '$module_id'
  ");
  $mod = $get_module->fetch_array(MYSQLI_ASSOC);
        
  $get_user = $mysqli->query("
    SELECT email, first_name, last_name, company, mobile_number, usr_group
    FROM evolve_users
    WHERE evolve_users.id = '$usr_id'
  ");
  //if(!$get_user) print_r($mysqli->error);
  
  $select_user_groups = $mysqli->query("
   SELECT evolve_user_groups.id, evolve_user_groups.name
   FROM evolve_user_groups
  ");
   
  $usr = $get_user->fetch_array(MYSQLI_ASSOC);
  $module_child = 2;
  ?>
<!-- page content -->
<form id="edit_user_form" action="modules/users/actions/edit_user.php" method="POST">
  <input type="hidden" name="page_title" value="<?php echo $mod['name'] ?>" />
  <input type="hidden" name="instanceID" value="<?php echo $usr_id; ?>" />
  <input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_id; ?>" />
  <input type="hidden" id="ch_moduleID" name="ch_moduleID" value="<?php echo $module_child ?>" />
  <div class="right_col" role="main">
  <div class="">
    <div class="input-group">
      <a href="index.php?users" class="btn btn-default"><i class="fa fa-chevron-left" aria-hidden="true"></i> <?php echo $lang['usr_title']?></a>
      <button id="add_new_usr" type="button" class="btn btn-info"><?php echo $lang['button_add_new']?></button>
    </div>
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $usr['first_name'].' '.$usr['last_name']; ?></h3>
      </div>
      <div class="title_right">
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-6 col-sm-6 col-xs-8 pull-left">
        <!--  Usr manage -->
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $lang['usr_edit']?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div id="ajax" ></div>
            <!--   block -->  
            <div class="col-md-12 col-sm-12 col-xs-16">
              <div class="form-group">
                <label><?php echo $lang['usr_email_username'];?></label>
                <input name="email" class="form-control" readonly="" value="<?php echo $usr['email']; ?>" type="text" autocomplete="off" />
              </div>
              <div class="form-group">
                <label><?php echo $lang['usr_first_name'];?></label>
                <input name="first_name" class="form-control" value="<?php echo $usr['first_name']; ?>" type="text" autocomplete="off" />
              </div>
              <div class="form-group">
                <label><?php echo $lang['usr_last_name'];?></label>
                <input name="last_name" class="form-control" value="<?php echo $usr['last_name']; ?>" type="text" autocomplete="off" />
              </div>
              <div class="form-group">
                <label><?php echo $lang['usr_company'];?></label>
                <input name="company" class="form-control" value="<?php echo $usr['company']; ?>" type="text" autocomplete="off" />
              </div>
              <div class="form-group">
                <label><?php echo $lang['usr_mob_nr']?></label>
                <input name="mobile_number" class="form-control" value="<?php echo $usr['mobile_number']; ?>" type="text" autocomplete="off" />
              </div>
            </div>
            <!--   block -->
            <div class="clearfix"></div>
            <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
          </div>
        </div>
        <!-- / Usr manage -->
      </div>
      <div class="col-md-6 col-sm-6 col-xs-8 pull-right">
        <!-- Users group -->
        <div class="x_panel upload_block" id="cover_image">
          <div class="x_title">
            <h2><?php echo $lang['usr_group']; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="form-group">
              <label class="control-label"><?php echo $lang['usr_select_group']?></label>
              <div>
                <select name="usr_group" class="form-control">
                  <?php while($grp = $select_user_groups->fetch_assoc()){?>
                  <option value="<?php echo $grp['id']?>" <?php echo ($grp['id'] == $usr['usr_group'] ? 'selected' : '') ?> ><?php echo $grp['name']?></option>
                  <?php }?> 
                </select>
              </div>
            </div>
            <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
          </div>
        </div>
        <!-- /Users group -->
        <!-- password -->
        <div class="x_panel upload_block" id="cover_image">
          <div class="x_title">
            <h2><?php echo $lang['usr_pass_change']; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="form-group">
              <label><?php echo $lang['usr_new_pass']?></label>
              <input name="password" id="new_pass" class="form-control" type="password" autocomplete="off" />
            </div>
            <div id="usr_confirm_pass" class="form-group item">
              <label><?php echo $lang['usr_confirm_pass']?></label>
              <input name="password2" id="confirm_pass" class="form-control" type="password" autocomplete="off" />
            </div>
            <div id="passAlert" class="alert none alert-danger alert-dismissible fade in" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
              </button>
              <?php echo $lang['err_pass_match'] ?>
            </div>
            <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
          </div>
        </div>
        <!-- /password -->
      </div>
    </div>
  </div>
</form>
<!-- /page content -->