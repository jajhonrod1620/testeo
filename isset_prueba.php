<?php
$extantarray['a'] = 42;
if(!isset($extantarray['b']))
	echo "existe <br>";
else 
	echo "no existe <br>";
	
	echo "<pre>";
	print_r($extantarray);
?>

