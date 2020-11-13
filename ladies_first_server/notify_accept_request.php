<?php

error_reporting(0);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

ini_set('max_execution_time', 300); //300 seconds = 5 minutes
// temporarly extend time limit
set_time_limit(300);




include('quickbase_token.php');
include('quickbase_tables.php');


$reciever_id=strip_tags($_POST['reciever_id']);
$reciver_username = $reciever_id;
$id_temp=strip_tags($_POST['idtemp']);
$id=strip_tags($_POST['id']);



$userid_sess_data = strip_tags($_POST['userid_sess_data']);
$fullname_sess_data = strip_tags($_POST['fullname_sess_data']);
$photo_sess_data = strip_tags($_POST['photo_sess_data']);
$email_sess_data = strip_tags($_POST['email_sess_data']);
$user_rank_sess_data = strip_tags($_POST['user_rank_sess_data']);


$timer = time();
$tmm =$timer;

//Get Recipient Data from Users Table

$id_users_field =  3;

$url3 = "https://api.quickbase.com/v1/records/query";
$ch3 = curl_init();
curl_setopt($ch3,CURLOPT_URL, $url3);
$useragent3 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

$data_params3 ='{
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
14,
15,
16,
17
  ],

  "where": "{'.$id_users_field.'.CT.'.$reciever_id.'}"

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


$db_userid  = $json3['data'][0]['3']['value'];
$db_username  = $json3['data'][0]['6']['value'];
$db_fullname = $json3['data'][0]['8']['value'];
$db_email  = $json3['data'][0]['9']['value'];
$db_photo  = $json3['data'][0]['10']['value'];
$db_department  = $json3['data'][0]['11']['value'];




//insert 1 for sender starts at users_connection table
//users_connection table is uct


$url4="https://api.quickbase.com/v1/records";
$ch4 = curl_init();
curl_setopt($ch4,CURLOPT_URL, $url4);
$useragent4 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';



$uct_sender_userid_field =6;
$uct_sender_fullname_field = 7;
$uct_sender_photo_field = 8;
$uct_sender_email_field = 9;

$uct_reciever_userid_field =10;
$uct_reciever_fullname_field =11;
$uct_reciever_photo_field =12;
$uct_timing_field = 13;
$uct_status_field = 14;
$uct_status1_field = 15;
$uct_message_counter_field = 16;
$uct_reciever_email_field =17;


$post_add4='

