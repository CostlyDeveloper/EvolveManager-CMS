<?php 
  defined('ADMIN') or die();//prevent direct open

 // To prevent hacking, remove in case developing testimonials categories
  $testimonial_list_id = 1;

  $get_testimonial_list = $mysqli->query("
    SELECT published, name, id
    FROM  evolve_testimonials
    WHERE for_instance = '$testimonial_list_id'
    ORDER BY  evolve_testimonials.position ASC
  ");
  //if(!$get_testimonial_list) print_r($mysqli->error);
  
  $get_testimonials = $mysqli->query("
    SELECT evolve_testimonials_cat.name
    FROM evolve_testimonials_cat
    WHERE id = '$testimonial_list_id'
  ");    
  $sli = $get_testimonials->fetch_array(MYSQLI_ASSOC);              
  ?>
<input type="hidden" name="page_title" value="<?php echo $lang['testimonials_title'] ?>" />
<input type="hidden" name="moduleID" id="moduleID" value="<?php echo $module_id; ?>" />
<input type="hidden" id="for_instance" name="for_instance" value="<?php echo $testimonial_list_id; ?>" />
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $lang['testimonials_title']; ?></h3>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $sli['name']; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <button id="add_new_testimonial" type="button" class="btn btn-primary"><?php echo $lang['button_add_new']?></button>
            <ul class="to_do" id="sort_testimonial">
              <?php while($row = $get_testimonial_list->fetch_assoc()){?>
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
                  <a href="index.php?testimonial_item=<?php echo $row['id']; ?>" class="btn_in_item btn-info btn-xs"><i class="fa fa-pencil"></i> <?php echo $lang['button_edit']; ?> </a>
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