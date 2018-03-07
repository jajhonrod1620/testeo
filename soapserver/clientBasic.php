<?php
$operando1 = 30;
$operando2 = 34;

//PARA LLAMAR A UN SERVICIO WEB DEBEMOS DE PONERLO EN UN BLOQYE TRY CATCH,
//UN SERVICIO WEB ES MUY PROCLIBE A CAER EN ERRORES Y LOS BLOQUES TRY CATCH,
//NOS AYUDARAN A DEPURARLOS
try {
	//INDICAMOS DONDE ESTA EL WSDL QUE VAMOS A CONSULTAR Y CREAMOS EL OBJETO CLIENT
	$sClient  = new SoapClient('http://localhost/soapserver/basic.wsdl');

	//CREAMOS EL OBJETO REQUEST DONDE DECLARAMOS EL ARRAY QUE CONTIENE NUESTROS
	//PARAMETROS A Y B QUE ESTAN DECLARADOS EN EL WSDL Y USADOS POR EL SCRIPT
	//DE NUESTRO SERVIDOR
	$request = new SoapVar(array( 'a'=>$operando1,
				                  'b'=>$operando2
				            ),SOAP_ENC_OBJECT);
    //LLAMAMOS AL PROCEDIMIENTO Y CAPTURAMOS SU 
    //VALOR DE RETORNO EN LA VARIABLE RESPONSE			            
	$response = $sClient->suma($request);
			
}catch (SoapFault  $e){
		//EN CASO DE QUE HUBO ALGUN ERROR EL BLOQUE CATCH LO CAPTURA
		//EN EL CAPITULO DE MANEJO AVANZADO VEREMOS COMO CAPTURAR LOS SOAPFAULTS
		echo 'Hubo un error';
}//catch		

//MOSTRAMOS EL RESULTADO
echo 'La Suma es:'.$response;			
	
?>