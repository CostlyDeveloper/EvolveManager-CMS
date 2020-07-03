<?php

$fileContent = json_decode(file_get_contents('php://input'));

$post = new Request($fileContent->Request);
$request = json_decode($post->Request);
