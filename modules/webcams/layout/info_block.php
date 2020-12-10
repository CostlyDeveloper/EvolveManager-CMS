<div class="x_panel">
  <div class="x_title">
    <h4><?php lang_string('webcam_info')?></h4>
    <div class="clearfix"></div>
  </div>
  <div class="x_content tabs_parent">
    <div class="col-sm-6 col-md-6"><!-- (1eft block) -->
      <div class="featured-item">
        <div class="meta-text">
          <p><?php lang_string('webcam_city')?>:</p>
          <h5><?php echo $webcam['city'] ?></h5>
        </div> 
      </div> 
      <div class="featured-item">
        <div class="meta-text">
          <p><?php lang_string('webcam_category')?>:</p>
          <h5><?php echo implode(', ' , $categories);?> </h5>
        </div> 
      </div> 
    </div> <!-- /(1eft block) -->
    <div class="col-sm-6 col-md-6"> <!-- (right block) -->
      <div class="featured-item">
        <div class="meta-text">
          <p><?php lang_string('webcam_sdate')?></p>
          <h5><?php echo date('Y.m.d', strtotime($webcam['date_start'])) ?></h5>
        </div> 
      </div> 
      <?php if ($webcam['date_end'] && $webcam['show_date_end']){?>
      <div class="featured-item">
        <div class="meta-text">
          <p><?php lang_string('webcam_edate')?></p>
          <h5><?php echo date('Y.m.d', strtotime($webcam['date_end'])) ?></h5>
        </div> 
      </div> 
      <?php }?>
    </div> <!-- /(right block) -->
    <div class="clearfix"></div>
  </div>
</div>