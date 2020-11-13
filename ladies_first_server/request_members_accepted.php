<?php
error_reporting(0);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


//include quickbase token
include('quickbase_token1.php');
include('quickbase_tables.php');



$user_email = strip_tags($_GET['user_email']);

//$res1 = $db->prepare("SELECT * FROM needy_users_connection where reciever_email=:reciever_email ");
//$res1->execute(array('reciever_email' => $user_email));



$reciever_email_field = 17;
$url3 = "https://api.quickbase.com/v1/records/query";
$ch3 = curl_init();
curl_setopt($ch3,CURLOPT_URL, $url3);
$useragent3 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

$data_params3 ='{
  "from": "'.$table_users_connection.'",
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
14,
15,
16,
17


  ],

  "where": "{'.$reciever_email_field .'.CT.'.$user_email.'}"

}
';





curl_setopt($ch3, CURLOPT_HTTPHEADER, array(
"QB-Realm-Hostname: $quickbase_domain",
"User-Agent: $useragent3",
"Authorization: QB-USER-TOKEN $access_token",
'Content-Type:application/json'
));  

//curl_setopt($ch3,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch3,CURLOPT_CUSTOMREQUEST,'POST');

//curl_setopt($ch3,CURLOPT_CUSTOMREQUEST,'DELETE');
curl_setopt($ch3,CURLOPT_POSTFIELDS, $data_params3);
curl_setopt($ch3,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch3,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch3,CURLOPT_RETURNTRANSFER, true);
$response3 = curl_exec($ch3);

curl_close($ch3);

//print_r($response3);
$json3 = json_decode($response3, true);

$rec_List1 = $json3["metadata"]["numRecords"];


if($rec_List1 > 0){
//$count = 1;

foreach($json3['data'] as $v1){


$id = $v1['3']['value'];
$sender_userid =  $v1['6']['value'];
$sender_fullname1 =  $v1['7']['value'];
$sender_photo =  $v1['8']['value'];
$sender_email =  $v1['9']['value'];
$department =  $v1['15']['value'];

// replace empty space with hyphen
$sender_fullname = str_replace(' ', '-', $sender_fullname1);

$status =  $v1['14']['value'];
$message_counter =  $v1['16']['value'];


$result_array[] = array(
"id" => $id,
"sender_userid" => $sender_userid,
"sender_fullname" => $sender_fullname,
"sender_photo" => $sender_photo,
"sender_email" => $sender_email,
"department" => $department,
"message_counter" => $message_counter



);
}

}

echo json_encode($result_array);