<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>A-Z Home Inventory Demo</title><style>
	html { margin:0; padding:0; color: #387929; font-family: Futura,Trebuchet MS,Arial,sans-serif; font-size:62.5%; }
	body { 	background-image: url("./images/a-ztitle.png");
    background-color: #FAFCFB;
	max-width:800px; min-width:300px; margin:0 auto; padding:20px 10px; font-family: Futura,Trebuchet MS,Arial,sans-serif; font-size:14px; font-size:1.4em; }
	h1 { font-family: Futura,Trebuchet MS,Arial,sans-serif; font-size:1.8em; }
	.dispwindow {
		position: fixed;
	    top: 375px;
		left: 309px;
		overflow:auto;
		border:4px solid #90C32E;
		min-height:400px;
		min-width:500px;
	}
	#gridmain {
		display:none;
	}
	#toggler {
		position: fixed;
	    top: 318px;
		left: 590px;
	}
	.viewwidget {
		padding: 0px 15px 0px 15px;
	}
</style>
<link rel="stylesheet" type="text/css" href="./jquery/jquery.dataTables.css">
<link rel="stylesheet" href="jquery/themes/default/style.min.css" />
<link rel="shortcut icon" href="./images/favicon.ico"></head>
<body>

<script src="./jquery/jquery.2.min.js"></script>
<!-- Grid init -->
<script type="text/javascript" language="javascript" src="./jquery/jquery.dataTables.js"></script>

<!-- Tree init -->
<script src="./jquery/jstree.min.js"></script>

<p><a href="index.php?id=1">Page 1</a>&nbsp;<a href="index.php?id=2">Page 2</a>&nbsp;<a href="index.php?id=3">Page 3</a></p>
<p><button id="toggler" onclick="toggleView()">Grid View</button></p>

<div id="treemain" class="dispwindow">
<div id="treeviewwidget" class="viewwidget">
<p><button onclick="$('.jstree').jstree('open_all');">Open All</button><button onclick="$('.jstree').jstree('close_all');">Close All</button></p>
<div id="treeview" class="viewwidget"></div>
</div></div>

<div id="gridmain" class="dispwindow">
<div id="gridviewwidget" class="viewwidget">
<p><button onclick="">Properties</button><button onclick="">Rooms</button><button onclick="">Sections</button><button onclick="">Items</button></p>
<div id="gridview">

<table id="grid-basic" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th data-column-id="id" data-type="numeric">ID</th>
            <th data-column-id="sender">Sender</th>
            <th data-column-id="received" data-order="desc">Received</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Adam</td>
            <td>Data 1</td>
        </tr>
		<tr>
            <td>2</td>
            <td>Rosemary</td>
            <td>Data 2</td>
        </tr>
		<tr>
            <td>1</td>
            <td>Lynne</td>
            <td>Data 3</td>
        </tr>
    </tbody>
</table>
</div></div></div>

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
					echo "\"./$json.json\""; 
			?>,	"dataType" : "json" // needed only if you do not supply JSON headers
			}
		}, "plugins" : ["contextmenu", "dnd"]
	});
});
</script>


</body></html>