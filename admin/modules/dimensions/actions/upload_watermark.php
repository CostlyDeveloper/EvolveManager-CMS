<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } 
security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check

$mkdir = '../../../../media/upload/watermarks';
  if (!is_dir($mkdir)) {
    mkdir($mkdir, 0777, true);
  }
if(isset($_FILES)){
  $slugify_filename     = slugify($_FILES["file"]["name"]);
  $dimensionID          = $_POST['dimensionID'];
  $dimensionType        = $_POST['dimensionType'];
  $fileName             = time().'_'.basename($slugify_filename);  //generate unique file name
  $targetDir            = "../../../../media/upload/watermarks/"; //file upload path
  $targetFilePath       = $targetDir . $fileName;
  $fileType             = pathinfo($targetFilePath,PATHINFO_EXTENSION);
  $allowTypes           = array('jpg','JPG','png','PNG','jpeg','JPEG','gif','GIF');//allow certain file formats
  
  //DELETE OLD ONE FILE
  $get_dim = $mysqli->query("
    SELECT evolve_dimensions_data.*
    FROM evolve_dimensions_data 
    WHERE for_dimension = '$dimensionID' AND type = '$dimensionType'
  ");
  
  $dim                  = $get_dim->fetch_array(MYSQLI_BOTH);
  $old_filename    = $targetDir.$dim['watermark'];
  if (file_exists($old_filename) && $dim['watermark']) {
    unlink($old_filename);
  }
  
  // /DELETE OLD ONE FILE
  
  
  /** ERR MSG **/     
  $message = 'Error uploading file';    
  switch( $_FILES['file']['error'] ) {
    case UPLOAD_ERR_OK:
      $message = false;
      break;
    case UPLOAD_ERR_INI_SIZE:
    case UPLOAD_ERR_FORM_SIZE:
      $message .= ' - file too large (limit of '.ini_get('upload_max_filesize').' bytes).';
      break;
    case UPLOAD_ERR_PARTIAL:
      $message .= ' - file upload was not completed.';
      break;
    case UPLOAD_ERR_NO_FILE:
      $message .= ' - zero-length file uploaded.';
      break;
      default:
      $message .= ' - internal error #'.$_FILES['file']['error'];
      break;
   }
   /** / ERR MSG **/
   
   if(is_uploaded_file($_FILES['file']['tmp_name']) ) {
     $image_info          = getimagesize($_FILES["file"]["tmp_name"]);
     $image_width         = $image_info[0];
     $image_height        = $image_info[1];
      if(in_array($fileType, $allowTypes)){
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){//upload file to server
          $message            = 'File uploaded okay.';
          $size               = $_FILES["file"]["size"];
          $folder             = '/media/upload/watermarks/';
          $width              = '';
          $height             = '';
          $jpgquality         = 100;
          $crop               = 0;
          $src                = $targetDir.$fileName;
          $prefix             = '';
          $dst                = $targetDir.$prefix.$fileName;
          image_resize($src, $dst, $width, $height, $crop, $jpgquality);         
            
          $sql = $mysqli->query("  
            UPDATE evolve_dimensions_data 
            SET watermark_folder = '$folder', watermark = '$fileName'
            WHERE for_dimension = '$dimensionID' AND type = '$dimensionType'
          ");
          //if(!$sql) print_r($mysqli->error);

         	if($sql){
            $my_id = $mysqli->insert_id; //Get ID of last inserted row from MySQL
          }
                     
          $imgsrc = $domain.$folder.$prefix.$fileName;
          $response['thumb'] = '<img src="'.$imgsrc.'" alt="image"/>';
            
        }else{ // /upload file to server
          $message = 'Error uploading file - could not save upload (this will probably be a permissions problem in '.$targetDir.')';
          $response['status'] = 'err';        
        }
    }else{
      $message = 'File type error.';
      $response['status'] = 'type_err';
    }

  }// /is_uploaded_file
  else{
    $response['status'] = 'err';    
    $message = 'Error uploading file - unknown error.';
  }
  $response['upload_message'] = $message;
    //render response data in JSON format
    echo json_encode($response);
    }
?>