<nav>
	<div class="dropdown">
	    <button><a href="landing.php">Inventory</a></button>     <!-- trigger button -->
	</div>  <!-- end dropdown -->

	<div class="dropdown">
		<button><a href="#">Add &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a><i class="fa fa-caret-down"></i></button>
			<ul class="dropdown_menu">
				<li><a href="add_property.php">Add Property</a></li>
				<li><a href="room.php">Add Room</a></li>
				<li><a href="section.php">Add Section</a></li>
				<li><a href="item.php">Add Item</a></li>
			</ul>
	</div>  <!-- end dropdown -->

	<div class="dropdown">
		<button><a href="reports.php">Reports</a></button>
	</div>  <!-- end dropdown -->

	<div class="dropdown">
		<button><a href="user_profile.php"><?php echo ucfirst($_SESSION['firstName']); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down"></i></a></button>
			<ul class="dropdown_menu">
				<li><a href="user_profile.php">User Profile</a></li>
				<li><a href="user_profile.php#tabs-2">Change Password</a></li>
				<li><a href="user_profile.php#tabs-3">Insurance</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
	</div>   <!-- end dropdown -->
</nav>