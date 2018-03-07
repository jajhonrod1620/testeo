<?php

ini_set('session.cache_limiter', '');
header('Expires: Thu, 19 Nov 1981 08:52:00 GMT');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: no-cache');
header('Content-Type: text/html; charset=utf-8');

if($_REQUEST['nuevo'] !='V')
	{
		$nuevo='F';
	}
	else
		$nuevo='V';


	$date=date('Y-m-d');
	$year = substr($date, 0,4);
	$month = substr($date, 5, 2);
	$day = substr($date, 8, 2); 
?>

<script type='text/javascript' language='text/javascript'>

function gebi(name){
	 return document.getElementById(name)
}

function diasentre(fechaFinal, fechaIni){

	var one_day = 1000*60*60*24;

	//var daysApart = Math.abs(parseInt(Math.ceil((parseInt(fechaFinal.getTime())-parseInt(fechaIni.getTime()))))/parseInt(one_day));
	var daysApart = parseInt(Math.ceil((parseInt(fechaFinal.getTime())-parseInt(fechaIni.getTime()))))/parseInt(one_day);

	return daysApart
}

function validaciones()
{
	var mensaje = "";
	var mensajelogueo = "";
	var mensajegestiones = "";
	var mensajetraslados = "";
	var mensaje4 = "";
	var mensaje2 = "";

	var validacion1 = false;
	var validacion4 = true;
	var validacion2 = true;
	var validacion3 = true;

	var fecha_actual = new Date();

	alert(fecha_actual);
	var inicio_logueo = "";
	var fin_logueo = "";
	var inicio_gestiones = "";
	var fin_gestiones = "";
	var inicio_traslados = "";
	var fin_traslados = "";
	
	var aceptacambios = true;

	if(gebi('fecha_inicio_tiemposlogueo').value != "" || gebi('fecha_fin_tiemposlogueo').value != "") {
		if(gebi('fecha_inicio_tiemposlogueo').value == "" || gebi('fecha_fin_tiemposlogueo').value == ""){
			validacion4 = false;
			mensaje4 = "\n    -Tiempos de Conexion";
		}
		else{
			validacion1 = true;
			var fecinilogueo = gebi('fecha_inicio_tiemposlogueo').value;
			var fecfinlogueo = gebi('fecha_fin_tiemposlogueo').value;
			alert(fecinilogueo+"\n"+fecfinlogueo);
			var inicio_logueo = new Date(parseInt(fecinilogueo.substring(0,4)), (parseInt(fecinilogueo.substring(5,7))-parseInt('1')), fecinilogueo.substring(8,10), 23, 59, 59);
			var fin_logueo = new Date(parseInt(fecfinlogueo.substring(0,4),10), (parseInt(fecfinlogueo.substring(5,7))-parseInt('1')), fecfinlogueo.substring(8,10), 23, 59, 59);
			
			alert(inicio_logueo+"\n"+fin_logueo);

			if(inicio_logueo < fecha_actual && fin_logueo < fecha_actual){
				if(!(diasentre(fin_logueo, inicio_logueo) <= 2 && diasentre(fin_logueo, inicio_logueo) >= 0)){
					validacion3 = false;
					mensajelogueo = "\n    -Tiempos de Conexion";
				}
			}
			else{
				validacion2 = false;
				mensaje2 = "\n    -Tiempos de Conexion";
			}
		}
	}
	if(gebi('fecha_inicio_gestiones').value != "" || gebi('fecha_fin_gestiones').value != ""){
		if(gebi('fecha_inicio_gestiones').value == "" || gebi('fecha_fin_gestiones').value == ""){
			validacion4 = false;
			mensaje4 = mensaje4+"\n    -Gestiones";
		}
		else{
			validacion1 = true;
			var fecinigestiones = gebi('fecha_inicio_gestiones').value;
			var fecfingestiones = gebi('fecha_fin_gestiones').value;
			var inicio_gestiones = new Date(parseInt(fecinigestiones.substring(0,4)), (parseInt(fecinigestiones.substring(5,7))-parseInt('1')), fecinigestiones.substring(8,10), 23, 59, 59);
			var fin_gestiones = new Date(parseInt(fecfingestiones.substring(0,4)), (parseInt(fecfingestiones.substring(5,7))-parseInt('1')), fecfingestiones.substring(8,10), 23, 59, 59);

			if(inicio_gestiones < fecha_actual && fin_gestiones < fecha_actual){
				if(!(diasentre(fin_gestiones, inicio_gestiones) <= 2 && diasentre(fin_gestiones, inicio_gestiones) >= 0)){
					validacion3 = false;
					mensajegestiones = "\n    -Gestiones";
				}
			}
			else{
				validacion2 = false;
				mensaje2 = mensaje2+"\n    -Gestiones";
			}
		}
	}
	if(gebi('fecha_inicio_traslados').value != "" || gebi('fecha_fin_traslados').value != ""){
		if(gebi('fecha_inicio_traslados').value == "" || gebi('fecha_fin_traslados').value == ""){
			validacion4 = false;
			mensaje4 = mensaje4+"\n    -Traslados";
		}
		else{
			validacion1 = true;
			var fecinitraslados = gebi('fecha_inicio_traslados').value;
			var fecfintraslados = gebi('fecha_fin_traslados').value;
			var inicio_traslados = new Date(parseInt(fecinitraslados.substring(0,4)), (parseInt(fecinitraslados.substring(5,7))-parseInt('1')), fecinitraslados.substring(8,10), 23, 59, 59);
			var fin_traslados = new Date(parseInt(fecfintraslados.substring(0,4)), (parseInt(fecfintraslados.substring(5,7))-parseInt('1')), fecfintraslados.substring(8,10), 23, 59, 59);

			if(inicio_traslados < fecha_actual  && fin_traslados < fecha_actual){
				if(!(diasentre(fin_traslados, inicio_traslados) <= 2 && diasentre(fin_traslados, inicio_traslados) >= 0)){
					validacion3 = false;
					mensajetraslados = "\n    -Traslados";
				}
			}
			else{
				validacion2 = false;
				mensaje2 = mensaje2+"\n    -Traslados";
			}
		}
	}

	if(gebi('reprograma_oblig').checked == true){
		validacion1 = true;
	}
	
	if(validacion4 == false){
		mensaje = mensaje+"Debe diligenciar tanto fecha inicial y final en : "+mensaje4;
	}
	else if(validacion1 == false  && '<?php echo $nuevo ?>' == 'V'){
		mensaje = mensaje+"\n Debe seleccionar como minimo un archivo, diligenciando las fechas inicial y final del archivo que desee reprogramar\n";
	}
	if(validacion2 == false){
		mensaje =  mensaje+"\n Las fechas deben ser anteriores a la fecha actual en : "+mensaje2;
	}
	if(validacion3 == false){
		mensaje =  mensaje+"\n Rango de fechas Invalido en : "+mensajelogueo+mensajegestiones+mensajetraslados+"\n ";
	}


	if((validacion1 == false  &&  '<?php echo $nuevo ?>' == 'V') || validacion2 == false || validacion3 == false || validacion4 == false){
		alert (" Error : \n"+mensaje);
		return false
	}
	else {
		aceptacambios = true;
		return aceptacambios;
	}
}

