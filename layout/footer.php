  <!-- BEGIN PRE-FOOTER -->
    <div class="pre-footer">
      <div class="container">
        <div class="row">
          
          <!-- BEGIN BOTTOM ABOUT BLOCK -->
         
          <div class="<?php echo ($data['facebook_block'] ? 'col-md-4 col-sm-6':'col-md-6 col-sm-8') ?> pre-footer-col">
          <?php if($data['logo2_img']){ 
           $imgsrc = FRONTEND_URL.module_media_folder(11).'/'.$data['logo2_img'];?>
          <a class="footer-logo" href="<?php echo FRONTEND_URL; ?>"><img src="<?php echo $imgsrc; ?>" alt="<?php echo lang('site_title'); ?>"/></a>
          <?php } ?>  
          
          <div class="clearfix"></div>
          <p><?php echo lang('footer_tagline'); ?></p>
            <div class="margin-bottom-40">
            <?php echo get_menu(2, 1) ?>
            </div> 
          </div>
          <!-- END BOTTOM ABOUT BLOCK -->

          <!-- BEGIN BOTTOM CONTACTS -->
          <div class="<?php echo ($data['facebook_block'] ? 'col-md-4 col-sm-6':'col-md-6 col-sm-8') ?> pre-footer-col">
            <h2><?php echo lang('our_contact'); ?></h2>
            <address class="margin-bottom-40">
              <?php echo $data['company_name']?><br/>
              <?php if($data['company_tel']){ ?><?php echo lang('phone'); ?>: <a href="mailto:<?php echo $data['company_tel']?>"><?php echo $data['company_tel']?></a><br /><?php } ?>
              <?php if($data['company_email']){ ?><?php echo lang('email'); ?>: <a href="mailto:<?php echo $data['company_email']?>"><?php echo $data['company_email']?></a><br /><?php } ?>
              <?php if($data['skype']){ ?>  <?php echo lang('skype'); ?>: <a href="skype:<?php echo $data['skype']?>"><?php echo $data['skype']?></a><?php } ?>
             
            </address>

           <h2><?php echo lang('about_us_home_title'); ?></h2>
            <p><?php echo lang('about_us_home_description'); ?></p>

          </div>
          <!-- END BOTTOM CONTACTS -->
          <?php if($data['facebook_block']){ ?>
          <!-- BEGIN FACEBOOK BLOCK --> 
          <div class="col-md-4 col-sm-6 pre-footer-col">
          <h2><?php echo lang('follow_us')?></h2>
          <div class="fb-page" data-href="https://www.facebook.com/<?php echo $data['facebook_block']?>/" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/<?php echo $data['facebook_block']?>/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/<?php echo $data['facebook_block']?>/"></a></blockquote></div>
          </div>
          <!-- END FACEBOOK BLOCK -->
          <?php } ?>  
        </div>
      </div>
    </div>
    <!-- END PRE-FOOTER -->

    <!-- BEGIN FOOTER -->
    <div class="footer">
      <div class="container">
        <div class="row">
          <!-- BEGIN COPYRIGHT -->
          <div class="col-md-4 col-sm-4 padding-top-10">
            <?php echo date('Y'); ?> ©  <?php echo $data['company_name']?> | <?php echo lang('copyright_title'); ?> 
          </div>
          <!-- END COPYRIGHT -->
           <?php if($data['facebook'] || $data['dribbble'] || $data['linkedin'] || $data['twitter'] || $data['skype'] || $data['github'] || $data['youtube'] || $data['dropbox'] || $data['googleplus']){ ?>          
          <!-- BEGIN SOCIAL -->          
          <div class="col-md-4 col-sm-4">
            <ul class="social-footer list-unstyled list-inline text-center">
            <?php if($data['facebook']){ ?> <li><a href="<?php echo $data['facebook']?>"><i class="fa fa-facebook"></i></a></li><?php } ?>
            <?php if($data['dribbble']){ ?> <li><a href="<?php echo $data['dribbble']?>"><i class="fa fa-dribbble"></i></a></li><?php } ?>
            <?php if($data['linkedin']){ ?> <li><a href="<?php echo $data['linkedin']?>"><i class="fa fa-linkedin"></i></a></li><?php } ?>
            <?php if($data['twitter']){ ?> <li><a href="<?php echo $data['twitter']?>"><i class="fa fa-twitter"></i></a></li><?php } ?>
            <?php if($data['skype']){ ?> <li><a href="skype:<?php echo $data['skype']?>?userinfo"><i class="fa fa-skype"></i></a></li><?php } ?>
            <?php if($data['github']){ ?> <li><a href="<?php echo $data['github']?>"><i class="fa fa-github"></i></a></li><?php } ?>
            <?php if($data['youtube']){ ?> <li><a href="<?php echo $data['youtube']?>"><i class="fa fa-youtube"></i></a></li><?php } ?>
            <?php if($data['dropbox']){ ?> <li><a href="<?php echo $data['dropbox']?>"><i class="fa fa-dropbox"></i></a></li><?php } ?>
            <?php if($data['googleplus']){ ?> <li><a href="<?php echo $data['googleplus']?>"><i class="fa fa-google-plus"></i></a></li><?php } ?> 
            </ul>  
          </div>
          <!-- END SOCIAL -->
          <div class="col-md-4 col-sm-4 padding-top-10 pull-right text-right">
          Powered by <a class="no_decor" href="https://evovemanager.com" target="_blank">Evolve Manager</a>
              </div>
          <?php } ?>           
        </div>
      </div>
    </div>
    <!-- END FOOTER -->
