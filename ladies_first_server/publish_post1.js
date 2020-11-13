$(document).ready(function(){





$(".send_request").click(function(){

// confirm start
 if(confirm("Are you sure you want to Send Friend Request to this Members: "))
     {

var post_id = this.id;
var explode_postid = post_id.split("_");
var like_first = explode_postid[0];
var postid_second = explode_postid[1]; 
var userid = explode_postid[2]; 
var post_id = postid_second;


var userid_sess_data = localStorage.getItem('useridsessdata');
var fullname_sess_data = localStorage.getItem('fullnamesessdata');
var photo_sess_data = localStorage.getItem('photosessdata');
var username_sess_data = localStorage.getItem('usernamesessdata');


var datasend = {'post_id': post_id, 'userid':userid, 'userid_sess_data':userid_sess_data, 'fullname_sess_data':fullname_sess_data, 'photo_sess_data':photo_sess_data, username_sess_data:username_sess_data};

//var datasend = "post_id="+ post_id + "&userid=" + userid;

$(".loader-request_"+post_id).fadeIn(400).html('<br><div style="color:black;background:white;padding:10px;"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i> &nbsp;Please Wait, Friend Request is being submitted...</div>');
        $.ajax({
            url: 'https://qbtut.com/ladies_first_server/request_send.php',
            type: 'post',
            data: datasend,
            crossDomain: true,
	    cache:false,
            success: function(msg){


if(msg == 1){
alert('Friend Request successfully Sent..');
$(".loader-request_"+post_id).hide();
$(".result-request_"+post_id).html("<div style='color:white;background:green;padding:10px;'>Friend Request successfully Sent.</div>");
setTimeout(function(){ $(".result-request_"+post_id).html(''); }, 5000);				

//location.reload();	

		

}


	if(msg == 0){
alert('Friend Request could not be Sent. Please ensure you are connected to Internet.');

$(".loader-request_"+post_id).hide();
$(".result-request_"+post_id).html("<div style='color:white;background:red;padding:10px;'>Friend Request could not be Sent. Please ensure you are connected to Internet.</div>");
setTimeout(function(){ $(".result-request_"+post_id).html(''); }, 5000);

}


if(msg == 2){
alert('Friend Request already exist between you and this Member.');

$(".loader-request_"+post_id).hide();
$(".result-request_"+post_id).html("<div style='color:white;background:red;padding:10px;'>You have already sent Friend Request to this Member.</div>");
setTimeout(function(){ $(".result-request_"+post_id).html(''); }, 5000);

}


if(msg == 3){
alert('You Cannot send Friend Request to Yourself.');

$(".loader-request_"+post_id).hide();
$(".result-request_"+post_id).html("<div style='color:white;background:red;padding:10px;'>You Cannot send Friend Request to Yourself</div>");
setTimeout(function(){ $(".result-request_"+post_id).html(''); }, 5000);

}

              

            }
        });
}

// confirm ends

    });









$(".like").click(function(){

var id = this.id;

var explode_postid = id.split("_");
var like_first = explode_postid[0];
var postid_second = explode_postid[1]; 
var post_id = postid_second;
var postid = postid_second;

var title = $(this).data('title'); 
var title_seo = $(this).data('titleseo');
var userid = $(this).data('userid'); 
var ppp = $(this).data('points');



//var userid_send1 =  $('.userid_send1').val();
//var fullname_send1 =  $('.fullname_send1').val();
//var photo_send1 =  $('.photo_send1').val();

//var userid_send2 = $(this).data('useridsend2');

//Get Session Data

var userid_sess_data = localStorage.getItem('useridsessdata');
var fullname_sess_data = localStorage.getItem('fullnamesessdata');
var photo_sess_data = localStorage.getItem('photosessdata');


var like_type = 1;

// start confirm
 if(confirm("Are you sure you want to Like this Post: ")){

//var datasend = "post_id="+ post_id + "&like_type=" + like_type + "&title=" + title + "&title_seo=" + title_seo + "&userid=" + userid + "&ppp=" + ppp;

$(".loaderLike_"+postid).fadeIn(400).html('<br><div style="color:black;background:#ddd;padding:10px;"><i class="fa fa-spinner fa-spin" style="font-size:20px"></i>&nbsp;Please Wait, Like is being Published...</div>');
var datasend = {'post_id': post_id,'like_type': like_type, 'title': title, 'title_seo': title_seo, 'userid': userid, 'ppp': ppp, 'userid_sess_data':userid_sess_data, 'fullname_sess_data':fullname_sess_data, 'photo_sess_data':photo_sess_data};
$.ajax({
			type:'POST',
			url:'https://qbtut.com/ladies_first_server/post_lu.php',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){

//alert(msg);
res1 = msg.replace('["','');
res2 = res1.replace('"]','');
//alert(res2);

var res = res2.split("-");
var likes = res[0];
var unlikes = res[1]; 
               
                $("#likes_"+post_id).text(likes);    
                $("#unlikes_"+post_id).text(unlikes);  
               
alert('Like Sent');
$(".loaderLike_"+postid).hide();
//$(".result-like_"+id).html("<div style='color:white;background:green;padding:10px;'>Like Sent Successfully</div>");
//setTimeout(function(){ $(".result-like_"+id).html(''); }, 5000);



}
			
		});
		
		


}
// end confirm

    });













$(".unlike").click(function(){
var id = this.id;

var explode_postid = id.split("_");
var unlike_first = explode_postid[0];
var postid_second = explode_postid[1]; 
var post_id = postid_second;
var postid = postid_second;

var title = $(this).data('title'); 
var title_seo = $(this).data('titleseo');
var userid = $(this).data('userid'); 
var ppp = $(this).data('points');


var userid_sess_data = localStorage.getItem('useridsessdata');
var fullname_sess_data = localStorage.getItem('fullnamesessdata');
var photo_sess_data = localStorage.getItem('photosessdata');


var like_type = 0;

// start confirm
 if(confirm("Are you sure you want to un-Like this Post: ")){

//var datasend = "post_id="+ post_id + "&like_type=" + like_type + "&title=" + title + "&title_seo=" + title_seo + "&userid=" + userid + "&ppp=" + ppp;


$(".loaderunLike_"+postid).fadeIn(400).html('<br><div style="color:black;background:#ddd;padding:10px;"><i class="fa fa-spinner fa-spin" style="font-size:20px"></i>&nbsp;Please Wait, unLike is being Published...</div>');
var datasend = {'post_id': post_id,'like_type': like_type, 'title': title, 'title_seo': title_seo, 'userid': userid, 'ppp': ppp, 'userid_sess_data':userid_sess_data, 'fullname_sess_data':fullname_sess_data, 'photo_sess_data':photo_sess_data};
$.ajax({
			type:'POST',
			url:'https://qbtut.com/ladies_first_server/post_lu.php',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){

//alert(msg);
res1 = msg.replace('["','');
res2 = res1.replace('"]','');
//alert(res2);

var res = res2.split("-");
var likes = res[0];
var unlikes = res[1]; 
               
                $("#likes_"+post_id).text(likes);    
                $("#unlikes_"+post_id).text(unlikes);  
               
alert('unLike Sent');
$(".loaderunLike_"+postid).hide();
//$(".result-like_"+id).html("<div style='color:white;background:green;padding:10px;'>unLike Sent Successfully</div>");
//setTimeout(function(){ $(".result-like_"+id).html(''); }, 5000);



}
			
		});
		
		


}
// end confirm

    });







