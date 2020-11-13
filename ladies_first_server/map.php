<?php 
error_reporting(0);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 // ensure that there is no whitespace and included file quickbase_token.php does not have whitespace
header("Content-type: text/xml");
include('quickbase_token.php');
include('quickbase_tables.php');
// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);
//$identity = strip_tags($_GET['identity']);
$lat_field= 23;
$post_value= '';
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
22,
23,
24
  ],

 "where": "{'.$lat_field.'.XEX.'.$post_value.'}"


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
$total_count = $json["metadata"]["totalRecords"];
 foreach($json['data'] as $v1){
                $id = $v1['3']['value'];
                $postid = $v1['3']['value'];
                $title = $v1['6']['value'];
                $title_seo = $v1['7']['value'];
                $content = $v1['8']['value'];
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
                $lat = $v1['23']['value'];
                $lng = $v1['24']['value'];
                $data ='public';
                $type = 1;
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("id",$id);
  $newnode->setAttribute("name",$fullname);
  $newnode->setAttribute("photo",$photo);
  $newnode->setAttribute("address", $address);
  $newnode->setAttribute("lat", $lat);
  $newnode->setAttribute("lng", $lng);
  $newnode->setAttribute("type", $type);
  $newnode->setAttribute("data_type", $data);
$newnode->setAttribute("fullname", $fullname);
$newnode->setAttribute("userid", $userid);
$newnode->setAttribute("timing", $timing);
}
echo $dom->saveXML();
?>