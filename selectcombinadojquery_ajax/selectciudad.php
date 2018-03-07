<?php
	$_SESSION['usubd']= $_POST["usuario"];
	$_SESSION['dbdriver']= "postgres";
	$_SESSION['database']= "fna_credito_20140507";
	$_SESSION['servidor']= "192.168.2.122";
if(isset($_POST["iddpto"]))
{
	include_once('/var/www/html/padminfo/includes/funciones_genericas.php');
	$opciones = '<option value="0"> Elige una Ciudad</option>';
	$strConsulta = "SELECT conciudad, ciudad, nomciudad FROM ciudades WHERE dpto = ".$_POST["iddpto"];
	$result = query($_SESSION['database'], $strConsulta, 0, 0);
	for($r = 0; $r < $result->RecordCount(); $r++){
		$opciones.='<option value="'.$result->fields["conciudad"].'">'.$result->fields["nomciudad"].'</option>';
		$result->MoveNext();
	}
		echo $opciones;
}
?>