

<?php 
  //webcam
  $get_webcam_cat = $mysqli->query("
    SELECT evolve_webcam_cat.*, evolve_webcam_cat_data.*, evolve_webcam_cat.id as cat_id
    FROM evolve_webcam_cat
      
    RIGHT JOIN evolve_webcam_cat_data
    ON evolve_webcam_cat_data.for_instance_id = evolve_webcam_cat.id
      AND evolve_webcam_cat_data.lang =  '$language'
        
    WHERE evolve_webcam_cat_data.seo_id = '$seo_id'
  ");
  //webcam
  //if(!$get_webcam_cat) print_r($mysqli->error); 
  
  $cat                    = $get_webcam_cat->fetch_array(MYSQLI_ASSOC);
  $module                 = 3;
  $module_child           = 1;
  $upload_folder          = $data['domain'].'/media/upload/webcams';
  $cover_image            = $upload_folder.$cat['folder'].$cat['image'];
  $cat_id                 = $cat['cat_id'];
  
  $select_cams = $mysqli->query("
   SELECT evolve_webcams.*, evolve_webcams_data.*, evolve_webcam_cat_relations.*, evolve_webcams.id as wcam_id
   FROM evolve_webcams
    
   LEFT JOIN evolve_webcams_data
   ON evolve_webcams_data.for_wcam = evolve_webcams.id
     AND evolve_webcams_data.lang = '$language'
     
   LEFT JOIN evolve_webcam_cat_relations
   ON evolve_webcam_cat_relations.for_webcam = evolve_webcams.id
   
   WHERE evolve_webcam_cat_relations.for_cat = '$cat_id'
     AND evolve_webcams_data.seo_id != ''
   
   GROUP BY evolve_webcams.id 
  ");  
  //if(!$select_cams) print_r($mysqli->error);
  
  ?>
<!--========== PARALLAX ==========-->
<div class="margin-b-20">
  <div class="container">
    <!--========== TITLE BLOCK ==========-->
    <?php include(FRONTEND_PATH.'modules/webcams/layout/category_title_block.php'); ?>
    <!--========== /TITLE BLOCK ==========-->
    <p><?php echo $cat['description']?></p>
  </div>
</div>
<!--========== /PARALLAX ==========-->
<!--========== PAGE LAYOUT ==========-->
<!-- Our Exceptional Solutions -->
<div class="container">
  <div class="row margin-b-40">
    <!--==========  CENTERD BLOCK 1  ==========-->
    <div class="col-md-12 col-sm-12 col-xs-12">
      <?php include(FRONTEND_PATH.'modules/webcams/layout/category_featured_video.php'); ?>
      <?php include(FRONTEND_PATH.'modules/webcams/layout/category_live_projects.php'); ?>
    </div>
    
    <!--==========  /CENTERD BLOCK 1  ==========-->  
  </div>

</div>
<!-- End Our Exceptional Solutions -->
<!--========== END PAGE LAYOUT ==========-->

