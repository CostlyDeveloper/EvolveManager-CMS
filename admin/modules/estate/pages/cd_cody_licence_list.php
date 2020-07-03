<?php
defined('ADMIN') or die();//prevent direct open

$get_cd_cody_licence_list = $mysqli->query("
      SELECT 
        evolve_cd_cody_licences.*
      , evolve_cd_cody_licences.id as licence_id
      , evolve_cd_cody_licences_data.*
      FROM evolve_cd_cody_licences
      
      INNER JOIN evolve_cd_cody_licences_data
      ON evolve_cd_cody_licences_data.for_instance = evolve_cd_cody_licences.id
        AND evolve_cd_cody_licences_data.lang =  '$default_language'
        
      WHERE evolve_cd_cody_licences.category = '$instance_id'
      ORDER BY evolve_cd_cody_licences.id DESC
      ");
// if (!$get_cd_cody_licence_list) print_r($mysqli->error);

$get_cd_cody_list = $mysqli->query("
      SELECT evolve_cd_cody_data.title
      FROM evolve_cd_cody_list
      
      LEFT JOIN evolve_cd_cody_data
      ON evolve_cd_cody_data.for_instance = evolve_cd_cody_list.id
        AND evolve_cd_cody_data.lang = '$default_language'
        
      WHERE evolve_cd_cody_list.id = '$instance_id'
      ");

$get_module = $mysqli->query("
      SELECT evolve_modules.name
      FROM evolve_modules       
      WHERE evolve_modules.id = '$module_id'
  ");

$mod = $get_module->fetch_array(MYSQLI_ASSOC);
$cody_CD_module = $get_cd_cody_list->fetch_array(MYSQLI_ASSOC);

$item_name = 'cd_cody_licence_edit';
$category_name = 'estate';

$module_child = 1;
//if($developing) prb($cody_CD_module).prb($mod);
?>
<input type="hidden" name="page_title" value="<?php echo $mod['name'] . ' - ' . $cody_CD_module['title']; ?>"/>
<input type="hidden" name="moduleID" id="moduleID" value="<?php echo $module_id; ?>"/>
<input type="hidden" id="ch_moduleID" name="ch_moduleID" value="<?php echo $module_child ?>"/><!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <a href="index.php?<?php echo $category_name ?>" class="btn btn-default"><i class="fa fa-chevron-left" aria-hidden="true"></i> <?php echo $lang[$category_name . '_list']; ?>
        </a>
        <button type="button" id="add_new_<?php echo $item_name ?>" class="btn btn-primary"><?php echo $lang['button_add_new'] . ' ' . $lang['cd_cody_licence_edit'] ?></button>


        <div class="page-title">
            <div class="title_left">
                <h3>CostlyDeveloper / cody licences</h3>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?php echo $cody_CD_module['title']; ?></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th class="disable_sorting disable_sorting_first">Legal</th>
                                <th>Domain</th>
                                <th>Date</th>
                                <th>Token</th>
                                <th>Licence</th>
                                <th>Server IP</th>
                                <th class="disable_sorting"><?php echo $lang[$category_name . '_edit']; ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($item = $get_cd_cody_licence_list->fetch_assoc()) {
                                $publishing_date = date("d.m.Y. H:i:s", strtotime($item['date']));
                                $publishing_date_o = date("YmdHis", strtotime($item['date']));
                                ?>
                                <tr id="instanceID_<?php echo $item['licence_id']; ?>">
                                    <td>
                                        <input type="checkbox" data-id="<?php echo $item['licence_id']; ?>" class="js-switch publish_switch" name="is_legal" <?php echo checked($item['is_legal']); ?> />
                                    </td>
                                    <td><?php echo $item['domain']; ?></td>
                                    <td> <span class="hidden_text"><?php echo $publishing_date_o; ?></span><?php echo $publishing_date; ?></td>
                                    <td><?php echo $item['token']; ?></td>
                                    <td><?php echo $item['licence']; ?></td>
                                    <td><?php echo $item['server_ip']; ?></td>
                                    <td>
                                        <a href="index.php?cd_cody_licence_edit=<?php echo $item['licence_id']; ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> <?php echo $lang['button_edit']; ?>
                                        </a>
                                        <a data-id="<?php echo $item['licence_id']; ?>" class="btn btn-danger btn-xs del_instance"><i class="fa fa-trash-o"></i> <?php echo $lang['button_delete']; ?>
                                        </a>
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
</div><!-- /page content -->
