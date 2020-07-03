if ($('.tinymce').length > 0) {  //Prevent error

//TINYMCE
    tinymce.PluginManager.add('evo_gallery', function (editor, url) {
        // Add a button that opens a window
        editor.addButton('evo_gallery', {
            text: 'custom',
            icon: false,
            onclick: function () {
                // Open window
                editor.windowManager.open({
                    title: 'Example plugin',
                    body: [{
                        type: 'textbox',
                        name: 'title',
                        label: 'Title'
                    }],
                    onsubmit: function (e) {
                        // Insert content when the window form is submitted
                        editor.insertContent('Title: ' + e.data.title);
                    }
                });
            }
        });
    });
    tinymce.init({
        selector: 'textarea.tinymce',
        height: 300,
        theme: 'modern',
        mobile: {
            theme: 'mobile',
            plugins: ['autosave', 'lists', 'autolink']
        },
        plugins: 'blockquote lorumipsum evo_gallery code print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern',
        toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat',
        toolbar2: 'evolvegallery | evo_gallery | lorumipsum | blockquote',
        image_advtab: true,

        /*templates: [{
          title: 'Test template 1',
          content: 'Test 1'
        },
        {
          title: 'Test template 2',
          content: 'Test 2'
        }],*/
        content_css: ['//fonts.googleapis.com/css?family=Lato:300,300i,400,400i', 'vendors/tinymce/style.min.css']
        /*,
          setup: function(editor) {

            function toTimeHtml(date) {
              return '<time datetime="' + date.toString() + '">' + date.toDateString() + '</time>';
            }

            function insertDate() {
              var html = toTimeHtml(new Date());
              editor.insertContent(html);
            }

            editor.addButton('evolvegallery', {
              text: 'My button',
              icon: 'icon-gallery',
              //image: 'http://p.yusukekamiyamane.com/icons/search/fugue/icons/calendar-blue.png',
              tooltip: "Insert Gallery",
              onclick: insertDate
            });
          }*/
    });
}
// /TINYMCE 
var $ = jQuery.noConflict();
jQuery(document).ready(function ($) {

    //MODULE PATH
    var commonScripts = 'modules/_commonScripts/';
    var mediaPath = 'modules/media/';
    // /MODULE PATH

    $(document).on('click', 'form button', function () {
        $.ajax({
            type: 'POST',
            url: commonScripts + 'regenerate_session/actions/regenerate.php',
            success: function (data) {
                $('#token_data input[name=token]').val(data);
            }
        });
    });

    //SELECT GALLERY
    $(document).on('click touchstart', '.res', function () {
        var galID = $(this).attr('data-id');
        var moduleID = $('#moduleID').val();
        var $form = $('#token_data');
        var data = {
            moduleID: moduleID,
            galID: galID
        };
        data = $form.serialize() + '&' + $.param(data);
        $.ajax({
            type: 'POST',
            url: commonScripts + 'add_gallery/select_gallery.php',
            data: data,
            success: function (data) {
                $("#choosed_gallery").empty().append(data);
            },
        });
        return false;
    });

    //fade our results
    $("input#select_gallery").focusout(function (e) {
        $("#gallery_results").fadeOut();
    });
    // /fadeout results
    $("input#select_gallery").focus(function (e) {
        this.value = '';
        var moduleID = $('#moduleID').val();
        var $form = $('#token_data');
        var data = {
            moduleID: moduleID,
            focus: 'focus'
        };
        data = $form.serialize() + '&' + $.param(data);
        $.ajax({
            type: "POST",
            url: commonScripts + 'add_gallery/select_gallery.php',
            data: data,
            cache: false,
            success: function (html) {
                $('#gallery_results').fadeIn();
                $("#gallery_results").html(html);
            }
        });
        return false;
    });

    $("input#select_gallery").keyup(function (e) {
        // Set Search String
        var search_string = $(this).val();
        // Do Search
        if (search_string == '') {
            $("#gallery_results").fadeOut();
        }
        var moduleID = $('#moduleID').val();
        var $form = $('#token_data');
        var data = {
            moduleID: moduleID,
            query: search_string
        };
        data = $form.serialize() + '&' + $.param(data);
        $.ajax({
            type: "POST",
            url: commonScripts + 'add_gallery/select_gallery.php',
            data: data,
            cache: false,
            success: function (html) {
                if (search_string == '') {
                    $("#gallery_results").fadeOut();
                } else {
                    $('#gallery_results').fadeIn();
                    $("#gallery_results").html(html);
                }
                //
            }
        });
        return false;
    });
    // /SELECT GALLERY

    //SELECT VIDEO
    $(document).on('click touchstart', '.video_res', function () {
        var videoID = $(this).attr('data-id');
        var moduleID = $('input[name=moduleID]').val();
        if ($("#ch_moduleID").length) {
            var chmoduleID = $('input[name=ch_moduleID]').val();
        } else {
            var chmoduleID = false;
        }
        var instanceID = $('input[name=instanceID]').val();
        var $form = $('#token_data');
        var data = {
            videoID: videoID,
            moduleID: moduleID,
            chmoduleID: chmoduleID,
            instanceID: instanceID
        };
        data = $form.serialize() + '&' + $.param(data);
        $.ajax({
            type: 'POST',
            url: commonScripts + 'add_video/select_video.php',
            data: data,
            success: function (data) {
                $(".choosed_video").append(data);
            },
            error: function (data) {
                showMessage('error', '', '');
            }
        });
        return false;
    });
    //delete from list
    $(document).on('click touchstart', '.vid_close', function () {
        var videoID = $(this).attr('data-id');
        var moduleID = $('input[name=moduleID]').val();
        var instanceID = $('input[name=instanceID]').val();
        var $form = $('#token_data');
        var data = {
            videoID: videoID,
            moduleID: moduleID,
            instanceID: instanceID
        };
        data = $form.serialize() + '&' + $.param(data);
        $.ajax({
            type: 'POST',
            url: commonScripts + 'add_video/remove_from_list.php',
            data: data,
        }); //ajax
    });
    $("input#select_video").focusout(function (e) {
        $("#video_results").fadeOut();
    });

    $("input#select_video").focus(function (e) {
        this.value = '';
        var moduleID = $('input[name=moduleID]').val();
        var instanceID = $('input[name=instanceID]').val();
        if ($("#ch_moduleID").length) {
            var chmoduleID = $('input[name=ch_moduleID]').val();
        } else {
            var chmoduleID = false;
        }
        var $form = $('#token_data');
        var data = {
            focus: 'focus',
            moduleID: moduleID,
            chmoduleID: chmoduleID,
            instanceID: instanceID
        };
        data = $form.serialize() + '&' + $.param(data);
        $.ajax({
            type: "POST",
            url: commonScripts + 'add_video/select_video.php',
            data: data,
            cache: false,
            success: function (html) {
                $('#video_results').fadeIn();
                $("#video_results").html(html);
            }
        }); //ajax
        return false;
    });
    $("input#select_video").keyup(function (e) {
        // Set Search String
        var search_string = $(this).val();
        // Do Search
        if (search_string == '') {
            $("#video_results").fadeOut();
        }
        var moduleID = $('input[name=moduleID]').val();
        var instanceID = $('input[name=instanceID]').val();
        if ($("#ch_moduleID").length) {
            var chmoduleID = $('input[name=ch_moduleID]').val();
        } else {
            var chmoduleID = false;
        }
        var $form = $('#token_data');
        var data = {
            query: search_string,
            moduleID: moduleID,
            chmoduleID: chmoduleID,
            instanceID: instanceID
        };
        data = $form.serialize() + '&' + $.param(data);
        $.ajax({
            type: "POST",
            url: commonScripts + 'add_video/select_video.php',
            data: data,
            cache: false,
            success: function (html) {
                if (search_string == '') {
                    $("#video_results").fadeOut();
                } else {
                    $('#video_results').fadeIn();
                    $("#video_results").html(html);
                }
            }
        }); //ajax
        return false;
    });
    // /SELECT VIDEO

    //upload init

    function upload_init() {
        var moduleID = $('#moduleID').val();
        var userID = $('input[name=userID]').val();
        var token = $('input[name=token]').val();
        var cpass = $('input[name=cpass]').val();
        var rdts = $('input[name=rdts]').val();

        $('.dropzone_fly').dropzone({
            params: {
                moduleID: moduleID,
                userID: userID,
                token: token,
                cpass: cpass,
                rdts: rdts
            },
            url: mediaPath + 'actions/upload_media.php',
            success: function (file, responseText) {
                var response = JSON.parse(responseText);
                //var ImgSrc = response.filesrc;
                d = new Date();
                $(".art_img_admin").css('display', 'none');
                $(response.thumb).insertAfter("#media_wrapper_tagline");
                this.removeAllFiles();
            }
        });


    };
    //upload init

    Dropzone.options.validationForm = {
        clickable: "#upl_button",
        //rest of your code
    }

    //SELECT COVER PIC
    $(document).on('click touchstart', '.select_cover', function () {
        var dim = $(this).attr('id');
        var dim = dim.split('_');
        var dim = dim[1];
        var sub_form = $(this).closest('.upload_block').attr('id');
        $(document).on('click touchstart', '.cover_image', function () {
            $('.selected_img').removeClass('selected_img');
            $('.coverImgCheck').addClass('hidden');
            $(this).closest('.thumbnail').toggleClass('selected_img');
            $(this).prev().toggleClass('hidden');
            var img = $(this).attr('id');
            var arr = img.split('_');
            var selected_id = arr[1];
            $('#cover_input_data').empty().append('<input type="hidden" name="selected_cover_id" value="' + selected_id + '" />').show();
        });
        var moduleID = $('input[name=moduleID]').val();
        var instanceID = $('input[name=instanceID]').val();
        var new_btn = 'btn-blue';
        var newTitle = lang.commonSelTitle;
        var moduleID = $('#moduleID').val();
        var $form = $('#token_data');
        var data2 = {
            moduleID: moduleID,
        };
        data2 = $form.serialize() + '&' + $.param(data2);
        var phpContent = 'url:' + commonScripts + 'cover_img/select_pic.php?' + data2;
        $.confirm({
            title: newTitle,
            content: phpContent,
            theme: 'supervan',
            columnClass: 'col-md-8 col-md-offset-2',
            buttons: {
                formSubmit: {
                    text: lang.commonSetCover,
                    btnClass: new_btn,
                    action: function () {
                        if ($(".selected_img").length) {
                            var coverID = $('input[name=selected_cover_id]').val();
                            if (document.getElementById('ch_moduleID') != null) {
                                var moduleChildID = $('input[name=ch_moduleID]').val();
                            } else {
                                moduleChildID = false;
                            }
                            var data = {
                                instanceID: instanceID,
                                coverID: coverID,
                                moduleID: moduleID,
                                dim: dim,
                                moduleChildID: moduleChildID,
                                sub_form: sub_form
                            };
                            data = $form.serialize() + '&' + $.param(data);
                            $.ajax({
                                type: 'POST',
                                url: commonScripts + 'cover_img/upload_cover.php',
                                data: data,
                                cache: false,
                                success: function (response) {
                                    $('#' + sub_form + ' .cover_preview').empty().show().append(response);
                                    $('.cover_exist').removeClass('hidden');
                                    //$.alert(response);
                                    showMessage('success', '', '');
                                },
                                error: function (data) {
                                    showMessage('error', '', '');
                                }
                            }); //ajax
                        } //if nothing is selected
                        else {
                            $.alert(lang.selectMediaAlert);
                            this.$$hey.prop('disabled', true);
                        }
                    } //action
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                //alert('contentLoaded');
                upload_init();
                lazyload();
            }
        }); //confirm
    });
    // /SELECT COVER PIC
    //DELETE COVER PIC
    $(document).on('click touchstart', '.delete_cover', function () {
        var sub_form = $(this).closest('.upload_block').attr('id');
        var moduleID = $('input[name=moduleID]').val();
        var instanceID = $('input[name=instanceID]').val();
        if (document.getElementById('ch_moduleID') != null) {
            var moduleChildID = $('input[name=ch_moduleID]').val();
        } else {
            moduleChildID = false;
        }
        var new_btn = 'btn-red';
        var newTitle = lang.commonDelCover;
        $.confirm({
            title: newTitle,
            content: '',
            buttons: {
                formSubmit: {
                    text: lang.commonDelButton,
                    btnClass: new_btn,
                    action: function () {
                        var $form = $('#token_data');
                        var data = {
                            instanceID: instanceID,
                            moduleID: moduleID,
                            moduleChildID: moduleChildID,
                            sub_form: sub_form
                        };
                        data = $form.serialize() + '&' + $.param(data);
                        $.ajax({
                            type: 'POST',
                            url: commonScripts + 'cover_img/delete_cover_image.php',
                            data: data,
                            success: function (data) {
                                showMessage('success', '', '');
                                $('#' + sub_form + ' .cover_preview').fadeOut().empty();
                                $('.cover_exist').addClass('hidden');

                            },
                            error: function (data) {
                                showMessage('error', '', '');
                            }
                        }); //ajax
                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
            }
        }); //confirm
    });
    // /DELETE COVER PIC
    //DELETE INSTANCE
    $(document).on('click touchstart', '.del_instance', function () {
        var moduleID = $('input[name=moduleID]').val();
        var instanceID = $(this).attr('data-id');
        if (document.getElementById('ch_moduleID') != null) {
            var moduleChildID = $('input[name=ch_moduleID]').val();
        } else {
            moduleChildID = false;
        }
        var new_btn = 'btn-red';
        var newTitle = lang.commonDelIns;
        $.confirm({
            title: newTitle,
            icon: 'fa fa-warning',
            content: lang.commonDelText,
            type: 'red',
            buttons: {
                formSubmit: {
                    text: lang.commonDelButton,
                    btnClass: new_btn,
                    action: function () {
                        var $form = $('#token_data');
                        var data = {
                            instanceID: instanceID,
                            moduleID: moduleID,
                            moduleChildID: moduleChildID
                        };
                        data = $form.serialize() + '&' + $.param(data);
                        $.ajax({
                            type: 'POST',
                            url: commonScripts + 'delete_instance/delete_instance.php',
                            data: data,
                            success: function (data) {

                                if (data) {
                                    showMessage('error', data, '', 1500);
                                } else {
                                    $('#instanceID_' + instanceID).fadeOut();
                                    showMessage('success', '', '');
                                }
                            },
                            error: function (data) {
                                showMessage('error', '', '');
                            }
                        }); //ajax
                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
            }
        }); //confirm
    });
    // /DELETE INSTANCE
    //SORTABLE
    $("#video_dragable").sortable({
        'items': 'li',
        'placeholder': 'placeholder_dragable',
        'update': function () {
            var moduleID = $('#moduleID').val();
            var $form = $('#token_data');
            var $order = $("#video_dragable");
            var data = {
                moduleID: moduleID
            };
            data = $order.serializeTree("data-id", "postData") + '&' + $form.serialize() + '&' + $.param(data);
            $.ajax({
                type: 'POST',
                url: commonScripts + 'add_video/input_new_order.php',
                data: data,
                success: function (data) {
                    showMessage('success', '', '');
                },
                error: function (data) {
                    showMessage('error', '', '');
                    //window.setTimeout('location.reload()', 1000);
                }
            });
        }
    }).disableSelection();
    // /SORTABLE
}); //document ready
