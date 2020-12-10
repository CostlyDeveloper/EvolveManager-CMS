<!-- BEGIN HEADER -->
    <div class="header">
      <div class="container">
       <?php if($data['logo_img']){ 
           $imgsrc = FRONTEND_URL.module_media_folder(11).'/'.$data['logo_img'];?>
          <a class="site-logo" href="<?php echo FRONTEND_URL; ?>"><img src="<?php echo $imgsrc; ?>" alt="<?php echo lang('site_title'); ?>"/></a>
          <?php } ?>  
        

        <a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>

        <!-- BEGIN NAVIGATION -->
        <div class="header-navigation pull-right font-transform-inherit">
          <?php echo get_menu(1) ?>
        </div>
        <!-- END NAVIGATION -->
      </div>
    </div>
    <!-- Header END -->