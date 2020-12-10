<!-- BEGIN TOP BAR -->
<div class="pre-header">
    <div class="container">
        <div class="row top-block-line">

            <!-- BEGIN TOP BAR LEFT PART -->

            <div class="col-md-6 col-sm-6 additional-shop-info">
                <?php if ($data['company_tel'] || $data['company_email']) { ?>
                    <ul class="list-unstyled list-inline">
                        <?php if ($data['company_tel']) { ?>
                            <li><i class="fa fa-phone"></i><span><?php echo $data['company_tel'] ?></span>
                            </li><?php } ?>
                        <?php if ($data['company_email']) { ?>
                            <li><i class="fa fa-envelope-o"></i><span><?php echo $data['company_email'] ?></span>
                            </li><?php } ?>
                    </ul>
                <?php } ?>
            </div>
            <!-- END TOP BAR LEFT PART -->
            <!-- BEGIN TOP BAR MENU -->
            <div class="col-md-6 col-sm-6 additional-nav">
                <?php if (evolveLogged()) { ?>
                    <ul class="list-unstyled list-inline pull-right user-profile">
                        <li>

                            <?php lang('wellcome') ?>, <?php echo $first_name ?>

                        </li>
                    </ul>
                <?php } ?>
            </div>
            <!-- END TOP BAR MENU -->
        </div>
    </div>
</div>
<!-- END TOP BAR -->
