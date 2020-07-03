var $ = jQuery.noConflict();
//MODULE PATH 
var modulep = 'menu';
//var root = window.location.protocol + "//" + window.location.host + "/";   
var modulePath = 'modules/' + modulep + '/';
// /modulePath
//SORT 

function sort_position() {
    var moduleID = $('#moduleID').val();
    var userID = $('input[name=userID').val();
    var token = $('input[name=token').val();
    var cpass = $('input[name=cpass').val();
    var rdts = $('input[name=rdts').val();

    $('ol.sortable').nestedSortable({
        forcePlaceholderSize: true,
        handle: 'div',
        helper: 'clone',
        items: 'li',
        opacity: .6,
        placeholder: 'placeholder',
        revert: 250,
        tabSize: 25,
        tolerance: 'pointer',
        toleranceElement: '> div',
        maxLevels: 4,
        isTree: true,
        expandOnHover: 700,
        startCollapsed: false,
        excludeRoot: true,
        update: function () {
            //arraied = $(this).nestedSortable('toArray', {startDepthCount: 0}),
            hiered = $(this).nestedSortable('toHierarchy', {
                startDepthCount: 0
            }),
                $.post(
                    modulePath + 'actions/sort.php', {
                        moduleID: moduleID,
                        userID: userID,
                        token: token,
                        cpass: cpass,
                        rdts: rdts,
                        array: hiered
                    }, function (data) {
                        $("#sort_data").html(data);
                    });
            //console.log(hiered);
        }
    });
}
// /SORT
jQuery(document).ready(function ($) {
    ////////
    //EDIT MENU
    $(document).on('click touchstart', '.edit_menu_item', function (event) {
        event.preventDefault();
        var item_id = $(this).attr('data-id');
        var moduleID = $('#moduleID').val();
        var $form = $('#token_data');
        var data = {
            moduleID: moduleID,
            id: item_id
        };
        data = $form.serialize() + '&' + $.param(data);
        var new_btn = 'btn-blue';
        var newTitle = lang.commonEdit;
        var phpContent = 'url:' + modulePath + 'confirmBox/edit_menu_item.php?' + data;
        var art_name;
        $.confirm({
            title: newTitle,
            content: phpContent,
            buttons: {
                formSubmit: {
                    text: lang.commonSubmit,
                    btnClass: new_btn,
                    action: function () {
                        var form_data = $('#menu_item_form, #token_data, #menu_form');
                        $.ajax({
                            type: 'POST',
                            url: modulePath + 'actions/edit_instance.php',
                            data: form_data.serialize(),
                            cache: false,
                            success: function (data) {
                                showMessage('success', '', '');
                                $("#name_" + item_id).html(data);
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
    // /EDIT MENU
    //ADD NEW MENU ITEM
    $(document).on('click touchstart', '#add_new_menu_item', function (event) {
        event.preventDefault();
        var instanceID = $(this).attr('data-id');
        var moduleID = $('#moduleID').val();
        var $form = $('#token_data');
        var data = {
            moduleID: moduleID,
            instanceID: instanceID
        };
        data = $form.serialize() + '&' + $.param(data);
        $.ajax({
            type: 'POST',
            url: modulePath + 'actions/add_menu_item.php',
            data: data,
            success: function (data) {
                showMessage('success', '', '');
                $(".sortable").prepend(data);
            },
            error: function (data) {
                showMessage('error', '', '');
            }
        });
    });
    // /ADD NEW MENU ITEM
    //DELETE INSTANCE
    $(document).on('click touchstart', '.del_inst', function () {
        var instanceID = $(this).attr('data-id');
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
                        var moduleID = $('#moduleID').val();
                        var $form = $('#token_data');
                        var data = {
                            moduleID: moduleID,
                            instanceID: instanceID
                        };
                        data = $form.serialize() + '&' + $.param(data);
                        $.ajax({
                            type: 'POST',
                            url: modulePath + 'actions/delete_instance.php',
                            data: data,
                            success: function (data) {
                                $('li[id="item_' + instanceID + '"]').fadeOut(1000).remove();
                                showMessage('success', '', '');
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
    //GET MENU
    $('#get_menu').on('change', function () {
        var id = this.value;
        $.ajax({
            type: 'POST',
            url: modulePath + 'actions/get_menu.php',
            data: {
                id: id
            },
            success: function (data) {
                showMessage('success', '', '');
                $("#strings_append").empty();
                $("#strings_append").append(data);
                sort_position();
            }
        });
        return false;
    });
    // /GET MENU
}); //document ready