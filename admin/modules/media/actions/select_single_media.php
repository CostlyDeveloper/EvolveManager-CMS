<?php 
define("ADMIN",true);
require_once ("../../../../system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check
  
if(isset($_POST['media_id'])) {
  $media_id = $mysqli->real_escape_string($_POST['media_id']);
  
  $get_img = $mysqli->query("
    SELECT folder, filename
    FROM evolve_media       
    WHERE evolve_media.id = '$media_id'
  ");
  
  if($get_img->num_rows > 0) {
    $img = $get_img->fetch_array(MYSQLI_BOTH);
    $imgsrc = $domain.$img['folder'].$img['filename'];
  
    if(isset($_POST['gallery'])) {
      echo json_encode(array('wrapper_id' => '#parentpic_'.$media_id,'thumb' => '<div class="box box_category" id="parentpic_'.$media_id.'"><div class="boxInner media_pic pointer" id="pic_'.$media_id.'"><img src="'.$imgsrc.'"/></div></div>'));
    }else { ?>
<div class="x_panel" id="media_info_block">
  <div class="x_title">
    <h2><?php echo $lang['edit_media']; ?></h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <div class="row">
      <p><?php echo $lang['choosed_media']; ?></p>
      <div id="media_edit">
        <div class="profile_img">
          <div id="crop-avatar">
            <!-- Media -->
            <img class="img-responsive avatar-view" src="<?php echo $imgsrc; ?>" alt="<?php echo $imgsrc; ?>" />
          </div>
        </div>
        <h3><?php echo $lang['img_alt_name']; ?></h3>
        <form id="submit_media_info" class="form-horizontal form-label-left" method="POST">
          <?php       $slugs_arr = languages();
            foreach($slugs_arr as $slug) { ?>
          <div class="form-group">
            <label><?php echo $slug['lang_name']; ?></label>
            <input type="text" name="media_alt_<?php echo $slug['slug']; ?>" class="form-control" value="<?php echo alt_content($media_id,$slug['slug']); ?>" />
            <input type="hidden" name="media_id" class="form-control" value="<?php echo $media_id; ?>" />
          </div>
          <?php } ?>
          <button type="submit" class="btn btn-success"><?php echo $lang['submit_media_button']; ?></button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php } } } ?>