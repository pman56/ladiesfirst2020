<?php
error_reporting(0);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


ini_set('max_execution_time', 300); //300 seconds = 5 minutes
// temporarly extend time limit
set_time_limit(300);



$postid = $_POST['post_id'];
$type = $_POST['like_type'];
$title = $_POST['title'];
$title_seo = $_POST['title_seo'];
$post_userid = $_POST['userid'];
$points_per_posts = $_POST['ppp'];

$userid_sess_data = $_POST['userid_sess_data'];
$fullname_sess_data = $_POST['fullname_sess_data'];
$photo_sess_data = $_POST['photo_sess_data'];

$token= md5(uniqid());
$timer = time();
include("time/now.fn");
$created_time=strip_tags($now);
$dt2=date("Y-m-d H:i:s");


//include quickbase token
include('quickbase_token.php');
include('quickbase_tables.php');



//query post tables to get previous total likes and unlikes

$postid_field2 =  3;
$postid_userid_field2 =  10;

$url3a = "https://api.quickbase.com/v1/records/query";
$ch3a = curl_init();
curl_setopt($ch3a,CURLOPT_URL, $url3a);
$useragent3a ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

$data_params3a ='{
  "from": "'.$table_posts.'",
  "select": [
3,
    6,
    7,
    8,
    9,
    10,
	20,
	21,
	22
  ],

  "where": "{'.$postid_field2.'.CT.'.$postid.'}"

}
';

//"where": "{'.$postid_field2.'.CT.'.$postid.'}AND{'.$postid_userid_field2.'.CT.'.$userid_sess_data.'}"

curl_setopt($ch3a, CURLOPT_HTTPHEADER, array(
"QB-Realm-Hostname: $quickbase_domain",
"User-Agent: $useragent3a",
"Authorization: QB-USER-TOKEN $access_token",
'Content-Type:application/json'
));  

//curl_setopt($ch3a,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch3a,CURLOPT_CUSTOMREQUEST,'POST');

//curl_setopt($ch3a,CURLOPT_CUSTOMREQUEST,'DELETE');
curl_setopt($ch3a,CURLOPT_POSTFIELDS, $data_params3a);
curl_setopt($ch3a,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch3a,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch3a,CURLOPT_RETURNTRANSFER, true);
$response3a = curl_exec($ch3a);

curl_close($ch3a);

//print_r($response3a);
$json3a = json_decode($response3a, true);
$counta = $json3a["metadata"]["numRecords"];
$db_like_count = $json3a["data"][0]["20"]["value"];
$db_unlike_count = $json3a["data"][0]["21"]["value"];


//calculate new total likes
$new_like = 1;
$total_like_count = $db_like_count + $new_like;


//calculate new total unlikes
$new_unlike = 1;
$total_unlike_count = $db_unlike_count + $new_unlike;



//check if user has already like the post before via like_unlike table

$userid_field1 =  6;
$postid_field1 =  7;

$url3 = "https://api.quickbase.com/v1/records/query";
$ch3 = curl_init();
curl_setopt($ch3,CURLOPT_URL, $url3);
$useragent3 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

$data_params3 ='{
  "from": "'.$table_post_like_unlike.'",
  "select": [
3,
    6,
    7,
    8,
    9,
    10
  ],

  "where": "{'.$userid_field1.'.CT.'.$userid_sess_data.'}AND{'.$postid_field1.'.CT.'.$postid.'}"

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

$count = $json3["metadata"]["numRecords"];


