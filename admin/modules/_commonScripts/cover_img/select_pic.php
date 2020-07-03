<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");

if (!isset($_GET['userID']) || !isset($_GET['cpass']) || !isset($_GET['token']) || !isset($_GET['rdts'])){ die_500(); } 
security($_GET['userID'], $_GET['cpass'], $_GET['token'], $_GET['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_GET['userID'], $_GET['moduleID'], true);//Second check
  
  $get_media = $mysqli->query("
    SELECT evolve_media.*
    FROM evolve_media
    ORDER BY id DESC
  ");
  /*$all_gal = $mysqli->query("
    SELECT evolve_galleries.*
    FROM evolve_galleries       
    ORDER BY id DESC
  "); */

  ?>
<div class="x_panel" id="confirm_media_library">
  <div class="x_title">
    <div id="submit_new_gallery"></div>
    <h2><?php echo $lang['menu_media_library']; ?></h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <form class="dropzone_fly" action="modules/media/actions/upload_media.php" method="POST">
      <input type="hidden" name="module_id" value="1" />
      <input type="hidden" name="flying_block" value="1" />
      <div class="dz-message btn btn-primary btn-sm" data-dz-message><span><?php echo $lang['upload_on_fly_btn']; ?></span></div>
      <div class="dz-preview dz-processing dz-image-preview dz-complete"></div>
    </form>
    <strong>
      <p id="media_wrapper_tagline"><?php echo $lang['media_library_fly']; ?></p>
    </strong>
    <div id="cover_input_data"></div>
    <?php    
      while($media = $get_media->fetch_assoc()){
      
         $imgsrc = $domain.$media['folder'].$media['filename'];
         if($media['thumb']){
             $imgsrc = $domain.$media['folder'].$media['thumb'];
         }
          ?>
    <div class="col-md-3 media_item_outer" id="parentpic_<?php echo $media['id']; ?>">
      <div class="thumbnail" id="selected_<?php echo $media['id']; ?>">
        <span class="badge coverImgCheck bg-blue hidden"><i class="icon-check fa fa-check"></i></span>
        <div class="image view view-first cover_image cursor_cell" id="pic_<?php echo $media['id']; ?>" >
          <img style="width: 100%; display: block;" class="lazyload" data-src="<?php echo $imgsrc; ?>" alt="image" />
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