<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } 
security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check

if (isset($_POST['dimensionID'])) {
  $dimension_id          = $mysqli->real_escape_string($_POST['dimensionID']);
  $dimension_name        = $mysqli->real_escape_string($_POST['dimName']);
  $widthBig              = $mysqli->real_escape_string($_POST['widthBig']);
  $heightBig             = $mysqli->real_escape_string($_POST['heightBig']);  
  $qualityBig            = $mysqli->real_escape_string($_POST['qualityBig']);
  $wmark_positionBig     = $mysqli->real_escape_string($_POST['wmark_positionBig']);
  $wmark_opacityBig      = $mysqli->real_escape_string($_POST['wmark_opacityBig']);
  //$watermark_imgBig      = $mysqli->real_escape_string($_POST['watermark_imgBig']);
  $wmark_ratioBig        = $mysqli->real_escape_string($_POST['wmark_ratioBig']);
  $wmark_ratioSmall      = $mysqli->real_escape_string($_POST['wmark_ratioSmall']);
  $wmark_positionSmall   = $mysqli->real_escape_string($_POST['wmark_positionSmall']);
  $wmark_opacitySmall    = $mysqli->real_escape_string($_POST['wmark_opacitySmall']);
  //$watermark_imgSmall    = $mysqli->real_escape_string($_POST['watermark_imgSmall']);
  $widthSmall            = $mysqli->real_escape_string($_POST['widthSmall']); 
  $heightSmall           = $mysqli->real_escape_string($_POST['heightSmall']); 
  $qualitySmall          = $mysqli->real_escape_string($_POST['qualitySmall']);
  
   //Checkboxed    
  if (isset($_POST['enableSmall'])) {
    $enableSmall = 1;} else{ $enableSmall = 0; }
  if (isset($_POST['cropSmall'])) {
    $cropSmall = 1;} else{ $cropSmall = 0; }
  if (isset($_POST['graySmall'])) {
    $graySmall = 1;} else{ $graySmall = 0; }
  if (isset($_POST['cropBig'])) {
    $cropBig = 1;} else{ $cropBig = 0; }
  if (isset($_POST['grayBig'])) {
    $grayBig = 1;} else{ $grayBig = 0; }
  if (isset($_POST['watermark_enableBig'])) {
    $watermark_enableBig = 1;} else{ $watermark_enableBig = 0; }
  if (isset($_POST['watermark_enableSmall'])) {
    $watermark_enableSmall = 1;} else{ $watermark_enableSmall = 0; }
    
    
    $unique = $mysqli->query("
          CREATE UNIQUE INDEX dim_index 
          ON evolve_dimensions_data (type, for_dimension)");        

    $sql = $mysqli->query("  
          INSERT INTO evolve_dimensions_data (width, height, quality, crop, type, for_dimension, gray) 
          VALUES ('$widthBig', '$heightBig', '$qualityBig', '$cropBig', '1', '$dimension_id', '$grayBig')
          ON DUPLICATE KEY UPDATE
          width               = '$widthBig', 
          height              = '$heightBig',
          quality             = '$qualityBig',
          crop                = '$cropBig',
          gray                = '$grayBig',
          watermark_enable    = '$watermark_enableBig',
          watermark_opacity   = '$wmark_opacityBig',
          watermark_position  = '$wmark_positionBig',
          watermark_ratio     = '$wmark_ratioBig'
          ");
      
    $unique = $mysqli->query("
          ALTER TABLE evolve_dimensions_data
          DROP INDEX dim_index;");
              
if ($enableSmall === 1){ //Edit or create thumb
    
    $unique = $mysqli->query("
          CREATE UNIQUE INDEX dim_index 
          ON evolve_dimensions_data (type, for_dimension)");        

    $sql = $mysqli->query("  
          INSERT INTO evolve_dimensions_data (width, height, quality, crop, type, for_dimension, gray) 
          VALUES ('$widthSmall', '$heightSmall', '$qualitySmall', '$cropSmall', '2', '$dimension_id', '$graySmall')
          ON DUPLICATE KEY UPDATE
          width          = '$widthSmall', 
          height         = '$heightSmall',
          quality        = '$qualitySmall',
          crop           = '$cropSmall',
          gray           = '$graySmall',
          watermark_enable    = '$watermark_enableSmall',
          watermark_opacity   = '$wmark_opacitySmall',
          watermark_position  = '$wmark_positionSmall',
          watermark_ratio     = '$wmark_ratioSmall'
          ");
      
    $unique = $mysqli->query("
          ALTER TABLE evolve_dimensions_data
          DROP INDEX dim_index;");    
    
   }else{
    
    $sql = $mysqli->query("
          DELETE FROM evolve_dimensions_data 
          WHERE type = 2 and for_dimension = '$dimension_id'");
   }
              
   $sql = $mysqli->query("     
          UPDATE evolve_dimensions_img
          SET 
          name           = '$dimension_name'
          WHERE id = '$dimension_id' ");  

//LOOP THROUGH MODULES          
$get_modules = $mysqli->query("
    SELECT evolve_modules.*
    FROM evolve_modules    
    ");
while($mod = $get_modules->fetch_assoc()){
  
  $mod_id = $mod['id'];
  
  //Checkboxed    
  if (isset($_POST['module_'.$mod_id])) {
    $unique = $mysqli->query("
          CREATE UNIQUE INDEX mod_index 
          ON evolve_dimensions_relations (for_module, for_dimension)");        

    $sql = $mysqli->query("  
          INSERT INTO evolve_dimensions_relations (for_module,  for_dimension) 
          VALUES ('$mod_id', '$dimension_id')
          ON DUPLICATE KEY UPDATE
          for_module     = '$mod_id'  
          ");
          
    $unique = $mysqli->query("
          ALTER TABLE evolve_dimensions_relations
          DROP INDEX mod_index;");  
    }else{
      
      $sql = $mysqli->query("
          DELETE FROM evolve_dimensions_relations 
          WHERE for_module = '$mod_id' and for_dimension = '$dimension_id'");
      }
  
  }              
          
}
?>