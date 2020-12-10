var $ = jQuery.noConflict();


function initColorPicker(_ModulePath) {
    $('.colorpicker').colorpicker();
    const activeColors = $('#activate_colors');

    $(document).on('click', '.add_field', function (data) {//on add input button click
        const colorDomItem = $('.added_color');
        if (!!!colorDomItem.length) {
            $.ajax({
                type: 'POST',
                cache: false,
                url: _ModulePath + 'actions/multi_color_template.php',
                success: function (data) {
                    $('#color_dragable').html(data);
                    const activeColors = $('#activate_colors');
                    activeColors.fadeIn();
                    $('.colorpicker').colorpicker();
                }
            });
        }else{
            console.log($(colorDomItem).first());
            $(colorDomItem).first().clone().prependTo('#color_dragable');

            $('.colorpicker').colorpicker();
        }
        data.preventDefault();
    });

    $(document).on('click', '.remove_item_icon', function (data) {

        $(this).parent().parent().fadeOut().delay(500);
        $(this).parent().parent().remove();
        $('.colorpicker').colorpicker();

        const colorDomItem = $('.added_color');
        if (!!!colorDomItem.length) {
            activeColors.fadeOut();
            $(activeColors).iCheck('uncheck');
        }

    });

}

function initPublishSwitch(_ModulePath) {

    var elem = document.querySelector('.publish-sw');
    if (elem !== null) {
        var switchery = new Switchery(elem, {
            color: '#26B99A'
        });
    }


    //PUBLISH SWITCH - SHOW/HIDE SCHEDULER
    $('.publish_switch').change(function (e) {
        e.preventDefault();
        let published;
        if ($(this).prop('checked')) {
            published = 1;
        } else {
            published = 0;
        }
        const itemID = $(this).attr('data-id');
        var moduleID = $('#moduleID').val();
        var $form = $('#token_data');
        var data = {
            moduleID: moduleID,
            itemID: itemID,
            published: published
        };
        data = $form.serialize() + '&' + $.param(data);
        $.ajax({
            type: 'POST',
            url: _ModulePath + 'actions/publish.php',
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
    // /PUBLISH SWITCH - SHOW/HIDE SCHEDULER
}

function initDataTable(_ElementID) {
    $(_ElementID).DataTable({
        responsive: false,
        columnDefs: [{
            className: 'all',
            orderable: false,
            targets: 0
        },
            {
                className: 'orderable-false',
                orderable: false,
                targets: 5
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

function initSortable(_ElementID) {

    $(_ElementID).sortable({
        'items': 'li',
        'placeholder': 'placeholder_dragable'

    }).disableSelection();
}

function initSeoIdCheck() {
    $('.seoid').blur(function () {
        if (!$.trim(this.value).length) { // zero-length string AFTER a trim
            $(this).addClass('parsley-error');
        }
    });
}

function initDatepicker(_ElementID, _Format) {
    $(_ElementID).datetimepicker({
        format: _Format
    });
}

function initCreateNewItem(_ModulePath, _ItemName) {
    $(document).on('click touchstart', '#add_new_' + _ItemName + '', function (event) {
        event.preventDefault();
        var new_btn = 'btn-blue';
        var newTitle = lang.commonCreateNew;
        var phpContent = 'url:' + _ModulePath + 'confirmBox/add_' + _ItemName + '.php';
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
                        $('.item_lang').each(function () {
                            langSlug = $(this).attr('id').split('_')[1];
                            itemTitle = $(this).val();
                            langArray.push({
                                slug: langSlug,
                                title: itemTitle
                            });
                        });
                        var moduleID = $('#moduleID').val();
                        var category = $('#category_id').val();
                        var jsonLang = JSON.stringify(langArray);
                        var $form = $('#token_data');
                        var data = {
                            data: jsonLang,
                            moduleID: moduleID,
                            category: category
                        };
                        dat = $form.serialize() + '&' + $.param(data);
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: _ModulePath + 'actions/add_' + _ItemName + '.php',
                            data: dat,
                            cache: false,
                            success: function (response) {
                                showMessage('success', '', '');
                                window.setTimeout(window.location.replace(response.load_new), 500);
                            },
                            error: function (data) {
                                $.alert(data.responseText);
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
}

function initEditItem(_ModulePath, _ItemName) {

    $(document).on('submit', '#edit_' + _ItemName + '_form', function () {
        var formDetails = $('#edit_' + _ItemName + '_form, #token_data');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: _ModulePath + 'actions/edit_' + _ItemName + '.php',
            data: formDetails.serialize(),
            success: function (data) {
                showMessage('success', '', '');
                $.each(data, function (key, value) {
                    $('input[name=' + key + ']').val(value);
                    $('input[name=' + key + ']').removeClass('parsley-error');
                });
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
}

function initEditCategory(_ModulePath, _Category) {
    $(document).on('submit', '#edit_' + _Category, function () {
        var formDetails = $('#edit_' + _Category +', #token_data');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: _ModulePath + 'actions/edit_' + _Category + '.php',
            data: formDetails.serialize(),
            success: function (data) {
                $.each(data, function (key, value) {
                    $('input[name=' + key + ']').val(value);
                    $('input[name=' + key + ']').removeClass('parsley-error');
                });
                showMessage('success', '', '');
            },
            error: function (data) {
                showMessage('error', '', '');
            }
        });
        return false;
    });

}

function initNawCategory(_ModulePath) {

    $(document).on('click touchstart', '#add_new_category', function (event) {
        event.preventDefault();
        var $form = $('#token_data');
        var moduleID = $('#moduleID').val();
        var data = {
            moduleID: moduleID
        };
        data = $form.serialize() + '&' + $.param(data);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: _ModulePath + 'actions/add_product_cateory.php',
            data: data,
            cache: false,
            success: function (response) {
                showMessage('success', '', '');
                window.setTimeout(window.location.replace(response.load_new), 500);
            },
            error: function (data) {
                showMessage('error', '', '');
            }
        }); //ajax
    });
}


jQuery(document).ready(function ($) {


    const itemName = 'room';
    const categoryName = 'estate';


    const modulep = 'estate';
    const modulePath = 'modules/' + modulep + '/';
    // const commonScripts = 'modules/_commonScripts/';


    // initColorPicker(modulePath);
    initPublishSwitch(modulePath);

    initDataTable('#datatable-responsive');
    initSortable('#color_dragable');
    initSeoIdCheck();
    initDatepicker('#datetimepicker_publishing', 'DD.MM.YYYY. HH:mm');

    initCreateNewItem(modulePath, itemName);
    initEditItem(modulePath, itemName);

    initEditCategory(modulePath, categoryName);
    initNawCategory(modulePath);


}); //document ready
