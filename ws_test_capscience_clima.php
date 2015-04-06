<?php

/**
* Codigo para consumir un servicio web (Web Service) por medio de NuSoap
* La distribucion del codigo es totalmente gratuita y no tiene ningun tipo de restriccion.
* Se agradece que mantengan la fuente del mismo.
*/
// Le indicamos a PHP que no muestre los Notices (por si el servicio no retorna datos)
// (esto se puede evitar preguntando si hay datos antes de mostrarlos)
//error_reporting(1);

// Inclusion de la libreria nusoap (la que contendra toda la conexión con el servidor
require_once('nusoap/nusoap.php');
$oSoapClient = new nusoap_client('http://live.capescience.com/wsdl/GlobalWeather.wsdl', true);
if ($sError = $oSoapClient->getError()) {
   echo "No se pudo realizar la operación [" . $sError . "]";
   die();
}

// Viene de un POST => Selecciono una ciudad
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $aParametros = array("code" => $_POST["codLocalidad"]);
   $aRespuesta = $oSoapClient->call("getWeatherReport", $aParametros);
}
else{
	$aParametros = array("code" => 25);
	$aRespuesta = $oSoapClient->call("getWeatherReport", $aParametros);
}

   // Existe alguna falla en el servicio?
   if ($oSoapClient->fault) { // Si
      echo 'No se pudo completar la operación';
      die();
   } 
   else { // No
      $sError = $oSoapClient->getError();
      // Hay algun error ?
      if ($sError) { // Si
         echo 'Error:' . $sError;
      }
}
?>
<html>
   <body>
      <table width="367" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td colspan="2"><div align="center">Datos del tiempo</div></td>
      </tr>
      <tr>
         <td width="147"> </td>
         <td width="220"> </td>
      </tr>
      <tr>
         <td>Nombre:</td>
         <td><?=$aRespuesta["station"]["name"];?></td>
      </tr>
      <tr>
         <td>Elevación:</td>
         <td><?=$aRespuesta["station"]["elevation"]; ?></td>
      </tr>
      <tr>
         <td>Fecha y Hora:</td>
         <td><?=$aRespuesta["timestamp"];?></td>
      </tr>
      <tr>
         <td>País:</td>
         <td><?=$aRespuesta["station"]["country"];?></td>
      </tr>
     <tr>
         <td>Latitud:</td>
         <td><?=$aRespuesta["station"]["latitude"];?></td>
      </tr>
         <tr>
      <td>Longitud:</td>
         <td><?=$aRespuesta["station"]["longitude"];?></td>
      </tr>
      <tr>
         <td>Presión:</td>
         <td><?=$aRespuesta["pressure"]["string"];?></td>
      </tr>
      <tr>
         <td>Temperatura:</td>
         <td><?=$aRespuesta["temperature"]["string"];?></td>
   	</tr>
      <tr>
         <td>Visibilidad:</td>
         <td><?=$aRespuesta["visibility"]["distance"];?> mts.</td>
      </tr>
      </table>
   </body>
</html> 