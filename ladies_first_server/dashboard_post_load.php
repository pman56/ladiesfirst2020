﻿

<?php
error_reporting(0);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

ini_set('max_execution_time', 300); //300 seconds = 5 minutes
// temporarly extend time limit
set_time_limit(300);


?>
        <script src="https://qbtut.com/ladies_first_server/publish_post1.js" type="text/javascript"></script>
       
       <script>



$(document).ready(function(){


    $('.loadPost').click(function(){
        var postRow = Number($('#postRow').val());
        var postCount = Number($('#pCounter').val());
        postRow = postRow + 5;

        if(postRow <= postCount){
            $("#postRow").val(postRow);

            $.ajax({
                url: 'https://qbtut.com/ladies_first_server/post_loadmoreData.php',
                type: 'post',
                data: {postRow:postRow},
                beforeSend:function(){
                    //$(".loadPost").text("Loading Data...");
$(".loadPost").html("<span class='loader_post'></span> Loading Data...");
                    $('.loader_post').fadeIn(400).html('<span><i class="fa fa-spinner fa-spin" style="font-size:20px"></i></span>');

                },
                success: function(response){
                    setTimeout(function() {
                        $(".post:last").after(response).show().fadeIn("slow");
 
                        var rowno = postRow + 5;

//check number of row loaded
if(rowno > postCount){

var pRow = Number($('#postRow').val());
var pCount = Number($('#pCounter').val());

var remaining_row = pCount - pRow;

var pRow1 = pRow + remaining_row;
$(".no_of_row_loaded").text(pRow1);

}else{

$(".no_of_row_loaded").text(rowno);
}

                   
                        if(rowno > postCount){
                            $('.loadPost').text("No More Content to Load");
                              $('.loader_post').hide();
                        }else{
                            $(".loadPost").text("Load more");
                           $('.loader_post').hide();
                        }
                    }, 2000);
                   


                }
            });
        }

    });

});




$(document).ready(function(){
var userid_sess_data = localStorage.getItem('useridsessdata');
var fullname_sess_data = localStorage.getItem('fullnamesessdata');
var photo_sess_data = localStorage.getItem('photosessdata');
$('#myd_userid_sess_value').val(userid_sess_data).value;
$('#myd_userid_sess_id').html(userid_sess_data);

$('#myd_fullname_sess_value').val(fullname_sess_data).value;
$('#myd_photo_sess_value').val(photo_sess_data).value;
});



</script>




<style>
.point_count { color: #FFF; display: block; float: right; border-radius: 12px; border: 1px solid #2E8E12; background: #ec5574; padding: 2px 6px;font-size:20px; }
.point_count1 { color:#FFF; display: block; float: right; border-radius: 12px; border: 1px solid #2E8E12; background: purple; padding: 2px 6px;font-size:20px; }


</style>






<!--start loading post-->



<!--input type='text' id='myd_userid_sess_value' class='userid_send1' value='' -->
<!--input type='text' id='myd_fullname_sess_value' class='fullname_send1' value=''-->
<!--input type='text' id='myd_photo_sess_value' class='photo_send1' value=''-->

<div style='display:none;' id='myd_userid_sess_id' data-useridsend2='myd_userid_sess_id'></div>


        <div class="content">


<?php


//include quickbase token
include('quickbase_token.php');
include('quickbase_tables.php');

?>



            <?php

$row_per_page = 5;


//include quickbase token
//include('quickbase_token.php');
//include('quickbase_tables.php');


$post_type_field= 13;
$post_value= 'post';

$url = "https://api.quickbase.com/v1/records/query";
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
$useragent ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';
// query Posts record

$post ='{
  "from": "'.$table_posts.'",
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
17,
18,
19,
20,
21,
22


  ],

 "where": "{'.$post_type_field.'.CT.'.$post_value.'}",

 "sortBy": [
    {
      "fieldId": 4,
      "order": "DESC"
    },
    {
      "fieldId": 5,
      "order": "DESC"
    }
  ],

  



"options": {
    "skip": 0,
    "top": '.$row_per_page.',
    "compareWithAppLocalTime": false
  }

}
';




curl_setopt($ch, CURLOPT_HTTPHEADER, array(
"QB-Realm-Hostname: $quickbase_domain",
"User-Agent: $useragent",
"Authorization: QB-USER-TOKEN $access_token",
'Content-Type:application/json'
));  

//curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');

//curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'DELETE');
curl_setopt($ch,CURLOPT_POSTFIELDS, $post);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

curl_close($ch);

//print_r($response);
$json = json_decode($response, true);


//echo "<br><br>num field: "  .$json["metadata"]["numFields"]. "<BR><br>";
//echo "<br><br>num rec: "  .$json["metadata"]["numRecords"]. "<BR><br>";

$total_count = $json["metadata"]["totalRecords"];

if($json == ''){
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


if($total_count == 0){
echo "<div style='background:red;color:white;padding:10px;'>No Post  has been Created Yet by members</div>";
}

 foreach($json['data'] as $v1){


          //echo $v1['3']['value'];

$id = $v1['3']['value'];
                $postid = $v1['3']['value'];
                $title = $v1['6']['value'];
                $title_seo = $v1['7']['value'];
                //$content = $v1['8']['value'];
$content = html_entity_decode(html_entity_decode($v1['8']['value']));
                $timing = $v1['9']['value'];
                $userid = $v1['10']['value'];
                $fullname = $v1['11']['value'];
                $photo = $v1['12']['value'];
                $post_type = $v1['13']['value'];
                $video = $v1['14']['value'];
                $category = $v1['15']['value'];
                $points = $v1['16']['value'];
                $offering = $v1['17']['value'];
                $offering1 = $v1['18']['value'];
                $address = $v1['19']['value'];

                $post_shortened = substr($content, 0, 90)."...";

$total_likes =$v1['20']['value'];
$total_unlikes =$v1['21']['value'];
 $total_comments =$v1['22']['value'];

	/*
	
//encrypt points to avoid cheating before passing it in the URL
$your_encryption_secret ='iamayoungprogrammerplease';
$points_encrypt = $points;
$encrypted_points=openssl_encrypt($points_encrypt ,"AES-128-ECB",$your_encryption_secret);
//$decrypted_points=openssl_decrypt($encrypted_points,"AES-128-ECB",$your_encryption_secret);
*/


                

   // }





            ?>
                
                <div class="post well" id="post_<?php echo $postid; ?>">


<style>
.post_css1{
background:#ddd;
color:black;
border:none;
padding:10px;
border-radius:20%;
}


.post_css1:hover{
background:orange;
color:black;


}



.help_css{
background:#ddd;
color:black;
border:none;
padding:10px;
border-radius:20%;
font-size:20px;
}


.help_css:hover{
background:orange;
color:black;


}




</style>

<div>

<?php
if($post_type){
?>
<img class='' style='border-style: solid; border-width:3px; border-color:#ec5574; width:80px;height:80px; 
max-width:80px;max-height:80px;border-radius: 50%;' src='<?php echo $photo; ?>' title='Image'><br>
<b style='color:#ec5574;font-size:18px;' >Name: <?php echo $fullname; ?> </b><br><br>

<?php } ?>

</div>


<div style='float:right;top:0px;right:0;margin-top:-150px;right:0px;'>
<span class='point_count'><span>Scores: </span> <?php echo $points; ?> Points</span>
<button class='post_css1'>
<a title='Click to access users Profile page' style='color:black;' href='https://hackathon20-fesedo.quickbase.com/db/bqyb6cxvm?a=dbpage&pageID=15&id=<?php echo $userid; ?>'>
<span style='font-size:20px;color:#ec5574;' class='fa fa-user'></span> View Users Profile</a></button><br>

                        <div class="loader-request_<?php echo $postid; ?>"></div>
                        <div class="result-request_<?php echo $postid; ?>"></div>

<button class='post_css1'>
<a title=' Send Friends Request' style='color:black;' id="request_<?php echo $postid; ?>_<?php echo $userid; ?>" class="send_request"><span style='font-size:20px;color:#ec5574;' class='fa fa-comments-o'></span> Send Friends Request</a></button>

</div>




<?php
if($post_type == 'post'){
?>

<?php
if($offering1 == 'Seeking-Help'){
?>
<div class='help_css'>Seeking Assistance on (<?php echo $category; ?>)</div><br>

<?php } ?>



<?php
if($offering1 == 'Offering-Help'){
?>
<div class='help_css'>Offering Assistance on (<?php echo $category; ?>)</div><br>

<?php } ?>


<?php
if($category =='Protests'){
?>
<div class='help_css'>Protests Posts</div><br>

<button title='View Only this Protest on Map' class="map_css"><a target = "_blank" style="color:white;" href="https://hackathon20-fesedo.quickbase.com/db/bqyb6cxvm?a=dbpage&pageID=19&identity=<?php echo $timing; ?>">
<i  style="color:white;font-size:30px;" class="fa fa-map-marker" aria-hidden="true"></i>
View Only this Protest on Map </a></button>&nbsp;&nbsp;

<button title='View All Protests on Map' class="map_css1"><a target = "_blank" style="color:white;" href="https://hackathon20-fesedo.quickbase.com/db/bqyb6cxvm?a=dbpage&pageID=18">
<i  style="color:white;font-size:30px;" class="fa fa-map-marker" aria-hidden="true"></i>
View All Protests on Map</a></button><br><br>


<?php } ?>


<b class='title_css'>Title:<?php echo $title; ?></b><br><br>
<?php
if($video  != '0'){
?>
<iframe class='responsive_video' width='400' height='500' src='https://www.youtube.com/embed/<?php echo $video; ?>'>
</iframe><br><br>
<?php } ?>

<b >Descriptions:</b><br><?php echo $post_shortened; ?> ....<br>
<b>Location:</b> <?php echo $address; ?> &nbsp; &nbsp; &nbsp;

<?php } ?>



<br><br>
<span><b> <span style='color:#ec5574;' class='fa fa-calendar'></span>Time:</b>  <span data-livestamp="<?php echo $timing;?>"></span></span>



                        <div class="pc2">
<br>
<span data-title="<?php echo $title; ?>"  data-titleseo= "<?php echo $title_seo; ?>"  data-userid ="<?php echo $userid; ?>" data-points= "<?php echo $points; ?>" title="Like"  id="like_<?php echo $postid; ?>" style="font-size:26px;color:#ec5574;cursor:pointer;" class="like fa fa-thumbs-up"></span>
 <span class="loaderLike_<?php echo $postid; ?>"></span>


&nbsp;&nbsp;(<span id="likes_<?php echo $postid; ?>"><?php echo $total_likes; ?></span>)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;



<span data-title="<?php echo $title; ?>"  data-titleseo= "<?php echo $title_seo; ?>"  data-userid ="<?php echo $userid; ?>" data-points= "<?php echo $points; ?>" title="UnLike" id="unlike_<?php echo $postid; ?>" style="font-size:26px;color:#ec5574;cursor:pointer;" class="unlike fa fa-thumbs-down"></span>
 <span class="loaderunLike_<?php echo $postid; ?>"></span>
&nbsp;&nbsp;(<span id="unlikes_<?php echo $postid; ?>"><?php echo $total_unlikes; ?></span>)



&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style="font-size:26px;color:#ec5574;" class="fa fa-comments"></span> 
&nbsp;<span id="<?php echo $postid; ?>" style="cursor:pointer;" title="Comments" /><a title='Comments' style='color:black' href='https://hackathon20-fesedo.quickbase.com/db/bqyb6cxvm?a=dbpage&pageID=20&title=<?php echo $title_seo; ?>&pid=<?php echo $postid; ?>&uid=<?php echo $userid; ?>&tit=<?php echo $title; ?>'>Comments</a></span>
(<span id="comment_<?php echo $postid; ?>"><?php echo $total_comments; ?></span>)


<br>
<br>
<button class='readmore_btn btn btn-warning'><a title='Click to Read More and Comments' style='color:white;' 
href='https://hackathon20-fesedo.quickbase.com/db/bqyb6cxvm?a=dbpage&pageID=20&title=<?php echo $title_seo; ?>&pid=<?php echo $postid; ?>&notifyId='>Click to Read-More & Comments</a></button>
</div>




                </div>

            <?php
            }
            ?>

            <h1 class="loadPost  category_post" title='Load More Post!'> Load More Posts</h1>


<?php
if($total_count < 5 || $total_count == 5){
?>
(<span class="no_of_row_loaded"><?php echo $total_count; ?></span> out of <span class="p"><?php echo $total_count; ?></span>)
 <?php } ?>

<?php
if($total_count > 5){
?>
(<span class="no_of_row_loaded">5</span> out of <span class="p"><?php echo $total_count; ?></span>)
 <?php } ?>

            <input type="hidden" id="postRow" value="0">
            <input type="hidden" id="pCounter" value="<?php echo $total_count; ?>">

        </div>




<!--End loading posts-->
