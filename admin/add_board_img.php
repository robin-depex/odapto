<?php  
error_reporting(0);
$path = $_SERVER['DOCUMENT_ROOT'];
include($path.'/admin/'.'dbconfig.php');
$error = '';
if(isset($_POST['submit'])){
    
    $hidimg = $_REQUEST['hidimg'];
    // $name = $db->clean_input($_REQUEST['name']);
    // $category = $_REQUEST['category'];
    // $description = $_REQUEST['description'];

    if(!empty($_FILES['image']['name'])){
        $img_name=md5(date('ymdhis').$_FILES['image']['name']);
        $ftype=$_FILES['image']['type'];
        
        $type=array("image/jpg","image/png","image/jpeg","image/gif");
            $f=0;
            for($a=0; $a<4; $a++){
                if($type[$a] == $ftype){
                     $f=1;
                     
                              
                    $path='https://odapto.com/board_img/' .$img_name;
            move_uploaded_file($_FILES['image']['tmp_name'], '../board_img/' .$img_name);
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
                $data['bg_img']=$img_name;
            }else{
                 $data['bg_img']=$hidimg;
            }
           
            
            if(!empty($_REQUEST['id'])){
                
                $con = array(
                    'id' => $_REQUEST['id']
                );
                
                if($db->update("tbl_board_img",$data, $con)){
                         ?>
                <script>
                window.location.href = "https://odapto.com/admin/dashboard.php?page=board_img";  
                
                </script>
                <?php
                }else{
                    $error .='Some thing Went Wrong';
                }
            }else{
if($f==0){
   $error .='Please Select Image';
}else{
     if($db->insert("tbl_board_img",$data)){
                      ?>
                <script>
                window.location.href = "https://odapto.com/admin/dashboard.php?page=board_img";  
                
                </script>
                <?php
                }else{
                    $error .='Some thing Went Wrong';
                }
}

            }

    
}
if(isset($_GET['id'])){
    $btn_title = "Update Board Images";
    $btn_id = "Update";
    $uid = $_GET['id'];
    $userData = $db->get_single('tbl_board_img', $uid);

    $image = $userData['bg_img'];
    //$status = $userData['status'];
}else{
  $btn_title = "Add Board Image";
    $images = '';
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
    <h3 class="panel-title">New Board Image</h3>
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
    <div class="col-ms-12">
    <?php if(!empty($error)){ ?>
    <div class="alert alert-info alert-dismissible fade in" role="alert" style="padding:15px 30px 10px 20px;"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <?php echo $error;  ?></div>
    <?php } ?>
    </div>
    
        <div class="col-md-6">
        <div class="dropify-wrapper">
            <label class="control-label">Board Image</label>
            <?php if($image != ''){ ?>
            <img class="img-thumbnail" style="width:100px" 
        src="https://odapto.com/board_img/<?php echo $image; ?>" />
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
 <input type="hidden" name="hidimg" id="hidimg" value="<?php echo $image; ?>">
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