<?php # landing.php
$page_title = "A-Z Home Inventory";
$page_heading = "Home Inventory";
$nav_context = "inventory";
// $nav_context sets the first nav item to be the grid/tree view toggler
// This value is *case sensitive*
require_once ("inc/header.inc.php");
$viewstate = 0;
if (isset($_SESSION["viewstate"])) $viewstate = (int) $_SESSION["viewstate"];
?>
	<div id="data_wrapper">
		<div id="toggle_view_buttons">
			<button id="toggler" href="javascript: void(0)" onclick="toggleView(0)">Inventory Grid View</button>
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
					<button class="gridMainButton" onclick="initprop(true)">Properties</button>
					<button class="gridMainButton" onclick="initroom(true)">Rooms</button>
					<button class="gridMainButton" onclick="initsection(true)">Sections</button>
					<button class="gridMainButton" onclick="inititem(true)">Items</button>
				</p>
				<div id="gridview">
					<table id="grid-basic" class="display" cellspacing="0" width="100%">
					</table>
				</div>
			</div>
		</div> <!-- End of grid -->
	</div> <!-- End of data_wrapper -->
</div> <!-- End of page_wrapper -->
<script>
var viewstate = <?php echo $viewstate?>;

function toggleView(viewstate) { // Toggle tree vs grid views
	var treeview = document.getElementById('treemain');
	var gridview = document.getElementById('gridmain');
	var toggler =  document.getElementById('toggler');
	
	if (viewstate == 1) treeview.style.display = 'none';
	else if (viewstate == 2) treeview.style.display = 'block';
	
	if (treeview.style.display == 'none') {
		gridview.style.display = 'none'
		treeview.style.display = 'block'
		toggler.textContent = "Inventory Grid View";
		$.get("main.php?F=28&view=1");  // Pass the view state back to main.php where it sets the session variable
	} else {
		gridview.style.display = 'block'
		treeview.style.display = 'none'
		toggler.textContent = "Inventory Tree View";
		$.get("main.php?F=28&view=2");
	}
}

function initprop (init) {
	if (init) $('#grid-basic').DataTable().destroy();
	document.getElementById("grid-basic").innerHTML = "<thead><tr><th>Name</th><th>Address</th><th>City</th><th>State</th><th>Zip</th><th>Description</th></tr></thead><tfoot><tr><th><a href=\"property.php\">Add New Property</a></th><th>Address</th><th>City</th><th>State</th><th>Zip</th><th>Description</th></tr></tfoot>";
	$('#grid-basic').DataTable({
		"ajax": "main.php?F=24",
		"columns": [{"data":"Name"},{"data":"Address"},{"data":"City"},{"data":"State"},{"data":"Zip"},{"data":"Description"}]
	});	
}

function initroom (init) {
	if (init) $('#grid-basic').DataTable().destroy();
	document.getElementById("grid-basic").innerHTML = "<thead><tr><th>Room</th><th>Property</th><th>Description</th><th>Category</th><th>Notes</th></tr></thead><tfoot><tr><th><a href=\"room.php\">Add New Room</a></th><th>Property</th><th>Description</th><th>Category</th><th>Notes</th></tr></tfoot>";
	$('#grid-basic').DataTable({
		"ajax": "main.php?F=25",
		"columns": [{"data":"Room"},{"data":"Property"},{"data":"Description"},{"data":"Category"},{"data":"Notes"}]
	});	
}

function initsection (init) {
	if (init) $('#grid-basic').DataTable().destroy();
	document.getElementById("grid-basic").innerHTML = "<thead><tr><th>Section</th><th>Property</th><th>Room</th><th>Description</th><th>Category</th><th>Notes</th></tr></thead><tfoot><tr><th><a href=\"section.php\">Add New Section</a></th><th>Property</th><th>Room</th><th>Description</th><th>Category</th><th>Notes</th></tr></tfoot>";
	$('#grid-basic').DataTable({
		"ajax": "main.php?F=26",
		"columns": [{"data":"Section"},{"data":"Property"},{"data":"Room"},{"data":"Description"},{"data":"Category"},{"data":"Notes"}]
	});	
}

function inititem (init) {
	if (init) $('#grid-basic').DataTable().destroy();
	document.getElementById("grid-basic").innerHTML = "<thead><tr><th>Name</th><th>Property</th><th>Room</th><th>Section</th><th>Category</th><th>Description</th><th>Manufacturer</th><th>Brand</th><th>Model Number</th><th>Serial Number</th><th>Condition</th><th>Beneficiary</th><th>purchaseDate</th><th>purchasePrice</th><th>purchasedFrom</th><th>paymentMethod</th><th>warrantyExpirationDate</th><th>warrantyType</th><th>warranty_attached</th><th>repaired_by</th><th>repair_date</th><th>repair_cost</th><th>repair_attached</th><th>repair_description3</th><th>general_notes</th><th>estimated_value</th><th>appraised_value</th><th>appraisal_date</th><th>appraiser</th><th>appraisal_attached</th><th>description2</th><th>warranty_question</th></thead><tfoot><th><a href=\"item.php\">Add New Item</a></th><th>Property</th><th>Room</th><th>Section</th><th>categoryID</th><th>description1</th><th>Manufacturer</th><th>Brand</th><th>Model Number</th><th>serialNumber</th><th>Condition</th><th>Beneficiary</th><th>purchaseDate</th><th>purchasePrice</th><th>purchasedFrom</th><th>paymentMethod</th><th>warrantyExpirationDate</th><th>warrantyType</th><th>warranty_attached</th><th>repaired_by</th><th>repair_date</th><th>repair_cost</th><th>repair_attached</th><th>repair_description3</th><th>general_notes</th><th>estimated_value</th><th>appraised_value</th><th>appraisal_date</th><th>appraiser</th><th>appraisal_attached</th><th>description2</th><th>warranty_question</th></tfoot>";
	$('#grid-basic').DataTable({
		"ajax": "main.php?F=27",
		"columns": [{"data":"Name"},{"data":"Property"},{"data":"Room"},{"data":"Section"},{"data":"Category"},{"data":"Description"},{"data":"manufacturer"},{"data":"Brand"},{"data":"Model Number"},{"data":"serialNumber"},{"data":"condition"},{"data":"beneficiary"},{"data":"purchaseDate"},{"data":"purchasePrice"},{"data":"purchasedFrom"},{"data":"paymentMethod"},{"data":"warrantyExpirationDate"},{"data":"warrantyType"},{"data":"warranty_attached"},{"data":"repaired_by"},{"data":"repair_date"},{"data":"repair_cost"},{"data":"repair_attached"},{"data":"repair_description3"},{"data":"general_notes"},{"data":"estimated_value"},{"data":"appraised_value"},{"data":"appraisal_date"},{"data":"appraiser"},{"data":"appraisal_attached"},{"data":"description2"},{"data":"warranty_question"}],
		"scrollX": true		
	});	
}

$(function () {
	$('#gridmain').hide();

	initprop(false);
	toggleView(viewstate);
	
	$('#treeview').jstree({
		'core' : {
			'data' : {
				"url" : <?php
					echo '"main.php?F=1&userid=' . $userid . '"';
			?>,	"dataType" : "json" // needed only if you do not supply JSON headers
			}
		}, "plugins" : ["contextmenu", "dnd"]
	});
});
</script>	
</body></html>