<?PHP
	if (!mail("websitebryan@gmail.com", "test mailing", "testing message")){
		echo 'Cant send';	
	}
	echo 'done';
?>