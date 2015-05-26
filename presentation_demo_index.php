<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>A-Z Home Inventory Demo</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" type="text/css" href="./jquery/jquery.dataTables.css">
<link rel="stylesheet" href="jquery/themes/default/style.min.css" />
<link rel="shortcut icon" href="./images/favicon.ico"></head>
<body>

	<script src="./jquery/jquery.2.min.js"></script>
	<!-- Grid init -->
	<script type="text/javascript" language="javascript" src="./jquery/jquery.dataTables.js"></script>

	<!-- Tree init -->
	<script src="./jquery/jstree.min.js"></script>
<section class="wrapper">
	<p>
		<a class="pageNumbers" href="index.php?id=1">Page 1</a>
		<a class="pageNumbers" href="index.php?id=2">Page 2</a>
		<a class="pageNumbers" href="index.php?id=3">Page 3</a>
	</p>
	<p>
		<button id="toggler" onclick="toggleView()">Grid View</button>
	</p>

	<div id="treemain" class="dispwindow">
		<div id="treeviewwidget" class="viewwidget">
			<p>
				<button class="allButtons" onclick="$('.jstree').jstree('open_all');">Open All</button>
				<button class="allButtons" onclick="$('.jstree').jstree('close_all');">Close All</button>
			</p>
			<div id="treeview" class="viewwidget">
			</div>   <!-- end treeview -->
		</div>   <!-- end treeviewwidget -->
	</div>   <!-- end treemain -->

	<div id="gridmain" class="dispwindow">
		<div id="gridviewwidget" class="viewwidget">
			<p>
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
				            <td ><img class="table-images"src="images/addams-home.jpg"></td>
				            <td class="table-name">Addams Family Home</td>
				            <td class="table-desc">0001 Cemetery Lane</td>
				        </tr>
						<tr>
				            <td><img class="table-images"src="images/HauntedLakeHouse.jpg"></td>
				            <td class="table-name">Haunted Lake House</td>
				            <td class="table-desc">1313 Dead Lake</td>
				        </tr>
						<tr>
				            <td><img class="table-images"src="images/shed.jpg"></td>
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
	</div>
</section>
<!-- Page init -->
<!--<script src="./jquery/az.js"></script>-->

<script>
function toggleView() { // Toggle tree vs grid views
	var treeview = document.getElementById('treemain');
	var gridview = document.getElementById('gridmain');
	var toggler =  document.getElementById('toggler');
	if (treeview.style.display == 'none') {
		gridview.style.display = 'none'
		treeview.style.display = 'block'
		toggler.textContent = "Grid View";
	} else {
		gridview.style.display = 'block'
		treeview.style.display = 'none'
		toggler.textContent = "Tree View";
	}
}
$(function () {
	$('#grid-basic').DataTable();
	$('#treeview').jstree({
		'core' : {
			'data' : {
				"url" : <?php
					$json = $_GET['id'];
					if ($json == null) $json = '1';
					//echo "\"./$json.json\""; 
					echo '"http://localhost/az/main.php?F=1&userid=3"';
			?>,	"dataType" : "json" // needed only if you do not supply JSON headers
			}
		}, "plugins" : ["contextmenu", "dnd"]
	});
});
</script>


</body></html>