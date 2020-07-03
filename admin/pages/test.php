<?php 
/*
$get_webcam = $mysqli->query("
    SELECT evolve_webcams.youtube
    FROM evolve_webcams
    
    order by id
  
  ");
  //if(!$get_webcam) print_r($mysqli->error);
  while ($webcam = $get_webcam->fetch_assoc()){
  if ($webcam['youtube']){
  //pr($webcam);
  $data_yt = $webcam['youtube'];
  if(strpos($data_yt, ',') !== false) {
        $explode_youtube = explode(',',$data_yt);
        $only_one_youtube = false;   
    } else {
        $youtube_id = $data_yt;
        $array[] = $data_yt;
        $only_one_youtube = true;
  }
   if (!$only_one_youtube){
   foreach ($explode_youtube as $youtube_id) {
    $array[] = $youtube_id;
    }

    } }  
}
$array = array_unique($array);
pr ($array);  

foreach ($array as $pub_video_id) {
  
  ////////////////////////////

$author_id           = 5;
$type                = 1;
$module_id           = 2;
$original_title      = get_video_title($pub_video_id, $type);

//CREATE NEW 
$sql = $mysqli->query("  
        INSERT INTO evolve_video (original_title, pub_video_id, author, type) 
        VALUES ('$original_title', '$pub_video_id', '$author_id', '$type')      
        ");

if($sql)//
{
  $vid_id               = $mysqli->insert_id; 
  $date                 = '/'.date('Y-m').'/';
  $cache_folder         = $to_root.'/media/cache/';
  $img                  = find_video_id(NULL, $pub_video_id, $type, 3); //get img url
  $video_folder_const   = "/media/upload/video$date";
  $video_media_dir      = $to_root.$video_folder_const;
  $fileName             = cache_image($img, $cache_folder);//get filename
  $exploded_filename    = explode(".",$fileName);//rename filename
  $extension            = end($exploded_filename);//rename filename
  $new_fileName         = $pub_video_id.'.'.$extension;//filename renamed
  
  cache_image($img, $cache_folder); //save image to cache folder
  
  if (!is_dir($video_media_dir)) { //make folder for video img
   mkdir($video_media_dir, 0777, true);
  }
  
  $get_dim_rel = $mysqli->query("
    SELECT evolve_dimensions_relations.*, evolve_dimensions_img.*
    FROM evolve_dimensions_relations
      
    LEFT JOIN evolve_dimensions_img
    ON evolve_dimensions_img.id = evolve_dimensions_relations.for_dimension
    WHERE evolve_dimensions_relations.for_module = '$module_id'
  ");
  $dimen                = $get_dim_rel->fetch_array(MYSQLI_BOTH);     
  $dim_id               = $dimen['for_dimension'];
//Dimension options
  $get_dimensions = $mysqli->query("
    SELECT evolve_dimensions_data.*
    FROM evolve_dimensions_data 
    WHERE evolve_dimensions_data.for_dimension = '$dim_id'
  ");
  while($dim = $get_dimensions->fetch_assoc()){ 
    $width                = $dim['width'];
    $height               = $dim['height'];
    $jpgquality           = $dim['quality'];
    $crop                 = $dim['crop'];
    $gray                 = $dim['gray'];
    $watermark            = '';
    $watermark_opacity    = '';
    $watermark_position   = '';
    $watermark_ratio      = '';
    if($dim['watermark_enable']){
      $watermark            = $to_root.$dim['watermark_folder'].$dim['watermark'];
      $watermark_opacity    = $dim['watermark_opacity'];
      $watermark_position   = $dim['watermark_position'];
      $watermark_ratio      = $dim['watermark_ratio'];
    }
    $src                  = $to_root.'/media/cache/'.$fileName;
    
    if($dim['type'] == 2){
      $prefix             = 'tn_';
      $thumb_name         = $prefix.$new_fileName;
    }else{
      $prefix             = '';
    }
    $dst = $video_media_dir.$prefix.$new_fileName;
    image_resize($src, $dst, $width, $height, $crop, $jpgquality, $gray, $watermark, $watermark_opacity, $watermark_position, $watermark_ratio);
  }  
  if (file_exists($src)) {
   unlink($src);
  }
    //check Thump name if exist
    $get_dim_thumb = $mysqli->query("
      SELECT evolve_dimensions_data.*
      FROM evolve_dimensions_data 
      WHERE evolve_dimensions_data.for_dimension = '$dim_id'
      and evolve_dimensions_data.type = 2 
    ");
    if ($get_dim_thumb->num_rows > 0){
      $prefix = 'tn_';
      $thumb_name = $prefix.$new_fileName;          
    }else{
      $prefix = '';
      $thumb_name = NULL;
    }
    //Update info in DB
    $sql = $mysqli->query("     
      UPDATE evolve_video
      SET 
     	folder                = '$date',
      image                 = '$new_fileName', 
      thumb_image           = '$thumb_name'
      WHERE id = '$vid_id' 
    ");
          

 
}
  
  
  
  ///////////////////////////
}
    
?>


    </div>*/
