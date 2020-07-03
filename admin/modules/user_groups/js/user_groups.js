var $ = jQuery.noConflict();
jQuery(document).ready(function($) {
  function data_table() {
    $('#table-responsive').DataTable({
      responsive: false,
      "order": []
    });
  };
  data_table();
  //MODULE PATH 
  var modulep = 'user_groups';
  var modulePath = 'modules/' + modulep + '/';
  var commonScripts = 'modules/_commonScripts/';
  // /modulePath
  //EDIT USR
  $(document).on('submit', '#edit_' + modulep + '_form', function(event) {
    event.preventDefault();
    var formDetails = $('#edit_' + modulep + '_form, #token_data');
    $.ajax({
      type: 'POST',
      url: modulePath + 'actions/edit_' + modulep + '.php',
      data: formDetails.serialize(),
      success: function(data) {
        showMessage('success', '', '');
      },
      error: function(data) {
        showMessage('error', '', '');
      },
    });
    return false;
  });
  // /EDIT USR
  // ADD NEW 
  $(document).on('click touchstart', '#add_new_user_groups', function(event) {
    event.preventDefault();
    var new_btn = 'btn-blue';
    var newTitle = lang.commonCreateNew;
    var phpContent = 'url:' + modulePath + 'confirmBox/add_user_groups.php';
    $.confirm({
      title: newTitle,
      content: phpContent,
      buttons: {
        formSubmit: {
          text: lang.commonCreateButton,
          btnClass: new_btn,
          action: function() {
            var langArray = [];
            var group_name = $('input[name=group_name').val();
            var moduleID = $('#moduleID').val();
            var $form = $('#token_data');
            var data = {
              moduleID: moduleID,
              group_name: group_name
            };
            data = $form.serialize() + '&' + $.param(data);
            $.ajax({
              type: 'POST',
              dataType: 'json',
              url: modulePath + 'actions/add_user_groups.php',
              data: data,
              cache: false,
              success: function(response) {
                showMessage('success', '', '');
                window.setTimeout(window.location.replace(response.load_new), 500);
              },
              error: function(response) {
                showMessage('error', '', '');
              }
            }); //AJAX
          } //CONFIRM ACTTION
        },
        cancel: function() {
          //close
        },
      },
      onContentReady: function() {}
    }); //CONFIRM
  });
  // /ADD NEW 
}); //document ready