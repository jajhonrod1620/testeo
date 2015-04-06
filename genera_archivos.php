<?php
$archivo = fopen("/var/www/html/testeo/prueba_gnrafile.txt", "w+") OR 	$error_genera = 'S';
$registros = 2500;

$linea = date('Y-m-d')."|".$registros;

fputs($archivo, $linea); 

fclose($archivo);

?>
