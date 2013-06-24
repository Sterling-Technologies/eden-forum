$(document).ready(function(){

	if($('.error_box2').html()==""){
		$('.error_box2').hide();
	}
	if($('.error_box1').html()==""){
		$('.error_box1').hide();
	}
	
	var validator = new FormValidator('signup', [
	{
	    name: 'firstname',
	    rules: 'required'
	}, {
	    name: 'lastname',
	    rules: 'required'
	}
	, {
	    name: 'password',
	    rules: 'required|min_length[6]'
	}, {
	    name: 'cpassword',
	    display: 'password confirmation',
	    rules: 'required|matches[password]|min_length[6]'
	}, {
	    name: 'email',
	    rules: 'valid_email'
	}
	], function(errors, event) {

		  var SELECTOR_ERRORS = $('.error_box1')
	    if (errors.length > 0) {
	         SELECTOR_ERRORS.empty();
	        for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
	            SELECTOR_ERRORS.append(errors[i].message + '<br />');
	        }
	        SELECTOR_ERRORS.fadeIn(200);
	        $('.error_box2').hide();
	    }
	});

	$('#myModal').on('show', function (e) {
    	$('#forgotresponse').hide();
    });
    $('#myModal').on('hidden', function (e) {
    	$("#forgotresponse").attr('class', 'alert alert-error');
    	$('#forgotresponse').html("");
    	$('#femail').val("");
    	$('#forgotresponse').hide();
    });


    $('#sendEmail').click(function(){
    		 $.ajax({
    	        url: "/forgot",
    	        type: "post",
    	        data: "&femail=" + $('#femail').val() ,
    	        beforeSend : function(){
			     	$('#forgotresponse').show();
			     	$('#forgotresponse').html('Checking...');
			    },
    	    	}).done(function(msg){
    	    		$('#forgotresponse').show();
    	    		if(msg=="Invalid email."){

    	    		$("#forgotresponse").attr('class', 'alert error');
    	    		}else{
    	    		$("#forgotresponse").attr('class', 'alert alert-success');
    	    		}
    	  			$('#forgotresponse').html(msg);
    		  	});
    });
});