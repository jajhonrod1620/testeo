<?php
if(isset($_POST["iddpto"]))
	{
		$opciones = '<option value="0"> Elige una Ciudad</option>';

		$conexion = pg_connect("host=192.168.2.122 port=5432 dbname=fna_credito_20140507 user=root password=");
		$strConsulta = "SELECT conciudad, ciudad, nomciudad FROM ciudades WHERE dpto = ".$_POST["iddpto"];
		$result = pg_query($conexion,$strConsulta);
		

		while( $fila = pg_fetch_array($result) )
		{
			$opciones.='<option value="'.$fila["conciudad"].'">'.$fila["nomciudad"].'</option>';
		}

		echo $opciones;
	}
?>