function checkShortcut() 
{
	if(event.keyCode==8 || event.keyCode==13) 
	{
		return false; 
	}
}

function del_fechas_logueos(){
	gebi('fecha_inicio_tiemposlogueo').value = ''; 
	gebi('fecha_fin_tiemposlogueo').value = '';
	gebi('txt_grabador_logueos').innerHTML = '';
	gebi('grabador_logueos').value = '';
}

function del_fechas_gest(){
	gebi('fecha_inicio_gestiones').value = ''; 
	gebi('fecha_fin_gestiones').value = '';
	gebi('txt_grabador_gestiones').innerHTML = '';
	gebi('grabador_gestiones').value = '';
}

function del_fechas_tras(){
	gebi('fecha_inicio_traslados').value = ''; 
	gebi('fecha_fin_traslados').value = '';
	gebi('txt_grabador_traslados').innerHTML = '';
	gebi('grabador_traslados').value = '';

}

</script>

<script type='text/javascript' src='/padminfo/jscalendar/calendar.js'></script>
<script type='text/javascript' src='/padminfo/jscalendar/lang/calendar-es.js'></script>
<script type='text/javascript' src='/padminfo/jscalendar/calendar-setup.js'></script>
<link rel='stylesheet' type='text/css' media='all' href='/padminfo/jscalendar/calendar-win2k-cold-1.css' title='win2k-cold-1' />

		<form action="<?=$PHP_SELF?>" method="post" name="formulario" onsubmit="return validaciones()">
			<table border="0" align=center cellspacing="2" cellpadding="0" width="100%">
			<tr><td colspan = '2' style='font-weight:bold;text-align:center;font-size:120%'><br>Tiempos de Conexion<br></td></tr>
				<tr><td>Fecha Inicio&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td width="160">
				<input id="fecha_inicio_tiemposlogueo" type="text" tabindex="1" readonly="1" style="width: 130;" value="" name="fecha_inicio_tiemposlogueo">
				<img id="f_trigger_c_fecha_inicio_tiemposlogueo" title="Seleccione la Fecha" style="cursor: pointer; border: 1px solid blue;" src="/padminfo/jscalendar/img.gif">
					<script type="text/javascript">
					 Calendar.setup
						(	{ inputField     :    'fecha_inicio_tiemposlogueo',
								ifFormat       :    '%Y-%m-%d',
								button         :    'f_trigger_c_fecha_inicio_tiemposlogueo',
								align          :    'Bl',
								singleClick    :    true
							}	);
					</script>
				</td></tr>
				<tr><td>Fecha Fin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td width="160">
				<input id="fecha_fin_tiemposlogueo" type="text" tabindex="1" readonly="1" style="width: 130;" value="" name="fecha_fin_tiemposlogueo">
				<img id="f_trigger_c_fecha_fin_tiemposlogueo" title="Seleccione la Fecha" style="cursor: pointer; border: 1px solid blue;" src="/padminfo/jscalendar/img.gif">
					<script type="text/javascript">
					 Calendar.setup
						(	{ inputField     :    'fecha_fin_tiemposlogueo',
								ifFormat       :    '%Y-%m-%d',
								button         :    'f_trigger_c_fecha_fin_tiemposlogueo',
								align          :    'Bl',
								singleClick    :    true
							}	);
					</script>
				</td>
				</tr>
				<tr><td colspan = '2' style='font-weight:bold;text-align:center;font-size:120%'><br>Gestiones Diarias<br></td></tr>
				<tr><td>Fecha Inicio&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td width="160">
				<input id="fecha_inicio_gestiones" type="text" tabindex="1" readonly="1" style="width: 130;" value="" name="fecha_inicio_gestiones">
				<img id="f_trigger_c_fecha_inicio_gestiones" title="Seleccione la Fecha" style="cursor: pointer; border: 1px solid blue;" src="/padminfo/jscalendar/img.gif">
					<script type="text/javascript">
					 Calendar.setup
						(	{ inputField     :    'fecha_inicio_gestiones',
								ifFormat       :    '%Y-%m-%d',
								button         :    'f_trigger_c_fecha_inicio_gestiones',
								align          :    'Bl',
								singleClick    :    true
							}	);
					</script>
				</td></tr>
				<tr><td>Fecha Fin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td width="160">
				<input id="fecha_fin_gestiones" type="text" tabindex="1" readonly="1" style="width: 130;" value="" name="fecha_fin_gestiones">
				<img id="f_trigger_c_fecha_fin_gestiones" title="Seleccione la Fecha" style="cursor: pointer; border: 1px solid blue;" src="/padminfo/jscalendar/img.gif">
					<script type="text/javascript">
					 Calendar.setup
						(	{ inputField     :    'fecha_fin_gestiones',
								ifFormat       :    '%Y-%m-%d',
								button         :    'f_trigger_c_fecha_fin_gestiones',
								align          :    'Bl',
								singleClick    :    true
							}	);
					</script>
				</td>
				</tr>
				<tr><td colspan = '2' style='font-weight:bold;text-align:center;font-size:120%'><br>Traslados Diarios<br></td></tr>
				<tr><td>Fecha Inicio&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td width="160">
				<input id="fecha_inicio_traslados" type="text" tabindex="1" readonly="1" style="width: 130;" value="" name="fecha_inicio_traslados">
				<img id="f_trigger_c_fecha_inicio_traslados" title="Seleccione la Fecha" style="cursor: pointer; border: 1px solid blue;" src="/padminfo/jscalendar/img.gif">
					<script type="text/javascript">
					 Calendar.setup
						(	{ inputField     :    'fecha_inicio_traslados',
								ifFormat       :    '%Y-%m-%d',
								button         :    'f_trigger_c_fecha_inicio_traslados',
								align          :    'Bl',
								singleClick    :    true
							}	);
					</script>
				</td></tr>
				<tr><td>Fecha Fin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td width="160">
				<input id="fecha_fin_traslados" type="text" tabindex="1" readonly="1" style="width: 130;" value="" name="fecha_fin_traslados">
				<img id="f_trigger_c_fecha_fin_traslados" title="Seleccione la Fecha" style="cursor: pointer; border: 1px solid blue;" src="/padminfo/jscalendar/img.gif">
					<script type="text/javascript">
					 Calendar.setup
						(	{ inputField     :    'fecha_fin_traslados',
								ifFormat       :    '%Y-%m-%d',
								button         :    'f_trigger_c_fecha_fin_traslados',
								align          :    'Bl',
								singleClick    :    true
							}	);
					</script>
				</td>
				</tr>
				
				<tr><td colspan="2" ><br><input type='checkbox' name = 'reprograma_oblig'  id = 'reprograma_oblig' value = 'S' <?php	if($day = '01') echo "disabled='true'"; ?>>&nbsp;&nbsp;&nbsp;  Obligaciones Mensuales </td></tr>
				<tr><td><br>&nbsp;</td><td>&nbsp;</td></tr>
				
				<tr>
					<th colspan=2>
					<?
						echo "<input type='submit' value='guardar' name='accion' style='width:80' >";
					?>
					</th>
				</tr>
			</table>
		</form>

<?php
	include_once($DOCUMENT_ROOT.'/padminfo/includes/pie.php');

?>
