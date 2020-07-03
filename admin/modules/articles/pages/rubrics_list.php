<?php 
  defined('ADMIN') or die();//prevent direct open
      
  $get_article_rubrics = $mysqli->query("
    SELECT evolve_article_rubrics_data.title, evolve_article_rubrics.id as rubric_id
    FROM evolve_article_rubrics
      
    LEFT JOIN evolve_article_rubrics_data
    ON evolve_article_rubrics_data.for_instance_id = evolve_article_rubrics.id
      AND evolve_article_rubrics_data.lang =  '$default_language'
  ");
  //if(!$get_article_rubrics) print_r($mysqli->error);
  
  $get_module           = $mysqli->query("
    SELECT evolve_modules.name
    FROM evolve_modules       
    WHERE evolve_modules.id = '$module_id'
  ");
    
  $mod                  = $get_module->fetch_array(MYSQLI_BOTH);
  ?>
<input type="hidden" name="page_title" value="<?php echo $mod['name'].' - '. $lang['article_rubrics']; ?>" />
<input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_id; ?>" />
<input type="hidden" id="ch_moduleID" name="ch_moduleID" value="3" />
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="input-group">
      <button id="add_new_art_rubric" type="button" class="btn btn-info"><?php echo $lang['button_add_new']?></button>
    </div>
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $lang['article_title']; ?></h3>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $lang['article_rubrics']; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="table-responsive">
              <table class="table table-striped jambo_table bulk_action">
                <thead>
                  <tr class="headings">
                    <th>
                    </th>
                    <th class="column-title"><?php echo $lang['rubric_title'] ?> </th>
                    <th class="column-title"><?php echo $lang['number_of_articles'];?> </th>
                    <th>
                    </th>
                    <th class="bulk-actions" colspan="7">
                      <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($rubric = $get_article_rubrics->fetch_assoc()){?>
                  <tr id="instanceID_<?php echo $rubric['rubric_id'];?>" class="even pointer">
                    <td class="a-center ">
                    </td>
                    <td class=" "><?php echo $rubric['title'];?></td>
                    <td class=" "><?php echo get_article_nr($rubric['rubric_id'])?> </td>
                    <td class=" last">
                       <a href="index.php?article_rubrics=<?php echo $rubric['rubric_id']; ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> <?php echo $lang['button_edit']; ?> </a>
                       <a data-id="<?php echo $rubric['rubric_id']; ?>" class="btn btn-danger btn-xs del_instance"><i class="fa fa-trash-o"></i> </a>
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