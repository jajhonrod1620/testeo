<?php
	$_SESSION['usubd']="root";
	$_SESSION['dbdriver']="postgres";
	$_SESSION['database']="fna_credito_20140507";
	$_SESSION['servidor']="192.168.2.122";
if(isset($_POST["ciudad"]))
{
	include_once('/var/www/html/padminfo/includes/funciones_genericas.php');
	$opciones = '<option value="0"> Elige una Notaria</option>';
	$strConsulta = "SELECT cod_notaria, notaria FROM notarias WHERE ".
		"ltrim(cod_dpto||cod_munucipio, '0') like '". $_POST["ciudad"] . "'";

	$result = query($_SESSION['database'], $strConsulta, 0, 0);

	for($r = 0; $r < $result->RecordCount(); $r++){
		$opciones.='<option value="'.$result->fields["cod_notaria"].'">'.$result->fields["notaria"].'</option>';
		$result->MoveNext();
	}
	echo $opciones;
}
?>