<?php  
ob_start();
session_start();
require_once("DBInterface.php");
$db = new Database();
$db->connect();

if(isset($_POST['id'])){
?>
<form id="labels" method="post">
 <div class="form-group">	
   <label class="heading">Name</label>	
   <input type="text" class="form-control input-md" name="Labelname" id="Labelname">
 </div>    
<h4 class="heading" style="text-align:left !important">Select Colors</h4>
<ul id="labelList" style="margin: 0px; padding: 0px; list-style: none;">
<?php
$id = $_POST['id'];
$labels = $db->EditAlllabels();
foreach ($labels as $value) {
$dblabel_id = $value['label_id'];
if($dblabel_id == $id){
	$display = "block";
}else{
	$display = "none";
}
?>
<li style="position:relative"> 
<span class="edit-label-div" id="<?php echo $value['label_id']; ?>" style="background: <?php echo $value['color']; ?>">
<span class="select-icon" style="display: <?php echo $display; ?>">
	<span class="fa fa-check"></span>
</span>
</span>

</li>
<?php
}
?>
</ul>
<br style="clear: both">
<div class="form-group" style="margin-bottom: 20px;height: 30px">
<input type="button" name="Save" id="<?php echo $id; ?>" value="save" class="list-btn" style="padding:10px 20px;float:left; background-color: #61BD4F" onclick="return editLabel(this.id)">
<input type="button" name="Delete" id="<?php echo $id; ?>" value="Delete" class="list-btn" style="background-color:#EB5A46;color: #fff;padding:9px 17px;float:right" onclick="return deleteLabel(this.id)">	
</div>
</form>
<?php
}
?>
<script type="text/javascript">
	function editLabel(elem){
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
		
		
	}
</script>
