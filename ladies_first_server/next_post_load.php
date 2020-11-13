




            <?php
error_reporting(0);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$title_seo = strip_tags($_POST['title']);
$postID_call = strip_tags($_POST['pid']);
$postid= $postID_call;


//include quickbase token
include('quickbase_token.php');
include('quickbase_tables.php');



//$post_Userid_call = strip_tags($_GET['uid']);


//$title = strip_tags($_GET['tit']);
//$title_seo = strip_tags($_GET['title']);
//$points_encrypted =strip_tags($_GET['points_encrypted']);

$post_title_seo_field= 7;
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

 "where": "{'.$post_title_seo_field.'.CT.'.$title_seo.'}"

 
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
//$id_for_updates  = $json['data'][0]['3']['value'];


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
echo "<div style='background:red;color:white;padding:10px;'>Searched Post does not exist</div>";
exit();
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

                //$post_shortened = substr($content, 0, 90)."...";

$total_likes =$v1['20']['value'];
$total_unlikes =$v1['21']['value'];
 $total_comments =$v1['22']['value'];

	
	

                

   // }





            ?>


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



        <script src="https://qbtut.com/ladies_first_server/publish_post1.js" type="text/javascript"></script>


<div class='well'>



<div>

<?php
if($post_type){
?>
<img class='' style='border-style: solid; border-width:3px; border-color:#ec5574; width:80px;height:80px; 
max-width:80px;max-height:80px;border-radius: 50%;' src='<?php echo $photo; ?>'  title='User Image'><br>
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



<b class='title_css'>Title: <?php echo $title; ?></b><br><br>


<?php
if($video  != '0'){
?>
<iframe class='responsive_video' width='400' height='500' src='https://www.youtube.com/embed/<?php echo $video; ?>'>
</iframe><br><br>
<?php } ?>



<b >Descriptions:</b><br><?php echo $content; ?> ....<br>
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
&nbsp;<span id="<?php echo $postid; ?>" style="cursor:pointer;" title="Comments" />Comments</span>
(<span id="comment_<?php echo $postid; ?>"><?php echo $total_comments; ?></span>)


<br>
</div>




                </div>

            <?php
            }
            ?>




<!--start comments -->





        <div class="content">




            <?php

error_reporting(0);

//include quickbase token
include('quickbase_token.php');
include('quickbase_tables.php');


$row_per_page = 5;
$post_field_c= 6;
//$postid = strip_tags($_POST['pid']);
//$postID_call = $postid;

$url_c = "https://api.quickbase.com/v1/records/query";
$ch_c = curl_init();
curl_setopt($ch_c,CURLOPT_URL, $url_c);
$useragent_c ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';
// query commnts record

$post_c ='{
  "from": "'.$table_comments.'",
  "select": [
3,
6,
7,
8,
9,
10,
11


  ],

 
  
"where": "{'.$post_field_c.'.CT.'.$postid.'}",

 "sortBy": [
    {
      "fieldId": 3,
      "order": "ASC"
    },
    {
      "fieldId": 4,
      "order": "ASC"
    }
  ],



"options": {
    "skip": 0,
    "top": '.$row_per_page.',
    "compareWithAppLocalTime": false
  }

}
';




curl_setopt($ch_c, CURLOPT_HTTPHEADER, array(
"QB-Realm-Hostname: $quickbase_domain",
"User-Agent: $useragent_c",
"Authorization: QB-USER-TOKEN $access_token",
'Content-Type:application/json'
));  

//curl_setopt($ch_c,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch_c,CURLOPT_CUSTOMREQUEST,'POST');

//curl_setopt($ch_c,CURLOPT_CUSTOMREQUEST,'DELETE');
curl_setopt($ch_c,CURLOPT_POSTFIELDS, $post_c);
curl_setopt($ch_c,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch_c,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch_c,CURLOPT_RETURNTRANSFER, true);
$response_c = curl_exec($ch_c);

curl_close($ch_c);

//print_r($response_c);
$json_c = json_decode($response_c, true);


//echo "<br><br>num field: "  .$json_c["metadata"]["numFields"]. "<BR><br>";
//echo "<br><br>num rec: "  .$json_c["metadata"]["numRecords"]. "<BR><br>";

$total_count_c = $json_c["metadata"]["totalRecords"];

