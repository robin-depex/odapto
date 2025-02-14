<?php  
$path = $_SERVER['DOCUMENT_ROOT'];
include('dbconfig.php');
$error = '';
if(isset($_POST['submit'])){
	
	$card_name = $db->clean_input($_REQUEST['card_name']);
	$list_id = $_REQUEST['list_id'];
	$card_description = $_REQUEST['card_description'];

	
			date_default_timezone_set("Asia/Kolkata");
			$date = date("Y-m-d H:i:s");
			$status = 1;
			
			$data = array();
			if($_POST['card_name']){
				$data['card_name']=$card_name;
			}
			if($_POST['list_id']){
				$data['list_id']=$list_id;
			}
			if($_POST['card_description']){
				$data['card_description']=$card_description;
			}
			
			$list_data = $db->get_single_data('tbl_tmp_board_list','id',$list_id);
			$data['cat_id'] = $list_data['cat_id'];
			$data['board_id'] = $list_data['board_id'];
			
			if(!empty($_REQUEST['id'])){
				$data['status']=(!empty($_REQUEST['id']))? $_REQUEST['status'] : $status;
				$con = array('id' => $_REQUEST['id']);
				
				if($db->update("tbl_tmp_board_list_card",$data, $con)){
						?>
				<script>
				window.location.href = "https://odapto.com/admin/dashboard.php?page=boardcards";	
				
				</script>
				<?php
				}else{
					$error .='Some thing Went Wrong';
				}
			}else{
				if($db->insert("tbl_tmp_board_list_card",$data)){
						?>
				<script>
				window.location.href = "https://odapto.com/admin/dashboard.php?page=boardcards";	
				
				</script>
				<?php
				}else{
					$error .='Some thing Went Wrong';
				}
			}

	
}
if(isset($_GET['id'])){
    $btn_title = "Update";
    $btn_id = "Update";
    $uid = $_GET['id'];
    $data = $db->get_single('tbl_tmp_board_list_card',$uid);
$h1 = 'Update Template Board List Card';
    $card_name = $data['card_name'];
    $list_id = $data['list_id'];
    $card_description = $data['card_description'];
    $status = $data['status'];
}else{
	$h1 = 'Add Template Board List Card';
	$uid = '';
    $btn_title = "Create";
    $btn_id = "register";
    $card_name = '';
    $list_id = '';
    $card_description = '';
    $status = '';
}
?>
<div class="content">
<div class="container-fluid">
<div class="row">
<div class="col-sm-12" style="margin-top:80px;">
<div class="panel panel-default panel-table">
<div class="panel-heading">
<div class="row">
  <div class="col col-xs-6">
    <h3 class="panel-title"><?php echo $h1; ?></h3>
  </div>
 
</div>
</div>

<div class="card-content">
<?php //print_r($userData); ?>
<!--  add user form -->
<form method="post" enctype="multipart/form-data">
<div class="row">
<div class="col-sm-12">
    <div class="col-sm-12">
	<div class="card-content">
	<div class="card-panel">
	<div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Card Name</label>
            <input type="text" class="form-control" name="card_name" id="card_name" value="<?php echo $card_name; ?>" />
        </div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label">Board List</label>
			   <select name="list_id" class="form-control" id="list_id">
				<?php 
				//list_id
				$page = '';
				$data_cats = $db->getAll('tbl_tmp_board_list', $page); 
				$data_decode = json_decode($data_cats, true);
				$data_catss = $data_decode['Result'];
				$k =0;
				foreach($data_catss as $cats){ ?>
					<option <?php echo ($list_id == $data_catss[$k]['id'])? 'selected="selected"' : ''; ?> value="<?php echo $data_catss[$k]['id']; ?>">
					<?php echo $data_catss[$k]['list_title']; ?></option>
					<?php 
				$k++;
				}
				?>
				</select>
			</div>
		</div>
	<div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Card Description</label>
            <input type="text" class="form-control" name="card_description" id="card_description" value="<?php echo $card_description; ?>" />
        </div>
	</div>

	<?php  
    if(!empty($_REQUEST['id'])){
    ?>		
		<div class="col-md-6">
		<div class="form-group">
            <div class="col-sm-2"><label class="control-label">Active</label></div>
				<div class="col-sm-6" style="padding-top: 20px">
				<div class="radio col-sm-6" style="margin-top:-5px;"><label>
				<input name="status" type="radio" value="1" <?php echo ($status == 1)? 'checked': '';?>>
				
				<span class="circle"></span><span class="check"></span> Yes </label></div>
				<div class="radio col-sm-6"><label>
				
				<input name="status" type="radio" value="0"  <?php echo ($status == 0)? 'checked': '';?>>
				
				<span class="circle"></span><span class="check"></span> No </label></div>
				</div>
        </div>
		</div>
		    <input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">
    <?php } ?>
    </div></div>
	</div>
	</div>
</div>
<button type="submit" name="submit" class="btn btn-primary pull-right" id="<?php echo $btn_id ?>"><?php echo $btn_title; ?></button>
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
jQuery(document).ready(function($){
$("#register").click(function(){ 

var card_name = $("#card_name").val();
var list_id = $("#list_id").val();
var card_description = $("#card_description").val();


if(card_name == ""){
    $("#card_name").focus();
    $("#card_name").attr("placeholder","Enter Board Name").css("border", "1px solid red;");
	return false;
}else if(list_id == ""){
	$("#list_id").focus();
    $("#list_id").css("border", "1px solid red;");
	return false;
}else if(card_description == ""){
    $("#card_description").focus();
    $("#card_description").css("border","1px solid red");
	return false;
}else{
	return true; 
}
});
});
</script>