<?php  
error_reporting(0);
$path = $_SERVER['DOCUMENT_ROOT'];
include($path.'/admin/'.'dbconfig.php');
$error = '';

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
	 $plan_tag = $userData['plan_tag'];
	$h1 = 'Update Template';
}else{
	$h1 = 'Add New Template';
	$uid = '';
    $btn_title = "Create Template";
    $btn_id = "register";
    $name = $_REQUEST['name'];
    $category = '';
    $cat_id = '';
    $description = $_REQUEST['description'];
    $image = '';
    $plan_tag = '';
}
?>
<div class="content">
<div class="container-fluid">
<div class="row">
<div class="col-sm-12" style="margin-top:80px;">
<div class="panel panel-default panel-table">
<div class="panel-heading">
    <div class="row">
         <div class="col-ms-12">
      
    	<?php
    	if(!empty($error)){ ?>
    	<div class="alert alert-info alert-dismissible fade in msg" role="alert" style="padding:15px 30px 10px 20px;"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    	<?php echo $error;  ?></div>
    	<?php }
    	if($_SESSION['msg']){ ?>
    	<div class="alert alert-info alert-dismissible fade in msg" role="alert" i style="padding:15px 30px 10px 20px;"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    	<?php  echo $_SESSION['msg'];	?>
    	
    	</div>
    	<?php }
            unset($_SESSION['msg']);
        
    	?>
    	
    	</div>
    </div>
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
            <label class="control-label">Plan </label>
            <select name="plan" class="form-control" id="plan">
	<option <?php echo ($plan_tag == 1)? 'selected="selected"' : ''; ?> value="1">Free</option>
	<option <?php echo ($plan_tag == 2)? 'selected="selected"' : ''; ?> value="2">Business</option>
	<option <?php echo ($plan_tag == 3)? 'selected="selected"' : ''; ?> value="3">Enterprise</option>
			
			</select>
        </div>
		</div>

		<div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Description</label>
            <textarea name="description" id="description" class="form-control"><?php echo $description; ?></textarea>
        </div>
				</div>
		<div class="col-md-3">
		    <?php
		        if(isset($_GET['id'])){ ?>
		            <div class="dropify-wrapper">
                        <label class="control-label">Template Image</label>
            			
                        <input type="file" class="dropify" data-default-file="" name="image" id="image" onchange="loadFile(event)">
                        
                    </div>
		        <?php   
		        }else{ ?>
		             <div class="dropify-wrapper">
                        <label class="control-label">Template Image</label>
            			
                        <input type="file" class="dropify" data-default-file="" name="image" id="image" onchange="loadFile(event)" required>
                        
                    </div>
		      <?php  }
		    ?>
    		
		</div>
		<div class="col-md-3">
		    
		    <?php if($image != ''){ ?>
    			<img class="img-thumbnail" style="width:100px; height:70px"  id="edit_pic"
    		src="<?php echo $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/admin/temp/images/'.$image; ?>" />
    			<?php }
    			?>
    			<img id="output" class="img-thumbnail" style="width:100px; height:80px; display:none" >
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
<div class="row">
    <div class="col-md-12">
    <button type="submit" name="submit" class="btn btn-primary pull-right" id="<?php echo $btn_id ?>"><?php echo $btn_title; ?></button>
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
  $(".msg").fadeTo(5000, 500).slideUp(500, function(){
        $(".msg").slideUp(500);
    });


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

<?php 


if(isset($_POST['submit'])){
	
	$name = $_REQUEST['name'];
	$category = $_REQUEST['category'];
	$description = $_REQUEST['description'];
	$plan = $_REQUEST['plan'];

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
					$destFile = $imagePath.$uniquesavename.$img_name;
					$image_name = $uniquesavename.$img_name;
					 move_uploaded_file($_FILES['image']['tmp_name'],$destFile);
					 break;
				}
			}
			if($f==0){
				 //$error .= "Invalid File type.<br/>";
				 //$error .= "Your file Type is ".$img_name;
				 echo'<script>
				    alert("Invalid File type. please select jpg,png,jpeg,gif file type");
				 </script>';
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

			if($_POST['plan']){
				$data['plan_tag']=$plan;
			}
			
			$data['status']=(!empty($_REQUEST['id']))? $_REQUEST['status'] : $status;
			
			if(!empty($_REQUEST['id'])){
				
				$id = array(
					'id' => $_REQUEST['id']
				);
				
            if($db->update("tbl_templates",$data, $id)){
                $_SESSION['msg']="Template Successfully Updated";
                
                //$error .= $_SESSION['msg'];
            						?>
            				<script>
            				window.location.href = "https://www.odapto.com/admin/dashboard.php?page=temp";
            				
            				
            				</script>
            				<?php
            				}else{
            					//$error .='Some thing Went Wrong';
            					 echo'<script>
            				    alert("Some thing Went Wrong");
            				 </script>';
            				}
			
			}else{

if(empty($img_name)){
//$error .='Please select Image';
            echo'<script>
            	alert("Please select Image");
            </script>';

}else{
if($f!=0){
if($db->insert("tbl_templates",$data)){
    $_SESSION['msg']="Template Successfully Created";
    
    //$error .= $_SESSION['msg'];
				?>
				<script>
			  
				window.location.href = "https://www.odapto.com/admin/dashboard.php?page=add_temp";	
				
				</script>
				<?php
				}else{
					$error .='Some thing Went Wrong';
				}
				}	
}

				
				
			}

	
}

?>