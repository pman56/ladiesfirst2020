<?php
error_reporting(0);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



//include('cors.php');
//include('time_limit.php');
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
// temporarly extend time limit
set_time_limit(300);



$mt = microtime(true);
$timer = time();
include("time/now.fn");
$created_time=strip_tags($now);
$dt2=date("Y-m-d H:i:s");

$title = strip_tags($_POST['title']);

//replace any space with hyphen
$sp ='-';
$tt = time();
$title_seo = str_replace(' ', '-', $title.$sp.$tt);


$video_url= strip_tags($_POST['video_url']);


//test for presence of certain characters to validate url link

if(strpos($video_url, 'http://') !== false){
//echo "yes found!";
}

elseif(strpos($video_url, 'https://') !== false){
//echo "yes found1!";
} 

else{
echo 22;
exit();
} 




if(strpos($video_url, 'watch') !== false){
//echo "yes found!";
$uv = explode("=",$video_url);
$video_id = end($uv);
$video_type = 'youtube';
} 

elseif(strpos($video_url, 'be') !== false){
//echo "yes found!";
$uv = explode("/",$video_url);
$video_id = end($uv);
$video_type = 'youtube';
} 

else{
//not found
echo 33;
exit();
}


$geo_address = trim($_POST['geo_address']);
$offering = strip_tags($_POST['offering']);
//$messaging = strip_tags($_POST['messaging']);

$messaging =  htmlentities(htmlentities($_POST['messaging']));
$help_category = strip_tags($_POST['help_category']);

$offering1 = str_replace(' ', '-', $offering);



$userid_sess_data = $_POST['userid_sess_data'];
$fullname_sess_data = $_POST['fullname_sess_data'];
$photo_sess_data = $_POST['photo_sess_data'];
$session_points_data = $_POST['points_sess_data'];



// insert into posts table at quickbase


//include quickbase token
include('quickbase_token.php');
include('quickbase_tables.php');

//$table_users
//$access_token
//$quickbase_domain




//update value of session Points with new values without Querying the users tavble at Quickbase

$new_points_for_posts = 50;
$session_points_data = $session_points_data + $new_points_for_posts;

$ss = "<script>
var points_sess_data = localStorage.getItem('$session_points_data');
alert(points_sess_data);
</script>";

$final_count = $session_points_data;
$point = $session_points_data;







$url2="https://api.quickbase.com/v1/records";
$ch2 = curl_init();
curl_setopt($ch2,CURLOPT_URL, $url2);
$useragent2 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';


$title_field = 6;
$title_seo_field =7;
$content_field = 8;
$timing_field =9;
$userid_field = 10;
$fullname_field = 11;
$userphoto_field = 12;
$post_type_field = 13;
$video_field = 14;
$category_field = 15;
$points_field = 16;
$offering_field =17;
$offering_seo_field =18;
$address_field =19;
$likes_field =20;
$unlikes_field =21;
$comments_field =22;


//$point = 100;
$level= 1;

$post_add='

{
  "to": "'.$table_posts.'",
  "data": [
    {


      "'.$title_field.'": {
        "value": "'.$title.'"
      },
      "'.$title_seo_field.'": {
        "value": "'.$title_seo.'"
      },
"'.$content_field.'": {
        "value": "'.$messaging.'"
      },
"'.$timing_field.'": {
        "value": "'.$timer.'"
      },
 "'.$userid_field.'": {
        "value": "'.$userid_sess_data.'"
      },
 "'.$fullname_field.'": {
        "value": "'.$fullname_sess_data.'"
      },
 "'.$userphoto_field.'": {
        "value": "'.$photo_sess_data.'"
      },
 "'.$post_type_field.'": {
        "value": "post"
      },
 "'.$video_field.'": {
        "value": "'.$video_id.'"
      },

 "'.$category_field.'": {
        "value": "'.$help_category.'"
      },
 "'.$points_field.'": {
        "value": "'.$final_count.'"
      },
 "'.$offering_field.'": {
        "value": "'.$offering.'"
      },
"'.$offering_seo_field.'": {
        "value": "'.$offering1.'"
      },
"'.$address_field.'": {
        "value": "'.$geo_address.'"
      },
"'.$likes_field.'": {
        "value": "0"
      },

"'.$unlikes_field.'": {
        "value": "0"
      },

"'.$comments_field.'": {
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
12,
13,
14,
15,
16,
17,
18,
19
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


// get last inserted Id for post table
$lastId  = $json2['data'][0]['3']['value'];
$postID = $lastId;



if($json2 == ''){
echo 4;
exit();
}



// send post broadcast notifications to all community members


// query users table to update notification_post table

$username_field_query = 6;
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
    10
  ],

  "where": "{'.$username_field_query.'.XCT.'.$username_sess_data.'}"

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
$reciever_userid = $v1['3']['value'];
$reciever_username = $v1['6']['value'];
		    
//insert into notification_post table
//insert starts




$url4="https://api.quickbase.com/v1/records";
$ch4 = curl_init();
curl_setopt($ch4,CURLOPT_URL, $url4);
$useragent4 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';


$post_id_field = 6;
$userid_field =7;
$fullname_field = 8;
$photo_field = 9;
$user_rank_field = 10;
$reciever_id_field =11;
$status_field = 12;
$type_field = 13;
$timing_field = 14;
$title_field = 15;
$title1_field = 16;


$post_add4='

{
  "to": "'.$table_notification_post.'",
  "data": [
    {


      "'.$post_id_field.'": {
        "value": "'.$lastId.'"
      },
      "'.$userid_field.'": {
        "value": "'.$userid_sess_data.'"
      },
"'.$fullname_field.'": {
        "value": "'.$fullname_sess_data.'"
      },
"'.$photo_field.'": {
        "value": "'.$photo_sess_data.'"
      },
 "'.$user_rank_field.'": {
        "value": "'.$user_rank_sess_data.'"
      },
 "'.$reciever_id_field.'": {
        "value": "'.$reciever_userid.'"
      },
 "'.$status_field.'": {
        "value": "unread"
      },
 "'.$type_field.'": {
        "value": "post"
      },
 "'.$timing_field.'": {
        "value": "'.$timer.'"
      },
 "'.$title_field.'": {
        "value": "'.$title.'"
      },
 "'.$title1_field.'": {
        "value": "'.$title_seo.'"
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
16


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






//insert ends
		  

		    //$count++;
		}
	}else{
		//echo "<div>No Users found.</div>";
	}
	


// update table users with the Points starts here

$u_points_field = 14;

$url_update = "https://api.quickbase.com/v1/records";
$ch_update = curl_init();
curl_setopt($ch_update,CURLOPT_URL, $url_update);
$useragent_update ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

$post_updates='

{
  "to": "'.$table_users.'",
  "data": [
    {


      "'.$u_points_field.'": {
        "value": "'.$final_count.'"
      },

 "3": {
        "value": "'.$userid_sess_data.'"
      }

    }
  ],

 "fieldsToReturn": [
3,
    6,
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


// update table users with the Points ends here


if ($updated_rec_id){
//if($statement){
echo 1;	

}
else{
//echo "post could not be submitted";
echo 2;
}






?>