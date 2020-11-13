<?php

error_reporting(0);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

ini_set('max_execution_time', 300); //300 seconds = 5 minutes
// temporarly extend time limit
set_time_limit(300);


//include quickbase token
include('quickbase_token.php');
include('quickbase_tables.php');


$post_id=strip_tags($_POST['post_id']);
$reciever_id=strip_tags($_POST['userid']);

$timer = time();
$tmm = timer;


$userid_sess_data = $_POST['userid_sess_data'];
$fullname_sess_data = $_POST['fullname_sess_data'];
$photo_sess_data = $_POST['photo_sess_data'];
$username_sess_data = $_POST['username_sess_data'];


if($reciever_id == $userid_sess_data){
//Ensure that user cannot send request to her self
echo 3;
exit();
}



//check if user has already sent Friend/Chat Request to this User

$userid_field =  6;
$reciever_id_field =  11;

$url3 = "https://api.quickbase.com/v1/records/query";
$ch3 = curl_init();
curl_setopt($ch3,CURLOPT_URL, $url3);
$useragent3 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

$data_params3 ='{
  "from": "'.$table_users_temp.'",
  "select": [
3,
    6,
    7,
    8,
    9,
    10,
11
  ],

  "where": "{'.$userid_field.'.CT.'.$userid_sess_data.'}AND{'.$reciever_id_field.'.CT.'.$reciever_id.'}"

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

$res_count = $json3["metadata"]["numRecords"];


if($res_count >  0){
// check if user has already sent request before
echo 2;
exit();
}






//check if user has already sent Friend/Chat Request to this User 2

$userid_field =  6;
$reciever_id_field =  11;

$url4 = "https://api.quickbase.com/v1/records/query";
$ch4 = curl_init();
curl_setopt($ch4,CURLOPT_URL, $url4);
$useragent4 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

$data_params4 ='{
  "from": "'.$table_users_temp.'",
  "select": [
3,
    6,
    7,
    8,
    9,
    10,
11
  ],

  "where": "{'.$userid_field.'.CT.'.$reciever_id.'}AND{'.$reciever_id_field.'.CT.'.$userid_sess_data.'}"

}
';





curl_setopt($ch4, CURLOPT_HTTPHEADER, array(
"QB-Realm-Hostname: $quickbase_domain",
"User-Agent: $useragent4",
"Authorization: QB-USER-TOKEN $access_token",
'Content-Type:application/json'
));  

//curl_setopt($ch4,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch4,CURLOPT_CUSTOMREQUEST,'POST');

//curl_setopt($ch4,CURLOPT_CUSTOMREQUEST,'DELETE');
curl_setopt($ch4,CURLOPT_POSTFIELDS, $data_params4);
curl_setopt($ch4,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch4,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch4,CURLOPT_RETURNTRANSFER, true);
$response3 = curl_exec($ch4);

curl_close($ch4);

//print_r($response4);
$json4 = json_decode($response4, true);

$res_count4 = $json4["metadata"]["numRecords"];


if($res_count4 >  0){
// check if user has already sent request before
echo 2;
exit();
}






// insert into users_temporal tables starts

$url2a="https://api.quickbase.com/v1/records";
$ch2a = curl_init();
curl_setopt($ch2a,CURLOPT_URL, $url2a);
$useragent2a ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';


$utemp_userid_field = 6;
$utemp_username_field = 7;
$utemp_fullname_field = 8;
$utemp_user_rank_field = 9;
$utemp_photo_field = 10;
$utemp_reciever_id_field = 11;
$utemp_status_field = 12;


$post_add_a='

{
  "to": "'.$table_users_temp.'",
  "data": [
    {


      "'.$utemp_userid_field.'": {
        "value": "'.$userid_sess_data.'"
      },
      "'.$utemp_username_field.'": {
        "value": "'.$username_sess_data.'"
      },
"'.$utemp_fullname_field.'": {
        "value": "'.$fullname_sess_data.'"
      },
"'.$utemp_user_rank_field.'": {
        "value": "'.$user_rank_sess_data.'"
      },
 "'.$utemp_photo_field.'": {
        "value": "'.$photo_sess_data.'"
      },
 "'.$utemp_reciever_id_field.'": {
        "value": "'.$reciever_id.'"
      },
"'.$utemp_status_field.'": {
        "value": "0"
      }
 
 




    }
  ],

 "fieldsToReturn": [
3,
    6,
    7,
    8,
    9,
    10,
11,
12


  ]

}

