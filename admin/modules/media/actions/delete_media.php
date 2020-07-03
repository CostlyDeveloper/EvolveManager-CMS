<?php
define("ADMIN", true);
require_once("../../../../system/config.php");

security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip); //First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true); //Second check


if (isset($_POST['media_id'])) {
    $media_id = $mysqli->real_escape_string($_POST['media_id']);
}

$get_media = $mysqli->query("
    SELECT folder, filename, thumb
    FROM evolve_media       
    WHERE evolve_media.id = '$media_id'
    ");
pr($get_media);
if ($get_media) {

    if ($get_media->num_rows > 0) {
        $img = $get_media->fetch_array(MYSQLI_ASSOC);

        $filename = '../../../..' . $img['folder'] . $img['filename'];

        if (!isset($_POST['if_gallery'])) {

            if ($img['thumb']) {
                $thumb = '../../../..' . $img['folder'] . $img['thumb'];

                if (file_exists($thumb)) {
                    unlink($thumb);
                    echo 'File ' . $thumb . ' has been deleted';
                }
            }
            if (file_exists($filename)) {
                unlink($filename);
                echo 'File ' . $filename . ' has been deleted';
            }
        }

        $sql = $mysqli->query("
            DELETE FROM evolve_media_alt 
            WHERE for_media = $media_id
            ");

        $sql = $mysqli->query("
            DELETE FROM evolve_media 
            WHERE id = $media_id");

        delete_record_from_galleries($media_id);
    }

} //get media


?>
