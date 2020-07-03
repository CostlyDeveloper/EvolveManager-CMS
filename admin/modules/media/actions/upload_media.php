<?php
define("ADMIN", true);
require_once("../../../../system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])){ die_500(); } security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check
  
$mkdir = '../../../../media/upload/'.date('Y-m');
  if (!is_dir($mkdir)) {
    mkdir($mkdir, 0777, true);
  }
  
  $date = date('Y-m');
  
if(isset($_FILES)){
  $slugify_filename       = slugify($_FILES["file"]["name"]);
  $fileName               = time().'_'.basename($slugify_filename);  //generate unique file name
  $targetDir              = "../../../../media/upload/$date/"; //file upload path
  $targetFilePath         = $targetDir . $fileName;
  $fileType               = pathinfo($targetFilePath,PATHINFO_EXTENSION);
  $allowTypes = array('jpg','JPG','png','PNG','jpeg','JPEG','gif','GIF');//allow certain file formats
  
  // ERR MSG    
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
   // / ERR MSG 
   
   if(is_uploaded_file($_FILES['file']['tmp_name']) ) {
     $image_info          = getimagesize($_FILES["file"]["tmp_name"]);
     $image_width         = $image_info[0];
     $image_height        = $image_info[1];
      if(in_array($fileType, $allowTypes)){
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){//upload file to server
          $message = 'File uploaded okay.';
          $size = $_FILES["file"]["size"];
          $folder = '/media/upload/'.date('Y-m').'/';
          //Dimension options
          $module_id = $_POST['module_id'];
          $get_dimensions = $mysqli->query("
          SELECT evolve_dimensions_data.*, evolve_dimensions_relations.*
          FROM evolve_dimensions_data 
          
          RIGHT JOIN evolve_dimensions_relations
          ON evolve_dimensions_relations.for_dimension = evolve_dimensions_data.for_dimension
          
          WHERE evolve_dimensions_relations.for_module = '$module_id'
          ");          
          while($dim = $get_dimensions->fetch_assoc()){ 
            $width        = $dim['width'];
            $height       = $dim['height'];
            $jpgquality   = $dim['quality'];
            $crop         = $dim['crop'];
            $src          = $targetDir.$fileName;
            if($dim['type'] == 2){
              $prefix = 'tn_';
              $thumb_name = $prefix.$fileName;
            }else{
              $prefix = '';
            }
            $dst = $targetDir.$prefix.$fileName;
            image_resize($src, $dst, $width, $height, $crop, $jpgquality);
          } 
          $get_dim_thumb = $mysqli->query("
            SELECT evolve_dimensions_data.*, evolve_dimensions_relations.*
            FROM evolve_dimensions_data 
            
            RIGHT JOIN evolve_dimensions_relations
            ON evolve_dimensions_relations.for_dimension = evolve_dimensions_data.for_dimension
            
            WHERE evolve_dimensions_relations.for_module = '$module_id'
              and evolve_dimensions_data.type = 2 
                  
            ");
          if ($get_dim_thumb->num_rows > 0){
            $prefix = 'tn_';
            $thumb_name = $prefix.$fileName;          
          }else{
            $prefix = '';
            $thumb_name = NULL;
          }
  
          $sql = $mysqli->query("  
            INSERT INTO evolve_media (folder, filename, thumb, size, width, height) 
            VALUES('$folder', '$fileName', '$thumb_name', '$size', '$image_width', '$image_height')
          ");

         	if($sql){
            $my_id = $mysqli->insert_id; //Get ID of last inserted row from MySQL
          }
          
          if(isset($_POST['galleryid'])){//ADD RECORD TO GALLERIE
            $gallery_id = $_POST['galleryid'];
            
            //Find items then decrease num in gallery
            $gal_items = $mysqli->query(" 
              UPDATE evolve_galleries
              SET evolve_galleries.total_media = evolve_galleries.total_media + 1     
              WHERE evolve_galleries.id = $gallery_id
            "); 
            
            $sql = $mysqli->query("  
              INSERT INTO evolve_gallery_items (gallery_id, media_id, thumb, filename, folder) 
              VALUES ('$gallery_id', '$my_id', '$thumb_name', '$fileName', '$folder')      
              ");   
          }            
          $imgsrc = $domain.$folder.$prefix.$fileName;
          if (isset($_POST['flying_block'])){
           $response['thumb'] = '<div class="col-md-3 media_item_outer" id="parentpic_'. $my_id.'"><div class="thumbnail" id="selected_'. $my_id.'"> <span class="badge coverImgCheck bg-blue hidden"><i class="icon-check fa fa-check"></i></span> <div class="image view view-first cover_image cursor_cell" id="pic_'.$my_id.'" > <img style="width: 100%; display: block;" class="lazyload" src="'.$imgsrc.'" alt="image" /> </div> <div class="caption"> <ul class="list-unstyled media_desc"> <li><small>'.$lang['media_size'].': '.formatSizeUnits($size).'</small> </li> <li><small>'.$lang['media_dimensions'].': '.$image_width.' x '.$image_height.' px'.'</small> </li> </ul> </div> </div> </div>'; 
          }else{
          $response['thumb'] = '<div class="col-md-3 media_item_outer"id="parentpic_'.$my_id.'"><div class="thumbnail"id="selected_'.$my_id.'"><span class="badge bg-blue media_selected hidden"><i class="icon-check fa fa-check"></i></span><div class="image view view-first media_image media_pic cursor_cell"id="pic_'.$my_id.'"><img style="width: 100%; display: block;"src="'.$imgsrc.'"alt="image"/><div class="mask"><div class="tools tools-bottom"><span class="hidden"id="imgpath">'.$imgsrc.'</span><span class="media_pic_button pointer"id="copyToClipboard"><i class="fa fa-link"></i></span><span class="media_pic_button pointer edit_media"><i class="fa fa-pencil"></i></span><span class="media_pic_button pointer delete_media"><i class="fa fa-times"></i></span></div></div></div><div class="caption"><ul class="list-unstyled media_desc"><li><small>'.$lang['media_size'].': '.formatSizeUnits($size).'</small></li><li><small>'.$lang['media_dimensions'].': '.$image_width.' x '.$image_height.' px'.'</small></li></ul></div></div></div>';
            }
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