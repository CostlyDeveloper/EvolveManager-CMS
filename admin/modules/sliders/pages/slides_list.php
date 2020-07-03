<?php 
  defined('ADMIN') or die();//prevent direct open 
  $get_slides_list = $mysqli->query("
    SELECT published, name, id
    FROM  evolve_sliders
    WHERE for_instance = '$slider_id'
    ORDER BY  evolve_sliders.position ASC
  ");
  //if(!$get_slides_list) print_r($mysqli->error);
  
  $get_sliders = $mysqli->query("
    SELECT evolve_sliders_cat.name
    FROM evolve_sliders_cat
    WHERE id = '$slider_id'
  ");    
  $sli = $get_sliders->fetch_array(MYSQLI_ASSOC);              
  ?>
<input type="hidden" name="page_title" value="<?php echo $lang['sliders_list'] ?>" />
<input type="hidden" name="moduleID" id="moduleID" value="<?php echo $module_id; ?>" />
<input type="hidden" id="for_instance" name="for_instance" value="<?php echo $slider_id; ?>" />
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $lang['sliders_title']; ?></h3>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $sli['name']; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <button id="add_new_slide" type="button" class="btn btn-primary"><?php echo $lang['button_add_new']?></button>
            <ul class="to_do" id="sort_slides">
              <?php while($row = $get_slides_list->fetch_assoc()){?>
              <li class="list-group-item" data-id="<?php echo $row['id']; ?>" id="instanceID_<?php echo $row['id']; ?>">
                <div class="col-xs-2 col-md-1 pull-left">
                  <i class="fa fa-arrows"></i>
                </div>
                <div class="col-xs-2 col-md-1 pull-left text-center">
                  <a data-toggle="tooltip" data-placement="top" title="<?php echo $lang['switch_publish']; ?>">
                  <input data-id="<?php echo $row['id']; ?>" type="checkbox" <?php echo checked($row['published']); ?> name="published" class="js-switch publish_switch">
                  </a>
                </div>
                <div class="col-xs-4 col-md-7 pull-left">
                  <?php echo $row['name']; ?> 
                </div>
                <div class="col-xs-4 col-md-2 pull-right text-right">
                  <a href="index.php?slide=<?php echo $row['id']; ?>" class="btn_in_item btn-info btn-xs"><i class="fa fa-pencil"></i> <?php echo $lang['button_edit']; ?> </a>
                  <a data-id="<?php echo $row['id']; ?>" class="btn_in_item btn-danger btn-xs del_instance pointer"><i class="fa fa-trash-o"></i> <?php echo $lang['button_delete']; ?> </a>
                </div>
                <div class="clearfix"></div>
              </li>
              <?php } ?>
            </ul>
            <span id="span"></span>					
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->