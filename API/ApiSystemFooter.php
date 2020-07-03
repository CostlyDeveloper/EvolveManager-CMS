<?php
$response = $prepareResponse;
$message = new ResponseMessage($post->Code, $post->Title, $post->Message);
$response_object = new Response($response, $message, $ses_id);


echo json_encode($response_object);


$query->close();
$mysqli->close();
