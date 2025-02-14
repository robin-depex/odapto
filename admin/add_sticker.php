<?php  
error_reporting(0);
$path = $_SERVER['DOCUMENT_ROOT'];
include('dbconfig.php');
$error = '';
if(isset($_POST['submit'])){
    
    // $name = $db->clean_input($_REQUEST['name']);
    // $category = $_REQUEST['category'];
    // $description = $_REQUEST['description'];

    if(!empty($_FILES['image']['name'])){
        $img_name=$_FILES['image']['name'];
        $ftype=$_FILES['image']['type'];
        
        $type=array("image/jpg","image/png","image/jpeg","image/gif");
            $f=0;
            for($a=0; $a<4; $a++){
                if($type[$a] == $ftype){
                     $f=1;
                     
                              
                    $path='stickers/' .$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], '../stickers/' .$_FILES['image']['name']);
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
          
            if(!empty($_FILES['image']['name'])){
                $data['images']=$path;
            }
           
            
            if(!empty($_REQUEST['id'])){
                
                $id = array(
                    'id' => $_REQUEST['id']
                );
                
                if($db->update("stickers_images",$data, $id)){
                    $error .='SuccessFully Updated';
                }else{
                    $error .='Some thing Went Wrong';
                }
            }else{
                if($db->insert("stickers_images",$data)){
                    $error .='SuccessFully Inserted';
                }else{
                    $error .='Some thing Went Wrong';
                }
            }

    
}
if(isset($_GET['id'])){
    $btn_title = "Update Sticker";
    $btn_id = "Update";
    $uid = $_GET['id'];
    $userData = $db->get_single('stickers_images', $uid);

    $image = $userData['images'];
    //$status = $userData['status'];
}else{
  $btn_title = "Add Sticker";
    $images = '';
}
?>
<div class="content">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header" data-background-color="purple">
<h4 class="title">Add New Sticker</h4>
<p class="category">Add Odapto New Sticker</p>
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
        <div class="dropify-wrapper">
            <label class="control-label">Sticker Image</label>
            <?php if($image != ''){ ?>
            <img class="img-thumbnail" style="width:100px" 
        src="<?php echo $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.$image; ?>" />
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
    $("#name").attr("placeholder","enter Sticker Name").css("border", "1px solid red;");
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