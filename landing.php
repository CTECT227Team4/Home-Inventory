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
							<th>ID</th>
							<th>Name</th>
							<th>Address</th>
							<th>Zip</th>
							<th>Description</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Address</th>
							<th>Zip</th>
							<th>Description</th>
						</tr>
					</tfoot>
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
	//$('#grid-basic').DataTable();
	$('#grid-basic').DataTable({
        "ajax": "main.php?F=24",
		"columns": [
			{ "data": "ID" },
			{ "data": "Name" },
			{ "data": "Address" },
			{ "data": "Zip" },
			{ "data": "Description" }
		]
    });
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