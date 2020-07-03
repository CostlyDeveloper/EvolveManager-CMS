<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root . "/system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])) {
	die_500();
}
security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check

if (isset($_POST['coverID'])) {
	$media_id = $mysqli->real_escape_string($_POST['coverID']);
	$instance_id = $mysqli->real_escape_string($_POST['instanceID']);
	$dim_id = $mysqli->real_escape_string($_POST['dim']);
	$module_id = $mysqli->real_escape_string($_POST['moduleID']);
	$module_child_id = $mysqli->real_escape_string($_POST['moduleChildID']);
	$sub_form = $mysqli->real_escape_string($_POST['sub_form']);

	$get_img = $mysqli->query("
    SELECT filename, folder
    FROM evolve_media       
    WHERE evolve_media.id = '$media_id'
  ");
	$img = $get_img->fetch_array(MYSQLI_ASSOC);
	$get_module = $mysqli->query("
    SELECT slug, media_folder
    FROM evolve_modules       
    WHERE evolve_modules.id = '$module_id'
  ");
	$mod = $get_module->fetch_array(MYSQLI_ASSOC);
	$date_folder = '/' . date('Y-m') . '/';
	if ($module_id == 11) {
		$date_folder = '/';
	}
	$fileName = $img['filename'];
	$exploded_filename = explode(".", $fileName);//rename filename
	$extension = end($exploded_filename);//rename filename
	$new_fileName = $mod['slug'] . time() . '.' . $extension;//filename renamed
	$folder_const = $mod['media_folder'] . $date_folder;
	$media_dir = $to_root . $folder_const;

	if (!is_dir($media_dir)) {
		mkdir($media_dir, 0777, true);
	}
	//Dimension options
	$get_dimensions = $mysqli->query("
    SELECT evolve_dimensions_data.*
    FROM evolve_dimensions_data 
    WHERE evolve_dimensions_data.for_dimension = '$dim_id'
  ");
	while ($dim = $get_dimensions->fetch_assoc()) {
		$width = $dim['width'];
		$height = $dim['height'];
		$jpgquality = $dim['quality'];
		$crop = $dim['crop'];
		$gray = $dim['gray'];
		$watermark = '';
		$watermark_opacity = '';
		$watermark_position = '';
		$watermark_ratio = '';
		if ($dim['watermark_enable']) {
			$watermark = $to_root . $dim['watermark_folder'] . $dim['watermark'];
			$watermark_opacity = $dim['watermark_opacity'];
			$watermark_position = $dim['watermark_position'];
			$watermark_ratio = $dim['watermark_ratio'];
		}
		$src = $to_root . $img['folder'] . $fileName;

		if ($dim['type'] == 2) {
			$prefix = 'tn_';
			$thumb_name = $prefix . $new_fileName;
		} else {
			$prefix = '';
		}
		$dst = $media_dir . $prefix . $new_fileName;
		image_resize($src, $dst, $width, $height, $crop, $jpgquality, $gray, $watermark, $watermark_opacity, $watermark_position, $watermark_ratio);
	}
	//check Thump name if exist
	$get_dim_thumb = $mysqli->query("
    SELECT evolve_dimensions_data.*
    FROM evolve_dimensions_data 
    WHERE evolve_dimensions_data.for_dimension = '$dim_id'
      and evolve_dimensions_data.type = 2 
  ");
	if ($get_dim_thumb->num_rows > 0) {
		$prefix = 'tn_';
		$thumb_name = $prefix . $new_fileName;
	} else {
		$prefix = '';
		$thumb_name = null;
	}
	//Update info in DB
	if ($module_id == 2) {//VIDEO MODULE
		$get_video = $mysqli->query("
      SELECT evolve_video.*
      FROM evolve_video       
      WHERE evolve_video.id = '$instance_id'
    ");
		$vid = $get_video->fetch_array(MYSQLI_ASSOC);
		if ($vid['image']) {
			$image = $media_dir . $vid['image'];
			if (file_exists($image)) {
				unlink($image);
			}
		}
		if ($vid['thumb_img']) {
			$image = $media_dir . $vid['thumb_img'];
			if (file_exists($image)) {
				unlink($image);
			}
		}
		$sql = $mysqli->query("     
      UPDATE evolve_video
      SET 
     	folder                = '$date_folder',
      image                 = '$new_fileName', 
      thumb_img             = '$thumb_name'
      WHERE id = '$instance_id' 
    ");
	}// /video
	if ($module_id == 3) {//WEBCAM MODULE
		if ($module_child_id == 2) {//SINGLE WEBCAM EDIT
			if ($sub_form == 'hosted_by') {//HOSTED BY

				$get_wcam = $mysqli->query("
          SELECT hosted_image 
          FROM evolve_webcams       
          WHERE evolve_webcams.id = '$instance_id'
        ");
				$wcam = $get_wcam->fetch_array(MYSQLI_ASSOC);
				if ($wcam['hosted_image']) {
					$image = $media_dir . $wcam['hosted_image'];
					$imagetn = $media_dir . 'tn_' . $wcam['hosted_image'];
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
         	hosted_folder         = '$date_folder',
          hosted_image          = '$new_fileName'
          WHERE id = '$instance_id' 
        ");
				// /HOSTED BY
			} else {
				//COVER IMAGE
				$get_wcam = $mysqli->query("
          SELECT image, thumb_img
          FROM evolve_webcams       
          WHERE evolve_webcams.id = '$instance_id'
        ");
				$wcam = $get_wcam->fetch_array(MYSQLI_ASSOC);
				if ($wcam['image']) {
					$image = $media_dir . $wcam['image'];
					if (file_exists($image)) {
						unlink($image);
					}
				}
				if ($wcam['thumb_img']) {
					$image = $media_dir . $wcam['thumb_img'];
					if (file_exists($image)) {
						unlink($image);
					}
				}
				$sql = $mysqli->query("     
          UPDATE evolve_webcams
          SET 
         	folder                = '$date_folder',
          image                 = '$new_fileName', 
          thumb_img             = '$thumb_name'
          WHERE id = '$instance_id' 
        ");
			}// /COVER IMAGE

		} else {//SINGLE CATEGORY EDIT

			$get_wcat = $mysqli->query("
        SELECT image, thumb_img
        FROM evolve_webcam_cat       
        WHERE evolve_webcam_cat.id = '$instance_id'
      ");
			$wcat = $get_wcat->fetch_array(MYSQLI_ASSOC);
			if ($wcat['image']) {
				$image = $media_dir . $wcat['image'];
				if (file_exists($image)) {
					unlink($image);
				}
			}
			if ($wcat['thumb_img']) {
				$image = $media_dir . $wcat['thumb_img'];
				if (file_exists($image)) {
					unlink($image);
				}
			}
			$sql = $mysqli->query("     
        UPDATE evolve_webcam_cat
        SET 
       	folder                = '$date_folder',
        image                 = '$new_fileName', 
        thumb_img             = '$thumb_name'
        WHERE id = '$instance_id' 
      ");
		}
	}// /webcam
	if ($module_id == 4) {//ARTICLE MODUL
		if ($module_child_id == 2) {//SINGLE ARTICLE
			$get_item = $mysqli->query("
      SELECT img, thumb_img
      FROM evolve_articles       
      WHERE evolve_articles.id = '$instance_id'
    ");
			$art = $get_item->fetch_array(MYSQLI_ASSOC);
			if ($art['img']) {
				$image = $media_dir . $art['img'];
				if (file_exists($image)) {
					unlink($image);
				}
			}
			if ($art['thumb_img']) {
				$image = $media_dir . $art['thumb_img'];
				if (file_exists($image)) {
					unlink($image);
				}
			}
			$sql = $mysqli->query("     
      UPDATE evolve_articles
      SET 
     	folder           = '$date_folder',
      img                   = '$new_fileName', 
      thumb_img             = '$thumb_name'
      WHERE id = '$instance_id' 
    ");
		}// /SINGLE ARTICLE
		else {
			if ($module_child_id == 4) {//SINGLE RUBRIC
				$get_item = $mysqli->query("
      SELECT img, thumb_img
      FROM evolve_article_rubrics       
      WHERE evolve_article_rubrics.id = '$instance_id'
    ");
				$art = $get_item->fetch_array(MYSQLI_ASSOC);
				if ($art['img']) {
					$image = $media_dir . $art['img'];
					if (file_exists($image)) {
						unlink($image);
					}
				}
				if ($art['thumb_img']) {
					$image = $media_dir . $art['thumb_img'];
					if (file_exists($image)) {
						unlink($image);
					}
				}
				$sql = $mysqli->query("     
      UPDATE evolve_article_rubrics
      SET 
     	folder                = '$date_folder',
      img                   = '$new_fileName', 
      thumb_img             = '$thumb_name'
      WHERE id = '$instance_id' 
    ");
			}
		}// /SINGLE RUBRIC
	}// /article
	if ($module_id == 5) {//SLIDER MODUL
		$query = $mysqli->query("
      SELECT img, thumb_img
      FROM evolve_sliders       
      WHERE evolve_sliders.id = '$instance_id'
    ");
		$row = $query->fetch_array(MYSQLI_ASSOC);
		if ($row['img']) {
			$image = $media_dir . $row['img'];
			if (file_exists($image)) {
				unlink($image);
			}
		}
		if ($row['thumb_img']) {
			$image = $media_dir . $row['thumb_img'];
			if (file_exists($image)) {
				unlink($image);
			}
		}
		$sql = $mysqli->query("     
      UPDATE evolve_sliders
      SET 
     	folder               = '$date_folder',
      img                  = '$new_fileName', 
      thumb_img            = '$thumb_name'
      WHERE id = '$instance_id' 
    ");
	}// /testimonials module
	if ($module_id == 11) {//site setup

		$query = $mysqli->query("
      SELECT evolve_site_images.*
      FROM evolve_site_images      
      WHERE id = '$instance_id'
    ");
		$row = $query->fetch_array(MYSQLI_ASSOC);

		if ($sub_form == 'logo_image') {
			$old_img = $row['logo_img'];
			$old_thumb = $row['logo_thumb_img'];
			$img_table = 'logo_img';
			$thumb_table = 'logo_thumb_img';
		}
		if ($sub_form == 'logo2_image') {
			$old_img = $row['logo2_img'];
			$old_thumb = $row['logo2_thumb_img'];
			$img_table = 'logo2_img';
			$thumb_table = 'logo2_thumb_img';
		}
		if ($sub_form == 'og_image') {
			$old_img = $row['og_img'];
			$old_thumb = $row['og_thumb_img'];
			$img_table = 'og_img';
			$thumb_table = 'og_thumb_img';
		}
		if ($old_img) {
			$image = $media_dir . $old_img;
			if (file_exists($image)) {
				unlink($image);
			}
		}
		if ($old_thumb) {
			$image = $media_dir . $old_thumb;
			if (file_exists($image)) {
				unlink($image);
			}
		}
		$sql = $mysqli->query("     
      UPDATE evolve_site_images
      SET 
      $img_table              = '$new_fileName', 
      $thumb_table            = '$thumb_name'
      WHERE id = '$instance_id' 
    ");

	}// /site setup
	if ($module_id == 14) {//SLIDER MODUL
		$query = $mysqli->query("
      SELECT img, thumb_img
      FROM evolve_testimonials       
      WHERE evolve_testimonials.id = '$instance_id'
    ");
		$row = $query->fetch_array(MYSQLI_ASSOC);
		if ($row['img']) {
			$image = $media_dir . $row['img'];
			if (file_exists($image)) {
				unlink($image);
			}
		}
		if ($row['thumb_img']) {
			$image = $media_dir . $row['thumb_img'];
			if (file_exists($image)) {
				unlink($image);
			}
		}
		$sql = $mysqli->query("     
      UPDATE evolve_testimonials
      SET 
      folder               = '$date_folder',
      img                  = '$new_fileName', 
      thumb_img            = '$thumb_name'
      WHERE id = '$instance_id' 
    ");
	}// /testimonials module
	if ($module_id == 15) {
		if ($module_child_id == 2) {//SINGLE PRODUCT
			$get_item = $mysqli->query("
      SELECT img, thumb_img
      FROM evolve_products       
      WHERE evolve_products.id = '$instance_id'
    ");
			$item = $get_item->fetch_array(MYSQLI_ASSOC);
			if ($item['img']) {
				$image = $media_dir . $item['img'];
				if (file_exists($image)) {
					unlink($image);
				}
			}
			if ($item['thumb_img']) {
				$image = $media_dir . $item['thumb_img'];
				if (file_exists($image)) {
					unlink($image);
				}
			}
			$sql = $mysqli->query("     
                      UPDATE evolve_products
                      SET 
                        folder                = '$date_folder',
                        img                   = '$new_fileName', 
                        thumb_img             = '$thumb_name'
                      WHERE id = '$instance_id' 
                    ");
		}// /single item
        elseif ($module_child_id == 4) {//SINGLE Category
			$get_category = $mysqli->query("
                      SELECT img, thumb_img
                      FROM evolve_product_category
                      WHERE evolve_product_category.id = '$instance_id'
                    ");
			$cat_item = $get_category->fetch_array(MYSQLI_ASSOC);
			if ($cat_item['img']) {
				$image = $media_dir . $cat_item['img'];
				if (file_exists($image)) {
					unlink($image);
				}
			}
			if ($cat_item['thumb_img']) {
				$image = $media_dir . $cat_item['thumb_img'];
				if (file_exists($image)) {
					unlink($image);
				}
			}
			$sql = $mysqli->query("
			  UPDATE evolve_product_category
			  SET
			  folder                = '$date_folder',
			  img                   = '$new_fileName',
			  thumb_img             = '$thumb_name'
			  WHERE id = '$instance_id'
			");
		}// /single category
	}// /shop
	if ($module_id == 16) {
		if ($module_child_id == 2) {//SINGLE PRODUCT
			$get_item = $mysqli->query("
      SELECT img, thumb_img
      FROM evolve_cd_cody_licences      
      WHERE evolve_cd_cody_licences.id = '$instance_id'
    ");
			$item = $get_item->fetch_array(MYSQLI_ASSOC);
			if ($item['img']) {
				$image = $media_dir . $item['img'];
				if (file_exists($image)) {
					unlink($image);
				}
			}
			if ($item['thumb_img']) {
				$image = $media_dir . $item['thumb_img'];
				if (file_exists($image)) {
					unlink($image);
				}
			}
			$sql = $mysqli->query("     
                      UPDATE evolve_cd_cody_licences
                      SET 
                        folder                = '$date_folder',
                        img                   = '$new_fileName', 
                        thumb_img             = '$thumb_name'
                      WHERE id = '$instance_id' 
                    ");
		}// /single item
        elseif ($module_child_id == 4) {//SINGLE Category
			$get_category = $mysqli->query("
                      SELECT img, thumb_img
                      FROM evolve_cd_cody_list
                      WHERE evolve_cd_cody_list.id = '$instance_id'
                    ");
			$cat_item = $get_category->fetch_array(MYSQLI_ASSOC);
			if ($cat_item['img']) {
				$image = $media_dir . $cat_item['img'];
				if (file_exists($image)) {
					unlink($image);
				}
			}
			if ($cat_item['thumb_img']) {
				$image = $media_dir . $cat_item['thumb_img'];
				if (file_exists($image)) {
					unlink($image);
				}
			}
			$sql = $mysqli->query("
			  UPDATE evolve_cd_cody_list
			  SET
			  folder                = '$date_folder',
			  img                   = '$new_fileName',
			  thumb_img             = '$thumb_name'
			  WHERE id = '$instance_id'
			");
		}// /single category
	}// /estate
	$urlToNew = $domain . $folder_const . $new_fileName;
	?>
    <img class="cover_img img-responsive" src="<?php echo $urlToNew; ?>?<?php echo time('timestamp'); ?>" alt=""/>
<?php } ?>
