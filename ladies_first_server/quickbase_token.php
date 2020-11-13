<?php 
error_reporting(0);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// For Json Quickbase API Call for ladies First.
$access_token = 'your access token goes here';
$quickbase_domain = 'hackathon20-fesedo.quickbase.com';

//For XML Quickbase API Call for Ladies First.
$auth_ticket ='Your auth ticket goes here';
$udata_from_ticket ='62346645.dzbr';
$app_token ='your app token goes here';
$target_domain_url ='https://hackathon20-fesedo.quickbase.com';
$appID ='bqyb6cxvm';

?>