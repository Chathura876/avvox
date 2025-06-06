<?php require_once "common/header.php" ?>
<?php require_once "common/nav.php" ?>
<?php require_once "common/functions.php" ?>

<?php

if(isset($_FILES['fileToUpload'])){

//error_reporting(1);

	$target_dir = "uploads/productimages/";
	$thumb_dir = "uploads/productimages/thumbs/";
	$file_extension = pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION);
	$newfilename = $_POST['productid'].".".$file_extension;

	//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$target_file = $target_dir.$newfilename;
	$thumb_flie = $thumb_dir.$newfilename;
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	    if($check !== false) {
	        //echo "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        echo "File is not an image.";
	        $uploadOk = 0;
	    }
	}

	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 20000000) {
	    echo "Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 0;
	}


	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

	         //create a resized version of the image, put the same value in the second parameter so the original file will be overwritten.
	         convertImage($target_file, $target_file, 800, 800, 70);

	        //create a thumbnail of the image
	         convertImage($target_file, $thumb_flie, 100, 100, 70);

	    ?>

		    <div class='col-12' id='successmessage' style='display:none'><div class='alert alert-success' role='alert'>
		            <b>Imaged uploaded Successfully.</b>
		    </div></div>

		    <script type="text/javascript">
		    	$("#successmessage").show().delay(5000).fadeOut(2000);
		    </script>

	    <?php 
	    } else {
	        echo "Sorry, there was an error uploading your file.";
	    }
	}


}
else{
	echo "No input files";
}

?>


<?php require_once "common/footer.php" ?>