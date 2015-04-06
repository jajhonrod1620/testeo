<?php

	function formato_nomarchivo($cadena_ruta){
		$ruta = str_replace("(", "\(",$cadena_ruta);
		$ruta = str_replace(")", "\)",$cadena_ruta);
		$ruta = str_replace("'", "\'",$cadena_ruta);
		$ruta = str_replace(" ", "\ ",$cadena_ruta);
		
		return $ruta;
	}
	
	
	$cadena = "/home/proteccion/Entes territoriales.csv_bueno.txt";
	$niucadena = formato_nomarchivo($cadena);
	echo "Cadena   antes : $cadena    <br> despues : $niucadena <br>";
	
	
	echo "\n".$month.",".$day.",".$year;
	
	sleep(30);
	
	$date=date('Y-m-d');
	$year = substr($date, 0,4);
	$month = substr($date, 5, 2);
	$day = substr($date, 8, 2); 
	$strFechaActual=date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));	
	
	$formato_fecha = str_replace("-", "",$strFechaActual);
	
	echo "<br> <br>Formato Fecha : $strFechaActual  Reemplazando (-)  : $formato_fecha  <br>";

/* Can you imagine what this will print? :) */
echo convert_uudecode("+22!L;W9E(%!(4\"$`\n`");

?>
