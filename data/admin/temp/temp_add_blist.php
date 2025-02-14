<?php  
$path = $_SERVER['DOCUMENT_ROOT'];
include($path.'/admin/'.'dbconfig.php');
$error = '';
if(isset($_POST['submit'])){

	$list_title = $db->clean_input($_REQUEST['list_title']);
	$board_id = $_REQUEST['board_id'];
	$list_key = $_REQUEST['list_key'];
	$user = $db->my_get_single('tbl_user_board', $board_id);
	
			date_default_timezone_set("Asia/Kolkata");
			$date = date("Y-m-d H:i:s");
			$status = 1;
			
			$data = array();
			$my_data = array();
			if($_POST['list_title']){
				$data['list_title']=$list_title;
				$my_data['list_title']=$list_title;
			}
			if($_POST['board_id']){
				$data['board_id']=$board_id;
				$my_data['board_id']=$user['board_id'];
			}
			
			if($_POST['list_key']){
				$data['list_key']=$list_key;
				$my_data['listkey']=$list_key;
			}
			if($_POST['font_family']){
				$data['font_family']=$font_family;
				$my_data['font_family']=$font_family;
			}
			
			if($_POST['bgcolor']){
				$data['bgcolor']=$bgcolor;
				$my_data['bgcolor']=$bgcolor;
			}
			if($_POST['bgimage']){
				$data['bgimage']=$bgimage;
				$my_data['bgimage']=$bgimage;
			}
			
			$data['status']=(!empty($_REQUEST['id']))? $_REQUEST['status'] : $status;
			
			if(!empty($_REQUEST['id'])){
				
				$id = array(
					'id' => $_REQUEST['id']
				);
				
				if($db->update("tbl_tmp_board_list",$my_data, $user['board_id'])){
					
					$error .='SuccessFully Updated';

				}else{
					$error .='Some thing Went Wrong';
				}
			}else{

				if($db->insert("tbl_tmp_board_list",$data)){
					
					$error .='SuccessFully Inserted';
				}else{
					$error .='Some thing Went Wrong';
				}
			}

	
}
if(isset($_GET['id'])){
    $btn_title = "Update";
    $btn_id = "Update";
    $uid = $_GET['id'];
    $userData = $db->get_single('tbl_tmp_board_list', $uid);

    $list_title = $userData['list_title'];
    $board_id = $userData['board_id'];
    $list_key = $userData['list_key'];
	
    $font_family = $userData['font_family'];
    $bgimage = $userData['bgimage'];
    $bgcolor = $userData['bgcolor'];
	
	
	$status = $userData['status'];
}else{
	$uid = '';
    $btn_title = "Create";
    $btn_id = "register";
    $list_title = '';
    $category = '';
    $board_id = '';
    $list_key = '';
	
    $font_family = '';
    $bgimage = '';
    $bgcolor = '';
	
	
}
?>
<div class="content">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header" data-background-color="purple">
<h4 class="title">Add Board Templates List</h4>
<p class="category">Odapto Add New Board list Template</p>
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
	<div class="col-ms-12">
	<?php if(!empty($error)){ ?>
	<div class="alert alert-info alert-dismissible fade in" role="alert" style="padding:15px 30px 10px 20px;"> 
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<?php echo $error;  ?></div>
	<?php } ?>
	</div>
	<div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Board List Name</label>
            <input type="text" class="form-control" name="list_title" id="list_title" value="<?php echo $list_title; ?>" />
        </div>
		</div>
		<div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Board</label>
            <select name="board_id" class="form-control" id="board_id">
			
			<?php 
			$page = '';
			$data_cats = $db->getAll('tbl_tmp_board', $page); 
			$data_decode = json_decode($data_cats, true);
			$data_catss = $data_decode['Result'];
			$k =0;
			foreach($data_catss as $cats){ ?>
				<option <?php echo ($board_id == $data_catss[$k]['id'])? 'selected="selected"' : ''; ?> value="<?php echo $data_catss[$k]['id']; ?>">
				<?php echo $data_catss[$k]['board_name']; ?></option>
				<?php 
			$k++;
			}
			?>
			</select>
        </div>
		</div>
		<div class="col-md-6">
        <div class="form-group">
            <label class="control-label">List Key</label>
            <input name="list_key" id="list_key" class="form-control" value="<?php echo $list_key; ?>" />
        </div>
		</div>
		
				<div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Font Family</label>
            <input name="list_key" id="list_key" class="form-control" value="<?php echo $font_family; ?>" />
        </div>
		</div>
		
				<div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Background Color</label>
            <input name="list_key" id="list_key" class="form-control" value="<?php echo $bgcolor; ?>" />
        </div>
		</div>
		
				<div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Background Image</label>
            <input name="list_key" id="list_key" class="form-control" value="<?php echo $bgimage; ?>" />
        </div>
		</div>
		
    </div>
	</div>
	</div>
</div>
</div>

<div class="row">
    <?php  
    if(!empty($_GET['id'])){
    ?>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Status</label>
            <select name="status" id="status" class="form-control">
                <?php  
                if($status == 1){
                ?>
                 <option value="1" selected>Active</option>
                <option value="0">In-active</option>
                <?php    
                }else if($status == -1){
                ?>
                <option value="-1" selected>Disable</option>
                <option value="0">In-active</option>
                <option value="1">Active</option>
                <?php
                }else{
                ?>
                <option value="0" selected>In-active</option>
                <option value="1">Active</option>
                <?php    
                }
                ?>
               
            </select>
        </div>
    </div>
    <input type="hidden" name="user_id" id="user_id" value="<?php echo $_GET['id']; ?>">
    <?php } ?>
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
 $("form").submit(function(){
	 
var list_title = $("#list_title").val();
var board_id = $("#board_id").val();

if(list_title == ""){
    $("#list_title").focus();
    $("#list_title").attr("placeholder","Enter Board List Name").css("border", "1px solid red;");
	return false;
}else if(board_id == ""){
    $("#board_id").focus();
    $("#board_id").css("border", "1px solid red;");
	return false;
}else{
 
	return true; 
}
});
});
</script>