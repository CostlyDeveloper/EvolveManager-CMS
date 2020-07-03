<?php
defined('ADMIN') or die();//prevent direct open

$get_media = $mysqli->query("
    SELECT evolve_media.*
    FROM evolve_media
    ORDER BY id DESC
  ");
$all_gal = $mysqli->query("
    SELECT gallery_name, total_media, id
    FROM evolve_galleries       
    ORDER BY id DESC
  ");

?>
<input type="hidden" name="page_title" value="<?php echo $lang['media_library']; ?>"/>
<input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_id; ?>"/>
<div id="all_media" class="right_col" role="main">
    <div>
        <div class="page-title">
            <div class="title_left">
                <h3> <?php echo $lang['media_library']; ?> </h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-8">
                <div class="x_panel">
                    <div class="x_title">
                        <form id="selected_items_form"
                              method="POST">
                            <div id="selected_items"></div>
                            <h2>
                                <?php echo $lang['media_library']; ?>
                                <button id="create_gallery_button" type="button" class="none btn btn-info btn-sm">
                                    <div id="selected_media_nr" class="pull-left"></div>
                                    <div class="pull-left"
                                         id="create_gallery_button_title"><?php echo $lang['create_gallery']; ?></div>
                                </button>
                                <button id="delete_selected_button" type="button"
                                        class="none btn btn-danger btn-sm">
                                    <div id="selected_media_del_nr" class="pull-left"></div>
                                    &nbsp;<i class="fa fa-trash"
                                             aria-hidden="true"></i><?php echo $lang['delete_selected']; ?>
                                </button>
                            </h2>
                            <?php if ($all_gal->num_rows > 0) { //ADD INTO GALLERY?>
                                <br class="clear"/>
                                <div id="add_into_specific" class="form-group none">
                                    <label class="control-label col-md-6 col-sm-6 col-xs-12"><?php echo $lang['add_items_to_existing']; ?></label>
                                    <br class="clear"/>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <select id="add_into_gallery" class="select2_group form-control">
                                            <optgroup label="<?php echo $lang['gal_to_add_files_into']; ?>">
                                                <option></option>
                                                <?php
                                                while ($all = $all_gal->fetch_assoc()) { ?>
                                                    <option value="<?php echo $all['id'] . '|' . $all['gallery_name']; ?>"><?php echo $all['gallery_name'] . ' (' . $all['total_media'] . ')'; ?></option>
                                                <?php } ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <?php
                            } // /ADD INTO GALLERY?
                            ?>
                        </form>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row" id="media_wrapper">
                            <p id="media_wrapper_tagline"><?php echo $lang['media_library_items']; ?></p>
                            <?php
                            while ($media = $get_media->fetch_assoc()) {

                                $imgsrc = $domain . $media['folder'] . $media['filename'];
                                if ($media['thumb']) {
                                    $imgsrc = $domain . $media['folder'] . $media['thumb'];
                                }
                                ?>
                                <div class="col-md-3 media_item_outer" id="parentpic_<?php echo $media['id']; ?>">
                                    <div class="thumbnail" data-id="<?php echo $media['id']; ?>">
                                        <span class="badge bg-blue media_selected hidden"><i
                                                    class="icon-check fa fa-check"></i></span>
                                        <div class="image view view-first media_image cursor_cell"
                                             data-id="<?php echo $media['id']; ?>">
                                            <img style="width: 100%; display: block;" class="lazyload"
                                                 data-src="<?php echo $imgsrc; ?>" alt="image"/>
                                            <div class="mask">
                                                <div class="tools tools-bottom">
                                                    <span class="hidden" id="imgpath"><?php echo $imgsrc; ?></span>
                                                    <span class="media_pic_button pointer" id="copyToClipboard"><i
                                                                class="fa fa-link"></i></span>
                                                    <span class="media_pic_button pointer edit_media"><i
                                                                class="fa fa-pencil"></i></span>
                                                    <span class="media_pic_button pointer delete_media"><i
                                                                class="fa fa-trash"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="caption">
                                            <ul class="list-unstyled media_desc">
                                                <li>
                                                    <small><?php echo $lang['media_size'] . ': ' . formatSizeUnits($media['size']); ?></small>
                                                </li>
                                                <li>
                                                    <small><?php echo $lang['media_dimensions'] . ': ' . $media['width'] . ' x ' . $media['height'] . ' px'; ?></small>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" id="dynamic_media_siedebar_wrapper">
                <div class="x_panel">
                    <!-- upload form -->
                    <div class="x_title">
                        <h2><?php echo $lang['upload_media']; ?></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <p><?php echo $lang['select_file']; ?></p>
                            <form class="dropzone" action="modules/media/actions/upload_media.php" method="POST">
                                <input type="hidden" name="module_id" value="<?php echo $module_id; ?>"/>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- / upload form -->
            </div>
        </div>
    </div>
</div>