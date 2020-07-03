<?php
define("ADMIN", true);
require_once("../../../../system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])) {
    die_500();
}
security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check


$lang_arr = json_decode(stripslashes($_POST['data']), true);


$table_item = 'evolve_cd_cody_licences';
$table_data = 'evolve_cd_cody_licences_data';
$get_string = 'cd_cody_licence_edit';

$category_id = $_POST['category'];
$author_id = $_POST['userID'];

//CREATE NEW ITEM
$sql = $mysqli->query("  
  INSERT INTO $table_item (category, author) 
  VALUES ('$category_id', '$author_id')      
");
if ($sql) {
    $id = $mysqli->insert_id; //Get ID of last inserted row from MySQL

    foreach ($lang_arr as $slug) {
        $art_name = $slug['title'];
        $slug = $slug['slug'];
        $seo_id = seo_id($art_name);

        $check_seo_id = $mysqli->query("
          SELECT $table_data.*
          FROM $table_data
          WHERE $table_data.seo_id = '$seo_id'
        ");
        $check_seo = $check_seo_id->fetch_array(MYSQLI_ASSOC);

        if ($check_seo) {
            $seo_id = $seo_id . time('timestamp');
        }

        $sql = $mysqli->query("  
          INSERT INTO $table_data (for_instance, lang, seo_id, title) 
          VALUES ('$id', '$slug', '$seo_id', '$art_name')      
        ");
    }

    $response['load_new'] = $domain . '/admin/index.php?' . $get_string . '=' . $id;
    echo json_encode($response);
}

?>
