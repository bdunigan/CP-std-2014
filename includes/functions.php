<?PHP
// starting a session to keep user info saved while they are working on the form
session_start();
// making sure the session is from the same IP that started it for security
if (!isset($_SESSION['session_ip'])) $_SESSION['session_ip'] = $_SERVER['REMOTE_ADDR'];
if ($_SESSION['session_ip'] != $_SERVER['REMOTE_ADDR']){
	// invalid IP address, reset the session
	unset($_SESSION);
	session_destroy();
	// restarting the session
	session_start();
}

// deleting old uploaded files
delete_old_files();

//bryan--unlimited memory

ini_set('memory_limit', '-1');


// general output functions
function printFrameSizesOptions(){
	global $frame_sizes;
	foreach ($frame_sizes as $k=>$v){
		echo '<option value="'.$k.'"';
		//if ($_POST['FrameSize'] == $k) echo 'selected';
		echo '>'.$v.'</option>';
	}
}

// printing out an input field value with html entities converted
function printValue($field){
	if (isset($_POST[$field])) echo trim(htmlentities($_POST[$field], ENT_COMPAT | ENT_HTML401, 'UTF-8'));
}

// function to upload files
function uploadImage($file){
	$path = UPLOADSPATH.'/original/';
	if ($file['name'] != ""){
		$ext = strtolower(substr($file['name'], strlen($file['name']) - 3));
		$valid_format = array("jpg", "gif", "png");
		
		if(!in_array($ext, $valid_format)){
			return array(
				'error' => 'Invalid file, please select a different file'
			);
		}
		
		$FN = time() . "_" . rand(0, 999) . "." . $ext;
				
		$uploaddir = $path . $FN;
		if (!move_uploaded_file($file['tmp_name'], $uploaddir)){
			return array(
				'error' => 'Could not upload file, an error has occured'
			);
		}
		
		return array(
			'file'	=>	$FN,
		);
	}
	return array(
		'error' => 'Please select a file'
	);
}

// function to get the image name based on the size
function getImageName($src, $w, $h){
	if ($src == "") $src = "noimage.jpg";
	$ext = strtolower(substr($src, strlen($src) - 3));
	$src = str_replace('.'.$ext, '', $src)."_".$w."x".$h;
	return $src.'.'.$ext;
}

// function to get a web sized image from the main uploaded file
function getImageSource($src, $w, $h){
	$new_src = getImageName($src, $w, $h);
	
	if (!is_file(UPLOADSPATH.'/web/'.$new_src)){
		resizeImage($src, $w, $h);
	}
	
	return URL.UPLOADSPATH.'/web/'.$new_src;
}

// function to resize image for a web friendly size
function resizeImage($FileName, $width, $height){
	if ($FileName != ""){
		// Get new dimensions
		list($width_orig, $height_orig) = getimagesize(UPLOADSPATH.'/original/'.$FileName);
		$ratio_orig = $width_orig/$height_orig;
		
		$Image_ext = strtolower(substr($FileName, strlen($FileName) - 3));
		$new_file = getImageName($FileName, $width, $height);
		
		// ratio correction based on width comparing to height
		if ($width_orig < $height_orig){
			$height = round($width/$ratio_orig);
		}
		else {
			$width = round($height*$ratio_orig);	
		}
		
		/* imagick is not insalled, use GD instead
		// new Imagick style
		$img = new Imagick(UPLOADSPATH.'/original/'.$FileName);
		
		$img->cropThumbnailImage($width, $height);
		$img->writeImage(UPLOADSPATH.'/web/'.$new_file);
		*/
		
		// GD image resize
		$img = imagecreatetruecolor($width, $height);
		$file_path = UPLOADSPATH.'/original/'.$FileName;
		$new_file_path = UPLOADSPATH.'/web/'.$new_file;
		if ($Image_ext == "jpg"){
			$o_img = imagecreatefromjpeg($file_path);
		}
		else if ($Image_ext == "png"){
			$o_img = imagecreatefrompng($file_path);
		}
		else {
			$o_img = imagecreatefromgif($file_path); 
		}
		
		// resampling the image
		imagecopyresampled($img, $o_img, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		
		// Output
		if ($Image_ext == "jpg"){
			imagejpeg($img, $new_file_path, 60);
		}
		else if ($Image_ext == "png"){
			imagepng($img, $new_file_path, 4);
		}
		else {
			imagegif($img, $new_file_path); 
		}
		imagedestroy($o_img);
		imagedestroy($img);
	}
}

// function to delete a file or a session file
function deleteFile($file){	
	if (is_file($file)) unlink ($file);
}

// function to delete old files
function delete_old_files($dir=UPLOADSPATH){
	if (substr($dir, strlen($dir) - 1) != '/') $dir .= '/';
	$arr = scandir($dir);
	$tm = strtotime('-1 days');
	if (!empty($arr)){
		foreach ($arr as $obj){
			if (($obj != '.') && ($obj != '..')) {
				if (is_dir($dir.$obj)){
					delete_old_files($dir.$obj);
				}
				else {
					if (filemtime($dir.$obj) < $tm){
						deleteFile($dir.$obj);
					}
				}
			}
		}
	}
}
