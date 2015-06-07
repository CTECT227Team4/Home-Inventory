<?php # landing.php
$page_title = "A-Z Home Inventory";
$page_heading = "Home Inventory";
$nav_context = "inventory";
// $nav_context sets the first nav item to be the grid/tree view toggler
// This value is *case sensitive*
require_once "inc/header.inc.php";
?>
	<div id="data_wrapper">
		<div id="toggle_view_buttons">
			<button id="toggler" href="javascript: void(0)" onclick="toggleView()">Inventory Grid View</button>
		</div>   <!-- end toggle view buttons -->
		<div id="treemain" class="dispwindow">
			<div id="treeviewwidget" class="viewwidget">
				<button class="allButtons" onclick="$('.jstree').jstree('open_all');">Open All</button>
				<button class="allButtons" onclick="$('.jstree').jstree('close_all');">Close All</button>
				<div id="treeview" class="viewwidget">
				</div>   <!-- end treeview -->
			</div>   <!-- end treeviewwidget -->
		</div>   <!-- end treemain -->

		<div id="gridmain" class="dispwindow">
			<div id="gridviewwidget" class="viewwidget">
				<br><p>
					<button class="gridMainButton" onclick="">Properties</button>
					<button class="gridMainButton" onclick="">Rooms</button>
					<button class="gridMainButton" onclick="">Sections</button>
					<button class="gridMainButton" onclick="">Items</button>
				</p>
				<div id="gridview">
					<table id="grid-basic" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th data-column-id="id">Image</th>
								<th data-column-id="sender" class="table-name">Name</th>
								<th data-column-id="received" data-order="desc" class="table-desc">Description</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td ><img class="table-images"src="images/addams-home.jpg" height="64" width="64"></td>
								<td class="table-name">Addams Family Home</td>
								<td class="table-desc">0001 Cemetery Lane</td>
							</tr>
							<tr>
								<td><img class="table-images"src="images/HauntedLakeHouse.jpg" height="64" width="64"></td>
								<td class="table-name">Haunted Lake House</td>
								<td class="table-desc">1313 Dead Lake</td>
							</tr>
							<tr>
								<td><img class="table-images"src="images/shed.jpg" height="64" width="64"></td>
								<td class="table-name">Scary Shed</td>
								<td class="table-desc">in the Backyard</td>
							</tr>
							<tr>
								<td></td>
								<td class="table-name"><a href="#">Add New Property</a></td>
								<td class="table-desc"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div> <!-- End of grid -->
	</div> <!-- End of data_wrapper -->
</div> <!-- End of page_wrapper -->
<script>
function toggleView() { // Toggle tree vs grid views
	var treeview = document.getElementById('treemain');
	var gridview = document.getElementById('gridmain');
	var toggler =  document.getElementById('toggler');
	if (treeview.style.display == 'none') {
		gridview.style.display = 'none'
		treeview.style.display = 'block'
		toggler.textContent = "Inventory Grid View";
	} else {
		gridview.style.display = 'block'
		treeview.style.display = 'none'
		toggler.textContent = "Inventory Tree View";
	}
}
$(function () {
	$('#gridmain').hide();
	$('#grid-basic').DataTable();
	$('#treeview').jstree({
		'core' : {
			'data' : {
				"url" : <?php
					//$json = $_GET['id'];
					//if ($json == null) $json = '1';
					//echo "\"./$json.json\""; 
					echo '"main.php?F=1&userid=' . $userid . '"';
			?>,	"dataType" : "json" // needed only if you do not supply JSON headers
			}
		}, "plugins" : ["contextmenu", "dnd"]
	});
});
</script>	
</body></html>