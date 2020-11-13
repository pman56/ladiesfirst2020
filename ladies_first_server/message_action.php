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



$timer = time();
include("time/now.fn");
$created_time=strip_tags($now);
$dt2=date("Y-m-d H:i:s");


$connection_id = strip_tags($_POST['connection_id']);
$rid = strip_tags($_POST['rid']);
$messaging = strip_tags($_POST['messaging']);

$userid_sess_data = strip_tags($_POST['userid_sess_data']);
$fullname_sess_data = strip_tags($_POST['fullname_sess_data']);
$photo_sess_data = strip_tags($_POST['photo_sess_data']);


        if($messaging !=''){
          
// get reciever data from users table
$url5 = "https://api.quickbase.com/v1/records/query";
$ch5 = curl_init();
curl_setopt($ch5,CURLOPT_URL, $url5);
$useragent5 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';


$rid_field= 3;


$post5 ='{
  "from": "'.$table_users.'",
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

  "where": "{'.$rid_field.'.CT.'.$rid.'}"

}
';


curl_setopt($ch5, CURLOPT_HTTPHEADER, array(
"QB-Realm-Hostname: $quickbase_domain",
"User-Agent: $useragent5",
"Authorization: QB-USER-TOKEN $access_token",
'Content-Type:application/json'
));  

//curl_setopt($ch5,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch5,CURLOPT_CUSTOMREQUEST,'POST');

//curl_setopt($ch5,CURLOPT_CUSTOMREQUEST,'DELETE');
curl_setopt($ch5,CURLOPT_POSTFIELDS, $post5);
curl_setopt($ch5,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch5,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch5,CURLOPT_RETURNTRANSFER, true);
$response5 = curl_exec($ch5);

curl_close($ch5);

//print_r($response5);
$json5= json_decode($response5, true);

$num_field5 = $json5["metadata"]["numFields"];
$num_rec5 = $json5["metadata"]["numRecords"];


$r_id = $json5["data"][0]["3"]["value"];
$r_fullname =$json5["data"][0]["8"]["value"];
$r_photo =$json5["data"][0]["10"]["value"];








//insert into message

$url2="https://api.quickbase.com/v1/records";
$ch2 = curl_init();
curl_setopt($ch2,CURLOPT_URL, $url2);
$useragent2 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';


$sender_photo_field = 6;
$sender_name_field =7;
$sender_id_field = 8;
$reciever_photo_field = 9;
$reciever_name_field =10;
$reciever_id_field = 11;
$message_field = 12;
$timing_field = 13;
$status_field = 14;
$message_counter_field = 15;

$post_add='

{
  "to": "'.$table_messages.'",
  "data": [
    {


      "'.$sender_photo_field.'": {
        "value": "'.$photo_sess_data.'"
      },
      "'.$sender_name_field.'": {
        "value": "'.$fullname_sess_data.'"
      },
"'.$sender_id_field.'": {
        "value": "'.$userid_sess_data.'"
      },

      "'.$reciever_photo_field.'": {
        "value": "'.$r_photo.'"
      },
      "'.$reciever_name_field.'": {
        "value": "'.$r_fullname .'"
      },
"'.$reciever_id_field.'": {
        "value": "'.$rid.'"
      },

 "'.$message_field.'": {
        "value": "'.$messaging.'"
      },

"'.$timing_field.'": {
        "value": "'.$timer.'"
      },

 "'.$status_field.'": {
        "value": "sent"
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


curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
"QB-Realm-Hostname: $quickbase_domain",
"User-Agent: $useragent2",
"Authorization: QB-USER-TOKEN $access_token",
'Content-Type:application/json'
));  

//curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'POST');

//curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'DELETE');
curl_setopt($ch2,CURLOPT_POSTFIELDS, $post_add);
curl_setopt($ch2,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch2,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch2,CURLOPT_RETURNTRANSFER, true);
$response2 = curl_exec($ch2);

curl_close($ch2);

//print_r($response2);
$json2 = json_decode($response2, true);
$statement= $json2["metadata"]["totalNumberOfRecordsProcessed"];


// get last inserted Id for message table
$lastId  = $json2['data'][0]['3']['value'];
$msgID = $lastId;






// query table users_connection to get message counter via senders and recievers id
$url5_m = "https://api.quickbase.com/v1/records/query";
$ch5_m = curl_init();
curl_setopt($ch5_m,CURLOPT_URL, $url5_m);
$useragent5_m ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';


$users_connect_id_field= 3;


$post5_m ='{
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
16

  ],

  "where": "{'.$users_connect_id_field.'.CT.'.$connection_id.'}"

}
';


curl_setopt($ch5_m, CURLOPT_HTTPHEADER, array(
"QB-Realm-Hostname: $quickbase_domain",
"User-Agent: $useragent5_m",
"Authorization: QB-USER-TOKEN $access_token",
'Content-Type:application/json'
));  

