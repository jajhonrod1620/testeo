<?php
$a = array(
 'a' => 'A',
 'b' => 'B',
 'c' => 'C',
);

$b = array(
 'd' => 'D',
 'e' => 'E',
);
echo "<pre>";
print_r($a);
echo "<br>";
print_r($b);
//array_push($a, $b);
echo "<br> \$a[] = \$b; <br>";
$a[] = $b;
print_r($a);

echo "<br> \$a = array(); <br>";

$a = array();
print_r($a);

echo '$a = array("apple", "banana");
$b = array(1 => "banana", "0" => "apple");
$c = array(0 => "apple", 1 => "banana"); <br><br>';

$a = array("apple", "banana");
$b = array(1 => "banana", "0" => "apple");
$c = array(0 => "apple", 1 => "banana");

echo 'var_dump($a == $b); // bool(true)
var_dump($a === $b); // bool(false)"; 
var_dump($a === $c); // bool(true) <br><br>';

var_dump($a == $b); // bool(true)
var_dump($a === $b); // bool(false)
var_dump($a === $c); // bool(false)


$arrCadena = array();

$arrCadena[] = "cadena = 1";
$arrCadena[] = "cadena2 = 3";
$arrCadena[] = "cadena3 = 3";


echo '<br>$arrCadena[] = "cadena = 1" <br>
$arrCadena[] = "cadena2 = 3" <br>
$arrCadena[] = "cadena3 = 3<br>';

echo "<br>count(\$arrCadena) = " .count($arrCadena);

$strCadena = implode(",", $arrCadena);




echo '<br>$strCadena = implode(",", $arrCadena)' ;

echo '<br>echo $strCadena <br>' ;

echo $strCadena;


echo 'array("d"=>"lemon", "a"=>"orange", "b"=>"banana", "c"=>"apple") <br>' .
  'krsort($fruits);  <br>' .
  'foreach ($fruits as $key => $val) { <br>' .
  ' echo "$key = $val\n <br>"; ' .
  '} <br> <br>';

$fruits = array("d"=>"lemon", "a"=>"orange", "b"=>"banana", "c"=>"apple");
krsort($fruits);
foreach ($fruits as $key => $val) {
    echo "$key = $val\n";
}

$bines = array(
	'1'=> array(1,5),
	'3'=> array(3,4),
	'5'=> array(6,5)
	);
echo json_encode($bines);

/*
Array
(
    [a] => A
    [b] => B
    [c] => C
)
Array
(
    [a] => A
    [b] => B
    [g] => G
    [c] => C
)
*/
?>
