<?php 
  defined('ADMIN') or die();//prevent direct open
      
  $get_webcams_cat = $mysqli->query("
      SELECT evolve_webcam_cat_data.name, evolve_webcam_cat.id as wcat_id
      FROM evolve_webcam_cat
      
      
      LEFT JOIN evolve_webcam_cat_data
      ON evolve_webcam_cat_data.for_instance_id = evolve_webcam_cat.id
        AND evolve_webcam_cat_data.lang =  '$default_language'
      ORDER BY evolve_webcam_cat.position ASC 
      ");      
      //if(!$get_webcams_cat) print_r($mysqli->error);
  
  ?>
<!-- page content -->
<input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_id; ?>" />
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $lang['webcams_cat']; ?></h3>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $lang['webcams_cat_list'] ; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="table-responsive">
              <table class="table table-striped jambo_table bulk_action">
                <thead>
                  <tr class="headings">
                    <th>
                    </th>
                    <th class="column-title"><?php echo $lang['wcat_title'];?> </th>
                    <th class="column-title"><?php echo $lang['number_of_wcat'];?> </th>
                    <th>
                    </th>
                  </tr>
                </thead>
                <tbody id="wcats_dragable">
                  <?php while($cat = $get_webcams_cat->fetch_assoc()){?>
                  <tr data-id="<?php echo $cat['wcat_id']; ?>" class="even pointer">
                    <td class="a-center">
                      <div class="text-center"><i class="fa fa-arrows"></i></div>
                    </td>
                    <td class=" "><?php echo $cat['name'];?></td>
                    <td class=" "><?php echo number_cat_instances($cat['wcat_id']) ?></td>
                    <td class=" last">
                      <div class="pull-right">
                        <a href="index.php?webcam_cat=<?php echo $cat['wcat_id'] ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> <?php echo $lang['button_edit']?> </a>
                        <a href="#" class="btn btn-danger btn-xs hidden"><i class="fa fa-trash-o"></i> <?php echo $lang['button_delete']?> </a>
                      </div>
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