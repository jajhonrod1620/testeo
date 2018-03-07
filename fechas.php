<?php
	echo "date('Y-m-d H:i:s')   =  ".date('Y-m-d H:i:s'). "<br>";

	$date = new DateTime();
	echo $date->getTimestamp();
	$date = date_create();
	echo '<br> Timestamp ----------------- date = date_create() : ';
	echo '<br> date_format($date, "U = Y-m-d H:i:s")';
	echo date_format($date, 'U = Y-m-d H:i:s') . "<br>";
	
	$fechacambiaformato=date('m/d/Y');
	echo "<br> <br> date('m/d/Y') = $fechacambiaformato";
	
	$fechanumero = strtotime($fechacambiaformato, 0);
	echo " linea 9 <br> <br> strtotime(\$fechacambiaformato, 0)   =  $fechanumero";

	
	$plazocobroseg=1*86400;//a futuro el un tiene que ser variable de 0 a algo;
	echo "<br> <br> $plazocobroseg";
	
	$fechamazplazo=$fechanumero-$plazocobroseg;
	echo "<br> <br> $fechamazplazo";
	
	$fecha2=strftime("%Y%m%d",$fechamazplazo);
	echo "<br> <br>  strftime(\"%Y%m%d\",$fechamazplazo) =   $fecha2";
	
	echo "<br> <br>  strftime('%a %b %d %H:%M:%S %Y')  =   ".strftime('%a %b %d %H:%M:%S %Y');
	
	$dias = 3;
	$fecha    = mktime(0,0,0,date('m'),date('d')-1,date('Y'));
	$fechaant = mktime(0,0,0,date('m'),date('d')-$dias,date('Y'));
	
	echo " <br><br> fecha mktime(0,0,0,date('m'),date('d')-1,date('Y'))   =   ".$fecha;
	echo "<br> fecha ant mktime(0,0,0,date('m'),date('d')-$dias,date('Y'))   =  ".$fechaant;
	
	$fecha    = date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));
	$fechaant = date('Y-m-d',mktime(0,0,0,date('m'),date('d')-dias,date('Y')));
	
	echo " <br><br> fecha date('Ymd',mktime(0,0,0,date('m'),date('d'),date('Y'))) = ".$fecha;
	echo "<br>fecha ant date('Ymd',mktime(0,0,0,date('m'),date('d')-$dias,date('Y')))   = ".$fechaant;
	
	$date=date('Y-m-d');
	$year = substr($date, 0,4);
	$month = substr($date, 5, 2);
	$day = substr($date, 8, 2); 
	$hour = substr($date, 11, 2);
	$minute = substr($date, 14, 2);
	$second = substr($date, 17, 2);
	
  $numdias = 20;
  
	$strFechaActual=date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
  $strFechaAnt=date("Y-m-d", mktime(0, 0, 0, $month, $day-$numdias, $year));
  
  $ano = substr($strFechaAnt, 0,4);
	$mes = substr($strFechaAnt, 5, 2);
	$dia = substr($strFechaAnt, 8, 2); 
	$hora = substr($strFechaAnt, 11, 2);
	$minuto = substr($strFechaAnt, 14, 2);
	$segundo = substr($strFechaAnt, 17, 2);
  
  $strPrimeroMesActual = date("Y-m-d", mktime(0, 0, 0, $mes, 1, $ano));
  
  echo "<br><br>------------------------------------------------------------------------------------------".
    "<br>strFechaActual date('Y-m-d', mktime(0, 0, 0, \$month, \$day, \$year));   = ".$strFechaActual;
  echo "<br>strFechaActual date('Y-m-d', mktime(0, 0, 0, \$month, \$day-$dias, \$year));   = ".$strFechaAnt;
  echo "<br>strPrimeroMesActual date('Y-m-d', mktime(0, 0, 0, \$mes, \$dia-$dias, \$ano));   = ".$strPrimeroMesActual;
		
	
	
	echo "<br> <br> \$date=date('Y-m-d')   = ".$date=date('Y-m-d')."<br>
	\$year = substr(\$date, 0,4)   = ".$year = substr($date, 0,4)."<br>
	\$month = substr(\$date, 5, 2)  = ".$month = substr($date, 5, 2)."<br>
	\$day = substr(\$date, 8, 2)    =  ".$day = substr($date, 8, 2);
	
	echo "<br> \$strFechaActual=date(\"Ymd\", mktime(0, 0, 0, \$month, \$day, \$year))   =   ".$strFechaActual=date("Ymd", mktime(0, 0, 0, $month, $day, $year));
  echo "<br> \$strprimerodemes=date(\"Ymd\", mktime(0, 0, 0, \$month, 1, \$year))   =   ".$strFechaActual=date("Ymd", mktime(0, 0, 0, $month, 1, $year));
	
	echo "<br> <br> \$date=date('Y-m-d H:i:s')   = ".$date=date('Y-m-d H:i:s')."<br>";
	echo strlen($date);
	echo "<br> \$year = substr(\$date, 0,4)   = ".$year = substr($date, 0,4)."<br>
	\$month = substr(\$date, 5, 2)  = ".$month = substr($date, 5, 2)."<br>
	\$day = substr(\$date, 8, 2)    =  ".$day = substr($date, 8, 2)."<br>
	\$hora = substr(\$date, 11, 2)  = ".$hora = substr($date, 11, 2)."<br>
	\$min = substr(\$date, 14,2)   = ".$min = substr($date, 14,2)."<br>
	\$sec = substr(\$date, 17, 2)    =  ".$sec = substr($date, 17, 2);
	
	
	
	echo "<br> \$strFechaActual=date(\"Y-m-d H:i:s\", mktime(\$hora, \$min, \$sec, \$month, \$day, \$year))   =   ".$strFechaActual=date("Y-m-d H:i:s", mktime($hora, $min, $sec, $month, $day, $year));
	
	
	echo "<br> \$strFechaActual=date(\"H:i:s\", mktime(\$hora, \$min, \$sec, 0, 0, 0))   =   ".$strFechaActual=date("H:i:s", mktime($hora, $min, $sec, 0, 0, 0));

	$fecha    = date('Ymd', mktime(0,0,0,5,30	,2012));
	echo "<br> <br>	\$fecha    = date('Ymd',mktime(0,0,0,5,30,2012))  = ".$fecha;
	
	$fecha    = date('Ymd', mktime(0,0,0,5,0,2012));
	echo "<br> <br>	\$fecha    = date('Ymd',mktime(0,0,0,5,0,2012))  = ".$fecha;
	
	$fecha  = strtotime('2011-09-05');
	
	echo "<br> <br>	\$fecha  = strtotime('2011-09-05') = ".$fecha;

	$fecha = date('2011-09-05');

	echo "<br> <br>	\$fecha  = date('2011-09-05') = ".$fecha;
	
	$year = substr($date, 0,4);
	$month = substr($date, 5, 2);
	$day = substr($date, 8, 2);
	

	$fecha = date('Ymd', mktime(0, 0, 0, $month, $day, $year));
	
	echo "<br> <br>	\$fecha  = date('Ymd', mktime(0, 0, 0, $month, $day, $year)) = ".$fecha;
	
	$fechaIni = date('2011-09-29');
	
	$fechaFin = date('2011-10-01');
	
	$fechaIni2 = $fechaIni;

	/* while($fechaIni2 <= $fechaFin){

		$anoIni2 = substr($fechaIni2, 0,4);
		$mesIni2 = substr($fechaIni2, 5, 2);
		$diaIni2 = substr($fechaIni2, 8, 2);
		echo "<br> $fechaIni2";
		$fechaIni2 = date('Y-m-d', mktime(0,0,0, $mesIni2, $diaIni2+1, $anoIni2));
		
		echo " ..... $fechaIni2";
	}
*/

	echo "date('Y-m-d H:i:s')   =  ".date('Y-m-d H:i:s');
	echo "<br>".date('H:i:s');
	
	echo "<br> dia de la semana  date('w') : ".date('w');
	
	
	echo "<br> <br> resta de fechas : ";
	
	echo "<br>";
	
	echo "strtotime(date('Y-m-d')) = ". strtotime(date('Y-m-d'));
	
	echo "<br>";
	
	echo "strtotime(date('2013-07-16')) = ". strtotime('2013-07-16');
	
	echo "<br>";
	
	
	
	$fecha  = strtotime(date('Y-m-d')) - strtotime(date('2013-07-16'));
	echo "<br> <br>	\$fecha  = strtotime(date('Y-m-d')) - strtotime('2103-07-16')  = " .$fecha."<br>";
	
	
	echo "<br> 154";
	
	$fecha  = intval(strtotime(date('Y-m-d')) - strtotime(date('2013-07-16')))/86400;
	echo "<br> <br>	\$fecha  = (strtotime(date('Y-m-d')) - strtotime(\$dias->fields['2103-07-16']))/86400  = " .$fecha."<br>";
  
	echo "<br>";
	echo "<br> <br>	date(\"Y-m-d\", strtotime(\"+1 day\", strtotime(date('Y-m-d'))))  = " .
		date("Y-m-d", strtotime("+1 day", strtotime(date('Y-m-d'))));

	echo "<br>";
	echo "<br> <br>	date(\"Y-m-d\", strtotime(\"-1 day\", strtotime(date('2014-11-19'))))  = " .
		date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d','2014-11-19'))));
    
	echo "<br> <br>	intval((strtotime(date('Y-m-d')) - strtotime('1970-01-01'))  = " .
		intval((strtotime(date('Y-m-d')) - strtotime('1970-01-01')));
	echo "<br> <br>	intval((strtotime(date('Y-m-d')) - strtotime(''))  = " .
		intval((strtotime(date('Y-m-d')) - strtotime('')));
	echo "<br> <br>	intval((strtotime(date('Y-m-d')) - strtotime('2015-06-01'))  = " .
		intval((strtotime(date('Y-m-d')) - strtotime('2015-06-01')));
	
	echo "<br> <br> obtener hora en cadena : 2016-01-28 10:34:06.0 : <br>";
	echo "\$date = new DateTime('2016-01-28 10:34:06.0'); <br>";
	$date = new DateTime('2016-01-28 10:34:06.0');
	echo "\$date->format('H:i:s') =  " . $date->format('H:i:s');
?>
