

<?php 
  while($row = $res_data->fetch_assoc()){
   $item_id             = $row['id'];
   $thumb_imgsrc        = $upload_folder.$row['folder'].$row['thumb_img'];
   if(!$row['thumb_img']){
     $thumb_imgsrc   = FRONTEND_URL.'/media/upload/site/'.$data['og_thumb_img'];
   } 
   //pr($row);
  ?>
<div class="row">
  <div class="col-md-4 col-sm-4">
    <img class="img-responsive" alt="" src="<?php echo $thumb_imgsrc ?>" />
  </div>
  <div class="col-md-8 col-sm-8">
    <h2><a href="<?php echo $cat_url.$row['seo_id'] ?>"><?php echo $row['title'] ?></a></h2>
    <?php if( $row['description']){ ?>
    <p><?php echo $row['description'] ?></p>
    <?php }?>
    <a href="<?php echo $cat_url.$row['seo_id'] ?>" class="more"><?php lang('read_more')?> <i class="fa fa-angle-right" aria-hidden="true"></i>
    </a>
    <?php if ($row['show_author'] OR $row['keywords'] OR $row['show_date']){ ?>
    <ul class="blog-info">
      <?php if ($row['show_date']){
        $date = date('d.m.Y', strtotime($row['date'])); ?>
      <li><i class="fa fa-calendar"></i> <?php echo $date ?></li>
      <?php  }?>
      <?php if ($row['keywords']){
        $keywords = explode(',', $row['keywords']); 
        $keywords = implode(', ', $keywords);
        ?>
      <li><i class="fa fa-tags"></i> <?php echo $keywords ?> </li>
      <?php  }?>
    </ul>
    <?php }?>
  </div>
</div>
<hr/>
<?php }?>

