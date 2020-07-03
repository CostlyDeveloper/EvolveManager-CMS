<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");

if (!isset($_GET['userID']) || !isset($_GET['cpass']) || !isset($_GET['token']) || !isset($_GET['rdts'])){ die_500(); } 
security($_GET['userID'], $_GET['cpass'], $_GET['token'], $_GET['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_GET['userID'], $_GET['moduleID'], true);//Second check
  
  $menu_item_id   = $mysqli->real_escape_string($_GET['id']);
  $get_m = $mysqli->query("
    SELECT evolve_menus_relations.*
    FROM evolve_menus_relations
    WHERE id = '$menu_item_id'
  ");   
  $men = $get_m->fetch_array(MYSQLI_ASSOC); 
        
  ?> 
<form id="menu_item_form" class="form-horizontal form-label-left" method="POST">
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $lang['e_sample_name']?> </label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="text" class="form-control" id="e_sample_name" name="e_sample_name" value="<?php echo $men['name'];?>" />
    </div>
  </div>
  <?php  $slugs_arr = languages();                    
    foreach($slugs_arr as $slug){
    $sl = $slug['slug'];               
    $get_menu = $mysqli->query("
        SELECT evolve_menus_relations.*, evolve_menus_data.*
          FROM evolve_menus_relations
          
          LEFT JOIN evolve_menus_data
          ON evolve_menus_data.for_instance = evolve_menus_relations.id
        
        WHERE evolve_menus_data.for_instance = '$menu_item_id'
          AND evolve_menus_data.lang = '$sl'
    
    ");    
    $row = $get_menu->fetch_array(MYSQLI_ASSOC);

  ?>
  <div class="x_title">
    <h2><?php echo $slug['lang_name']?></h2>
    <div class="clearfix"></div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $lang['e_name']?> </label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="text" class="by_lang form-control" id="name_<?php echo $slug['slug']; ?>" name="name_<?php echo $slug['slug']; ?>" value="<?php echo $row['name'];?>" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $lang['e_uri']?> </label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="text" class="by form-control" id="uri_<?php echo $slug['slug']; ?>" name="uri_<?php echo $slug['slug']; ?>" value="<?php echo $row['uri'];?>" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $lang['e_url']?> </label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="text" class="by_lang form-control" id="url_<?php echo $slug['slug']; ?>" name="url_<?php echo $slug['slug']; ?>" value="<?php echo $row['url'];?>" />
    </div>
  </div>
  <?php } ?>
  <input type="hidden" name="menu_id" value="<?php echo $menu_item_id ?>" />
</form>