if($total_count_c == 0){
echo "<div style='background:red;color:white;padding:10px;'>No Comments has been Posted Yet by members</div>";
}

 foreach($json_c['data'] as $v2){

                $id2 = $v2['3']['value'];
$comment_id = $id2;
                $postid2 = $v2['6']['value'];
                $comment2 = $v2['7']['value'];
                $timing2 = $v2['8']['value'];
                $userid2 = $v2['9']['value'];
                $fullname2 = $v2['10']['value'];
                $photo2 = $v2['11']['value'];
                

	
	

                

   // }





            ?>
                
                <div class="post alerts alert-warning comments_hovering" id="post_<?php echo $comment_id; ?>">


<style>

.comments_hovering:hover{
background: pink;
color:black;


}


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


<img class='' style='border-style: solid; border-width:3px; border-color:#ec5574; width:60px;height:60px; 
max-width:60px;max-height:60px;border-radius: 50%;' src='<?php echo $photo2; ?>' alt='User Image'><br>
<b style='color:#ec5574;font-size:18px;' >Name: <?php echo $fullname2; ?> </b><br><br>

</div>


<div style='float:right;top:0px;right:0;margin-top:-90px;right:0px;'>
<button class='post_css1'>
<a title='Click to access users Profile page' style='color:black;' href='https://hackathon20-fesedo.quickbase.com/db/bqyb6cxvm?a=dbpage&pageID=15&id=<?php echo $userid2; ?>'>
<span style='font-size:20px;color:#ec5574;' class='fa fa-user'></span> View Users Profile</a></button><br>

                        <div class="loader-request_<?php echo $comment_id; ?>"></div>
                        <div class="result-request_<?php echo $comment_id; ?>"></div>

<button class='post_css1'>
<a title=' Send Friends Request' style='color:black;' id="request_<?php echo $comment_id; ?>_<?php echo $userid2; ?>" class="send_request"><span style='font-size:20px;color:#ec5574;' class='fa fa-comments-o'></span> Send Friends Request</a></button>

</div>






<b>Comments:</b> <?php echo $comment2; ?> &nbsp; &nbsp; &nbsp;

<br>
<span><b> <span style='color:#ec5574;' class='fa fa-calendar'></span>Time:</b>  <span data-livestamp="<?php echo $timing2;?>"></span></span>






                </div><p></p>

            <?php
            }
            ?>

<!--START comment result form-->

<div id="commentsubmissionResult_<?php echo $postid; ?>"></div>

<!--end comment result form-->


            <h1 class="loadComment  category_post" title='Load More Comments!'> Load More Comments</h1>


<?php
if($total_count_c < 5 || $total_count_c == 5){
?>
(<span class="no_of_row_loaded"><?php echo $total_count_c; ?></span> out of <span class="p"><?php echo $total_count_c; ?></span>)
 <?php } ?>

<?php
if($total_count_c > 5){
?>
(<span class="no_of_row_loaded">5</span> out of <span class="p"><?php echo $total_count_c; ?></span>)
 <?php } ?>

            <input type="hidden" id="postRow" value="0">
            <input type="hidden" id="pCounter" value="<?php echo $total_count_c; ?>">

        </div>



<!--START comment form-->

<div id="commentsubmissionResult_<?php echo $postid; ?>"></div>


<div class="col-sm-12 form-group">
 <textarea  id="comdesc<?php echo $postID_call; ?>"  class="form-control" style="color:black;"  placeholder="Enter Comments"></textarea>
<div class='loader_comments'></div>

<br>
 <input data-color='' data-color1='' data-pe='<?php echo $points_encrypted; ?>' data-title='<?php echo $title; ?>' data-titleseo='<?php echo $title_seo; ?>' type="button" value="comment Now" id="<?php echo $postID_call; ?>" class="comment category_post2 pull-left" />


</div>
<br><br><p class='col-sm-12'></p>





<!--end comment form -->




<!--end comments -->






<?php


// update table notification_posts with Unread for read Updates starts

$notifyId = intval($_POST['notifyId']);
if($notifyId != ''){


$status_field = 12;

$url_update = "https://api.quickbase.com/v1/records";
$ch_update = curl_init();
curl_setopt($ch_update,CURLOPT_URL, $url_update);
$useragent_update ='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';

$post_updates='

{
  "to": "'.$table_notification_post.'",
  "data": [
    {


      "'.$status_field.'": {
        "value": "read"
      },

 "3": {
        "value": "'.$notifyId.'"
      }

    }
  ],

 "fieldsToReturn": [
3,
    6,
    8,
12,
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



}


// update table notification_posts with Unread for read Updates starts

?>



