<?php 
//session_start();
//date_default_timezone_set("Asia/Kolkata"); 
require_once('DBInterface.php');
//include("DBInterface.php");
$uid=$_SESSION['sess_login_id'];
 // echo $uid;
$db = new Database();
$db->connect();

$name = $db->getName($uid);
$email = $db->getEmail($uid);


/*$_SESSION['user']	= array(
			'name'		=> $name,
			'gravatar'	=> $email
		);*/
		


?>

<?php
include('live_chat/database_connection.php');	


                $query1 = "SELECT * FROM  chat_login_details WHERE user_id = '".$uid."' ORDER BY login_details_id DESC LIMIT 1  ";
            	$statement1 = $connect->prepare($query1);
            	$statement1->execute();	
            	$count1 = $statement1->rowCount();
            	$row=$statement1->fetch();
            	//echo "def".$count1;
            	if($count1==0)
            	{
            	     $_SESSION['user_id'] = $uid;
				$_SESSION['username'] = $name;
				$last_activity=date("Y-m-d H:i:s");
				$sub_query = "INSERT INTO chat_login_details (user_id,last_activity) VALUES ('".$uid."','".$last_activity."') ";
				//echo $sub_query ;
				$statement = $connect->prepare($sub_query);
				$statement->execute();
				$_SESSION['login_details_id'] = $connect->lastInsertId();
				//$_SESSION['login_details_id']=$uid;
            	    
            	}else{
            	     $_SESSION['user_id'] = $uid;
			    	$_SESSION['username'] = $name;
            	    $last_activity=date("Y-m-d H:i:s");
            	    $sub_query = "UPDATE chat_login_details SET user_id='".$uid."', last_activity='".$last_activity."' WHERE user_id='".$uid."' ";
            	    //echo $sub_query;
            		$statement = $connect->prepare($sub_query);
            		$statement->execute();
            	//$_SESSION['login_details_id'] = $connect->lastInsertId();
            	$_SESSION['login_details_id']=$row['login_details_id'];
            	
            		
            	}
            	//echo 	$_SESSION['login_details_id'];

   /*
	$query = "SELECT * FROM  tbl_users WHERE ID = '".$uid."' ";
	$statement = $connect->prepare($query);
	$statement->execute();	
	$count = $statement->rowCount();
	if($count > 0)
	{
	        	$row = $statement->fetch();
	        	
	        	$query1 = "SELECT * FROM  chat_login_details WHERE user_id = '".$uid."' ";
            	$statement1 = $connect->prepare($query1);
            	$statement1->execute();	
            	$count1 = $statement1->rowCount();
            	//echo $count1;
            	if($count1==0)
            	{
            	     $_SESSION['user_id'] = $row['ID'];
				$_SESSION['username'] = $row['Full_Name'];
				$last_activity=date("Y-m-d H:i:s");
				$sub_query = "INSERT INTO chat_login_details (user_id,last_activity) VALUES ('".$row['ID']."','".$last_activity."') ";
				$statement = $connect->prepare($sub_query);
				$statement->execute();
				//$_SESSION['login_details_id'] = $connect->lastInsertId();
				$_SESSION['login_details_id']=$uid;
            	    
            	}else{
            	    $last_activity=date("Y-m-d H:i:s");
            	    $sub_query = "UPDATE chat_login_details SET user_id='".$uid."', last_activity='".$last_activity."' WHERE user_id='".$uid."' ";
            	    //echo $sub_query;
            		$statement = $connect->prepare($sub_query);
            		$statement->execute();
            		//$_SESSION['login_details_id'] = $connect->lastInsertId();
            	$_SESSION['login_details_id']=$uid;
            	echo "cerf".	$_SESSION['login_details_id'];
            		
            	}
	
			 
				
	
	}*/
	

?>

		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
       <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  		<script src="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.js"></script>
  		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>-->
     
        <div class="container">
            
		    <div class="row" style="margin-top:50px;">
		        <div class="col-sm-6">
		             <div class="panel panel-default">
                        <div class="panel-heading"> <h4 align="center">Token  - Support</h4></div>
                        <div class="panel-body">
                            <center>
                            <p style="color:#000;">Contact us for token support</p>
                            <button type="button" class="btn btn-info"> Contact us</button>
                            </center>
                         </div>
                      </div>
		        </div>
		        <div class="col-sm-6">
		           
		            <div class="table-responsive">
		               <div class="panel panel-default">
                        <div class="panel-heading"> <h4 align="center">Chat - Support</h4></div>
                        <div class="panel-body">
                            <div id="user_details"></div>
        			    	<div id="user_model_details"></div>
                         </div>
                      </div>
				
        				
        			</div>
		        </div>
		    </div>
			
			
			<br />
		<!--	<div class="row">
				<div class="col-md-8 col-sm-6">
					<h4>Online User</h4>
				</div>
				<div class="col-md-2 col-sm-3">
					<input type="hidden" id="is_active_group_chat_window" value="no" />
					<button type="button" name="group_chat" id="group_chat" class="btn btn-warning btn-xs">Group Chat</button>
				</div>
				<div class="col-md-2 col-sm-3">
					<p align="right">Hi - ADmin - <a href="logout.php">Logout</a></p>
				</div>
			</div> -->
			
			<br />
			<br />
		
		</div>

<style>

.chat_message_area
{
	position: relative;
	width: 100%;
	height: auto;
	background-color: #FFF;
    border: 1px solid #CCC;
    border-radius: 3px;
}

#group_chat_message
{
	width: 100%;
	height: auto;
	min-height: 80px;
	overflow: auto;
	padding:6px 24px 6px 12px;
}

