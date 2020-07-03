<?php //hide menu if no items

if (
evolveAllow($data_user_id, find_module('users')['id']) OR 
evolveAllow($data_user_id, find_module('user_groups')['id']) OR 
evolveAllow($data_user_id, find_module('dimensions')['id']) OR 
evolveAllow($data_user_id, find_module('ads')['id']) OR 
evolveAllow($data_user_id, find_module('site_setup')['id']) OR 
evolveAllow($data_user_id, find_module('menu')['id']) OR 
evolveAllow($data_user_id, find_module('languages')['id'])  
){ ?>

  <li>
    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
    <i class="fa fa-cog fa-3x"></i>
    </a>
    <ul class="dropdown-menu dropdown-usermenu pull-right">
    <?php 
    //users
    $module_id = find_module('users')['id'];
    if (evolveAllow($data_user_id, $module_id)){ ?>
      <li><a href="index.php?users"> <?php echo $lang['usr_title']?></a></li>
    <?php } ?>  
    
    <?php 
    //user_groups
    $module_id = find_module('user_groups')['id'];
    if (evolveAllow($data_user_id, $module_id)){ ?>  
      <li><a href="index.php?user_groups"> <?php echo $lang['grp_title']?></a></li>
    <?php } ?>
    
    <?php 
    //dimensions
    $module_id = find_module('dimensions')['id'];
    if (evolveAllow($data_user_id, $module_id)){ ?>
      <li><a href="index.php?dimensions"> <?php echo $lang['set_dimensions_dd']?></a></li>
    <?php } ?>
    
    <?php 
    //languages
    $module_id = find_module('languages')['id'];
    if (evolveAllow($data_user_id, $module_id)){ ?>
      <li><a href="index.php?languages"> <?php echo $lang['set_languages']?></a></li>
    <?php } ?>
    
     <?php 
    //languages
    $module_id = find_module('menu')['id'];
    if (evolveAllow($data_user_id, $module_id)){ ?>
      <li><a href="index.php?menu"> <?php echo $lang['menu_menu']?></a></li>
    <?php } ?>
    
    <?php 
    //ads
    $module_id = find_module('ads')['id'];
    if (evolveAllow($data_user_id, $module_id)){ ?>
      <li><a href="index.php?ads"> <?php echo $lang['ads_title']?></a></li>
    <?php } ?>
    
    <?php 
    //site settings
    $module_id = find_module('site_setup')['id'];
    if (evolveAllow($data_user_id, $module_id)){ ?>
      <li><a href="index.php?site_setup"> <?php echo $lang['site_setup']?></a></li>
    <?php } ?>
    </ul>
  </li>
<?php } ?>