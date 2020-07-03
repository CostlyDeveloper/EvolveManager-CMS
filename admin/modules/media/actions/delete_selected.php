<?php
define("ADMIN", true);
require_once("../../../../system/config.php");

security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip); //First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true); //Second check


/*$response['message'] = pr($_POST);


echo json_encode($response);*/

foreach ($_POST as $name => $val) {
    if (substr($name, 0, 7) == 'mediaid') {

        $get_media = $mysqli->query("
            SELECT id, thumb, filename, folder
            FROM evolve_media
            WHERE evolve_media.id = '$val'
            ");
        if ($get_media) {

            if ($get_media->num_rows > 0) {
                $img = $get_media->fetch_array(MYSQLI_ASSOC);

                $media_id = $img['id'];

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
        }

    }
}
?>