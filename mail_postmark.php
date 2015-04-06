<?php 
	require("/home/jjhon/solati/padminfo2/librerias/email/Postmark.class.php");
	
	$postmark = new Postmark();
	
	$result = $postmark->sendRawEmail("jrodriguez@solati.com.co", "jrodriguez@solati.com.co", " nuevo mensaje de prueba " , "de pruebas Subject");	
	if($result === true)
		echo "Message sent";
	else echo $result;
  
  print_r($result); 
