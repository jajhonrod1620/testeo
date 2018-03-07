<?php
if(isset($_POST["ciudad"]))
	{
		$opciones = '<option value="0"> Elige una Notaria</option>';

		$conexion = pg_connect("host=192.168.2.122 port=5432 dbname=fna_credito_20140507 user=root password=");
		$strConsulta = "SELECT cod_notaria, notaria FROM notarias WHERE ".
			"ltrim(cod_dpto||cod_munucipio, '0') like '". $_POST["ciudad"] . "'";
		echo $strConsulta;
		$result = pg_query($conexion,$strConsulta);
		

		while( $fila = pg_fetch_array($result) )
		{
			$opciones.='<option value="'.$fila["cod_notaria"].'">'.$fila["notaria"].'</option>';
		}

		echo $opciones;
	}
?>