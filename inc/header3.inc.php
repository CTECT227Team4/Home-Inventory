	<header class="header3">
		<div class="side_logo">
			<img class="small_logo" src="images/logo.png" alt="A-Z Home Inventory Logo" sizes="30vw"
				srcset="images/logo.png 1000w"
			>
		</div>
		<div class="header_welcome">
			<?php 
				include "header_welcome.inc.php";
			 ?>
		</div>
		<nav>
			<ul class="upper_buttons">
				<li><a href="change.view.php">Change View</a></li>
				<li><a href="add_stuff.php">Add Stuff</a></li>
				<li><a href="reports.php">Reports</a></li>
				<li><a href="user_profile.php">Gomez</a>                        <!--  <?php echo $firstName ?> -->
					<ul>
						<li><a href="user_profile.php">User Profile</a></li>
						<li><a href="change_password.php">Change Password</a></li>
						<li><a href="#">I Don't Know</a></li>
						<li><a href="#">I Don't Know</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</li>
			</ul>
		</nav>
	</header>