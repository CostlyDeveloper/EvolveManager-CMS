<?php 
  defined('ADMIN') or die();//prevent direct open
    
  $evolve_menus = $mysqli->query("
   SELECT evolve_menus.*
   FROM evolve_menus
  ");
  ?>
<!-- page content -->
<form id="menu_form"  method="POST">
  <input type="hidden" name="page_title" value="<?php echo $lang['edit_menu']?>" />
  <input type="hidden" name="moduleID" id="moduleID" value="<?php echo $module_id; ?>" />
  <div class="right_col" role="main">
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $lang['edit_menu']?></h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-2 col-sm-5 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $lang['choose_menu']?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="form-group">
              <label class="control-label"><?php echo $lang['available_menus']?></label>
              <div>
                <select id="get_menu" class="form-control">
                  <option><?php echo $lang['choose_menu']?></option>
                  <?php while($men = $evolve_menus->fetch_assoc()){?>
                  <option value="<?php echo $men['id']?>" ><?php echo $men['name']?></option>
                  <?php }?> 
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- / left -->
      <!--  Multilang  strings-->
      <div class="col-md-10 col-sm-7 col-xs-12 pull-left">
        <div id="strings_append">
        </div>
      </div>
      <!-- / Multilang strings -->
    </div>
    <!-- / row -->
  </div>
</form>
<!-- /page content -->