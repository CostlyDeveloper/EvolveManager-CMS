<?php
  define("ADMIN", true);
  require_once("../../../../system/config.php");
  
    $get_article_rubrics = $mysqli->query("
      SELECT evolve_article_rubrics.id, evolve_article_rubrics_data.title
      FROM evolve_article_rubrics
      
      LEFT JOIN evolve_article_rubrics_data
      ON evolve_article_rubrics_data.for_instance_id = evolve_article_rubrics.id
        AND evolve_article_rubrics_data.lang =  '$default_language' 
      ");
      //if(!$get_article_rubrics) print_r($mysqli->error);
     
  ?>
<form id="add_article_form" class="form-horizontal form-label-left" method="POST">
  <?php $slugs_arr = languages();
    foreach($slugs_arr as $slug){?>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $slug['lang_name'].' '.$lang['add_title'] ; ?> </label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="text" class="article_lang form-control" id="atricleLang_<?php echo $slug['slug']; ?>" name="atricle_title_<?php echo $slug['slug']; ?>" value="" />
    </div>
  </div>
  <?php } ?>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $lang['select_rubric'];?></label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <select class="form-control" id="rubric_id">
        <?php while($rubric = $get_article_rubrics->fetch_assoc()){?>
        <option value="<?php echo $rubric['id'];?>"><?php echo $rubric['title'];?></option>
        <?php } ?>
      </select>
    </div>
  </div>
</form>