<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root . "/system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])) {
    die_500();
}
security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check

if (isset($_POST['instanceID'])) {
    $instance_id = $mysqli->real_escape_string($_POST['instanceID']);
    $module_id = $mysqli->real_escape_string($_POST['moduleID']);
    $module_child_id = $mysqli->real_escape_string($_POST['moduleChildID']);
    $sub_form = $mysqli->real_escape_string($_POST['sub_form']);
    $get_module = $mysqli->query("
    SELECT media_folder
    FROM evolve_modules       
    WHERE evolve_modules.id = '$module_id'
  ");
    $mod = $get_module->fetch_array(MYSQLI_ASSOC);
    $media_dir = $to_root . $mod['media_folder'];

    if ($module_id == 2) {//VIDEO MODULE
        $get_video = $mysqli->query("
      SELECT image, folder, thumb_img
      FROM evolve_video       
      WHERE evolve_video.id = '$instance_id'
    ");
        $vid = $get_video->fetch_array(MYSQLI_ASSOC);

        if ($vid['image']) {
            $image = $media_dir . $vid['folder'] . $vid['image'];
            if (file_exists($image)) {
                unlink($image);
            }
        }
        if ($vid['thumb_img']) {
            $image = $media_dir . $vid['folder'] . $vid['thumb_img'];
            if (file_exists($image)) {
                unlink($image);
            }
        }
        $sql = $mysqli->query("     
      UPDATE evolve_video
      SET 
     	folder                = '',
      image                 = '', 
      thumb_img             = ''
      WHERE id = '$instance_id' 
    ");
    }// /video
    if ($module_id == 3) {//WEBCAM MODULE
        if ($module_child_id == 2) {//SINGLE WEBCAM EDIT
            if ($sub_form == 'hosted_by') {//HOSTED BY

                $query = $mysqli->query("
        SELECT hosted_image, hosted_folder
        FROM evolve_webcams       
        WHERE evolve_webcams.id = '$instance_id'
      ");
                $row = $query->fetch_array(MYSQLI_ASSOC);

                if ($row['hosted_image']) {
                    $image = $media_dir . $row['hosted_folder'] . $row['hosted_image'];
                    $imagetn = $media_dir . $row['hosted_folder'] . 'tn_' . $row['hosted_image'];
                    if (file_exists($imagetn)) {
                        unlink($imagetn);
                    }
                    if (file_exists($image)) {
                        unlink($image);
                    }
                }
                $sql = $mysqli->query("     
        UPDATE evolve_webcams
        SET 
       	hosted_folder         = '',
        hosted_image          = ''
        WHERE id = '$instance_id' 
      ");
                // /HOSTED BY
            }
            else {
                //COVER IMAGE
                $query = $mysqli->query("
        SELECT image, folder, thumb_img
        FROM evolve_webcams       
        WHERE evolve_webcams.id = '$instance_id'
      ");
                $row = $query->fetch_array(MYSQLI_ASSOC);

                if ($row['image']) {
                    $image = $media_dir . $row['folder'] . $row['image'];
                    if (file_exists($image)) {
                        unlink($image);
                    }
                }
                if ($row['thumb_img']) {
                    $image = $media_dir . $row['folder'] . $row['thumb_img'];
                    if (file_exists($image)) {
                        unlink($image);
                    }
                }
                $sql = $mysqli->query("     
        UPDATE evolve_webcams
        SET 
       	folder                = '',
        image                 = '', 
        thumb_img             = ''
        WHERE id = '$instance_id' 
      ");
            }
            // /COVER IMAGE
        }
        else {
            //category
            $query = $mysqli->query("
        SELECT image, folder, thumb_img
        FROM evolve_webcam_cat       
        WHERE evolve_webcam_cat.id = '$instance_id'
      ");
            $row = $query->fetch_array(MYSQLI_ASSOC);

            if ($row['image']) {
                $image = $media_dir . $row['folder'] . $row['image'];
                if (file_exists($image)) {
                    unlink($image);
                }
            }
            if ($row['thumb_img']) {
                $image = $media_dir . $row['folder'] . $row['thumb_img'];
                if (file_exists($image)) {
                    unlink($image);
                }
            }
            $sql = $mysqli->query("     
        UPDATE evolve_webcam_cat
        SET 
       	folder                = '',
        image                 = '', 
        thumb_img             = ''
        WHERE id = '$instance_id' 
      ");
        }
    }// /WEBCAM
    if ($module_id == 4) {//ARTICLE MODUL
        if ($module_child_id == 2) {//SINGLE ARTICLE
            $get_art = $mysqli->query("
      SELECT img, folder, thumb_img
      FROM evolve_articles       
      WHERE evolve_articles.id = '$instance_id'
    ");
            $art = $get_art->fetch_array(MYSQLI_ASSOC);

            if ($art['img']) {
                $image = $media_dir . $art['folder'] . $art['img'];
                if (file_exists($image)) {
                    unlink($image);
                }
            }
            if ($art['thumb_img']) {
                $image = $media_dir . $art['folder'] . $art['thumb_img'];
                if (file_exists($image)) {
                    unlink($image);
                }
            }
            $sql = $mysqli->query("     
      UPDATE evolve_articles
      SET 
     	folder           = '',
      img                   = '',
      show_cover_img        = 0, 
      thumb_img             = ''
      WHERE id = '$instance_id' 
    ");
        }// /SINGLE ARTICLE
        else if ($module_child_id == 4) {//SINGLE RUBRIC
            $get_art = $mysqli->query("
      SELECT img, folder, thumb_img
      FROM evolve_article_rubrics       
      WHERE evolve_article_rubrics.id = '$instance_id'
    ");
            $art = $get_art->fetch_array(MYSQLI_ASSOC);

            if ($art['img']) {
                $image = $media_dir . $art['folder'] . $art['img'];
                if (file_exists($image)) {
                    unlink($image);
                }
            }
            if ($art['thumb_img']) {
                $image = $media_dir . $art['folder'] . $art['thumb_img'];
                if (file_exists($image)) {
                    unlink($image);
                }
            }
            $sql = $mysqli->query("     
      UPDATE evolve_article_rubrics
      SET 
     	folder                = '',
      img                   = '',
      thumb_img             = ''
      WHERE id = '$instance_id' 
    ");
        }// /SINGLE RUBRIC
    }// /article
    if ($module_id == 5) {//SLIDER MODUL
        $query = $mysqli->query("
      SELECT img, folder, thumb_img
      FROM evolve_sliders       
      WHERE evolve_sliders.id = '$instance_id'
    ");
        $row = $query->fetch_array(MYSQLI_ASSOC);

        if ($row['img']) {
            $image = $media_dir . $row['folder'] . $row['img'];
            if (file_exists($image)) {
                unlink($image);
            }
        }
        if ($row['thumb_img']) {
            $image = $media_dir . $row['folder'] . $row['thumb_img'];
            if (file_exists($image)) {
                unlink($image);
            }
        }
        $sql = $mysqli->query("     
      UPDATE evolve_sliders
      SET 
      folder                = '',
      img                   = '',
      thumb_img             = ''
      WHERE id = '$instance_id' 
    ");
    }// /SLIDER
    if ($module_id == 11) {//SITE SETTINGS
    $query = $mysqli->query("
      SELECT img, folder, thumb_img
      FROM evolve_settings       
      WHERE evolve_settings.id = '$instance_id'
    ");
    $row = $query->fetch_array(MYSQLI_ASSOC);

    if ($row['img']) {
        $image = $media_dir . $row['folder'] . $row['img'];
        if (file_exists($image)) {
            unlink($image);
        }
    }
    if ($row['thumb_img']) {
        $image = $media_dir . $row['folder'] . $row['thumb_img'];
        if (file_exists($image)) {
            unlink($image);
        }
    }
    $sql = $mysqli->query("     
      UPDATE evolve_settings
      SET 
     	folder                = '',
      img                   = '',
      thumb_img             = ''
      WHERE id = '$instance_id' 
    ");
}// /SITE SETTINGS
    if ($module_id == 14) {//TESTIMONIAL MODUL
        $query = $mysqli->query("
      SELECT img, folder, thumb_img
      FROM evolve_testimonials       
      WHERE evolve_testimonials.id = '$instance_id'
    ");
        $row = $query->fetch_array(MYSQLI_ASSOC);

        if ($row['img']) {
            $image = $media_dir . $row['folder'] . $row['img'];
            if (file_exists($image)) {
                unlink($image);
            }
        }
        if ($row['thumb_img']) {
            $image = $media_dir . $row['folder'] . $row['thumb_img'];
            if (file_exists($image)) {
                unlink($image);
            }
        }
        $sql = $mysqli->query("     
      UPDATE evolve_testimonials
      SET 
      folder                = '',
      img                   = '',
      thumb_img             = ''
      WHERE id = '$instance_id' 
    ");
    }// /TESTIMONIAL
    if ($module_id == 15) {//SHOP MODUL
        if ($module_child_id == 2) {//SINGLE PRODUCT
            $get_item = $mysqli->query("
      SELECT img, folder, thumb_img
      FROM evolve_products       
      WHERE evolve_products.id = '$instance_id'
    ");
            $item = $get_item->fetch_array(MYSQLI_ASSOC);

            if ($item['img']) {
                $image = $media_dir . $item['folder'] . $item['img'];
                if (file_exists($image)) {
                    unlink($image);
                }
            }
            if ($item['thumb_img']) {
                $image = $media_dir . $item['folder'] . $item['thumb_img'];
                if (file_exists($image)) {
                    unlink($image);
                }
            }
            $sql = $mysqli->query("     
      UPDATE evolve_products
      SET 
      folder                = '',
      img                   = '',
      show_cover_img        = 0, 
      thumb_img             = ''
      WHERE id = '$instance_id' 
    ");
        }// /SINGLE PRODUCT
        else if ($module_child_id == 4) {//SINGLE RUBRIC
            $get_category = $mysqli->query("
      SELECT img, folder, thumb_img
      FROM evolve_product_category
      WHERE evolve_product_category.id = '$instance_id'
    ");
            $cat_item = $get_category->fetch_array(MYSQLI_ASSOC);

            if ($cat_item['img']) {
                $image = $media_dir . $cat_item['folder'] . $cat_item['img'];
                if (file_exists($image)) {
                    unlink($image);
                }
            }
            if ($cat_item['thumb_img']) {
                $image = $media_dir . $cat_item['folder'] . $cat_item['thumb_img'];
                if (file_exists($image)) {
                    unlink($image);
                }
            }
            $sql = $mysqli->query("
      UPDATE evolve_product_category
      SET
      folder                = '',
      img                   = '',
      thumb_img             = ''
      WHERE id = '$instance_id'
    ");
        }// /SINGLE RUBRIC
    }// /SHOP
    if ($module_id == 16) {//Estate
        if ($module_child_id == 2) {//SINGLE Category
            $get_item = $mysqli->query("
      SELECT img, folder, thumb_img
      FROM evolve_cd_cody_licences       
      WHERE evolve_cd_cody_licences.id = '$instance_id'
    ");
            $item = $get_item->fetch_array(MYSQLI_ASSOC);

            if ($item['img']) {
                $image = $media_dir . $item['folder'] . $item['img'];
                if (file_exists($image)) {
                    unlink($image);
                }
            }
            if ($item['thumb_img']) {
                $image = $media_dir . $item['folder'] . $item['thumb_img'];
                if (file_exists($image)) {
                    unlink($image);
                }
            }
            $sql = $mysqli->query("     
      UPDATE evolve_cd_cody_licences
      SET 
      folder                = '',
      img                   = '',
      show_cover_img        = 0, 
      thumb_img             = ''
      WHERE id = '$instance_id' 
    ");
        }// /SINGLE Item
        else if ($module_child_id == 4) {//SINGLE Category
            $get_category = $mysqli->query("
      SELECT img, folder, thumb_img
      FROM evolve_cd_cody_list
      WHERE evolve_cd_cody_list.id = '$instance_id'
    ");
            $cat_item = $get_category->fetch_array(MYSQLI_ASSOC);

            if ($cat_item['img']) {
                $image = $media_dir . $cat_item['folder'] . $cat_item['img'];
                if (file_exists($image)) {
                    unlink($image);
                }
            }
            if ($cat_item['thumb_img']) {
                $image = $media_dir . $cat_item['folder'] . $cat_item['thumb_img'];
                if (file_exists($image)) {
                    unlink($image);
                }
            }
            $sql = $mysqli->query("
      UPDATE evolve_cd_cody_list
      SET
      folder                = '',
      img                   = '',
      thumb_img             = ''
      WHERE id = '$instance_id'
    ");
        }// /SINGLE Category
    }// /ESTATE

}
?>