{
  "to": "'.$table_users_connection.'",
  "data": [
    {


      
      "'.$uct_sender_userid_field.'": {
        "value": "'.$userid_sess_data.'"
      },
"'.$uct_sender_fullname_field.'": {
        "value": "'.$fullname_sess_data.'"
      },
"'.$uct_sender_photo_field.'": {
        "value": "'.$photo_sess_data.'"
      },
 "'.$uct_sender_email_field.'": {
        "value": "'.$email_sess_data.'"
      },
 "'.$uct_reciever_userid_field.'": {
        "value": "'.$db_userid.'"
      },
 "'.$uct_reciever_fullname_field.'": {
        "value": "'.$db_fullname.'"
      },
 "'.$uct_reciever_photo_field.'": {
        "value": "'.$db_photo.'"
      },
 "'.$uct_reciever_email_field.'": {
        "value": "'.$db_email.'"
      },
 "'.$uct_timing_field.'": {
        "value": "'.$timer.'"
      },
 "'.$uct_status_field.'": {
        "value": "Accepted"
      },
"'.$uct_status1_field.'": {
        "value": "'.$user_rank_sess_data.'"
      }



    }
  ],

 "fieldsToReturn": [
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


  ]

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
curl_setopt($ch4,CURLOPT_POSTFIELDS, $post_add4);
curl_setopt($ch4,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch4,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch4,CURLOPT_RETURNTRANSFER, true);
$response4 = curl_exec($ch4);

curl_close($ch4);

//print_r($response4);
$json4 = json_decode($response4, true);
$statement4= $json4["metadata"]["totalNumberOfRecordsProcessed"];





//insert 2 for reciever starts


$url5="https://api.quickbase.com/v1/records";
$ch5 = curl_init();
curl_setopt($ch5,CURLOPT_URL, $url5);
$useragent5 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';



$post_add5='

{
  "to": "'.$table_users_connection.'",
  "data": [
    {


      
      "'.$uct_sender_userid_field.'": {
        "value": "'.$db_userid.'"
      },
"'.$uct_sender_fullname_field.'": {
        "value": "'.$db_fullname.'"
      },
"'.$uct_sender_photo_field.'": {
        "value": "'.$db_photo.'"
      },
 "'.$uct_sender_email_field.'": {
        "value": "'.$db_email.'"
      },
 "'.$uct_reciever_userid_field.'": {
        "value": "'.$userid_sess_data.'"
      },
 "'.$uct_reciever_fullname_field.'": {
        "value": "'.$fullname_sess_data.'"
      },
 "'.$uct_reciever_photo_field.'": {
        "value": "'.$photo_sess_data.'"
      },
 "'.$uct_reciever_email_field.'": {
        "value": "'.$email_sess_data.'"
      },
 "'.$uct_timing_field.'": {
        "value": "'.$timer.'"
      },
 "'.$uct_status_field.'": {
        "value": "Accepted"
      },
"'.$uct_status1_field.'": {
        "value": "'.$db_department.'"
      }



    }
  ],

 "fieldsToReturn": [
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


  ]

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
curl_setopt($ch5,CURLOPT_POSTFIELDS, $post_add5);
curl_setopt($ch5,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch5,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch5,CURLOPT_RETURNTRANSFER, true);
$response5 = curl_exec($ch5);

curl_close($ch5);

//print_r($response5);
$json5 = json_decode($response5, true);
$statement5= $json5["metadata"]["totalNumberOfRecordsProcessed"];






// update table users_temp starts here

//users_temporal table is utt
$utt_status_field =12;
$utt_id_field = 3;

$url_update = "https://api.quickbase.com/v1/records";
$ch_update = curl_init();
curl_setopt($ch_update,CURLOPT_URL, $url_update);
$useragent_update ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

$post_updates='

{
  "to": "'.$table_users_temp.'",
  "data": [
    {


      "'.$utt_status_field.'": {
        "value": "1"
      },

 "3": {
        "value": "'.$id_temp.'"
      }

    }
  ],

 "fieldsToReturn": [
3,
    6,
    7,
    8,
14
  ]

}

';


curl_setopt($ch_update, CURLOPT_HTTPHEADER, array(
"QB-Realm-Hostname: $quickbase_domain",
"User-Agent: $useragent_update",
"Authorization: QB-USER-TOKEN $access_token",
'Content-Type:application/json'
));  

//curl_setopt($ch_update,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch_update,CURLOPT_CUSTOMREQUEST,'POST');

//curl_setopt($ch_update,CURLOPT_CUSTOMREQUEST,'DELETE');
curl_setopt($ch_update,CURLOPT_POSTFIELDS, $post_updates);
curl_setopt($ch_update,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch_update,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch_update,CURLOPT_RETURNTRANSFER, true);
$response_update = curl_exec($ch_update);

curl_close($ch_update);

//print_r($response_update);
$json_update = json_decode($response_update, true);

$updated_rec_id = $json_update["data"][0]["3"]["value"];

/*
if ($updated_rec_id !=''){

echo "success";
}else{
echo "failed";
}
*/

// update table users_temp ends here




//delete request notification upon acceptance starts


$url="https://api.quickbase.com/v1/records";
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
$useragent ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';


$post_del ='{ "from" : "'.$table_notification_request.'", "where": "{3.EX.'.$id.'}"}';

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
"QB-Realm-Hostname: $quickbase_domain",
"User-Agent: $useragent",
"Authorization: QB-USER-TOKEN $access_token",
'Content-Type:application/json'
));  

//curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
//curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');

curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'DELETE');
curl_setopt($ch,CURLOPT_POSTFIELDS, $post_del);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

curl_close($ch);

//print_r($response);
$json = json_decode($response, true);
$numberDeleted = $json["numberDeleted"];


//delete request notification upon acceptance ends



// send notification to the other user that her request has been accepted starts

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
        "value": "accepted"
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


// send notification to the other user that her request has been accepted ends






?>


