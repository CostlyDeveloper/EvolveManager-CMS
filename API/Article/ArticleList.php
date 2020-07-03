<?php

require_once("../../API/ApiSystem.php");

if (RequiredProps($request, ['seoID', 'Language'])) {

	$language = $mysqli->real_escape_string($request->Language);
	// $ID = $mysqli->real_escape_string($request->ID);
	$seoID = $mysqli->real_escape_string($request->seoID);

	$module_id = 4;
	$module_child = 2;
	if (!$seoID) {
		$expandSQL = '';
	} elseif ($seoID) {
		$expandSQL = "AND evolve_articles_data.seo_id = '$seoID'";
	} else {
		$expandSQL = '';
	}

	/* */
	$query = $mysqli->query("
    SELECT 
	        evolve_articles.date,
	        evolve_articles.author,
	        evolve_articles.last_edit_user,
	        evolve_articles.last_edit_time,
	        evolve_articles.published,
	        evolve_articles.show_date,
	        evolve_articles.show_author,
	        evolve_articles.show_cover_img,
	        evolve_articles.img,
	        evolve_articles.folder,
	        evolve_articles.thumb_img,
	        evolve_articles.category,
	        evolve_articles.featured,
	        evolve_articles.promoted,
	        evolve_articles.article_order,
	        evolve_articles.gallery_id,

           evolve_articles_data.seo_id,
           evolve_articles_data.title,
           evolve_articles_data.tagline,
           evolve_articles_data.description,
           evolve_articles_data.keywords,
	      evolve_articles.id as article_id,
	      evolve_articles_data.title as article_title
    FROM evolve_articles
    
        LEFT JOIN evolve_articles_data
        ON evolve_articles_data.for_article = evolve_articles.id
        AND evolve_articles_data.lang = '$language'
          
    
    
     	WHERE evolve_articles.published = 1
        $expandSQL
        ORDER BY evolve_articles.id DESC
    ");

	$prepareResponse = array();

	$upload_folder = $data['domain'] . module_media_folder($module_id);

	while ($row = $query->fetch_assoc()) {
		// $keywords = explode(',', $row['keywords'] );
		// $prepareResponse[] = $row;
		$prepareResponse[] = array(
			'DatePublished' => $row['show_date'] ? $row['date'] : null,
			'LastEdit' => $row['last_edit_time'],
			'AuthorName' => $row['show_author'] ? get_username($row['author'], 'full_name') : null,
			'Img' => $row['show_cover_img'] ? ($row['img'] ? $upload_folder . $row['folder'] . $row['img'] : null) : null,
			'ImgThumb' => $row['show_cover_img'] ? ($row['thumb_img'] ? $upload_folder . $row['folder'] . $row['thumb_img'] : null) : null,
			'SeoID' => $row['seo_id'],
			'CategoryIndex' => $row['category'],
			'Featured' => $row['featured'] ? true : false,
			'Preomoted' => $row['promoted'] ? true : false,
			'Ordinal' => $row['article_order'],
			'Title' => $row['title'],
			'Tagline' => $row['tagline'],
			'Description' => $row['description'],
			'Keywords' => explode(',', $row['keywords']),
			'Gallery' => get_gallery_object($row['gallery_id'], $language),
			'Video' => get_video_list_object($row['article_id'], $module_id, $module_child, $language),
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
