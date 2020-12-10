<div class="row row-eq-height margin-b-50">
  <div class="locked_block">
  <?php 
   if(isset($_POST["cookie_name"])){
      if ($webcam['password'] != $_POST['pass']) {
      $fmsg = true;
    }
  }
  ?>
    <form class="editing_top" name="set_cookie" id="set_cookie" action="<?php echo FRONTEND_URL ?>modules/webcams/actions/set_cookie.php" method="POST">
      <div class="locked_ico"><i class="fa fa-lock fa-5x" aria-hidden="true"></i></div>
            <h3 class="form-signin-heading"><?php lang_string('private_project')?></h3>
            <p><?php lang_string('enter_password')?></p>
            
            <div class="alert alert-danger" id="wrong_pass" style="display: none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong><?php lang_string('error_title')?></strong> <?php lang_string('wrong_password') ?>
            </div>

            <input type="hidden" name="action" value="<?php echo FRONTEND_URL ?>modules/webcams/actions/set_cookie.php" />
            <input class="form-control locked-input margin-b-20" type="password" name="pass" value="" />
            <input type="hidden" name="cookie_name" value="<?php echo $webcam_id ?>" />
            <button class="btn-theme btn-theme-sm btn-base-bg text-uppercase" form="set_cookie"><?php lang_string('submit_button')?></button>
        </form>
  </div>
</div>