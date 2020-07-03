<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");
  
  if(!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } 
  security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
  evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check
  
if(isset($_POST["videoID"])){
  
  $video_id             = $_POST["videoID"];
  $module_id            = $_POST["moduleID"];
  $child_module_id      = '';
  if(isset($_POST["chmoduleID"])){
  $child_module_id      = $_POST["chmoduleID"];
  }
  $instance_id          = $_POST["instanceID"];
  
  $video_info = $mysqli->query("
    SELECT evolve_video.*, evolve_video.id as video_id
      FROM evolve_video

      WHERE evolve_video.id = '$video_id'
      
      GROUP BY evolve_video.id
    "); 
  $vid                  = $video_info->fetch_array(MYSQLI_BOTH);
  $unique_id            = $instance_id.$module_id.$child_module_id.$video_id;
  if ($video_info->num_rows > 0) {
    $sql = $mysqli->query("  
      INSERT INTO evolve_video_relations (video_id, for_instance, for_module, for_module_child, unique_id) 
      VALUES ('$video_id', '$instance_id', '$module_id', '$child_module_id', '$unique_id')      
    ");
    //if(!$sql) print_r($mysqli->error);
  ?>
  <li data-id="<?php echo $video_id; ?>" class="selected_video_li alert alert-info alert-dismissible fade in" role="alert">
    <div class="col-xs-3 col-md-2 pull-right">
      <button data-id="<?php echo $video_id; ?>" type="button" class="vid_close close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
      <input type="hidden" name="vid_id" value="<?php echo $video_id ?>" />
      <a href="index.php?video=<?php echo $video_id; ?>" target="_blank" class="close"><i class="fa fa-pencil small_ico" aria-hidden="true"></i></a>
    </div>
    <div class="col-xs-3 col-md-2 pull-left">
      <div class="text-left pull-left"><?php echo $video_id; ?></div>
      <div class="text-left pull-right"><i class="fa fa-arrows"></i></div>
    </div>
    <div class="col-xs-10 col-md-8">
    <strong> <?php echo $vid['original_title'] ?></strong> 
    </div>
    <div class="clearfix"></div>
  </li>
<?php
}
}
elseif(isset($_POST["focus"])){//SHOW LAST 10 ON FOCUS
  $module_id            = $_POST["moduleID"];
  $instance_id          = $_POST["instanceID"];
  $child_module_id      = '';
  if(isset($_POST["chmoduleID"])){
    $child_module_id      = $_POST["chmoduleID"];
  }
    
  $result_array = $mysqli->query("
    SELECT evolve_video.*, evolve_video.id as vid_id
    FROM evolve_video
        
    GROUP BY evolve_video.id
    
    ORDER BY evolve_video.id DESC
    LIMIT 10
    "); 

    //print_r($result_array);
   
    if ($result_array->num_rows > 0) {
     foreach ($result_array as $result) {
       $unique_id            = $instance_id.$module_id.$child_module_id.$result['vid_id'];
       if(video_relation($unique_id)) {
         ?>
         <li class="result">
           <div data-id="<?php echo $result['vid_id'] ?>" class="video_res"><?php echo $result['original_title'] ?></div>
         </li> 
         <?php
       }
     }
   }
   else{
     ?>
     <li class="result"><div><?php echo $lang['no_results'] ?></div></li>
     <?php
   }
// /SHOW LAST 10 ON FOCUS     
}else{
//DO SEARCH  
  $html  = '';
  $html .= '<li class="result">';
  $html .= '<div data-id="vid_id" class="video_res">nameString</div>';
  $html .= '</li>';
  //$search_string = preg_replace("/[^A-Ža-ž0-9]/", " ", $_POST['query']);
  $search_string = $_POST['query'];
  $module_id            = $_POST["moduleID"];
  $instance_id          = $_POST["instanceID"];
  $child_module_id      = '';
  if(isset($_POST["chmoduleID"])){
    $child_module_id      = $_POST["chmoduleID"];
  }
  // Check Length More Than One Character
  if (strlen($search_string) >= 1 && $search_string !== ' ') {

    $result_array = $mysqli->query("
      SELECT evolve_video.*, evolve_video.id as video_id
      FROM evolve_video 
     
      WHERE evolve_video.original_title LIKE '%$search_string%' 
    "); 
        
    
    if ($result_array->num_rows > 0) {
     foreach ($result_array as $result) {
      $unique_id            = $instance_id.$module_id.$child_module_id.$result['video_id'];
       if(video_relation($unique_id)) {
       // Format Output Strings And Hightlight Matches
    	 $display_name = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['original_title']);
    	 // Insert Name
    	 $output = str_replace('nameString', $display_name, $html);
       $output = str_replace('vid_id', $result['video_id'], $output);
      
       // Output
       echo($output);
       }
      }
        
    }else{
      // Format No Results Output
    	$output = str_replace('class="video_res">nameString</div>', '>'.$lang['no_results'].'</div>', $html);
    
    	// Output
    	echo($output);
    }
  }
}// /DO SEARCH  
//OR ($rel_for_instance.$rel_for_module.$rel_vid_id == 000)
?>

