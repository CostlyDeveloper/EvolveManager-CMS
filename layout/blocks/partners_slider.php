<?php
$get_main_slider = $mysqli->query("
    SELECT evolve_sliders.*, evolve_sliders_data.*, evolve_sliders.id as sid
    FROM evolve_sliders
    
    
    LEFT JOIN evolve_sliders_data
    ON evolve_sliders_data.for_instance = evolve_sliders.id
      AND evolve_sliders_data.lang =  '$language'
      
    WHERE evolve_sliders.published = 1
      AND evolve_sliders.for_instance = 2
      AND img IS NOT NULL 
      AND img != ''
    ORDER BY evolve_sliders.position ASC 
    ");
    if(!$get_main_slider) print_r($mysqli->error);
    $upload_folder          = $data['domain'].'/media/upload/sliders';        
  ?>
        <!-- Clients -->
            <div class="row margin-bottom-40 our-clients">
            <div class="col-md-3">
            <h2 class=""><?php lang('slider_partners_title')?></h2>
            <p><?php lang('slider_partners_paragraph')?></p>
            </div>
              <div class="col-md-9">
                <div class="owl-carousel owl-recommendation_home">
                    <?php
                    while($slide = $get_main_slider->fetch_assoc()){
                      $imgsrc       = $upload_folder.$slide['folder'].$slide['img'];
                      $thumb_imgsrc = $upload_folder.$slide['folder'].$slide['thumb_img'];
                    ?>
                    <div class="">
                    <?php if ($slide['uri'] OR $slide['url']){ ?>
                      <a href="<?php echo ($slide['url'] ? $slide['url'] : FRONTEND_URL.$slide['uri']) ?>">
                     <?php  } ?>
                        <img src="<?php echo $imgsrc ?>" class="img-responsive" alt="<?php echo $slide['title'] ?>">
                    <?php if ($slide['uri'] OR $slide['url']){ ?> 
                      </a>
                     <?php  } ?>
                    </div>
                    <?php  } ?>
                    </div>
                    <!-- End Swiper Wrapper -->
                </div>
                <!-- End Swiper Clients -->
            </div>
        <!-- End Clients -->