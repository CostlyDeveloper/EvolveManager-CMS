<?php 
  defined('ADMIN') or die();//prevent direct open
  $all_gal = $mysqli->query("
      SELECT evolve_galleries.*
      FROM evolve_galleries       
      ORDER BY id DESC
      "); 
      
      //$media = $get_media->fetch_array(MYSQLI_BOTH);
   
  ?>
<input type="hidden" name="page_title" value="<?php echo $lang['galleries']; ?>" />
<input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_id; ?>" />
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
  <div class="input-group">
        <button id="add_new_gal" type="button" class="btn btn-primary"><?php echo $lang['button_add_new']?></button>
      </div>
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $lang['galleries'] ; ?></h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $lang['gallery_list']; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <!-- start project list -->
            <table class="table table-striped projects">
              <thead>
                <tr>
                  <th style="width: 1%">#</th>
                  <th style="width: 20%"><?php echo $lang['gallery_name']; ?></th>
                  <th><?php echo $lang['gallery_preview']; ?></th>
                  <th><?php echo $lang['gallery_total'] ; ?></th>
                  <th style="width: 20%"><?php echo $lang['gallery_edit_buttons'] ; ?></th>
                </tr>
              </thead>
              <tbody>
                <?php while($gal = $all_gal->fetch_assoc()){
                  $date = date("d.m.Y.", strtotime($gal['date']));
                  ?>
                <tr id="galtr_<?php echo $gal['id']; ?>">
                  <td>#</td>
                  <td>
                    <a><?php echo $gal['gallery_name']; ?></a>
                    <br />
                    <small><?php echo $lang['gallery_created'].' '.$date; ?></small>
                  </td>
                  <td>
                    <ul class="list-inline">
                      <?php echo gallery_preview($gal['id']);?>
                    </ul>
                  </td>
                  <td class="project_progress">
                    <small><?php echo $gal['total_media'].' '.$lang['gallery_item']; ?></small>
                  </td>
                  <td>
                    <a href="#" class="hidden btn btn-primary btn-xs"><i class="fa fa-folder"></i> View </a>
                    <a href="index.php?galleries=<?php echo $gal['id']; ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> <?php echo $lang['gallery_edit_button']; ?> </a>
                    <a href="#" data-id="<?php echo $gal['id']; ?>" class="delete_gallery btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $lang['gallery_delete'];?> </a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <!-- end project list -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->