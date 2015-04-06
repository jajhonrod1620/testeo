<?php
if($_GET["boton"] == "Enviar"){
	
	if( is_numeric($_GET["user"]))
		echo "<br> Es numerico ";
	else echo"<br> No es  numerico";
	$_GET["user"] = is_numeric($_GET["user"])?$_GET["user"]:0;
	
	echo 
	"<br>".$_GET["user"];
}

?>

<form name="input" action="" method="get">
consulta: <input type="text" name="user" />
<input name="boton" type="submit" value="Enviar" />
</form>
