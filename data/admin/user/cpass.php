<?php  
$path = $_SERVER['DOCUMENT_ROOT'];
include($path.'/admin/'.'dbconfig.php');
if(isset($_GET['id'])){
    $btn_title = "Change Password";
    $btn_id = "CahngePwd";
    $uid = $_GET['id'];
    $userData = $db->getUserData($uid);

    $Full_Name = $userData['Full_Name'];
    $Email_ID = $userData['Email_ID'];
    $User_Password = $userData['User_Password'];
    $status = $userData['status'];
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
<div class="col-md-12">
<div class="card">
<div class="card-header" data-background-color="purple">
<h4 class="title">Add User Data
</h4>
<p class="category">Add Odapto Members</p>
</div>

<div class="card-content">
<?php //print_r($userData); ?>
<!--  add user form -->
<form method="post">
<div class="row">
    <div class="col-md-6">
        <div class="form-group label-floating">
            <label class="control-label">Name</label>
            <input type="text" class="form-control" name="fullname" id="fullname" value="<?php echo $Full_Name; ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group label-floating">
            <label class="control-label">Email address</label>
            <input type="email" class="form-control" name="user_email" id="user_email" value="<?php echo $Email_ID; ?>">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group label-floating">
            <label class="control-label">Password</label>
            <input type="password" class="form-control" name="pass" id="pass" value="">

        </div>
           
    </div>
    <input type="hidden" name="user_id" id="user_id" value="<?php echo $_GET['id']; ?>">
    
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



/* chahge password  */
$(document).on('click', '#CahngePwd', function(event) {
    event.preventDefault();
    /* Act on the event */
    var password = $("#pass").val();
    var user_id = $("#user_id").val();
    var user_email = $("#user_email").val();
    $.ajax({
        url: 'user/userRegister.php',
        type: 'POST',
        data: { action: 'CahngePwd' , password: password, user_id: user_id, user_email: user_email},
        beforeSend: function(){
            $("#CahngePwd").text('processing....');
        },
        success: function(res){
            $("#CahngePwd").text('Change Password');
            //alert(res);
            var obj = jQuery.parseJSON(res);
            if(obj.result=="TRUE")
            {
            $(".Mypopup").animate({top:75}, 800).css({'display':'block'});    
            $("#yes").css({'display':'none'});
            $('#no').text('Cancel');
            $(".poptext").text(obj.message);
            var url = "<?php echo "https://www.odapto.com/admin/dashboard.php?page=user"; ?>";
            window.location.href = url;
            }else if(obj.result=="FALSE"){ 
                $("#yes").css({'display':'none'});
                $('#no').text('Cancel');
                $(".poptext").text(obj.message);
            }
            
        }
    });
   
});


</script>