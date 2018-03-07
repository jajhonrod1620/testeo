<?php
//** CREAMOS LA FUNCI?N ***//
function suma($params){
	
	//$params --> Es un objeto que es enviado que contiene los par?metros via WSDL
	//Accedemos a los par?metros de la siguiente forma:
	
	$operador1 = $params->a;
	$operador2 = $params->b;
	
	$suma = $operador1 + $operador2;
	
	//Como la respuesta es v?a SOAP pues se tiene que convertir a un Objeto soap v?lido
	$response = new SoapVar($suma,XSD_INT);	
	//Devolvemos la Variable SOAP
	return $response;
}//function

ini_set("soap.wsdl_cache_enabled", "0"); 
//Creamos el objeto Servidor, indicando a que archivo WSDL apunta, ya que ah? a sido declarada su operaci?n y la URN del WSDL, tamb?en la versi?n de SOAP que se utiliza.
$sServer = new SoapServer('basic.wsdl', array('actor'=>'urn:BasicAPI', 'soap_version' => SOAP_1_2));
//Se declara la funci?n 
$sServer->addFunction("suma");
$sServer->handle();

?>