if($count == 0){

//You have not like this post before.

//insert into post_like_unlike table
//insert starts




$url4="https://api.quickbase.com/v1/records";
$ch4 = curl_init();
curl_setopt($ch4,CURLOPT_URL, $url4);
$useragent4 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

$userid_field =6;
$postid_field = 7;
$type_field = 8;
$timing_field = 9;
$fullname_field = 10;
$photo_field = 11;


$post_add4='

{
  "to": "'.$table_post_like_unlike.'",
  "data": [
    {


      
      "'.$userid_field.'": {
        "value": "'.$userid_sess_data.'"
      },
"'.$postid_field.'": {
        "value": "'.$postid.'"
      },

 "'.$type_field.'": {
        "value": "'.$type.'"
      },
 "'.$timing_field.'": {
        "value": "'.$timer.'"
      },
"'.$fullname_field.'": {
        "value": "'.$fullname_sess_data.'"
      },
"'.$photo_field.'": {
        "value": "'.$photo_sess_data.'"
      }


    }
  ],

 "fieldsToReturn": [
    6,
    7,
    8,
    9,
    10,
11


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



if($type == 1){
// add counter for post like to notification_post tables


if($userid_sess_data != $post_userid){

$tmm=time();
$url5="https://api.quickbase.com/v1/records";
$ch5 = curl_init();
curl_setopt($ch5,CURLOPT_URL, $url5);
$useragent5 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

$postid_field = 6;
$userid_field =7;
$fullname_field = 8;
$photo_field = 9;
$user_rank_field = 10;
$reciever_id_field = 11;
$status_field = 12;
$type_field = 13;
$timing_field = 14;
$title_field = 15;
$title_seo_field = 16;


$post_add5='

{
  "to": "'.$table_notification_post.'",
  "data": [
    {

"'.$postid_field.'": {
        "value": "'.$postid.'"
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
        "value": "'.$post_userid.'"
      },

"'.$status_field.'": {
        "value": "unread"
      },
"'.$type_field.'": {
        "value": "like"
      },
"'.$timing_field.'": {
        "value": "'.$tmm.'"
      },
"'.$title_field.'": {
        "value": "'.$title.'"
      },
"'.$title_seo_field.'": {
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


} //close if userid_sess_data check






// update table posts with the Points and likes counts starts here


$posts_points_field =16;
$total_likes_field = 20;

$url_update2 = "https://api.quickbase.com/v1/records";
$ch_update2 = curl_init();
curl_setopt($ch_update2,CURLOPT_URL, $url_update2);
$useragent_update2 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

$post_update2='

{
  "to": "'.$table_posts.'",
  "data": [
    {


 "'.$total_likes_field.'": {
        "value": "'.$total_like_count.'"
      },


 "3": {
        "value": "'.$postid.'"
      }

    }
  ],

 "fieldsToReturn": [
3,
    6,
    7,
    8,
10,
16,
20,
21,
22


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


// update table posts with the Points and likes count ends here





}// close if when type is 1











//start if when type is 0



if($type == 0){
// add counter for post like to notification_post tables


if($userid_sess_data != $post_userid){

$tmm=time();
$url5="https://api.quickbase.com/v1/records";
$ch5 = curl_init();
curl_setopt($ch5,CURLOPT_URL, $url5);
$useragent5 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

$postid_field = 6;
$userid_field =7;
$fullname_field = 8;
$photo_field = 9;
$user_rank_field = 10;
$reciever_id_field = 11;
$status_field = 12;
$type_field = 13;
$timing_field = 14;
$title_field = 15;
$title_seo_field = 16;


$post_add5='

{
  "to": "'.$table_notification_post.'",
  "data": [
    {

"'.$postid_field.'": {
        "value": "'.$postid.'"
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
        "value": "'.$post_userid.'"
      },

"'.$status_field.'": {
        "value": "unread"
      },
"'.$type_field.'": {
        "value": "unlike"
      },
"'.$timing_field.'": {
        "value": "'.$tmm.'"
      },
"'.$title_field.'": {
        "value": "'.$title.'"
      },
"'.$title_seo_field.'": {
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


} //close if userid_sess_data check









// update table for unlike with the Points starts here



$total_unlikes_field = 21;
$posts_points_field =16;

$url_update2 = "https://api.quickbase.com/v1/records";
$ch_update2 = curl_init();
curl_setopt($ch_update2,CURLOPT_URL, $url_update2);
$useragent_update2 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

$post_update2='

{
  "to": "'.$table_posts.'",
  "data": [
    {


      "'.$posts_points_field.'": {
        "value": "'.$final_count1.'"
      },

"'.$total_unlikes_field.'": {
        "value": "'.$total_unlike_count.'"
      },

 "3": {
        "value": "'.$postid.'"
      }

    }
  ],

 "fieldsToReturn": [
3,
    6,
    7,
    8,
10,
16,
20,
21,
22


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


// update table for unlike with the Points ends here







}// close if when type is 0


		  

		
	}else{
//echo "<div>You have Liked this Post before.</div>";

/*
//update starts

$lu_userid_field =6;
$lu_postid_field =7;
$lu_type_field =8;

$url_update3 = "https://api.quickbase.com/v1/records";
$ch_update3 = curl_init();
curl_setopt($ch_update3,CURLOPT_URL, $url_update3);
$useragent_update3 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

$post_update3='

{
  "to": "'.$table_post_like_unlike.'",
  "data": [
    {


      "'.$lu_userid_field.'": {
        "value": "'.$post_userid.'"
      },

"'.$lu_type_field.'": {
        "value": "'.$type.'"
      },

 "3": {
        "value": "'.$postid.'"
      }

    }
  ],

 "fieldsToReturn": [
3,
    6,
    7,
    8,
10,
11


  ]

}

';


curl_setopt($ch_update3, CURLOPT_HTTPHEADER, array(
"QB-Realm-Hostname: $quickbase_domain",
"User-Agent: $useragent_update3",
"Authorization: QB-USER-TOKEN $access_token",
'Content-Type:application/json'
));  

//curl_setopt($ch_update3,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch_update3,CURLOPT_CUSTOMREQUEST,'POST');

//curl_setopt($ch_update3,CURLOPT_CUSTOMREQUEST,'DELETE');
curl_setopt($ch_update3,CURLOPT_POSTFIELDS, $post_update3);
curl_setopt($ch_update3,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch_update3,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch_update3,CURLOPT_RETURNTRANSFER, true);
$response_update3 = curl_exec($ch_update3);

curl_close($ch_update3);

//print_r($response_update3);
$json_update3= json_decode($response_update3, true);

$updated_rec_id3 = $json_update3["data"][0]["3"]["value"];

//updates ends

*/


	}
	
	
	
	
	// get total like and unlikes making finalquery
	
//  get total like from the post

$url_like = "https://api.quickbase.com/v1/records/query";
$ch_like = curl_init();
curl_setopt($ch_like,CURLOPT_URL, $url_like);
$useragent_like ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';


$post_field_a= 7;
$type_field_a = 8; 

$type_value_a =1;

$post_like ='{
  "from": "'.$table_post_like_unlike.'",
  "select": [
3,
6,
7,
8,
9,
10,
11
  ],

  "where": "{'.$post_field_a.'.CT.'.$postid.'}AND{'.$type_field_a.'.CT.'.$type_value_a.'}"

}
';


curl_setopt($ch_like, CURLOPT_HTTPHEADER, array(
"QB-Realm-Hostname: $quickbase_domain",
"User-Agent: $useragent_like",
"Authorization: QB-USER-TOKEN $access_token",
'Content-Type:application/json'
));  

//curl_setopt($ch_like,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch_like,CURLOPT_CUSTOMREQUEST,'POST');

//curl_setopt($ch_like,CURLOPT_CUSTOMREQUEST,'DELETE');
curl_setopt($ch_like,CURLOPT_POSTFIELDS, $post_like);
curl_setopt($ch_like,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch_like,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch_like,CURLOPT_RETURNTRANSFER, true);
$response_like = curl_exec($ch_like);

curl_close($ch_like);

//print_r($response_like);
$json_like= json_decode($response_like, true);

$num_field_like = $json_like["metadata"]["numFields"];
$total_likes = $json_like["metadata"]["numRecords"];








// get total unlikes from the post

$url_unlike = "https://api.quickbase.com/v1/records/query";
$ch_unlike = curl_init();
curl_setopt($ch_unlike,CURLOPT_URL, $url_unlike);
$useragent_unlike ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';


$post_field_b= 7;
$type_field_b = 8; 

$type_value_b =0;

$post_unlike ='{
  "from": "'.$table_post_like_unlike.'",
  "select": [
3,
6,
7,
8,
9,
10,
11
  ],

  "where": "{'.$post_field_b.'.CT.'.$postid.'}AND{'.$type_field_b.'.CT.'.$type_value_b.'}"

}
';


curl_setopt($ch_unlike, CURLOPT_HTTPHEADER, array(
"QB-Realm-Hostname: $quickbase_domain",
"User-Agent: $useragent_unlike",
"Authorization: QB-USER-TOKEN $access_token",
'Content-Type:application/json'
));  

//curl_setopt($ch_unlike,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch_unlike,CURLOPT_CUSTOMREQUEST,'POST');

//curl_setopt($ch_unlike,CURLOPT_CUSTOMREQUEST,'DELETE');
curl_setopt($ch_unlike,CURLOPT_POSTFIELDS, $post_unlike);
curl_setopt($ch_unlike,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch_unlike,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch_unlike,CURLOPT_RETURNTRANSFER, true);
$response_unlike = curl_exec($ch_unlike);

curl_close($ch_unlike);

//print_r($response_unlike);
$json_unlike= json_decode($response_unlike, true);

$num_field_unlike = $json_unlike["metadata"]["numFields"];
$total_unlikes = $json_unlike["metadata"]["numRecords"];

$array_display = array("$total_likes-$total_unlikes");
echo json_encode($array_display);
