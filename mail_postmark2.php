<?php 
	require("Postmark.class.php");
	
	//$postmark = new Postmark("1d4bb7b9-aa89-4db9-af8d-8376f3ece688","jrodriguez@solati.com.co");
  $postmark = new Postmark("b41827bc-7e0f-413f-9bdd-695a23442c13","jrodriguez@solati.com.co");
	
	$result = $postmark->to("jrodriguez@solati.com.co")
		->subject("Email Subject")
		->plain_message("This is a plain text message.")		
		->send();
	
	if($result === true)
		echo "Message sent";
	else echo $result;
