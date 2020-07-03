<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } 
security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check

$ml   = $mysqli->real_escape_string($_POST['lang']);

$get_strings = $mysqli->query("
  SELECT evolve_frontend_lang_strings.*
  FROM evolve_frontend_lang_strings
  GROUP BY string_name
");
if(!$get_strings) print_r($mysqli->error)
?>
<div class="x_panel">
  <div class="x_title">
    <h2><?php echo $lang['ml_strings'];?></h2>
    <ul class="nav navbar-right panel_toolbox hidden">
      <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
      </li>
    </ul>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <table id="langs"  data-lang="<?php echo $ml?>"  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th><?php echo $lang['ml_string_name'];?></th>
          <th><?php echo $lang['ml_translation'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php 
          while($str = $get_strings->fetch_assoc()){
           ?>
        <tr>
          <td><?php echo $str['string_name'];?></td>
          <td><textarea name="<?php echo $str['string_name'];?>" class="resizable_textarea form-control full_width"><?php  lang($str['string_name'], $ml) ?></textarea></td>
        </tr>
        <?php } ?>     
      </tbody>
    </table>
    <div class="clearfix"></div>
    <button type="submit" class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
  </div>
</div>