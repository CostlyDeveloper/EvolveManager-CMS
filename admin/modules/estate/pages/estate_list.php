<?php
defined('ADMIN') or die();//prevent direct open

$get_product_category_list = $mysqli->query("
    SELECT evolve_cd_cody_data.title, evolve_cd_cody_list.id as instance_id
    FROM evolve_cd_cody_list
      
    LEFT JOIN evolve_cd_cody_data
    ON evolve_cd_cody_data.for_instance = evolve_cd_cody_list.id
      AND evolve_cd_cody_data.lang =  '$default_language'
  ");
// if(!$get_product_category_list) print_r($mysqli->error);

$get_module = $mysqli->query("
    SELECT evolve_modules.name
    FROM evolve_modules       
    WHERE evolve_modules.id = '$module_id'
  ");

$module_name = 'product';

$mod = $get_module->fetch_array(MYSQLI_BOTH);
$module_child = 3;
?>
<input type="hidden" name="page_title" value="<?php echo $mod['name'] . ' - ' . $lang[$module_name . '_categories']; ?>"/>
<input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_id; ?>"/>
<input type="hidden" id="ch_moduleID" name="ch_moduleID" value="<?php echo $module_child ?>"/>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="input-group">
            <button id="add_new_category" type="button"
                    class="btn btn-info"><?php echo $lang['button_add_new'] ?> Category</button>
        </div>
        <div class="page-title">

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>CostlyDeveloper / CodyChat modules</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div>
                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                <tr class="headings">
                                    <th>
                                    </th>
                                    <th class="column-title"><?php echo $lang['rubric_title'] ?> </th>
                                    <th class="column-title">Number of licences</th>
                                    <th>
                                    </th>
                                    <th class="bulk-actions" colspan="7">
                                        <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span
                                                    class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php while ($category_item = $get_product_category_list->fetch_assoc()) { ?>
                                    <tr id="instanceID_<?php echo $category_item['instance_id']; ?>" class="even pointer">
                                        <td class="a-center ">
                                        </td>
                                        <td><?php echo $category_item['title']; ?></td>
                                        <td><?php echo get_items_nr($category_item['instance_id'], 'evolve_cd_cody_licences') ?> </td>
                                        <td class="text-right last">

                                            <a href="index.php?cd_cody_licence_list=<?php echo $category_item['instance_id']; ?>"
                                               class="btn btn-primary btn-xs"><i
                                                        class="fa fa-list"></i> <?php echo $lang['button_show_items']; ?>
                                            </a>

                                            <a href="index.php?estate=<?php echo $category_item['instance_id']; ?>"
                                               class="btn btn-info btn-xs"><i
                                                        class="fa fa-pencil"></i> <?php echo $lang['button_edit']; ?>
                                            </a>
                                            <a data-id="<?php echo $category_item['instance_id']; ?>"
                                               class="btn btn-danger btn-xs del_instance"><i class="fa fa-trash-o"></i>
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
    </div>
</div>
<!-- /page content -->
