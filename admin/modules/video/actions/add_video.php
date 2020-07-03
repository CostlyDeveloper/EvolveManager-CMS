<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root . "/system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])) {
	die_500();
}
security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check

$url = $_POST['videoURL'];
$author_id = $_POST['userID'];
$type = $_POST['pub_type_id'];
$module_id = $_POST['moduleID'];
$pub_video_id = find_video_id($url, NULL, $type, 1);
$original_title = get_video_title($pub_video_id, $type);

//CREATE NEW 
$sql = $mysqli->query("  
  INSERT INTO evolve_video (original_title, pub_video_id, author, type) 
  VALUES ('$original_title', '$pub_video_id', '$author_id', '$type')      
");
if ($sql)//
{

	$vid_id = $mysqli->insert_id;
	$date = '/' . date('Y-m') . '/';
	$cache_folder = $to_root . '/media/cache/';
	$img = find_video_id(NULL, $pub_video_id, $type, 3); //get img url
	$video_folder_const = "/media/upload/video";
	$video_media_dir = $to_root . $video_folder_const;
	$fileName = cache_image($img, $cache_folder);//get filename
	$exploded_filename = explode(".", $fileName);//rename filename
	$extension = end($exploded_filename);//rename filename
	$new_fileName = $pub_video_id . '.' . $extension;//filename renamed

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
	$dimen = $get_dim_rel->fetch_array(MYSQLI_BOTH);
	$dim_id = $dimen['for_dimension'];
//Dimension options
	$get_dimensions = $mysqli->query("
    SELECT evolve_dimensions_data.*
    FROM evolve_dimensions_data 
    WHERE evolve_dimensions_data.for_dimension = '$dim_id'
  ");
	while ($dim = $get_dimensions->fetch_assoc()) {
		$width = $dim['width'];
		$height = $dim['height'];
		$jpgquality = $dim['quality'];
		$crop = $dim['crop'];
		$gray = $dim['gray'];
		$watermark = '';
		$watermark_opacity = '';
		$watermark_position = '';
		$watermark_ratio = '';
		if ($dim['watermark_enable']) {
			$watermark = $to_root . $dim['watermark_folder'] . $dim['watermark'];
			$watermark_opacity = $dim['watermark_opacity'];
			$watermark_position = $dim['watermark_position'];
			$watermark_ratio = $dim['watermark_ratio'];
		}
		$src = $to_root . '/media/cache/' . $fileName;

		if ($dim['type'] == 2) {
			$prefix = 'tn_';
			$thumb_name = $prefix . $new_fileName;
		} else {
			$prefix = '';
		}
		$dst = $video_media_dir . $prefix . $new_fileName;
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
	if ($get_dim_thumb->num_rows > 0) {
		$prefix = 'tn_';
		$thumb_name = $prefix . $new_fileName;
	} else {
		$prefix = '';
		$thumb_name = NULL;
	}
	//Update info in DB
	$sql = $mysqli->query("     
      UPDATE evolve_video
      SET 
      folder                = '$date',
      image                 = '$new_fileName', 
      thumb_img             = '$thumb_name',
      published             = 1
      WHERE id = '$vid_id' 
    ");

	$urlToNew = $domain . $video_folder_const . $prefix . $fileName;

// /DOWNLOAD IMAGE
	$response['load_video_url'] = $domain . '/admin/index.php?video=' . $vid_id;
	echo json_encode($response);
}
?>
