<?php

$_SESSION['usubd']="root";
$_SESSION['dbdriver']="postgres";
$_SESSION['database']="adminofh";
$_SESSION['servidor']="192.168.2.185";

include_once('/var/www/html/padminfo/includes/funciones_genericas.php');

/*$resultado1=query_shell($_SESSION['database'], "DROP TABLE IF EXISTS prueba_rec_trans",1,0);
$resultado1 = query_shell($_SESSION['database'], "CREATE TABLE prueba_rec_trans(cons bigint,
												texto text,
												texto_concat text
												)", 0,0);
												
												
$resultado1 = query_shell($_SESSION['database'], "insert into prueba_rec_trans select doc_clte, obligacion, obligacion||' \| '||gestionsap FROM trans_bancolombia_act LIMIT 10 ",0,0);

$resultado1 = query_shell($_SESSION['database'], "copy (SELECT cons, texto, texto_concat FROM prueba_rec_trans) to '/home/bancolombia/prueba_rechazos.txt' with delimiter '|'  null '' ",0,0);
* */

$arrResultado = evalua_separador( "/home/jjhon/plano_pruebas.txt", "|", 3);

echo "<pre>";
print_r($arrResultado);

?>
