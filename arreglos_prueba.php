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