';


curl_setopt($ch2a, CURLOPT_HTTPHEADER, array(
"QB-Realm-Hostname: $quickbase_domain",
"User-Agent: $useragent2a",
"Authorization: QB-USER-TOKEN $access_token",
'Content-Type:application/json'
));  

//curl_setopt($ch2a,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch2a,CURLOPT_CUSTOMREQUEST,'POST');

//curl_setopt($ch2a,CURLOPT_CUSTOMREQUEST,'DELETE');
curl_setopt($ch2a,CURLOPT_POSTFIELDS, $post_add_a);
curl_setopt($ch2a,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch2a,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch2a,CURLOPT_RETURNTRANSFER, true);
$response2a = curl_exec($ch2a);

curl_close($ch2a);

//print_r($response2a);
$json2a = json_decode($response2a, true);
$statement= $json2a["metadata"]["totalNumberOfRecordsProcessed"];

// get last inserted Id for users temp table
$lastId_temp  = $json2a['data'][0]['3']['value'];

// insert into temporal table ends







// insert into notification_request table starts
$url2b="https://api.quickbase.com/v1/records";
$ch2b = curl_init();
curl_setopt($ch2b,CURLOPT_URL, $url2b);
$useragent2b ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

//nrt is notification_request table

$nrt_user_temp_table_id_field = 6;
$nrt_userid_field = 7;
$nrt_fullname_field = 8;
$nrt_photo_field = 9;
$nrt_user_rank_field = 10;
$nrt_reciever_id_field = 11;
$nrt_status_field = 12;
$nrt_type_field = 13;
$nrt_timing_field = 14;




$post_add_b='

{
  "to": "'.$table_notification_request.'",
  "data": [
    {


      "'.$nrt_user_temp_table_id_field .'": {
        "value": "'.$lastId_temp.'"
      },
      "'.$nrt_userid_field.'": {
        "value": "'.$userid_sess_data.'"
      },
"'.$nrt_fullname_field.'": {
        "value": "'.$fullname_sess_data.'"
      },
 "'.$nrt_photo_field.'": {
        "value": "'.$photo_sess_data.'"
      },
"'.$nrt_user_rank_field.'": {
        "value": "'.$user_rank_sess_data.'"
      },
 "'.$nrt_reciever_id_field.'": {
        "value": "'.$reciever_id.'"
      },
"'.$nrt_status_field.'": {
        "value": "0"
      },
"'.$nrt_type_field.'": {
        "value": "sent"
      },
"'.$nrt_timing_field.'": {
        "value": "'.$timer.'"
      }
 
 




    }
  ],

 "fieldsToReturn": [
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


  ]

}

';


curl_setopt($ch2b, CURLOPT_HTTPHEADER, array(
"QB-Realm-Hostname: $quickbase_domain",
"User-Agent: $useragent2b",
"Authorization: QB-USER-TOKEN $access_token",
'Content-Type:application/json'
));  

//curl_setopt($ch2b,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch2b,CURLOPT_CUSTOMREQUEST,'POST');

//curl_setopt($ch2b,CURLOPT_CUSTOMREQUEST,'DELETE');
curl_setopt($ch2b,CURLOPT_POSTFIELDS, $post_add_b);
curl_setopt($ch2b,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch2b,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch2b,CURLOPT_RETURNTRANSFER, true);
$response2b = curl_exec($ch2b);

curl_close($ch2b);

//print_r($response2b);
$json2b = json_decode($response2b, true);
$stmt_b= $json2b["metadata"]["totalNumberOfRecordsProcessed"];


// get last inserted Id for notificatio_request table
$lastId_b= $json2b['data'][0]['3']['value'];

// insert into notification_request table ends



if($stmt_b == 1) {

echo 1;
}
 else{
echo 0;
}














?>


