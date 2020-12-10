<?php
  $get_video = $mysqli->query("
      SELECT evolve_video_relations.*
      FROM evolve_video_relations
        
      WHERE for_instance = '$cat_id'
        and for_module = '$module'
        and for_module_child = '$module_child'
      ORDER BY position ASC
      LIMIT 3
      ");
      if(!$get_video) print_r($mysqli->error);
  
  //$vid = $get_video->fetch_array(MYSQLI_ASSOC);
    if ($get_video->num_rows > 0) { ?>
      
    <h2 class="with_line"><div><?php lang_string('wcat_featured_video_title')?></div></h2>
    <div class="clearfix"></div>  
      
    <?php  
    while($vmed = $get_video->fetch_assoc()){
      $vid_media[] = video_info($vmed['video_id'], $language);
    }
    ?>
<div class="row row-eq-height margin-b-40">
  <?php
    $video_image_folder = '/media/upload/video';
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
  <!-- Our Exceptional Solutions -->
  <div class="col-sm-12 col-md-4">
    <div class="margin-b-20">
      <div class="wow zoomIn" data-wow-duration=".3" data-wow-delay=".1s">
        <a rel="video-gallery-1" class="swipebox" href="<?php echo $provider.$vmedia['pub_video_id']; ?>" title="<?php echo $vmedia['title']?>">
        <img class="img-responsive" src="<?php echo $vidthumbsrc; ?>" alt="<?php echo $vmedia['title'] ?>"/>
        </a>
        <div>
        </div>
        <span class="overlay_filter"></span>
      </div>
    </div>
    <p class="color-base2"><?php echo $vmedia['title']?></p>
    <div class="clearfix"></div>
  </div>
  <?php } ?> 
</div>

<?php } ?> 