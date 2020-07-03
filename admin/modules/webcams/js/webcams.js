jQuery(document).ready(function ($) {
    function data_table() {
        $('#webcams-responsive').DataTable({
            //ajax: "js/datatables/json/scroller-demo.json",
            responsive: false,
            columnDefs: [{
                className: 'all',
                orderable: false,
                targets: 0
            },
                {
                    responsivePriority: 1,
                    targets: 0
                },
                {
                    responsivePriority: 2,
                    targets: 1
                }]
        });
    }
    //MODULE PATH
    var modulep = 'webcams';
    var modulePath = 'modules/' + modulep + '/';
    var commonScripts = 'modules/_commonScripts/';
    // /modulePath
    //WEBCAMS MULTIPLE ID
    var max_fields = 10; //maximum input field allowed
    var fields = $(".fields"); //Fields
    var add_button = $(".add_field"); //Add button
    var instanceID = $('input[name=instanceID]').val();
    var $streams = $('.added_wids');
    if ($streams.length) {
        var x = $streams.length + 1; //initlal text box count
    } else {
        var x = 1; //initlal text box count
    }
    $(add_button).click(function (e) { //on add input button click
        e.preventDefault(); //undo event
        $.ajax({
            type: 'POST',
            data: {
                count: x,
                instanceID: instanceID
            },
            cache: false,
            url: modulePath + 'actions/add_multi_stream.php',
            success: function (data) {
                if (x < max_fields) { //max input box allowed
                    if (!$('.added_wids').length) {
                        $('#single_stream').addClass('hidden');
                        $("input[name=single_stream]").attr("disabled", true);
                    }
                    $(fields).append(data); //add input box
                    x++; //text box increment
                }
            }
        });
        return false;
    });
    $(fields).on("click", ".remove_field", function (e) { //user click on remove text
        e.preventDefault();
        //$.alert($(this).parent().parent('.added_wids').attr('class'));
        $(this).parent().parent().parent('.added_wids').remove();
        if (!$('.added_wids').length) {
            $('#single_stream').removeClass('hidden');
            $("input[name=single_stream]").attr("disabled", false);
        }
        x--;
    });
    // /WEBCAMS MULTIPLE ID
    //MAKE HISTORIC
    $('#make_historic').on('ifChecked', function (e) {
        e.preventDefault();
        $("#f_date").attr("readonly", false);
    });
    $('#make_historic').on('ifUnchecked', function (e) {
        e.preventDefault();
        $("#f_date").attr("readonly", true);
    });
    // /MAKE HISTORIC
    //SELECT CATEGORIES
    $('.webcam_categories').select2();
    // /SELECT CATEGORIES
    // PUBLISH SWITCH (list)
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
    // / PUBLISH SWITCH (list)
    // FEATURE SWITCH (list)
    $(document).on('click touchstart', '.feature_switch', function (e) {
        e.preventDefault();
        var instanceID = $(this).attr('data-id');
        var icon = 'fa-heart';
        var switcType = 'featured';
        if ($(this).hasClass(icon)) {
            var featured = 0;
        } else {
            var featured = 1;
        }
        var moduleID = $('#moduleID').val();
        var $form = $('#token_data');
        var data = {
            moduleID: moduleID,
            instanceID: instanceID,
            featured: featured
        };
        data = $form.serialize() + '&' + $.param(data);
        $.ajax({
            type: 'POST',
            url: modulePath + 'actions/featured.php',
            data: data,
            success: function (data) {
                var table = $('#webcams-responsive').DataTable();
                if (featured == 0) { //isključeno
                    table.cell('#instanceID_' + instanceID + ' .' + switcType).data('<span class="hidden_text">0</span><i data-id="' + instanceID + '" class="pointer feature_switch fa ' + icon + '-o" aria-hidden="true"></i>');
                } else if (featured == 1) { //uključeno
                    table.cell('#instanceID_' + instanceID + ' .' + switcType).data('<span class="hidden_text">1</span><i data-id="' + instanceID + '" class="pointer feature_switch fa ' + icon + '" aria-hidden="true"></i>');
                }
                showMessage('success', '', '');
            }
        });
        return false;
    });
    // / FEATURE SWITCH (list)
    // PROMOTE SWITCH (list)
    $(document).on('click touchstart', '.promote_switch', function (e) {
        e.preventDefault();
        var instanceID = $(this).attr('data-id');
        var icon = 'fa-star';
        var switcType = 'promoted';
        if ($(this).hasClass(icon)) {
            var promoted = 0;
        } else {
            var promoted = 1;
        }
        var moduleID = $('#moduleID').val();
        var $form = $('#token_data');
        var data = {
            moduleID: moduleID,
            instanceID: instanceID,
            promoted: promoted
        };
        data = $form.serialize() + '&' + $.param(data);
        $.ajax({
            type: 'POST',
            url: modulePath + 'actions/promoted.php',
            data: data,
            success: function (data) {
                var table = $('#webcams-responsive').DataTable();
                if (promoted == 0) { //isključeno
                    table.cell('#instanceID_' + instanceID + ' .' + switcType).data('<span class="hidden_text">0</span><i data-id="' + instanceID + '" class="pointer promote_switch fa ' + icon + '-o" aria-hidden="true"></i>');
                } else if (promoted == 1) { //uključeno
                    table.cell('#instanceID_' + instanceID + ' .' + switcType).data('<span class="hidden_text">1</span><i data-id="' + instanceID + '" class="pointer promote_switch fa ' + icon + '" aria-hidden="true"></i>');
                }
                showMessage('success', '', '');
            },
            error: function (data) {
                showMessage('error', '', '');
            }
        });
        return false;
    });
    // / PROMOTED SWITCH (list)
    //EDIT WEBCAM
    $(document).on('submit', '#edit_webcam_form', function () {
        var formDetails = $('#edit_webcam_form, #token_data');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: modulePath + 'actions/edit_webcam.php',
            data: formDetails.serialize(),
            success: function (data) {
                $.each(data, function (key, value) {
                    $('input[name=' + key + ']').val(value);
                    $('input[name=' + key + ']').removeClass('parsley-error');
                });
                showMessage('success', '', '');
                if ($(".unsaved").length) {
                    $(".unsaved").fadeOut();
                }
            },
            error: function (data) {
                showMessage('error', '', '');
            }
        });
        return false;
    });
    // /EDIT WEBCAM
    // SORTABLE
    $("#wcats_dragable").sortable({
        'items': 'tr',
        'placeholder': 'placeholder_dragable',
        'update': function () {
            var moduleID = $('#moduleID').val();
            var $form = $('#token_data');
            var $order = $("#wcats_dragable");
            var data = {
                moduleID: moduleID
            };
            data = $order.serializeTree("data-id", "postData") + '&' + $form.serialize() + '&' + $.param(data);
            $.ajax({
                type: 'POST',
                url: modulePath + 'actions/input_new_wcam_order.php',
                data: data,
                success: function (data) {
                    showMessage('success', '', '');
                    $("#dev").html(data);
                },
                error: function (data) {
                    showMessage('error', '', '');
                }
            });
        }
    }).disableSelection();
    $("#stream_dragable").sortable({
        'items': 'li',
        'placeholder': 'placeholder_dragable',
        'update': function () {
            var moduleID = $('#moduleID').val();
            var $form = $('#token_data');
            var $order = $("#stream_dragable");
            var data = {
                moduleID: moduleID
            };
            data = $order.serializeTree("data-id", "postData") + '&' + $form.serialize() + '&' + $.param(data);
            $.ajax({
                type: 'POST',
                url: modulePath + 'actions/input_new_multiple_stream.php',
                data: data,
                success: function (data) {
                    showMessage('success', '', '');
                    $("#dev").html(data);
                },
                error: function (data) {
                    showMessage('error', '', '');
                }
            });
        }
    }).disableSelection();
    // /SORTABLE
    //EDIT WEBCAM CATEGORY
    $(document).on('submit', '#edit_wcat_form', function () {
        var formDetails = $('#edit_wcat_form, #token_data');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: modulePath + 'actions/edit_wcat.php',
            data: formDetails.serialize(),
            success: function (data) {
                $.each(data, function (key, value) {
                    $('input[name=' + key + ']').val(value);
                });
                showMessage('success', '', '');
            },
            error: function (data) {
                showMessage('error', '', '');
            }
        });
        return false;
    });
    // /EDIT WEBCAM CATEGORY
    //DATEPICKERS
    $('#publishing_date').datetimepicker({
        format: 'DD.MM.YYYY.'
    });
    $('#finishing_date').datetimepicker({
        format: 'DD.MM.YYYY.'
    });
    // /DATEPICKERS
    //CREATE NEW WEBCAM
    $(document).on('click touchstart', '#add_new_webcam', function (event) {
        event.preventDefault();
        var new_btn = 'btn-blue';
        var newTitle = lang.commonCreateNew;
        var phpContent = 'url:' + modulePath + 'confirmBox/add_webcam.php';
        var art_name;
        $.confirm({
            title: newTitle,
            content: phpContent,
            buttons: {
                formSubmit: {
                    text: lang.commonCreateButton,
                    btnClass: new_btn,
                    action: function () {
                        var langArray = [];
                        $('.lang').each(function () {
                            langSlug = $(this).attr('id').split('_')[1];
                            newTitle = $(this).val();
                            langArray.push({
                                slug: langSlug,
                                title: newTitle
                            });
                        });
                        var jsonLang = JSON.stringify(langArray);
                        var moduleID = $('#moduleID').val();
                        var videoURL = $('#videoURL').val();
                        var $form = $('#token_data');
                        var data2 = {
                            moduleID: moduleID,
                            data: jsonLang
                        };
                        data2 = $form.serialize() + '&' + $.param(data2);
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: modulePath + 'actions/add_webcam.php',
                            data: data2,
                            cache: false,
                            success: function (response) {
                                showMessage('success', '', '');
                                window.setTimeout(window.location.replace(response.load_new), 500);
                            },
                            error: function (data) {
                                showMessage('error', '', '');
                            }
                        }); //ajax
                    }
                },
                cancel: function () {
                    //close
                }
            },
            onContentReady: function () {
            }
        }); //confirm
    });
    // /CREATE NEW WEBCAM
    if ($('#webcams-responsive').length > 0) { //Prevent error
        //DATA TABLES
        data_table();
        // /DATA TABLES
    }
}); //document ready
