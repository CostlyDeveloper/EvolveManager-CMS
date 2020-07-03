<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root . "/system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])) {
    die_500();
}
security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check


if (isset($_POST['menu_id'])) {
    $menu_id = $mysqli->real_escape_string($_POST['menu_id']);
    $e_sample_name = $mysqli->real_escape_string($_POST['e_sample_name']);

    $sql = $mysqli->query("     
        UPDATE evolve_menus_relations
        SET 
        name           = '$e_sample_name'
        WHERE id       = '$menu_id' ");

    // DATA - MULTILANG
    $slugs_arr = languages();
    foreach ($slugs_arr as $sl) {

        $slug = $sl['slug'];
        $name = $mysqli->real_escape_string($_POST['name_' . $slug]);
        $uri = $mysqli->real_escape_string($_POST['uri_' . $slug]);
        $url = $mysqli->real_escape_string($_POST['url_' . $slug]);

        $unique = $mysqli->query("
        CREATE UNIQUE INDEX unque_index 
        ON evolve_menus_data (for_instance,lang)
      ");
        //if(!$unique) print_r($mysqli->error);
        $sql = $mysqli->query("  
        INSERT INTO evolve_menus_data (for_instance, lang, name, uri, url) 
        VALUES ('$menu_id', '$slug', '$name', '$uri', '$url')
        ON DUPLICATE KEY UPDATE
        name        = '$name',
        uri         = '$uri',
        url         = '$url'   
      ");
        $unique = $mysqli->query("
        ALTER TABLE evolve_menus_data
        DROP INDEX unque_index;
      ");
    }
    // / DATA - MULTILANG
    echo $e_sample_name;
}//if isset menu id