<?php 
  defined('ADMIN') or die();//prevent direct open
  
  $get_article_list = $mysqli->query("
      SELECT 
        evolve_articles.date,
        evolve_articles.author,
        evolve_articles.last_edit_user,
        evolve_articles.last_edit_time,
        evolve_articles.published,
        evolve_articles.id as article_id,
        evolve_articles_data.title as article_title
      
      FROM evolve_articles
      
      INNER JOIN evolve_articles_data
      ON evolve_articles_data.for_article = evolve_articles.id
        AND evolve_articles_data.lang =  '$default_language'
        
      WHERE evolve_articles.category = '$instance_id'
      ORDER BY evolve_articles.id DESC
      ");
      //if(!$get_article_list) print_r($mysqli->error);
  
  $get_article_rubrics = $mysqli->query("
      SELECT evolve_article_rubrics_data.title, evolve_article_rubrics.id
      FROM evolve_article_rubrics
      
      LEFT JOIN evolve_article_rubrics_data
      ON evolve_article_rubrics_data.for_instance_id = evolve_article_rubrics.id
        AND evolve_article_rubrics_data.lang = '$default_language'
        
      WHERE evolve_article_rubrics.id = '$instance_id'
      ");
  
  $get_module           = $mysqli->query("
      SELECT evolve_modules.name
      FROM evolve_modules       
      WHERE evolve_modules.id = '$module_id'
  ");
    
  $mod                  = $get_module->fetch_array(MYSQLI_ASSOC);
  $rub                  = $get_article_rubrics->fetch_array(MYSQLI_ASSOC);
  if($developing) prb($rub);
  ?>
<input type="hidden" name="page_title" value="<?php echo $mod['name'].' - '. $rub['title']; ?>" />
<input type="hidden" name="moduleID" id="moduleID" value="<?php echo $module_id; ?>" />
<input type="hidden" name="rubric_id" id="rubric_id" value="<?php echo $rub['id']; ?>" />
<input type="hidden" id="ch_moduleID" name="ch_moduleID" value="1" />
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <button id="add_new_article" type="button" class="btn btn-primary"><?php echo $lang['button_add_new']?></button>
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $lang['article_title']; ?></h3>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $rub['title'];?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content table-responsive">
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th class="disable_sorting disable_sorting_first"><a data-toggle="tooltip" data-placement="top" title="<?php echo $lang['article_published']; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a></th>
                  <th><?php echo $lang['article_name']; ?></th>
                  <th><?php echo $lang['article_author']; ?></th>
                  <th><?php echo $lang['article_created']; ?></th>
                  <th><?php echo $lang['art_e_lst_edt']; ?></th>
                  <th class="disable_sorting"><?php echo $lang['article_edit'];?></th>
                </tr>
              </thead>
              <tbody>
                <?php while($article = $get_article_list->fetch_assoc()){
                  $publishing_date = date("d.m.Y. H:i:s", strtotime($article['date']));
                  $publishing_date_o = date("YmdHis", strtotime($article['date']));
                  $lastEdit_date = date("d.m.Y. H:i:s", strtotime($article['last_edit_time']));
                  $lastEdit_date_o = date("YmdHis", strtotime($article['last_edit_time']));
                  ?>
                <tr id="instanceID_<?php echo $article['article_id'];?>">
                  <td>
                    <input type="checkbox" data-id="<?php echo $article['article_id']; ?>" class="js-switch publish_switch" name="published" <?php echo checked($article['published']); ?> />
                  </td>
                  <td><?php echo $article['article_title']; ?></td>
                  <td><?php echo get_username($article['author']); ?></td>
                  <td><span class="hidden_text"><?php echo $publishing_date_o; ?></span><?php echo $publishing_date; ?></td>
                  <td><span class="hidden_text"><?php if($article['last_edit_time']){ echo $lastEdit_date_o; ?></span><?php echo $lastEdit_date; ?> ( <?php echo get_username($article['last_edit_user']); ?> ) <?php } ?></td>
                  <td>
                    <a href="index.php?article=<?php echo $article['article_id']; ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> <?php echo $lang['button_edit']; ?> </a>
                    <a data-id="<?php echo $article['article_id']; ?>" class="btn btn-danger btn-xs del_instance"><i class="fa fa-trash-o"></i> <?php echo $lang['button_delete']; ?> </a>
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
<!-- /page content -->
