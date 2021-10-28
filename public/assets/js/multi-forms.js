$(document).ready(function(){  
    var form_count = 1, previous_form, next_form, total_forms;
    total_forms = $("fieldset").length;  
    $(".next-form").click(function(){
        previous_form = $(this).parent();
        next_form = $(this).parent().next();
        next_form.show();
        previous_form.hide();
        setProgressBarValue(++form_count);
        });  
    $(".previous-form").click(function(){
        previous_form = $(this).parent();
        next_form = $(this).parent().prev();
        next_form.show();
        previous_form.hide();
        setProgressBarValue(--form_count);
        });
    setProgressBarValue(form_count);  
    function setProgressBarValue(value){
    var percent = parseFloat(100 / total_forms) * value;
    percent = percent.toFixed();
    $(".progress-bar")
      .css("width",percent+"%")
      .html(percent+"%");   
    } 
  // Handle form submit and validation
    $( "#register_form" ).submit(function(event) {    
  	    var error_message = '';
          	if(!$("#first_name").val()) {
              error_message+="Please Fill First Name";
            }
            if(!$("#last_name").val()) {
              error_message+="Please Fill Last Name";
            }
            if(!$("#email").val()) {
              error_message+="Please Fill Email Address";
            }
            if(!$("#password").val()) {
              error_message+="Please Fill Password";
            }
            if(!$("#nok_name").val()) {
              error_message+="Please Fill Next of Kin Name";
            } 
            if(!$("#nok_address").val()) {
              error_message+="Please Fill Next of Kin's Address";
            } 
            if(!$("#nok_email").val()) {
              error_message+="Please Fill  Next of Kin's Email Address";
            } 
            if(!$("#nok_phone").val()) {
              error_message+="Please Fill  Next of Kin Phone Number";
            } 
            if(!$("#street").val()) {
              error_message+="Please Fill Street Address";
            }
            if(!$("#city").val()) {
              error_message+="Please Fill City";
            }
            if(!$("#state_id").val()) {
              error_message+="Please Fill State";
            }  
            if(!$("#phone").val()) {
              error_message+="Please Fill Phone number";
            }
          	// Display error if any else submit form
        	  if(error_message) {
        		    $('.alert-success').removeClass('hide').html(error_message);
        		    return false;
        	  } 
            else {return true;}    
        });  
    });