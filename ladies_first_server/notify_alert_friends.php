<?php
error_reporting(0);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


//include quickbase token
include('quickbase_token.php');
include('quickbase_tables.php');

$userid_sess_data = $_POST['userid_sess_data'];
//echo "I am: $userid_sess_data ";

//nrt is notification request table

$nrt_reciever_id_field =11;
$nrt_status_field = 12;
$nrt_status_value = 0;

$url_nrt = "https://api.quickbase.com/v1/records/query";
$ch_nrt = curl_init();
curl_setopt($ch_nrt,CURLOPT_URL, $url_nrt);
$useragent_nrt ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

$data_params_nrt ='{
  "from": "'.$table_notification_request.'",
  "select": [
3,
    6,
    7,
    8,
    9,
    10,
11,
12,
13,
14

  ],

  "where": "{'.$nrt_reciever_id_field.'.CT.'.$userid_sess_data.'}"

}
';





curl_setopt($ch_nrt, CURLOPT_HTTPHEADER, array(
"QB-Realm-Hostname: $quickbase_domain",
"User-Agent: $useragent_nrt",
"Authorization: QB-USER-TOKEN $access_token",
'Content-Type:application/json'
));  

//curl_setopt($ch_nrt,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch_nrt,CURLOPT_CUSTOMREQUEST,'POST');

//curl_setopt($ch_nrt,CURLOPT_CUSTOMREQUEST,'DELETE');
curl_setopt($ch_nrt,CURLOPT_POSTFIELDS, $data_params_nrt);
curl_setopt($ch_nrt,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch_nrt,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch_nrt,CURLOPT_RETURNTRANSFER, true);
$response_nrt = curl_exec($ch_nrt);

curl_close($ch_nrt);

//print_r($response_nrt);
$json_nrt = json_decode($response_nrt, true);
$count_nrt = $json_nrt["metadata"]["numRecords"];


echo $count_nrt;


?>

