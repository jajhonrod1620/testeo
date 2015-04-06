<?php
/*
 * @author Jaime Jhon
 * Script para probar si los registros de extraccion pertenecen a registros validos de adminfo
 */


$_SESSION['usubd']=$argv[1];
$_SESSION['dbdriver']=$argv[2];
$_SESSION['database']=$argv[3];
$_SESSION['servidor']=$argv[4];
$nro_pruebas= $argv[5];
$tabla_plano= $argv[6];
$campo_valida= $argv[7];


if(trim(PHP_OS)=="Linux"){
	$DOCUMENT_ROOT  = "/var/www/html";
}else{
	$DOCUMENT_ROOT  = "C:\Archivos de programa\Apache Group\Apache\htdocs";
}

include_once($DOCUMENT_ROOT.'/padminfo/includes/funciones_genericas.php');

include_once($DOCUMENT_ROOT.'/padminfo/includes/funciones_genericas.php');

$informe = array();


function valida_existencias($campo, $ap, $nom_ap, $valorfiltro=null, $tabla, $cam_tabla, $nro_pruebas,  $campofiltro=null){
	global $informe, $posicion;
	
	$select_aleatorio = "SELECT ".$campo." as campo FROM ".$ap;
	if ($campofiltro != null){
		$where_aleatorio = " where ".$campofiltro." ".$valorfiltro."";
	}
	
	$limit_aleatorio = " LIMIT ".$nro_pruebas;
	
	$sql_aleatorio = $select_aleatorio.$where_aleatorio." ORDER BY random() ".$limit_aleatorio;
	
	$consultacampos = query($_SESSION['database'], $sql_aleatorio, 0, 0);
	
	for($r=0; $r<$consultacampos->RecordCount(); $r++){
		$select_valida = "SELECT count(*) as cantidad FROM ".$tabla;
		$where_valida = " WHERE ".$cam_tabla." = ".$consultacampos->fields['campo'];
		$sql_valida = $select_valida.$where_valida;
		$cantidad = query($_SESSION['database'], $sql_valida, 0, 0);
		$posicion = $posicion+1;
		if($cantidad == 0){
			$informe[$posicion]['Archivo'] = $nom_ap;
			$informe[$posicion]['campo'] = $campo;
			$informe[$posicion]['tabla_Asociada'] = $tabla;
			$informe[$posicion]['valor'] = $consultacampos->fields['campo'];
		}	
		$consultacampos->MoveNext();
	}

}

switch ($tabla_plano) {
	case 'tmp_elementos_casos':
		if($campo_valida == 'Demandados') {
			valida_existencias('nitdeudor', 'tmp_elementos_casos', 'Elementos Casos', '= \'ZDMNDADO\'', 'demandados_t', 'nit', $nro_pruebas, 'funcion');
		}
		elseif($campo_valida == 'Demandantes'){
			valida_existencias('nitdeudor', 'tmp_elementos_casos', 'Elementos Casos', '=\'ZDMNDNTE\'', 'demandantes', 'nit', $nro_pruebas, 'funcion');
		}
		elseif($campo_valida == 'Negociadores'){
			valida_existencias('nitdeudor', 'tmp_elementos_casos', 'Elementos Casos', '= \'ZNEGOCIA\'', 'abogados', 'nit', $nro_pruebas, 'funcion');
		}
		elseif($campo_valida == 'Obligaciones'){
			valida_existencias('nro_obligacion', 'tmp_elementos_casos', 'Elementos Casos', 'is not null', 'docdeu', 'nrodoc', $nro_pruebas, 'nro_obligacion');
		}
		elseif($campo_valida == 'Garantias'){
			valida_existencias('nro_garantia', 'tmp_elementos_casos', 'Elementos Casos', 'is not null', 'garantias', 'num_garantia', $nro_pruebas, 'nro_garantia');
		}
		break;
	case 'tmp_casos':
		if($campo_valida == 'Negociadores') {
			valida_existencias('id_negociador', 'tmp_casos', 'Casos', 'is not null', 'abogados', 'nit', $nro_pruebas, 'id_negociador');
		}
		elseif($campo_valida == 'Externos'){
			valida_existencias('id_abog_externo', 'tmp_casos', 'Casos', 'is not null', 'abogados', 'nit', $nro_pruebas, 'id_abog_externo');
		}
		elseif($campo_valida == 'Juzgados'){
			valida_existencias('juzgado', 'tmp_casos', 'Casos', 'is not null', 'juzgados', 'codijuz', $nro_pruebas, 'juzgado');
		}
		break;
	case 'tmp_actividades_hist':
		if($campo_valida == 'Deudor') {
			valida_existencias('nitdeudor', ' tmp_actividades_hist', 'Actividades', 'is not null', 'nits', 'nit', $nro_pruebas, 'nitdeudor');
		}
		break;
	default:
		echo "\n Parametros Invalidos \n";
}

if (count($informe) > 1){
	echo "Existen los Siguientes registros invalidos en el AP ".$tabla_plano." \n";
	echo "Archivo\tCampo\tTabla Asociada\tValor \n \n";
	foreach ($informe as $valor){
		echo $valor['Archivo']."\t".$valor['campo']."\t".$valor['tabla_Asociada']."\t".$valor['valor']."\n";
	}
}
else echo "No Hay registros invalidos en el AP de ".$tabla_plano." \n";


//demandados validos en el ap de elementos
/*
$sql_aleatorio = "SELECT nitdeudor FROM tmp_elementos_casos where funcion = 'ZDMNDADO' order by random() limit ".$nro_pruebas;

$consultacampos = query($_SESSION['database'], $sql_aleatorio, 0, 0);

for($r=0; $r<$consultacampos->RecordCount(); $r++){
	$cantidad = query($_SESSION['database'], "SELECT count(*) as cantidad FROM demandados_t WHERE nit = ".$consultacampos->fields['nitdeudor'], 0,0);
	$posicion = $r+1;
	if($cantidad == 0){
		$informe[$posicion]['Archivo'] = "Elementos";
		$informe[$posicion]['campo'] = "nitdeudor";
		$informe[$posicion]['tabla_Asociada'] = "demandados_t";
		$informe[$posicion]['valor'] = $consultacampos->fields['nitdeudor'];
	}	
	$consultacampos->MoveNext();
}
*/

// negociadores validos en el AP de elementos
/*
$sql_aleatorio = "SELECT nitdeudor FROM tmp_elementos_casos where funcion  = 'ZNEGOCIA' order by random() limit ".$nro_pruebas;

// demandas validas en el Ap de elementos

$sql_aleatorio = "SELECT consdeman FROM  tmp_elementos_casos order by random() limit ".$nro_pruebas;

$consultacampos = query($_SESSION['database'], $sql_aleatorio, 0, 0);
*/
?>
