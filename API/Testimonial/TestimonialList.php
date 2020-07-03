<?php

require_once("../../API/ApiSystem.php");

if (RequiredProps($request, ['ID', 'Language'])) {

	$language = $mysqli->real_escape_string($request->Language);
	$ID = $mysqli->real_escape_string($request->ID);
	$module_id = 14;
	$module_child = '';


	$ID = (int)$ID;
	if ($ID === 0) {
		$expandSQL = '';
	} elseif (is_int($ID)) {
		$expandSQL = 'AND evolve_testimonials.id = ' . $ID;
	} else {
		$expandSQL = '';
	}

	$query = $mysqli->query("
    SELECT 
           evolve_testimonials.for_instance as cat_index,
           evolve_testimonials.name,
           evolve_testimonials.img,
           evolve_testimonials.thumb_img,
           evolve_testimonials.folder,
           evolve_testimonials.position,
           evolve_testimonials_data.occupation,
           evolve_testimonials_data.job_title,
           evolve_testimonials_data.city,
           evolve_testimonials_data.message,
           evolve_testimonials_data.web_name,
           evolve_testimonials_data.web_url,
           evolve_testimonials_data.rating
    FROM evolve_testimonials
    
    LEFT JOIN evolve_testimonials_data
    ON evolve_testimonials_data.for_instance = evolve_testimonials.id
    
    WHERE evolve_testimonials.published = 1
      $expandSQL
   
    ORDER BY  evolve_testimonials.position ASC
    ");

	$prepareResponse = array();

	$upload_folder = $data['domain'] . module_media_folder($module_id);

	while ($row = $query->fetch_assoc()) {
		 //$prepareResponse[] = $row;
		$prepareResponse[] = array(
			'CriticName' => $row['name'],
			'CriticComment' => $row['message'],
			'CriticLocation' => $row['city'],
			'CriticJobTitle' => $row['job_title'],
			'CriticOccupation' => $row['occupation'],
			'CriticWebName' => $row['web_name'],
			'CriticWebUrl' => $row['web_url'],
			'Rating' => $row['rating'],
			'CategoryIndex' => $row['cat_index'],
			'Ordinal' => $row['position'],
		    'Img' => $row['img'] ? $upload_folder . $row['folder'] . $row['img'] : null,
			'ImgThumb' => $row['thumb_img'] ? $upload_folder . $row['folder'] . $row['thumb_img'] : null,
		);


	}
	/*pr($row);*/
   // pr($prepareResponse);


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
