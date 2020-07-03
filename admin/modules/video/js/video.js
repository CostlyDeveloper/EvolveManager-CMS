var $ = jQuery.noConflict();
jQuery(document).ready(function($) {
  //MODULE PATH 
  var modulep = 'video';
  var modulePath = 'modules/' + modulep + '/';
  // /MODULE PATH        
  //ADD NEW VIDEO
  $(document).on('click touchstart', '#add_new_video', function(event) {
    event.preventDefault();
    var new_btn = 'btn-blue';
    var newTitle = lang.videoTitleNew;
    var phpContent = 'url:' + modulePath + 'confirmBox/add_video.php';
    var art_name;
    $.confirm({
      title: newTitle,
      content: phpContent,
      buttons: {
        formSubmit: {
          text: lang.commonCreateButton,
          btnClass: new_btn,
          action: function() {
            var langArray = [];
            var pub_type_id = $('#pub_type_id').val();
            $('.video_lang').each(function() {
              langSlug = $(this).attr('id').split('_')[1];
              videoTitle = $(this).val();
              langArray.push({
                slug: langSlug,
                title: videoTitle
              });
            });
            var jsonLang = JSON.stringify(langArray);
            var moduleID = $('#moduleID').val();
            var videoURL = $('#videoURL').val();
            var $form = $('#token_data');
            var data2 = {
              moduleID: moduleID,
              data: jsonLang,
              videoURL: videoURL,
              pub_type_id: pub_type_id
            };
            data2 = $form.serialize() + '&' + $.param(data2);
            $.ajax({
              type: 'POST',
              dataType: "json",
              url: modulePath + 'actions/add_video.php',
              data: data2,
              cache: false,
              success: function(response) {
                showMessage('success', '', '');
                window.setTimeout(window.location.replace(response.load_video_url), 500);
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
  // /ADD NEW VIDEO
  // PUBLISH SWITCH (category list)
  $('.publish_switch').change(function(e) {
    e.preventDefault();
    var videoID = $(this).attr('data-id');
    if ($(this).prop('checked')) {
      var published = 1;
    } else {
      var published = 0;
    }
    var moduleID = $('#moduleID').val();
    var videoURL = $('#videoURL').val();
    var $form = $('#token_data');
    var data = {
      moduleID: moduleID,
      instanceID: videoID,
      published: published
    };
    data = $form.serialize() + '&' + $.param(data);
    $.ajax({
      type: 'POST',
      url: modulePath + 'actions/publish.php',
      data: data,
      success: function(data) {
        showMessage('success', '', '');
      },
      error: function(data) {
        showMessage('error', '', '');
      }
    });
    return false;
  });
  // / PUBLISH SWITCH (category list) 
    // FEATURE SWITCH (category list)
  $('.featured_switch').change(function(e) {
    e.preventDefault();
    var videoID = $(this).attr('data-id');
    if ($(this).prop('checked')) {
      var featured = 1;
    } else {
      var featured = 0;
    }
    var moduleID = $('#moduleID').val();
    var videoURL = $('#videoURL').val();
    var $form = $('#token_data');
    var data = {
      moduleID: moduleID,
      instanceID: videoID,
      featured: featured
    };
    data = $form.serialize() + '&' + $.param(data);
    $.ajax({
      type: 'POST',
      url: modulePath + 'actions/featured.php',
      data: data,
      success: function(data) {
        showMessage('success', '', '');
      },
      error: function(data) {
        showMessage('error', '', '');
      }
    });
    return false;
  });
  // / FEATURE SWITCH (category list) 
  //EDIT VIDEO
  $(document).on('submit', '#edit_video_form', function() {
    var formDetails = $('#edit_video_form, #token_data');
    $.ajax({
      type: 'POST',
      url: modulePath + 'actions/edit_video.php',
      data: formDetails.serialize(),
      success: function(data) {
        showMessage('success', '', '');
      },
      error: function(data) {
        showMessage('error', '', '');
        window.setTimeout('location.reload()', 1000);
      }
    });
    return false;
  });
  // /EDIT VIDEO  
}); //document ready