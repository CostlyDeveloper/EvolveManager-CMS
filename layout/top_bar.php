<header role="banner" id="fh5co-header">
    <div class="container">
        <!-- <div class="row"> -->
        <nav class="navbar navbar-default">
            <div class="navbar-header">
                <!-- Mobile Toggle Menu Button -->
                <a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle" data-toggle="collapse" data-target="#navbar"
                   aria-expanded="false" aria-controls="navbar"><i></i></a>
                <?php if($data['logo_img']){
                $imgsrc = FRONTEND_URL.module_media_folder(11).'/'.$data['logo_img'];?>
                <a class="site-logo" href="<?php echo FRONTEND_URL; ?>"><img src="<?php echo $imgsrc; ?>" alt="<?php echo lang('site_title'); ?>"/></a>
                <?php } ?>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <?php /*echo get_menu(1) */?>
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="#" data-nav-section="home"><span>Home</span></a></li>
                    <li><a href="#" data-nav-section="work"><span>Work</span></a></li>
                    <li><a href="#" data-nav-section="testimonials"><span>Testimonials</span></a></li>
                    <li><a href="#" data-nav-section="services"><span>Services</span></a></li>
                    <li><a href="#" data-nav-section="about"><span>About</span></a></li>
                    <li><a href="#" data-nav-section="contact"><span>Contact</span></a></li>
                </ul>
            </div>
        </nav>
        <!-- </div> -->
    </div>
</header>