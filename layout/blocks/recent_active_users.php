<?php
$get_recent_users = $mysqli->query("
  SELECT boom_users.user_name,
  boom_users.user_about,
  boom_users.user_mood,
  boom_users.user_tumb
  FROM boom_users
      
  WHERE user_tumb LIKE 'ava%'
  
  ORDER BY last_action
  LIMIT 10
");
//
if(!$get_recent_users) print_r($mysqli->error);
?>


    <div class="row">
      <div class="col-md-12 col-sm-12 ">
      <div class="row">
      <?php if (get_ad('home_top_left_aside')){ ?>
         <div class="col-md-3 col-sm-5 margin-bottom-30 home_top_left_aside">
         <?php echo get_ad('home_top_left_aside') ?>
        </div>
        <div class="col-md-9 col-sm-7"> 
      <?php } else{?>
        <div class="col-md-12 col-sm-12">
      <?php } ?>
          <h2><?php lang('recently_active_on_chat')?> <a href="<?php echo CHAT_URL; ?>" class="btn btn-primary"><?php lang('go_there')?></a></h2>
          
          <div class="owl-carousel owl-recent_users owl-theme">
          <?php while($row = $get_recent_users->fetch_assoc()){ ?>

            <div class="item profile temp_hidden none">
               <a href="<?php echo FRONTEND_URL; ?>user/<?php echo urlencode($row['user_name']) ?>">
               <div class="img-box">
                  <img src="<?php echo get_avatar($row['user_tumb']) ?>" class="img-responsive temp_hidden none"/>
                </div>
              </a>
              <h4 class="hidden"><?php echo $row['user_name'] ?></h4>
              <h3><?php echo $row['user_mood'] ?></h3>
              <p class="hidden"><?php echo $row['user_about'] ?></p>
            </div>
            
           <?php } ?>
          </div>

        </div>
        </div>
      </div>
    </div>
