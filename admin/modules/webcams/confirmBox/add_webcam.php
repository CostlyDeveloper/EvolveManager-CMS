<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");

?>

              <form id="confirm_box_form" class="form-horizontal form-label-left" method="POST">
                  <?php $slugs_arr = languages();
                        foreach($slugs_arr as $slug){?>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $slug['lang_name'].' '.$lang['add_title'] ; ?> </label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="lang form-control" id="lang_<?php echo $slug['slug']; ?>" name="title_<?php echo $slug['slug']; ?>" value="" />
                          </div>
                        </div>
                        <?php } ?>
                      <input type="hidden" id="author_id" value="<?php echo $data_user_id;?>" />
                      </form>
                      
                      
                      
        
