<?php 
/*
  defined('ADMIN') or die();//prevent direct open

  if(($data_user_id == $instance_id) || spelialPermission($data_user_id, $module_id))
  
  
  $get_dim_rel = $mysqli->query("
  
      SELECT evolve_dimensions_relations.*, evolve_dimensions_img.*
      FROM evolve_dimensions_relations
      
      LEFT JOIN evolve_dimensions_img
      ON evolve_dimensions_img.id = evolve_dimensions_relations.for_dimension
      WHERE evolve_dimensions_relations.for_module = '$module_id'
      
  ");
    $get_profile = $mysqli->query("
      SELECT boom_users.*, evolve_soc_users.*
      FROM boom_users
      
      LEFT JOIN evolve_soc_users
        ON boom_users.user_id = evolve_soc_users.for_instance
          
      WHERE boom_users.user_id = '$instance_id'
    ");
      if(!$get_profile) print_r($mysqli->error);
  
     $pro = $get_profile->fetch_array(MYSQLI_ASSOC);
  
  //pr($pro);
  
    $pro_username  = $pro['user_name'];
    $pro_pass      = $pass;//cookie, prevent hacking

  ?>
<!-- page content -->
<form id="edit_site_setup_form"  method="POST">
  <input type="hidden" name="page_title" value="<?php echo $lang['pro_profile_title'].' - '.$pro_username ?>" />
  <input type="hidden" name="instanceID" value="<?php echo $instance_id; ?>" />
  <input type="hidden" name="userID" value="<?php echo $data_user_id; ?>" />
  <input type="hidden" name="userToken" value="<?php echo $pass; ?>" />
  <input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_id; ?>" />
  <div class="right_col" role="main">
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $lang['pro_profile_title'].' - '.$pro_username ?></h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div id="ajax"></div>

<div class="row">
  <div class="col-md-8 col-sm-8 col-xs-12">
    <div class="x_panel">
    <div class="x_title">
        <h2><?php echo $lang['block_general'] ?></h2>
        <div class="clearfix"></div>
      </div>
    <div class="alert alert-success alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <strong><?php echo $lang['meta_alert_str']?> </strong> <?php echo $lang['meta_alert']?>
    </div>
      
      <div class="x_title">
        <h2><?php echo $lang['block_scripts'] ?></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="">
          <div class="form-group">
            <label><?php echo $lang['header_script'];?></label>
            <textarea name="header_script" class="resizable_textarea form-control" ><?php //echo $row['header_script']; ?></textarea>
          </div>
          <div class="form-group">
            <label><?php echo $lang['footer_script'];?></label>
            <textarea name="footer_script" class="resizable_textarea form-control" ><?php // echo $row['footer_script']; ?></textarea>
          </div>
        </div>
      </div>
      
      <div class="x_title">
          <h2><?php echo $lang['block_verifivation'] ?></h2>
          <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="">
          <div class="form-group">
            <label><?php echo $lang['google_verif'];?></label>
            <input name="google_verif" class="resizable_textarea form-control" value="<?php //echo $row['google_verif']; ?>" />
          </div>
          <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
        </div>
      </div>

    </div>
  </div>
  <div class="col-md-4 col-sm-4 col-xs-12">
   
    <div class="x_panel">
      <div class="x_title">
        <h2><?php echo $lang['block_about']  ?></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="">
          <div class="form-group">
            <label><?php echo $lang['company_name'];?></label>
            <input name="company_name" class="form-control" value="<?php //echo $row['company_name']; ?>" type="text" autocomplete="off" />
          </div>
          <div class="form-group">
            <label><?php echo $lang['company_email'];?></label>
            <input name="company_email" class="form-control" value="<?php //echo $row['company_email']; ?>" type="text" autocomplete="off" />
          </div>
          <div class="form-group">
            <label><?php echo $lang['company_tel'];?></label>
            <input name="company_tel" class="form-control" value="<?php //echo $row['company_tel']; ?>" type="text" autocomplete="off" />
          </div>
          <div class="form-group">
            <label><?php echo $lang['skype'];?></label>
            <input name="skype" class="form-control" value="<?php //echo $row['skype']; ?>" type="text" autocomplete="off" />
          </div>
          
          <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
        </div>
      </div>
    </div>
   </div>

    
    <div class="clearfix"></div>
  </div>
</form>
<!-- /page content -->
*/
