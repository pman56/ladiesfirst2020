<?php 
ob_start();
error_reporting(0);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('header_title.php');
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
// temporarly extend time limit
set_time_limit(300);

 ?>



<script>
$(document).ready(function(){
$('.notify-accept-friend-request-post').click(function(){
// start confirm
 if(confirm("Are you sure you want to accept This Friend Request: ")){
var id = $(this).data('id');
var userid = $(this).data('userid');
var idtemp = $(this).data('idtemp');


var userid_sess_data = localStorage.getItem('useridsessdata');
var fullname_sess_data = localStorage.getItem('fullnamesessdata');
var photo_sess_data = localStorage.getItem('photosessdata');
var user_rank_sess_data = localStorage.getItem('userranksessdata');
var email_sess_data = localStorage.getItem('emailsessdata');


$(".loader-notify-accept-friend-request_"+id).fadeIn(400).html('<br><div style="color:black;background:white;padding:10px;"><i class="fa fa-spinner fa-spin" style="font-size:20px"></i>&nbsp;Please Wait, Friends Request is being accepted...</div>');
var datasend = {'id': id,'reciever_id': userid, 'idtemp': idtemp, 'userid_sess_data':userid_sess_data, 'fullname_sess_data':fullname_sess_data, 'photo_sess_data':photo_sess_data, 'user_rank_sess_data':user_rank_sess_data, 'email_sess_data':email_sess_data};
$.ajax({
			type:'POST',
			url:'https://qbtut.com/ladies_first_server/notify_accept_request.php',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){
if(msg == 1){
alert('Friends Request Successfully accepted');
$(".loader-notify-accept-friend-request_"+id).hide();
$(".result-notify-accept-friend-request_"+id).html("<div style='color:white;background:green;padding:10px;'>Friends Request Successfully accepted</div>");
setTimeout(function(){ $(".result-notify-accept-friend-request_"+id).html(''); }, 5000);
location.reload();
}


	if(msg == 0){

alert('Friends Request  could not be accepted. Please ensure you are connected to Internet.');

$(".loader-notify-accept-friend-request_"+id).hide();
$(".result-notify-accept-friend-request_"+id).html("<div style='color:white;background:red;padding:10px;'>Friends Request could not be accepted. Please ensure you are connected to Internet.</div>");
setTimeout(function(){ $(".result-notify-accept-friend-request_"+id).html(''); }, 5000);


}

}
			
		});
		
		


}
// end confirm

                });












$('.notify-reject-friend-request-post').click(function(){

// start confirm
 if(confirm("Are you sure you want to Reject This Friend Request: "))
     {
var id = $(this).data('id');
var userid = $(this).data('userid');
var idtemp = $(this).data('idtemp');



var userid_sess_data = localStorage.getItem('useridsessdata');
var fullname_sess_data = localStorage.getItem('fullnamesessdata');
var photo_sess_data = localStorage.getItem('photosessdata');
var user_rank_sess_data = localStorage.getItem('userranksessdata');


if(id ==''){
alert('something is wrong with UserId');
}
else{



$(".loader-notify-reject-friend-request_"+id).fadeIn(400).html('<br><div style="color:black;background:white;padding:10px;"><i class="fa fa-spinner fa-spin" style="font-size:20px"></i>&nbsp;Please Wait, Friends Request is being Rejected...</div>');
//var datasend = "id="+ id;
var datasend = {'id': id,'reciever_id': userid, 'idtemp': idtemp, 'userid_sess_data':userid_sess_data, 'fullname_sess_data':fullname_sess_data, 'photo_sess_data':photo_sess_data, 'user_rank_sess_data':user_rank_sess_data};
		
		$.ajax({
			
			type:'POST',
			url:'https://qbtut.com/ladies_first_server/notify_reject_request.php',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){


	if(msg == 1){


alert('Friends Request Successfully Rejected');

$(".loader-notify-reject-friend-request_"+id).hide();
$(".result-notify-reject-friend-request_"+id).html("<div style='color:white;background:green;padding:10px;'>Friends Request Successfully Rejected</div>");
setTimeout(function(){ $(".result-notify-reject-friend-request_"+id).html(''); }, 5000);

	
location.reload();

		

}


	if(msg == 0){

alert('Friends Request  could not be Rejected. Please ensure you are connected to Internet.');

$(".loader-notify-reject-friend-request_"+id).hide();
$(".result-notify-reject-friend-request_"+id).html("<div style='color:white;background:red;padding:10px;'>Friends Request could not be Rejected. Please ensure you are connected to Internet.</div>");
setTimeout(function(){ $(".result-notify-reject-friend-request_"+id).html(''); }, 5000);


}

}
			
		});
		
		}


}
// end confirm

                });






