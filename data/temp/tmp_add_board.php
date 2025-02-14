<?php  
$path = $_SERVER['DOCUMENT_ROOT'];
include($path.'/admin/'.'dbconfig.php');
if(isset($_GET['id'])){
    $btn_title = "Update";
    $btn_id = "Update";
    $uid = $_REQUEST['id'];
    $data = $db->get_single('tbl_tmp_board',$uid);

    $board_name = $data['board_name'];
    $cat_id = $data['cat_id'];
    $board_url = $data['board_url'];
    $board_key = $data['board_key'];
    $status = $data['status'];
	
	$board_bgcolor = $data['board_bgcolor'];
	$board_fontcolor = $data['board_fontcolor'];
	//$board_bgimage = $data['board_bgimage'];
	
}else{
	$uid = '';
    $btn_title = "Slect Image for Background";
    $btn_id = "register";
    $board_name = '';
    $cat_id = '';
    $board_url = '';
    $board_key = '';
    $image = '';
    $status = '';
	$board_bgcolor = '';
	$board_fontcolor ='';
	//$board_bgimage='';

}

?>
<div class="content">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header" data-background-color="purple">
<h4 class="title">Add New Board</h4>
<p class="category">Add Odapto New Board</p>
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
            <label class="control-label">Board Name</label>
            <input type="text" class="form-control" name="board_name" id="board_name" value="<?php echo $board_name; ?>" />
        </div>
		</div>
	<div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Board Key</label>
            <input type="text" class="form-control" name="board_key" id="board_key" value="<?php echo $board_key; ?>" />
        </div>
	</div>
	<div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Board URL</label>
            <input type="text" class="form-control" name="board_url" id="board_url" value="<?php echo $board_url; ?>" />
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
            <label class="control-label">Board Background Color</label>
            <input type="text" class="form-control showAlpha" name="board_bgcolor" id="board_bgcolor" value="<?php echo $board_bgcolor; ?>" />
			
        </div>
	</div>
	<div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Board Font Color</label>
            <input type="text" class="form-control showAlpha" name="board_fontcolor" id="board_fontcolor" value="<?php echo $board_fontcolor; ?>" />
        </div>
	</div>
	<!-- <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Board Background Image</label>
            <input type="text" class="form-control" name="board_bgimage" id="board_bgimage" value="<?php //echo $board_bgimage; ?>" />
        </div>
	</div>	-->
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
    </div>
	
	<div style="margin-top:30px" class="col-sm-6">
<?php echo $btn_title; ?>
<input type="file" id="file" name="file" class="btn btn-primary />
<button type="button" class="btn btn-primary pull-right" id="<?php echo $btn_id ?>"></button>
</div>
	
	</div>
	
	</div>
	
	</div>
</div>

<button type="button" class="btn btn-primary pull-right" id="<?php echo $btn_id ?>">SUBMIT</button>
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

$(document).ready(function (e) {
  
    $('#register').on('click', function () {
      
                    var file_data = $('#file').prop('files')[0];
                    var form_data = new FormData();
                    form_data.append('file', file_data);
                   
                      $.ajax({
                        url: 'temp/upload.php', // point to server-side PHP script 
                        dataType: 'text', // what to expect back from the PHP script
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'post',
                        success: function (response) {
                            
                            $('#msg').html(response); // display success response from the PHP script
                        },
                        error: function (response) {
                            $('#msg').html(response); // display error response from the PHP script
                        }
                    });


    });

});

jQuery(document).ready(function($){
$("#register").click(function(){ 

var board_name = $("#board_name").val();
var board_key = $("#board_key").val();
var board_url = $("#board_url").val();
var board_bgcolor = $("#board_bgcolor").val();
var board_fontcolor = $("#board_fontcolor").val();
var category = $("#category").val();
var imagename=$('#file').prop('files')[0];


if(board_name == ""){
    $("#board_name").focus();
    $("#board_name").attr("placeholder","Enter Board Name").css("border", "1px solid red;");
}else if(board_key == ""){
	$("#board_key").focus();
    $("#board_key").css("border", "1px solid red;");
}else if(board_url == ""){
    $("#board_url").focus();
    $("#board_url").css("border","1px solid red");
}else if(category == ""){
    $("#category").focus();
    $("#category").css("border","1px solid red");
}else {

$.ajax({
url: "temp/template_ajax.php",
type: "POST",
data: {
    action: 'temp_add_board',
    board_name: board_name,
    board_key: board_key,
    board_url: board_url,
    board_bgcolor: board_bgcolor,
    board_fontcolor: board_fontcolor,
    category: category,
    image:imagename.name
},

success: function(rel){

    alert('Successfully Submit');
//var obj = jQuery.parseJSON(rel);
//console.log(rel['message']);
	// if(obj.result=="TRUE"){
	// 	alert(obj.message);
	// 	window.location.href = "https://www.odapto.com/admin/dashboard.php?page=boards";
	// }else if(obj.result=="FALSE"){
	// 	alert(obj.message);
	// }
}
});        
return false; 

}
});


/* update User*/ 

$(document).on('click', '#Update', function(event) {
    
var board_name = $("#board_name").val();
var board_key = $("#board_key").val();
var board_url = $("#board_url").val();
var board_bgcolor = $("#board_bgcolor").val();
var board_fontcolor = $("#board_fontcolor").val();
var category = $("#category").val();
var status = '1';
var id = $("#id").val();

if(board_name == ""){
    $("#board_name").focus();
    $("#board_name").attr("placeholder","Enter Board Name").css("border", "1px solid red;");
}else if(board_key == ""){
	$("#board_key").focus();
    $("#board_key").css("border", "1px solid red;");
}else if(board_url == ""){
    $("#board_url").focus();
    $("#board_url").css("border","1px solid red");
}else if(category == ""){
    $("#category").focus();
    $("#category").css("border","1px solid red");
}else{

$.ajax({
url: "temp/template_ajax.php",
type: "POST",
data: {
		action: 'temp_edit_board',
		board_name: board_name,
		board_key: board_key,
		board_url: board_url,
		board_bgcolor: board_bgcolor,
		board_fontcolor: board_fontcolor,
		category: category,
		status: status,
		id : id
},
success: function(rel){
var obj = jQuery.parseJSON(rel);
if(obj.result=="TRUE"){
alert(obj.message);
var url = "<?php echo "https://www.odapto.com/admin/dashboard.php?page=boards"; ?>";
window.location.href = url;
}else if(obj.result=="FALSE"){ 
    alert(obj.message);
}

}
}); 

}
    
});  

});
$(".showAlpha").spectrum({
	preferredFormat: "rgb",
    showAlpha: true,
	showPalette: true,
    palette: [
        ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
        ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
        ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
        ["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
        ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
        ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
        ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
        ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
    ]
});
</script>