<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head><title>Storing Images in DB</title></head><body>
<h2>Basic upload of image to a database</h2>
<p><a href="view.php">View Thumbnails</a></p>
<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">Select Image File:
<input type="file" name="userfile"  size="40">
<input type="hidden" name="MAX_FILE_SIZE" value="10000000">
<select name="image_ctgy">
<option value="animals">Animals</option>
<option value="vegetables">Vegetables</option>
<option value="minerals">Minerals</option>
</select><br /><input type="submit" value="submit"></form>
<?php
include_once("../azconfig.php");

if(!isset($_FILES['userfile'], $_POST['image_ctgy'])) { // check if a file was submitted
	echo '<p>Please select a file</p>';
} else {
	try {
		upload($user, $pwd);
		echo '<p>Thank you for submitting</p>';
	} catch(Exception $e) {
		echo '<h4>' . $e->getMessage() . '</h4>';
	}
}

function upload($user, $pwd) { // handle file upload and inserting into database
	if(is_uploaded_file($_FILES['userfile']['tmp_name']) && getimagesize($_FILES['userfile']['tmp_name']) != false) {
		/*** an array of allowed categories ***/
		$cat_array = array("animals", "vegetables", "minerals");
		if(filter_has_var(INPUT_POST, "notset") !== false || in_array($_POST['image_ctgy'], $cat_array) !== false) {
			$image_ctgy = filter_input(INPUT_POST, "image_ctgy", FILTER_SANITIZE_STRING);
		} else {
			throw new Exception("Invalid Category");
		}
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

		/*  check the file is less than the maximum file size */
		if($_FILES['userfile']['size'] < $maxsize ) {
			$thumb_data = $_FILES['userfile']['tmp_name']; // create a second variable for the thumbnail
			$aspectRatio=(float)($size[0] / $size[1]); // get the aspect ratio (height / width)
			$thumb_height = 100; // height of the thumbnail
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
			$dbh = new PDO("mysql:host=localhost;dbname=testblob", $user, $pwd); // connect to db
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set the error mode

			/*** prepare the sql ***/
			$array = array(null, PDO::PARAM_LOB, PDO::PARAM_INT, PDO::PARAM_INT, PDO::PARAM_LOB, PDO::PARAM_INT, null, null);
			print "<pre>";
			print_r($array);
			print "</pre>";


			$ID = 1;
			$parentType = 4;
			$description = "Test description";
			
			
			
			//$dbh->beginTransaction();
			$item = 1;
			

			//$stmt = $dbh->prepare("INSERT INTO testblob (image_type ,image, image_height, image_width, image_thumb, thumb_height, thumb_width, image_ctgy, image_name) VALUES (? ,?, ?, ?, ?, ?, ?, ?, ?)");
			$sql = "INSERT INTO attachment (ID, parentType, item, image_type, attachment, height, width, thumbnail, thumbHeight, thumbWidth, name, description) VALUES (? ,?, ?, ?, ?, ?, ?, ?, ?)";
		
			exit;

			//$stmt = $dbh->prepare($sql);
			$stmt->bindParam(1, $ID, PDO::PARAM_INT);
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

			//$stmt->execute();
			//$dbh->commit();
			//dbh->rollBack();
		} else { // throw an exception is image is not of type
			throw new Exception("File Size Error.  Picture is too large.");
		}
	} else { // if the file is not less than the maximum allowed, print an error
		throw new Exception("No file uploaded.");
	}
}
?></body></html>