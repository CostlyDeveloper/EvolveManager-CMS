<?php
  $wcam_folder       = $data['domain'].'/media/upload/webcams';
  $promoted_wcams = $mysqli->query("
       SELECT 
       evolve_webcams_data.title,
       evolve_webcams_data.for_wcam,
       evolve_webcams.folder,
       evolve_webcams.thumb_img
        
       FROM evolve_webcams
       
       INNER JOIN evolve_webcams_data
       ON evolve_webcams_data.for_wcam = evolve_webcams.id
         AND evolve_webcams_data.lang =  '$language'
         
       WHERE evolve_webcams.published = '1'
         AND evolve_webcams.promoted = '1'
       ORDER BY evolve_webcams.date_start DESC
       
       LIMIT 8
       ");
  ?>

<!-- BEGIN RECENT NEWS --> 
            <div class="col-md-12 col-sm-12 margin-b-40">
              <h4><?php lang('home_promoted_projects')?></h4>
              <div class="row">
                <?php
                  while($wcams = $promoted_wcams->fetch_assoc()){
                  $item_id             = $wcams['for_wcam'];
                  $thumb_imgsrc   = $wcam_folder.$wcams['folder'].$wcams['thumb_img'];
                  if(!$wcams['thumb_img']){
                    $thumb_imgsrc   = FRONTEND_URL.'/media/upload/site/'.$data['og_thumb_img'];
                  }
                
                  ?>
                <div class="margin-b-5 section-seperator ">
                  <div class="col-md-5 col-sm-5 col-xs-5 row margin-b-5">
                    <div class="wow zoomIn" data-wow-duration=".3" data-wow-delay=".1s">
                      <a href="<?php echo webcam_url($item_id) ?>">
                      <img class="img-responsive" alt="<?php echo $wcams['title'] ?>" src="<?php echo $thumb_imgsrc ?>" />
                      </a>
                    </div>
                  </div>
                  <div class="col-md-7 col-sm-7 col-xs-7 margin-b-5">
                    <h5><?php echo $wcams['title'] ?></h5>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <?php } ?>
              </div>
            </div>
