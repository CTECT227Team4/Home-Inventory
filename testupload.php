<html>
<h2>Editing an Item</h2>
ID<br>
<input type="text" id="id"><br>
parentType<br>
<select id="parentType"><option value="1">Property<option value="2">Room<option value="3">Section<option value="4">Item</select><br><br>
<button onclick="upload()">Upload a file</button>

<script>
function upload () {
	var parentType = document.getElementById("parentType").selectedIndex;
	parentType++;
	popupWindow = window.open('upload.php?ID=' + document.getElementById("id").value + '&parentType=' + parentType, 'Upload Some Stuff', 'width=700,height=350');
	popupWindow.focus();
}
</script>

</html>