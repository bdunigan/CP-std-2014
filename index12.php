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
		'4.25x5.75'	=>	'A Joyful Joining Portrait;',
		'5.75x4.25'	=>	'A Joyful Joining Landscape;'
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

	$images_folder = '/frame12/web/';
	$printimages_folder = 'images/frame12/print/';



    // End CP Variables
	$alt1 = 'images' . $images_folder . '4.25x5.75.png';
	$alt2 = 'images' . $images_folder . '5.75x4.25.png';
	$alt1d = 'images' . $images_folder . '4.25x5.75d.png';
	$alt2d = 'images' . $images_folder . '5.75x4.25d.png';
	$alt3 = 'images' . $images_folder . '4.25x5.75c.png';
	$alt3d = 'images' . $images_folder . '4.25x5.75dc.png';
	$alt4 = 'images' . $images_folder . '5.75x4.25c.png';
	$alt4d = 'images' . $images_folder . '5.75x4.25dc.png';

	$example1 = 'images' . $images_folder . 'ex1.jpg';
	$example2 = 'images' . $images_folder . 'ex2.jpg';


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

	
	// default form action and image source
	$user_photo = URL.IMAGESPATH. $images_folder .'/nophoto.jpg';
	
	// show warning and recommend size for the frame
	$show_dpi_warning = false;
	$recommended = '';
	$image_width = 0;

	
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
				if ($user_photo == URL.IMAGESPATH.'nophoto.jpg'){
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





<!--////////////// Choose If both layouts///////-->
<div class="hide" default="5.75x4.25" id="select-layout">
	<label for="pfapp_frame_size_select">Card Layout: <span id="pfapp_recommended" class="small"></span></label>
	<?php include 'newincludes/size-select.php';?>
	</div>



<!--////////////// Choose Selected Example///////-->
<div class="field" id="select-example">
	<label for="select-example" >Example Shown: <br/></label>

	<input type="radio" name="example" valone="<?php echo $alt1;?>" valtwo="<?php echo $alt2;?>" valthree="<?php echo $alt3;?>" valfour="<?php echo $alt4;?>" id="example-light"  >Light Example<br>
	<input type="radio"name="example" valone="<?php echo $alt1d;?>" valtwo="<?php echo $alt2d;?>" valthree="<?php echo $alt3d;?>" valfour="<?php echo $alt4d;?>" id="example-dark" checked="checked" >Dark Example
	<?php include 'newincludes/example-alert.php';?>

</div>

<?php include 'newincludes/mid.php';?>
<div class=""><?php include 'newincludes/select-card-type.php';?></div>
<div class=""><?php include 'newincludes/select-paper.php';?></div>				
<div class="hide" id="env-select"><?php include 'newincludes/select-envelope.php';?></div>				
<div class=""><?php include 'newincludes/select-name1.php';?></div>
<div class=""><?php include 'newincludes/select-name2.php';?></div>
<div class=""><?php include 'newincludes/select-date.php';?></div>

<!--////////////////////////////////////////////////New Save the Date Dropdowns////////////////////////////////////////-->

<div class="hide"><?php include 'newincludes/select-location.php';?></div>


	<div class="field"><!--COLOR 1-->
		<input type="hidden" name="color1-name" id="color1-name" value="Select Name Color">
		<label>Select Name Color:  </label>
		<select  id="color1" name="color1" >
			<?php include 'newincludes/options-all.php';?>
		</select>
	</div>


	<div class="field"><!--COLOR 2-->
		<input type="hidden" name="color2-name" id="color2-name" value="Select Banner/Accent Color">
		<label>Select Banner/Accent Color:  </label>
		<select  id="color2" name="color2" >
			<?php include 'newincludes/options-all.php';?>
		</select>
	</div>


	<div class="field"><!--COLOR 3-->
		<input type="hidden" name="color3-name" id="color3-name" value="Select Text Color">
		<label>Select Text Color:  </label>
		<select  id="color3" name="color3" >
			<?php include 'newincludes/options-txt2.php';?>
		</select>
	</div>




<!--END New Dropdowns///////////////////-->



<?php include 'newincludes/bottom.php';?>


