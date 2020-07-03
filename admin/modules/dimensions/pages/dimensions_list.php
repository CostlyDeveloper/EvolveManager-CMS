<?php 
  defined('ADMIN') or die();//prevent direct open
  $get_dimensions = $mysqli->query("
    SELECT evolve_dimensions_img.*
    FROM evolve_dimensions_img   
    WHERE evolve_dimensions_img.id != 1 AND evolve_dimensions_img.id != 2
  ");
  //mysqli_data_seek($get_dimensions, 3);
  
?>
<!-- page content -->
<input type="hidden" name="page_title" value="<?php echo $lang['dimensions_title'] ?>" />
<input type="hidden" name="moduleID" id="moduleID" value="<?php echo $module_id; ?>" />
<div class="right_col" role="main">
  <div class="">
  <div class="input-group">
        <button id="create_dimension" type="button" class="btn btn-primary"><?php echo $lang['button_add_new']?></button>
      </div>
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $lang['dimensions_title']; ?></h3>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $lang['dimensions_title']; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="table-responsive">
              <table class="table table-striped jambo_table bulk_action">
                <thead>
                  <tr class="headings">
                    <th class="column-title"><?php echo $lang['dimensions_name'];?> </th>
                    <th class="column-title no-link last" width="150px"><span class="nobr"><?php echo $lang['dimensions_actions'];?></span>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="even pointer">
                    <td><?php echo $lang['dim_general_upl'];?></td>
                    <td class="last">
                      <a href="index.php?dimensions=1" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> <?php echo $lang['dimensions_edit']?> </a>
                    </td>
                  </tr>
                  <tr class="even pointer">
                    <td><?php echo $lang['dim_video_upl'];?></td>
                    <td class="last">
                      <a href="index.php?dimensions=2" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> <?php echo $lang['dimensions_edit']?> </a>
                    </td>
                  </tr>
                  <?php while($dim = $get_dimensions->fetch_assoc()){?>
                  <tr id="dimTr_<?php echo $dim['id'];?>" class="even pointer">
                    <td class=" "><?php echo $dim['name'];?></td>
                    <td class=" last">
                      <a href="index.php?dimensions=<?php echo $dim['id'];?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> <?php echo $lang['dimensions_edit']?> </a>
                      <a data-id="<?php echo $dim['id'];?>" class="btn btn-danger btn-xs del_dim"><i class="fa fa-trash-o"></i> <?php echo $lang['dimensions_delete']?> </a>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->