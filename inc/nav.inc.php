<nav>
	<ul class="upper_buttons">
		<li ><a id="toggler" href="javascript: void(0)" onclick="toggleView()">Grid View</a></li>
		<li><a href="add_property.php">Add &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down"></i></a>
			<ul>
				<li><a href="add_property.php">Add Property</a></li>
				<li><a href="add_room.php">Add Room</a></li>
				<li><a href="add_section.php">Add Section</a></li>
				<li><a href="add_item.php">Add Item</a></li>
			</ul>
		</li>
		<li><a href="reports.php">Reports</a></li>
		<li><a href="user_profile.php"><?php echo $_SESSION['firstName']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down"></i></a>
			<ul>
				<li><a href="user_profile.php">User Profile</a></li>
				<li><a href="user_profile.php#tabs-2">Change Password</a></li>
				<li><a href="user_profile.php#tabs-3">Insurance</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</li>
	</ul>
</nav>