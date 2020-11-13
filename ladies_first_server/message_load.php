
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

$uid = htmlentities(htmlentities($_POST['userid_sess_data'])); 
$userid_sess_data = $uid;


$r_id= htmlentities(htmlentities($_POST['userid']));
$connection_id= htmlentities(htmlentities($_POST['id']));
$fname1= htmlentities(htmlentities($_POST['fullname']));

$final_count = '0';




// query table users_connection table in quickbase.

$url5 = "https://api.quickbase.com/v1/records/query";
$ch5 = curl_init();
curl_setopt($ch5,CURLOPT_URL, $url5);
$useragent5 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';


$id_field= 3;
$post5 ='{
  "from": "'.$table_users_connection.'",
  "select": [
3,
    6,
10,
14
  ],

  "where": "{'.$id_field.'.CT.'.$connection_id.'}"

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



if($json5 == ''){
//if($rec_List1 == ''){
echo "
<script>
function reloadPage() {
location.reload();
}
</script>
<div style='background:red;color:white;padding:10px;'>No Network. Refresh page and ensure there is Internet Connection <br><br> <center><button class='readmore_btn' style='' title='Refresh Page' onclick='reloadPage()'>Refresh Page</button></center> </div>";
exit();
}




$cid = $json5["data"][0]["3"]["value"];
$userid_to_be_updated = $cid;
$db_s_id =$json5["data"][0]["6"]["value"];
$db_r_id =$json5["data"][0]["10"]["value"];




// update table users connection with the Message_counter starts here

$message_counter_field = 16;
$sender_userid_field = 6;
$reciever_userid_field = 10;


$url_update = "https://api.quickbase.com/v1/records";
$ch_update = curl_init();
curl_setopt($ch_update,CURLOPT_URL, $url_update);
$useragent_update ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

$post_updates='

{
  "to": "'.$table_users_connection.'",
  "data": [
    {


      "'.$message_counter_field.'": {
        "value": "'.$final_count.'"
      },

 "3": {
        "value": "'.$userid_to_be_updated.'"
      }

    }
  ],

 "fieldsToReturn": [
3,
    6,
    7,
    8,
14,
15
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


// update table users connection with the message_counter ends here




// query table message so that u can make updates later with msg Id.

$url5 = "https://api.quickbase.com/v1/records/query";
$ch5 = curl_init();
curl_setopt($ch5,CURLOPT_URL, $url5);
$useragent5 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';


$sender_id_field= 8;
$reciever_id_field=11;

$post5 ='{
  "from": "'.$table_messages.'",
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

  "where": "{'.$sender_id_field.'.EX.'.$db_s_id.'}AND{'.$reciever_id_field.'.EX.'.$db_r_id.'}"

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


$msg_id = $json5["data"][0]["3"]["value"];
$msg_id_to_be_updated = $msg_id;



//update message table starts here


$status_field =14;

$url_update2 = "https://api.quickbase.com/v1/records";
$ch_update2 = curl_init();
curl_setopt($ch_update2,CURLOPT_URL, $url_update2);
$useragent_update2 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

$post_update2='

{
  "to": "'.$table_messages.'",
  "data": [
    {


      "'.$status_field.'": {
        "value": "seen"
      },

 "3": {
        "value": "'.$msg_id_to_be_updated.'"
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


// update table message table ends here




//finally display message results


// query table message so that u can make updates later with msg Id.

$url5 = "https://api.quickbase.com/v1/records/query";
$ch5 = curl_init();
curl_setopt($ch5,CURLOPT_URL, $url5);
$useragent5 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';


$sender_id_field= 8;
$reciever_id_field=11;

$post5 ='{
  "from": "'.$table_messages.'",
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

"where": "({'.$reciever_id_field.'.EX.'.$db_r_id.'}OR{'.$sender_id_field.'.EX.'.$db_r_id.'})AND({'.$reciever_id_field.'.EX.'.$db_s_id.'}OR{'.$sender_id_field.'.EX.'.$db_s_id.'})"

 
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


$msg_id = $json5["data"][0]["3"]["value"];
$msg_id_to_be_updated = $msg_id;


if($num_rec5 == 0){

echo "<div style='background:red;color:white;padding:10px;border:none'>No New Message Exist Yet Between <b>You</b> and  <b>($fname1)</b> .</div>";
}


foreach($json5['data'] as $v1){

$id = $v1['3']['value'];
$sender_photo = $v1['6']['value'];
$sender_name = $v1['7']['value']; 
$sender_id = $v1['8']['value'];
$reciever_photo = $v1['9']['value'];
$reciever_name = $v1['10']['value'];
$reciever_id = $v1['11']['value'];
$message = $v1['12']['value'];
$timing = $v1['13']['value'];
$status = $v1['14']['value'];







?>





<div class="notify_content_css col-sm-12" >
<?php 
if($sender_id == $uid){
?>


<p class="col-sm-12" style="color:black;padding:10px;background:#ddd">
<b>Sender Name:</b> You<br>
<a href='https://hackathon20-fesedo.quickbase.com/db/bqyb6cxvm?a=dbpage&pageID=15&id=<?php echo $reciever_id; ?>' class='pull-right post-css2' title='View Profile'>Profile</a>
<img style='max-height:60px;max-width:60px;' class='img-circle' src='<?php echo $reciever_photo; ?>'>
<br><b>Reciever Name:</b> <?php echo $reciever_name; ?><br>
<b> Message: </b> <?php echo $message;?>
<?php 
if($status == 'sent'){
echo "&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-check' style='font-size:30px;color:green;'></i>";
}

if($status == 'seen'){
echo "&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-check' style='font-size:30px;color:green;'></i><i class='fa fa-check' style='font-size:30px;color:blue;'></i>";
}

?>




<span style='color:#800000;'><b> Time: </b> <span data-livestamp="<?php echo $timing;?>"></span></span><br>
</p>
<?php
}
?>


<?php 
if($reciever_id == $uid){
?>


<p class="col-sm-12" style="color:black;padding:10px;background:#f1f1f1">
<b>Reciever Name:</b> You<br>
<a href='https://hackathon20-fesedo.quickbase.com/db/bqyb6cxvm?a=dbpage&pageID=15&id=<?php echo $sender_id; ?>' class='pull-right post-css2' title='View Profile'>Profile</a>
<img style='max-height:60px;max-width:60px;' class='img-circle' src='<?php echo $sender_photo; ?>'>
<br><b>Sender Name:</b> <?php echo $sender_name; ?><br>
<b> Message: </b> <?php echo $message;?>
<?php 
if($status == 'sent'){
echo "&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-check' style='font-size:30px;color:green;'></i>";
}
if($status == 'seen'){
echo "&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-check' style='font-size:30px;color:green;'></i><i class='fa fa-check' style='font-size:30px;color:blue;'></i>";
}
?>

<span style='color:#800000;'><b> Time: </b> <span data-livestamp="<?php echo $timing;?>"></span></span><br>
</p>
<?php
}
?>








</div>



<?php
}
?>


