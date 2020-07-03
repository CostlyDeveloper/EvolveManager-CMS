<?php
function article_type($category)
{
    global $mysqli;

    $query = $mysqli->query("
      SELECT evolve_article_rubrics_type.slug
      FROM evolve_article_rubrics_type
          
      LEFT JOIN evolve_article_rubrics
      ON evolve_article_rubrics_type.id = evolve_article_rubrics.layout_type
        
      WHERE evolve_article_rubrics.id = '$category'
      ");
    ///if(!$get_video) print_r($mysqli->error);
    if ($query->num_rows > 0) {

        $row = $query->fetch_array(MYSQLI_ASSOC);

        return $row['slug'];
    }
}

function getAddress()
{
    $protocol = 'http';
    if (!empty($_SERVER['HTTPS'])) {
        $protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
    }
    return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

function set_website_head($site_title, $site_description, $og_image, $custom1, $custom2, $custom3)
{
    global $buffer;

    $site_description ? $site_description = substr(strip_tags($site_description), 0, 325) . '...' : '';

    if (!empty($buffer)) {
        $site_title ? $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $site_title . '$3', $buffer) : '';
        $site_title ? $buffer = preg_replace('/<meta property="og:title" content="(.*)"\/>/i', '<meta property="og:title" content="' . $site_title . '" />', $buffer) : '';

        $site_description ? $buffer = preg_replace('/<meta property="og:description" content="(.*)"\/>/i', '<meta property="og:description" content="' . $site_description . '" />', $buffer) : '';
        $site_description ? $buffer = preg_replace('/<meta name="description" content="(.*)"\/>/i', '<meta name="description" content="' . $site_description . '" />', $buffer) : '';

        $og_image ? $buffer = preg_replace('/<meta property="og:image" content="(.*)"\/>/i', '<meta property="og:image" content="' . $og_image . '" />', $buffer) : '';

        echo $buffer;
    }
}

function escape($t)
{
    global $mysqli;
    return $mysqli->real_escape_string(trim(htmlspecialchars($t, ENT_QUOTES)));
}

function get_ad($position)
{
    global $mysqli;

    $query = $mysqli->query("
      SELECT 
      evolve_ads_data.content
      
      FROM evolve_ads
      
      LEFT JOIN evolve_ads_data
      ON evolve_ads.id = evolve_ads_data.for_instance
      
      WHERE evolve_ads.slug = '$position'
        AND evolve_ads_data.published = 1
      
      ORDER BY evolve_ads_data.position
      ");
    if (!$query) print_r($mysqli->error);

    if ($query->num_rows > 0) {

        $row = $query->fetch_array(MYSQLI_ASSOC);

        return $row['content'];
    }
}

function GetIP()
{
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
}

function lang($string)
{
    global $mysqli, $language;

    $query = $mysqli->query("
      SELECT evolve_frontend_lang_strings.*
      FROM evolve_frontend_lang_strings
        
      WHERE string_name = '$string' 
        and for_lang = '$language'
      ");
    if (!$query) print_r($mysqli->error);

    if ($query->num_rows > 0) {

        $row = $query->fetch_array(MYSQLI_ASSOC);

        if ($row['string_value']) {
            echo $row['string_value'];
        } else {
            return false;
        }
    }

}

function lang_return($string)
{
    global $mysqli, $language;

    $query = $mysqli->query("
      SELECT evolve_frontend_lang_strings.*
      FROM evolve_frontend_lang_strings
        
      WHERE string_name = '$string' 
        and for_lang = '$language'
      ");
    //if(!$query) print_r($mysqli->error);

    if ($query->num_rows > 0) {

        $row = $query->fetch_array(MYSQLI_ASSOC);

        if ($row['string_value']) {
            return $row['string_value'];
        } else {
            return false;
        }
    }

}

function pr($var)
{
    echo '<pre>', print_r($var), '</pre>';
}

function evolveAllow($rank)
{
    global $data;
    if ($data['user_rank'] >= $rank) {
        return true;
    } else {
        return false;
    }
}

function evolveLogged()
{
    global $data;
    if ($data['user_rank']) {
        return true;
    } else {
        return false;
    }
}

function module_enabled($module_id)
{
    global $mysqli;
    $modules = $mysqli->query(" 
       SELECT evolve_modules.*
       FROM evolve_modules
       WHERE evolve_modules.id = '$module_id'
         AND evolve_modules.enabled = '1'
    ");
    if ($modules->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

?>