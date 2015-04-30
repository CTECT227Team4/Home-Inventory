<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>A-Z Home Inventory Demo</title><style>
	html { margin:0; padding:0; color: #387929; font-family: Futura,Trebuchet MS,Arial,sans-serif; font-size:62.5%; }
	body { 	background-image: url("./img/a-ztitle.png");
    background-color: #FAFCFB;
	max-width:800px; min-width:300px; margin:0 auto; padding:20px 10px; font-family: Futura,Trebuchet MS,Arial,sans-serif; font-size:14px; font-size:1.4em; }
	h1 { font-family: Futura,Trebuchet MS,Arial,sans-serif; font-size:1.8em; }
	.demo { 
	position: fixed;
	    top: 375px;
		left: 309px;
		overflow:auto;
		border:4px solid #90C32E;
		min-height:400px; 
		min-width:500px;}
</style><link rel="stylesheet" href="jquery/themes/default/style.min.css" /><link rel="shortcut icon" href="./img/favicon.ico"></head>
<body>
	<div id="maintree" class="demo"></div>
	<script src="./jquery/jquery.2.min.js"></script>
	<script src="./jquery/jstree.min.js"></script>
<script>
	// ajax demo
	$('#maintree').jstree({
		'core' : {
			'data' : {
				"url" : <?php
					$json = $_GET['id'];
					if ($json == null) $json = '1';
					echo "\"./$json.json\""; 
			?>,	"dataType" : "json" // needed only if you do not supply JSON headers
			}
		}
	});
</script></body></html>