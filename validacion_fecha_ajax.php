<script language = 'javascript' type='text/javascript'>

function gebi(name){
	 return document.getElementById(name)
}

function nuevoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
		}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}


function valida_fecha(){
	var ano, mes, dia;
	alert(gebi('fecha').value);
	ano = parseInt(gebi('fecha').value.substring(0,4));
	mes = gebi('fecha').value.substring(5,7);
	dia = gebi('fecha').value.substring(8,10);
	fec_valida = false;
	ajax=nuevoAjax();
	ajax.open("GET", "ajax_valida_fecha.php?ano="+ano+"&mes="+mes+"&dia="+dia, true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
		fec_valida = ajax.responseText
	 	}
	}
	ajax.send(null)
	
	alert ("fecha valida = "+fec_valida);
	return fec_valida
}


</script>


<html>
<head>
<title></title>
</head>

<body>
<form action='<?=$PHP_SELF?>' method="get" name="formulario" onsubmit='return valida_fecha();'>
	Fecha: <input type="text" name="fecha" id="fecha" />
	<input type="button" onClick = "return valida_fecha();"/>
</form>
</body>

</html>
