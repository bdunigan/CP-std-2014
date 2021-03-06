<?PHP
	require_once(INCLUDESPATH.'/fpdf/fpdf.php');
	require_once(INCLUDESPATH.'/phpmailer/class.phpmailer.php');
	
//bryan if 
if ($_SESSION['current_image'] != '') {
		# code...	
	// PDF file size based on frame
	// to change the size, set the width and height and orientation.
	// size is in inches, orientation P is for portrait L is for landscape
			$pdf_size = array(
				'4.25x5.75'	=>	array('width' => 4.25, 'height' => 5.75, 'orientation' => 'P'),
				'5.75x4.25'	=>	array('width' => 5.75, 'height' => 4.25, 'orientation' => 'L')
			);
			
			// the paper size based on the frame size
			$paper_w = $pdf_size[$_POST['FrameSize']]['width'];
			$paper_h = $pdf_size[$_POST['FrameSize']]['height'];
			
			$pdf = new FPDF($pdf_size[$_POST['FrameSize']]['orientation'], 'in', array($paper_w, $paper_h));
			$pdf->SetAutoPageBreak(false);
			$pdf->SetCompression(false);
			$pdf->SetMargins(0, 0, 0);
			$pdf->AddPage();
			
			// calculate the top left corner of the frame and photo
			$arr = explode('x', $_POST['FrameSize']);
			$fw = floatval($arr[0]);
			$fh = floatval($arr[1]);
			
			$fml = ($paper_w - $fw) / 2;
			$fmt = ($paper_h - $fh) / 2;
			
			// calculating the zoom margins for the photo
			$zml = $fw * ($_POST['margin'] / 100);
			$zmt = $fh * ($_POST['margin'] / 100);
			
			// checking how far did the user move the photo
			// since the user is workin on a 72 DPI screen,
			// the pixels are converted to inches using 72 DPI
			$top = ($_POST['top'] + $_POST['margintop']) / 72;
			$left = ($_POST['left'] + $_POST['marginleft']) / 72;
			
			// photo margins
			$pml = $fml + $zml + $left;
			$pmt = $fmt + $zmt + $top;
			
			// the photo source file
			$src = UPLOADSPATH.'/original/'.$_SESSION['current_image'];
			
			// the photo size
			list($ow, $oh) = getimagesize($src);
			// converting to inch
			$ow = $ow / 72;
			$oh = $oh / 72;
			
			// resizing the height and width to match the frame based on the picture layout
			if ($ow <= $oh){
				$pw = $fw;
				$ph = $oh * ($pw / $ow);
			}
			else {
				$ph = $fh;
				$pw = $ow * ($ph / $oh);
			}
			
			// setting the zoom size based on the frame size
			$pw = $pw * ($_POST['PhotoZoom'] / 50);
			$ph = $ph * ($_POST['PhotoZoom'] / 50);
			
			
			// inserting the photo
			$pdf->Image($src, $pml, $pmt, $pw, $ph);
			
			// since the user might drag the photo outside the
			// frame edges, we need to cover up the external areas
			// with white squares
			// setting the fill color
			$pdf->SetFillColor(255, 255, 255);
			if ($fmt > 0){
				$pdf->Rect(0, 0, $paper_w, $fmt, 'F');
				$pdf->Rect(0, ($fh+$fmt), $paper_w, $fmt, 'F');
			}
			if ($fml > 0){
				$pdf->Rect(0, 0, $fml, $paper_h, 'F');
				$pdf->Rect(($fw+$fml), 0, $fml, $paper_h, 'F');
			}
			
			// finally inserting the frame over the photo
			$src = $printimages_folder.$_POST['FrameSize'].'.png';
			$pdf->Image($src, $fml, $fmt, $fw, $fh);
			
			$file = UPLOADSPATH.'/autogenerated/'.uniqid(rand()).'.pdf';
			$pdf->Output($file, 'F');
}	
	// starting the mailing process
	$mail = new PHPMailer();
	
	/* starting SMTP setup */
	$mail->IsSMTP();							// Set mailer to use SMTP
	$mail->Host = 'smtp.cardsandpockets.com:587';			// Specify main and backup server
												// for a special port, use :PORTNUMBER e.g. mail.server.com:2525
	$mail->SMTPAuth = true;						// Enable SMTP authentication
	$mail->Username = 'bryan@cardsandpockets.com';				// SMTP username
	$mail->Password = 'Pockets1';				// SMTP password
	$mail->From = 'bryan@cardsandpockets.com';		// from email
	//$mail->SMTPSecure = 'tls';				// Enable encryption, 'ssl' also accepted
	/* end SMTP setup */

	$mail->FromName = 'Save The Date Wizard';	// from name
	$mail->AddAddress('bryan@cardsandpockets.com', 'CP Photos');  // Add a recipient
	$mail->AddAttachment($file);    // Adding the pdf file
	
	$mail->IsHTML(true);
