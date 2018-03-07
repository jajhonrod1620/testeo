<?php

$text = "\t\tThese are a few words :) ...  ";
$binary = "\x09Example string\x0A";
$hello  = "Hello World";
var_dump($text, $binary, $hello);

print "<br> comienza trim <br>";

print "<br> \$trimmed = rtrim(\$text); ";
$trimmed = rtrim($text);
var_dump($trimmed);

print "<br> \$trimmed = rtrim(\$text,  \"\\t.\") ";
$trimmed = rtrim($text, " \t.");
var_dump($trimmed);

$trimmed = rtrim($hello, "Hdle");
var_dump($trimmed);

// retira los caracteres ASCII de control al inicio de $binary
// (de 0 a 31 inclusive)
$clean = rtrim($binary, "\x00..\x1F");
var_dump($clean);
