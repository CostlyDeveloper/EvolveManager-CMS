<?php


$array = implode("','",$related_webcams);      
   
$get_webcams = $mysqli->query("
  SELECT evolve_webcams.*, evolve_webcams_data.*, evolve_webcams.id as webcam_id
  FROM evolve_webcams
    
  RIGHT JOIN evolve_webcams_data
  ON evolve_webcams_data.for_wcam = evolve_webcams.id
    AND evolve_webcams_data.lang =  '$language'
    
      
  WHERE evolve_webcams.id IN ('$array')
");         

while($relcams = $get_webcams->fetch_assoc()){
$relmedia[] = $relcams;
}
shuffle($relmedia);// SHUFFLE GALLERY -- RANDOM ORDER
$chunked = array_chunk($relmedia, 4); 
?>
<div class="x_panel">
  <div class="x_title">
    <h4 class="pull-left" ><?php lang_string('webcams_related')?></h4>
    <div class="pull-right put_on_top margin_t10">
      <button type="button" id="rpc_btn_prev" class="btn btn-xs"><span class="glyphicon glyphicon-chevron-left"></span></button>
      <button type="button" id="rpc_btn_next" class="btn btn-xs"><span class="glyphicon glyphicon-chevron-right"></span></button>
    </div>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <div class="rel_projects_carousel carousel slide" data-ride="carousel">
      <!-- Carousel items -->
      <div class="carousel-inner"> 
        <?php              
        foreach($chunked as $key => $chunk) {
          $class = '';
          if( $key == 0){
            $class = 'active';
          }?>
        <div class="item <?php echo $class; ?> visible_gallery">
            <?php
            foreach($chunk as $relmedia) {
              $thumbsrc = $upload_folder.$relmedia['folder'].$relmedia['thumb_img'];
              if($relmedia['password']){
                  $thumbsrc               = $data['domain'].'/img/tn_mask.jpg';
                }
              ?>
              <div class="col-md-6 col-xs-6 rel_projects">
                <div class="inner_item_rel">
                  <a href="<?php echo $relmedia['seo_id']; ?>" class="lazyload_parent" title="<?php echo $relmedia['title']?>" >
                    <img class="lazyload sepia" src="<?php echo $preloader; ?>" data-src="<?php echo $thumbsrc; ?>" alt="Image" style="max-width:100%;"/>
                    <div class="img_title">
                      <h3>
                      <?php echo limitStrlen($relmedia['title'], 24); ?>
                      </h3>
                    </div>
                    <span class="overlay_filter grad_dark"></span>
                  </a>
                  
                </div>
              </div>
            <?php } ?>
        
        </div><!--.item-->
        <?php } ?>
      </div><!--.carousel-inner-->
    </div><!--.Carousel-->
    </div>
    <div class="clearfix"></div>
  </div>
