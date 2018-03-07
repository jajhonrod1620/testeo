<?php
	$_SESSION['usubd']="root";
	$_SESSION['dbdriver']="postgres";
	$_SESSION['database']="fna_credito_20140507";
	$_SESSION['servidor']="192.168.2.122";

	include_once('/var/www/html/padminfo/includes/funciones_genericas.php');
	//$conexion = pg_connect("host=192.168.2.122 port=5432 dbname=fna_credito_20140507 user=root password=");
	$strConsulta = "SELECT coddpto, nombredpto FROM dptos";
	//$result = pg_query($conexion,$strConsulta);
	//print_r($result);
	$result = query($_SESSION['database'],$strConsulta, 0, 0);
	$opciones = '<option value="0"> Elige una Depto</option>';
	for($r = 0; $r < $result->RecordCount(); $r++){
		$opciones.='<option value="'.$result->fields["coddpto"].'">'.$result->fields["nombredpto"].'</option>';
		$result->MoveNext();
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Selects combinados JQuery + Ajax + PHP + Postgres</title>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#dpto").change(function(){
					$.ajax({
						url:"selectciudad.php",
						type: "POST",
						data:"iddpto="+$("#dpto").val()+"&usuario=<?php echo $_SESSION['usubd']; ?>",
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
