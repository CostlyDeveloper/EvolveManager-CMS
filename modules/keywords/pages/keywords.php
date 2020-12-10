<?php
/*
echo $keyword_seo;

//article
$get_article = $mysqli->query("
  SELECT evolve_articles_data.keywords
  FROM evolve_articles_data
  
  WHERE keywords LIKE '$keyword_seo,' 
    OR keywords LIKE ',$keyword_seo'
    OR keywords LIKE ',$keyword_seo,' 
    AND evolve_articles_data.lang =  '$language'
  
");

if(!$get_article) print_r($mysqli->error);

$row                 = $get_article->fetch_array(MYSQLI_ASSOC);

pr($row);

*/
?>