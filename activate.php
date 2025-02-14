<?php 
include("inc/headernew.php"); 
require_once("./DBInterface.php");
$db = new Database();
$db->connect();
?>
<header id="nheader">
<nav class="navbar navbar-inverse">
<div class="container">
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span> 
</button>
<a class="navbar-brand" href="#"><img style="max-width: 170px;" src="images/logo.png"></a>
</div>
<div class="collapse navbar-collapse" id="myNavbar">
<ul class="nav navbar-nav pull-right">
<li><a href="#">Feature</a></li>
<li><a href="pricing.php">Pricing</a></li>
<li><a href="appointment">Appointment</a></li>
<li class="pull-right"><a style="background: #f76f4b;color:#fff" href="signup.php">Sign Up</a></li>
<li style="margin-right:5%" class="pull-right"><a style="background-color:#2f8f7c;color:#fff" href="login.php">Login</a>
</li>
</ul>
</div>
</div>
</nav>
</header>
  <div class="container" style="min-height: 600px;">
   <div class="row">
     <div class="col-sm-8 col-sm-offset-2" style="margin-top: 220px;">
        <div class="modal-body text-center">

          <?php 
            $uid = $_GET['uid']; 
            $tocken = $_GET['token']; 
            //echo $uid. ' - ' . $tocken; 
            $rowcount = $db->verifyToken($tocken,$uid);
            if($rowcount == 1){
              $verifyAccount = array("status"=>1);
              $condition = array("accessTocken"=>$tocken);
              $db->update("tbl_users",$verifyAccount,$condition);
              $token = md5(date("Ymdhis")."AccountVerify");
              $update_token = array("accessTocken"=>$token,"user_verify_status"=>1,"status"=>1);
              $con_ver = array("ID"=>$uid);
              if($db->update("tbl_users",$update_token,$con_ver)){    
                ?>
                <div class="col-md-12 marginTop">
                   <h2 class="modal-title text-center" style="color:green"><strong>Your Odapto Account is Verified Now: </strong></h2>   
                </div>
                 <div class="col-md-12 text-center top">
                    <a href="login.php" class="list-btn">Login Your Account</a>
                 </div> 
                <?php
              }else{
                echo "Error Found";
              }
            }else{
              ?>
              <h4 class="modal-title text-center"><strong><strong>Oops!! Your Token has expired.<br/> If you want to continue then please sign up again.  </strong> </h4> 
              <br>
              <a href="login.php" style="background: #f90;padding: 10px 30px;margin-top: 20px;color: #fff;">Go To Home</a>
               
              <?php
            }
          ?>
        </div>
      </div>
      
    </div>
  </div>
<style>
.list-btn {
    background: #2a8171;
    padding: 5px 10px;
    color: #FFF;
    font-size: 18px;
}
.list-btn:hover{
    color:#fff;
}
</style>
</body>

<script type="text/javascript">

function isValidEmailAddress(emailAddress) {
    var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(emailAddress);
}

  jQuery(document).ready(function($) {

$("#login").click(function(){

  var username = $("#username").val();
  var pass = $("#password").val();
   if(username == ""){
        $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
        $(".yes,.No").hide();
        $(".message").html("Please Enter Email Id").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
        setTimeout(function() {
          $('.confirmBox').fadeOut('fast');
        }, 2000);
        event.preventDefault();
    }else if(!isValidEmailAddress(username)){
          $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
          $(".yes,.No").hide();
          $(".message").html("Please Enter Valid Email Id").delay(3000).css({'fontSize':'12px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal','width':'480px'});
          setTimeout(function() {
            $('.confirmBox').fadeOut('fast');
          }, 2000);
          event.preventDefault();
      }else if(pass == ""){
        $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
        $(".yes,.No").hide();
        $(".message").html("Please Enter Password").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
        setTimeout(function() {
          $('.confirmBox').fadeOut('fast');
        }, 2000);
        event.preventDefault();
    }else{
        var data = $("#loginForm").serialize();
       // alert(data);  
        $.ajax({
        url: "getLoginResponse.php",
        type: "POST",
        data: data,
        success: function(rel){
         // alert(rel);
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
           
            $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
            $(".yes,.No").hide();
            $(".message").html(obj.message).delay(10000);
            setTimeout(function() {
              $('.confirmBox').css({'display':'block'});
              window.location.href = "<?php //echo 'dashboard.php' ?>";            
            }, 2000);     
          }else if(obj.result=="FALSE"){ 
            $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
            $(".yes,.No").hide();
            $(".message").html(obj.message);
            setTimeout(function() {
              $('.confirmBox').css({'display':'block'});
            }, 2000);
          }
        }
      });        
      return false; 
    }

});
  
});
</script>


</html>