$('.notify-delete-request-post').click(function(){
// confirm start
 if(confirm("Are you sure you want to Delete This Data: ")){
var id = $(this).data('id');

$(".loader-notify-delete_"+id).fadeIn(400).html('<br><div style="color:black;background:white;padding:10px;"><i class="fa fa-spinner fa-spin" style="font-size:20px"></i> &nbsp;Please Wait, Content is being deleted...</div>');
var datasend = {'id': id};
		$.ajax({
			
			type:'POST',
			url:'https://qbtut.com/ladies_first_server/notify_delete_request.php',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){


	if(msg == 1){
alert('Content Successfully Deleted');
$(".loader-notify-delete_"+id).hide();
$(".result-notify-delete_"+id).html("<div style='color:white;background:green;padding:10px;'>Content Successfully Deleted</div>");
setTimeout(function(){ $(".result-notify-delete_"+id).html(''); }, 5000);
location.reload();
}


	if(msg == 0){

alert('Content could not be deleted. Please ensure you are connected to Internet.');
$(".loader-notify-delete_"+id).hide();
$(".result-notify-delete_"+id).html("<div style='color:white;background:red;padding:10px;'>Content could not be deleted. Please ensure you are connected to Internet.</div>");
setTimeout(function(){ $(".result-notify-delete_"+id).html(''); }, 5000);

}

}
			
});
}

// confirm ends

                });








$('.notify-delete-request-post1').click(function(){
// confirm start
 if(confirm("Are you sure you want to Delete This Data: ")){
var id = $(this).data('id');

$(".loader-notify-delete1_"+id).fadeIn(400).html('<br><div style="color:black;background:white;padding:10px;"><i class="fa fa-spinner fa-spin" style="font-size:20px"></i> &nbsp;Please Wait, Content is being deleted...</div>');
var datasend = {'id': id};
		$.ajax({
			
			type:'POST',
			url:'https://qbtut.com/ladies_first_server/notify_delete_request.php',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){


	if(msg == 1){
alert('Content Successfully Deleted');
$(".loader-notify-delete1_"+id).hide();
$(".result-notify-delete1_"+id).html("<div style='color:white;background:green;padding:10px;'>Content Successfully Deleted</div>");
setTimeout(function(){ $(".result-notify-delete1_"+id).html(''); }, 5000);
location.reload();
}


	if(msg == 0){

alert('Content could not be deleted. Please ensure you are connected to Internet.');
$(".loader-notify-delete1_"+id).hide();
$(".result-notify-delete1_"+id).html("<div style='color:white;background:red;padding:10px;'>Content could not be deleted. Please ensure you are connected to Internet.</div>");
setTimeout(function(){ $(".result-notify-delete1_"+id).html(''); }, 5000);

}

}
			
});
}

// confirm ends

                });









            });






</script>



<style>


.notify-reject-friend-request-css{
background:red;
border:none;
color:white;
padding:6px;
}

.notify-reject-friend-request-css:hover{
background:orange;
color:black;
}


.notify-accept-friend-request-css{
background:green;
border:none;
color:white;
padding:6px;
}

.notify-accept-friend-request-css:hover{
background:orange;
color:black;
}


.notify_content_css{
display:inline-block;border-style: dashed; border-width:2px; border-color: 
orange;color:black;background:#eeeeee;padding:10px;
}


.notify_content_css:hover{
color:black;background:#ec5574;
}



.post-css2{
background:#ec5574;
border:none;
color:white;
padding:6px;
border-radius:20%;
}

.post-css2:hover{
background:orange;
color:black;
}
</style>



<?php
//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Methods: GET, POST');
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



include('quickbase_token.php');
include('quickbase_tables.php');

$sender_id=strip_tags($_POST['sender_id']);
$userid_sess_data = $sender_id;


$reciever_id_field =11;
$status_field = 12;
$status_value = 0;

$url3 = "https://api.quickbase.com/v1/records/query";
$ch3 = curl_init();
curl_setopt($ch3,CURLOPT_URL, $url3);
$useragent3 ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

$data_params3 ='{
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

  "where": "{'.$reciever_id_field.'.CT.'.$userid_sess_data.'}",

 "sortBy": [
    {
      "fieldId": 4,
      "order": "DESC"
    },
    {
      "fieldId": 5,
      "order": "DESC"
    }
  ]

  



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


