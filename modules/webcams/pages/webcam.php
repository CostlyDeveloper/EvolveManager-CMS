<?php 
//webcam
$get_webcam = $mysqli->query("
  SELECT evolve_webcams.*, evolve_webcams_data.*, evolve_webcams.id as webcam_id
  FROM evolve_webcams
    
  RIGHT JOIN evolve_webcams_data
  ON evolve_webcams_data.for_wcam = evolve_webcams.id
    AND evolve_webcams_data.lang =  '$language'
      
  WHERE evolve_webcams_data.seo_id = '$seo_id'
");

//if(!$get_webcam) print_r($mysqli->error);


//webcam
$webcam                 = $get_webcam->fetch_array(MYSQLI_ASSOC);
$gal_id                 = $webcam['gallery_id'];
$upload_folder          = $data['domain'].'/media/upload/webcams';
$cover_image            = $upload_folder.$webcam['folder'].$webcam['image'];
$module                 = 3;
$module_child           = 2;
$webcam_id              = $webcam['webcam_id'];
$preloader              = $data['domain'].'/img/preloader.gif'; 
$layout_path            = 'modules/webcams/layout/';
$layout_path_news       = 'modules/articles/layout/';
$locked                 = $webcam['password'];
recordPostPageView($webcam_id, 'evolve_webcams_visits'); // Store pageViews

 if ($locked){ 
    if(isset($_COOKIE['project_'.$webcam_id])){
      if ($webcam['password'] === $_COOKIE['project_'.$webcam_id]) {
      $locked = false;
      }
    }
 }

//Categories
 $select_cat = $mysqli->query("
   SELECT evolve_webcam_cat_data.*, evolve_webcam_cat.*, evolve_webcam_cat. id as cat_id, evolve_webcam_cat_relations.*
   FROM evolve_webcam_cat
    
   LEFT JOIN evolve_webcam_cat_data
   ON evolve_webcam_cat_data.for_instance_id = evolve_webcam_cat.id
     AND evolve_webcam_cat_data.lang = '$language'
     
   LEFT JOIN evolve_webcam_cat_relations
   ON evolve_webcam_cat_relations.for_cat = evolve_webcam_cat.id
     AND evolve_webcam_cat_relations.for_webcam = '$webcam_id'
   
   WHERE evolve_webcam_cat_relations.for_webcam = '$webcam_id'
   
   GROUP BY evolve_webcam_cat.id 
 ");
 
 //if(!$select_cat) print_r($mysqli->error);
 
  
 $categories           = array();
 $categories_data      = array();
   while($cat = $select_cat->fetch_assoc()){
   $categories[]       = '<a href="'.FRONTEND_URL.$cat['seo_id'].'" class="" target="_self">'.$cat['name'].'</a>';
   $categories_data[]  = $cat; 
 }
 //Related webcams 
 $related_webcams      = array();
   foreach ($categories_data as $cat){
     $related_webcams[] = webcams_from_same_category($cat['for_cat']);
   }
   $related_webcams = array_unique(array_flatten($related_webcams));
 // /Related webcams 
// /Categories 

//echo pr($webcam); ?>
<input type="hidden" name="page_title" value="<?php echo $webcam['title']; ?>" />
<div class="container">

<?php 



include(FRONTEND_PATH.$layout_path.'title_block.php'); ?>
  <div class="col-md-12 col-sm-12 col-xs-12 section-seperator margin-b-40">
  <!--  LEFT BLOCK 1  -->
    <div class="col-md-8 col-sm-8 col-xs-12 pull-left">
      <?php include(FRONTEND_PATH.$layout_path.'info_block.php'); ?>
    </div>
  <!--  /LEFT BLOCK 1  -->
  <!--  RIGHT BLOCK 1  -->
    <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
      <?php include(FRONTEND_PATH.$layout_path.'hostedby_block.php'); ?>
    </div>
  </div>
  <div class="clearfix"></div> 
<!--  /RIGHT BLOCK 1  -->
  <?php 
  if (!$locked){
    if ($webcam['history']){
      include(FRONTEND_PATH.$layout_path.'history.php');
    }else{
      include(FRONTEND_PATH.$layout_path.'live_cam.php');
    } 
  }//Locked - hide this
  ?>
</div>



<!-- media content -->

<div class="section-seperator main_bg">
  <div class="new_container container">
    <div class="row">
<!--  CENTERD BLOCK 1  -->
      <div class="col-md-12 col-sm-12 col-xs-12 section-seperator margin-b-40">
      <?php //include(FRONTEND_PATH.$layout_path.'featured_video.php'); ?>
      <?php if ($locked){include(FRONTEND_PATH.$layout_path.'locked_form.php');}//Locked - show form ?>
      <!-- VIDEO -->
      <?php if (!$locked){ include(FRONTEND_PATH.$layout_path.'video_carousel.php');}//Locked - hide this  ?>
      <!--/VIDEO -->
      <!-- DESCRIPTION BLOCK -->
      <?php include(FRONTEND_PATH.$layout_path.'description_block.php'); ?>
      <!-- /DESCRIPTION BLOCK -->
      <!-- GALLERY -->
      <?php if (!$locked){include(FRONTEND_PATH.$layout_path.'gallery_carousel.php');}//Locked - hide this ?>
      <!-- /GALLERY -->
      
      </div>
<!--  /CENTERD BLOCK 1  --> 
    
     <div class="col-md-12 col-sm-12 col-xs-12 section-seperator margin-b-40">
<!--  /LEFT BLOCK 2  -->
      <div class="col-md-8 col-sm-8 col-xs-12 pull-left">
      <!-- TABS BLOCK -->
      <?php //include(FRONTEND_PATH.$layout_path.'tabs_block.php'); ?>
      <?php include(FRONTEND_PATH.$layout_path.'related_webcams_block.php'); ?>
      <?php //include(FRONTEND_PATH.$layout_path.'promoted_webcams_block.php'); ?>
      <!-- /TABS BLOCK -->
      
      </div>
<!--  /LEFT BLOCK 2  -->
<!--  RIGHT BLOCK 2  -->      
      <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
        <!-- RELATED WEBCAMS BLOCK -->
        <?php include(FRONTEND_PATH.$layout_path.'webcam_categories.php'); ?>
        <!-- /RELATED WEBCAMS BLOCK -->
      
      </div>
<!--  /RIGHT BLOCK 2  --> 
    </div>
     <div class="col-md-12 col-sm-12 col-xs-12 section-seperator margin-b-40">
    <!-- Features block -->
    <?php include(FRONTEND_PATH.$layout_path_news.'promoted_news_block.php'); ?>
    <?php //include(FRONTEND_PATH.$layout_path.'features_block.php'); ?>
    <!-- /Features block -->
    </div>
</div>
  </div>
</div>
<!-- /media content -->

<?php if (evolveAllow('4')){ ?>
<a href="<?php echo $data['domain'].'/admin/index?webcam='.$webcam_id ?>" target="_blank" class="float btn btn-primary">
<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
</a>
<?php } ?>
      