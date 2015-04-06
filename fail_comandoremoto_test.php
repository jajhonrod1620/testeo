<?php
/*expect -c "spawn ssh desarrollo@192.168.2.185 wc -l /home/bancolombia/transformacion_bancolombia_prejur.txt
expect \"*?assword:*\"
send -- \"devsolati\r\"
expect eof"*/

$cadena_conteo1 = shell_exec("expect -c \"spawn ssh desarrollo@192.168.2.185 wc -l /home/bancolombia/transformacion_bancolombia_prejur.txt
expect \\\"*?assword:*\\\"
send -- \\\"devsolati\\r\\\"
expect eof\"");

$cadena_conteo2 = shell_exec(escapeshellcmd("wc -l /home/comfama-cartas/archivos/EMTELCONOMINA20101227.csv"));

$cadena_conteo1 = explode("password:", $cadena_conteo1);

$conte2 = explode(" /", $cadena_conteo2);

$conte1 = explode(" /", $cadena_conteo1[1]);

$conte1 = $conte1[0];

$conte2 = $conte2[0];

echo $cadena_conteo1."\n";

echo $cadena_conteo2."\n";

echo $conte1."\n";

echo $conte2."\n";

?>
