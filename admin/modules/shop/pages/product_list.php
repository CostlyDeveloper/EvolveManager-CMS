<?php
defined('ADMIN') or die();//prevent direct open

$get_product_list = $mysqli->query("
      SELECT 
        evolve_products.date,
        evolve_products.author,
        evolve_products.last_edit_user,
        evolve_products.last_edit_time,
        evolve_products.published,
        evolve_products.id as product_id,
        evolve_products_data.title as product_title
      
      FROM evolve_products
      
      INNER JOIN evolve_products_data
      ON evolve_products_data.for_instance = evolve_products.id
        AND evolve_products_data.lang =  '$default_language'
        
      WHERE evolve_products.category = '$instance_id'
      ORDER BY evolve_products.id DESC
      ");
if (!$get_product_list) print_r($mysqli->error);

$get_product_category = $mysqli->query("
      SELECT evolve_product_category_data.title
      FROM evolve_product_category
      
      LEFT JOIN evolve_product_category_data
      ON evolve_product_category_data.for_instance = evolve_product_category.id
        AND evolve_product_category_data.lang = '$default_language'
        
      WHERE evolve_product_category.id = '$instance_id'
      ");

$get_module = $mysqli->query("
      SELECT evolve_modules.name
      FROM evolve_modules       
      WHERE evolve_modules.id = '$module_id'
  ");

$mod = $get_module->fetch_array(MYSQLI_ASSOC);
$cat = $get_product_category->fetch_array(MYSQLI_ASSOC);
$item_name = 'product';
$module_child = 1;
//if($developing) prb($cat).prb($mod);
?>
<input type="hidden" name="page_title" value="<?php echo $mod['name'] . ' - ' . $cat['title']; ?>"/>
<input type="hidden" name="moduleID" id="moduleID" value="<?php echo $module_id; ?>"/>
<input type="hidden" id="ch_moduleID" name="ch_moduleID" value="<?php echo $module_child ?>"/><!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <a href="index.php?product_category" class="btn btn-default"><i class="fa fa-chevron-left" aria-hidden="true"></i> <?php echo $lang[$item_name . '_categories']; ?></a>
        <button type="button"
                class="btn btn-primary"><?php echo $lang['button_add_new'] . ' ' . $lang['product'] ?></button>


        <div class="page-title">
            <div class="title_left">
                <h3><?php echo $lang[$item_name . '_list_title']; ?></h3>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?php echo $cat['title']; ?></h2>
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
                                <th><?php echo $lang[$item_name . '_name']; ?></th>
                                <th><?php echo $lang[$item_name . '_author']; ?></th>
                                <th><?php echo $lang[$item_name . '_created']; ?></th>
                                <th><?php echo $lang['art_e_lst_edt']; ?></th>
                                <th class="disable_sorting"><?php echo $lang[$item_name . '_edit']; ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($item = $get_product_list->fetch_assoc()) {
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
                                        <a href="index.php?<?php echo $item_name ?>=<?php echo $item['product_id']; ?>"
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
