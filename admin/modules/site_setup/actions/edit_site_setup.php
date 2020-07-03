<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } 
security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check

if (isset($_POST['instanceID'])) {
  $instance_id           = $mysqli->real_escape_string($_POST['instanceID']);
  $admin_domain          = $mysqli->real_escape_string($_POST['admin_domain']);
  $header_script         = $mysqli->real_escape_string($_POST['header_script']);
  $footer_script         = $mysqli->real_escape_string($_POST['footer_script']);
  $facebook              = $mysqli->real_escape_string($_POST['facebook']);
  $twitter               = $mysqli->real_escape_string($_POST['twitter']);
  $youtube               = $mysqli->real_escape_string($_POST['youtube']);
  $instagram             = $mysqli->real_escape_string($_POST['instagram']);
  $googleplus            = $mysqli->real_escape_string($_POST['googleplus']);
  $dribbble              = $mysqli->real_escape_string($_POST['dribbble']);
  $linkedin              = $mysqli->real_escape_string($_POST['linkedin']);
  $github                = $mysqli->real_escape_string($_POST['github']);
  $dropbox               = $mysqli->real_escape_string($_POST['dropbox']);
  $skype                 = $mysqli->real_escape_string($_POST['skype']);
  $facebook_block        = $mysqli->real_escape_string($_POST['facebook_block']);
  $theme                 = $mysqli->real_escape_string($_POST['theme']);
  $google_verif          = $mysqli->real_escape_string($_POST['google_verif']);
  $company_name          = $mysqli->real_escape_string($_POST['company_name']);
  $company_email         = $mysqli->real_escape_string($_POST['company_email']);
  $company_tel           = $mysqli->real_escape_string($_POST['company_tel']);
  $home_custom_box1      = $mysqli->real_escape_string($_POST['home_custom_box1']);
  



   $sql = $mysqli->query("     
        UPDATE evolve_settings
        SET 
      
        header_script   = '$header_script',
        footer_script   = '$footer_script',
        facebook        = '$facebook',
        twitter         = '$twitter',
        youtube         = '$youtube',
        instagram       = '$instagram',
        googleplus      = '$googleplus',
        dribbble        = '$dribbble',
        linkedin        = '$linkedin',
        github          = '$github',
        dropbox         = '$dropbox',
        google_verif    = '$google_verif',
        skype           = '$skype',
        company_name    = '$company_name',
        company_email   = '$company_email',
        company_tel     = '$company_tel',
        theme           = '$theme',
        facebook_block  = '$facebook_block',
        home_custom_box1= '$home_custom_box1'
        
        
        WHERE id     = '$instance_id' ");
   
  //if(!$sql) print_r($mysqli->error);    

 
 } //END

?>