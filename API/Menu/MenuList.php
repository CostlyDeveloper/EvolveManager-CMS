<?php

require_once("../../API/ApiSystem.php");

if (RequiredProps($request, ['ID', 'Language'])) {

	$language = $mysqli->real_escape_string($request->Language);
	$ID = $mysqli->real_escape_string($request->ID);
	$module_id = 10;
	$module_child = '';

	$ID = (int)$ID;
	if ($ID === 0) {
		$expandSQL = '';
	} elseif (is_int($ID)) {
		$expandSQL = 'AND evolve_menus_relations.id = ' . $ID;
	} else {
		$expandSQL = '';
	}

	$query = $mysqli->query("
     SELECT evolve_menus_relations.*,
            evolve_menus_data.uri,
            evolve_menus_data.url,
            evolve_menus_data.name,
            evolve_menus_relations.id as item_id,
            evolve_menus_relations.for_instance as menu_id
     
        FROM evolve_menus_relations
        LEFT JOIN evolve_menus_data
        ON evolve_menus_data.for_instance = evolve_menus_relations.id
        WHERE evolve_menus_data.lang = '$language'
        ORDER BY evolve_menus_relations.position
    ");

	$prepareResponse = array();

	//$upload_folder = $data['domain'] . module_media_folder($module_id);

	while ($row = $query->fetch_assoc()) {
		// $prepareResponse[] = $row;
		$prepareResponse[] = array(
			'Label' => $row['name'],
			'MenuIndex' => $row['menu_id'],
			'ItemIndex' => $row['item_id'],
			'NestedLevel' => $row['level'],
			'HaveChild' => $row['have_child'] ? true : false,
			'Url' => $row['url'] ? $row['url'] : $row['uri'] ? $row['uri'] : null,
			'Ordinal' => $row['position']
		);


	}
	/*pr($row);*/
    //pr($prepareResponse);


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
