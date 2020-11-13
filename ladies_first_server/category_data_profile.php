




<?php
error_reporting(0);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$result = '{
"Male":"0",
"Female":1

}';




$json = json_decode($result, true);

echo "

<center>
<span class='dropdown'>
  <a title='Connect to Other Members' class='dropdown-toggle'
 data-toggle='dropdown'><button class='category_post'><i style='font-size:20px;color:orange;' class='fa fa-connectdevelop'>
</i>Connect Members</button>
</a>

<ul class='dropdown-menu col-sm-12' style='width:300px;'><h4>Connect Members Categories</h4>";

foreach($json as $da => $va) {
  //echo $da . " => " . $va . "<br>";

//<p><li title='$da'><a href='members.php?data_type=$da'>$da</a></li></p>
echo "<p><li title='$da'><a class='connect_members_btn' data-name='$da' data-toggle='modal' data-target='#myModal_connect_members' >$da</a></li></p>";


}

echo "</ul></span></center>";
?>




