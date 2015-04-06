<?php
// Include Mailjet's API Class
include_once('php-mailjet.class-mailjet-0.1.php');
 
// Create a new Object
$mj = new Mailjet();
 
// Get some of your account informations
$me = $mj->userInfos();
 
// Display your firstname
echo $me->infos->firstname."<br>";
echo $mj->apiUrl."<br>";

# Parameters
$params = array(
    'method' => 'GET',
    'subject' => 'Your subject',
    'list_id' => '123',
    'lang' => 'en',
    'from' => 'importador@solati.com.co',
    'from_name' => 'Your name',
    'footer' => 'default'
);
 
# Call
$response = $mj->messageCreateCampaign($params);
 
# Result
$id = $response->campaign->id;
$url = $response->campaign->url;

/*
$params = array(
    'method' => 'POST',
    'id' => $id
);
 
# Call
$response = $mj->messageSendCampaign($params);
*/
