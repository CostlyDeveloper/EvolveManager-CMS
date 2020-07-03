<?php 
  defined('ADMIN') or die();//prevent direct open
   
  $user_groups_table = 'evolve_user_groups';
  if($bridge_cody_chat){  
    $user_groups_table = 'evolve_boom_groups';
  }
  
  $get_user_groups_list = $mysqli->query("
    SELECT $user_groups_table.*
    FROM $user_groups_table
    
    ORDER BY id
    ");
  //if(!$get_user_groups_list) print_r($mysqli->error);
  
  ?>
<input type="hidden" name="moduleID" id="moduleID" value="<?php echo $module_id; ?>" />
<input type="hidden" id="ch_moduleID" name="ch_moduleID" value="2" />
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="input-group">
      <button id="add_new_user_groups" type="button" class="btn btn-primary"><?php echo $lang['button_add_new']?></button>
    </div>
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $lang['grp_title']; ?></h3>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div id="echart_pie"></div>
          <div class="x_title">
            <h2><?php echo $lang['grp_title_list'];?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content table-responsive">
            <table id="table-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th><?php echo $lang['grp_name']; ?></th>
                  <th><?php echo $lang['grp_notice']; ?></th>
                  <th class="disable_sorting"><?php echo $lang['edit_title'];?></th>
                </tr>
              </thead>
              <tbody>
                <?php while($grp = $get_user_groups_list->fetch_assoc()){?>
                <tr id="instanceID_<?php echo $grp['id'];?>" class="">
                  <td><strong><?php echo $grp['name']; ?></strong></td>
                  <td><em><?php echo $grp['notice'] ?></em></td>
                  <td><?php if ($grp['editable']){//If group is editable  ?>
                    <a href="index.php?user_groups=<?php echo $grp['id']; ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> <?php echo $lang['button_edit']; ?> </a>
                    <?php if(!$bridge_cody_chat){ ?>
                    <a data-id="<?php echo $grp['id']; ?>" class="btn btn-danger btn-xs del_instance"><i class="fa fa-trash-o"></i> </a>
                    <?php } 
                    } //If group is editable?>
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