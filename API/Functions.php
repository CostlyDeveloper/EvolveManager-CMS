<?php

function RequiredProps($request, $arrayOfRequiredProps)
{
	$counterA = 0;
	$counterB = 0;

	foreach ($arrayOfRequiredProps as $RequiredProp) {

		$counterA += property_exists($request, $RequiredProp) ? 1 : 0;
		$counterB += 1;
	}

	if ($counterA === $counterB) {
		return true;
	} else {
		return false;
	}

}

function cors()
{

	if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS' || $_SERVER['REQUEST_METHOD'] === 'POST') {
	} else
		die();

	// Allow from any origin
	if (isset($_SERVER['HTTP_ORIGIN'])) {
		// Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
		// you want to allow, and if so:
		header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Max-Age: 86400');    // cache for 1 day
	}

	// Access-Control headers are received during OPTIONS requests
	if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

		if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
			// may also be using PUT, PATCH, HEAD etc
			header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");

		if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
			header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

		exit(0);
	}
}

/****/

//GET USERNAME
function get_username($user_id, $type = false)
{
	global $mysqli;
	//Find items then decrease num in gallery
	$find_user = $mysqli->query(" 
            SELECT evolve_users.*
            FROM evolve_users       
            WHERE evolve_users.id = '$user_id'
            ");
	$user = $find_user->fetch_array(MYSQLI_ASSOC);

	if ($type = 'first_name') {
		return $user['first_name'];
	} elseif ($type = 'last_name') {
		return $user['last_name'];
	} elseif ($type = 'full_name') {
		return $user['first_name'] . ' ' . $user['last_name'];
	} elseif ($type = 'email') {
		return $user['email'];
	} else {
		return false;
	}

}

//GALLERY BY ID
function get_gallery_object($gal_id, $lang)
{
	global $mysqli, $data;

	$query = $mysqli->query("
        SELECT evolve_gallery_items.*, evolve_media_alt.*
		  FROM evolve_gallery_items  
		  
		  LEFT JOIN evolve_media_alt
		  ON evolve_media_alt.for_media = evolve_gallery_items.media_id
		    AND evolve_media_alt.for_lang =  '$lang'
		  WHERE evolve_gallery_items.gallery_id = '$gal_id' 
		  ORDER BY evolve_gallery_items.order_position DESC
    ");
	if (!$query->num_rows) {
		return false;
	}
	$prepareResponse = array();
	while ($row = $query->fetch_assoc()) {

		$prepareResponse[] = array(
			'Img' => $row['filename'] ? $data['domain'] . $row['folder'] . $row['filename'] : null,
			'ImgThumb' => $row['thumb'] ? $data['domain'] . $row['folder'] . $row['thumb'] : null,
			'AltText' => $row['content'],
			'Ordinal' => $row['order_position'],
		);
	}
	return $prepareResponse;

}

//GALLERY BY ID
function get_video_list_object($instance_id, $module_id, $module_child, $language)
{
	global $mysqli, $data;

	$query = $mysqli->query("
    SELECT evolve_video_relations.*
    FROM evolve_video_relations
      
    WHERE for_instance = '$instance_id'
      and for_module = '$module_id'
      and for_module_child = '$module_child'
    ORDER BY position ASC
    ");
	if (!$query->num_rows) {
		return false;
	}
	$prepareResponse = array();
	while ($row = $query->fetch_assoc()) {
		$prepareResponse[] = get_video_item($row['video_id'], $language);
	}
	return $prepareResponse;

}


function get_video_item($video_id, $language)
{
	global $mysqli, $data;

	$upload_folder = $data['domain'] . module_media_folder(2);

	$query = $mysqli->query("
      SELECT evolve_video.*, evolve_video_data.*
      FROM evolve_video
          
      LEFT JOIN evolve_video_data
      ON evolve_video_data.for_video = evolve_video.id
        AND evolve_video_data.for_lang =  '$language'
        
      WHERE evolve_video.id = '$video_id'
		AND evolve_video.published = 1
      ");

	$row = $query->fetch_array(MYSQLI_ASSOC);

	if ($row['type'] == 1) {
		$provider = 'https://www.youtube.com/watch?v=';
	} elseif ($row['type'] == 2) {
		$provider = 'https://vimeo.com/';
	}

	$prepareResponse = array(
		'Img' => $row['image'] ? $upload_folder . $row['folder'] . $row['image'] : null,
		'ImgThumb' => $row['thumb_img'] ? $upload_folder . $row['folder'] . $row['thumb_img'] : null,
		'Title' => $row['title'],
		'ProviderTitle' => $row['original_title'],
		'Featured' => $row['featured'] ? true : false,
		'CreatedDate' => $row['date'],
		'Video' => $provider.$row['pub_video_id']
	);

	return $prepareResponse;
}

