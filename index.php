<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>A-Z Home Inventory Demo</title><style>
	html { margin:0; padding:0; color: #387929; font-family: Futura,Trebuchet MS,Arial,sans-serif; font-size:62.5%; }
	body { 	background-image: url("../images/a-ztitle.png");
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
<script src="./jquery/az.js"></script>
<!-- Grid init -->
<script type="text/javascript" language="javascript" src="./jquery/jquery.dataTables.js"></script>
<!-- Tree init -->
<script src="./jquery/jstree.min.js"></script>

<button>Test</button>
<p><a href="index.php?id=1">Page 1</a>&nbsp;<a href="index.php?id=2">Page 2</a>&nbsp;<a href="index.php?id=3">Page 3</a></p>
<p><button id="toggler" onclick="toggleView()">Grid View</button></p>

<div id="treemain" class="dispwindow">
<div id="treeviewwidget" class="viewwidget">
<p><button onclick="$('.jstree').jstree('open_all');">Open All</button><button onclick="$('.jstree').jstree('close_all');">Close All</button></p>

<div id="treeview"></div></div></div>
<div id="gridmain" class="dispwindow">
<div id="gridviewwidget" class="viewwidget">
<p><button onclick="gridHeader(1)">Properties</button><button onclick="gridHeader(2)">Rooms</button><button onclick="gridHeader(3)">Sections</button><button onclick="gridHeader(4)">Items</button></p>
<div id="gridview">

<table id="grid-basic" class="display" cellspacing="0" width="100%">
    <thead id="grid-headers">
        <tr>
            <th data-column-id="name" data-type="numeric">Name</th>
            <th data-column-id="address">Address</th>
            <th data-column-id="city" data-order="desc">City</th>
			<th data-column-id="state">State</th>
			<th data-column-id="zip">Zip</th>
        </tr>
    </thead>
</table>
</div></div></div>

<script>
$(function () {
	$('#grid-basic').DataTable({
        "ajax": 'grid1.json'
    });
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