<?php 
  defined('ADMIN') or die();//prevent direct open
  
  $get_video_list = $mysqli->query("
      SELECT id as video_id, published, original_title, type, featured
      FROM evolve_video
      ORDER BY evolve_video.id DESC
      ");
      //if(!$get_video_list) print_r($mysqli->error);
  
  ?>
<input type="hidden" name="page_title" value="<?php echo $lang['video_list'] ?>" />
<input type="hidden" name="moduleID" id="moduleID" value="<?php echo $module_id; ?>" />
<input type="hidden" id="ch_moduleID" name="ch_moduleID" value="1" />
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $lang['manage_video_title']; ?></h3>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $lang['video_list']; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <button id="add_new_video" type="button" class="btn btn-primary"><?php echo $lang['button_add_new']?></button>
            <ul class="to_do">
              <?php while($vid = $get_video_list->fetch_assoc()){
                $type = $vid['type'];
                ?>
              <li class="list-group-item" id="instanceID_<?php echo $vid['video_id']; ?>">
                <div class="col-xs-2 col-md-1 pull-left">
                  <div class="count col-xs-10 col-md-8"><?php echo $vid['video_id']; ?></div>
                  <i class="fa fa-arrows hidden"></i>
                </div>
                <div class="col-xs-2 col-md-1 pull-left text-center">
                  <a data-toggle="tooltip" data-placement="top" title="<?php echo $lang['tooltip_featured']; ?>">
                  <input data-id="<?php echo $vid['video_id']; ?>" type="checkbox" <?php echo checked($vid['featured']); ?> name="featured" class="featured_switch">
                  </a>
                </div>
                <div class="col-xs-8 col-md-7 pull-left">
                  <div class="count col-xs-2 col-md-1">
                    <i class="fa fa-<?php if($type == 1){ echo 'youtube'; }elseif($type == 2){ echo 'vimeo'; } ?>"></i>
                  </div>
                  <?php echo $vid['original_title']; ?> 
                </div>
                <div class="col-xs-4 col-md-2 pull-right text-right">
                  <a href="index.php?video=<?php echo $vid['video_id']; ?>" class="btn_in_item btn-info btn-xs"><i class="fa fa-pencil"></i> <?php echo $lang['button_edit']; ?> </a>
                  <a data-id="<?php echo $vid['video_id']; ?>" class="btn_in_item btn-danger btn-xs del_instance pointer"><i class="fa fa-trash-o"></i> <?php echo $lang['button_delete']; ?> </a>
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
