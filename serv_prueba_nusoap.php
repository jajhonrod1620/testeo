<?php
ini_set("soap.wsdl_cache_enabled", "0");	
// Pull in the NuSOAP code
require_once('nusoap/nusoap.php');
// Enable debugging *before* creating server instance
$debug = 1;
// Create the server instance
$server = new soap_server;
// Register the method to expose
$server->register('hello');
// Define the method as a PHP function
function hello($name) {
    return 'Hello, ' . $name;
}
// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>