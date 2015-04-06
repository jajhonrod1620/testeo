<?php
if($_GET["boton"] == "Enviar"){
	echo "<br>".$_GET["user"];
	if($_GET["reprograma_oblig"] == null){
		echo "Unchecked <br>".$_GET["reprograma_oblig"];
		echo var_dump($_GET["reprograma_oblig"]);
	}
	else
		echo "<br> Checked  ".$_GET["reprograma_oblig"];
}

?>
<script type='text/javascript' language='text/javascript'>
function gebi(name){
	return document.getElementById(name)
}
function vervalores(){
	if(gebi('reprograma_oblig').checked == false){
		alert("No seleccionado reprogramado ");
	}
	else{
		var reprogramaoblig = gebi('reprograma_oblig').value;
		alert("Valor reprogramado "+reprogramaoblig);
	}
	return true
}
</script>

<form name="input" action="" method="get">
consulta: <input type="text" name="user" />
Nueva consulta: <input type='checkbox' name = 'reprograma_oblig'  id = 'reprograma_oblig' value = 'S' >
<input name="boton" onclick="return vervalores();" type="submit" value="Enviar" />
</form>
