<?php
	/*
	$a = 5;
	$b = &$a;
	$b = 6;
	$c = &$a;
	$c = 8;
	$b = 4;
	$a = 2;
	
	echo "Ejemplo de referencia \$a = $a, \$b = $b, \$c = $c <br>";
	echo "a: ";
	var_dump($a);
	echo "b: ";
	var_dump($b);
	echo "c: ";
	var_dump($c);
	
	
	echo "<br>";
	
	
	function &unaFuncion()
	{
		static $var =4;
		echo "<br> var: ";
		var_dump($var);
		
		$var++;
		return $var;
	}

	$alias = &unaFuncion();

	echo " <br> alias: ";
	var_dump($alias);
	//$alias++;
	unaFuncion();
	echo "<br>  alias: ";
	var_dump($alias);
	unaFuncion();
	echo "<br>  alias: ";
	var_dump($alias);
*/

function miFuncion (&$a) 
{ 
	return ++$a;  
}

function otraFuncion ($a) 
{ 
	return ++$a; 
}

$param = 0; 
echo "<br> miFuncion(\$param): ";  
miFuncion($param); 
var_dump($param); 

$variable = 0; 

echo '<br> otraFuncion(&$variable): ';  
otraFuncion(&$variable); 
var_dump($variable);


?>
