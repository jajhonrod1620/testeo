<!DOCTYPE html>
<html>
<head>
  <style>
  p { color:red; margin:4px; }
  b { color:blue; }
  </style>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script>
	var myWindow;
	function openWin()
	{
		myWindow=window.open('','view','width=200,height=100');
		myWindow.document.write("<p>This window's name is: " + myWindow.name + "</p>");
	}

	function showin()
	{
		alert("window's name is: " + window.name );
	}

</script>
</head>
<body>
	<form action="<?php echo $PHP_SELF ?>" method="post">

<?php
	echo "<pre>";
	print_r($arreglos_alianzas);
	?>
	<tr title = 'Mantenga presionada la tecla Ctrl para seleccionar varias opciones'>
	<td>ALIANZA</td>
	</tr>
	<tr><td>
		
	<select multiple="multiple" name="cars[]">
		<option value="">Nada</option>
		<option value="volvo">Volvo</option>
		<option value="saab">Saab</option>
		<option value="opel">Opel</option>
		<option value="audi">Audi</option>
	</select>
	</td>
	</tr>
	<input type="submit">
	<button id = "arreglo" name ="arreglo">Alert</button>
	<input type="button" value="Open 'myWindow'" onclick="openWin()" />
	<input type="button" value="Show 'myWindow'" onclick="showin()" />
</form>
<script>
function valoresarreglo(){
  alert( $("#cars").val() || []);
  multipleselects = $("#cars").val() || [];
  if(multipleselects == '')
	alert("ENTRO");

}
$("#arreglo").click(valoresarreglo);
</script>

</body>
</html>
