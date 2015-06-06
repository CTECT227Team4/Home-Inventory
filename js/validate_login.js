		$(document).ready(function(){
			$(".error").hide();  // hide the errors, if any exist

			var value = "";   // create variables
			var errorUserName = false;
			var errorPassword = false;

			var preventSubmit = false;

		//This section checks for empty fields as the form is being filled out 

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

			$(':input#password').blur(function(){        // check when cursor moves out of field that it isn't empty
					value = $(this).val();
					if (value == "") {           // if the value is empty
						$(this).addClass('error');       // turns on the error class
						$('#passwordError').show();      // shows the error message 
					} else {
						$(this).removeClass('error');    // turns off the error class
						$('#passwordError').hide();      // turns off the error message
					} // end if
			});//end each

		//  This section is a function that checks data and returns a true/false to prevent submit 
		function checkData() {

			$(':input#userName').focus();      			 // Moves through all of the fields to trigger errors
			$(':input#password').focus();

			// Now it's checking for errors and returns true to preventSubmit
			value = $(':input#userName').val();
			if ( value == "" ) {
				return true;
			};
			value = $(':input#password').val();
			if ( value == "" ) {
				return true;
			};
		};// end checkData()


		//  This function handled the submit button
			$('#submit').submit(function(event){
				$('#submit').prop('disabled',true);     	// disable submit button

				preventSubmit = checkData();     			// sets a variable to the value returned from the checkData function 

				if (preventSubmit == true) {
					event.preventDefault();					
				}  else if (preventSubmit == false) {
					$('#submit').prop('disabled',false);    	// re-enable submit button
				};  // enter re-enable submit
			});//end submit
		}); // end ready