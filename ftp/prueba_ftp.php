<?php 
/*
	$ftp_server 	=  '200.31.16.231';
	$ftp_user_name 	= 'gladysprueba';
	$ftp_user_pass 	= '2x1hbaB9';
	$ftp_port 		= '22';
	$conn_id = ssh2_connect($ftp_server, $ftp_port);
	
	echo "<pre>";
	print_r($conn_id);
	var_dump($conn_id);
	
	ssh2_auth_password($conn_id, $ftp_user_name, $ftp_user_pass);
	
	$sftp = ssh2_sftp($conn_id);
	var_dump($sftp);
	$statinfo = ssh2_sftp_stat($sftp, '/efectividad/gestiones2012-05-08.gpg');
 
 echo "<pre>";
 print_r($statinfo);


	//ssh2_scp_send($conn_id, '/bd/tuya/tiemposlogueoc20120822.pgp', '/efectividad/tiemposlogueoc20120822.pgp', 0777);

	
	
	$resFile = fopen("ssh2.sftp://$sftp/efectividad/tiemposlogueoc20120822.pgp", 'w');
	var_dump($resFile);

	$datos = file_get_contents('/bd/tuya/tiemposlogueoc20120822.pgp');

	fwrite($resFile, $datos);
	fclose($resFile);

*/

require_once('ConexionSFTP.class.php');

$ftp_server 	=  '200.31.16.231';
$ftp_user_name 	= 'gladysprueba';
$ftp_user_pass 	= '2x1hbaB9';
$ftp_port 		= '22';


$sftp = new ConexionSFTP($ftp_server, $ftp_port);
$sftp->login($ftp_user_name, $ftp_user_pass);
$sftp->uploadFile('/bd/tuya/tiemposlogueoc20120822.pgp', '/efectividad/tiemposlogueoc20120822.pgp');

	?>
