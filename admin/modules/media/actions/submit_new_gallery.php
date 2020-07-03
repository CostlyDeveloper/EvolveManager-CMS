<?php define("ADMIN", true);
require_once("../../../../system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])) {
    die_500();
}
security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check

$response['message'] = '';

$total_media = $mysqli->real_escape_string($_POST['total_media']);
$gallery_name = $mysqli->real_escape_string($_POST['gallery_title']);
$gallery_id = $mysqli->real_escape_string($_POST['add_into_gallery']);

if ($gallery_id != 'false') {
    $response['message'] = 'add_into_gallery= '. $gallery_id;

    //Find gallery then increase num in gallery
    $sql = $mysqli->query(" 
    UPDATE evolve_galleries
    SET evolve_galleries.total_media = evolve_galleries.total_media + 1     
    WHERE evolve_galleries.id = '$gallery_id'
  ");
} else {
    $response['message'] = 'else-!add_into_gallery';
    //CREATE NEW GALLERY ROW
    $sql = $mysqli->query("  
        INSERT INTO evolve_galleries (gallery_name, total_media) 
        VALUES ('$gallery_name', '$total_media')      
        ");
    if ($sql) {
        $gallery_id = $mysqli->insert_id; //Get ID of last inserted row from MySQL
    } else {
        $response['message'] = 'err';
    }
}
foreach ($_POST as $name => $val) {
    if (substr($name, 0, 7) == 'mediaid') {
        $get_media = $mysqli->query("
    SELECT thumb, filename, folder
    FROM evolve_media
    WHERE evolve_media.id = '$val'
    ");
        $media = $get_media->fetch_array(MYSQLI_ASSOC);
        if (!$media) {
            $response['message'] = 'err';
        }
        $thumb = NULL;
        if ($media['thumb']) {
            $thumb = $media['thumb'];
        }
        $filename = $media['filename'];
        $folder = $media['folder'];
        $sql = $mysqli->query("  
        INSERT INTO evolve_gallery_items (gallery_id, media_id, thumb, filename, folder) 
        VALUES ('$gallery_id', '$val', '$thumb', '$filename', '$folder')      
        ");
    }
}
$response['load_gallery_url'] = $domain . '/admin/index.php?galleries=' . $gallery_id;
echo json_encode($response);

?>
