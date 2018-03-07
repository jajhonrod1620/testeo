<?php
echo "----------- strtok -----------<br>";
$cadena2 = array();
$cadena2  = strtok('usuario_136', '_');
$cadena2 = strtok('_');
var_dump($first_token, $cadena2);

echo "----------- substr -----------<br>";
$first_token  = substr('usuario_136', 8);
var_dump($first_token);

echo "----------- explode -----------<br>";
$first_token  = explode('_','usuario_136');
var_dump($first_token);
