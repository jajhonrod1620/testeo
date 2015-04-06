<?php
$string = 'cup';
$name = 'coffee';
$variable = "taza de $name";
$str = 'This is a $string with my $name in it.';
echo $str. "<br>";
eval("\$str = \"$str\";");
echo $str. "<br>";
echo $variable."<br>";
?>
