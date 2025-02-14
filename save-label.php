<?php  
ob_start();
session_start();
require_once("DBInterface.php");
$db = new Database();
$db->connect();
if(isset($_POST['action'])){
	if($_POST['action'] == "saveLabel"){

		$uid = $_SESSION['sess_login_id'];
		$id = $_POST['id'];
		$label = $_POST['label'];
		
		if($db->checkLabelText($uid, $id) > 0){
			$update_label = array(
				'label_name' => $label
			);
			$cond = array(
				'user_id' => $uid,
				'label_id'=> $id
			);
			$update = $db->update('tbl_label_users', $update_label, $cond);		
			if($update){
				echo "Done";
			}else{
				echo "Error";
			}
		}else{

			$update_label = array(
				'label_name' => $label,
				'user_id' => $uid,
				'label_id'=> $id
			);
			
			$update = $db->insert('tbl_label_users', $update_label);		
			if($update){
				echo "Done";
			}else{
				echo "Error";
			}
		}
		
		

	}else if($_POST['action'] == 'createLabel'){
		$labelname = $_REQUEST['labelname'];
		$label_id = $_REQUEST['label_id'];
		$userid = $_REQUEST['userid'];
		$boardid = $_SESSION['boardid'];
		$cardid = $_SESSION['cardid'];
		$data_insert = array(
'user_id' => $userid,
'label_id' => $label_id,
'label_name'=> $labelname,
			);
			$insert = $db->insert('tbl_label_users', $data_insert);		

echo '<div id="crelabdata"><h6 class="heading">Labels <span class="close-div2 fa fa-times pull-right"></span></h6><div class="model-container">
<div class="col-md-12 n-p" id="LabelDiv">	
<form id="labels">
   <input type="text" Placeholder = "Search Labels..." class="form-control input-md" name="searchLabel" id="searchlabel">
</form>
<ul style="margin: 0px; padding: 0px; list-style: none;" id="my_lab">';
		$getlabelbyuser = $db->getlblbyuserid('tbl_labels','tbl_label_users',$userid);
		//print_r($getlabelbyuser);
foreach($getlabelbyuser as $value){
		$uid = $_SESSION['sess_login_id'];
$labelcardcount = $db->BoardCardlabelcount($cardid,$userid,$value['id']);
if($labelcardcount>0){
							$classlab = 'my_check_right';
							$idjlab='hide_me'.rand(1,100);
						}
						else{
							$classlab = 'my_check_right hiddeni tog_bg';
							$idjlab='showme'.rand(100,1000);
						}
	
 $labelname = $value['label_name']; 
$labelColor = $value['color'];
	$colon = "'";
echo '<li style="position:relative"> 
	<span onclick="addMylabel('.$boardid.','.$userid.','.$value['id'].','.$cardid.','.$colon.$idjlab.$colon.','.$colon.$labelname.$colon.','.$colon.$labelColor.$colon.')" id="'.$idjlab.'" class="label-div '.$classlab.'" id="'.$value['color'].'" style="background:'.$value['color'] .'">
		<span class="labmyname" style="color: #fff;top: 15px;">'.$value['label_name'].'</span>
		</span>
	<a href="javascript:void(0)" class="editLabel" id="'.$value['id'].'" onclick="return showEditLabel(this.id); "> <i class="fa fa-pencil"></i> </a>
	</li>';
	}


echo '</ul>

	<div class="clearfix"></div>
	<div class="createLabelLink"><a href="javascript:void(0)" style="color: #000;line-height: 30px;margin-left: 14px;">Create a new label</a></div>
</div>
</div>
</div>
<div id="createlab"></div>
';
?>
<script>
$(".createLabelLink").click(function(event) {
	//alert('skjdj');
	$.ajax({
		url: 'create_labels.php',
		type: 'POST',
		data: { 
			userid: <?php echo $_SESSION['sess_login_id'] ?>
		},
		success: function(data){
			$('#crelabdata').css('display','none');
			$('#createlab').css('display','block');
		$('#createlab').html(data)
		//$('#createlab').html(data);
		//$('#createlab').css('display','block');
		
		/*$("#editLabelDiv > h6.heading > span.textHeading").text("Edit Label");
		$("#LabelDiv").css({'display':'none'});
		$("#editLabelDiv").css({'display':'block'});*/
		}
});
	});

	 $(document).ready(function(){ 
					$('input[id=searchlabel]').on('keyup', function() {
						var value = $(this).val();
				 var patt = new RegExp(value, "i");
				  $('#my_lab').find('li').each(function() {
				    if (!($(this).find('span').text().search(patt) >= 0)) {
				      $(this).not('.labmyname').hide();
				    }
				    if (($(this).find('span').text().search(patt) >= 0)) {

				      $(this).show();
				    }
				  });
				  
					});
				});
$(".close-div2").click(function(event) {

		$("#addlabels").css('display','none');
	});
</script>

<?php
	
	}else if($_POST['action'] == 'editLabel'){
		$labelname = $_REQUEST['labelname'];
		$label_id = $_REQUEST['label_id'];
		$editid = $_REQUEST['editid'];
		$boardid = $_SESSION['boardid'];
		$cardid = $_SESSION['cardid'];
		$data_update = array(
'label_id' => $label_id,
'label_name'=> $labelname,
			);

		$data_where = array(
'id' => $editid,
			);
			$insert = $db->update('tbl_label_users',$data_update,$data_where);		

echo '<div id="crelabdata"><h6 class="heading">Labels <span class="close-div2 fa fa-times pull-right"></span></h6><div class="model-container">
<div class="col-md-12 n-p" id="LabelDiv">	
<form id="labels">
   <input type="text" Placeholder = "Search Labels..." class="form-control input-md" name="searchLabel" id="searchlabel">
</form>
<ul style="margin: 0px; padding: 0px; list-style: none;" id="my_lab">';
	$userid = $_SESSION['sess_login_id'];
		$getlabelbyuser = $db->getlblbyuserid('tbl_labels','tbl_label_users',$userid);
		//print_r($getlabelbyuser);
foreach($getlabelbyuser as $value){
	
$labelcardcount = $db->BoardCardlabelcount($cardid,$userid,$value['id']);
if($labelcardcount>0){
							$classlab = 'my_check_right';
							$idjlab='hide_me'.rand(1,100);
						}
						else{
							$classlab = 'my_check_right hiddeni tog_bg';
							$idjlab='showme'.rand(100,1000);
						}
	
 $labelname = $value['label_name']; 
$labelColor = $value['color'];
	$colon = "'";
echo '<li style="position:relative"> 
	<span onclick="addMylabel('.$boardid.','.$userid.','.$value['id'].','.$cardid.','.$colon.$idjlab.$colon.','.$colon.$labelname.$colon.','.$colon.$labelColor.$colon.')" id="'.$idjlab.'" class="label-div '.$classlab.'" id="'.$value['color'].'" style="background:'.$value['color'] .'">
		<span class="labmyname" style="color: #fff;top: 15px;">'.$value['label_name'].'</span>
		</span>
	<a href="javascript:void(0)" class="editLabel" id="'.$value['id'].'" onclick="return showEditLabel(this.id); "> <i class="fa fa-pencil"></i> </a>
	</li>';
	}


echo '</ul>

	<div class="clearfix"></div>
	<div class="createLabelLink"><a href="javascript:void(0)" style="color: #000;line-height: 30px;margin-left: 14px;">Create a new label</a></div>
</div>
</div>
</div>
<div id="createlab"></div>
';
?>
<script>
$(".createLabelLink").click(function(event) {
	//alert('skjdj');
	$.ajax({
		url: 'create_labels.php',
		type: 'POST',
		data: { 
			userid: <?php echo $_SESSION['sess_login_id'] ?>
		},
		success: function(data){
			$('#crelabdata').css('display','none');
			$('#createlab').css('display','block');
		$('#createlab').html(data)
		//$('#createlab').html(data);
		//$('#createlab').css('display','block');
		
		/*$("#editLabelDiv > h6.heading > span.textHeading").text("Edit Label");
		$("#LabelDiv").css({'display':'none'});
		$("#editLabelDiv").css({'display':'block'});*/
		}
});
	});

	 $(document).ready(function(){ 
					$('input[id=searchlabel]').on('keyup', function() {
						var value = $(this).val();
				 var patt = new RegExp(value, "i");
				  $('#my_lab').find('li').each(function() {
				    if (!($(this).find('span').text().search(patt) >= 0)) {
				      $(this).not('.labmyname').hide();
				    }
				    if (($(this).find('span').text().search(patt) >= 0)) {

				      $(this).show();
				    }
				  });
				  
					});
				});
$(".close-div2").click(function(event) {

		$("#addlabels").css('display','none');
	});
</script>

<?php
	
	}
} 
?>
