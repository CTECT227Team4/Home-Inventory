<?php # user_profile.php
$page_title = "Home Inventory - User Information"; //sets title
$page_heading = "User Information"; //sets heading to appear on page
require_once "inc/header.inc.php"; 
?><script>
$(document).ready(function() {
	$( "#tabs" ).tabs();
	$(function() {
		$( "#resizable resizable2" ).resizable({
			handles: "se"
		 });
	});
});
</script>
<!-- END HEADER CONTENT -->

	<div class="content">

		<div id="tabs">
			<form method="Post" action="main.php?F=8" id="user_info">
			  	<ul>
				    <li><a href="#tabs-1">User Profile</a></li>
				    <li><a href="#tabs-2">Change Password</a></li>
				    <li><a href="#tabs-3">Insurance</a></li>
			  	</ul>
			  	<div id="tabs-1" class="user_tab tabs_nav">

		  			<p class="tab_one_wide">
						<label for="name">Name:</label>
						<input id="name" type="text" name="name">    
					</p>
					<p class="tab_two_wide">
						<label for="email">E-Mail Address:</label>
						<input id="email" type="text" name="email">  
					</p>
					<p class="tab_two_wide">      <!--  makes two inputs on one line -->
						<label for="telephone">Telephone:</label>
						<input id="telephone" type="text" name="telephone">       
					</p>
					<p class="tab_one_wide_text">     
						<label for="notes">Notes:</label>
						<textarea id="resizable" name="notes" ></textarea>
					</p>				
				</div>  <!-- end of tabs 1 -->

				<div id="tabs-2" class="password_tab tabs_nav">

				<h3>Please verify your current password:</h3>
				<p class="two_wide">          <!--  makes two inputs on one line -->
					<label for="currentPassword">Current Password:</label>
					<input id="currentPassword" type="password" name="currentPassword">
					<label for="password" class="error" id="currentError">Please enter current Password.</label>
				</p>

				<h3>Now please enter your new password and verify it:</h3>
				<p class="two_wide">          <!--  makes two inputs on one line -->
					<label for="password">Password:</label>
					<input id="password" type="password" name="password">
					<label for="password" class="error" id="passwordError">Please enter a Password.</label>
				</p>
				<p class="two_wide">             <!--  makes two inputs on one line, one with a long label -->
					<label for="verifyPassword">Verify Password:</label>
					<input id="verifyPassword" type="password" name="verifyPassword">
					<label for="verifyPassword" class="error" id="verifyError">Please verify your Password.</label>
					<label for="verifyPassword" class="error" id="verifyError2">Passwords do not match.</label>
				</p>

				<h3>Thank You or No Dice Message</h3>

				</div>   <!-- end of tabs2 -->

				<div id="tabs-3" class="insurance_tab tabs_nav">
		  			<p class="tab_one_wide">
						<label for="insurance_name">Insurance Company:</label>
						<input id="name" type="text" name="name">    
					</p>
		  			<p class="tab_one_wide">
						<label for="agent_name">Agent's Name:</label>
						<input id="agent_name" type="text" name="agent_name">    
					</p>	
					<p class="tab_two_wide">      <!--  makes two inputs on one line -->
						<label for="policy">Policy Number:</label>
						<input id="premium" type="text" name="premium">       
					</p>
					<p class="tab_two_wide">
						<label for="policy_dates">Policy Dates:</label>
						<input id="policy_dates" type="text" name="policy_dates">    
					</p>	
					<p class="tab_two_wide">      <!--  makes two inputs on one line -->
						<label for="premium">Annual Premium:</label>
						<input id="premium" type="text" name="premium">       
					</p>
					<p class="tab_two_wide">      <!--  makes two inputs on one line -->
						<label for="deductible">Deductible:</label>
						<input id="deductible" type="text" name="deductible">       
					</p>
					<p class="coverage">      <!--  makes two inputs on one line -->
						<label for="dwelling">Coverage -- Dwelling:</label>
						<input id="dwelling" type="text" name="dwelling">       
					</p>
					<p class="coverage">      <!--  makes two inputs on one line -->
						<label for="structures">Coverage -- Other Structures:</label>
						<input id="structures" type="text" name="structures">       
					</p>
					<p class="coverage">      <!--  makes two inputs on one line -->
						<label for="personal_prop">Coverage -- Personal Property:</label>
						<input id="personal_prop" type="text" name="personal_prop">       
					</p>
					<p class="coverage">      <!--  makes two inputs on one line -->
						<label for="living_exp">Coverage -- Addtl Living Expenses:</label>
						<input id="living_exp" type="text" name="living_exp">       
					</p>
					<p class="coverage">      <!--  makes two inputs on one line -->
						<label for="liability">Coverage -- Personal Liability:</label>
						<input id="liability" type="text" name="liability">       
					</p>
					<p class="coverage">      <!--  makes two inputs on one line -->
						<label for="medical">Coverage -- Medical Payments:</label>
						<input id="medical" type="text" name="medical">       
					</p>
					<p class="coverage">      <!--  makes two inputs on one line -->
						<label for="riders">Additional Coverage -- Valuable Articles:</label>
						<input id="riders" type="text" name="riders">       
					</p>
					<p class="tab_one_wide_text">     
						<label for="notes">Notes:</label>
						<textarea id="resizable2" name="notes" ></textarea>
					</p>	
				</div>    <!-- end of tabs3 -->

				<p class="centered_button">
					<input type="submit" value="Submit"  id="add_item_submit">
				</p>		
			</form>   <!--  end of form -->
		</div>	<!-- end of tabs -->	
	</div>   <!-- end of content -->
	<script src="js/validate_password_change.js"></script>
</body>
</html>