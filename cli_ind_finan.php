<?php
require_once('nusoap/nusoap.php');
$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';

$client = new nusoap_client('http://www.desachile.com/webservice.asmx?WSDL', 'wsdl',$proxyhost, $proxyport, $proxyusername, $proxypassword);
$err = $client->getError();
if ($err) {
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}
$param = array('Fecha' => '20081010');
$result = $client->call('Indicadores', $param, '', '', false, true);

if ($client->fault) {
    echo '<h2>Fault</h2><pre>';
    print_r($result);
    echo '</pre>';
} 
else {
    $err = $client->getError();
    if ($err) {
        echo '<h2>Error</h2><pre>' . $err . '</pre>';
    } 
    else {
        echo '<h2>Result</h2><pre>';
        print_r($result);
        echo '</pre>';
    }
}

$indicadores =  $result['IndicadoresResult']['diffgram']['NewDataSet']['indicadores'];

echo 'UTM  = '.$indicadores['utm'].'<br>';
echo 'UF   = '.$indicadores['uf'].'<br>';
echo 'USD  = '.$indicadores['usd'].'<br>';
echo 'EURO = '.$indicadores['euro'].'<br>';
?>