if ($_SESSION['current_image'] != '') {	
	$mail->Subject = 'Full Order -  '.$_POST['FirstName'].' '.$_POST['LastName'];
} if ($_POST['prooforder'] != '') {	
	$mail->Subject = 'Proof -  '.$_POST['FirstName'].' '.$_POST['LastName'];
}
else{
	$mail->Subject = 'Full Order (No Proof) -  '.$_POST['FirstName'].' '.$_POST['LastName'];
}
	$mail->Body = '<div style="font-family:arial; font-size:9pt;">Generated on '.date('r').'. 
	<table style="font-family:arial; font-size:9pt;">
		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
		<tr><td>Layout:</td><td>'.$frame_sizes[$_POST['FrameSize']].'</td></tr>
		<tr><td>Quantity:</td><td>'.$_POST['qty'].'</td></tr>
		<tr><td>Paper Select:</td><td>'.$_POST['PaperSelect'].'</td></tr>
		<tr><td>Paper Select:</td><td>'.$_POST['select-card-type'].'</td></tr>
		<tr><td>Paper Select:</td><td>'.$_POST['select-envelope'].'</td></tr>
		<tr><td>Name 1:</td><td>'.$_POST['name1'].'</td></tr>
		<tr><td>Name 2:</td><td>'.$_POST['name2'].'</td></tr>
		<tr><td>Date:</td><td>'.$_POST['date'].'</td></tr>
		<tr><td>Location:</td><td>'.$_POST['location'].'</td></tr>
		<tr><td>'.$_POST['color1-name'].':</td><td>'.$_POST['color1'].'</td></tr>
		<tr><td>'.$_POST['color2-name'].':</td><td>'.$_POST['color2'].'</td></tr>
		<tr><td>'.$_POST['color3-name'].':</td><td>'.$_POST['color3'].'</td></tr>
		<tr><td>Order Number:</td><td>'.$_POST['OrderNumber'].'</td></tr>
		<tr><td>First Name:</td><td>'.$_POST['FirstName'].'</td></tr>
		<tr><td>Last Name:</td><td>'.$_POST['LastName'].'</td></tr>
		<tr><td>Email:</td><td>'.$_POST['Email'].'</td></tr>
	</table>
	</div>';
	$mail->AltBody = 'The following PDF file was generated on '.date('r').'. Below are the request details:
		- Frame Size:'.$frame_sizes[$_POST['FrameSize']].'
		- Quantity:</td><td>'.$_POST['qty'].'
		- Paper Select:</td><td>'.$_POST['PaperSelect'].'
		- Order Number:</td><td>'.$_POST['OrderNumber'].'
		- First Name:</td><td>'.$_POST['FirstName'].'
		- Last Name:</td><td>'.$_POST['LastName'].'
		- Email:</td><td>'.$_POST['Email'].'';
		
	if(!$mail->Send()) {
	   echo 'Message could not be sent.';
	   echo 'Mailer Error: ' . $mail->ErrorInfo;
	   exit;
	}
	
	header('location: thanks.php');
