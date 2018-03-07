<?php
if(isset($argv[2])){
	$_SESSION['usubd']=$argv[2];
}
else
	$_SESSION['usubd']="root";

if(isset($argv[3])){
	$_SESSION['dbdriver']=$argv[3];
}
else
	$_SESSION['dbdriver']="postgres";

if(isset($argv[4])){
	$_SESSION['database']=$argv[4];
}
else
	$_SESSION['database']="comfama_20120924";

if(isset($argv[5])){
	$_SESSION['servidor']=$argv[5];
}
else
	$_SESSION['servidor']="192.168.2.122";





if(trim(PHP_OS)=="Linux"){
	$DOCUMENT_ROOT  = "/var/www/html";
}else{
	$DOCUMENT_ROOT  = "C:\Archivos de programa\Apache Group\Apache\htdocs";
}

include_once($DOCUMENT_ROOT.'/padminfo/includes/funciones_genericas.php');


//convertir arreglo postgres en array php 
function arrpg_arrphp ($arreglo,  $asText = true) {
    $s = $arreglo;
    if ($asText) {
			$s = str_replace("{", "array('", $s);
			$s = str_replace("}", "')", $s);    
			$s = str_replace(",", "','", $s);    
    } else {
			$s = str_replace("{", "array(", $s);
			$s = str_replace("}", ")", $s);
    }
    $s = "\$retval = $s;";
    eval($s);
    return $retval;
}
//convertir arreglo php en array postgres
function arrphp_arrpg ($arreglo) {
    $s = $arreglo;
    for($i=0; $i< count($s); $i++){
			if($i==0){
				$cadena .= "'{".$s[$i].","; 
			}
			else{
				if($i == count($s)-1)
					$cadena .= "".$s[$i]."}'";
				else
					$cadena .= $s[$i].",";
			}
		}
    return $cadena;
}


//tabla de postgres  cuyo campo cod_agente es un array
$alianza_user = query($_SESSION['database'], "SELECT * FROM agentesusuario WHERE estado = 'A' limit 1", 1,0);


for($i=0; $i<$alianza_user->recordcount();$i++){
	echo $alianza_user->fields['cod_agente'] ." <br>";
	$arreglo_php = arrpg_arrphp($alianza_user->fields['cod_agente'], false);
	echo "<pre>";
	print_r($arreglo_php);
	echo "</pre>";
	$alianza_user->movenext();
}


echo "<pre>";
	print_r($arreglo_php);
	echo "</pre>";
	
echo "<br> ".arrphp_arrpg($arreglo_php); 

//if(in_array)
?>

