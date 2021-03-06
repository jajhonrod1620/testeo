<?php
/**
* Codigo para consumir un servicio web (Web Service) por medio de NuSoap.
* La distribucion del codigo es totalmente gratuita y no tiene ningun tipo de restriccion.
* Se agradece que mantengan la fuente del mismo.
*/
$sPais = "argentina";
// Nombre del pais que queremos el listado de localidades

// Inclusion de la libreria nusoap (la que contendra toda la conexión con el servidor
require_once('nusoap/nusoap.php');

//$oSoapClient = new soapclient('http://live.capescience.com/wsdl/GlobalWeather.wsdl', true);
$oSoapClient = new nusoap_client('http://live.capescience.com/wsdl/GlobalWeather.wsdl', true);

if ($sError = $oSoapClient->getError()) {
echo "No se pudo realizar la operación [" . $sError . "]";
die();
}
$aParametros = array("country" => $sPais);
$respuesta = $oSoapClient->call("searchByCountry", $aParametros);

// Existe alguna falla en el servicio?
if ($oSoapClient->fault) { // Si
echo 'No se pudo completar la operación';
die();
} else { // No
$sError = $oSoapClient->getError();
// Hay algun error ?
if ($sError) { // Si
echo 'Error: ' . $sError;
die();
}
}
?>
<html>
<head>
<title>Seleccionar localidad</title>
</head>
<body>
<form action="mostrarPronostico.php" method="post" name="frmLocalidades" id="frmLocalidades">
<table width="400" border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="2" align="center">Seleccione una localidad</td>
</tr>
<tr>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
</tr>
<tr>
<td align="right">Localidad:&nbsp;</td>
<td>
<select name="codLocalidad" id="codLocalidad">
<?php
// Recorremos el array (wmo es la clave que necesitamos para el proximo script)
foreach ($respuesta as $iClave => $aElemento)
echo "<option value='".$aElemento["wmo"]."'>".$aElemento["name"]."</option>";
?>
</select>
</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" name="Submit" value="Quiero ver el pronostico"></td>
</tr>
</table>
</form>
</body>
</html>