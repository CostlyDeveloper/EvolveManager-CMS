<?php
define("ADMIN", true);
require_once("../../../../system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])) {
    die_500();
}
security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check


if (isset($_POST['instanceID'])) {
    $instance_id = $mysqli->real_escape_string($_POST['instanceID']);
    $user_id = $mysqli->real_escape_string($_POST['userID']);

    if (isset($_POST['gal_id'])) {
        $gallery_id = $mysqli->real_escape_string($_POST['gal_id']);
    } else {
        $gallery_id = '0';
    }


    //DATA - MULTILANG
    $slugs_arr = languages();
    foreach ($slugs_arr as $slug) {

        $slug = $slug['slug'];
        $domain = $mysqli->real_escape_string($_POST['domain_' . $slug]);
        $token = $mysqli->real_escape_string($_POST['token_' . $slug]);
        $licence = $mysqli->real_escape_string($_POST['licence_' . $slug]);
        $price = $mysqli->real_escape_string($_POST['price_' . $slug]);
        $provision = $mysqli->real_escape_string($_POST['provision_' . $slug]);
        $agent = $mysqli->real_escape_string($_POST['agent_' . $slug]);
        $content = $mysqli->real_escape_string($_POST['content_' . $slug]);

        $unique = $mysqli->query("
          CREATE UNIQUE INDEX instance_index 
          ON evolve_cd_cody_licences_data (for_instance,lang)");
        //if(!$unique) print_r($mysqli->error);
        $sql = $mysqli->query("  
          INSERT INTO evolve_cd_cody_licences_data (for_instance, lang, domain, token, licence, price, provision, agent, content) 
          VALUES ('$instance_id', '$slug', '$domain', '$token', '$licence', '$price', '$provision', '$agent', '$content')
          ON DUPLICATE KEY UPDATE
          domain              = '$domain',
          token               = '$token',
          licence             = '$licence',
          price               = '$price',
          provision           = '$provision',
          agent               = '$agent',
          content             = '$content' 
          ");

        $unique = $mysqli->query("
              ALTER TABLE evolve_cd_cody_licences_data
              DROP INDEX instance_index;
        ");

    }
    // /$_POST DATA - MULTILANG

    //ARTICLE INFO
    //Checkboxed
    if (isset($_POST['is_legal'])) {
        $is_legal = 1;
    } else {
        $is_legal = 0;
    }
    if (isset($_POST['featured'])) {
        $featured = 1;
    } else {
        $featured = 0;
    }
    if (isset($_POST['trouble'])) {
        $trouble = 1;
    } else {
        $trouble = 0;
    }





    $sql = $mysqli->query("     
        UPDATE evolve_cd_cody_licences
        SET 
        is_legal              = '$is_legal',
        featured              = '$featured', 
        trouble               = '$trouble',
        last_edit_user        = '$user_id',
        last_edit_time        =  CURRENT_TIMESTAMP
        WHERE id = '$instance_id' ");
    // if(!$sql) print_r($mysqli->error);


    // /ARTICLE INFO


    //render response data in JSON format
     echo json_encode('');

}
?>
