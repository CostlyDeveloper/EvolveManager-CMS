        <!-- BEGIN TABS AND TESTIMONIALS -->
        <div class="row mix-block margin-bottom-40">
          <!-- TABS -->
          <div class="col-md-12 tab-style-1">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-1" data-toggle="tab"><?php lang('home_tab1_title')?></a></li>
              <li><a href="#tab-2" data-toggle="tab"><?php lang('home_tab2_title')?></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane row fade_in active" id="tab-1">
                <div class="col-md-12 col-sm-12">
                  <?php include(FRONTEND_PATH.'layout/blocks/featured_articles.php'); ?>
                </div>
              </div>
              <div class="tab-pane row fade" id="tab-2">
                <div class="col-md-12 col-sm-12">
                  <?php include(FRONTEND_PATH.'layout/blocks/featured_events.php'); ?>
                </div>
              </div>
            </div>
          </div>
          <!-- END TABS -->
        

        </div>                
        <!-- END TABS AND TESTIMONIALS -->