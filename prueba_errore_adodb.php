<?php
/*
 * @author Jaime Jhon
 * Script para probar si los registros de extraccion pertenecen a registros validos de adminfo
 */


$_SESSION['usubd']=$argv[1];
$_SESSION['dbdriver']=$argv[2];
$_SESSION['database']=$argv[3];
$_SESSION['servidor']=$argv[4];


include_once('/var/www/html/padminfo/includes/funciones_genericas.php');

	$mapeo_campos = array(
		"segui.consegui" => "consecutivo gestiones",
		"compromi.conscompromi" => "codigo compromiso",
		"segui.nit" => "identificacion cliente",
		"doc.nrodoctxt" => "numero obligacion",
		"segui.total_ges" => "Dia mora",
		"segui.codcob" => "cod estado contacto",
		"estcob.descripcion" => "desc estado contacto",
		"segui.fechasegui" => "fecha gestion",
		"nue_usuario.nombre" => "nombre usuario",
		"segui.nota" => "nota gestion",
		"segui.fechaprome" => "fecha compromiso",
		"compromi.valop" => "valor compromiso",
		"compromi.estado" => "estado compromiso",
		"compromi.codcob_resultado" => "estado compromiso",
		"abogados.nomabogado" => "nombre agente",
		"abogados.nit" => "nit agente",
		"nue_usuario.nit" => "nit usuario",
		"segui.consdocdeu" => "numero obligacion"
	);


	$mapeo_tablas = array(
		"segui" => "historial de gestiones",
		"docdeu" => "inventario de creditos",
		"compromi" => "historial de compromisos",
		"estcob" => "codigos de gestion",
		"abogados" => "gestores",
		"nue_usuario" => "usuarios",
		"sociedad" => "configuracion",
		"fechaimportacion" => "fecha importacion"
	);




function borrar_cadenas_delimitadas($cadena, $delimitador1, $delimitador2){
	$ocurrencias = substr_count($cadena,  $delimitador2);
	$cant = 1;
	$niucadena = $cadena;
	for($i =0; $i < $ocurrencias; $i ++){
		$niucadena = preg_replace("/$delimitador2/", "##", $niucadena, $cant);
		$niucadena = preg_replace("/$delimitador1.*##/", "xxxx", $niucadena);
	}
	return $niucadena;
}

function editar_mensaje_error($mens_error){
global $mapeo_campos, $mapeo_tablas;
		$resultado2=explode("\n",$mens_error);
		$mens_error=$resultado2[0];

		$niucadena = $mens_error;

		foreach($mapeo_campos as $nom_campo => $equivalencia){
			$niucadena = str_replace($nom_campo, $equivalencia, $niucadena);
		}
		foreach($mapeo_tablas as $nom_campo => $equivalencia){
			$niucadena = str_replace($nom_campo, $equivalencia, $niucadena);
		}
		return $niucadena;
	}

$resultado=query_shell($_SESSION['database'], "SELECT max(fecha_importacion) AS ult_import FROM docdeu",0,1);

if(!$resultado[1]){
	$niucadena = editar_mensaje_error($resultado[0]);
	echo "\n $niucadena \n ";
	}
else {
	echo "\n";
	//var_dump ($resultado[1]);
	echo "\n".$resultado[1]->fields['ult_import']."\n";
}

$resultado=query_shell($_SESSION['database'], "SELECT max(total_ges) AS ult_import FROM docdeu",0,1);

if(!$resultado[1]){
	$niucadena = editar_mensaje_error($resultado[0]);
	echo "\n $niucadena \n ";
	}
else {
	echo "\n";
	//var_dump ($resultado[1]);
	echo "\n".$resultado[1]->fields['ult_import']."\n";
}

//$niucadena = explode("«»", $cadena);

//$niucadena = preg_replace("/«.*»/", "xxxx", $cadena);

//$niucadena = preg_replace("/»/", "##", $cadena, $cant);


/*
$resultado=query_shell($_SESSION['database'], "SELECT max(fechaimportacion) AS ult_import FROM docdeu",0,1);

$resultado2=explode("\n",$resultado[0]);
$resultado[0]=$resultado2[0];

$ini = $str_pos

echo "\n mensaje   ".$resultado[0]." \n  Resultado " ;
var_dump($resultado[1]);
/*if(!$resultado)
	echo "\n Exito";
else
	echo "\n Error";


echo "\n";
var_dump($resultado);
*/

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
