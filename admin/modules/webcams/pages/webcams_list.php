<?php 
  defined('ADMIN') or die();//prevent direct open
     
  $get_webcam_list = $mysqli->query("
      SELECT 
      evolve_webcams.date_start,
      evolve_webcams.last_edit_time,
      evolve_webcams.gallery_id,
      evolve_webcams.history,
      evolve_webcams.featured,
      evolve_webcams.promoted,
      evolve_webcams.created_by,
      evolve_webcams.published,
      evolve_webcams_data.title,
      evolve_webcams_data.seo_id,
      
      evolve_webcams.id as webcam_id
      FROM evolve_webcams
      
      LEFT JOIN evolve_webcams_data
      ON evolve_webcams_data.for_wcam = evolve_webcams.id
        AND evolve_webcams_data.lang =  '$default_language'
      ORDER BY evolve_webcams.id DESC 
      ");
  //if(!$get_webcam_list) print_r($mysqli->error);
  
  ?>
<input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_id; ?>" />
<input type="hidden" id="ch_moduleID" name="ch_moduleID" value="2" />
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="input-group">
      <button id="add_new_webcam" type="button" class="btn btn-info"><?php echo $lang['button_add_new']?></button>
    </div>
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $lang['webcam_title']; ?></h3>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $lang['webcam_title_list'];?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content table-responsive">
            <table id="webcams-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th class="disable_sorting disable_sorting_first"><a data-toggle="tooltip" data-placement="top" title="<?php echo $lang['switch_publish']; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a></th>
                  <th></th>
                  <th><?php echo $lang['webcam_name']; ?></th>
                  <th><?php echo $lang['webcam_created_by']; ?></th>
                  <th><?php echo $lang['webcam_published']; ?></th>
                  <th><a data-toggle="tooltip" data-placement="top" title="<?php echo $lang['tooltip_featured'] ?>"><i class="fa fa-heart" aria-hidden="true"></i></a></th>
                  <th><a data-toggle="tooltip" data-placement="top" title="<?php echo $lang['tooltip_promoted'] ?>"><i class="fa fa-star" aria-hidden="true"></i></a></th>
                  <th><a data-toggle="tooltip" data-placement="top" title="<?php echo $lang['tooltip_gal_items']; ?>"><i class="fa fa-picture-o" aria-hidden="true"></i></a></th>
                  <th><a data-toggle="tooltip" data-placement="top" title="<?php echo $lang['tooltip_videos_nr']; ?>"><i class="fa fa-video-camera" aria-hidden="true"></i></a></th>
                  <th><?php echo $lang['webcam_progress_ff']; ?></th>
                  <th class="disable_sorting"><?php echo $lang['edit_title'];?></th>
                </tr>
              </thead>
              <tbody>
                <?php while($webcam = $get_webcam_list->fetch_assoc()){
                  $wcam_title = $webcam['title'];
                  if (empty($wcam_title)){
                    $wcam_title = get_available_name($webcam['webcam_id']);
                  }
                  $publishing_date = date("d.m.Y.", strtotime($webcam['date_start']));
                  $publishing_date_o = date("YmdHis", strtotime($webcam['date_start']));
                  
                  $lastEdit_date = '';
                  $lastEdit_date_o = '';
                  if ($webcam['last_edit_time']){
                  $lastEdit_date = date("d.m.Y. H:i:s", strtotime($webcam['last_edit_time']));
                  $lastEdit_date_o = date("YmdHis", strtotime($webcam['last_edit_time']));
                  }
                  $videos = '<i class="fa fa-ban" aria-hidden="true"></i>';
                  if (get_video_items_nr($webcam['webcam_id'], $module_id, 2)){
                    $videos = get_video_items_nr($webcam['webcam_id'], $module_id, 2);
                  }
                  $galleries = '<i class="fa fa-ban" aria-hidden="true"></i>';
                  if (get_gallery_items_nr($webcam['gallery_id'])){
                    $galleries = get_gallery_items_nr($webcam['gallery_id']);
                  }
                  
                  $instance_alert   = '';
                  $tooltip_alert    = '';
                  $info_icons       = '';
                  $icon_promoted    = 'star-o';
                  $icon_promoted_o  = '0';
                  $icon_featured    = 'heart-o';
                  $icon_featured_o  = '0';
                  // ALERT
                  if (empty($webcam['seo_id'])){ $instance_alert = 'instance_alert'; } // IF SEO ID IS MISSING
                  if (empty($webcam['seo_id'])){ 
                    $tooltip_alert = '<a data-toggle="tooltip" data-placement="top" title="'. $lang['alert_seo_id'].'"><i class="fa fa-question-circle" aria-hidden="true"></i></a>';
                  }
                  //INFO ICON 
                  $info_icon_history = '<a data-toggle="tooltip" data-placement="top" title="'. $lang['tooltip_history'].'"><i class="fa fa-header info_icons" aria-hidden="true"></i></a>';
                  
                  if ($webcam['history']){ $info_icons .= '<a data-toggle="tooltip" data-placement="top" title="'. $lang['tooltip_history'].'"><i class="fa fa-header info_icons" aria-hidden="true"></i></a>'; } // IF CAM IS IN HISTORY MODE
                  if ($webcam['promoted']){ $icon_promoted = 'star';  $icon_promoted_o  = '1'; } // IF CAM IS PROMOTED
                  if ($webcam['featured']){ $icon_featured = 'heart'; $icon_featured_o  = '1'; } // IF CAM IS FEATURED
                  ?>
                <tr id="instanceID_<?php echo $webcam['webcam_id'];?>" class="<?php echo $instance_alert;?>">
                  <td>                           
                    <input type="checkbox" data-id="<?php echo $webcam['webcam_id']; ?>" class="js-switch publish_switch" name="published" <?php echo checked($webcam['published']); ?> />
                  </td>
                  <td class="text-center"><?php echo $info_icons; ?></td>
                  <td><?php echo $tooltip_alert. ' ' .$wcam_title; ?></td>
                  <td><?php echo get_username($webcam['created_by']); ?></td>
                  <td><span class="hidden_text"><?php echo $publishing_date_o; ?></span><?php echo $publishing_date; ?></td>
                  <td class="text-center featured"><span class="hidden_text"><?php echo $icon_featured_o; ?></span><i data-id="<?php echo $webcam['webcam_id']; ?>" class="pointer feature_switch fa fa-<?php echo $icon_featured; ?>" aria-hidden="true"></i></td>
                  <td class="text-center promoted"><span class="hidden_text"><?php echo $icon_promoted_o; ?></span><i data-id="<?php echo $webcam['webcam_id']; ?>" class="pointer promote_switch fa fa-<?php echo $icon_promoted; ?>" aria-hidden="true"></i></td>
                  <td class="text-center"><?php echo $galleries; ?></td>
                  <td class="text-center"><?php echo $videos; ?></td>
                  <td><?php echo get_progress($webcam['webcam_id']); ?></td>
                  <td>
                    <a href="index.php?webcam=<?php echo $webcam['webcam_id']; ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> <?php echo $lang['button_edit']; ?> </a>
                    <a data-id="<?php echo $webcam['webcam_id']; ?>" class="btn btn-danger btn-xs del_instance"><i class="fa fa-trash-o"></i> </a>
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
  <div class="clearfix"></div>
</div>
<!-- /page content -->