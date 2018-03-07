<?php
	$conexion = pg_connect("host=192.168.2.122 port=5432 dbname=fna_credito_20140507 user=root password=");
	$strConsulta = "SELECT coddpto, nombredpto FROM dptos";
	$result = pg_query($conexion,$strConsulta);
	//print_r($result);
	$opciones = '<option value="0"> Elige una Depto</option>';
	while( $fila = pg_fetch_array($result) )
	{
		$opciones.='<option value="'.$fila["coddpto"].'">'.$fila["nombredpto"].'</option>';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Selects combinados JQuery + Ajax + PHP + Postgres</title>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#dpto").change(function(){
					$.ajax({
						url:"selectciudad.php",
						type: "POST",
						data:"iddpto="+$("#dpto").val(),
						success: function(opciones){
							$("#ciudad").html(opciones);
						}
					})
				});
				$("#ciudad").change(function(){
					$.ajax({
						url:"selectnotaria.php",
						type: "POST",
						data:"ciudad="+$("#ciudad").val(),
						success: function(opciones){
							$("#notaria").html(opciones);
						}
					})
				});
			});
		</script>
    </head>
    <body>
			<div> Selects combinados </div>
			<label> Depto:</label> 
			<select id="dpto">
				<?php echo $opciones; ?>
			</select> <br>
			<label> Ciudad:</label>
			<select id="ciudad">
				<option value="0">Elige una ciudad</option>
			</select>
			<label> Notaria:</label>
			<select id="notaria">
				<option value="0">Elige una notaria</option>
			</select>
    </body>
</html>