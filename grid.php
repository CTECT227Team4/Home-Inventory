<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>A-Z Home Inventory Demo</title>
<link rel="stylesheet" href="./jquery/jquery.bootgrid.min.css" />
<link rel="shortcut icon" href="./img/favicon.ico"></head>
<body>

<script src="./jquery/jquery.2.min.js"></script>
<script src="./jquery/jquery.bootgrid.min.js"></script>
<script src="./jquery/jquery.bootgrid.fa.min.js"></script>
	
<table id="grid-basic" class="table table-condensed table-hover table-striped">
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
            <td>3</td>
            <td>Lynne</td>
            <td>Data 3</td>
        </tr>
		<tr>
            <td>4</td>
            <td>Bruce</td>
            <td>Data 4</td>
        </tr>
    </tbody>
</table>

<script>
	$("#grid-basic").bootgrid();

</script></body></html>