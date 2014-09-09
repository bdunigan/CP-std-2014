<?PHP
	// general settings
	define('URL', '');
	define('IMAGESPATH', 'images');
	define('INCLUDESPATH', 'includes');
	define('UPLOADSPATH', 'uploads');
	define('MINDPI', 72);
	define('RECOMMENDEDDPI', 300);

	require_once(INCLUDESPATH.'/functions.php');
	
	// error messages
	$errs = '';
	
	// list of frame sizes ---- This is where you input the name of the save the date
	$frame_sizes = array(
		'4.25x5.75'	=>	'Single Photo Portrait;',
		'5.75x4.25'	=>	'Ornate Photo Landscape;'
	);
	
	// default values
	$default = array( 
		'top'			=>	0,
		'margintop'		=>	0,
		'left'			=>	0,
		'marginleft'	=>	0,
		'margin'		=>	0,
		'MatchProof'    =>  0,
		'FrameSize'		=>	'4.25x5.75',
		'PhotoZoom'		=>	50,
		'OrderNumber'	=>	'',
		'FirstName'		=>	'',
		'LastName'		=>	'',
		'Email'			=>	''
	);

	// CP Variables -----------------------------------------
    // This is where you put the name of the correct folder with the files and images
	$images_folder = '/frame05/web/';
	$printimages_folder = 'images/frame05/print/';

	// checking user input
	foreach ($default as $k=>$v){
		if (!isset($_POST[$k])) {
			if (isset($_SESSION[$k])) $_POST[$k] = $_SESSION[$k];
			else $_POST[$k] = $v;
		}
		else {
			$_SESSION[$k] = $_POST[$k];
		}
		$_POST[$k] = trim(strip_tags($_POST[$k]));
	}
	// making sure the frame size is valid
	$_POST['FrameSize'] = strtolower($_POST['FrameSize']);
	if (!isset($frame_sizes[$_POST['FrameSize']])) $_POST['FrameSize'] = $default['FrameSize'];
	
	// making sure the image position are valid numbers
	$_POST['top'] = floatval($_POST['top']);
	$_POST['left'] = floatval($_POST['left']);
	$_POST['margintop'] = floatval($_POST['margintop']);
	$_POST['marginleft'] = floatval($_POST['marginleft']);
	$_POST['margin'] = floatval($_POST['margin']);
	$_POST['PhotoZoom'] = intval($_POST['PhotoZoom']);
	
	// saving the current image in a session
	// in case the user leaves and comes back to the page
	if (!isset($_SESSION['current_image'])) $_SESSION['current_image'] = '';
	if ((isset($_POST['current_image'])) && (is_file(UPLOADSPATH.'/original/'.$_POST['current_image']))){
		$_SESSION['current_image'] = $_POST['current_image'];
	}
	
	// default form action and image source
	$user_photo = URL.IMAGESPATH.'/nophoto.jpg';
	
	// show warning and recommend size for the frame
	$show_dpi_warning = false;
	$recommended = '';
	$image_width = 0;
	
	// if the user is using a session image, use it by default
	if ($_SESSION['current_image'] != ''){
		// getting the photo size based on the largest frame (5x7)
		$user_photo = getImageSource($_SESSION['current_image'], 288, 397);
		list($image_width, $image_height) = getimagesize(UPLOADSPATH.'/original/'.$_SESSION['current_image']);
		
		$size_key = 0;
		$div_by = $image_width;
		if ($image_height < $image_width){
			$size_key = 1;
			$div_by = $image_height;
		}
		
		$cur_size = explode('x', $_POST['FrameSize']);
		$dpi = $div_by / $cur_size[$size_key];
		
		// if dpi is too low
		if ($dpi < MINDPI) {
			$show_dpi_warning = true;
		}
		// finding the recommended frame size based on dpi
		foreach ($frame_sizes as $k=>$v){
			$cur_size = explode('x', $k);
			$dpi = $div_by / $cur_size[$size_key];
			if ($dpi >= RECOMMENDEDDPI){
				$recommended = $k;
				break;	
			}
		}
	}
	
	// checking if the user submitted a from
	if (isset($_POST['form_action'])){
		// if we are processing the image for user resize
		if ($_FILES['UserPhoto']['name'] != ''){
			// checking if the image is a valid file
			$json = uploadImage($_FILES['UserPhoto']);
			
			// setting the web image size
			if (isset($json['file'])){
				// caching the user photo
				$_SESSION['current_image'] = $json['current_image'] = $json['file'];
				
				// checking the image size comparing to the frame resolution
				list($image_width, $image_height) = getimagesize(UPLOADSPATH.'/original/'.$json['file']);
				
				$size_key = 0;
				$div_by = $image_width;
				if ($image_height < $image_width){
					$size_key = 1;
					$div_by = $image_height;
				}
				
				$cur_size = explode('x', $_POST['FrameSize']);
				$dpi = $div_by / $cur_size[$size_key];
				
				// if dpi is too low
				if ($dpi < MINDPI) {
					$show_dpi_warning = true;
					$json['dpi_warning'] = true;
				}
				
				$json['image_width'] = $image_width;
				$json['image_height'] = $image_height;
					
				// finding the recommended frame size based on dpi
				foreach ($frame_sizes as $k=>$v){
					$cur_size = explode('x', $k);
					$dpi = $div_by / $cur_size[$size_key];
					if ($dpi >= RECOMMENDEDDPI){
						$recommended = $k;
						break;	
					}
				}
				if ($recommended != ''){
					$json['recommended'] = $recommended;
				}
				
				// resizing the image for the user interface
				// getting the photo size based on the largest frame (5x7)
				$json['file'] = getImageSource($json['file'], 288, 397);
				
			}
			
			// printing the output, either via ajax or normal output
			if (isset($_POST['Ajax'])) {
				echo json_encode($json);
				die();	
			}
			else {
				if (isset($json['file'])){
					$user_photo = $json['file'];
				}
				else {
					$errs .= $json['error'];
				}
			}
		}
		// user is submitting the form for processing
		else {
			$valid = true;
			$err_arr = array();
			// checking the frame size
			if ($_POST['FrameSize'] == ''){
				$err_arr[] = " - Please select a frame size";
				$valid = false;
			}
			
	//Bryan - Box checked check
			if ($_POST['matchproof'] == 0){

				// checking if the user uploaded a photo
				if ($user_photo == URL.IMAGESPATH.'/nophoto.jpg'){
					$err_arr[] = " - Please select a photo";
					$valid = false;
				}
				// checking the user zoom level
				if ($_POST['PhotoZoom'] == ''){
					$err_arr[] = " - Please enter the zoom level";
					$valid = false;
				}
				else {
					// checking if the zoom level is valid
					$_POST['PhotoZoom'] = intval($_POST['PhotoZoom']);
					if (($_POST['PhotoZoom'] < 0) || ($_POST['PhotoZoom'] > 150)){
						$err_arr[] = " - You can only zoom the photo between 0 to 150%";
						$valid = false;
					}

				}
			} else {
				// checking the order number
				if ($_POST['OrderNumber'] == ''){
					$err_arr[] = " - Please enter an order number";
					$valid = false;	
				}

				//remove the session image
				$_SESSION['current_image'] = '';
			}
			





			// checking the first name
			if ($_POST['FirstName'] == ''){
				$err_arr[] = " - Please enter your first name";
				$valid = false;
			}
			// checking the last name
			if ($_POST['LastName'] == ''){
				$err_arr[] = " - Please enter your last name";
				$valid = false;
			}
			// checking the email
			if (!filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)){
				$err_arr[] = " - Please enter a valid email";
				$valid = false;
			}
			
			// invalid submission, alert errors
			if (!$valid){
				alert("vav 2");
				$errs .= "The following fields are missing or invalid
".implode("\n", $err_arr);
			}
			
			// valid submission, generate PDF file
			else {
				include("process.php");
			}

		//--------send buy first

	//echo '<script type="text/javascript">', 
	// 'buyFunction();', 
	// '</script>'; 
		}
	}
	
	// calculating the zoom padding for the image
	$zm_pt = 0;
	$zm_pl = 0;
	if ($_POST['FrameSize'] != ''){
		// getting the size
		$size = explode('x', $_POST['FrameSize']);
		
		$zm_pt = (floatval($size[0]) * 72) * ($_POST['margin'] / 100);
		$zm_pl = (floatval($size[1]) * 72) * ($_POST['margin'] / 100);
	}
	
?>
<?php include 'newincludes/meta.php';?>
<?php include 'newincludes/top.php';?>
<div style="display:none";>
<?php include 'newincludes/size-select.php';?>
	</div>
<?php include 'newincludes/mid.php';?>


<!--////////////////////////////////////////////////New Save the Date Dropdowns////////////////////////////////////////-->

				<?php include 'newincludes/select-name1.php';?>
				<?php include 'newincludes/select-name2.php';?>
				<?php include 'newincludes/select-date.php';?>
				<!--<?php include 'newincludes/select-location.php';?>-->
				<!--<?php include 'newincludes/select-colors.php';?>-->
				<!--<?php include 'newincludes/select-location.php';?>-->
				<!--<<?php include 'newincludes/select-stripe-color.php';?>-->





<!--END New Dropdowns///////////////////-->


<?php include 'newincludes/bottom.php';?>