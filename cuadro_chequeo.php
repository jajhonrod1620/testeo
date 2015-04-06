<?php
if($accion!="")
{
	echo "<br>".$bike;
}
?>
<!DOCTYPE html>
<html>
<head>
<script type="text/javascript">
function displayResult()
{
	var x=document.getElementById("bike").value;
	alert(x);
}

</script>
</head>
<body>

<form action "cuadro_chequeo.php">
	<input type="checkbox" id="bike"  name="bike" value="Bike" /> I have a bike<br />
	<input type="submit" name='accion' onclick="displayResult()" value = "guardar" />Display value 
</form>
</body>
</html>
