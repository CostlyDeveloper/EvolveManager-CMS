 <?php

//article
$get_article = $mysqli->query("
  SELECT evolve_articles.*, evolve_articles_data.*, evolve_articles.id as art_id
  FROM evolve_articles
    
  RIGHT JOIN evolve_articles_data
  ON evolve_articles_data.for_article = evolve_articles.id
      
  WHERE evolve_articles_data.seo_id = '$instance_seo_id'
");

//if(!$get_article) print_r($mysqli->error);
$row                 = $get_article->fetch_array(MYSQLI_ASSOC);
$category            = $row['category'];
$article_type        = article_type($row['category']);
$module_path         = FRONTEND_PATH.'modules/articles/';
$upload_folder       = $data['domain'].'/media/upload/articles';
$layout_path         = 'modules/articles/layout/';
$art_id              = $row['art_id'];
$module_id           = 4;
$module_child        = 2;
$gal_id              = $row['gallery_id'];

$cover_image = '';
if($row['img'] && $row['show_cover_img']){
  $cover_image         = $upload_folder.$row['folder'].$row['img'];
} 
 set_website_head(lang_return('website_title').' | '.$row['title'], $row['description'], $cover_image, '', '', '');
 include($module_path.'layout/'.$article_type.'/article.php'); ?>
 
 <?php if (evolveAllow($data_user_id, $module_id)){ ?>
<a href="<?php echo $data['domain'].'/admin/index.php?article='.$art_id ?>" target="_blank" class="float btn btn-primary">
<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
</a>
<?php } ?>