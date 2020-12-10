
<h2 class="with_line"><div><?php lang_string('wcat_live_title')?></div></h2>
<div class="clearfix"></div>
<div class="row row-eq-height margin-b-50">
  <?php
    while($cam = $select_cams->fetch_assoc()){
      $img               = $upload_folder.$cam['folder'].$cam['thumb_img'];
      $cam_name          = $cam['title'];
      $cam_city          = $cam['city'];
      $cam_description   = $cam['description'];
      $cam_id            = $cam['wcam_id'];
      //$cam_description   = $cam['descrioption'];
      
      if($cam['password']){
        $img               = $data['domain'].'/img/tn_mask.jpg';
      }
      
        //pr($cam);
        ?>
  <!-- Our Exceptional Solutions -->
  <div class="col-sm-12 col-md-4 margin-b-50">
    <div class="margin-b-20">
      <div class="wow zoomIn" data-wow-duration=".3" data-wow-delay=".1s">
      <a href="<?php echo webcam_url($cam_id,$cat_id)?>">
        <img class="img-responsive" src="<?php echo $img ?>" alt="<?php echo $cam_name ?>"/>
      </a>
        <div>
        </div>
        <span class="overlay_filter"></span>
      </div>
    </div>
    <h3><a href="<?php echo webcam_url($cam_id,$cat_id)?>"><?php echo $cam_name ?></a> <span class="text-uppercase margin-l-20"><?php echo $cam_city ?></span></h3>
    <p><?php echo limitStrlen($cam_description, 120); ?></p>
    <a class="link" href="<?php echo webcam_url($cam_id,$cat_id)?>"><?php lang_string('general_read_more')?></a>
  <div class="clearfix"></div></div>
  
  <!-- End Our Exceptional Solutions -->
  <?php }  ?>
</div>

<!--// end row -->

