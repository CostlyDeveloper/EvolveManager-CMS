/*$(window).on('beforeunload', function ()
    {
        return false;
    });*/
var $ = jQuery.noConflict();
jQuery( document ).ready(function( $ ) {
      
//LOGIN PATH 
var scriptPath = 'system/login/';
// /LOGIN PATH  


//LOGIN
	$(document).on('submit', '#login_form', function() {
		var formDetails = $('#login_form');
		$.ajax({
			type: 'POST',
      dataType: 'json',
			url: scriptPath+'actions/check_login.php',
			data: formDetails.serialize(),
			success: function(data) {
			  if(data.load_admin){
			    window.location.replace(data.load_admin);
			  }else{
			    $("#message").empty().append(data.message);
			  }
		    
      },
	  });
		return false;
  });
    
// /LOGIN 
 // ADD page Title
 var page_title   = $('input[name="page_title"]').val();
 if(page_title){
  document.title = page_title;
 }
 // / ADD page Title
}); //document ready
