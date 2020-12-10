<?php
  $get_vides = $mysqli->query("
      SELECT pub_video_id, featured, original_title, type, folder, thumb_img
      FROM evolve_video
      
      WHERE published = 1
        AND featured = 1
      ORDER BY evolve_video.id DESC
      LIMIT 10
      ");
   //if(!$promoted_wcams) print_r($mysqli->error);
  if($get_vides->num_rows > 0){
   $video_image_folder = '/media/upload/video';
   ?>
<div class="row margin-bottom-30">
  <div class="col-md-12 col-sm-12 ">
    <h2><?php lang('home_promoted_videos')?></h2>
    <div class="row">
      <?php if (get_ad('home_top2_left_aside')){ ?>
      <div class="col-md-3 col-sm-5 margin-b-30 home_top_left_aside">
        <?php echo get_ad('home_top2_left_aside') ?>
      </div>
      <div class="col-md-9 col-sm-7">
        <?php } else{?>
        <div class="col-md-12 col-sm-12">
          <?php } ?>
          <div class="owl-carousel owl-featured_video owl-theme">
          <?php while($vid = $get_vides->fetch_assoc()){
            if ($vid['type'] == 1){ 
              $provider = 'https://www.youtube.com/watch?v=';
            }elseif ($vid['type'] == 2){ 
              $provider = 'https://vimeo.com/';
            }
            $vidthumbsrc       = $data['domain'].$video_image_folder.$vid['folder'].$vid['thumb_img'];
            ?>
            <div class="item temp_hidden none">
              <a rel="video-gallery-home" class="swipebox" href="<?php echo $provider.$vid['pub_video_id']; ?>" title="<?php echo $vid['original_title']?>">
                <img src="<?php echo $vidthumbsrc; ?>" alt="Image" class="temp_hidden none"/>
              </a>
              <p><?php echo $vid['original_title'] ?></p>
            </div>

           <?php } ?>
          </div>
          

        </div>
    </div>
  </div>
</div>
<?php } ?>