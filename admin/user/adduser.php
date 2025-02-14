<?php  
$path = $_SERVER['DOCUMENT_ROOT'];
include('dbconfig.php');
if(isset($_GET['id'])){
    $btn_title = "Update User";
    $btn_id = "Update";
    $uid = $_GET['id'];
    $userData = $db->getUserData($uid);

    $Full_Name = $userData['Full_Name'];
    $Email_ID = $userData['Email_ID'];
    $User_Password = $userData['User_Password'];
    $status = $userData['status'];
    $privilage = $userData['previlage'];
}else{
    $btn_title = "Create User";
    $btn_id = "register";
    $Full_Name = '';
    $Email_ID = '';
    $User_Password = '';
    $uid = '';
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
    <h3 class="panel-title">User Data</h3>
  </div>

</div>
</div>

<div class="card-content">
<?php //print_r($userData); ?>
<!--  add user form -->
<form method="post">
<div class="row">
    <div class="col-md-6">
        <div class="form-group label-floating">
            <label class="control-label">Name</label>
            <input type="text" class="form-control" DISABLED name="fullname" id="fullname" value="<?php echo $Full_Name; ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group label-floating">
            <label class="control-label">Email address</label>
            <input type="email" class="form-control" DISABLED name="emailadd" id="emailadd" value="<?php echo $Email_ID; ?>">
        </div>
    </div>
</div>

<div class="row">
    <!--<div class="col-md-6">
        <div class="form-group label-floating">
            <label class="control-label">Password</label>
            <input type="password" class="form-control" name="pass" id="pass" value="<?php echo $User_Password ?>">
        </div>
    </div>-->
    <?php  
    if(empty($_GET['id'])){
    ?>
    <!--<div class="col-md-6">
        <div class="form-group label-floating">
            <label class="control-label">Confirm Password</label>
            <input type="password" class="form-control" name="confirmpass" id="confirmpass">
        </div>
    </div>-->
    <?php    
    }
    ?>
  
    <?php  
    if(!empty($_GET['id'])){
    ?>
    
    <div class="col-md-6">
        <div class="form-group label-floating">
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
    
    <div class="col-md-6">
        <div class="form-group label-floating">
            <label class="control-label">Privilage</label>
            <select name="previlage" id="previlage" class="form-control">
                <?php  
                if($privilage == 1){
                ?>
                 <option value="1" selected>Yes</option>
                <option value="0">No</option>
                <?php }else{ ?>
                <option value="1" >Yes</option>
                <option value="0" selected>No</option>
                <?php    
                }
                ?>
               
            </select>
        </div>
    </div>
    <input type="hidden" name="user_id" id="user_id" value="<?php echo $_GET['id']; ?>">
    <?php } ?>
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
$("#fullname").keypress(function(event){
  var inputValue = event.charCode;
  if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)){
  $("#fullname").attr("placeholder","enter only charecter");
  }
});

function isValidEmailAddress(emailAddress) {
    var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(emailAddress);
}

jQuery(document).ready(function($) {

$("#register").click(function(){      
var fullname = $("#fullname").val();
var emailadd = $("#emailadd").val();
var pass = $("#pass").val();
var cmpass = $("#confirmpass").val();
if(fullname == ""){
    $("#fullname").focus();
    $("#fullname").attr("placeholder","enter fullname");
}else if(emailadd == ""){
    $("#emailadd").focus();
    $("#emailadd").attr("placeholder","please enter emaila ddress");
}else if(!isValidEmailAddress(emailadd)){
    $("#emailadd").focus();
    $("#emailadd").attr("placeholder","please enter valid emaila ddress");
}else if(pass == ""){
    $("#pass").focus();
    $("#pass").attr("placeholder","please enter password");
}else if(cmpass == ""){
    $("#confirmpass").focus();
    $("#confirmpass").attr("placeholder","please enter confirm password");
}else if(cmpass != pass){
    $("#confirmpass").focus();
    $("#confirmpass").attr("placeholder","please enter confirm password");
}else{

$.ajax({
url: "user/userRegister.php",
type: "POST",
data: {
    action: 'adduser',
    fullname: fullname,
    emailadd: emailadd,
    pass: pass
},
beforeSend:function(){
   $("#register").text('processing...');
},
success: function(rel){
$("#register").text('Create User');
var obj = jQuery.parseJSON(rel);
if(obj.result=="TRUE")
{
    alert(obj.message);
    window.location.href = "https://odapto.com/admin/dashboard.php?page=adduser";
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
    
/*var fullname = $("#fullname").val();
var emailadd = $("#emailadd").val();
var pass = $("#pass").val();
var cmpass = $("#confirmpass").val();*/
var status = $("#status").val();
var user_id = $("#user_id").val();
var previlage = $('#previlage').val();
/*if(fullname == ""){
    $("#fullname").focus();
    $("#fullname").attr("placeholder","enter fullname");
}else if(emailadd == ""){
    $("#emailadd").focus();
    $("#emailadd").attr("placeholder","please enter emaila ddress");
}else if(!isValidEmailAddress(emailadd)){
    $("#emailadd").focus();
    $("#emailadd").attr("placeholder","please enter valid emaila ddress");
}else if(pass == ""){
    $("#pass").focus();
    $("#pass").attr("placeholder","please enter password");
}else{*/

$.ajax({
url: "user/userRegister.php",
type: "POST",
data: {
    action: 'edituser',
    status: status,
    previlage: previlage,
    user_id : user_id
},
beforeSend:function(){
   $("#Update").text('updating profile...') ;
},
success: function(rel){

var obj = jQuery.parseJSON(rel);
if(obj.result=="TRUE")
{
//alert(obj.message);
//var url = "<?php echo "https://odapto.com/admin/dashboard.php?page=adduser&id=".$uid; ?>";
window.location.href = "https://odapto.com/admin/dashboard.php?page=user";
}else if(obj.result=="FALSE"){ 
    alert(obj.message);
}

}
}); 

//}
    
});  

});
</script>