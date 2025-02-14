<?php  
error_reporting(0);
require_once("DBInterface.php");
$db = new Database();
$db->connect();

//echo $_REQUEST['data'];
$data = explode("&",$_REQUEST['data']);

$type = explode("=",$data[0]);
$type= $type[1];

if($type == "board")
{
	$email = explode("=",$data[1]);
	$search = $email[1];
	$bid = explode("=",$data[2]);
	$bid = $bid[1];
	$result = $db->findUserByEmail($search);
	$fianl_result = json_decode($result,true);
	if($fianl_result['result'] == "TRUE"){
		?>
		<h5 style="color:#000;margin-top:6px;font-weight: bold;background-color: #fefefe;height:30px;line-height:30px;">Select To Add</h5>
		<ul style="max-height:210px !important;overflow:auto;margin-left: -38px;">
		<?php
		foreach ($fianl_result['Details'] as $key => $value) {
			$id = $value['id'];
			$name = $value['name'];
			$chk_invite_member = $db->ChkInviteMember($id,$bid);
			if($chk_invite_member > 0){
				$bgclr = "#029205";
			}else{
				$bgclr = "#828181";
			}
		?>
		<li style="background-color:<?php echo $bgclr ?>">
		<a style="color:#fff;margin-top:3px;height:30px;line-height:13px;font-size:15px;display: block;margin-bottom:3px;text-decoration: none" href="javascript:void(0)" onclick="return addMembers(this.id)" id="<?php echo $id."_".$bid ?>"><?php echo $name; ?></a> </li>
		<?php	
		}
		?>
		</ul>
		<?php

		}else{

		foreach ($fianl_result['Details'] as $key => $value){
			$name = $value['name'];
			$email = $value['email'];
			$msg = $value['msg'];
			?>
			<p style="font-size:14px;color:#020202;margin:10px;text-align: justify;width: 94%"><?php echo $msg ?></p>
			<form id="formId" method="POST">
				<div class="form-group" style="width:94%;margin-left:8px; ">
					<label style="font-size: 14px;margin-left:-28px;color: #545454">Name</label>
					<div class="clearfix"></div>
					<input type="text" class="form-control" name="name" id="name" value="<?php echo $name ?>" style="width:80%;display: inline-block;">
					<input type="hidden" name="email" id="email" value="<?php echo $email ?>" >
					<input type="hidden" name="bid" id="bid" value="<?php echo $bid ?>" >
				
					<button type="button" name="send" id="send" onclick="return addMemberByEmail()" class="btn-sm btn-danger" style="border:0px;padding:6px;">
					<span class="fa fa-user-plus" style="font-size:17px"></span>	
					</button>
				</div>
			</form>
			<?php
		}
	}
	

}else{
	$email = explode("=",$data[1]);
	$search = $email[1];
	$bid = explode("=",$data[2]);
	$bid = $bid[1];

	$result = $db->findUserByEmail($search);
	$fianl_result = json_decode($result,true);
	if($fianl_result['result'] == "TRUE"){
		?>
		<h5 style="color:#000;margin-top:6px;font-weight: bold;background-color: #fefefe;height:30px;line-height:30px;">Select To Add</h5>
		<ul style="max-height:210px !important;overflow:auto;margin-left:-38px;">
		<?php
		foreach ($fianl_result['Details'] as $key => $value) {
			$id = $value['id'];
			$name = $value['name'];
			$chk_invite_member = $db->ChkInviteTeamMember($id,$bid);
			if($chk_invite_member > 0){
				$bgclr = "#029205";
			}else{
				$bgclr = "#828181";
			}
		?>
		<li style="background-color:<?php echo $bgclr ?>; list-style: none;">
		<a style="color:#fff;margin-top:3px;height:30px;line-height:30px;font-size:15px;display: block;margin-left: 10px; margin-bottom:3px;text-decoration: none" href="javascript:void(0)" onclick="return addTeamMembers(this.id)" id="<?php echo $id."_".$bid ?>"><?php echo $name; ?></a> </li>
		<?php	
		}
		?>
		</ul>
		<?php
	}else{

		foreach ($fianl_result['Details'] as $key => $value) {
			$name = $value['name'];
			$email = $value['email'];
			$msg = $value['msg'];
			?>
			<p style="font-size:14px;color:#020202;margin:10px;text-align: justify;width: 94%"><?php echo $msg ?></p>
			<form id="formId" method="POST">
				<div class="form-group" style="width:94%;margin-left:8px; ">
					<label style="font-size: 14px;margin-left:0px;color: #545454">Name</label>
					<div class="clearfix"></div>
					<input type="text" class="form-control" name="name" id="name" value="<?php echo $name ?>" style="width:80%;display: inline-block;">
					<input type="hidden" name="email" id="email" value="<?php echo $email ?>" >
					<input type="hidden" name="bid" id="tid" value="<?php echo $bid ?>" >
				
					<button type="button" name="send" id="send" onclick="return addTeamMemberByEmail()" class="btn-sm btn-danger" style="border:0px;padding:6px;">
					<span class="fa fa-user-plus" style="font-size:17px"></span>	
					</button>
				</div>
			</form>
			<?php
		}
	}
}

?>
<script type="text/javascript">
	function addMembers(elem){
		var id = elem;
		$.post('add-existing-members.php', {data: id}, function(response) {
	    	alert(response);    
    	});
	}
	function addTeamMembers(elem){
		var id = elem;
		$.post('add-existing-members-team.php', {data: id}, function(response) {
	    	alert(response);    
    	});
	}
	//addTeamMembers
	function addMemberByEmail(){
		var name = $("#name").val();
		var email = $("#email").val();
		var bid = $("#bid").val();
		var data = "name="+name+"&email="+email+"&bid="+bid;
		$.post('add-member-email.php', {data: data}, function(response) {
	    	alert(response);    
    	});
	}
	function addTeamMemberByEmail(){
		var name = $("#name").val();
		var email = $("#email").val();
		var bid = $("#tid").val();
		var data = "name="+name+"&email="+email+"&bid="+bid;
		$.post('add-team-member-email.php', {data: data}, function(response) {
	    	alert(response);    
    	});
	}
</script>