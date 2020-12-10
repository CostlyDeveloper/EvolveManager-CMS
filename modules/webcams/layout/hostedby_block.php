<?php 
$hostedsrc = $data['domain'].'/media/upload/webcams'.$webcam['hosted_folder'].$webcam['hosted_image'];
?>
<div class="x_panel text-center">
  <div class="x_title">
    <h5 class="webcam-hosted-title"><?php lang_string('webcam_hosted_by') ?>: <a href="<?php echo $webcam['hosted_url']; ?>"> <?php echo $webcam['hosted_name']?></a></h5>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <a href="<?php echo $webcam['hosted_url']; ?>" class="swipebox lazyload_parent" title="<?php echo $webcam['hosted_name']?>" >
      <img class="lazyload" src="<?php echo $preloader; ?>" data-src="<?php echo $hostedsrc; ?>" alt="Image" style="max-width:100%;"/>
    </a>
  </div>
</div>