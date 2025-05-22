<?php
function convertImage($originalImage, $outputImage, $width = 250, $height = 250, $quality = 75){ 
	ini_set ('gd.jpeg_ignore_warning', 1);//ignore warnings with some source jpgs with errors but resizeable
	// Set a maximum height and width
	//$width = 250;
	//$height = 250;
	// Get new dimensions
	list($width_orig, $height_orig) = getimagesize($originalImage);
	$ratio_orig = $width_orig/$height_orig;

	if ($width/$height > $ratio_orig) {
	   $width = $height*$ratio_orig;
	} else {
	   $height = $width/$ratio_orig;
	}

	$imagetype = exif_imagetype($originalImage);
	
	if($imagetype == 1){//This is a GIF image
		$imageTmp=imagecreatefromgif($originalImage);
	}
	else if($imagetype == 2){//This is a JPEG image
		$imageTmp=imagecreatefromjpeg($originalImage);
	}
	else if($imagetype == 3){//This is a PNG image
		$imageTmp=imagecreatefrompng($originalImage);
	}
	else if($imagetype == 6){//This is a BMP image
		$imageTmp=imagecreatefrombmp($originalImage);
	}
	else{
		return 0;
	}
	
	// Resample
	$image_p = imagecreatetruecolor($width, $height);
	//$image = imagecreatefromjpeg($filename);
	//imagecopyresampled($image_p, $imageTmp, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	imagecopyresampled($image_p, $imageTmp, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

    // quality is a value from 0 (worst) to 100 (best)
    imagejpeg($image_p, $outputImage, $quality);
    imagedestroy($imageTmp);

    return 1;
}

function convert_crop_Image($originalImage, $outputImage, $quality=75, $resized_size=250){
    //in addition to resize this function will do a rectangular middle crop
	//Note: $resized_size Since we create the square image both height and width are the same
	ini_set ('gd.jpeg_ignore_warning', 1);//ignore warnings with some source jpgs with errors but resizeable 
	$src_x = 0;
	$src_y = 0;
	// Get source dimensions
	list($width_orig, $height_orig) = getimagesize($originalImage);
	
	if($width_orig >= $height_orig){
		$new_source_dim = $height_orig;
		$src_x = ($width_orig - $height_orig)/2;
	}
	else{
		$new_source_dim = $width_orig;
		$src_y = ($height_orig - $width_orig)/2;
	}
	
	$ratio_orig = $width_orig/$height_orig;

	$imagetype = exif_imagetype($originalImage);
	
	if($imagetype == 1){//This is a GIF image
		$imageTmp=imagecreatefromgif($originalImage);
	}
	else if($imagetype == 2){//This is a JPEG image
		$imageTmp=imagecreatefromjpeg($originalImage);
	}
	else if($imagetype == 3){//This is a PNG image
		$imageTmp=imagecreatefrompng($originalImage);
	}
	else if($imagetype == 6){//This is a BMP image
		$imageTmp=imagecreatefrombmp($originalImage);
	}
	else{
		return 0;
	}

	// Resample
	$image_p = imagecreatetruecolor($resized_size, $resized_size);
	imagecopyresampled($image_p, $imageTmp, 0, 0, $src_x, $src_y, $resized_size, $resized_size, $new_source_dim, $new_source_dim);
    // quality is a value from 0 (worst) to 100 (best)
    imagejpeg($image_p, $outputImage, $quality);
    imagedestroy($imageTmp);

    return 1;
}

function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}

?>