<?php include("inc/header_1.php"); ?>
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

          <h2 class="modal-title text-center"><strong><strong>Forgot password</strong></h2>
        </div>
        <div class="modal-body">

        <div class="alert alert-success alert-dismissable" style="position:relative;display: none">
            <a href="#" class="close1" data-dismiss="alert" aria-label="close">&times;</a>
            <p class="error" style="color: #000"></p>
        </div>

          <form action="" method="post" id="loginForm" autocomplete="off">   
           <div class="form-group">
             <label>Email</label>
           <span><input type="text" id="username" name="username" class="form-control input-lg" placeholder="Someone@mail.com"></span>
           </div>
           <div class="form-group">

           <span>
           <input type="button" id="forgotpassword" value="Submit"  class="list-btn btn-lg">
           </span>
			 <div class="col-lg-12 boto n-p top">
              <span class=""><h3>Don't have an account? <a style="color: #f47442;" href="signup.php">create an Odapto account</a>
               </h3>
              </span>
             </div>
             </form>
            <!-- <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
            </fb:login-button> -->
            <div id="status"></div>
        </div>
      </div>
      
    </div>
  </div>

  <script>
jQuery(document).ready(function($) {

function isValidEmailAddress(emailAddress) {
    var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(emailAddress);
}
  	$("#forgotpassword").click(function(event) {
  		var email = $("#username").val();
      if(email == ""){
        $("#username").attr('placeholder','please enter email id').foucs();
      }else if(!isValidEmailAddress(email)){
        $("#username").attr('placeholder','please enter valid email id').foucs();
      }else{
        $.ajax({
            url: 'code.forgotpassword.php',
            type: 'POST',
            data: { action: 'forgot_pwd', email: email},
            beforeSend: function(){
             $("#forgotpassword").val("sending....");
            },
            success:function(data){
              $(".alert").css({'display':'block'});
              $(".error").html(data);
              $("#forgotpassword").val("submit");
              $(".form-control").val("");
            }
        })
      }
  		
  		
  	});	
  });
  </script>