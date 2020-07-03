<?php 
  defined('ADMIN') or die();//prevent direct open 
    
  $select_multilang = $mysqli->query("
   SELECT evolve_multilang.*
   FROM evolve_multilang
   
   WHERE enabled = 1
  ");
  ?>
<!-- page content -->
<input type="hidden" name="page_title" value="<?php echo $lang['ed_langs']?>" />
<input type="hidden" name="moduleID" id="moduleID" value="<?php echo $module_id; ?>" />
<form id="edit_languages_form" action="settings/languages/actions/edit_languages.php" method="POST">
  <div class="right_col" role="main">
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $lang['ed_langs']?></h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-2 col-sm-5 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $lang['choose_language']?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="form-group">
              <label class="control-label"><?php echo $lang['lang_frontend']?></label>
              <div>
                <select id="get_strings" class="form-control">
                  <option value="" selected="selected" disabled="disabled"><?php echo $lang['choose_language']?></option>
                  <?php while($mul = $select_multilang->fetch_assoc()){?>
                  <option value="<?php echo $mul['slug']?>" ><?php echo $mul['lang_name']?></option>
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