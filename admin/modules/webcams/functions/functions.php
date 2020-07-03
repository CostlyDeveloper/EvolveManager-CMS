<?php function get_progress($webcam_id) {
  global $mysqli,$lang;
  $slugs_arr = languages();
  $t = '';
  $join = '';
  foreach($slugs_arr as $slug) {
    $lng = $slug['slug'];
    $t .= ', table_'.$lng.'.title, table_'.$lng.'.title as '.$lng.'_title'; //title
    $t .= ', table_'.$lng.'.description, table_'.$lng.'.description as '.$lng.'_description'; //description
    $t .= ', table_'.$lng.'.tagline, table_'.$lng.'.tagline as '.$lng.'_tagline'; //tagline
    $t .= ', table_'.$lng.'.content, table_'.$lng.'.content as '.$lng.'_content'; //content
    $t .= ', table_'.$lng.'.keywords, table_'.$lng.'.keywords as '.$lng.'_keywords'; //keywords
    $t .= ', table_'.$lng.'.seo_id, table_'.$lng.'.seo_id as '.$lng.'_seo_id'; //seo_id
    $join .= 'JOIN evolve_webcams_data as table_'.$lng.'
                    ON table_'.$lng.'.for_wcam = evolve_webcams.id 
                     AND table_'.$lng.'.lang =  "'.$lng.'"';
  }
  //echo $t;
  $query = $mysqli->query(" 
    SELECT evolve_webcams.id, evolve_webcams.gallery_id, evolve_webcams.city, evolve_webcams.category $t
      FROM evolve_webcams
      
      $join
      
      WHERE evolve_webcams.id = '$webcam_id'
    ");
  if(!$query)
    print_r($mysqli->error);
  if($query->num_rows > 0) {
    $row = $query->fetch_array(MYSQLI_ASSOC);
    $video = 0;
    if(get_video_items_nr($webcam_id,module_enabled('webcams'),2)) {
      $video = 1;
    }
    $fillfulled = count(array_filter($row)) - 1 + $video; // minus id value
    $all_vals = count($row); // minus row id value + row video from another table = 0
    $percentage = floor(($fillfulled / $all_vals) * 100);
    if($percentage < 30) {
      $class = 'danger';
    } elseif($percentage < 60) {
      $class = 'warning';
    } elseif($percentage < 100) {
      $class = 'info';
    } else {
      $class = 'success';
    } ?>
    <a data-toggle="tooltip" data-placement="top" title="">
      <div class="progress">
        <div class="progress-bar progress-bar-<?php echo $class ?>" data-transitiongoal="<?php echo $percentage; ?>"><?php echo $percentage; ?>%</div>
      </div>
    </a>
    <?php     //echo pr($row);
  }
}
function get_available_name($webcam_id) {
  global $mysqli;
  $query = $mysqli->query(" 
       SELECT evolve_webcams_data.*
       FROM evolve_webcams_data
       WHERE evolve_webcams_data.title != '' 
         AND evolve_webcams_data.for_wcam = '$webcam_id'
    ");
  if($query->num_rows > 0) {
    $row = $query->fetch_array(MYSQLI_BOTH);
    return $row['title'].' ('.$row['lang'].')';
  } else {
    return false;
  }
}
function get_selected_webcams($wcam_id,$cat_id) {
  global $mysqli,$default_language;
  $query = $mysqli->query("
   SELECT evolve_webcam_cat_relations.*
   FROM evolve_webcam_cat_relations
      
   WHERE evolve_webcam_cat_relations.for_webcam = '$wcam_id'
     AND evolve_webcam_cat_relations.for_cat = '$cat_id'
 ");
  if(!$query)
    print_r($mysqli->error);
  if($query->num_rows > 0) {
    echo 'selected';
  }
}
function webcam_cat_names($wcam_id) {
  global $mysqli,$default_language;
  $query = $mysqli->query("
   SELECT evolve_webcam_cat_relations.*, evolve_webcam_cat_data.*
   FROM evolve_webcam_cat_relations
    
   LEFT JOIN evolve_webcam_cat_data
   ON evolve_webcam_cat_data.for_instance_id = evolve_webcam_cat_relations.for_cat
     AND evolve_webcam_cat_data.lang =  '$default_language'
      
   WHERE evolve_webcam_cat_relations.for_webcam = '$wcam_id'
   ORDER BY evolve_webcam_cat_relations.priority DESC
 ");
  if($query->num_rows > 0) {
    $i = 0;
    $len = $query->num_rows;
    while($cat = $query->fetch_assoc()) {
      $title = $cat['title'];
      $comma = ', ';
      if($i == $len - 1) {
        $comma = ' ';
      }
      echo $title.$comma;
      $i++;
    }
  } else {
    return false;
  }
} ?>