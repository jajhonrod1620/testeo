<?php
/*
$in = file("/home/tuya/FACTURAVENCIDA.txt");
$out = fopen("/home/tuya/FACTURAVENCIDA_real.txt", "w");

foreach ($in as $line){

	fputs($out, iconv("UTF-16LE", "UTF-8//TRANSLIT", $line));

}
*/

$nom_archivo = "/home/tuya/FACTURAVENCIDA1.txt";
$nom_archivoOri = "/home/tuya/FACTURAVENCIDA1_nueva.txt";

shell_exec("iconv --from-code=UTF-16LE --to-code=UTF-8 -o  $nom_archivo $nom_archivoOri");


/*
$archivo = fopen($nom_archivo,"r") or die('Error de apertura');
$archivoa = fopen($nom_archivo."nuevo","a+") or die('Error de apertura');

		while(!feof($archivo))
		{
			//echo "<br>".$i++."  ";
			$datos = fgets($archivo,4096);
			fputs($archivoa, iconv("UTF-16LE", "UTF-8//TRANSLIT", $datos));
		}
		
		fclose($archivo);
		fclose($archivoa);
*/

?>
