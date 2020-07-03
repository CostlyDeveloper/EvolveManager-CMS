
var $ = jQuery.noConflict();
jQuery(document).ready(function ($) {
    var modulep = 'media';
    var modulePath = 'modules/' + modulep + '/';
    lazyload();
    //DELETE GALLERY

    $(document).on('click touchstart', '.delete_gallery', function () {

        var GalleryId = $(this).attr('data-id');
        var new_type = 'purple';
        $.confirm({
                      title: lang.galleryDelete,
                      content: lang.galleryDeleteContent,
                      autoClose: 'cancelAction|8000',
                      icon: 'fa fa-warning',
                      type: new_type,
                      //'blue, green, red, orange, purple & dark'
                      escapeKey: true,
                      buttons: {
                          deleteUser: {
                              text: lang.galleryDeleteConfirm,
                              action: function () {
                                  var moduleID = $('#moduleID').val();
                                  var $form = $('#token_data');
                                  var data = {
                                      moduleID: moduleID,
                                      gallery_id: GalleryId
                                  };
                                  data = $form.serialize() + '&' + $.param(data);
                                  $.ajax({
                                             type: "POST",
                                             url: modulePath + 'actions/delete_gallery.php',
                                             data: data,
                                             cache: false,
                                             success: function (html) {
                                                 $("#galtr_" + GalleryId).fadeOut();
                                                 showMessage('success', '', '');
                                             },
                                             error: function (data) {
                                                 showMessage('error', '', '');
                                             }
                                         }); //Ajax
                              }
                          },
                          cancelAction: function () {
                          }
                      }
                  }); //Confirm
    });
    // /DELETE GALLERY

    // ADD NEW GALLERY
    $(document).on('click touchstart', '#add_new_gal', function (event) {
        event.preventDefault();
        var new_btn = 'btn-blue';
        var newTitle = lang.commonCreateNew;
        var phpContent = 'url:' + modulePath + 'confirmBox/add_gal.php';
        $.confirm({
                      title: newTitle,
                      content: phpContent,
                      buttons: {
                          formSubmit: {
                              text: lang.commonCreateButton,
                              btnClass: new_btn,
                              action: function () {
                                  var moduleID = $('#moduleID').val();
                                  var name = $('#instance_name').val();
                                  var $form = $('#token_data');
                                  var data = {
                                      moduleID: moduleID,
                                      name: name
                                  };
                                  data = $form.serialize() + '&' + $.param(data);
                                  $.ajax({
                                             type: 'POST',
                                             dataType: 'json',
                                             url: modulePath + 'actions/add_gal.php',
                                             data: data,
                                             cache: false,
                                             success: function (response) {
                                                 showMessage('success', '', '');
                                                 window.setTimeout(window.location.replace(response.load_new), 500);
                                             },
                                             error: function (data) {
                                                 showMessage('error', '', '');
                                             }
                                         }); //AJAX
                              } //CONFIRM ACTTION
                          },
                          cancel: function () {
                              //close
                          },
                      },
                      onContentReady: function () {
                      }
                  }); //CONFIRM
    });
    // /ADD NEW GALLERY

    //SELECT MEDIA FOR EDITING
    $(document).on('click touchstart', '.edit_media', function (event) {
        event.preventDefault();
        var media_id = $(this).closest('.media_image').attr('data-id');
        var moduleID = $('#moduleID').val();
        var $form = $('#token_data');
        var data = {
            moduleID: moduleID,
            media_id: media_id
        };
        data = $form.serialize() + '&' + $.param(data);
        $.ajax({
                   type: "POST",
                   url: modulePath + 'actions/select_single_media.php',
                   data: data,
                   cache: false,
                   success: function (html) {
                       $("#media_info_block").remove();
                       $("#dynamic_media_siedebar_wrapper").prepend(html).fadeIn();
                   },
                   error: function (data) {
                       showMessage('error', '', '');
                   }
               });
        return false;
    });
    // /SELECT MEDIA FOR EDITING EDIT MEDIA
    $(document).on('click touchstart', '#submit_media_info button', function (event) {
        event.preventDefault();
        var moduleID = $('#moduleID').val();
        var $form = $('#submit_media_info, #token_data');
        var data = {
            moduleID: moduleID
        };
        data = $form.serialize() + '&' + $.param(data);
        $.ajax({
                   type: "POST",
                   url: modulePath + 'actions/submit_media_info.php',
                   data: data,
                   cache: false,
                   success: function (html) {
                       showMessage('success', '', '');
                   },
                   error: function (data) {
                       showMessage('error', '', '');
                   }
               });
        return false;
    });
    // /EDIT MEDIA

    //DELETE MEDIA
    $(document).on('click touchstart', '.delete_media', function (event) {
        event.preventDefault();
        var gallery = $(this).attr('id');
        var $form = $('#token_data');
        var moduleID = $('#moduleID').val();

        if (gallery) {
            var new_title = lang.confirmRemoveTitle;
            var new_text = lang.confirmRemoveText;
            var new_content = lang.confirmRemoveContent;
            var new_type = 'purple';
        } else {
            var new_title = lang.confirmDeleteTitle;
            var new_text = lang.confirmDeleteText;
            var new_content = '';
            var new_type = 'red';
        }
        var media_id = $(this).closest('.media_image').attr('data-id');
        $.confirm({
                      title: new_title,
                      content: new_content,
                      autoClose: 'cancelAction|8000',
                      icon: 'fa fa-warning',
                      type: new_type,
                      //'blue, green, red, orange, purple & dark'
                      escapeKey: true,
                      buttons: {
                          deleteUser: {
                              text: new_text,
                              action: function () {


                                  var data = {
                                      moduleID: moduleID,
                                      media_id: media_id,
                                      if_gallery: gallery
                                  };
                                  data = $form.serialize() + '&' + $.param(data);
                                  $.ajax({
                                             type: "POST",
                                             url: modulePath + 'actions/delete_media.php',
                                             data: data,
                                             cache: false,
                                             success: function (html) {
                                                 $('#add_into_specific').hide();
                                                 $('#create_gallery_button').hide();
                                                 $('#delete_selected_button').hide();
                                                 $("#parentpic_" + media_id).fadeOut();
                                                 $('.selected_img').each(function () {
                                                     $(this).removeClass('selected_img');
                                                 });
                                                 $('.media_selected').each(function () {
                                                     $(this).addClass('hidden');
                                                 });
                                                 showMessage('success', '', '');
                                             },
                                             error: function (data) {
                                                 showMessage('error', '', '');
                                             }
                                         }); //ajax
                              }
                          },
                          cancelAction: function () {
                          }
                      } //buttons
                  }); //confirm
    });
    // /DELETE MEDIA

    //DELETE ALL SELECTED
    $(document).on('click touchstart', '#delete_selected_button', function (event) {
        event.preventDefault();
        var newTitle = lang.confirmDeleteTitle;
        var newText = lang.confirmDeleteText;
        $.confirm({
                      title: newTitle,
                      content: lang.deleteSelectedMedia,
                      buttons: {
                          formSubmit: {
                              text: lang.settDelButton,
                              btnClass: 'btn-red',
                              action: function () {
                                  var gal_name = this.$content.find('.name').val();
                                  var moduleID = $('#moduleID').val();
                                  var $form = $('#selected_items_form, #token_data');
                                  var data = {
                                      moduleID: moduleID,
                                  };
                                  data = $form.serialize() + '&' + $.param(data);

                                  $.ajax({
                                             type: "POST",
                                             // dataType: "json",
                                             url: modulePath + 'actions/delete_selected.php',
                                             data: data,
                                             cache: false,
                                             success: function (response) {
                                                 showMessage('success', '', '');

                                                 $('.selected_img').each(function () {
                                                     $(this).fadeOut();
                                                 });
                                                 $('#create_gallery_button').hide();
                                                 $('#add_into_specific').hide();
                                                 $('#delete_selected_button').hide();
                                                 $('#submit_new_gallery').empty();
                                             },
                                             error: function (response) {
                                                 showMessage('error', '', '');
                                             }
                                         }); //ajax
                              } //actions
                          },
                          //formSubmit
                          cancel: function () {
                              //close
                          },
                      },
                      //buttons
                      onContentReady: function () {
                      }
                  }); //confirm
    });
    // /DELETE ALL SELECTED

    //SELECTED ADD INTO GALLERY
    $("#add_into_gallery").change(function () {
        if ($('#add_into_gallery').val() === '') {
            $("#create_gallery_button_title").html(lang.createGallery);
        } else {
            $("#create_gallery_button_title").html(lang.addIntoGallery);
        }
    });
    // /SELECTED ADD INTO GALLERY

    //CREATE MEDIA GALLERY
    $(document).on('click touchstart', '#create_gallery_button', function (event) {
        event.preventDefault();
        var AddIntoGallery = false;
        if ($('#add_into_gallery').val()) {
            var arr_AddIntoGallery = $('#add_into_gallery').val().split('|');
            var AddIntoGallery = arr_AddIntoGallery[0];
            var AddIntoGalleryName = arr_AddIntoGallery[1];
            var newTitle = lang.confirmSupplementGallery;
            var newContent = lang.addingMediaInto + AddIntoGalleryName;
            var new_btn = 'btn-purple';
        } else {
            var new_btn = 'btn-blue';
            var newTitle = lang.confirmCreateGallery;
            var newContent = '' + '<div class="form-group">' + '<label>' + lang.confirmEnterGalleryName + '</label>' + '<input type="text" autocomplete="off" placeholder="' + lang.confirmGalleryName + '" id="gallery_name" class="name form-control" required />' + '</div>';
        }
        var gal_name;
        $.confirm({
                      title: newTitle,
                      content: newContent,
                      buttons: {
                          formSubmit: {
                              text: lang.confirmSubmit,
                              btnClass: new_btn,
                              action: function () {
                                  var gal_name = this.$content.find('.name').val();
                                  if (!!!AddIntoGallery) {
                                      if (!gal_name) {
                                          $.alert(lang.ConfirmValidName);
                                          return false;
                                      }
                                  }
                                  var moduleID = $('#moduleID').val();
                                  var $form = $('#selected_items_form, #token_data');
                                  var data = {
                                      moduleID: moduleID,
                                      gallery_title: gal_name,
                                      add_into_gallery: AddIntoGallery
                                  };
                                  data = $form.serialize() + '&' + $.param(data);

                                  $.ajax({
                                             type: "POST",
                                             dataType: "json",
                                             url: modulePath + 'actions/submit_new_gallery.php',
                                             data: data,
                                             cache: false,
                                             success: function (response) {
                                                 if (response.message === 'err') {
                                                     showMessage('error', '', response.message, 2000);
                                                 } else {
                                                     showMessage('success', '', '');
                                                 }
                                                 $('.media_selected').each(function () {
                                                     $(this).addClass('hidden');
                                                 });
                                                 $('.selected_img').each(function () {
                                                     $(this).removeClass('selected_img');
                                                 });
                                                 $('#create_gallery_button').hide();
                                                 $('#add_into_specific').hide();
                                                 $('#delete_selected_button').hide();
                                                 $('#submit_new_gallery').empty();
                                                 $.alert(response.message);
                                                 window.setTimeout(window.location.replace(response.load_gallery_url), 500);
                                             },
                                             error: function (data) {
                                                 showMessage('error', '', '');
                                             }
                                         }); //ajax
                              } //actions
                          },
                          //formSubmit
                          cancel: function () {
                              //close
                          },
                      },
                      //buttons
                      onContentReady: function () {
                      }
                  }); //confirm
    });
    // /CREATE MEDIA GALLERY SELECTING MEDIA
    $(document).on('click touchstart', '.media_image', function (event) {
        event.preventDefault();
        $(this).closest('.thumbnail').toggleClass('selected_img');
        $(this).prev().toggleClass('hidden');
        var numItems = $('.selected_img').length;
        if (numItems > 0) {
            $('#create_gallery_button').fadeIn();
            $('#add_into_specific').fadeIn();
            $('#delete_selected_button').fadeIn();
        } else {
            $('#create_gallery_button').fadeOut();
            $('#add_into_specific').fadeOut();
            $('#delete_selected_button').fadeOut();
        }
        $('#selected_items').empty();
        $('#selected_media_nr').empty().append('(' + numItems + ')').fadeIn();
        $('#selected_media_del_nr').empty().append('(' + numItems + ')').fadeIn();
        $('#selected_items').append('<input type="hidden" name="total_media" value="' + numItems + '" />').show();
        $('.selected_img').each(function () {
            var selected_id = $(this).attr('data-id');
            $('#selected_items').append('<input type="hidden" name="mediaid_' + selected_id + '" value="' + selected_id + '" />').show();
        });
    });
    // /SELECTING MEDIA

    var moduleID = $('#moduleID').val();
    var userID = $('input[name=userID]').val();
    var token = $('input[name=token]').val();
    var cpass = $('input[name=cpass]').val();
    var rdts = $('input[name=rdts]').val();
    $(".dropzone").dropzone({
                                url: modulePath + 'actions/upload_media.php',
                                params: {
                                    moduleID: moduleID,
                                    userID: userID,
                                    token: token,
                                    cpass: cpass,
                                    rdts: rdts
                                },
                                success: function (file, responseText) {
                                    var response = JSON.parse(responseText);
                                    var ImgSrc = response.filesrc;
                                    d = new Date();
                                    $(".art_img_admin").css('display', 'none');
                                    $(response.thumb).insertAfter("#media_wrapper_tagline");
                                }
                            });
    //MEDIA URL copy to clipboard
    $(document).on('click touchstart', '#copyToClipboard', function (event) {
        event.preventDefault();
        copyToClipboard('#imgpath');
        $(function () {
            showMessage('success', '', lang.messageCopyClp);
        });
    });
    // /MEDIA URL copy to clipboard
}); //document ready
