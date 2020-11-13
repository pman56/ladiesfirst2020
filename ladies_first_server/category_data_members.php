

<!-- connect members modal starts here -->


<div class="container_connect_members_modal">

  <div class="modal fade " id="myModal_connect_members" role="dialog">
    <div class="modal-dialog modal-lg modal-appear-center1 pull-right modaling_sizing">
      <div class="modal-content">
        <div class="modal-header" style="color:black;background:#c1c1c1">
 <button type="button" class="pull-right btn btn-default" data-dismiss="modal">Close</button>
      <h4 class="modal-title">Community Members Connections</h4>
        </div>
        <div class="modal-body">

<h4>Easily Connect with Community (<b id='c_members'></b>) </h4><br>


<div style='background:#ddd;color:black;padding:10px;border-style: dashed; border-width:2px; border-color: orange;'>

<!--form START-->



        <script>


$(document).ready(function(){

$('.connect_members_btn').click(function(){
	
var connect_members = $(this).data('name');
var cm=  $("#c_members").html(connect_members);
alert(connect_members);

if(connect_members==""){
//alert('Search Content cannot be empty');	
		}
else{
$('#loader_c_members').fadeIn(400).html('<br><span class="well alerts alert-info"><img src="ajax-loader.gif" align="absmiddle">&nbsp;Please Wait, Community Members is being Retrieved..</span>');
var datasend = "search_data="+ connect_members;
		
		$.ajax({
			
			type:'POST',
			url:'members_connect.php',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){
	                       //$('#search_data_members').val('');
				
                                $("#result_c_members").html(msg);
				$('#alerts_c_members').delay(5000).fadeOut('slow');
                                $('#loader_c_members').hide();			
			}
			
		});
		
		}
		
	})
					
});


        </script>



<div id="loader_c_members"></div>
<div id="result_c_members"></div>



<br><br>


</div><br>


<!--form ENDS-->


        </div>
        <div class="modal-footer" style="color:black;background:#c1c1c1">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>



<!--  connect members modal ends here -->




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




