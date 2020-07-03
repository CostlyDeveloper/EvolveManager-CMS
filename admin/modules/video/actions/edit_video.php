<?php define("ADMIN",true);
require_once ("../../../../system/config.php");

  if(!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); }
  security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
  evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check

if(isset($_POST['instanceID'])) {
  $video_id       = $mysqli->real_escape_string($_POST['instanceID']);
  $user_id        = $mysqli->real_escape_string($_POST['userID']);
  $original_title = $mysqli->real_escape_string($_POST['original_title']);
  //VIDEO DATA - MULTILANG
  $slugs_arr = languages();
  
  foreach($slugs_arr as $slug) {
    $slug = $slug['slug'];
    $videoTitle = $mysqli->real_escape_string($_POST['videoTitle_'.$slug]);
    if($videoTitle) {
      $unique = $mysqli->query("
        CREATE UNIQUE INDEX vid_index 
        ON evolve_video_data (for_video,for_lang)
      ");
      //if(!$unique) print_r($mysqli->error);
      $sql = $mysqli->query("  
        INSERT INTO evolve_video_data (for_video, for_lang, title) 
        VALUES ('$video_id', '$slug', '$videoTitle')
        ON DUPLICATE KEY UPDATE
        title               = '$videoTitle'  
      ");
      $unique = $mysqli->query("
        ALTER TABLE evolve_video_data
        DROP INDEX vid_index;
      ");
    } else { //DELETE LANG ROW IF TITLE IS MISSING
      $sql = $mysqli->query("
        DELETE FROM evolve_video_data 
        WHERE for_video = '$video_id' AND for_lang = '$slug'
      ");
    }
  }
  // /$_POST DATA - MULTILANG
  //VIDEO INFO
  //Checkboxed
  if(isset($_POST['published'])) {
    $published = 1;
  } else {
    $published = 0;
  }
  if(isset($_POST['featured'])) {
    $featured = 1;
  } else {
    $featured = 0;
  }
  $url = $_POST['videoURL'];
  $type = $mysqli->real_escape_string($_POST['typeID']);
  $pub_video_id = find_video_id($url,NULL,$type,1);
  $sql = $mysqli->query("     
    UPDATE evolve_video
    SET 
    original_title        = '$original_title',
    published             = '$published',
    featured              = '$featured',
    pub_video_id          = '$pub_video_id'
    WHERE id = '$video_id' ");
  //if(!$sql)    print_r($mysqli->error);
  // /ARTICLE INFO
  //render response data in JSON format
  //json_encode($response);
} ?>