//curl_setopt($ch5_m,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch5_m,CURLOPT_CUSTOMREQUEST,'POST');

//curl_setopt($ch5_m,CURLOPT_CUSTOMREQUEST,'DELETE');
curl_setopt($ch5_m,CURLOPT_POSTFIELDS, $post5_m);
curl_setopt($ch5_m,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch5_m,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch5_m,CURLOPT_RETURNTRANSFER, true);
$response5_m = curl_exec($ch5_m);

curl_close($ch5_m);

//print_r($response5_m);
$json5_m= json_decode($response5_m, true);

$num_field5_m = $json5_m["metadata"]["numFields"];
$num_rec5_m = $json5_m["metadata"]["numRecords"];


$c_id_to_be_updated = $json5_m["data"][0]["3"]["value"];
$db_s_id =$json5_m["data"][0]["6"]["value"];
$db_r_id =$json5_m["data"][0]["10"]["value"];


//get counter info starts



$s_userid_field = 6;
$r_userid_field = 10;
  //"where": "{'.$sender1_userid_field.'.CT.'.$db_r_id.'}AND{'.$reciever1_userid_field.'.CT.'.$db_s_id.'}"


$url5_m = "https://api.quickbase.com/v1/records/query";
$ch5_m = curl_init();
curl_setopt($ch5_m,CURLOPT_URL, $url5_m);
$useragent5_m ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';


$users_connect_id_field= 3;


$post5_m ='{
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
16

  ],

  "where": "{'.$s_userid_field.'.CT.'.$db_r_id.'}AND{'.$R_userid_field.'.CT.'.$db_S_id.'}"

}
';


curl_setopt($ch5_m, CURLOPT_HTTPHEADER, array(
"QB-Realm-Hostname: $quickbase_domain",
"User-Agent: $useragent5_m",
"Authorization: QB-USER-TOKEN $access_token",
'Content-Type:application/json'
));  

//curl_setopt($ch5_m,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch5_m,CURLOPT_CUSTOMREQUEST,'POST');

//curl_setopt($ch5_m,CURLOPT_CUSTOMREQUEST,'DELETE');
curl_setopt($ch5_m,CURLOPT_POSTFIELDS, $post5_m);
curl_setopt($ch5_m,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch5_m,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch5_m,CURLOPT_RETURNTRANSFER, true);
$response5_m = curl_exec($ch5_m);

curl_close($ch5_m);

//print_r($response5_m);
$json5_m= json_decode($response5_m, true);

$num_field5_m = $json5_m["metadata"]["numFields"];
$num_rec5_m = $json5_m["metadata"]["numRecords"];


$counter_points=$json5_m["data"][0]["16"]["value"];
$new_count = 1;
$final_count = $counter_points + $new_count;

$sr_id_to_be_updated =  $json5_m["data"][0]["3"]["value"];

//get counter info ends




// update table users connnection starts here


$message_counter_field =16;

$url_update2 = "https://api.quickbase.com/v1/records";
$ch_update2 = curl_init();
curl_setopt($ch_update2,CURLOPT_URL, $url_update2);
$useragent_update2 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

$post_update2='

{
  "to": "'.$table_users_connection.'",
  "data": [
    {


      "'.$message_counter_field.'": {
        "value": "'.$final_count.'"
      },

 "3": {
        "value": "'.$sr_id_to_be_updated.'"
      }

    }
  ],

 "fieldsToReturn": [
3,
    6,
    7,
    8,
10,
16
  ]

}

';


curl_setopt($ch_update2, CURLOPT_HTTPHEADER, array(
"QB-Realm-Hostname: $quickbase_domain",
"User-Agent: $useragent_update2",
"Authorization: QB-USER-TOKEN $access_token",
'Content-Type:application/json'
));  

//curl_setopt($ch_update2,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch_update2,CURLOPT_CUSTOMREQUEST,'POST');

//curl_setopt($ch_update2,CURLOPT_CUSTOMREQUEST,'DELETE');
curl_setopt($ch_update2,CURLOPT_POSTFIELDS, $post_update2);
curl_setopt($ch_update2,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch_update2,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch_update2,CURLOPT_RETURNTRANSFER, true);
$response_update2 = curl_exec($ch_update2);

curl_close($ch_update2);

//print_r($response_update2);
$json_update2 = json_decode($response_update2, true);

$updated_rec_id2 = $json_update2["data"][0]["3"]["value"];

/*
if ($updated_rec_id2 !=''){

echo "success";
}else{
echo "failed";
}
*/


// update table users connection ends here


echo 1;	

}
else{
//echo "Message submission Failed";
echo 2;
}




?>