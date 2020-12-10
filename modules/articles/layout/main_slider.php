<?php
$get_media = $mysqli->query("
  SELECT evolve_gallery_items.*, evolve_media_alt.*
  FROM evolve_gallery_items  
  
  LEFT JOIN evolve_media_alt
  ON evolve_media_alt.for_media = evolve_gallery_items.media_id
    AND evolve_media_alt.for_lang =  '$language'
  WHERE evolve_gallery_items.gallery_id = '$gal_id' 
");   
if ($get_media->num_rows > 0) {    
  ?>

<!-- BEGIN SLIDER -->
    <div class="page-slider margin-bottom-40">
        <div id="carousel-example-generic" class="carousel slide carousel-slider">
            <!-- Indicators -->
            <ol class="carousel-indicators carousel-indicators-frontend">
            <?php
              $i = 0;
              while($slide = $get_media->fetch_assoc()){
              ?>
              <li data-target="#carousel-example-generic" data-slide-to="<?php echo $i ?>" <?php echo ($i == 0 ? 'class="active"' : '') ?>></li>
            <?php $i++; }
            
            mysqli_data_seek($get_media,0);// restart query from menu for new while loop
            ?>  
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <!-- First slide -->
                <?php
                $i = 0;
                while($slide = $get_media->fetch_assoc()){
                  $imgsrc = $data['domain'].$slide['folder'].$slide['filename'];  
                  $style_bg = 'style="background: url('.$imgsrc.'); background-size: cover;"';
                
                
                ?>
                <div class="item carousel-item-background <?php echo ($i == 0 ? 'active' : '') ?>" <?php echo $style_bg ?>>
                    <div class="container">
                        <div class="carousel-position-six text-uppercase text-center">
                        <?php if($row['title'] || $row['tagline']){?>
                            <h2 class="margin-bottom-20 animate-delay carousel-title-v5" data-animation="animated fadeInDown">
                                <span class="carousel-title-normal"><?php echo ($row['tagline'] ? $row['tagline'] : '') ?></span>
                                <br/>
                                <?php echo ($row['title'] ? $row['title'] : '') ?>  
                            </h2>
                            <?php  } ?>
                        </div>
                    </div>
                </div>
                <?php $i++; } ?>
            </div>

            <!-- Controls -->
            <a class="left carousel-control carousel-control-shop carousel-control-frontend" href="#carousel-example-generic" role="button" data-slide="prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </a>
            <a class="right carousel-control carousel-control-shop carousel-control-frontend" href="#carousel-example-generic" role="button" data-slide="next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
    <!-- END SLIDER -->
<?php  } ?>