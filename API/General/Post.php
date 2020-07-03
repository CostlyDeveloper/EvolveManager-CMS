<?php

require_once("../../API/ApiSystem.php");


if (RequiredProps($request, ['ID', 'Language'])) {

	$language = $mysqli->real_escape_string($request->Language);
	$ID = $mysqli->real_escape_string($request->ID);

	$ID = (int)$ID;
	if ($ID === 0) {
		$expandSQL = '';
	} elseif (is_int($ID)) {
		$expandSQL = 'AND evolve_sliders.id = ' . $ID;
	} else {
		$expandSQL = '';
	}

	$query = $mysqli->query("
    SELECT evolve_sliders.*, evolve_sliders_data.*
    FROM evolve_sliders
        
    LEFT JOIN evolve_sliders_data
    ON evolve_sliders_data.for_instance = evolve_sliders.id
        
    WHERE evolve_sliders.published = 1
      AND evolve_sliders.for_instance = 1
      $expandSQL
      AND evolve_sliders_data.lang = '$language'
      AND img IS NOT NULL 
      AND img != ''
    ORDER BY evolve_sliders.position ASC 
    ");

	$prepareResponse = array();

	$upload_folder = $data['domain'] . module_media_folder(5);

	while ($row = $query->fetch_assoc()) {

		$prepareResponse[] = array(
			'Title' => $row['title'],
			'Tagline' => $row['tagline'],
			'Description' => $row['description'],
			'Url' => $row['url'] ? $row['url'] : $row['uri'] ? FRONTEND_URL . $row['uri'] : null,
			'Name' => $row['name'],
			'Img' => $row['img'] ? $upload_folder . $row['folder'] . $row['img'] : null,
			'ImgThumb' => $row['thumb_img'] ? $upload_folder . $row['folder'] . $row['thumb_img'] : null,
			'Ordinal' => $row['position'],

		);
		/*	pr($row);
			pr($prepareResponse);*/
	}

	$query->close();
	$mysqli->close();
} else {
	$post->Code = '002';
	$ses_id = null;
	$prepareResponse = null;
}


$message = new ResponseMessage($post->Code, $post->Title, $post->Message);
$response_object = new Response($prepareResponse, $message, $ses_id);
echo json_encode($response_object);

?>

