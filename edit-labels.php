<?php  
ob_start();
session_start();
require_once("DBInterface.php");
$db = new Database();
$db->connect();

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$singledata = $db->getsingledata('tbl_label_users','id',$id);
	//echo $id;
	//print_r($singledata);
?>

<h6 class="heading"><span class="createlabback fa fa-arrow-left times pull-left"></span>Edit Labels <span class="close-div1 fa fa-times pull-right"></span></h6>
 <div class="form-group">	
   <label class="heading">Name</label>	
   <input type="text" value="<?php echo $singledata['label_name'] ?>" class="form-control input-md" name="labelname" id="Labelname">
 </div>    
<h4 class="heading" style="text-align:left !important">Select Colors</h4>
<ul id="labelList" style="margin: 0px; padding: 0px; list-style: none;">
<?php

$labels = $db->getAlllabels();
foreach ($labels as $value) {
$dblabel_id = $value['label_id'];

?>
<li style="position:relative"> 
	<a>
<span class="color_label labelcheck_<?php echo $value['label_id']; ?> edit-label-div <?php if($singledata['label_id']==$dblabel_id){ echo 'fa fa-check';} ?>" id="<?php echo $value['label_id']; ?>" style="background: <?php echo $value['color']; ?>;color:#fff;">
	<span  class="label_check" style="color:#fff;margin-top: -7px;" id="labelcheck_<?php echo $value['label_id']; ?>" ></span>
</span>
</a>
</li>
<?php
}
?>
<input  type="hidden" name="label_id" id="label" value="<?php echo $singledata['label_id']; ?>">
</ul>
<br style="clear: both">
<input type="hidden" name="editid" id="label_userid" value="<?php echo $id; ?>">
<div class="form-group" style="margin-bottom: 20px;height: 30px">

<input type="button" name="Save" id="savelabel" value="save" class="list-btn" style="padding:10px 20px;float:left; background-color: #61BD4F">
</div>

<?php
}
?>
<script type="text/javascript">
 $("#labelList > li > a").click ( function(){
      $("#labelList > li > a > span").removeClass ( 'fa fa-check' );
      $(this).find('.color_label').addClass('fa fa-check');
      $(this).find('.color_label').css('color','white');
      return false;
     });
$('.color_label').click(function(){
	var labelid = $(this).attr('id');
	$('#label').val(labelid);
});
$(".createlabback").click(function(event) {
		//$('#addlabels').html('');
		$("#createlab").html('');
		$("#createlab").css('display','none');
		$("#crelabdata").css('display','block');
		
	});



$(".close-div1").click(function(event) {
		//$('#addlabels').html('');
		$("#createlab").html('');
		$("#createlab").css('display','none');
		$("#crelabdata").css('display','block');
		
	});
$('#savelabel').click(function(){
	var labelname = $('#Labelname').val();
	//var label_id = $('input[name=label_id]:checked').val(); 
	var label_id = $('#label').val();

	var editid = $('#label_userid').val();
	$.ajax({
			url: 'save-label.php',
			type: 'POST',
			data: { 
				action: 'editLabel',
				labelname: labelname,
				label_id: label_id,
				editid: editid
			},
			success: function(response){
			//location.reload('#addlabels');
//alert(response);
			$('#addlabels').html(response)
			}
		})
	
});
	/*function editLabel(elem){
		var id = elem;
		var labelTitle = $("#Labelname").val();

		$.ajax({
			url: 'save-label.php',
			type: 'POST',
			data: { 
				action: 'saveLabel',
				id: id,
				label: labelTitle
			},
			success: function(response){
				alert(response);
			}
		})
		
		
	}*/
</script>
