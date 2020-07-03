<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root."/system/config.php");
?>
<li class="added_color">
    <div class="clearfix"></div>
    <div class="row">
        <div class="text-left col-md-1 col-sm-1 col-xs-2 form-group dragable_arrows">
            <i class="fa fa-arrows"></i></div>
        <div class="col-md-5 col-sm-5 col-xs-6 row form-group">
            <div class="input-group">
                <input name="multiColorName[]" class="form-control" placeholder="<?php echo $lang['product_color_name'] ?>" value="" type="text" autocomplete="off" />
            </div>
        </div>
        <div class="col-md-5 col-sm-5 col-xs-6 form-group">
            <div class="input-group colorpicker">
                <input name="multiColorHex[]" type="text" value="#ffffff" class="form-control" />
                <span class="input-group-addon"><i></i></span>
            </div>
        </div>
        <div class="col-md-1 col-sm-1 col-xs-2 remove_item_icon">

            <i class="fa fa-times" aria-hidden="true"></i>

        </div>
    </div>
    <div class="clearfix"></div>
</li>
