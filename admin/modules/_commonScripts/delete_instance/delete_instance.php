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
      DELETE FROM evolve_video 
      WHERE id = '$instance_id'
    ");
		$sql = $mysqli->query("
      DELETE FROM evolve_video_data 
      WHERE for_video = '$instance_id'
    ");

	}// /video

	elseif ($module_id == 3) {//WEBCAM MODUL
		$query = $mysqli->query("
      SELECT image, folder, thumb_img, hosted_image, hosted_folder
      FROM evolve_webcams       
      WHERE evolve_webcams.id = '$instance_id'
    ");
		$row = $query->fetch_array(MYSQLI_ASSOC);

		//Delete images
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
		//delete webcam
		$sql = $mysqli->query("
      DELETE FROM evolve_webcams 
      WHERE id = '$instance_id'
    ");
		$sql = $mysqli->query("
      DELETE FROM evolve_webcams_data 
      WHERE for_wcam = '$instance_id'
    ");
		//delete related videos connection
		$sql = $mysqli->query("
    DELETE FROM evolve_video_relations 
    WHERE for_instance         = '$instance_id'
     and for_module            = '$module_id'
     and for_module_child      = '$module_child_id'
  ");


	}// /WEBCAM

	elseif ($module_id == 4) {//ARTICLE MODUL
		if ($module_child_id == 1) {//ARTICLE LIST
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
        DELETE FROM evolve_articles 
        WHERE id = '$instance_id'
      ");
			$sql = $mysqli->query("
        DELETE FROM evolve_articles_data 
        WHERE for_instance = '$instance_id'
      ");
		}// /ARTICLE LIST
		elseif ($module_child_id == 3) {//RUBRIC LIST
			$get_art = $mysqli->query("
        SELECT img, folder, thumb_img
        FROM evolve_article_rubrics       
        WHERE evolve_article_rubrics.id = '$instance_id'
      ");
			$art = $get_art->fetch_array(MYSQLI_ASSOC);

			if (get_article_nr($instance_id) == 0) { //If category is empty allow delete

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
          DELETE FROM evolve_article_rubrics 
          WHERE id = '$instance_id'
        ");
				$sql = $mysqli->query("
          DELETE FROM evolve_article_rubrics_data 
          WHERE for_instance = '$instance_id'
        ");
			}// /If category is empty allow delete
			else {
				echo $lang['category_not_empty'];
			}

		}// /RUBRIC LIST

	}// /ARTICLE MODUL

	elseif ($module_id == 5) {//SLIDER
		$query = $mysqli->query("
      SELECT evolve_sliders.*
      FROM evolve_sliders       
      WHERE evolve_sliders.id = '$instance_id'
    ");
		//$row                  = $query->fetch_array(MYSQLI_ASSOC);
		if ($query->num_rows > 0) {
			//delete
			$sql = $mysqli->query("
      DELETE FROM evolve_sliders 
      WHERE id = '$instance_id'
    ");
			$sql = $mysqli->query("
      DELETE FROM evolve_sliders_data 
      WHERE for_instance = '$instance_id'
    ");
		}

	}// /SLIDER

	elseif ($module_id == 6) {//USER
		$query = $mysqli->query("
      SELECT evolve_users.id
      FROM evolve_users       
      WHERE evolve_users.id = '$instance_id'
    ");
		if ($query->num_rows > 0) {
			//delete
			$sql = $mysqli->query("
      DELETE FROM evolve_users 
      WHERE id = '$instance_id'
    ");
		}
	}// /USER

	elseif ($module_id == 7) {//USER GROUP
		$query = $mysqli->query("
      SELECT evolve_user_groups.id
      FROM evolve_user_groups       
      WHERE evolve_user_groups.id = '$instance_id'
    ");
		//if(!$query) print_r($mysqli->error);
		if ($query->num_rows > 0 OR $instance_id != 1 OR $instance_id != 2) {
			//delete
			$sql = $mysqli->query("
      DELETE FROM evolve_user_groups
      WHERE id = '$instance_id'
    ");
			//set users from current group to guest
			$sql = $mysqli->query("
      UPDATE evolve_users
      SET usr_group = 1
      WHERE usr_group = '$instance_id'
    ");

		}
	}// /USER GROUP

	elseif ($module_id == 12) {    //ADS
		$query = $mysqli->query("
      SELECT evolve_ads_data.id
      FROM evolve_ads_data      
      WHERE evolve_ads_data.id = '$instance_id'
    ");
		//$row                  = $query->fetch_array(MYSQLI_ASSOC);
		if ($query->num_rows > 0) {
			//delete
			$sql = $mysqli->query("
      DELETE FROM evolve_ads_data 
      WHERE id = '$instance_id'
    ");
		}

	}// /ADS

	elseif ($module_id == 14) {//TESTIMONIALS
		$query = $mysqli->query("
      SELECT evolve_testimonials.*
      FROM evolve_testimonials       
      WHERE evolve_testimonials.id = '$instance_id'
    ");
		if ($query->num_rows > 0) {
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

			//delete
			$sql = $mysqli->query("
      DELETE FROM evolve_testimonials 
      WHERE id = '$instance_id'
    ");
			$sql = $mysqli->query("
      DELETE FROM evolve_testimonials_data 
      WHERE for_instance = '$instance_id'
    ");
		}

	}// /TESTIMONIALS

	elseif ($module_id == 15) {//STORE MODUL
		if ($module_child_id == 1) {
			$query = $mysqli->query("
      SELECT img, folder, thumb_img
      FROM evolve_products       
      WHERE evolve_products.id = '$instance_id'
    ");
			$row = $query->fetch_array(MYSQLI_ASSOC);

			//Delete images
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
			//
			$sql = $mysqli->query("
      DELETE FROM evolve_products 
      WHERE id = '$instance_id'
    ");
			$sql = $mysqli->query("
      DELETE FROM evolve_products_data 
      WHERE for_instance = '$instance_id'
    ");
			//delete related videos connection
			$sql = $mysqli->query("
    DELETE FROM evolve_video_relations 
    WHERE for_instance         = '$instance_id'
     and for_module            = '$module_id'
     and for_module_child      = '$module_child_id'
  ");
		} elseif ($module_child_id == 3) {//RUBRIC LIST
			$get_cat = $mysqli->query("
        SELECT img, folder, thumb_img
        FROM evolve_product_category
        WHERE evolve_product_category.id = '$instance_id'
      ");
			$cat_item = $get_cat->fetch_array(MYSQLI_ASSOC);

			if (get_items_nr($instance_id, 'evolve_products') == 0) { //If category is empty allow delete

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
          DELETE FROM evolve_product_category 
          WHERE id = '$instance_id'
        ");
				$sql = $mysqli->query("
          DELETE FROM evolve_product_category_data 
          WHERE for_instance = '$instance_id'
        ");
			}// /If category is empty allow delete
			else {
				echo $lang['category_not_empty'];
			}

		}// /Category LIST
	}// /STORE

	elseif ($module_id == 16) {//ESTATE MODUL
		if ($module_child_id == 1) {
			$query = $mysqli->query("
      SELECT img, folder, thumb_img
      FROM evolve_cd_cody_licences      
      WHERE evolve_cd_cody_licences.id = '$instance_id'
    ");
			$row = $query->fetch_array(MYSQLI_ASSOC);

			//Delete images
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
			//
			$sql = $mysqli->query("
      DELETE FROM evolve_cd_cody_licences 
      WHERE id = '$instance_id'
    ");
			$sql = $mysqli->query("
      DELETE FROM evolve_cd_cody_licences_data
      WHERE for_instance = '$instance_id'
    ");
			//delete related videos connection
			$sql = $mysqli->query("
    DELETE FROM evolve_video_relations 
    WHERE for_instance         = '$instance_id'
     and for_module            = '$module_id'
     and for_module_child      = '$module_child_id'
  ");
		}
		elseif ($module_child_id == 3) {//Category LIST
			$get_cat = $mysqli->query("
        SELECT img, folder, thumb_img
        FROM evolve_cd_cody_list      
        WHERE evolve_cd_cody_list.id = '$instance_id'
      ");
			$cat_item = $get_cat->fetch_array(MYSQLI_ASSOC);

			if (get_items_nr($instance_id, 'evolve_cd_cody_licences') == 0) { //If category is empty allow delete

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
          DELETE FROM evolve_cd_cody_list
          WHERE id = '$instance_id'
        ");
				$sql = $mysqli->query("
          DELETE FROM evolve_cd_cody_data
          WHERE for_instance = '$instance_id'
        ");
			}// /If category is empty allow delete
			else {
				echo $lang['category_not_empty'];
			}

		}// /Category
	}// /ESTATE
}
?>
