<?php
defined('ADMIN') or die();//prevent direct open

$get_room_list = $mysqli->query("
      SELECT 
        evolve_estate_rooms.date,
        evolve_estate_rooms.author,
        evolve_estate_rooms.last_edit_user,
        evolve_estate_rooms.last_edit_time,
        evolve_estate_rooms.published,
        evolve_estate_rooms.id as product_id,
        evolve_estate_rooms_data.title as product_title
      
      FROM evolve_estate_rooms
      
      INNER JOIN evolve_estate_rooms_data
      ON evolve_estate_rooms_data.for_instance = evolve_estate_rooms.id
        AND evolve_estate_rooms_data.lang =  '$default_language'
        
      WHERE evolve_estate_rooms.category = '$instance_id'
      ORDER BY evolve_estate_rooms.id DESC
      ");
// if (!$get_room_list) print_r($mysqli->error);

$get_estate_list = $mysqli->query("
      SELECT evolve_estate_data.title
      FROM evolve_estate_list
      
      LEFT JOIN evolve_estate_data
      ON evolve_estate_data.for_instance = evolve_estate_list.id
        AND evolve_estate_data.lang = '$default_language'
        
      WHERE evolve_estate_list.id = '$instance_id'
      ");

$get_module = $mysqli->query("
      SELECT evolve_modules.name
      FROM evolve_modules       
      WHERE evolve_modules.id = '$module_id'
  ");

$mod = $get_module->fetch_array(MYSQLI_ASSOC);
$estate = $get_estate_list->fetch_array(MYSQLI_ASSOC);

$item_name = 'room';
$category_name = 'estate';

$module_child = 1;
//if($developing) prb($estate).prb($mod);
?>
<input type="hidden" name="page_title" value="<?php echo $mod['name'] . ' - ' . $estate['title']; ?>"/>
<input type="hidden" name="moduleID" id="moduleID" value="<?php echo $module_id; ?>"/>
<input type="hidden" id="ch_moduleID" name="ch_moduleID" value="<?php echo $module_child ?>"/><!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <a href="index.php?<?php echo $category_name ?>" class="btn btn-default"><i class="fa fa-chevron-left" aria-hidden="true"></i> <?php echo $lang[$category_name . '_list']; ?></a>
        <button type="button" id="add_new_<?php echo $item_name ?>" class="btn btn-primary"><?php echo $lang['button_add_new'] . ' ' . $lang['room'] ?></button>


        <div class="page-title">
            <div class="title_left">
                <h3><?php echo $lang[$category_name . '_room_list_title']; ?></h3>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?php echo $estate['title']; ?></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content table-responsive">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th class="disable_sorting disable_sorting_first">
                                    <a data-toggle="tooltip" data-placement="top"
                                       title="<?php echo $lang['switch_published']; ?>"><i class="fa fa-question-circle"
                                                                                           aria-hidden="true"></i></a>
                                </th>
                                <th><?php echo $lang[$category_name . '_name']; ?></th>
                                <th><?php echo $lang[$category_name . '_author']; ?></th>
                                <th><?php echo $lang[$category_name . '_created']; ?></th>
                                <th><?php echo $lang['art_e_lst_edt']; ?></th>
                                <th class="disable_sorting"><?php echo $lang[$category_name . '_edit']; ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($item = $get_room_list->fetch_assoc()) {
                                $publishing_date = date("d.m.Y. H:i:s", strtotime($item['date']));
                                $publishing_date_o = date("YmdHis", strtotime($item['date']));
                                $lastEdit_date = date("d.m.Y. H:i:s", strtotime($item['last_edit_time']));
                                $lastEdit_date_o = date("YmdHis", strtotime($item['last_edit_time']));
                                ?>
                                <tr id="instanceID_<?php echo $item['product_id']; ?>">
                                    <td>
                                        <input type="checkbox" data-id="<?php echo $item['product_id']; ?>"
                                               class="js-switch publish_switch"
                                               name="published" <?php echo checked($item['published']); ?> />
                                    </td>
                                    <td><?php echo $item['product_title']; ?></td>
                                    <td><?php echo get_username($item['author']); ?></td>
                                    <td>
                                        <span class="hidden_text"><?php echo $publishing_date_o; ?></span><?php echo $publishing_date; ?>
                                    </td>
                                    <td><span class="hidden_text"><?php if ($item['last_edit_time']){
                                            echo $lastEdit_date_o; ?></span><?php echo $lastEdit_date; ?>
                                        ( <?php echo get_username($item['last_edit_user']); ?> ) <?php } ?>
                                    </td>
                                    <td>
                                        <a href="index.php?room=<?php echo $item['product_id']; ?>"
                                           class="btn btn-info btn-xs"><i
                                                    class="fa fa-pencil"></i> <?php echo $lang['button_edit']; ?>
                                        </a>
                                        <a data-id="<?php echo $item['product_id']; ?>"
                                           class="btn btn-danger btn-xs del_instance"><i
                                                    class="fa fa-trash-o"></i> <?php echo $lang['button_delete']; ?>
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
