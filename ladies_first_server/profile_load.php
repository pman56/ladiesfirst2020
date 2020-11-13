
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
$request_userid= intval($_POST['r_id']);

// query users table

$userid_field_query = 3;
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

  "where": "{'.$userid_field_query.'.CT.'.$request_userid.'}"

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
$user_rec_count = $json3["metadata"]["numRecords"];

$u_rec_id = $json3["data"][0]["3"]["value"];
$fullname = $json3["data"][0]["8"]["value"];
$photo = $json3["data"][0]["10"]["value"];
$user_rank = $json3["data"][0]["11"]["value"];
$points = $json3["data"][0]["14"]["value"];
$levels = $json3["data"][0]["15"]["value"];
$created_time = $json3["data"][0]["12"]["value"];

if($json3 == ''){
//if($total_count == ''){
echo "
<script>
function reloadPage() {
location.reload();
}
</script>
<div style='background:red;color:white;padding:10px;'>No Network. Refresh page and ensure there is Internet Connection <br><br> <center><button class='readmore_btn' style='' title='Refresh Page' onclick='reloadPage()'>Refresh Page</button></center> </div>";
exit();
}


if($user_rec_count == 0){
echo "<div style='background:red;color:white;padding:10px;'>No Record Found for the Queried User..</div>";
exit();
}



?>




<!--create profile form START here-->

<div  class='col-sm-12' style='border-style: dashed; border-width:2px; border-color: orange;color:black;padding:10px;background:#eeeeee'>

<h3><center>Members Profiles/Posts</center></h3>
<div class='col-sm-6'>
<img style='max-height:200px;max-width:200px;' class='img-rounded' width='200px' height='200px' src='<?php echo $photo; ?>'>
<br>
</div>
<div class='col-sm-6'>
<b> Name:</b> <?php echo htmlentities(htmlentities($fullname, ENT_QUOTES, "UTF-8")); ?>
<br>
<b style='font-size:16px;'> Profession:</b> <?php echo htmlentities(htmlentities($user_rank, ENT_QUOTES, "UTF-8")); ?><br>
<b style='font-size:16px;'> Status:</b> Verified Member<br>
<b style='font-size:16px;color:green'> Awarded  Points:</b> <span title='Awarded Points:(<?php echo htmlentities(htmlentities($points, ENT_QUOTES, "UTF-8")); ?>) ' class='point_count'><?php echo htmlentities(htmlentities($points, ENT_QUOTES, "UTF-8")); ?></span><br>
<?php
$up = htmlentities(htmlentities($points, ENT_QUOTES, "UTF-8"));

$min1 = 0;
$max1 =100;
if (in_array($up, range($min1, $max1), true)) {
   echo "<b style='font-size:20px;color:#ec5574'> Helper Level: 1</b><br>";
}

$min2 = 101;
$max2 =200;

if (in_array($up, range($min2, $max2), true)) {
   echo "<b style='font-size:20px;color:#ec5574'> Helper Level: 2</b><br>";
}



$min3 = 201;
$max3 =300;

if (in_array($up, range($min3, $max3), true)) {
   echo "<b style='font-size:20px;color:#ec5574'> Helper Level: 2</b><br>";
}

?>



<b style='font-size:20px;color:#ec5574'> Helper Level: <?php echo htmlentities(htmlentities($levels, ENT_QUOTES, "UTF-8")); ?></b><br>
<b style='font-size:20px;color:#ec5574'> This Member has : <?php //echo $st_count; ?> Posts</b><br>


<b style='font-size:16px;'> Member Since:</b> <span data-livestamp='<?php echo $created_time; ?>'></span><br>
<div style='background:#ec5574;color:white;padding:10px;border-radius:20%;font-size:16px;'><i  style='font-size:20px;' class='fa fa-check'></i> User Verified</div>
</div>


<script>
$(document).ready(function(){

$(".send_request_new").click(function(){

// confirm start
 if(confirm("Are you sure you want to Send Friend/Chat Request to this Members: "))
     {
var userid= $(this).data('uid');
var post_id = 1;
//alert(userid);


var datasend = "post_id="+ post_id + "&userid=" + userid;

$(".loader-request_"+post_id).fadeIn(400).html('<br><div style="color:white;background:#ec5574;padding:10px;"><img src="ajax-loader.gif">&nbsp;Please Wait, Request is being Processed...</div>');
        $.ajax({
            url: 'request_send.php',
            type: 'post',
            data: datasend,
            crossDomain: true,
	    cache:false,
            success: function(msg){


if(msg == 1){
alert('Friend/Chat Request successfully Sent..');
$(".loader-request").hide();
$(".result-request").html("<div style='color:white;background:green;padding:10px;'>Friend/Chat Request successfully Sent.</div>");
setTimeout(function(){ $(".result-request").html(''); }, 5000);				

//location.reload();	

		

}


	if(msg == 0){
alert('Friend/Chat Request could not be Sent. Please ensure you are connected to Internet.');

$(".loader-request").hide();
$(".result-request").html("<div style='color:white;background:red;padding:10px;'>Friend/Chat Request could not be Sent. Please ensure you are connected to Internet.</div>");
setTimeout(function(){ $(".result-request").html(''); }, 5000);

}


if(msg == 2){
alert('You have already sent Friend/Chat Request to this Member.');

$(".loader-request").hide();
$(".result-request").html("<div style='color:white;background:red;padding:10px;'>You have already sent Friend/Chat Request to this Member.</div>");
setTimeout(function(){ $(".result-request").html(''); }, 5000);

}


if(msg == 3){
alert('You Cannot send Friend/Chat Request to Yourself.');

$(".loader-request").hide();
$(".result-request").html("<div style='color:white;background:red;padding:10px;'>You Cannot send Friend/Chat Request to Yourself</div>");
setTimeout(function(){ $(".result-request").html(''); }, 5000);

}

              

            }
        });
}

// confirm ends

    });

});

</script>

<div class='row'>
<br>
<div style='display:none; background:#c1c1c1;padding:20px;cursor:pointer' class='send_request_new col-sm-12' title='Send Friend Request' data-uid='<?php echo htmlentities(htmlentities($row1['id'], ENT_QUOTES, "UTF-8")); ?>' >

                        <div class="loader-request"></div>
                        <div class="result-request"></div>

<i style='font-size:30px;color:;' class='fa fa-user-plus'></i> Send Friend Request to (<b><?php echo htmlentities(htmlentities($fullname, ENT_QUOTES, "UTF-8")); ?></b>)</div>
<div disabled style='display:none; background:#c1c1c1;padding:20px;cursor:pointer' class='col-sm-6' title='Book Appointments'>
 <i style='font-size:30px;color:;' class='fa fa-handshake-o'></i> Book Appointments</div>
<br>
</div>



</div>


<div  class='col-sm-12' style='width:100%;'><br><br></div>






<!--create profile form ENDS-->
