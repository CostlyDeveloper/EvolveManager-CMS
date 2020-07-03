var $ = jQuery.noConflict();
  
// /SORT
jQuery( document ).ready(function( $ ) {
  
//MODULE PATH 
var modulep = 'site_setup'; 
var modulePath = 'modules/'+modulep+'/';
// /MODULE PATH  
 

//EDIT
	$(document).on('submit', '#edit_'+modulep+'_form', function(event) {
	 event.preventDefault();
		//var formDetails = $(this);
		$.ajax({
			type: 'POST',
      //dataType: 'json',
			url: modulePath+'actions/edit_'+modulep+'.php',
			data: $(this).serialize(),
			success: function(data) {
			 $("#ajax").empty().append(data);
				showMessage('success','','');
      },
      error:function(data){
      showMessage('error','','');
      },
		});
		return false;
	});
    
// /EDIT 

}); //document ready
