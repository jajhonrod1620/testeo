<?php
// Pull in the NuSOAP code
require_once('nusoap/nusoap.php');
// Create the client instance
$client = new nusoap_client('http://127.0.0.1/testeo/serv_prueba_nusoap.php');
// Check for an error
$err = $client->getError();
if ($err) {
    // Display the error
    echo '<p><b>Constructor error: ' . $err . '</b></p>';
    // At this point, you know the call that follows will fail
}
// Call the SOAP method
$result = $client->call('hello', array('name' => 'Scott'));
// Check for a fault
if ($client->fault) {
    echo '<p><b>Fault: ';
    print_r($result);
    echo '</b></p>';
} else {
    // Check for errors
    $err = $client->getError();
    if ($err) {
        // Display the error
        echo '<p><b>Error: ' . $err . '</b></p>';
    } else {
        // Display the result
        print_r($result);
    }
}
?>