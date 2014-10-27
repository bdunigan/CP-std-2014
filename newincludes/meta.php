<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Picture Frame</title>
 <script src="http://code.jquery.com/jquery-1.8.3.js"></script>

<!--adding cluetip-->
<link href="css/jquery.cluetip.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.cluetip.js" type="text/javascript" charset="utf-8"></script>


<link rel="stylesheet" type="text/css" href="css/pdff_style.css">
<script type="text/javascript" src="js/ng/1.2.2/ng_all.js"></script>
<script type="text/javascript" src="js/ng/1.2.2/components/slider.js"></script>

<!--adding fancybox-->
<link rel="stylesheet" type="text/css" href="http://cardsandpockets.dreamhosters.com/pfwizard/css/jquery.fancybox.css" media="screen" />
<script type="text/javascript" src="http://cardsandpockets.dreamhosters.com/pfwizard/js/jquery.fancybox.js"></script>


<script type="text/javascript">
// global variables
// recommended frame size
var recommended_frame = <?PHP echo json_encode($recommended); ?>;
// show dpi warning
var show_dpi_warning = <?PHP echo json_encode($show_dpi_warning); ?>;
// uploaded image size
var image_width = <?PHP echo json_encode($image_width); ?>;
var image_height = <?PHP echo json_encode($image_height); ?>;
// images path
var frame_images_path = <?PHP echo json_encode(IMAGESPATH.$images_folder); ?>; 
// minimum dpi
var MINDPI = <?PHP echo json_encode(MINDPI); ?>;
// recommended dpi
var RECOMMENDEDDPI = <?PHP echo json_encode(RECOMMENDEDDPI); ?>;
<?PHP
	// alerting error messages
	if ($errs != '') echo 'alert('.json_encode($errs).');';
?>

</script>
<script type="text/javascript" src="js/index.js"></script>