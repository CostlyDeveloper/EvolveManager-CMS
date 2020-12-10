<?php

function get_evolve_caching_suffix()
{
    global $developing, $ver;
    if ($developing) {
        $date = new DateTime();
        return $date->getTimestamp();
    } else {
        return $ver;
    }
}

function get_avatar($filename)
{

	if (substr($filename, 0, 7) == 'default') {
		return CHAT_URL . 'default_images/' . $filename;
	} else {
		return CHAT_URL . 'avatar/' . $filename;
	}
}

function recordPostPageView($instance_id, $table, $notify_mysql_interval = 3)
{
	global $mysqli, $data;

	if ($data['memcache']) {

		$memcache = new Memcache();
		$memcache->connect('localhost', 11211);

		if (!$memcache->get($table . $instance_id)) {
			$memcache->set($table . $instance_id, 1);
		} else {
			$memcache->increment($table . $instance_id, 1);
		}

		$new_count = $memcache->get($table . $instance_id);

		// Cron
		if ($new_count % $notify_mysql_interval == 0) {
			$sql = $mysqli->query("  
          INSERT INTO {$table} (for_instance, date, counter) 
          VALUES ('$instance_id', NOW(), '$notify_mysql_interval')
          ON DUPLICATE KEY UPDATE
          counter      = counter + '$notify_mysql_interval' 
          ");
		}

	}//if memcache
	else {
		$sql = $mysqli->query("  
          INSERT INTO {$table} (for_instance, date) 
          VALUES ('$instance_id', NOW())
          ON DUPLICATE KEY UPDATE
          counter      = counter + 1 
          ");

	}

}

function get_menu($menu_id, $footer = null)
{
	global $mysqli, $language;

	$get_menu = $mysqli->query("
        SELECT evolve_menus_relations.*, evolve_menus_data.*, evolve_menus_relations.id as item_id
        FROM evolve_menus_relations
        LEFT JOIN evolve_menus_data
        ON evolve_menus_data.for_instance = evolve_menus_relations.id
        WHERE evolve_menus_relations.for_instance = '$menu_id'
          AND evolve_menus_data.lang = '$language'
        ORDER BY evolve_menus_relations.position
        ");
	if (!$get_menu) print_r($mysqli->error); ?>
    <ul <?php echo($footer ? 'class="list-unstyled footer_menu"' : ''); ?>>
		<?php while ($men = $get_menu->fetch_assoc()) {
			if ($men['level'] == 1) {
				if ($men['name']) {
					?>
                    <li class="<?php echo($men['have_child'] ? 'dropdown' : 'dropdown-submenu'); ?>">
						<?php echo($footer ? '' : ''); ?>
                        <a <?php echo($men['have_child'] ? 'class="dropdown-toggle"  data-toggle="dropdown" data-target="#"' : ''); ?>
                                href="<?php
								if ($men['url']) {
									echo $men['url'];
								} elseif ($men['uri']) {
									echo FRONTEND_URL . $men['uri'];
								} else {
									?>
            javascript:;
          <?php }
								?>">
							<?php echo $men['name']; ?>
                        </a>
						<?php if ($men['have_child']) {
							get_next_level_menu_items($menu_id, $men['item_id'], $men['level'], $footer);
						} ?>
                    </li>
				<?php }//IF have name

			} //If is not submenu element

		} ?>
    </ul>
	<?php
}

function get_next_level_menu_items($menu_id, $parent_id, $parent_level, $footer = null)
{
	global $mysqli, $language;

	$level = $parent_level + 1;
	$query = $mysqli->query("
    SELECT evolve_menus_relations.*, evolve_menus_data.*, evolve_menus_relations.id as item_id
    FROM evolve_menus_relations  
    LEFT JOIN evolve_menus_data
    ON evolve_menus_data.for_instance = evolve_menus_relations.id    
    WHERE evolve_menus_relations.for_instance = '$menu_id'
      AND evolve_menus_relations.child_of = '$parent_id'
      AND evolve_menus_data.lang = '$language'
      AND level = '$level' 
    ORDER BY evolve_menus_relations.position
  ");
	if ($query->num_rows > 0) { ?>
        <ul class="<?php echo($footer ? 'footer_dropdown-menu' : 'dropdown-menu'); ?>">
			<?php while ($row = $query->fetch_assoc()) {
				if ($row['name']) { ?>
                    <li class="<?php echo($row['have_child'] ? 'dropdown-submenu' : 'dropdown'); ?>">
                        <a href="<?php
						if ($row['url']) {
							echo $row['url'];
						} elseif ($row['uri']) {
							echo FRONTEND_URL . $row['uri'];
						}
						?>">
							<?php if ($row['have_child']) { ?>
								<?php echo($footer ? '' : '<i class="fa fa-angle-right"></i> '); ?>
							<?php } ?>
							<?php echo $row['name']; ?>
                        </a>
						<?php if ($row['have_child']) {
							get_next_level_menu_items($menu_id, $row['item_id'], $row['level'], $footer);
						} ?>
                    </li>
				<?php } // IF submenu name exist
			} //while submenu items ?>
        </ul>
	<?php }
}

function limitStrlen($input, $length, $ellipses = true, $strip_html = true)
{
	//strip tags, if desired
	if ($strip_html) {
		$input = strip_tags($input);
	}

	//no need to trim, already shorter than trim length
	if (strlen($input) <= $length) {
		return $input;
	}

	//find last space within length
	$last_space = strrpos(substr($input, 0, $length), ' ');
	if ($last_space !== false) {
		$trimmed_text = substr($input, 0, $last_space);
	} else {
		$trimmed_text = substr($input, 0, $length);
	}
	//add ellipses (...)
	if ($ellipses) {
		$trimmed_text .= '...';
	}

	return $trimmed_text;
}

function array_flatten($array)
{
	if (!is_array($array)) {
		return FALSE;
	}
	$result = array();
	foreach ($array as $key => $value) {
		if (is_array($value)) {
			$result = array_merge($result, array_flatten($value));
		} else {
			$result[$key] = $value;
		}
	}
	return $result;
}

function video_info($video_id, $language)
{
	global $mysqli;

	$get_video = $mysqli->query("
      SELECT evolve_video.*, evolve_video_data.*
      FROM evolve_video
          
      LEFT JOIN evolve_video_data
      ON evolve_video_data.for_video = evolve_video.id
        AND evolve_video_data.for_lang =  '$language'
        
      WHERE evolve_video.id = '$video_id'
      ");
	///if(!$get_video) print_r($mysqli->error);

	$vid = $get_video->fetch_array(MYSQLI_ASSOC);

	if ($vid) {
		return $vid;
	} else {
		return false;
	}
}

function article_category_slug($instance_seo_id)
{
	global $mysqli, $language;

	$get_article = $mysqli->query("
      SELECT evolve_articles_data.lang, evolve_articles.category
      FROM evolve_articles_data
      
      RIGHT JOIN evolve_articles
      ON evolve_articles_data.for_article = evolve_articles.id
    
      WHERE evolve_articles_data.seo_id = '$instance_seo_id'
    ");

	if (!$get_article) print_r($mysqli->error);

	$row = $get_article->fetch_array(MYSQLI_ASSOC);

	$innstance_lang = $row['lang'];
	$category_id = $row['category'];

	//if Lang is enabled in db
	$chk_lang_is_enabled = $mysqli->query("
      SELECT evolve_multilang.id
      FROM evolve_multilang
    
      WHERE slug = '$innstance_lang'
        AND enabled = '1'
    ");

	if ($chk_lang_is_enabled->num_rows > 0) {

		$get_cat_seo = $mysqli->query("
        SELECT evolve_article_rubrics_data.seo_id
        FROM evolve_article_rubrics_data
      
        WHERE lang = '$innstance_lang'
          AND for_instance_id = '$category_id'
      ");

		//if(!$get_cat_seo) print_r($mysqli->error);

		$row = $get_cat_seo->fetch_array(MYSQLI_ASSOC);


		return $row['seo_id'];
	}//if lang is not enable return false
	return false;
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
		$mod = $modules->fetch_array(MYSQLI_BOTH);
		if ($mod['media_folder']) {
			return $mod['media_folder'];
		} else {
			return false;
		}
	} else {
		return false;
	}
}

?>
