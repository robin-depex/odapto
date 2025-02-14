<?php  
error_reporting(0);
$path = $_SERVER['DOCUMENT_ROOT'];
include($path.'/admin/'.'dbconfig.php');
$error = '';
if(isset($_POST['submit'])){
	
	$name = $db->clean_input($_REQUEST['name']);
	$category = $_REQUEST['category'];
	$description = $_REQUEST['description'];

	if(!empty($_FILES['image']['name'])){
		$img_name=$_FILES['image']['name'];
		$ftype=$_FILES['image']['type'];
		
		$type=array("image/jpg","image/png","image/jpeg","image/gif");
			$f=0;
			for($a=0; $a<4; $a++){
				if($type[$a] == $ftype){
					 $f=1;
					 
					$imagePath = $path."/admin/temp/images/";
					$uniquesavename=time().uniqid(rand());
					$destFile = $imagePath . $uniquesavename . $img_name;
					$image_name = $uniquesavename . $img_name;
					 move_uploaded_file($_FILES['image']['tmp_name'],$destFile);
					 break;
				}
			}
			if($f==0){
				 $error .= "Invalid File type.<br/>";
				 $error .= "Your file Type is ".$img_name;
			}

	}
	
			date_default_timezone_set("Asia/Kolkata");
			$date = date("Y-m-d H:i:s");
			$status = 1;
			
			$data = array();
			if($_POST['name']){
				$data['name']=$name;
			}
			if(!empty($_FILES['image']['name'])){
				$data['image']=$image_name;
			}
			if($_POST['category']){
				$data['cat_id']=$category;
			}
			if($_POST['description']){
				$data['description']=$description;
			}
			
			$data['status']=(!empty($_REQUEST['id']))? $_REQUEST['status'] : $status;
			
			if(!empty($_REQUEST['id'])){
				
				$id = array(
					'id' => $_REQUEST['id']
				);
				
				if($db->update("tbl_templates",$data, $id)){
					$error .='SuccessFully Updated';
				}else{
					$error .='Some thing Went Wrong';
				}
			}else{
				if($db->insert("tbl_templates",$data)){
					$error .='SuccessFully Inserted';
				}else{
					$error .='Some thing Went Wrong';
				}
			}

	
}
if(isset($_GET['id'])){
    $btn_title = "Update Template";
    $btn_id = "Update";
    $uid = $_GET['id'];
    $userData = $db->get_single('tbl_templates', $uid);

    $name = $userData['name'];
    $cat_id = $userData['cat_id'];
    $description = $userData['description'];
    $image = $userData['image'];
	$status = $userData['status'];
}else{
	$uid = '';
    $btn_title = "Create Template";
    $btn_id = "register";
    $name = '';
    $category = '';
    $cat_id = '';
    $description = '';
    $image = '';
}
?>
<div class="content">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header" data-background-color="purple">
<h4 class="title">Add New Template</h4>
<p class="category">Add Odapto New Template</p>
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
	<div class="alert alert-info alert-dismissible fade in" role="alert" style="padding:15px 30px 10px 20px;"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<?php echo $error;  ?></div>
	<?php } ?>
	</div>
	<div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Template Name</label>
            <input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>" >
        </div>
		</div>
		<div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Category</label>
            <select name="category" class="form-control" id="category">
			
			<?php 
			$page = '';
			$data_cats = $db->getAll('tbl_tmp_category', $page); 
			$data_decode = json_decode($data_cats, true);
			$data_catss = $data_decode['Result'];
			$k =0;
			foreach($data_catss as $cats){ ?>
				<option <?php echo ($cat_id == $data_catss[$k]['id'])? 'selected="selected"' : ''; ?> value="<?php echo $data_catss[$k]['id']; ?>">
				<?php echo $data_catss[$k]['cat_name']; ?></option>
				<?php 
			$k++;
			}
			?>
			</select>
        </div>
		</div>
		<div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Description</label>
            <textarea name="description" id="description" class="form-control"><?php echo $description; ?></textarea>
        </div>
				</div>
		<div class="col-md-6">
		<div class="dropify-wrapper">
            <label class="control-label">Template Image</label>
			<?php if($image != ''){ ?>
			<img class="img-thumbnail" style="width:100px" 
		src="<?php echo $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/admin/temp/images/'.$image; ?>" />
			<?php } ?>
            <input type="file" class="dropify" data-default-file="" name="image" id="image">
        </div>
		</div>
    </div></div>
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
	 
var name = $("#name").val();
var category = $("#category").val();
var description = $("#description").val();
var image = $("#image").val();

if(name == ""){
    $("#name").focus();
    $("#name").attr("placeholder","enter Template Name").css("border", "1px solid red;");
	return false;
}else if(category == ""){
    $("#emailadd").focus();
    $("#category").css("border", "1px solid red;");
	return false;
}else if(description == ""){
    $("#description").focus();
    $("#description").css("border","1px solid red");
	return false;
}else{
 
	return true; 
}
});
});
</script>