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

function testfun(user) {
	//$('#treeview').jstree.core;
	//var tv = $('#treeview');
	//tv[0].baseURI = "./main.php?F=1&userid=" + user;
	
	
	///*
	$('#treeview').jstree({
		'core' : {
			'data' : {
				"url" : "./main.php?F=1&userid=2"
			, "dataType" : "json"
			}
		}, "plugins" : ["contextmenu", "dnd"]
	});
	//*/
	$('#treeview').jstree('refresh');
}

function gridHeader(gridType) {
	var header =  document.getElementById('grid-headers');
	var newHeader = "<tr>";
	var grid = $('#grid-basic').DataTable();
	
	grid.destroy();
	switch(gridType) {
		case 1: // Properties
			$('#grid-basic').DataTable({
				"columns": [{ "title": "Name" },{ "title": "Property" },{ "title": "Name" },{ "title": "Description" },{ "title": "Zip" }]
			});
			//newHeader += '<th data-column-id="name" data-type="numeric">Name</th><th data-column-id="address">Address</th><th data-column-id="city" data-order="desc">City</th><th data-column-id="state">State</th><th data-column-id="zip">Zip</th>';
		case 2: // Rooms
			$('#grid-basic').DataTable({
				"columns": [{ "title": "Name" },{ "title": "Property" },{ "title": "Name" },{ "title": "Description" }]
			});
			//newHeader += '<th data-column-id="name" data-type="numeric">Name</th><th data-column-id="property">Property</th><th data-column-id="name" data-order="desc">Name</th><th data-column-id="description">Description</th>';
		case 3: // Sections
			newHeader += '';
		case 4: // Items
			newHeader += '';
		default:
			newHeader += '<th>Undefined Headers</th>';
	}
	header.innerHTML += '</tr>';
}