if($json3 == ''){
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




if($rec_List1  == 0){

echo "<div style='background:red;color:white;padding:10px;border:none'>No New Friends Request Yet.</div>";
}



foreach($json3['data'] as $v1){
$id = $v1['3']['value'];
$user_temp_table_id = $v1['6']['value'];
$sender_userid = $v1['7']['value'];
$sender_fullname1 = $v1['8']['value'];
$sender_photo = $v1['9']['value'];
$department = $v1['10']['value'];
$r_id = $v1['11']['value'];
$status = $v1['12']['value'];
$type  = $v1['13']['value'];
$timing = $v1['14']['value'];


// replace empty space with hyphen
$sender_fullname = str_replace(' ', '-', $sender_fullname1);


		   
?>





<div class="col-sm-12 notify_content_css" >
<?php 
if($type == 'sent'){
?>


<div  style="color:black;padding:10px;background:#ddd">
<a href='https://hackathon20-fesedo.quickbase.com/db/bqyb6cxvm?a=dbpage&pageID=15&id=<?php echo $sender_userid; ?>' class='pull-right post-css2' title='View Profile'>Profile</a>

<img style='max-height:60px;max-width:60px;' class='img-circle' src='<?php echo $sender_photo; ?>' alt='User Image'>
<br><b>Name:</b> <?php echo $sender_fullname1; ?><br>
<b> Profession: </b> <?php echo $department;?><br>
<span style='color:#800000;'><b> Time: </b> <span data-livestamp="<?php echo $timing;?>"></span></span><br>

<p>
<button class='pull-left col-sm-6 notify-accept-friend-request-post notify-accept-friend-request-css' data-idtemp='<?php echo $user_temp_table_id; ?>' data-id='<?php echo $id; ?>' data-userid='<?php echo $sender_userid; ?>'>Accept Request</button>
   <div class="loader-notify-accept-friend-request_<?php echo $id; ?>"></div>
   <div class="result-notify-accept-friend-request_<?php echo $id; ?>"></div>



<button class='pull-right col-sm-5 notify-reject-friend-request-post notify-reject-friend-request-css' data-idtemp='<?php echo $user_temp_table_id; ?>' data-id='<?php echo $id; ?>' data-userid='<?php echo $sender_userid; ?>'>Reject Request</button>
   <div class="loader-notify-reject-friend-request_<?php echo $id; ?>"></div>
   <div class="result-notify-reject-friend-request_<?php echo $id; ?>"></div>



</p>
<br>
</div>
<?php
}
?>






<?php 
if($type == 'accepted'){
?>


<div  style="color:black;padding:10px;background:#ddd">

<a href='https://hackathon20-fesedo.quickbase.com/db/bqyb6cxvm?a=dbpage&pageID=15&id=<?php echo $sender_userid; ?>' class='pull-right post-css2' title='View Profile'>Profile</a>
<img style='max-height:60px;max-width:60px;' class='img-circle' src='<?php echo $sender_photo; ?>' alt='User Image'>
<br><b>Name: <?php echo $sender_fullname1; ?></b> Accepted Your Friends Request says Thanks<br>
<span style='color:#800000;'><b> Time: </b> <span data-livestamp="<?php echo $timing;?>"></span></span><br>

<p>
<button class='pull-left col-sm-6 notify-delete-request-post notify-reject-friend-request-css' data-id='<?php echo $id; ?>'>Delete</button>
   <div class="loader-notify-delete_<?php echo $id; ?>"></div>
   <div class="result-notify-delete_<?php echo $id; ?>"></div>

</p>
<br>
</div>
<?php
}
?>





<?php 
if($type == 'rejected'){
?>


<div  style="color:black;padding:10px;background:#ddd">
<b style='color:red'> Friends Request Rejected...</b>

<a href='https://hackathon20-fesedo.quickbase.com/db/bqyb6cxvm?a=dbpage&pageID=15&id=<?php echo $sender_userid; ?>' class='pull-right post-css2' title='View Profile'>Profile</a>
<img style='max-height:60px;max-width:60px;' class='img-circle' src='<?php echo $sender_photo; ?>' alt='User Image'>
<br><b>Name: <?php echo $sender_fullname1; ?></b> Rejected Your Friends Request.<br>
<span style='color:#800000;'><b> Time: </b> <span data-livestamp="<?php echo $timing;?>"></span></span><br>

<p>
<button class='pull-left col-sm-6 notify-delete-request-post1 notify-reject-friend-request-css' data-id='<?php echo $id; ?>'>Delete</button>
   <div class="loader-notify-delete1_<?php echo $id; ?>"></div>
   <div class="result-notify-delete1_<?php echo $id; ?>"></div>

</p>
<br>
</div>
<?php
}
?>






</div>



<?php
}
?>

<?php
ob_flush();
?>