//comment

$(".comment").click(function(){

var postid = this.id; 
var type = 1;
var comment_type=1;


var userid_sess_data = localStorage.getItem('useridsessdata');
var fullname_sess_data = localStorage.getItem('fullnamesessdata');
var photo_sess_data = localStorage.getItem('photosessdata');

//var comdesc = $('#comdesc'+postid).val();
var comdesc = $('#comdesc'+postid).val();
//var userid = $('#uid').val();
//var title = $(this).data('title');
//var title_seo = $(this).data('titleseo');


//pe is encrypted points
var pe = $(this).data('pe');


//data: {postid:postid,type:type,comment_type:comment_type,comdesc:comdesc, userid:userid, title:title, title_seo:title_seo, pe:pe},          
         


if(comdesc == ''){
alert('comment cannot be empty');
return false;
}
$(".loader_comments").fadeIn(400).html('<br><div style="color:black;background:white;padding:10px;"><i class="fa fa-spinner fa-spin" style="font-size:20px"></i>&nbsp;Please Wait, Your Comments is being Published...</div>');

        // AJAX Request
        $.ajax({
            url: 'https://qbtut.com/ladies_first_server/comment.php',
            type: 'post',
            dataType: 'json',
            data: {postid:postid,type:type,comment_type:comment_type,comdesc:comdesc, 'userid_sess_data':userid_sess_data, 'fullname_sess_data':fullname_sess_data, 'photo_sess_data':photo_sess_data},          
            crossDomain: true,
	    cache:false,
            success: function(data){

                var comment = data['comment'];
                var comdesc = data['comdesc'];
                var comment_username = data['comment_username'];
                 var comment_fullname = data['comment_fullname'];
 var comment_photo = data['comment_photo'];
 var comment_time = data['comment_time'];
var comment_userid = data['userid'];
var comment_id = data['comment_id'];


//alert(comment_photo);
              $("#comment_"+postid).text(comment);    // setting comment
               //$("#comdesc_"+postid).prepend(comdesc);    // setting comment
              // $("#commentusername_"+postid).prepend(comment_username);    // setting comment


  var comment_json = "<div class='alerts alert-warning comments_hovering'>" +

"<div class=''>"+   
//"<img style='border-style: solid; border-width:3px; border-color:#ec5574; width:60px;height:60px; max-width:60px;max-height:60px;border-radius: 50%;' src='uploads/" + comment_photo +"' /><br>" +
              
 "<img style='border-style: solid; border-width:3px; border-color:#ec5574; width:60px;height:60px; max-width:60px;max-height:60px;border-radius: 50%;' src=" + comment_photo +" /><br>" +
"<b style='color:$color6;font-size:18px;' >Name:" + comment_fullname + "</b><br><br></div>"+

"<div style='float:right;top:0px;right:0;right:0px;margin-top:-90px;'><button class='post_css1'>"+
"<a title='Click to access users Profile page' style='color:black;' href='https://hackathon20-fesedo.quickbase.com/db/bqyb6cxvm?a=dbpage&pageID=15&id=" + comment_userid +"' title='Click to access users page'>"+
"<span style='font-size:20px;color:#3b5998;' class='fa fa-user'></span> View Your Profile</a></button><br>"+
"<div class='loader-request_'+postid></div><div class='result-request_'+postid></div>"+
"<button class='post_css1'><a title=' Send Friends Request' style='color:black;' id='request_"+postid+"_"+comment_userid+"' class='send_request'><span style='font-size:20px;color:#3b5998;' class='fa fa-comments-o'></span> Send Yourself Request Disabled</a></button></div>"+
   "<b style='font-size:12px;text-align:left;'>Comment: </b>" + comdesc + "<br>" +
  "<span><b> <span class='fa fa-calendar'></span>Time:</b></span>" +
"<span data-livestamp='" + comment_time + "'></span></span>"+



                    "</div><p></p>";

                //$("#comdesc_"+postid).append(comment_json);

$("#commentsubmissionResult_"+postid).append(comment_json);

$(".loader_comments").hide();

            //$('#comdesc').val('');
$('#comdesc'+postid).val('');

alert('comments success');

            }
        });

    });










