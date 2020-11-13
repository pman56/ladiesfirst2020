<?php
error_reporting(0);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



$result = '{
"Menstral-Cycle":"0",
"Jobs":1,
"Computer-Learning":2,
"Sexual-Harrasment":3,
"Racism":4,
"Police-Brutality":5,
"Marginalization":6,
"Education":7,
"Advice":8,
"Health":9,
"Racism":10,
"Enterpreneurship":11,
"Families":12,
"Stories":13,
"News":14,
"Others":15


}';






$json = json_decode($result, true);

echo "<div class='dropdown'>
  <button class='btn btn-default dropdown-toggle' type='button' data-toggle='dropdown'>Select Category Type
  <span class='caret'></span></button>

<ul class='dropdown-menu col-sm-12'>";

foreach($json as $da => $va) {
  //echo $da . " => " . $va . "<br>";


echo "
<p><li title='$da'><a href='https://hackathon20-fesedo.quickbase.com/db/bqyb6cxvm?a=dbpage&pageID=21&data_type=$da'>$da</a></li></p>
";


}

echo "
</ul></div>
</div>
<br><br><br>
</div><br>";
?>




