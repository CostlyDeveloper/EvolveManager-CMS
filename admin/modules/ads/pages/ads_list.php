<?php 
  defined('ADMIN') or die();//prevent direct open 
  
  $get_ads_list = $mysqli->query("
      SELECT 
      evolve_ads_data.name, 
      evolve_ads_data.published,
      evolve_ads_data.id,
      evolve_ads.position_name
      
      FROM evolve_ads_data
      
      LEFT JOIN evolve_ads
      ON evolve_ads.id = evolve_ads_data.for_instance
      
      ORDER BY evolve_ads_data.position
      ");
      if(!$get_ads_list) print_r($mysqli->error);
   
   //$row = $get_ads_list->fetch_array(MYSQLI_ASSOC);
               
                    
 // mysqli_data_seek($get_sliders,0);// restart query from menu for new while loop
  ?>
<input type="hidden" name="token" value="<?php echo $ses_id; ?>" />
<input type="hidden" name="page_title" value="<?php echo $lang['ads_title'] ?>" />
<input type="hidden" name="moduleID" id="moduleID" value="<?php echo $module_id; ?>" />
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $lang['ads_title']; ?></h3>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
       
          <div class="x_title">
            <h2><?php echo $lang['ads_title']; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <button id="add_new_ad" type="button" class="btn btn-primary"><?php echo $lang['button_add_new']?></button>
            <ul class="to_do ul_head" >
              <li class="list-group-item" >
                <div class="col-xs-2 col-md-1 pull-left"></div>
                <div class="col-xs-2 col-md-1 pull-left text-center"></div>
                <div class="col-xs-4 col-md-4 pull-left">
                  <?php echo $lang['ad_name'] ?> 
                </div>
                <div class="col-xs-4 col-md-4 pull-left">
                  <?php echo $lang['ads_position'] ?> 
                </div>
                <div class="col-xs-4 col-md-2 pull-right text-right"></div>
                <div class="clearfix"></div>
              </li>
            </ul>
            <ul class="to_do" id="sort_instances">
              <?php while($row = $get_ads_list->fetch_assoc()){
                ?>
              <li class="list-group-item" data-id="<?php echo $row['id']; ?>" id="instanceID_<?php echo $row['id']; ?>">
                <div class="col-xs-2 col-md-1 pull-left">
                  <i class="fa fa-arrows"></i>
                </div>
                <div class="col-xs-2 col-md-1 pull-left text-center">
                  <a data-toggle="tooltip" data-placement="top" title="<?php echo $lang['switch_publish']; ?>">
                  <input data-id="<?php echo $row['id']; ?>" type="checkbox" <?php echo checked($row['published']); ?> name="published" class="js-switch publish_switch">
                  </a>
                </div>
                <div class="col-xs-4 col-md-4 pull-left">
                  <?php echo $row['name']; ?> 
                </div>
                 <div class="col-xs-4 col-md-4 pull-left">
                  <?php echo $row['position_name']; ?> 
                </div>
                <div class="col-xs-4 col-md-2 pull-right text-right">
                  <a href="index.php?ads=<?php echo $row['id']; ?>" class="btn_in_item btn-info btn-xs"><i class="fa fa-pencil"></i> <?php echo $lang['button_edit']; ?> </a>
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