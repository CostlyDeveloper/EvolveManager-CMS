<?php
  $get_video = $mysqli->query("
      SELECT evolve_video_relations.*
      FROM evolve_video_relations
        
      WHERE for_instance = '$art_id'
        and for_module = '$module_id'
        and for_module_child = '$module_child'
      ORDER BY position ASC
      ");
      //if(!$get_video) print_r($mysqli->error);
  
  if ($get_video->num_rows > 0) { ?>
<h2 class="with_line">
  <div><?php lang('related_video_title')?></div>
</h2>
<div class="clearfix"></div>
<div class="owl-carousel owl-featured_video owl-theme">
  <?php $video_image_folder = '/media/upload/video';
    while($vmed = $get_video->fetch_assoc()){
    //pr($vmed);
    $vid_media[] = video_info($vmed['video_id'], $language);
    }
    
    foreach($vid_media as $vmedia) {
        if ($vmedia['type'] == 1){ 
          $provider = 'https://www.youtube.com/watch?v=';
        }elseif ($vmedia['type'] == 2){ 
          $provider = 'https://vimeo.com/';
        }
        $vidthumbsrc       = $data['domain'].$video_image_folder.$vmedia['folder'].$vmedia['thumb_img'];
        //     = $data['domain'].$media['folder'].$media['thumb'];
        ?>
  <div class="item temp_hidden none">
    <a rel="video-gallery" class="swipebox" href="<?php echo $provider.$vmedia['pub_video_id']; ?>" title="<?php echo $vmedia['original_title']?>">
    <img src="<?php echo $vidthumbsrc; ?>" alt="Image" class="temp_hidden none"/>
    </a>
    <p><?php echo $vmedia['original_title'] ?></p>
  </div>
  <?php } ?>
</div>
<?php } ?>