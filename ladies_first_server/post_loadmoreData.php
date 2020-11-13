
        <script src="https://qbtut.com/ladies_first_server/publish_post1.js" type="text/javascript"></script>


<?php
error_reporting(0);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

 include('header_title.php');

$row  = $_POST['postRow'];
$row_per_page = 5;


//include quickbase token
include('quickbase_token.php');
include('quickbase_tables.php');

//$table_users
//$access_token
//$quickbase_domain


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
    "skip": '.$row.',
    "top": 5,
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



$output = '';

 foreach($json['data'] as $v1){
  

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



    $output .= '<div id="post_'.$id.'" class="post well">';
if($post_type == 'post' ){

$output .= "<div class=''>
<img class='' style='border-style: solid; border-width:3px; border-color:#ec5574; width:80px;height:80px; 
max-width:80px;max-height:80px;border-radius: 50%;' src='$photo' title='Image'><br>
<b style='color:#ec5574;font-size:18px;' >Name: $fullname </b><br><br>
</div>";

}



$output .= "<div style='float:right;top:0px;right:0;margin-top:-150px;right:0px;'>
<span class='point_count'><span>Scores: </span> $points Points</span>
<button class='post_css1'>
<a title='Click to access users Profile page' style='color:black;' href='https://hackathon20-fesedo.quickbase.com/db/bqyb6cxvm?a=dbpage&pageID=15&id=$userid'>
<span style='font-size:20px;color:#ec5574;' class='fa fa-user'></span> View Users Profile</a></button><br>

                        <div class='loader-request_$postid'></div>
                        <div class='result-request_$postid'></div>

<button class='post_css1'>
<a title=' Send Friends Request' style='color:black;' id='request_".$postid."_".$userid."' class='send_request'><span style='font-size:20px;color:#ec5574;' class='fa fa-comments-o'></span> Send Friends Request</a></button>

</div>";



if($post_type == 'post'){


if($offering1 == 'Seeking-Help'){

$output .= "<div class='help_css'>Seeking Assistance on ($category)</div><br>";

} 


if($offering1 == 'Offering-Help'){

$output .= "<div class='help_css'>Offering Assistance on ($category)</div><br>";

 }



if($category == 'Protests'){

$output .= "<div class='help_css'>Protests Posts</div><br>";

$output .= "
<button title='View Only this Protest on Map' class='map_css'>
<a target = '_blank' style='color:white;' href='https://hackathon20-fesedo.quickbase.com/db/bqyb6cxvm?a=dbpage&pageID=19&identity=$timing'>
<i  style='color:white;font-size:30px;' class='fa fa-map-marker' aria-hidden='true'></i>
View Only this Protest on Map </a></button>&nbsp;&nbsp;

<button title='View All Protests on Map' class='map_css1'><a target = '_blank' style='color:white;' href='https://hackathon20-fesedo.quickbase.com/db/bqyb6cxvm?a=dbpage&pageID=18'>
<i  style='color:white;font-size:30px;' class='fa fa-map-marker' aria-hidden='true'></i>
View All Protests on Map</a></button><br><br>";




 }


$output .= "<b class='title_css'>Title: $title</b><br><br>";


if($video != '0'){

$output .= "<iframe class='responsive_video' width='400' height='500' src='https://www.youtube.com/embed/$video'></iframe><br>
<br>";

 }


$output .= "<b >Descriptions:</b><br> $post_shortened ....<br>
<b>Location:</b> $address &nbsp; &nbsp; &nbsp;
<br>";

 } 






$output .= "<br>
<span><b> <span style='color:#ec5574;' class='fa fa-calendar'></span>Time:</b>  
<span data-livestamp='$timing'></span></span>";


                        $output .= "<div class='pc2'>
<br>
<span data-title='$title'  data-titleseo= '$title_seo'  data-userid ='$userid' data-points= '$points' title='Like'  id='like_$postid' style='font-size:26px;color:#ec5574;cursor:pointer;' class='like fa fa-thumbs-up'></span>
 <span class='loaderLike_$postid'></span>


&nbsp;&nbsp;(<span id='likes_$postid'> $total_likes</span>)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;



<span data-title='$title'  data-titleseo= '$title_seo'  data-userid ='$userid' data-points= '$points' title='UnLike' id='unlike_$postid' style='font-size:26px;color:#ec5574;cursor:pointer;' class='unlike fa fa-thumbs-down'></span>
 <span class='loaderunLike_$postid'></span>
&nbsp;&nbsp;(<span id='unlikes_$postid'>$total_unlikes</span>)



&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style='font-size:26px;color:#ec5574;' class='fa fa-comments'></span> 
&nbsp;<span id='$postid' style='cursor:pointer;' title='Comments' />
<a title='Comments' style='color:black' href='https://hackathon20-fesedo.quickbase.com/db/bqyb6cxvm?a=dbpage&pageID=20&title=$title_seo&pid=$postid&uid=$userid&tit=$title'>Comments</a></span>
(<span id='comment_$postid'>$total_comments</span>)


<br>
<br>
<button class='readmore_btn btn btn-warning'><a title='Click to Read More and Comments' style='color:white;' 
href='https://hackathon20-fesedo.quickbase.com/db/bqyb6cxvm?a=dbpage&pageID=20&title=$title_seo&pid=$postid'>Click to Read-More & Comments</a></button>
</div>";





  
    $output .= '</div>';

}

echo $output;
