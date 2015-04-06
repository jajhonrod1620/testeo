<?php
/*
 * @author Jaime Jhon
 * Script para probar si los registros de extraccion pertenecen a registros validos de adminfo
 */


$_SESSION['usubd']= "root";
$_SESSION['dbdriver']="postgres";
$_SESSION['database']="adminfoh";
$_SESSION['servidor']="localhost";


include_once('/var/www/html/padminfo/includes/funciones_genericas.php');



$res = query_shell($database, "SELECT count(*) from prueba1", 1, 1);
//query_shell($database, "COPY (SELECT valor1, texto1 from prueba1) TO '/tmp/teste_plano2.txt' with delimiter '|' null as ''", 1, 1);

/*
$archivo1_new= fopen("/tmp/testeo_plano.txt","w+");
for($i=0; $i< 10; $i++){
	
	$line = " cadena ".$i." \n";
	fputs($archivo1_new,$line);
}

echo "archivo <br>";
/*$arreglo = fgets($archivo1_new);
echo "<pre>";
print_r($arreglo);
*/
/*
while(!feof($archivo1_new))
{
	$cadprue=fgets($archivo1_new);
	
	$datosc="titulos \n".$cadprue;
	fputs($archivo1_new, $datosc);
}
*/
?>
