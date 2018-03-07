	<?php
$arrvalor = array();
$arrvalor[0];
$arrvalor[1] = "";
$arrvalor[2] = null;

if (empty($arrvalor[0]) )
	echo "entro empty nada <br>";
if (empty($arrvalor[1]) )
	echo "entro empty vacio <br>";
if (empty($arrvalor[2]) )
	echo "entro empty null <br>";

echo "<br><br>";

if (isset($arrvalor[0]) )
	echo "entro isset nada <br>";
if (isset($arrvalor[1]) )
	echo "entro isset vacio <br>";
if (isset($arrvalor[2]) )
	echo "entro isset null <br>";

echo "<br><br>";

if ($arrvalor[0] == "" )
	echo "entro isset nada <br>";
if ($arrvalor[1] == "" )
	echo "entro isset vacio <br>";
if ($arrvalor[2] == "" )
	echo "entro isset null <br>";

echo "<br><br>";

if ($arrvalor[0] == NULL )
	echo "entro isset nada <br>";
if ($arrvalor[1] == NULL )
	echo "entro isset vacio <br>";
if ($arrvalor[2] == NULL )
	echo "entro isset null <br>";

echo "<br><br>";

if ($arrvalor[0] == false )
	echo "entro isset nada <br>";
if ($arrvalor[1] == false )
	echo "entro isset vacio <br>";
if ($arrvalor[2] == false )
	echo "entro isset null <br>";
