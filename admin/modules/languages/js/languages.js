var $ = jQuery.noConflict();
jQuery(document).ready(function ($) {
    //MODULE PATH
    var modulep = 'languages';
    //var root = window.location.protocol + "//" + window.location.host + "/";
    var modulePath = 'modules/' + modulep + '/';
    // /modulePath
    //GET LANG STRINGS
    $('#get_strings' ).on('change', function () {
        var lang = this.value;
        var moduleID = $('#moduleID').val();
        var $form = $('#token_data');
        var data = {
            moduleID: moduleID,
            lang: lang
        };
        data = $form.serialize() + '&' + $.param(data);
        $.ajax({
            type: 'POST',
            url: modulePath + 'actions/get_strings.php',
            data: data,
            success: function (data) {
                showMessage('success', '', '');
                $("#strings_append").empty();
                $("#strings_append").append(data);
                $('#langs').dataTable({
                    paging: false
                });
            },
            error: function (data) {
                showMessage('error', '', '');
            }
        });
        return false;
    });
    // /GET LANG STRINGS
    //EDIT LANG
    $(document).on('submit', '#edit_languages_form', function () {
        var ml = $('#langs').attr('data-lang');
        var moduleID = $('#moduleID').val();
        var userID = $('input[name=userID]').val();
        var token = $('input[name=token]').val();
        var cpass = $('input[name=cpass]').val();
        var rdts = $('input[name=rdts]').val();
        var $form = $('#edit_languages_form');
        var data = {
            ml: ml,
            moduleID: moduleID,
            userID: userID,
            token: token,
            cpass: cpass,
            rdts: rdts
        };
        data = $form.serialize() + '&' + $.param(data);
        $.ajax({
            type: 'POST',
            url: modulePath + 'actions/edit_languages.php',
            data: data,
            success: function (data) {
                showMessage('success', '', '');
                $("#strings_append").append(data);
            },
            error: function (data) {
                showMessage('error', '', '');
            }
        });
        return false;
    });
    // /EDIT LANG
}); //document ready