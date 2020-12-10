<?php
$get_webcams_cat = $mysqli->query("
    SELECT evolve_webcam_cat.*, evolve_webcam_cat_data.*, evolve_webcam_cat.id as wcat_id
    FROM evolve_webcam_cat
    
    
    LEFT JOIN evolve_webcam_cat_data
    ON evolve_webcam_cat_data.for_instance_id = evolve_webcam_cat.id
      AND evolve_webcam_cat_data.lang =  '$language'
    ORDER BY evolve_webcam_cat.position ASC 
    ");
    

?>

<!-- CATEGORIES START -->
<h4><?php lang_string('categories_block_title')?></h4>
<ul class="nav sidebar-categories margin-bottom-40">
<?php while($cat = $get_webcams_cat->fetch_assoc()){ ?>
  <li <?php echo is_in_this_cat($cat['wcat_id'], $webcam_id)?> ><a href="<?php echo FRONTEND_URL.$cat['seo_id'] ?>"><?php echo $cat['name'];?> (<?php echo number_cat_instances($cat['wcat_id']) ?>)</a></li>
<?php } ?>
</ul>
<!-- CATEGORIES END -->