var $ = jQuery.noConflict();


jQuery(document).ready(function ($) {
    //MODULE PATH
    var modulep = 'testimonials';
    var modulePath = 'modules/' + modulep + '/';

    // /MODULE PATH

    function call_switch() {
        // Switchery
        var elem = document.querySelector('.js-switch');
        var init = new Switchery(elem, {
            color: '#26B99A'
        });
        // /Switchery
    }
    // ADD NEW
    $(document).on('click touchstart', '#add_new_testimonial', function (event) {
        event.preventDefault();
        var new_btn = 'btn-blue';
        var newTitle = lang.commonCreateNew;
        var phpContent = 'url:' + modulePath + 'confirmBox/add_testimonial.php';
        $.confirm({
            title: newTitle,
            content: phpContent,
            buttons: {
                formSubmit: {
                    text: lang.commonCreateButton,
                    btnClass: new_btn,
                    action: function () {
                        var langArray = [];
                        var authorId = $('#author_id').val();
                        var for_instance = $('#for_instance').val();
                        var name = $('#instance_name').val();
                        var moduleID = $('#moduleID').val();
                        var $form = $('#token_data');
                        var data = {
                            moduleID: moduleID,
                            name: name,
                            for_instance: for_instance
                        };
                        data = $form.serialize() + '&' + $.param(data);
                        $.ajax({
                            type: 'POST',
                            url: modulePath + 'actions/add_testimonial.php',
                            data: data,
                            cache: false,
                            success: function (data) {
                                showMessage('success', '', '');
                                $("#sort_testimonial").prepend(data);
                                call_switch();
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
    // /ADD NEW
    // PUBLISH SWITCH (category list)
    $('.publish_switch').change(function (e) {
        e.preventDefault();
        var instanceID = $(this).attr('data-id');
        if ($(this).prop('checked')) {
            var published = 1;
        } else {
            var published = 0;
        }
        var moduleID = $('#moduleID').val();
        var $form = $('#token_data');
        var data = {
            moduleID: moduleID,
            instanceID: instanceID,
            published: published
        };
        data = $form.serialize() + '&' + $.param(data);
        $.ajax({
            type: 'POST',
            url: modulePath + 'actions/publish.php',
            data: data,
            success: function (data) {
                showMessage('success', '', '');
            },
            error: function (data) {
                showMessage('error', '', '');
            }
        });
        return false;
    });
    // / PUBLISH SWITCH (category list)

    //SORTABLE
    $("#sort_testimonial").sortable({
        'items': 'li',
        'placeholder': 'placeholder_dragable',
        'update': function () {
            var moduleID = $('#moduleID').val();
            var $form = $('#token_data');
            var $order = $("#sort_testimonial");
            var data = {
                moduleID: moduleID
            };
            data = $order.serializeTree("data-id", "postData") + '&' + $form.serialize() + '&' + $.param(data);
            $.ajax({
                type: 'POST',
                url: modulePath + 'actions/input_new_order.php',
                data: data,
                success: function (data) {
                    showMessage('success', '', '');
                    $("#dev").html(data);
                },
                error: function (data) {
                    showMessage('error', '', '');
                    //window.setTimeout('location.reload()', 1000);
                }
            });
        }
    }).disableSelection();
    // /SORTABLE
    //EDIT TESTIMONIAL
    $(document).on('submit', '#edit_testimonial_form', function () {
        var formDetails = $('#edit_testimonial_form, #token_data');
       console.log(formDetails);
        $.ajax({
            type: 'POST',
            url: modulePath + 'actions/edit_testimonial.php',
            data: formDetails.serialize(),
            success: function (data) {
                showMessage('success', '', '');
                $("#dev").html(data);
            },
            error: function (data) {
                showMessage('error', '', '');
                //window.setTimeout('location.reload()', 1000);
            }
        });
        return false;
    });
    // /EDIT TESTIMONIAL
}); //document ready
