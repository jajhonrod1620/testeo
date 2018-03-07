<?php

$a = '12345';

// This works:
echo "qwe{$a}rty"; // qwe12345rty, using braces
echo "<br>";

echo "qwe" . $a . "rty"; // qwe12345rty, concatenation used
echo "<br>";

// Does not work:
echo 'qwe{$a}rty'; // qwe{$a}rty, single quotes are not parsed
echo "<br>";
echo "qwe$arty"; // qwe, because $a became $arty, which is undefined
echo "<br>";

?>
