<?php
$get_media = $mysqli->query("
  SELECT evolve_gallery_items.*, evolve_media_alt.*
  FROM evolve_gallery_items  
  
  LEFT JOIN evolve_media_alt
  ON evolve_media_alt.for_media = evolve_gallery_items.media_id
    AND evolve_media_alt.for_lang =  '$language'
  WHERE evolve_gallery_items.gallery_id = '$gal_id' 
");

if ($get_media->num_rows > 0) { ?>
<div class="margin-bottom-40">
<h2 class="with_line"><div><?php lang('related_gallery_title')?></div></h2>
    <div class="clearfix"></div>  
    
    
<div class="owl-carousel owl-article_gallery owl-theme">
  <?php while($media = $get_media->fetch_assoc()){
        $imgsrc = $data['domain'].$media['folder'].$media['filename'];
        $thumbsrc = $data['domain'].$media['folder'].$media['thumb'];
        
        ?>
  <div class="item temp_hidden none">
    <a href="<?php echo $imgsrc; ?>" class="swipebox" title="<?php echo $media['content']?>" rel="gallery-1">
      <img src="<?php echo $thumbsrc; ?>" alt="Image" style="max-width:100%;"/>
    </a>
  </div>
  <?php } ?>
</div>  
</div> 
<?php } ?>