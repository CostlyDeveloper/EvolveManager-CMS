<?php
define("ADMIN", true);
require_once("../../../../system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])) {
    die_500();
}
security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check


// echo pr($_POST);
if (isset($_POST['multiColorHex'])) {
    $multi_color_hex_nr = count($_POST['multiColorHex']);
    $arr = [];

    for ($i = 0; $i < $multi_color_hex_nr; ++$i) {
        $colors_data = new stdClass;
        $colors_data->colorName = $_POST['multiColorName'][$i];
        $colors_data->colorHex = $_POST['multiColorHex'][$i];
        array_push($arr, $colors_data);
    }

    $colors_data_json = json_encode($arr, JSON_FORCE_OBJECT);
} else {
    $colors_data_json = '';
}




if (isset($_POST['instanceID'])) {
    $instance_id = $mysqli->real_escape_string($_POST['instanceID']);
    $user_id = $mysqli->real_escape_string($_POST['userID']);
    $price = $mysqli->real_escape_string($_POST['price']);
    $publishing_date = $mysqli->real_escape_string($_POST['datetimepicker_publishing']);
    $publishing_date = strtotime($publishing_date);
    $publishing_date = date("Y-m-d H:i:s", $publishing_date);

    if (isset($_POST['gal_id'])) {
        $gallery_id = $mysqli->real_escape_string($_POST['gal_id']);
    } else {
        $gallery_id = '0';
    }


    //ADRTICLE DATA - MULTILANG
    $slugs_arr = languages();
    foreach ($slugs_arr as $slug) {

        $slug = $slug['slug'];
        $seoID = seo_id($mysqli->real_escape_string($_POST['seoid_' . $slug]));
        $title = $mysqli->real_escape_string($_POST['title_' . $slug]);
        $tagline = $mysqli->real_escape_string($_POST['tagline_' . $slug]);
        $description = $mysqli->real_escape_string($_POST['description_' . $slug]);
        $content = $mysqli->real_escape_string($_POST['content_' . $slug]);
        $keywords = $mysqli->real_escape_string($_POST['keywords_' . $slug]);

        if (!$seoID) {
            if ($title) {
                $seoID = seo_id($title);
            }
        }

        $unique = $mysqli->query("
          CREATE UNIQUE INDEX instance_index 
          ON evolve_products_data (for_instance,lang)");
        //if(!$unique) print_r($mysqli->error);
        $sql = $mysqli->query("  
          INSERT INTO evolve_products_data (for_instance, lang, seo_id, title, tagline, description, content, keywords) 
          VALUES ('$instance_id', '$slug', '$seoID', '$title', '$tagline', '$description', '$content', '$keywords')
          ON DUPLICATE KEY UPDATE
          seo_id              = '$seoID', 
          title               = '$title',
          tagline             = '$tagline',
          description         = '$description',
          content             = '$content',
          keywords            = '$keywords'    
          ");

        $unique = $mysqli->query("
              ALTER TABLE evolve_products_data
              DROP INDEX instance_index;");

        $response['seoid_' . $slug] = $seoID;
    }
    // /$_POST DATA - MULTILANG

    //ARTICLE INFO
    //Checkboxed
    if (isset($_POST['published'])) {
        $published = 1;
    } else {
        $published = 0;
    }
    if (isset($_POST['featured'])) {
        $featured = 1;
    } else {
        $featured = 0;
    }
    if (isset($_POST['promoted'])) {
        $promoted = 1;
    } else {
        $promoted = 0;
    }
    if (isset($_POST['show_date'])) {
        $show_date = 1;
    } else {
        $show_date = 0;
    }
    if (isset($_POST['show_date'])) {
        $show_date = 1;
    } else {
        $show_date = 0;
    }
    if (isset($_POST['activate_colors'])) {
        $activate_colors = 1;
    } else {
        $activate_colors = 0;
    }
    if (isset($_POST['show_cover_img'])) {
        $show_cover_img = 1;
    } else {
        $show_cover_img = 0;
    }




    $sql = $mysqli->query("     
        UPDATE evolve_products
        SET 
        published             = '$published',
        featured              = '$featured', 
        promoted              = '$promoted',
        price                 = '$price',
        colors_data_json      = '$colors_data_json',
        activate_colors       = '$activate_colors',    
        date                  = '$publishing_date',
        show_date             = '$show_date',
        last_edit_user        = '$user_id',
        show_cover_img        = '$show_cover_img',
        gallery_id            = '$gallery_id', 
        last_edit_time        =  CURRENT_TIMESTAMP
        WHERE id = '$instance_id' ");
    // if(!$sql) print_r($mysqli->error);


    // /ARTICLE INFO


    //render response data in JSON format
    echo json_encode($response);

}
?>
