<?php
defined('ADMIN') or die();//prevent direct open

$get_themes = $mysqli->query("
    SELECT evolve_frontend_themes.*
    FROM evolve_frontend_themes
    ORDER BY id
  ");
//if(!$get_themes) print_r($mysqli->error);
?>
<div class="row">
    <div class="equal col-md-12 col-sm-12 col-xs-12">
        <div class="equal col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo $lang['block_styles'] ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="">
                        <div class="form-group">
                            <label class="control-label"><?php echo $lang['select_theme'] ?></label>
                            <div>
                                <select name="theme" class="form-control">
                                    <?php while ($the = $get_themes->fetch_assoc()) { ?>
                                        <option value="<?php echo $the['id'] ?>" <?php echo($the['id'] == $row['theme'] ? 'selected="selected"' : '') ?>><?php echo $the['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <button type="submit"
                                class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
                    </div>
                </div>
            </div>
        </div>
       <!-- <div class="equal col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php /*echo $lang['block_options'] */?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="">


                        <button type="submit"
                                class="btn btn-success pull-right"><?php /*echo $lang['button_submit']; */?></button>
                    </div>
                </div>
            </div>
        </div>-->
        <!-- logo picture -->
        <div class="equal col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel upload_block" id="logo_image">
                <div class="x_title">
                    <h2><?php echo $lang['logo_image']; ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php if ($get_dim_rel->num_rows > 0) { ?>
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-sm" type="button"
                                    aria-expanded="false"><i
                                        class="fa fa-picture-o m-right-xs"></i> <?php echo $lang['select_img'] ?> <span
                                        class="caret"></span>
                            </button>
                            <ul role="menu" class="dropdown-menu">
                                <?php mysqli_data_seek($get_dim_rel, 0);
                                while ($dim = $get_dim_rel->fetch_assoc()) {
                                    ?>
                                    <li><a id="dim_<?php echo $dim['for_dimension']; ?>"
                                           class="select_cover"><?php echo $dim['name']; ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } else {
                        echo $lang['please_make_dim']; ?>
                        <a href="index.php?dimensions"><?php echo $lang['set_dimensions_dd']; ?></a>
                    <?php } ?>
                    <div id="delete_cover"
                         class="cover_exist btn-group <?php echo (empty($row['img'])) ? 'hidden' : ''; ?>">
                        <button class="delete_cover btn btn-danger dropdown-toggle btn-sm" type="button"><i
                                    class="fa fa-trash-o m-right-xs"></i> <?php echo $lang['delete_img_button'] ?>
                        </button>
                    </div>
                    <div class="x_content">
                        <div class="cover_preview">
                            <?php
                            if ($img['logo_img']) {
                                $imgsrc = $domain . module_media_folder($module_id) . '/' . $img['logo_img'];
                                ?>
                                <img class="cover_img img-responsive"
                                     src="<?php echo $imgsrc; ?>?<?php echo time('timestamp'); ?>"
                                     alt="<?php echo $imgsrc; ?>"/>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="checkbox cover_exist <?php echo (empty($img['logo_img'])) ? 'hidden' : ''; ?>">
                    </div>
                    <button type="submit"
                            class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
                </div>
            </div>
        </div>
        <div class="equal col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel upload_block" id="logo2_image">
                <div class="x_title">
                    <h2><?php echo $lang['logo2_image']; ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li class="singletb"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php if ($get_dim_rel->num_rows > 0) { ?>
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-sm" type="button"
                                    aria-expanded="false"><i
                                        class="fa fa-picture-o m-right-xs"></i> <?php echo $lang['select_img'] ?> <span
                                        class="caret"></span>
                            </button>
                            <ul role="menu" class="dropdown-menu">
                                <?php mysqli_data_seek($get_dim_rel, 0);
                                while ($dim = $get_dim_rel->fetch_assoc()) {
                                    ?>
                                    <li><a id="dim_<?php echo $dim['for_dimension']; ?>"
                                           class="select_cover"><?php echo $dim['name']; ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } else {
                        echo $lang['please_make_dim']; ?>
                        <a href="index.php?dimensions"><?php echo $lang['set_dimensions_dd']; ?></a>
                    <?php } ?>
                    <div id="delete_cover"
                         class="cover_exist btn-group <?php echo (empty($row['img'])) ? 'hidden' : ''; ?>">
                        <button class="delete_cover btn btn-danger dropdown-toggle btn-sm" type="button"><i
                                    class="fa fa-trash-o m-right-xs"></i> <?php echo $lang['delete_img_button'] ?>
                        </button>
                    </div>
                    <div class="x_content">
                        <div class="cover_preview">
                            <?php
                            if ($img['logo2_img']) {
                                $imgsrc = $domain . module_media_folder($module_id) . '/' . $img['logo2_img'];
                                ?>
                                <img class="cover_img img-responsive"
                                     src="<?php echo $imgsrc; ?>?<?php echo time('timestamp'); ?>"
                                     alt="<?php echo $imgsrc; ?>"/>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="checkbox cover_exist <?php echo (empty($img['logo2_img'])) ? 'hidden' : ''; ?>">
                    </div>
                    <button type="submit"
                            class="btn btn-success pull-right"><?php echo $lang['button_submit']; ?></button>
                </div>
            </div>
        </div>
        <!-- /logo picture -->
    </div>
</div>