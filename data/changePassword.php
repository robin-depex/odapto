<?php 
  require_once("DBInterface.php");
  $db = new Database();
  $db->connect();

  include("inc/header_1.php"); 

?>
 <style type="text/css">
.close1 {
    float: right;
    outline: none;
    position: absolute;
    font-size: 36px;
    right: 0;
    top: 5px;
    font-weight: 400;
    width: 28px;
    height: 28px;
    line-height: 1;
    border-radius: 50px;
    color: #000000;
    text-shadow: 0 1px 0 #fff;
    opacity: 1;
}
 </style>
<div class="container" style="min-height: 490px;">
   <div class="row">
     <div class="col-sm-8 col-sm-offset-2" style="margin-top: 80px">
       <div class="col-sm-12">
          <?php  
          $email = $_GET['e'];
          $token = $_GET['t'];
          $status = $db->verifyFpToken($email,$token);
          if($status == 0){
            echo '<h2 class="modal-title text-center" style="color:red;margin-bottom:10px;"><strong>Invalid Token</strong></h2><br style="clear:both">';
          }
          ?>
          <h2 class="modal-title text-center"><strong>Change password</strong></h2>
        </div>
        <div class="modal-body">

        <div class="alert alert-success alert-sm alert-dismissable" style="position:relative;display: none">
            <a href="#" class="close1" data-dismiss="alert" aria-label="close">&times;</a>
            <p class="error" style="color: #000"></p>
        </div>

          <form action="" method="post" id="loginForm" autocomplete="off">   
           <div class="form-group">
             <label>Password</label>
           <span><input type="password" id="password" name="password" class="form-control input-lg" placeholder="password"></span>
           </div>
           <div class="form-group">
             <label>Confirm Password</label>
           <span><input type="password" id="conpassword" name="conpassword" class="form-control input-lg" placeholder="password"></span>
           </div>
           <div class="form-group">
           <input type="hidden" name="fp_token" id="fp_token" value="<?php echo $_GET['t']; ?>">
           <input type="hidden" name="user_email" id="user_email" value="<?php echo $_GET['e']; ?>">
           <span>
           <input type="button" id="changePassword" value="Submit"  class="list-btn btn-lg">
           </span>
			 <div class="col-lg-12 boto n-p top">
              <span class=""><h3>Don't have an account? <a style="color: #f47442;" href="signup.php">create an Odapto account</a>
               </h3>
              </span>
             </div>
             </form>
            <!-- <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
            </fb:login-button> -->
            <div id="status">
            </div>
        </div>
      </div>
      
    </div>
  </div>

  <script>
  jQuery(document).ready(function($) {
  	$("#changePassword").click(function(event) {
  		var password = $("#password").val();
      var conpassword = $("#conpassword").val();
      var email = $("#user_email").val();
      var fp_token = $("#fp_token").val();
      if(password == ""){
        $("#password").focus().attr("placeholder","entered password");
      }else if(conpassword == ""){
        $("#conpassword").focus().attr("placeholder","entered password");
      }else if(password != conpassword){
          $("#conpassword").focus().attr("placeholder","please enter password");
      }else{
      $.ajax({
        url: 'code.changepassword.php',
        type: 'POST',
        data: { 
            action: 'change_pwd', 
            password: password, 
            email: email, 
            fp_token : fp_token
        },
        beforeSend: function(){
         $("#changePassword").val("processing....");
        },
        success:function(data){
          if(data == 200){
            $("#changePassword").val("submit");
            $(".alert").css({'display':'block'});
            $(".form-control").val("");
            var url = "password changed successfully !! <a href='/login.php' style='color:#000;font-weight:bold;margin-left:50px;'> Login Now </a>"
            $(".error").html(url);
          }else{
            $(".alert").css({'display':'block'});
            $(".error").html(data);
          }
            
        }
          
      })
      }
  	
  		
  	});	
  });
  </script>