.image_upload
{
	position: absolute;
	top:3px;
	right:3px;
}
.image_upload > form > input
{
    display: none;
}

.image_upload img
{
    width: 24px;
    cursor: pointer;
}

</style>  
<!--
<div id="group_chat_dialog" title="Group Chat Window">
	<div id="group_chat_history" style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;">

	</div>
	<div class="form-group">
		
		<div class="chat_message_area">
			<div id="group_chat_message" contenteditable class="form-control">

			</div>
			<div class="image_upload">
				<form id="uploadImage" method="post" action="upload.php">
					<label for="uploadFile"><img src="upload.png" /></label>
					<input type="file" name="uploadFile" id="uploadFile" accept=".jpg, .png" />
				</form>
			</div>
		</div>
	</div>
	<div class="form-group" align="right">
		<button type="button" name="send_group_chat" id="send_group_chat" class="btn btn-info">Send</button>
	</div>
</div> -->


<script>  
$(document).ready(function(){

	fetch_user();

	setInterval(function(){
		update_last_activity();
		fetch_user();
		update_chat_history_data();
		fetch_group_chat_history();
	}, 5000); 

	function fetch_user()
	{
		$.ajax({
			url:"live_chat/fetch_user.php",
			method:"POST",
			success:function(data){
				$('#user_details').html(data);
			}
		})
	}

	function update_last_activity()
	{
		$.ajax({
			url:"live_chat/update_last_activity.php",
			success:function(res)
			{
                //console.log(res);
			}
		})
	}

	function make_chat_dialog_box(to_user_id, to_user_name)
	{
		var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="You have chat with '+to_user_name+'">';
		modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
		modal_content += fetch_user_chat_history(to_user_id);
		modal_content += '</div>';
		modal_content += '<div class="form-group">';
		modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control chat_message"></textarea>';
		modal_content += '</div><div class="form-group" align="right">';
		modal_content+= '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';
		$('#user_model_details').html(modal_content);
	}

	$(document).on('click', '.start_chat', function(){
		var to_user_id = $(this).data('touserid');
		var to_user_name = $(this).data('tousername');
		make_chat_dialog_box(to_user_id, to_user_name);
		$("#user_dialog_"+to_user_id).dialog({
			autoOpen:false,
			width:400
		});
		$('#user_dialog_'+to_user_id).dialog('open');
		/*$('#chat_message_'+to_user_id).emojioneArea({
			pickerPosition:"top",
			toneStyle: "bullet"
		});*/
	});

	$(document).on('click', '.send_chat', function(){
		var to_user_id = $(this).attr('id');
		var chat_message = $('#chat_message_'+to_user_id).val();
		$.ajax({
			url:"live_chat/insert_chat.php",
			method:"POST",
			data:{to_user_id:to_user_id, chat_message:chat_message},
			success:function(data)
			{
				$('#chat_message_'+to_user_id).val('');
				//var element = $('#chat_message_'+to_user_id).emojioneArea();
				//element[0].emojioneArea.setText('');
				$('#chat_history_'+to_user_id).html(data);
			}
		})
	});

	function fetch_user_chat_history(to_user_id)
	{
		$.ajax({
			url:"live_chat/fetch_user_chat_history.php",
			method:"POST",
			data:{to_user_id:to_user_id},
			success:function(data){
				$('#chat_history_'+to_user_id).html(data);
				
			}
		})
	}

	function update_chat_history_data()
	{
		$('.chat_history').each(function(){
			var to_user_id = $(this).data('touserid');
			fetch_user_chat_history(to_user_id);
		});
	}

	$(document).on('click', '.ui-button-icon', function(){
		$('.user_dialog').dialog('destroy').remove();
		$('#is_active_group_chat_window').val('no');
	});

	$(document).on('focus', '.chat_message', function(){
		var is_type = 'yes';
		$.ajax({
			url:"live_chat/update_is_type_status.php",
			method:"POST",
			data:{is_type:is_type},
			success:function()
			{

			}
		})
	});

	$(document).on('blur', '.chat_message', function(){
		var is_type = 'no';
		$.ajax({
			url:"live_chat/update_is_type_status.php",
			method:"POST",
			data:{is_type:is_type},
			success:function()
			{
				
			}
		})
	});

	$('#group_chat_dialog').dialog({
		autoOpen:false,
		width:400
	});

	$('#group_chat').click(function(){
		$('#group_chat_dialog').dialog('open');
		$('#is_active_group_chat_window').val('yes');
		fetch_group_chat_history();
	});

	$('#send_group_chat').click(function(){
		var chat_message = $('#group_chat_message').html();
		var action = 'insert_data';
		if(chat_message != '')
		{
			$.ajax({
				url:"live_chat/group_chat.php",
				method:"POST",
				data:{chat_message:chat_message, action:action},
				success:function(data){
					$('#group_chat_message').html('');
					$('#group_chat_history').html(data);
				}
			})
		}
	});

	function fetch_group_chat_history()
	{
		var group_chat_dialog_active = $('#is_active_group_chat_window').val();
		var action = "fetch_data";
		if(group_chat_dialog_active == 'yes')
		{
			$.ajax({
				url:"live_chat/group_chat.php",
				method:"POST",
				data:{action:action},
				success:function(data)
				{
					$('#group_chat_history').html(data);
				}
			})
		}
	}

	$('#uploadFile').on('change', function(){
		$('#uploadImage').ajaxSubmit({
			target: "#group_chat_message",
			resetForm: true
		});
	});
	
});  
</script>
