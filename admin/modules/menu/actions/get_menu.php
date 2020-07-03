<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root . "/system/config.php");
$menu_id = $mysqli->real_escape_string($_POST['id']);
if (is_numeric($menu_id)) {
    $get_menu = $mysqli->query("
        SELECT evolve_menus.*, evolve_menus_relations.*, evolve_menus_relations.id as item_id
        FROM evolve_menus
        LEFT JOIN evolve_menus_relations
        ON evolve_menus.id = evolve_menus_relations.for_instance
        WHERE evolve_menus_relations.for_instance = '$menu_id'
        ORDER BY evolve_menus_relations.position
        ");
    if (!$get_menu) print_r($mysqli->error);
    ?>
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo $lang['menu_tree'] ?></h2>
            <button data-id="<?php echo $menu_id; ?>" id="add_new_menu_item" type="button"
                    class="btn btn-primary pull-right"><?php echo $lang['add_new_menu_item'] ?></button>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <ol class="sortable ui-sortable mjs-nestedSortable-branch to_do">
                <?php while ($men = $get_menu->fetch_assoc()) {
                    if ($men['level'] == 1) { ?>
                        <li id="item_<?php echo $men['item_id']; ?>" class="list-group-item">
        <span class="pull-left margin_icon">
        <i class="fa fa-arrows"></i>
        </span>
                            <span class="pull-right margin_icon">
        <a data-id="<?php echo $men['item_id']; ?>" class="edit_menu_item btn btn-info btn-xs"><i
                    class="fa fa-pencil"></i> </a>
        <a data-id="<?php echo $men['item_id']; ?>" class="btn btn-danger btn-xs del_inst"><i class="fa fa-trash-o"></i> </a>
        </span>
                            <div id="name_<?php echo $men['item_id']; ?>">
                                <?php echo $men['name']; ?>
                            </div>
                            <?php get_next_level_menu_items($menu_id, $men['item_id'], $men['level']); ?>
                        </li>
                    <?php }
                } ?>
            </ol>
            <div id="sort_data"></div>
            <div class="clearfix"></div>
        </div>
    </div>
<?php } ?>