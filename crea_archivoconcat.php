<?php
$archivo = fopen("archivos/concat1.txt", "w+") OR 	$error_genera = 'S';
$registros = 2500;

$linea = date('Y-m-d')."|".$registros."\n";

fputs($archivo, $linea); 

fclose($archivo);

shell_exec("cat archivos/concat1.txt archivos/concat2.txt > archivos/concatdef.txt");
