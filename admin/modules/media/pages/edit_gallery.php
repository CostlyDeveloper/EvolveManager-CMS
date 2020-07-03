<?php 
  defined('ADMIN') or die();//prevent direct open
           
  
  $get_ugal = $mysqli->query("
      SELECT evolve_galleries.gallery_name
      FROM evolve_galleries       
      WHERE evolve_galleries.id = $instance_id
      "); 
      //if(!$get_ugal) print_r($mysqli->error);
      $ugal = $get_ugal->fetch_array(MYSQLI_ASSOC);
   
   $get_media = $mysqli->query("
      SELECT evolve_galleries.gallery_name, evolve_media.*
      FROM evolve_galleries
      
      LEFT JOIN evolve_gallery_items
      ON evolve_gallery_items.gallery_id = evolve_galleries.id
      
      LEFT JOIN evolve_media
      ON evolve_gallery_items.media_id = evolve_media.id
          
      WHERE evolve_gallery_items.gallery_id = '$instance_id'
      
      ");

  ?>
<input type="hidden" name="page_title" value="<?php echo $lang['media_library']; ?>" />
<input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_id; ?>" />
<div class="right_col" role="main">
  <div class="">
  <div class="input-group">
        <a href="index.php?galleries" class="btn btn-default"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
      </div>
    <div class="page-title">
      <div class="title_left">
        <h3> <?php echo $lang['gallery_name'] .': '.$ugal['gallery_name'] ?> </h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-8">
        <div class="x_panel">
          <div class="x_title">
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row"  id="media_wrapper">
              <p id="media_wrapper_tagline"><?php echo $lang['media_library_items']; ?></p>
              <?php    
                while($media = $get_media->fetch_assoc()){
                
                   $imgsrc = $domain.$media['folder'].$media['filename'];
                   if($media['thumb']){
                       $imgsrc = $domain.$media['folder'].$media['thumb'];
                   }
                    ?>
              <div class="col-md-3 media_item_outer" id="parentpic_<?php echo $media['id']; ?>">
                <div class="thumbnail" id="selected_<?php echo $media['id']; ?>">
                  <span class="badge bg-blue media_selected hidden"><i class="icon-check fa fa-check"></i></span>
                  <div class="image view view-first media_image cursor_cell" data-id="<?php echo $media['id']; ?>">
                    <img style="width: 100%; display: block;" class="lazyload" data-src="<?php echo $imgsrc; ?>" alt="image" />
                    <div class="mask">
                      <div class="tools tools-bottom">
                        <span class="hidden" id="imgpath"><?php echo $imgsrc; ?></span>
                        <span class="media_pic_button pointer" id="copyToClipboard"><i class="fa fa-link"></i></span>
                        <span class="media_pic_button pointer edit_media"><i class="fa fa-pencil"></i></span>
                        <span id="gal_remove" class="media_pic_button pointer delete_media"><i class="fa fa-minus"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="caption">
                    <ul class="list-unstyled media_desc">
                      <li><small><?php echo $lang['media_size'].': '.formatSizeUnits($media['size']); ?></small>
                      </li>
                      <li><small><?php echo $lang['media_dimensions'].': '.$media['width'].' x '.$media['height'].' px'; ?></small>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4" id="dynamic_media_siedebar_wrapper">
        <div class="x_panel">
          <!-- upload form -->
          <div class="x_title">
            <h2><?php echo $lang['upload_media']; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row">
              <p><?php echo $lang['select_file']; ?></p>
              <form class="dropzone" action="modules/media/actions/upload_media.php" method="POST">
                <input type="hidden" name="galleryid" value="<?php echo $instance_id; ?>" />
                <input type="hidden" name="module_id" value="<?php echo $module_id; ?>" />
              </form>
            </div>
          </div>
        </div>
        <!-- / upload form -->
      </div>
    </div>
  </div>
</div>