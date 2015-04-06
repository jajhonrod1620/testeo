<?php

function quitaregistrosmalos($archivo,$cantregs,$separador)
{
	$archivoc=fopen($archivo,"r") or die('Error de apertura');
	$archivob=fopen($archivo."bis","a+") or die('Error de apertura');
	$archivoa=fopen($archivo."real","a+") or die('Error de apertura');
	$contador=0;
	$contador2=0;
	while (!feof($archivoc))
	{
		$datosc=fgets($archivoc,4096);
		$cantidadseparador=substr_count($datosc,$separador); 
		if($cantidadseparador!= $cantregs)
		{
			fputs($archivob, "linea ".$contador."     ".$datosc);
			$contador=$contador+1;
		}
		else
		{
			fputs($archivoa,str_replace(chr(194),"",str_replace(chr(191),"",str_replace("\\".$separador,$separador,str_replace("\\."," ",str_replace(chr(224),"",str_replace(chr(205).chr(87),"",str_replace(chr(0),"",str_replace(chr(13),"",str_replace(chr(195),"",$datosc))))))))));
			$contador2=$contador2+1; 
		}
	//echo $cantidadseparador."\n";
	//exit();


	}
	fclose($archivoc);
	fclose($archivob);
	fclose($archivoa);
	return $contador2;
}

function desencriptargpg($archivo_encrip, $archivo_desenc, $clave)
{
	echo "\n echo ".$clave." | gpg --batch --passphrase-fd 0 --output ".$archivo_desenc." --decrypt ".$archivo_encrip." \n";
	shell_exec("echo ".$clave." | gpg --batch --passphrase-fd 0 --output ".$archivo_desenc." --decrypt ".$archivo_encrip);
}
//echo 3963barat | gpg --batch --passphrase-fd 0 --output EMPLEDOR_20091007_01.TXT --decrypt EMPLEDOR_20091007_01.TXT.asc

function encriptargpg($llave, $archivo_enc)
{
	echo "\n gpg --encrypt --recipient '".$llave."' ".$archivo_enc." \n";
	shell_exec("gpg --encrypt --recipient '".$llave."' ".$archivo_enc);
}

$archivo_enc = "/home/tuya/adfinaadfinad.txt";
$archivo_encrip = "/home/tuya/adfinaadfinad.txt.gpg";;
$archivo_sal = "/home/tuya/adfinaadfinasalida.txt";
$clave = "encripta tuya";
$llave = "admintuya <jrodriguez@solati.com.co>";


if($argv[1] !== '')
	$archivo_encrip =$argv[1];

if($argv[2] !== '')
	$archivo_sinencr = $argv[2];
/*
if($argv[3] !== '')
	$clave = $argv[3];

$fecha = date('Y-m-d');

$extension = ".txt";
*/

echo "\n Prueba \n ";

if(file_exists($archivo_encrip)){
	
	//encriptargpg($llave, $archivo_enc);
	
	desencriptargpg($archivo_encrip, $archivo_sinencr, $clave);
	
	//quitaregistrosmalos($archivo_sal,"6","|");

}
else echo "\n El archivo  $archivo_encrip no existe  \n";

?>
