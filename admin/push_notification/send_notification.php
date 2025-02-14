<?php  
error_reporting(0);
$path = $_SERVER['DOCUMENT_ROOT'];
include($path.'/admin/'.'dbconfig.php');
$error = '';


?>
<div class="content">
<div class="container-fluid">
<div class="row">
<div class="col-sm-12" style="margin-top:80px;">
<div class="panel panel-default panel-table">
<div class="panel-heading">
    <div class="row">
         <div class="col-ms-12">
      
    	
    	<div class="alert alert-info alert-dismissible fade in " id="msg_div" style="display:none" role="alert" style="padding:15px 30px 10px 20px;">
    	     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    	
    	<p id="msg"></p>
    	</div>
    </div>
<div class="row">
  <div class="col col-xs-6">
    <h3 class="panel-title"> Send Notification</h3>
  </div>
 
 
</div>
</div>

<div class="card-content">
<?php //print_r($userData); ?>
<!--  add user form -->
<form method="post"  id="notify_form" enctype="multipart/form-data">
<div class="row">
<div class="col-sm-12">
    <div class="col-sm-12">
	<div class="card-content">
	<div class="card-panel">
	
	<div class="col-md-12">
        <div class="form-group">
            <label class="control-label">Notification Title</label>
            <input type="text" class="form-control" name="notif_title" id="notif_title" placeholder="Notification Title" >
        </div>
	</div>
	<div class="col-md-12">
        <div class="form-group">
            <label class="control-label">Notification Message</label>
            <textarea class="form-control" name="notif_msg" id="notif_msg" placeholder="Notification Messsage" ></textarea>
        </div>
	</div>
		<div class="col-md-12">
        <div class="form-group">
            <label class="control-label">Category</label>
            <select name="category" class="form-control" id="category">
			
			<?php 
			$page = '';
			$data_user = $db->getAll('tbl_users', $page); 
			$data_decode = json_decode($data_user, true);
			$users = $data_decode['Result'];
			$k =0;
			foreach($users as $user){ ?>
				<option  value="<?php echo $user['ID']; ?>">
				<?php echo $user['Full_Name']; ?></option>
				<?php 
			$k++;
			}
			?>
			</select>
        </div>
		</div>
		
		<div class="col-md-12">
        <button type="submit" name="submit" class="btn btn-primary pull-right" id="send"> Send</button>
        </div>



		
		
		
    </div></div>
	</div>
	</div>
</div>



<div class="clearfix"></div>
</form>
<!-- add user form ends -->
</div>

</div>
</div>

</div>
</div> 
</div>

<script type="text/javascript">

//image preview
  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.style.display='block';
    var editpic = document.getElementById('edit_pic');
    editpic.style.display='none';
  };
  
  //HIDE SUCCESS ALERT
  $("#msg_div").fadeTo(5000, 500).slideUp(500, function(){
        $("#msg_div").slideUp(500);
    });


jQuery(document).ready(function($){
 $("#notify_form").submit(function(){
	 
var notify_title = $("#notify_title").val();
var notify_msg = $("#notify_msg").val();
if(notify_title == ""){
    $("#notify_title").focus();
    $("#notify_title").attr("placeholder","Please Enter notification Title").css("border", "1px solid red;");
	return false;
}else if(notify_msg == ""){
    $("#notify_msg").focus();
    $("#notify_msg").css("border", "1px solid red;");
	return false;
}else{
     $.ajax({
        url: "push_notification/insert_notification.php",
        type: "POST",
        data: {'notify_title':notify_title,'notify_msg':notify_msg,'action':'AddNotification'},
        success: function(rel){
          //alert(rel);
          //console.log(rel);
          var obj = jQuery.parseJSON(rel);
          
          if(obj.result=="TRUE")
          {
            $("#msg_div").css({'display':'block'});
            $("#msg").text(obj.message);
          }else if(obj.result=="FALSE"){ 
            $("#msg").html(obj.message).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
          }
        }
      });        
    return false;  
}
});
});
</script>

