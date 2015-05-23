//$(function () {
//	$('#grid-basic').DataTable();
	// js tree jquery start
	$('#maintree').jstree({
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
//});