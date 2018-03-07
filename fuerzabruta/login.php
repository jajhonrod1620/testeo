<?php


if($_POST)
{
	$password = isset( $_POST['password'] ) ? $_POST['password'] : '';

	if($password == '8')
	{
		http_response_code(200);
	}else
	{
		http_response_code(404);
	}
	
}