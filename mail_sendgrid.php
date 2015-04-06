<?php
	//require("/var/www/html/padminfo2/librerias/email/Sendgrid.class.php");
  require("Sendgrid.class.php");
	
	$sendgrid = new Sendgrid();
	
	list($respons, $msg) = $sendgrid->sendRawEmail("jbermudez@solati.com.co", "jrodriguez@solati.com.co", " nuevo mensaje de prueba " , "de pruebas Subject");	
	if($response === true)
		echo $msg;
	else print_r($msg);
  /*
  $url = 'http://sendgrid.com/';
  $user = 'solatipruebas';
  $pass = 'Adm1nfo_13';

  $params = array(
      'api_user'  => $user,
      'api_key'   => $pass,
      'to'        => 'importador@solati.com.co',
      'subject'   => 'testing from curl',
      'text'      => 'testing body',
      'from'      => 'jrodriguez@sendgrid.com',
    );


  $request =  $url.'api/mail.send.json';

  // Generate curl request
  $session = curl_init($request);
  // Tell curl to use HTTP POST
  curl_setopt ($session, CURLOPT_POST, true);
  // Tell curl that this is the body of the POST
  curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
  // Tell curl not to return headers, but do return the response
  curl_setopt($session, CURLOPT_HEADER, false);
  curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

  // obtain response
  $response = curl_exec($session);
  
  $http_code = curl_getinfo($session, CURLINFO_HTTP_CODE);
  
  curl_close($session);

  // print everything out
  print_r($response);
  
  print_r($http_code);
*/
