<nav>
	<ul class="upper_buttons">
		<li ><a id="toggler" href="javascript: void(0)" onclick="toggleView()">Grid View</a></li>
		<li><a href="add_property.php">Add Stuff</a></li>
		<li><a href="reports.php">Reports</a></li>
		<li><a href="user_profile.php"><?php echo $_SESSION['firstName']; ?></a>
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