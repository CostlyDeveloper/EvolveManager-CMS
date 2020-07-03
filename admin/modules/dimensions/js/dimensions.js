var $ = jQuery.noConflict();
jQuery(document).ready(function($) {
  //MODULE PATH 
  var modulep = 'dimensions';
  //var root = window.location.protocol + "//" + window.location.host + "/";   
  var modulePath = 'modules/' + modulep + '/';
  // /modulePath
  //UPLOAD WATERMARK
  //Show / hide options
  $('#watermark_enableBig').on('ifChecked', function(e) {
    e.preventDefault();
    $("#watermark_1").fadeIn();
  });
  $('#watermark_enableBig').on('ifUnchecked', function(e) {
    e.preventDefault();
    $("#watermark_1").fadeOut();
  });
  $('#watermark_enableSmall').on('ifChecked', function(e) {
    e.preventDefault();
    $("#watermark_2").fadeIn();
  });
  $('#watermark_enableSmall').on('ifUnchecked', function(e) {
    e.preventDefault();
    $("#watermark_2").fadeOut();
  });
  // /Show / hide options
  $(function() {
    $('#fileInput').on('change', fileUpload);
    $('#fileInput2').on('change', fileUpload);
  });

  function fileUpload(event) {
    var dimensionID = $('input[name=dimensionID]').attr("value");
    var sub_form = $(this).closest('.watermark_block').attr('id');
    var arr = sub_form.split('_');
    var dimensionType = arr[1];
    //get selected file
    files = event.target.files;
    //form data check the above bullet for what it is  
    var data = new FormData();
    //file data is presented as an array
    for (var i = 0; i < files.length; i++) {
      var file = files[i];
      if (!file.type.match('image.*')) {
        //check file type
        $("#success_upload").html("Please choose an images file.");
      } else if (file.size > 1048576) {
        //check file size (in bytes)
        $("#success_upload").html("Sorry, your file is too large )");
      } else {
        //append the uploadable file to FormData object
        var moduleID = $('#moduleID').val();
        var userID   = $('input[name=userID').val();
        var token    = $('input[name=token').val();
        var cpass    = $('input[name=cpass').val();
        var rdts     = $('input[name=rdts').val();
        data.append('file', file, file.name);
        data.append('dimensionID', dimensionID);
        data.append('dimensionType', dimensionType);
        data.append('moduleID', moduleID);
        data.append('userID', userID);
        data.append('token', token);
        data.append('cpass', cpass);
        data.append('rdts', rdts);
        //create a new XMLHttpRequest
        var xhr = new XMLHttpRequest();
        //post file data for upload
        xhr.open('POST', modulePath + 'actions/upload_watermark.php', true);
        xhr.send(data);
        xhr.onload = function() {
          //get response and show the uploading status
          var response = JSON.parse(xhr.responseText);
          $('#' + sub_form + ' .success_upload').html(response.thumb);
        };
      }
    }
  }
  // /UPLOAD WATERAMRK
  //EDIT DIMENSIONS
  $(document).on('submit', '#edit_dimensions_form', function() {
    var formDetails = $('#edit_dimensions_form, #token_data');
    $.ajax({
      type: 'POST',
      url: modulePath + 'actions/edit_dimension.php',
      data: formDetails.serialize(),
      success: function(data) {
        showMessage('success', '', '');
      },
      error: function(data) {
        showMessage('error', '', '');
      }
    });
    return false;
  });
  // /EDIT DIMENSIONS
  //DELETE DIMENSIONS
  $(document).on('click touchstart', '.del_dim', function() {
    var dim_id = $(this).attr('data-id');
    var new_btn = 'btn-red';
    var newTitle = lang.settDelDim;
    $.confirm({
      title: newTitle,
      content: '',
      buttons: {
        formSubmit: {
          text: lang.settDelButton,
          btnClass: new_btn,
          action: function() {
            var moduleID = $('#moduleID').val();
            var $form = $('#token_data');
            var data = {
              moduleID: moduleID,
              dim_id: dim_id
            };
            data = $form.serialize() + '&' + $.param(data);
            $.ajax({
              type: 'POST',
              url: modulePath + 'actions/delete_dimension.php',
              data: data,
              success: function(data) {
                $('#dimTr_' + dim_id).fadeOut();
                showMessage('success', '', '');
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
  // /DELETE DIMENSIONS   
  //CREATE NEW DIMENSION
  $(document).on('click touchstart', '#create_dimension', function(event) {
    event.preventDefault();
    var new_btn = 'btn-blue';
    var newTitle = lang.settCreateNewDim;
    var phpContent = 'url:' + modulePath + 'confirmBox/add_dimension.php';
    $.confirm({
      title: newTitle,
      content: phpContent,
      buttons: {
        formSubmit: {
          text: lang.settNewButton,
          btnClass: new_btn,
          action: function() {
            var newDim = $('#newDim').val();
            var moduleID = $('#moduleID').val();
            var $form = $('#token_data');
            var data = {
              moduleID: moduleID,
              newDim: newDim
            };
            data = $form.serialize() + '&' + $.param(data);
            $.ajax({
              type: 'POST',
              dataType: 'json',
              url: modulePath + 'actions/add_dimension.php',
              data: data,
              cache: false,
              success: function(response) {
                showMessage('success', '', '');
                window.setTimeout(window.location.replace(response.load_dim_url), 500);
              },
              error: function(data) {
                showMessage('error', '', '');
              }
            });
          }
        },
        cancel: function() {
          //close
        },
      },
      onContentReady: function() {}
    });
  });
  // /CREATE NEW DIMENSION
}); //document ready