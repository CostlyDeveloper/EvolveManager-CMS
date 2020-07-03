<?php /** Cody ENC **/
function encrypt($d)
{
    global $encryption;
    return sha1(str_rot13($d . $encryption));
}

/** Cody ENC **/

function allow_if_module_is_loaded($slug = 0)
{

    global $mysqli, $developing;

    // if($developing) pr(array_keys($_GET)[0]);
    // $slug = '"' . $slug . '"';
    $query = $mysqli->query("
    SELECT evolve_modules.id, evolve_modules.name, evolve_modules.get_var 
       FROM evolve_modules
       WHERE slug = '$slug'
  ");


    if ($query->num_rows > 0) {
        $mod = $query->fetch_array(MYSQLI_ASSOC);
        $get_var_list = $mod['get_var'];
        $get_var_list = json_decode( $get_var_list, true ); ;

       foreach ($get_var_list as $get_var) {
                $prevent_slash = (substr($get_var, 0, -1));
            if (isset($_GET[$get_var]) || isset($_GET[$prevent_slash])) {
                return true;
            }
        }

    } else {
        return false;
    }

}


//SECURITY CHECK
function security($user_id, $pass, $token, $rdts, $requested_url, $last_ip)
{
    global $mysqli;
    //Find items then decrease num in gallery
    $query = $mysqli->query(" 
      SELECT evolve_users.id
      FROM evolve_users       
      
      WHERE evolve_users.id = '$user_id'
        AND evolve_users.password = '$pass'
        AND evolve_users.token = '$token'
    ");
    if ($query->num_rows > 0) {
        return true;
    } else {
        $rdts = date('Y-m-d H:i:s', $rdts);
        $query = $mysqli->query("
    INSERT INTO evolve_hacking_atempts (user_id, regdate, requested_url, last_ip) 
      VALUES ('$user_id', '$rdts', '$requested_url', '$last_ip')
    ");
        if (!$query)
            print_r($mysqli->error);
        header('HTTP/1.1 500 Internal Server Error');
        die();
    }
}

function die_500()
{
    header('HTTP/1.1 500 Internal Server Error');
    die();
}

function GetIP()
{
    foreach (array(
                 'HTTP_CLIENT_IP',
                 'HTTP_X_FORWARDED_FOR',
                 'HTTP_X_FORWARDED',
                 'HTTP_X_CLUSTER_CLIENT_IP',
                 'HTTP_FORWARDED_FOR',
                 'HTTP_FORWARDED',
                 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
}

// /SECURITY CHECK

function get_items_nr($category_id, $item_table)
{
    global $mysqli;
    $query = $mysqli->query("
    SELECT $item_table.*
       FROM $item_table
       WHERE $item_table.category = '$category_id'
  ");
    return $query->num_rows;
}

function get_article_nr($category_id)
{
    global $mysqli;
    $query = $mysqli->query("
    SELECT evolve_articles.*
       FROM evolve_articles
       WHERE evolve_articles.category = '$category_id'
  ");
    return $query->num_rows;
}

function get_module_name($mod_id)
{
    global $mysqli;
    $query = $mysqli->query("
    SELECT evolve_modules.*
       FROM evolve_modules
       WHERE evolve_modules.id = '$mod_id'
  ");
    if ($query->num_rows > 0) {
        $mod = $query->fetch_array(MYSQLI_ASSOC);
        return $mod['name'];
    } else {
        return false;
    }
}

function number_cat_instances($cat_id)
{
    global $mysqli;
    $query = $mysqli->query("
    SELECT evolve_webcam_cat_relations.*
    FROM evolve_webcam_cat_relations
    
    WHERE for_cat = '$cat_id'
  ");
    if ($query) {
        return $query->num_rows;
    }
}

function get_add_video_block($for_module, $for_module_child, $for_instance)
{
    global $mysqli, $lang;

    $select_video = $mysqli->query("
    SELECT evolve_video.original_title, evolve_video.id as video_id
    FROM evolve_video

    LEFT JOIN evolve_video_relations
    ON evolve_video_relations.video_id = evolve_video.id     
      
    WHERE evolve_video_relations.for_module = '$for_module'
      AND evolve_video_relations.for_module_child = '$for_module_child'
      AND evolve_video_relations.for_instance = '$for_instance'
      
    GROUP BY evolve_video.id
    ORDER BY -position DESC
  ");
    if (!$select_video) print_r($mysqli->error);
    ?>
    <!-- Add videos -->
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo $lang['com_add_vid']; ?></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group">
                <ul class="choosed_video nav-list" id="video_dragable">
                    <?php while ($vid = $select_video->fetch_assoc()) {
                        $video_id = $vid['video_id']; ?>
                        <li data-id="<?php echo $video_id; ?>" class="selected_video_li alert alert-info alert-dismissible fade in" role="alert">
                            <div class="col-xs-3 col-md-2 pull-right">
                                <button data-id="<?php echo $video_id; ?>" type="button" class="vid_close close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <input type="hidden" name="vid_id" value="<?php echo $video_id ?>"/>
                                <a href="index.php?video=<?php echo $video_id; ?>" target="_blank" class="close"><i class="fa fa-pencil small_ico" aria-hidden="true"></i></a>
                            </div>
                            <div class="col-xs-3 col-md-2 pull-left">
                                <div class="text-left pull-left"><?php echo $video_id; ?></div>
                                <div class="text-left pull-right"><i class="fa fa-arrows"></i></div>
                            </div>
                            <div class="col-xs-10 col-md-8">
                                <strong> <?php echo $vid['original_title'] ?></strong>
                            </div>
                            <div class="clearfix"></div>
                        </li>
                    <?php } ?>
                </ul>
                <label><?php echo $lang['com_select_video']; ?></label>
                <input id="select_video" name="select_video" class="form-control" value="" type="text" autocomplete="off"/>
                <ul id="video_results"></ul>
            </div>
        </div>
    </div><!-- /Add videos -->
<?php }

function get_next_level_menu_items($menu_id, $parent_id, $parent_level)
{
    global $mysqli;
    $level = $parent_level + 1;
    $query = $mysqli->query("
      SELECT evolve_menus_relations.*
      FROM evolve_menus_relations
      WHERE for_instance = '$menu_id'
        AND child_of = '$parent_id'
        AND level = '$level'
      ORDER BY evolve_menus_relations.position
      ");
    //if(!$query) print_r($mysqli->error);
    if ($query->num_rows > 0) { ?>
        <ol>
            <?php while ($row = $query->fetch_assoc()) { ?>
                <li id="item_<?php echo $row['id']; ?>" class="list-group-item">
    <span class="pull-left margin_icon">
    <i class="fa fa-arrows"></i>
    </span> <span class="pull-right margin_icon">
    <a data-id="<?php echo $row['id']; ?>" class="edit_menu_item btn btn-info btn-xs"><i class="fa fa-pencil"></i> </a>
    <a data-id="<?php echo $row['id']; ?>" class="btn btn-danger btn-xs del_inst"><i class="fa fa-trash-o"></i> </a>
    </span>
                    <div id="name_<?php echo $row['id']; ?>">
                        <?php echo $row['name']; ?>
                    </div>
                    <?php get_next_level_menu_items($menu_id, $row['id'], $row['level']); ?>
                </li>
            <?php } ?>
        </ol>
    <?php }
}

function lang($string, $lang)
{
    global $mysqli, $default_language;
    $query = $mysqli->query("
    SELECT evolve_frontend_lang_strings.*
    FROM evolve_frontend_lang_strings
    
    WHERE string_name = '$string'
      AND for_lang = '$lang'
    ");
    //if(!$query) print_r($mysqli->error);
    $row = $query->fetch_array(MYSQLI_ASSOC);
    if ($row['string_value']) {
        echo $row['string_value'];
    } else {
        $query = $mysqli->query("
    SELECT evolve_frontend_lang_strings.*
    FROM evolve_frontend_lang_strings
    
    WHERE string_name = '$string'
      AND for_lang = '$default_language'
    ");
        $row = $query->fetch_array(MYSQLI_ASSOC);
        echo $row['string_value'];
    }
}

function pr($var)
{
    echo '<pre>', print_r($var), '</pre>';
}

function prb($var)
{
    echo '<div class="dev_box"><pre>', print_r($var), '</pre></div>';
}

function module_enabled($module_slug)
{
    global $mysqli;
    $modules = $mysqli->query(" 
       SELECT evolve_modules.*
       FROM evolve_modules
       WHERE evolve_modules.slug = '$module_slug'
    ");
    if ($modules->num_rows > 0) {
        $mod = $modules->fetch_array(MYSQLI_ASSOC);
        if ($mod['enabled']) {
            return $mod['id'];
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function module_media_folder($module_id)
{
    global $mysqli;
    $modules = $mysqli->query(" 
       SELECT evolve_modules.*
       FROM evolve_modules
       WHERE evolve_modules.id = '$module_id'
    ");
    if ($modules->num_rows > 0) {
        $mod = $modules->fetch_array(MYSQLI_ASSOC);
        if ($mod['media_folder']) {
            return $mod['media_folder'];
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function video_relation($unique_id)
{
    global $mysqli;
    $video_rel = $mysqli->query(" 
       SELECT evolve_video_relations.*
       FROM evolve_video_relations
       WHERE evolve_video_relations.unique_id = '$unique_id'
    ");
    if ($video_rel->num_rows > 0) {
        return false;
    } else {
        return true;
    }
}

function cache_image($image_url, $cache_folder)
{
    //cache directory
    $image_path = $cache_folder;
    $new_filename = time() . '_cache';
    if (!is_dir($image_path)) {
        mkdir($image_path, 0777, true);
    }
    //get the name of the file
    $exploded_image_url = explode("/", $image_url);
    $image_filename = end($exploded_image_url);
    $exploded_image_filename = explode(".", $image_filename);
    $extension = end($exploded_image_filename);
    //make sure its an image
    $image_filename = $new_filename . '.' . $extension;
    if ($extension == "gif" || $extension == "jpg" || $extension == "jpeg" || $extension == "png") {
        //get the remote image
        $arrContextOptions = array("ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
        ),);
        $image_to_fetch = file_get_contents($image_url, false, stream_context_create($arrContextOptions));
        //save
        $local_image_file = fopen($image_path . $image_filename, 'w+');
        chmod($image_path . $image_filename, 0755);
        fwrite($local_image_file, $image_to_fetch);
        fclose($local_image_file);
        return $image_filename;
    }
}

function getVimeoVideoThumbnailByVideoId($id = '', $thumbType = 'large')
{
    $id = trim($id);
    if ($id == '') {
        return FALSE;
    }
    $apiData = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$id.php"));
    if (is_array($apiData) && count($apiData) > 0) {
        $videoInfo = $apiData[0];
        switch ($thumbType) {
            case 'small':
                return $videoInfo['thumbnail_small'];
                break;
            case 'large':
                return $videoInfo['thumbnail_large'];
                break;
            case 'medium':
                return $videoInfo['thumbnail_medium'];
            default:
                break;
        }
    }
    return FALSE;
}

function find_video_id($url = NULL, $id = NULL, $type, $direction) //url = video url
    //type 1 = youtube
//type 2 = vimeo
//direction 1 = url to ID
//direction 2 = ID to url
//direction 3 = img by id
{
    if ($direction == 1) {
        if ($type == 1) { //YOUTUBE
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
            if ($match) {
                return $match[1];
            } else {
                die(header("HTTP/1.0 404 Not Found"));
            }
        } elseif ($type == 2) { //VIMEO
            preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([‌​0-9]{6,11})[?]?.*/', $url, $match);
            if ($match) {
                return $match[5];
            } else {
                die(header("HTTP/1.0 404 Not Found"));
            }
        }
    } elseif ($direction == 2) {
        if ($type == 1) { //YOUTUBE
            return 'https://youtu.be/' . $id;
        } elseif ($type == 2) { //VIMEO
            return 'https://vimeo.com/' . $id;
        }
    } elseif ($direction == 3) {
        if ($type == 1) { //YOUTUBE
            return 'https://img.youtube.com/vi/' . $id . '/0.jpg';
        } elseif ($type == 2) { //VIMEO
            return getVimeoVideoThumbnailByVideoId($id);
        }
    }
}

function get_video_title($ref, $type)
{
    switch ($type) {
        case "1":
            $json = file_get_contents('http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=' . $ref . '&format=json');
            if ($json) {
                $details = json_decode($json, true);
                return $details['title'];
            } else {
                die;
            }
            break;
        case "2":
            $json = file_get_contents('http://vimeo.com/api/v2/video/' . $ref . '.json');
            if ($json) {
                $details = json_decode($json, true);
                return $details['0']['title'];
            } else {
                die;
            }
            break;
    }
}

//VIDEO NUMBER OF ITEMS BY UNIQUE ID
function get_video_items_nr($instance_id, $module_id, $child_module_id)
{
    if ($instance_id && $module_id && $child_module_id) {
        global $mysqli;
        $video = $mysqli->query("
      SELECT evolve_video_relations.*
      FROM evolve_video_relations 
      WHERE evolve_video_relations.for_instance = $instance_id
        AND evolve_video_relations.for_module = $module_id
        AND evolve_video_relations.for_module_child = $child_module_id
    ");
        if ($video->num_rows > 0) {
            return $video->num_rows;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

// /VIDEO NUMBER OF ITEMS BY ID
//GALLERY NUMBER OF ITEMS UNIQUE ID
function get_gallery_items_nr($gal_id)
{
    if ($gal_id) {
        global $mysqli;
        $gal_info = $mysqli->query("
      SELECT evolve_galleries.*
      FROM evolve_galleries 
      WHERE evolve_galleries.id = $gal_id
    ");
        $gal = $gal_info->fetch_array(MYSQLI_ASSOC);
        if ($gal['total_media']) {
            return $gal['total_media'];
        } else {
            return false;
        }
    } else {
        return false;
    }
}

// /GALLERY NUMBER OF ITEMS BY ID
//GALLERY INFO BY ID
function get_gallery_selected_data($gal_id)
{
    global $mysqli, $lang;
    $gal_info = $mysqli->query("
      SELECT evolve_galleries.*
      FROM evolve_galleries 
      WHERE evolve_galleries.id = $gal_id
    ");
    $gal = $gal_info->fetch_array(MYSQLI_ASSOC);
    if ($gal_info->num_rows > 0) { ?>
        <div class="alert alert-info alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <input type="hidden" name="gal_id" value="<?php echo $gal_id ?>"/>

            <?php echo $lang['associated_gallery'] ?> <br/><strong><?php echo $gal['gallery_name'] ?></strong> <br/>
            <?php echo $lang['gall_nr_items'] ?>: <?php echo $gal['total_media'] ?>
            <br/>
            <a href="index.php?media=<?php echo $gal_id; ?>" target="_blank" class="btn btn-info btn-xs pull-left"><?php echo $lang['gallery_edit_button'] ?></a>
            <div class="clearfix"></div>
        </div>
    <?php }
}

// /GALLERY INFO BY ID
//CHECKBOX VALIDATION
function active_class($true)
{
    if ($true == true) {
        return 'active';
    }
}

// /CHECKBOX VALIDATION
//CHECKBOX VALIDATION
function checked($true)
{
    if ($true == true) {
        return 'checked="checked"';
    }
}

// /CHECKBOX VALIDATION
//READONLY VALIDATION
function readonly($false)
{
    if ($false == false) {
        return 'readonly="readonly"';
    }
}

// /READONLY VALIDATION
//READONLY VALIDATION
function disabled($true)
{
    if ($true == true) {
        return 'disabled="disabled"';
    }
}

// /READONLY VALIDATION
//GET USERNAME
function get_username($user_id, $link = false)
{
    global $mysqli;
    //Find items then decrease num in gallery
    $find_user = $mysqli->query(" 
            SELECT evolve_users.*
            FROM evolve_users       
            WHERE evolve_users.id = '$user_id'
            ");
    $user = $find_user->fetch_array(MYSQLI_ASSOC);
    return $user['email'];
}

// /GET USERNAME
//DELETE RECORD FROM GALLERIES
function delete_record_from_galleries($media_id)
{
    global $mysqli;
    //Find items then decrease num in gallery
    $find_items = $mysqli->query(" 
            SELECT evolve_gallery_items.*
            FROM evolve_gallery_items       
            WHERE evolve_gallery_items.media_id = '$media_id'
            ");
    if ($find_items) {
        $media = $find_items->fetch_array(MYSQLI_ASSOC);
        $gallery_id = $media['gallery_id'];
        //Find items then decrease num in gallery
        $gal_items = $mysqli->query(" 
                UPDATE evolve_galleries
                SET evolve_galleries.total_media = evolve_galleries.total_media - 1     
                WHERE evolve_galleries.id = $gallery_id
                ");
        $sql = $mysqli->query("
            DELETE FROM evolve_gallery_items 
            WHERE media_id = $media_id");
        return true;
    }
}

// /DELETE RECORD FROM GALLERIES
//GALLERY PREVIEW
function gallery_preview($gal_id, $limit = 6)
{
    global $mysqli, $domain;
    $get_media = $mysqli->query("
    SELECT evolve_gallery_items.*
    FROM evolve_gallery_items   
    WHERE evolve_gallery_items.gallery_id = '$gal_id' 
    LIMIT $limit;
    ");
    while ($media = $get_media->fetch_assoc()) {
        $imgsrc = $domain . $media['folder'] . $media['filename'];
        if ($media['thumb']) {
            $imgsrc = $domain . $media['folder'] . $media['thumb'];
        } ?>
        <li>
            <img class="lazyload avatar" data-src="<?php echo $imgsrc; ?>" alt="image"/>
        </li>
    <?php }
}

// /GALLERY PREVIEW
//IMAGE RESIZE
function image_resize($src, $dst, $width, $height, $crop = 0, $jpgquality, $grayscale = 0, $watermark = 0, $watermark_opacity = 50, $watermark_position = 0, $watermark_ratio = 5)
{
    if (!list($w, $h) = getimagesize($src))
        return false;
    if ($width == 0) {
        $width = $w;
    }
    if ($height == 0) {
        $height = $h;
    }
    $type = strtolower(substr(strrchr($src, "."), 1));
    if ($type == 'jpeg')
        $type = 'jpg';
    switch ($type) {
        case 'bmp':
            $img = imagecreatefromwbmp($src);
            break;
        case 'gif':
            $img = imagecreatefromgif($src);
            break;
        case 'jpg':
            $img = imagecreatefromjpeg($src);
            break;
        case 'png':
            $img = imagecreatefrompng($src);
            break;
        default:
            return false;
    }
    if ($crop) {
        $x = 0;
        $y = 0;
        if (($width / $w) > ($height / $h)) {
            //Width
            $ratio = $width / $w;
            $y = ($h - $height / $ratio) / 2;
        } else {
            //Height
            $ratio = $height / $h;
            $x = ($w - $width / $ratio) / 2;
        }
        $h = $height / $ratio;
        $w = $width / $ratio;
    } else {
        $ratio = min($width / $w, $height / $h);
        $width = $w * $ratio;
        $height = $h * $ratio;
        $x = 0;
        $y = 0;
    }
    $new = imagecreatetruecolor($width, $height);
    //preserve transparency
    if ($type == "gif" or $type == "png") {
        imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
        imagealphablending($new, false);
        imagesavealpha($new, true);
    }
    imagecopyresampled($new, $img, 0, 0, $x, $y, $width, $height, $w, $h);
    if ($grayscale) {
        imagefilter($new, IMG_FILTER_GRAYSCALE);
    }
    switch ($type) {
        case 'bmp':
            imagewbmp($new, $dst);
            break;
        case 'gif':
            imagegif($new, $dst);
            break;
        case 'jpg':
            imagejpeg($new, $dst, $jpgquality);
            break;
        case 'png':
            imagepng($new, $dst);
            break;
    }
    //imagedestroy($new);
    if ($watermark) {
        watermark($dst, $watermark, $watermark_opacity, $watermark_position, $watermark_ratio);
    }
    return true;
}

function watermark($image, $overlay, $opacity = 40, $position = 0, $ratio = 5)
{
    /** POSITIONS
     *
     * 0 = CENTER
     * 1 = TOP LEFT
     * 2 = TOP RIGHT
     * 3 = BOTTOM RIGHT
     * 4 = BOTTOM LEFT
     */
    if (!file_exists($image)) {
        die("Image does not exist.");
    }
    if (!list($swidth, $sheight) = getimagesize($image))
        return false; // GET ORIGINAL Image size
    //////////////////
    // OVERLAY
    $info = getimagesize($overlay);
    $mime = $info['mime'];
    switch ($mime) {
        case 'image/jpeg':
            $image_create_func = 'imagecreatefromjpeg';
            $image_save_func = 'imagejpeg';
            $new_image_ext = 'jpg';
            break;
        case 'image/png':
            $image_create_func = 'imagecreatefrompng';
            $image_save_func = 'imagepng';
            $new_image_ext = 'png';
            break;
        case 'image/gif':
            $image_create_func = 'imagecreatefromgif';
            $image_save_func = 'imagegif';
            $new_image_ext = 'gif';
            break;
        default:
            throw new Exception('Unknown image type.');
    }
    $owidth = $swidth / $ratio;
    $img = $image_create_func($overlay);
    if (!list($width, $height) = getimagesize($overlay))
        return false; // GET OVERLAY (WATERMARK)SIZE
    $oheight = ($height / $width) * $owidth;
    $watermark = imagecreatetruecolor($owidth, $oheight);
    imagealphablending($watermark, false);
    imagesavealpha($watermark, true);
    imagecopyresampled($watermark, $img, 0, 0, 0, 0, $owidth, $oheight, $width, $height);
    //TRANSPARENCY
    $transparency = ($opacity * 127) / 100;
    $transparency = 127 - $transparency;
    $offset = 10;
    //OFFSET
    if ($position == 0) { //center
        $positionX = ($swidth / 2) - ($owidth / 2); // centering the watermark
        $positionY = ($sheight / 2) - ($oheight / 2); // centering the watermark
    } elseif ($position == 1) { //top left
        $positionX = $offset;
        $positionY = $offset;
    } elseif ($position == 2) { //top right
        $positionX = $swidth - $owidth - $offset;
        $positionY = $offset;
    } elseif ($position == 3) { //bottom right
        $positionX = $swidth - $owidth - $offset;
        $positionY = $sheight - $oheight - $offset;
    } elseif ($position == 4) { //bottom left
        $positionX = $offset;
        $positionY = $sheight - $oheight - $offset;
    }
    $info = getimagesize($image); //OriginalFile
    $mime = $info['mime'];
    switch ($mime) {
        case 'image/jpeg':
            $image_create_func = 'imagecreatefromjpeg';
            $image_save_func = 'imagejpeg';
            $new_image_ext = 'jpg';
            break;
        case 'image/png':
            $image_create_func = 'imagecreatefrompng';
            $image_save_func = 'imagepng';
            $new_image_ext = 'png';
            break;
        case 'image/gif':
            $image_create_func = 'imagecreatefromgif';
            $image_save_func = 'imagegif';
            $new_image_ext = 'gif';
            break;
        default:
            throw new Exception('Unknown image type.');
    }
    $photo = $image_create_func($image);
    //alpha transparency
    imagealphablending($watermark, false);
    imagesavealpha($watermark, true);
    imagefilter($watermark, IMG_FILTER_COLORIZE, 0, 0, 0, $transparency);
    // /alpha transparency
    imagealphablending($photo, true);
    imagecopy($photo, $watermark, $positionX, $positionY, 0, 0, $owidth, $oheight);
    //finalize
    $image_save_func($photo, $image);
}

function resize($newWidth, $targetFile, $originalFile)
{
    $info = getimagesize($originalFile);
    $mime = $info['mime'];
    switch ($mime) {
        case 'image/jpeg':
            $image_create_func = 'imagecreatefromjpeg';
            $image_save_func = 'imagejpeg';
            $new_image_ext = 'jpg';
            break;
        case 'image/png':
            $image_create_func = 'imagecreatefrompng';
            $image_save_func = 'imagepng';
            $new_image_ext = 'png';
            break;
        case 'image/gif':
            $image_create_func = 'imagecreatefromgif';
            $image_save_func = 'imagegif';
            $new_image_ext = 'gif';
            break;
        default:
            throw new Exception('Unknown image type.');
    }
    $img = $image_create_func($originalFile);
    list($width, $height) = getimagesize($originalFile);
    $newHeight = ($height / $width) * $newWidth;
    $tmp = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    if (file_exists($targetFile)) {
        unlink($targetFile);
    }
    $image_save_func($tmp, "$targetFile.$new_image_ext");
}

// Count File Size
function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }
    return $bytes;
}

function find_module($get_variable = 0)
{
    global $mysqli;
    $get_variable = '"' . $get_variable . '"';
    $query = $mysqli->query("
    SELECT evolve_modules.id, evolve_modules.name, evolve_modules.slug
       FROM evolve_modules
       WHERE get_var LIKE '%$get_variable%'
  ");
    if (!$query)
        print_r($mysqli->error);
    if ($query->num_rows > 0) {
        $mod = $query->fetch_array(MYSQLI_ASSOC);
        return $mod;
        //return $mod['name'];
    } else {
        return false;
    }
}

function if_module_enabled($module_id)
{
    global $mysqli;
    $modules = $mysqli->query(" 
       SELECT evolve_modules.enabled
       FROM evolve_modules
       WHERE evolve_modules.id = '$module_id'
    ");
    if ($modules->num_rows > 0) {
        $mod = $modules->fetch_array(MYSQLI_ASSOC);
        if ($mod['enabled']) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function evolveAllow2($rank)
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

//Return all multilang slug
/**
 * $slugs_arr = languages();
 * foreach($slugs_arr as $slug){
 *
 * echo $slug;
 * }
 */
function languages()
{
    global $mysqli;
    $query_lang = $mysqli->query("
    SELECT evolve_multilang.*
    FROM evolve_multilang
    WHERE evolve_multilang.enabled = 1
    ORDER BY evolve_multilang.lang_order DESC
    ");
    while ($lan = $query_lang->fetch_assoc()) {
        $slugs[] = $lan;
    }
    return $slugs;
}

//SEO ID
function seo_id($text)
{
    $search = array("Đ", "đ");
    $replacement = array("dj", "dj");
    $text = str_replace($search, $replacement, $text);
    setlocale(LC_ALL, 'croatian');
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    if (empty($text)) {
        return false;
    }
    return $text;
}

// /SEO ID
/** Fix upload names **/
function slugify($text)
{
    $search = array("Đ", "đ");
    $replacement = array("dj", "dj");
    $text = str_replace($search, $replacement, $text);
    setlocale(LC_ALL, 'croatian');
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^\pL\d.]+~u', '', $text);
    $text = preg_replace('~[^-\w.]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~[^a-z0-9.]-+~', '-', $text);
    $text = strtolower($text);
    if (empty($text)) {
        return 'media';
    }
    return $text;
}

/** / Fix upload names **/
function alt_content($media_id, $slug)
{
    global $mysqli;
    $get_media_alt = $mysqli->query("
    SELECT evolve_media_alt.*
    FROM evolve_media_alt           
    WHERE evolve_media_alt.for_media = '$media_id' AND evolve_media_alt.for_lang = '$slug'
    ");
    if ($get_media_alt->num_rows > 0) {
        $media_alt = $get_media_alt->fetch_array(MYSQLI_ASSOC);
        return htmlentities($media_alt['content']);
    } else
        return '';
}

function evolveAllow($user_id, $module_id, $die = false)
{
    global $mysqli, $bridge_cody_chat;
    if (if_module_enabled($module_id)) {
        /**  if cody chat **/
        if ($bridge_cody_chat) {
            $query = $mysqli->query(" 
          SELECT boom_users.user_rank, evolve_boom_groups.permissions
          FROM boom_users     
                
          LEFT JOIN evolve_boom_groups
          ON evolve_boom_groups.id = boom_users.user_rank
                  
          WHERE boom_users.user_id = '$user_id'
        ");
            if ($query->num_rows > 0) {
                $perm = $query->fetch_array(MYSQLI_ASSOC);
                if ($perm['user_rank'] == 0) { //if group is guest
                    die_or_false($die);
                } elseif ($perm['user_rank'] == 10) { //if group is owner
                    return true;
                } else { //if group is any other
                    if ($perm['permissions']) { //if there is at least one permissions
                        $array = json_decode($perm['permissions']);
                        if (in_array($module_id, $array)) {
                            return true;
                        } else {
                            die_or_false($die);
                        }
                    } // /END if there is at least one permissions
                    else {
                        die_or_false($die);
                    }
                }
            } //num_rows > 0
        } /**  /if cody chat **/ else {
            /**  without bridge **/
            $query = $mysqli->query(" 
        SELECT evolve_users.usr_group, evolve_user_groups.permissions
        FROM evolve_users     
              
        LEFT JOIN evolve_user_groups
        ON evolve_user_groups.id = evolve_users.usr_group
                
        WHERE evolve_users.id = '$user_id'
      ");
            if ($query->num_rows > 0) {
                $perm = $query->fetch_array(MYSQLI_ASSOC);
                if ($perm['usr_group'] == 1) { //if group is guest
                    die_or_false($die);
                } elseif ($perm['usr_group'] == 2) { //if group is admin
                    return true;
                } else { //if group is any other
                    if ($perm['permissions']) { //if there is at least one permissions
                        $array = json_decode($perm['permissions']);
                        if (in_array($module_id, $array)) {
                            return true;
                        } else {
                            die_or_false($die);
                        }
                    } // /END if there is at least one permissions
                    else {
                        die_or_false($die);
                    }
                }
            } //num_rows > 0
        }
        /**  /without bridge **/
    } else //if module is enabled
    {
        die_or_false($die);
    }
}

function die_or_false($bool)
{
    if ($bool) {
        header('HTTP/1.1 500 Internal Server Error');
        die();
    } else {
        return false;
    }
}

function spelialPermission($user_id, $module_id)
{
    global $mysqli;
    if (if_module_enabled($module_id)) {
        $query = $mysqli->query(" 
      SELECT boom_users.user_rank, evolve_user_groups.permissions
      FROM boom_users     
            
      LEFT JOIN evolve_user_groups
      ON evolve_user_groups.id = boom_users.user_rank
              
      WHERE boom_users.user_id = '$user_id'
    ");
        if ($query->num_rows > 0) {
            $perm = $query->fetch_array(MYSQLI_ASSOC);
            if ($perm['user_rank'] == 10) { //if group is owner
                return true;
            } else {
                return false;
            }
        } //num_rows > 0
    } else //if module is enabled
    {
        return false;
    }
}

?>
