<?php 
  defined('ADMIN') or die();//prevent direct open
     
  $get_users_list = $mysqli->query("
      SELECT 
      evolve_users.email,
      evolve_users.first_name,
      evolve_users.last_name,
      evolve_users.id,
      evolve_user_groups.name as group_name
      
      FROM evolve_users
      
      LEFT JOIN evolve_user_groups
      ON evolve_user_groups.id = evolve_users.usr_group
      
  ");
  //if(!$get_users_list) print_r($mysqli->error);
  
  ?>
<input type="hidden" name="moduleID" id="moduleID" value="<?php echo $module_id; ?>" />
<input type="hidden" id="ch_moduleID" name="ch_moduleID" value="2" />
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="input-group">
      <button id="add_new_usr" type="button" class="btn btn-info"><?php echo $lang['button_add_new']?></button>
    </div>
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $lang['usr_title']; ?></h3>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div id="echart_pie"></div>
          <div class="x_title">
            <h2><?php echo $lang['usr_title_list'];?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content table-responsive">
            <table id="users-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th><?php echo $lang['usr_email']; ?></th>
                  <th><?php echo $lang['usr_name']; ?></th>
                  <th><?php echo $lang['usr_group']; ?></th>
                  <th class="disable_sorting"><?php echo $lang['edit_title'];?></th>
                </tr>
              </thead>
              <tbody>
                <?php while($usr = $get_users_list->fetch_assoc()){?>
                <tr id="instanceID_<?php echo $usr['id'];?>" class="">
                  <td><?php echo $usr['email']; ?></td>
                  <td><?php echo $usr['first_name'].' '.$usr['last_name']; ?></td>
                  <td><?php echo $usr['group_name']; ?></td>
                  <td>
                    <a href="index.php?users=<?php echo $usr['id']; ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> <?php echo $lang['button_edit']; ?> </a>
                    <a data-id="<?php echo $usr['id']; ?>" class="btn btn-danger btn-xs del_instance"><i class="fa fa-trash-o"></i> </a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
</div>
<!-- /page content -->