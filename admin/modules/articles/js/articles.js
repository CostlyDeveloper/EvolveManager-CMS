var $ = jQuery.noConflict();
jQuery(document).ready(function ($) {
    //MODULE PATH
    var modulep = 'articles';
    var modulePath = 'modules/' + modulep + '/';
    var commonScripts = 'modules/_commonScripts/';
    // /modulePath
    //ENABLE / DISABLE PUBLISH SWITCH
    // Switchery
    if ($("#activate_schedule").length) {
        $('#activate_schedule').iCheck('enable');
        var elem = document.querySelector('.publish-sw');
        var switchery = new Switchery(elem, {
            color: '#26B99A'
        });
    }
    $('#activate_schedule').on('ifUnchecked', function (event) {
        //switchery.enable();
        $("input[name=art_schedule]").prop("disabled", false);
        $('#sch_cal_ico').fadeIn();
        var schedule = 0;
        var articleID = $('input[name=articleID]').val();
        var artSchedule = $('input[name=art_schedule').val();
        $.ajax({
            type: 'POST',
            url: modulePath + 'actions/schedule.php',
            data: {
                articleID: articleID,
                schedule: schedule,
                art_schedule: artSchedule
            },
            success: function (data) {
                showMessage('success', '', lang.articleScheduleUnset);
                $('#art_schedule').removeClass('parsley-success');
                $('#sch_paravan').addClass('hidden');
                $('input[name=art_schedule]').removeClass('hidden');
            }
        });
        return false;
    });
    $('#activate_schedule').on('ifChecked', function (event) {
        //switchery.disable();
        $("input[name=art_schedule]").prop("disabled", true);
        $('#sch_cal_ico').fadeOut();
        var schedule = 1;
        var articleID = $('input[name=articleID]').val();
        var artSchedule = $('input[name=art_schedule]').val();
        $.ajax({
            type: 'POST',
            url: modulePath + 'actions/schedule.php',
            data: {
                articleID: articleID,
                schedule: schedule,
                art_schedule: artSchedule
            },
            success: function (data) {
                showMessage('success', '', lang.articleScheduleSet);
                $('#art_schedule').addClass('parsley-success');
            }
        });
        return false;
    });
    // /ENABLE / DISABLE PUBLISH SWITCH
    //PUBLISH SWITCH - SHOW/HIDE SCHEDULER
    $('.publish_switch').change(function (e) {
        e.preventDefault();
        if ($(this).prop('checked')) {
            var published = 1;
        } else {
            var published = 0;
        }
        var articleID = $(this).attr('data-id');
        if (document.getElementById('schedule_parent')) {
            $('#schedule_parent').fadeToggle("slow", "linear");
        }
        var moduleID = $('#moduleID').val();
        var $form = $('#token_data');
        var data = {
            moduleID: moduleID,
            articleID: articleID,
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
    // /PUBLISH SWITCH - SHOW/HIDE SCHEDULER
    //EDIT RUBRIC
    $(document).on('submit', '#edit_rubric_form', function () {
        var formDetails = $('#edit_rubric_form, #token_data');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: modulePath + 'actions/edit_rubric.php',
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
    // /EDIT RUBRIC
    //NEW RUBRIC
    $(document).on('click touchstart', '#add_new_art_rubric', function (event) {
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
            url: modulePath + 'actions/add_rubric.php',
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
    // /NEW RUBRIC
    //EDIT ARTICLE
    $(document).on('submit', '#edit_article_form', function () {
        var formDetails = $('#edit_article_form, #token_data');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: modulePath + 'actions/edit_article.php',
            data: formDetails.serialize(),
            success: function (data) {
                showMessage('success', '', '');
                $.each(data, function (key, value) {
                    $('input[name=' + key + ']').val(value);
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
    // /EDIT ARTICLE
    //CREATE NEW ARTICLE
    $(document).on('click touchstart', '#add_new_article', function (event) {
        event.preventDefault();
        var new_btn = 'btn-blue';
        var newTitle = lang.articleCreateNew;
        var phpContent = 'url:' + modulePath + 'confirmBox/add_article.php';
        var art_name;
        $.confirm({
            title: newTitle,
            content: phpContent,
            buttons: {
                formSubmit: {
                    text: lang.articleNewButton,
                    btnClass: new_btn,
                    action: function () {
                        var langArray = [];
                        $('.article_lang').each(function () {
                            langSlug = $(this).attr('id').split('_')[1];
                            articleTitle = $(this).val();
                            langArray.push({
                                slug: langSlug,
                                title: articleTitle
                            });
                        });
                        var moduleID = $('#moduleID').val();
                        var rubric_id = $('#rubric_id').val();
                        var jsonLang = JSON.stringify(langArray);
                        var $form = $('#token_data');
                        var data = {
                            data: jsonLang,
                            moduleID: moduleID,
                            rubric: rubric_id
                        };
                        dat = $form.serialize() + '&' + $.param(data);
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: modulePath + 'actions/add_article.php',
                            data: dat,
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
    // /CREATE NEW ARTICLE
    //ARTICLE LIST
    $('#datatable-responsive').DataTable({
        //ajax: "js/datatables/json/scroller-demo.json",
        responsive: false,
        columnDefs: [{
            className: 'all',
            orderable: false,
            targets: 0
        },
            {
                className: 'all',
                orderable: false,
                targets: 1
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
    $('#ddatatable-responsive').DataTable({
        "columnDefs": [{
            "targets": 'disable_sorting',
            "orderable": false
        }]
    });
    // /ARTICLE LIST
    //DATEPICKERS
    $('#datetimepicker_article_publishing').datetimepicker({
        format: 'DD.MM.YYYY. HH:mm'
    });
    $('#art_schedule').datetimepicker({
        format: 'DD.MM.YYYY. HH:mm'
    });
    // /DATEPICKERS
    //SEO ID
    $('.seoid').blur(function () {
        if (!$.trim(this.value).length) { // zero-length string AFTER a trim
            $(this).addClass('parsley-error');
        }
    });
    // /SEO ID
}); //document ready
