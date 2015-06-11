<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<title>A-Z Upload File</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<script>
	function upload (f) {
		f.submit();
		window.close();
	}
	</script>
</head>
<body>
<div class="page_wrapper">
	<div class="pop-up_wrapper">
		<h1 id="pop-up_header">A-Z Photo Upload</h1>
		<img src="images/logo.png"
				srcset="images/logo.png 900w" sizes="30vw"> 
			<form class="photo_load" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" name="attach">
				<p class="pop-up_table">
					<label for="userfile">Select File</label>
					<input type="file" name="userfile"  size="40">
				</p>
	<?php
		include_once("../azconfig.php");

		// Variables that need to be passed in
		$id = 0;
		$parentType = 0;
		if (isset($_GET['ID'])) $id = $_GET['ID'];
		if (isset($_GET['parentType'])) $parentType = $_GET['parentType'];
	?>
				<input type="hidden" name="ID" value="<?=$id?>">
				<input type="hidden" name="parentType" value="<?=$parentType?>">

				<p class="pop-up_table">
					<label for="description">Description</label>
					<input type=text name="description">
				</p>

				<p class="centered_button">
				<button class="gridMainButton" type="button" onclick="document.forms['attach'].submit()" id="add_item_submit">Submit</button>
				<button class="gridMainButton" type="button" onclick="upload(this)"  >Close</button></p>

		</form>
		</div>   <!-- end of pop-up_wrapper -->
	</div>    <!-- end page_wrapper -->
	<?php
		$description = "";

		if(!isset($_FILES['userfile'])) { // check if a file was submitted
			echo '<p class="php_message">Please select a file to upload.</p>';
		} else if(!isset($_POST['ID'], $_POST['parentType'])) { // check if enough info was submitted
			echo "<p>Error, not enough information about file.</p>";
		} else {
			if (isset($_POST['ID'])) $id = $_POST['ID'];
			if (isset($_POST['parentType'])) $parentType = $_POST['parentType'];
			if (isset($_POST['description'])) $description = $_POST['description'];

			try {
				if ($id == 0 || $parentType == 0 ) {
					echo "<p class=\"php_message\">You must supply the ID and parentType of the file.</p>";
					exit;
				}
				upload($driver, $db, $server, $user, $pwd, $id, $parentType, $description);
				echo '<p class="php_message">Thank you for submitting</p>';
			} catch(Exception $e) {
				echo '<h4>' . $e->getMessage() . '</h4>';
			}
		}

		function upload($driver, $db, $server, $user, $pwd, $id, $parentType, $description) { // handle file upload and inserting into database
			if(is_uploaded_file($_FILES['userfile']['tmp_name']) && getimagesize($_FILES['userfile']['tmp_name']) != false) {
				//  get the image info
				$size = getimagesize($_FILES['userfile']['tmp_name']);

				// assign our variables
				$image_type   = $size['mime'];
				$imgfp        = fopen($_FILES['userfile']['tmp_name'], 'rb');
				$image_width  = $size[0];
				$image_height = $size[1];
				$image_size   = $size[3];
				$image_name   = $_FILES['userfile']['name'];
				$maxsize      = 99999999;

				// check the file is less than the maximum file size
				if($_FILES['userfile']['size'] < $maxsize) {
					$thumb_data = $_FILES['userfile']['tmp_name']; // create a second variable for the thumbnail
					$aspectRatio = (float)($size[0] / $size[1]); // get the aspect ratio (height / width)
					$thumb_height = 24; // height of the thumbnail (jstree limitation is 24x24 px)
					$thumb_width = $thumb_height * $aspectRatio; // the thumb width is the thumb height/aspectratio
					/*  get the image source */
					if (exif_imagetype ($thumb_data) == IMAGETYPE_JPEG) $src = ImageCreateFromjpeg($thumb_data);
					elseif (exif_imagetype ($thumb_data) == IMAGETYPE_GIF) $src = ImageCreateFromgif($thumb_data);
					elseif (exif_imagetype ($thumb_data) == IMAGETYPE_PNG) $src = ImageCreateFrompng($thumb_data);
					else { // check for video or other files we want to support
						echo "File type not supported yet.";
					}
					
					$destImage = ImageCreateTrueColor($thumb_width, $thumb_height); // create the destination image
					ImageCopyResampled($destImage, $src, 0,0,0,0, $thumb_width, $thumb_height, $size[0], $size[1]); // copy and resize the src image to the dest image

					ob_start(); // start output buffering
					
					if (exif_imagetype ($thumb_data) == IMAGETYPE_JPEG) imageJPEG($destImage); // export the image
					elseif (exif_imagetype ($thumb_data) == IMAGETYPE_GIF) imageGIF($destImage); // export the image
					elseif (exif_imagetype ($thumb_data) == IMAGETYPE_PNG) imagePNG($destImage); // export the image

					$image_thumb = ob_get_contents(); // stick the image content in a variable
					ob_end_clean(); // clean up a little

					$dbh = new PDO("$driver:host=$server;dbname=$db", $user, $pwd); // connect to db
					$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set the error mode

					/*** prepare the sql ***/
					$array = array(null, PDO::PARAM_LOB, PDO::PARAM_INT, PDO::PARAM_INT, PDO::PARAM_LOB, PDO::PARAM_INT, null, null);
					
					$dbh->beginTransaction();
					$stmt = $dbh->prepare("SELECT IFNULL(MAX(item), 0) + 1 AS item FROM attachment WHERE ID = ? AND parentType = ?");
					$stmt->bindParam(1, $id, PDO::PARAM_INT);
					$stmt->bindParam(2, $parentType, PDO::PARAM_INT);
					$stmt->execute();
					
					if ($row = $stmt->fetch()) {
						$item = $row["item"];
						$sql = "INSERT INTO attachment (ID, parentType, item, mimeType, attachment, height, width, thumbnail, thumbHeight, thumbWidth, name, description) VALUES (? ,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

						//echo $sql . "<br>$item<br>";
						$stmt = $dbh->prepare($sql);
						$stmt->bindParam(1, $id, PDO::PARAM_INT);
						$stmt->bindParam(2, $parentType, PDO::PARAM_INT);
						$stmt->bindParam(3, $item, PDO::PARAM_INT);
						$stmt->bindParam(4, $image_type, PDO::PARAM_STR); // mime type
						$stmt->bindParam(5, $imgfp, PDO::PARAM_LOB); // binary attachment
						$stmt->bindParam(6, $image_height, PDO::PARAM_INT);
						$stmt->bindParam(7, $image_width, PDO::PARAM_INT);
						$stmt->bindParam(8, $image_thumb, PDO::PARAM_LOB); // binary thumbnail, if available
						$stmt->bindParam(9, $thumb_height, PDO::PARAM_INT);
						$stmt->bindParam(10, $thumb_width, PDO::PARAM_INT);
						$stmt->bindParam(11, $image_name, PDO::PARAM_STR);
						$stmt->bindParam(12, $description, PDO::PARAM_STR);
						$stmt->execute();
						$dbh->commit();
					} else {
						$dbh->rollBack();
						echo "Something went wrong getting the item number.<pre>";
						print_r($dbh->errorInfo());
						echo "</pre>";				
						exit;
					}
				} else { // throw an exception is image is not of type
					throw new Exception("File Size Error.  Picture is too large.");
				}
			} else { // if the file is not less than the maximum allowed, print an error
				throw new Exception("No file uploaded.");
			}
		}
	?>
</body>
</html>