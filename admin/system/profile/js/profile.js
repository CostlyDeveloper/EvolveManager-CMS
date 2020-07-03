var $ = jQuery.noConflict();
jQuery( document ).ready(function( $ ) {
  

//MODULE PATH 
var modulep = 'profile'; 
var modulePath = 'system/'+modulep+'/';
// /modulePath


//EDIT PROFILE
	$(document).on('submit', '#edit_'+modulep+'_form', function(event) {
	 event.preventDefault();
		//var formDetails = $(this);
		$.ajax({
			type: 'POST',
      dataType: 'json',
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
    
// /EDIT PROFILE

//PASWORD MATCH FUNCTION
function checkPasswordMatch() {
    var password = $("#new_pass").val();
    var confirmPassword = $("#confirm_pass").val();

    if (password != confirmPassword){
        $("#usr_confirm_pass").addClass("bad");
        $("#passAlert").show(500);
        }
    else{
       $("#usr_confirm_pass").removeClass("bad");
       $("#passAlert").hide();
       }
}
// / PASWORD MATCH FUNCTION


$("#new_pass, #confirm_pass").keyup(checkPasswordMatch);//PASSWORD CHANGE

}); //document ready
