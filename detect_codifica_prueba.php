<?php

function detectar_codificacion($archivo)
{
	$cadena = "";
	$archivo = fopen($archivo,"a") or die('Error de apertura');
	
	return mb_detect_encoding($archivo, "auto");



	/*while (!feof($archivo))
	{
		echo "<br>".$i++."  ";
		$datos = fgets($archivo,4096);
		$cadena = $cadena.$datos;
		echo mb_detect_encoding($datos, "auto");
	//exit();
	}
	*/
	
	fclose($archivo);
	//echo "<br>".mb_detect_encoding($cadena, "auto");

}

//echo 3963barat | gpg --batch --passphrase-fd 0 --output EMPLEDOR_20091007_01.TXT --decrypt EMPLEDOR_20091007_01.TXT.asc

$nom_archivo = "/home/tuya/FACTURAVENCIDA1.txt";


if(file_exists($nom_archivo)){
	$codificacion =  detectar_codificacion($nom_archivo);
	
	var_dump($codificacion);
	echo "<br>".$codificacion;
	
	if($codificacion != false ){

		$archivo = fopen($nom_archivo,"r") or die('Error de apertura');
		$archivoa = fopen($nom_archivo."nuevo","a+") or die('Error de apertura');

		while (!feof($archivo))
		{
			echo "<br>".$i++."  ";
			$datos = fgets($archivo,4096);
			fputs($archivoa, iconv($codificacion, "UTF-8//TRANSLIT", $datos));
		}
		
		fclose($archivo);
		fclose($archivoa);
	}

}

//(iconv --from-code=UTF-16 --to-code=UTF-8 -o FACTURAVENCIDA_real.txt FACTURAVENCIDA.txt)

?>
