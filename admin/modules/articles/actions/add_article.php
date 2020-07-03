<?php
define("ADMIN", true);
require_once("../../../../system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check


$lang_arr = json_decode(stripslashes($_POST['data']), true);

$rubruc_id = $_POST['rubric'];
$author_id = $_POST['userID'];

//CREATE NEW ARTICLE
$sql = $mysqli->query("  
  INSERT INTO evolve_articles (category, author) 
  VALUES ('$rubruc_id', '$author_id')      
");
	if($sql)
  {
    $id = $mysqli->insert_id; //Get ID of last inserted row from MySQL
    
    foreach($lang_arr as $slug ){
        $art_name = $slug['title'];
        $slug = $slug['slug'];
        $seo_id = seo_id($art_name);
        
        $check_seo_id = $mysqli->query("
          SELECT evolve_articles_data.*
          FROM evolve_articles_data
          WHERE evolve_articles_data.seo_id = '$seo_id'
        ");
        $check_seo = $check_seo_id->fetch_array(MYSQLI_BOTH);
    
        if($check_seo){
        $seo_id = $seo_id.time('timestamp');
        }
        
        $sql = $mysqli->query("  
          INSERT INTO evolve_articles_data (for_article, lang, seo_id, title) 
          VALUES ('$id', '$slug', '$seo_id', '$art_name')      
        ");
    }
    
    $response['load_new'] = $domain.'/admin/index.php?article='.$id;
    echo json_encode($response);
}

?>