//report

 $(".report").click(function(){

        

     var postid = this.id;   // Getting Button id
     var type = 1;
var report_type=1;

//var reportingdesc = $('#reportingdesc'+postid).val();
var reportingdesc = $('#reportingdesc'+postid).val();

if(reportingdesc == ''){
alert('Reports Message cannot be empty');
return false;
}

        // AJAX Request
        $.ajax({
            url: 'report.php',
            type: 'post',
            data: {postid:postid,type:type,report_type:report_type,reportingdesc:reportingdesc},
            dataType: 'json',
            success: function(data){
                var report = data['report'];
                var reportingdesc = data['reportingdesc'];

              $("#report_"+postid).text(report);    // setting comment
               //$("#reportingdesc_"+postid).prepend(reportingdesc);    // setting comment

            //$('#comdesc').val('');
$('#reportingdesc'+postid).val('');

alert('Report Submitted');

            }
        });

    });


//start comment hideunhide

            $(".hidecomment_on_pageload").click(function(){
             var postid = this.id; 
$("#commentdataHide_"+postid).show();
            });



   $(".hidecomment_on_pageload_close").click(function(){
             var postid = this.id; 
$("#commentdataHide_"+postid).hide();
            });


            // hide all comment data on page load
            $("[id^='commentdataHide_']").hide();

//end comment hideunhide


       

//start report  hideunhide

            $(".hidereport_on_pageload").click(function(){
             var postid = this.id; 
            $("#reportdataHide_"+postid).show();
            });
           
            $(".hidereport_on_pageload_close").click(function(){
             var postid = this.id; 
            $("#reportdataHide_"+postid).hide();
            });


            // hide all report data on page load
            $("[id^='reportdataHide_']").hide()
  
//end report hideunhide










});