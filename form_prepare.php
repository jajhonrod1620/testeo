<?php
if($_GET["boton"] == "Enviar"){
	include('prepare.php');
	echo prepare($_GET["user"]);
}

?>

<form name="input" action="" method="get">
consulta: <input type="text" name="user" />
<input name="boton" type="submit" value="Enviar" />
</form>
