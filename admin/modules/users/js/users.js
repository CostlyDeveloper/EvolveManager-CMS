var $ = jQuery.noConflict();
jQuery(document).ready(function($) {
  function data_table() {
    $('#users-responsive').DataTable({
      responsive: false,
      "order": []
    });
  };
  data_table();
  //MODULE PATH 
  var modulep = 'users';
  var modulePath = 'modules/' + modulep + '/';
  var commonScripts = 'modules/_commonScripts/';
  // /modulePath
  //EDIT USR
  $(document).on('submit', '#edit_user_form', function() {
    var formDetails = $('#edit_user_form, #token_data');
    $.ajax({
      type: 'POST',
      url: modulePath + 'actions/edit_user.php',
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
  //PASWORD MATCH FUNCTION
  function checkPasswordMatch() {
    var password = $("#new_pass").val();
    var confirmPassword = $("#confirm_pass").val();
    if (password != confirmPassword) {
      $("#usr_confirm_pass").addClass("bad");
      $("#passAlert").show(500);
    } else {
      $("#usr_confirm_pass").removeClass("bad");
      $("#passAlert").hide();
    }
  }
  // / PASWORD MATCH FUNCTION
  $("#new_pass, #confirm_pass").keyup(checkPasswordMatch); //PASSWORD CHANGE
  //ADD NEW USER
  $(document).on('click touchstart', '#add_new_usr', function(event) {
    event.preventDefault();
    var new_btn = 'btn-blue';
    var newTitle = lang.commonCreateNew;
    var phpContent = 'url:' + modulePath + 'confirmBox/add_user.php';
    var art_name;
    $.confirm({
      title: newTitle,
      content: phpContent,
      buttons: {
        formSubmit: {
          text: lang.commonCreateButton,
          btnClass: new_btn,
          action: function() {
            var email = $('#newEmail').val();
            var pass = $('#pass').val();
            var moduleID = $('#moduleID').val();
            var $form = $('#token_data');
            var data = {
              moduleID: moduleID,
              email: email,
              pass: pass
            };
            data = $form.serialize() + '&' + $.param(data);
            $.ajax({
              type: 'POST',
              dataType: 'json',
              url: modulePath + 'actions/add_user.php',
              data: data,
              cache: false,
              success: function(response) {
                showMessage('success', '', '');
                //$("#echart_pie").empty().append(response);
                window.setTimeout(window.location.replace(response.load_new), 500);
              },
              error: function(data) {
                showMessage('error', '', '');
              }
            }); //ajax
          }
        },
        cancel: function() {
          //close
        },
      },
      onContentReady: function() {}
    }); //confirm      
  });
  // /ADD NEW USER
}); //document ready