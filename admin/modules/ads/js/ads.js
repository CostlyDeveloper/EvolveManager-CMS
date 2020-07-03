var $ = jQuery.noConflict();
jQuery(document).ready(function($) {
  //MODULE PATH 
  var modulep = 'ads';
  var modulePath = 'modules/' + modulep + '/';
  // /MODULE PATH

  function call_switch() {
    // Switchery
    var elem = document.querySelector('.js-switch');
    var init = new Switchery(elem, {
      color: '#26B99A'
    });
    // /Switchery
  };
  //EDIT
  $(document).on('submit', '#edit_ad_form', function() {
    var formDetails = $('#edit_ad_form, #token_data');
    $.ajax({
      type: 'POST',
      url: modulePath + 'actions/edit_ad.php',
      data: formDetails.serialize(),
      success: function(data) {
        showMessage('success', '', '');
        $("#dev").html(data);
      },
      error: function(data) {
        showMessage('error', '', '');
        //window.setTimeout('location.reload()', 1000);
      }
    });
    return false;
  });
  // /EDIT
  // ADD NEW 
  $(document).on('click touchstart', '#add_new_ad', function(event) {
    event.preventDefault();
    var new_btn = 'btn-blue';
    var newTitle = lang.commonCreateNew;
    var phpContent = 'url:' + modulePath + 'confirmBox/add_ad.php';
    $.confirm({
      title: newTitle,
      content: phpContent,
      buttons: {
        formSubmit: {
          text: lang.commonCreateButton,
          btnClass: new_btn,
          action: function() {
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
              url: modulePath + 'actions/add_ad.php',
              data: data,
              cache: false,
              success: function(response) {
                showMessage('success', '', '');
                window.setTimeout(window.location.replace(response.load_new), 500);
              },
              error: function(data) {
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
  // PUBLISH SWITCH (category list)
  $('.publish_switch').change(function(e) {
    e.preventDefault();
    var instanceID = $(this).attr('data-id');
    if ($(this).prop('checked')) {
      var published = 1;
    } else {
      var published = 0;
    }
    $.ajax({
      type: 'POST',
      url: modulePath + 'actions/publish.php',
      data: {
        instanceID: instanceID,
        published: published
      },
      success: function(data) {
        showMessage('success', '', '');
      },
    });
    return false;
  });
  // / PUBLISH SWITCH (category list)
  //SORTABLE
  $("#sort_instances").sortable({
    'items': 'li',
    'placeholder': 'placeholder_dragable',
    'update': function() {
      $.post(
      modulePath + 'actions/input_new_order.php',
      //$("#sort_slides").sortable('serialize'),      
      $("#sort_instances").serializeTree("data-id", "postData"), function(data) {
        $("#span").html(data);
      }, "text");
    }
  }).disableSelection();
  // /SORTABLE  
}); //document ready