<?php
  define("ADMIN", true);
  require_once("../../../../system/config.php");
  
    $get_item_category = $mysqli->query("
      SELECT evolve_product_category.id, evolve_product_category_data.title
      FROM evolve_product_category
      
      LEFT JOIN evolve_product_category_data
      ON evolve_product_category_data.for_instance = evolve_product_category.id
        AND evolve_product_category_data.lang =  '$default_language' 
      ");
      //if(!$get_item_category) print_r($mysqli->error);
     
  ?>
<form id="add_item_form" class="add_new_form form-horizontal form-label-left" method="POST">
  <?php $slugs_arr = languages();
    foreach($slugs_arr as $slug){?>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $slug['lang_name'].' '.$lang['add_title'] ; ?> </label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="text" class="item_lang form-control" id="itemLang_<?php echo $slug['slug']; ?>" name="item_title_<?php echo $slug['slug']; ?>" value="" />
    </div>
  </div>
  <?php } ?>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $lang['select_category'];?></label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <select class="form-control" id="category_id">
        <?php while($category = $get_item_category->fetch_assoc()){?>
        <option value="<?php echo $category['id'];?>"><?php echo $category['title'];?></option>
        <?php } ?>
      </select>
    </div>
  </div>
</form>
