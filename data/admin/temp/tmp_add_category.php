<?php  
$path = $_SERVER['DOCUMENT_ROOT'];
include($path.'/admin/'.'dbconfig.php');
if(isset($_GET['id'])){
    $btn_title = "Update";
    $btn_id = "Update";
    $uid = $_REQUEST['id'];
    $data = $db->get_single('tbl_tmp_category',$uid);

    $cat_name = $data['cat_name'];
    $cat_slug = $data['cat_slug'];
    $description = $data['description'];
    $status = $data['status'];
}else{
	$uid = '';
    $btn_title = "Create";
    $btn_id = "register";
    $cat_name = '';
    $cat_slug = '';
    $description = '';
    $image = '';
    $status = '';
}

?>
<div class="content">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header" data-background-color="purple">
<h4 class="title">Add New Category</h4>
<p class="category">Add Odapto New Category</p>
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
            <label class="control-label">Category Name</label>
            <input type="text" class="form-control" name="cat_name" id="cat_name" value="<?php echo $cat_name; ?>" />
        </div>
		</div>
	<div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Category Slug</label>
            <input type="text" class="form-control" name="cat_slug" id="cat_slug" value="<?php echo $cat_slug; ?>" />
        </div>
		</div>
		<div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Description</label>
            <textarea name="description" id="description" class="form-control"><?php echo $description; ?></textarea>
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
<button type="button" class="btn btn-primary pull-right" id="<?php echo $btn_id ?>"><?php echo $btn_title; ?></button>
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

var cat_name = $("#cat_name").val();
var cat_slug = $("#cat_slug").val();
var description = $("#description").val();


if(cat_name == ""){
    $("#cat_name").focus();
    $("#cat_name").attr("placeholder","Enter Category Name").css("border", "1px solid red;");
}else if(cat_slug == ""){
	$("#cat_slug").focus();
    $("#cat_slug").css("border", "1px solid red;");
}else if(description == ""){
    $("#description").focus();
    $("#description").css("border","1px solid red");
}else {

$.ajax({
url: "temp/template_ajax.php",
type: "POST",
data: {
    action: 'temp_add_cat',
    cat_name: cat_name,
    cat_slug: cat_slug,
    description: description
},
mimeType:"multipart/form-data",
success: function(rel){
var obj = jQuery.parseJSON(rel);
	if(obj.result=="TRUE"){
		alert(obj.message);
		window.location.href = "https://www.odapto.com/admin/dashboard.php?page=temp_list_cat";
	}else if(obj.result=="FALSE"){
		alert(obj.message);
	}
}
});        
return false; 

}
});


/* update User*/ 

$(document).on('click', '#Update', function(event) {
    
var cat_name = $("#cat_name").val();
var cat_slug = $("#cat_slug").val();
var description = $("#description").val();
var status = '1';
var id = $("#id").val();

if(cat_name == ""){
    $("#cat_name").focus();
    $("#cat_name").attr("placeholder","Enter Category Name").css("border", "1px solid red;");
}else if(cat_slug == ""){
    $("#cat_slug").focus();
    $("#cat_slug").css("border", "1px solid red;");
}else if(description == ""){
    $("#description").focus();
    $("#description").css("border","1px solid red");
}else{

$.ajax({
url: "temp/template_ajax.php",
type: "POST",
data: {
		action: 'temp_edit_cat',
		cat_name: cat_name,
		cat_slug: cat_slug,
		description: description,
		status: status,
		id : id
},
success: function(rel){
var obj = jQuery.parseJSON(rel);
if(obj.result=="TRUE"){
alert(obj.message);
var url = "<?php echo "https://www.odapto.com/admin/dashboard.php?page=temp_list_cat&id=".$uid; ?>";
window.location.href = url;
}else if(obj.result=="FALSE"){ 
    alert(obj.message);
}

}
}); 

}
    
});  

});
</script>