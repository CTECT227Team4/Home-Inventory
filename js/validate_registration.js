		$(document).ready(function(){
			$(".error").hide();  // hide the errors, if any exist

			var value = "";   // create variables
			var passwordValue = "";
       		var verifyValue = "";
			var errorFirst = false;
			var errorLast = false;
			var errorEmail = false;
			var errorUserName = false;
			var errorPassword = false;
			var errorVerify = false;

			var preventSubmit = true;

		//This section checks for empty fields as the form is being filled out 
			$(':input#firstName').blur(function(){    // check when cursor moves out of field that it isn't empty
					value = $(this).val();
					if (value == "") {                // if the value is empty
						$(this).addClass('error');    // turns on the error class
						$('#firstError').show();      // shows the error message 
					} else {
						$(this).removeClass('error'); // turns off the error class
						$('#firstError').hide();      // turns off the error message
					} // end if
			});//end each

			$(':input#lastName').blur(function(){    // check when cursor moves out of field that it isn't empty
					value = $(this).val();
					if (value == "") {                // if the value is empty
						$(this).addClass('error');    // turns on the error class
						$('#lastError').show();      // shows the error message 
					} else {
						$(this).removeClass('error'); // turns off the error class
						$('#lastError').hide();      // turns off the error message
					} // end if
			});//end each

			$(':input#email').blur(function(){    // check when cursor moves out of field that it isn't empty
					value = $(this).val();
					if (value == "") {                // if the value is empty
						$(this).addClass('error');    // turns on the error class
						$('#emailError').show();      // shows the error message 
					} else {
						$(this).removeClass('error'); // turns off the error class
						$('#emailError').hide();      // turns off the error message
					} // end if
			});//end each

			$(':input#userName').blur(function(){    // check when cursor moves out of field that it isn't empty
					value = $(this).val();
					if (value == "") {                // if the value is empty
						$(this).addClass('error');    // turns on the error class
						$('#userError').show();      // shows the error message 
					} else {
						$(this).removeClass('error'); // turns off the error class
						$('#userError').hide();      // turns off the error message
					} // end if
			});//end each

			$(':input#password').blur(function(){    // check when cursor moves out of field that it isn't empty
					passwordValue = $(this).val();
					if (passwordValue == "") {                // if the value is empty
						$(this).addClass('error');    // turns on the error class
						$('#passwordError').show();      // shows the error message 
					} else {
						$(this).removeClass('error'); // turns off the error class
						$('#passwordError').hide();      // turns off the error message
					} // end if
			});//end each

			$(':input#verifyPassword').blur(function(){    // check when cursor moves out of field that it isn't empty
					verifyValue = $(this).val();
					if (verifyValue == "") {                // if the value is empty
						$(this).addClass('error');    // turns on the error class
						$('#verifyError').show();      // shows the error message 
        			} else if (verifyValue != passwordValue) {
						$(this).addClass('error');    // turns on the error class
						$('#verifyError2').show();      // shows the error message 
					} else {
						$(this).removeClass('error'); // turns off the error class
						$('#verifyError').hide();      // turns off the error message
						$('#verifyError2').hide();     // turns off the 2nd error message
					} // end if
			});//end each

		//  This section is a function that checks data and returns a true/false to prevent submit 
		function checkData() {
			$(':input#firstName').focus();  // Moves through all of the fields to trigger errors
			$(':input#lastName').focus();
			$(':input#email').focus();
			$(':input#userName').focus();
			$(':input#password').focus();
			$(':input#verifyPassword').focus();

			// Now it's checking for errors and returns true to preventSubmit
			value = $(':input#firstName').val();
			if ( value == "" ){
				return true;
			};
			value = $(':input#lastName').val();
			if ( value == "" ) {
				return true;
			};
			value = $(':input#email').val();
			if ( value == "" ) {
				return true;
			};
			value = $(':input#userName').val();
			if ( value == "" ) {
				return true;
			};
			value = $(':input#password').val();
			if ( value == "" ) {
				return true;
			};
			value = $(':input#verifyPassword').val();
			if ( value == "" ) {
				return true;
			};
		};// end checkData()


		//  This function handled the submit button
			$('#register').submit(function(event){
				$('#register').prop('disabled',true);     	// disable submit button

				preventSubmit = checkData();     			// sets a variable to the value returned from the checkData function 

				if (preventSubmit == true) {
					event.preventDefault();
					$('#register').prop('disabled',false);    	// re-enable submit button
				};  // enter re-enable submit
			});//end submit
		}); // end ready