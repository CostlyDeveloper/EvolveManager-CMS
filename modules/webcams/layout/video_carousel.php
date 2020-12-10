<?php
$get_video = $mysqli->query("
    SELECT evolve_video_relations.*
    FROM evolve_video_relations
      
    WHERE for_instance = '$webcam_id'
      and for_module = '$module'
      and for_module_child = '$module_child'
    ORDER BY position ASC
    ");
    if(!$get_video) print_r($mysqli->error);

if ($get_video->num_rows > 0) { ?>
<h2 class="with_line"><div><?php lang_string('wcat_featured_video_title')?></div></h2>
    <div class="clearfix"></div>  

<div class="evolve_carousel margin-b-40">
  <?php
  $video_image_folder = '/media/upload/video';
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
              $preloader    = $data['domain'].'/img/preloader.gif'; 
              ?>
              <div style="display: none;">
                <a rel="video-gallery-1" class="swipebox" href="<?php echo $provider.$vmedia['pub_video_id']; ?>" title="<?php echo $vmedia['title']?>">
                  <img src="<?php echo $preloader; ?>" data-lazy="<?php echo $vidthumbsrc; ?>" alt="Image" style="max-width:100%;"/>
                </a>
              </div>
            <?php } ?>
  
</div>
 <?php } ?>