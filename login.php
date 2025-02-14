<?php session_start();
if(isset($_REQUEST['logintype'])){
  $_SESSION['logintype'] = 'price';
}
include("inc/header_1.php");

include_once 'gpConfig.php';
require_once('DBInterface.php');
$db = new Database();
$db->connect();
if(isset($_GET['code'])){
  $gClient->authenticate($_GET['code']);
  $_SESSION['token'] = $gClient->getAccessToken();
  header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));

}
if (isset($_SESSION['token'])) {
  $gClient->setAccessToken($_SESSION['token']);
}
if ($gClient->getAccessToken()) {
  $gpUserProfile = $google_oauthV2->userinfo->get();
  $emailchk = $db->chkEmail($gpUserProfile['email']);
if($emailchk>0){
$userdata = $db->getsingledata('tbl_users','Email_ID',$gpUserProfile['email']);
//print_r($userdata);die;
    $_SESSION['auth'] = true;
    $_SESSION['FBID'] = $userdata['FBID'];           
    $_SESSION['sess_login_id'] = $userdata['ID'];
    $_SESSION['fullname'] = $userdata['Full_Name'];
    $_SESSION['Tocken'] = $userdata['accessTocken']; 
    $_SESSION['membership_id'] = $userdata['membership_plan']; 
     //echo "<pre>";
   // print_r($_SESSION);
    ?>
    <script>
window.location = "dashboard.php?page=home";
    </script>
    <?php
   
}else{
  $date = date("Y-m-d H:i:s");
  $token = md5($date.$gpUserProfile['name']);
  $pass = md5($db->generateRandomString());
 
    $data = array(
    'Full_Name' => $gpUserProfile['given_name'].' '.$gpUserProfile['family_name'],
    'FBID'    => $gpUserProfile['id'],
    'Email_ID' => $gpUserProfile['email'],
    'User_Password' => $pass,
    'accessTocken' => $token,
    'status' => 1,
    'AddDate' => $date,
    'profile_pics' => $gpUserProfile['picture'],
    'user_verify_status' =>1,
    'login_type' => 'Google',
    'profile_pic_type' => 'url',
  ); 
    $insertDataUserTable = $db->insert("tbl_users",$data);
    $uid = $db->lastInsertedId($token); 
    $profile_id = strtotime(date("Ymdhis"));
$user_meta_pid = array("meta_key" => "profile_id","meta_value"=> $profile_id,"user_id" => $uid);      
$insert = $db->insert("tbl_usermeta",$user_meta_pid);
 $user_meta_name = array(
      "meta_key" => "full_name",
      "meta_value"=> $gpUserProfile['given_name'].' '.$gpUserProfile['family_name'],
      "user_id" => $uid); 
      $insert = $db->insert("tbl_usermeta",$user_meta_name); 
        $username = explode("@", $gpUserProfile['email']);
         $user_meta_username = array(
      "meta_key" => "user_name",
      "meta_value"=> "@".$username[0],
       "user_id" => $uid);   
  $insert = $db->insert("tbl_usermeta",$user_meta_username);
         $first = explode(" ", $gpUserProfile['given_name'].' '.$gpUserProfile['family_name']);   
$initials = strtoupper(substr($first[0], 0, 1))."".strtoupper(substr($first[1], 0, 1));
 $user_meta_in = array(
      "meta_key" => "initials",
      "meta_value"=> $initials,
       "user_id" => $uid); 
          $insert = $db->insert("tbl_usermeta",$user_meta_in);
          $user_meta_in = array(
    "meta_key" => "Bio",
    "user_id" => $uid);     
  $insert = $db->insert("tbl_usermeta",$user_meta_in);
      $user_meta_bg = array("meta_key" => "bg_color","meta_value"=>"#f52d39","user_id" => $uid);      
  $insert = $db->insert("tbl_usermeta",$user_meta_bg);  
  
    $id = session_id();
    $cond = array(
      "ID" => $uid
    );
    $update_data = array("accessTocken" => $id);
    $update = $db->update("tbl_users",$update_data, $cond);
$userdata = $db->getsingledata('tbl_users','Email_ID',$gpUserProfile['email']);
//print_r($userdata);die;
  
    $value = $db->newUserFbData($id,$uid);
    $_SESSION['auth'] = true;
    $_SESSION['FBID'] = $value['FBID'];           
    $_SESSION['sess_login_id'] = $value['ID'];
    $_SESSION['fullname'] = $value['Full_Name'];
    $_SESSION['Tocken'] = $value['accessTocken']; 
    $_SESSION['membership_id'] = $value['membership_plan']; 
  //  echo "<pre>";
  //  print_r($_SESSION);die;
    ?>
    <script>
window.location = "dashboard.php?page=home";
    </script>
    <?php

}
} else {
  $authUrl = $gClient->createAuthUrl();
  $output = '<a class="google_login" href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><i class="fa fa-google-plus" aria-hidden="true"></i> Login with Google</a>';
}

?>
<link rel="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
<style type="text/css">
body{
  font-family: 'Varela Round', sans-serif !important;
}
h3{
  font-family: 'Varela Round', sans-serif !important;
}
.login-bg{
background: url(https://www.odapto.com/img-new/back-img.jpg) center;
    height: 100%;
    background-size: cover;) center;
  height: 100%;
  background-size: cover;
}
.login-bg:before{
    content: "";
    display: block;
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: #e8519e;
    background: -webkit-linear-gradient(bottom, #000000c4, #2f8f7c96);
    background: -o-linear-gradient(bottom, #e8519e, #c77ff2);
    background: -moz-linear-gradient(bottom, #e8519e, #c77ff2);
    background: linear-gradient(bottom, #e8519e, #c77ff2);
    opacity: 0.8;
  }
 .login-logo img{
    max-width: 200px;
    margin: auto;
    display: block;
    margin-bottom: 14px;
    margin-top: 30px;
  }
  .change-control{
    height: 60px;
    border-radius: 3px;
    font-size: 20px;
    color: #494949;
    border: 2px solid #919191;
  }
  .change-control::placeholder{
    color: #494949;
  }
  #loginForm label{
    font-family: 'Varela Round', sans-serif !important;
    font-weight: 400 !important;
    font-size: 21px;
    color: #494949;

  }
  input:-webkit-autofill,
input:-webkit-autofill:hover, 
input:-webkit-autofill:focus
textarea:-webkit-autofill,
textarea:-webkit-autofill:hover
textarea:-webkit-autofill:focus,
select:-webkit-autofill,
select:-webkit-autofill:hover,
select:-webkit-autofill:focus {
  -webkit-box-shadow: 0 0 0px 1000px #fff inset;
  transition: background-color 5000s ease-in-out 0s;
}
.button-login {
  border-radius: 4px;
  background-color: #f4511e;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 24px;
    padding: 8px;
  width: 200px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 5px;
}

.button-login span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button-login span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button-login:hover span {
  padding-right: 25px;
}

.button-login:hover span:after {
  opacity: 1;
  right: 0;
}
.forgot-link{
   font-size: 24px;
    font-family: 'Varela Round', sans-serif !important;
    color: #494949 !important;
    margin-top: 12px;
    display: block;
    text-decoration: underline;
}
.fb, .linkedin, .google_login{
   color: #ffffff !important;
    font-family: 'Varela Round', sans-serif !important;
    display: block;
    text-align: center;
    font-size: 14px;
    letter-spacing: 0 !important;
    padding: 10px 0px;
    border-radius: 4px;
  }
 .fb{ 
   background: #343f7b; 
 }
 .linkedin{
  background: #0077B5; 
 }
  .google_login{
  background: #dd4b39; 
 }
 .sm-padd{
    padding-left: 2px;
    padding-right: 2px;
 }
 .or-login{
  position: relative;
  margin: 0;
  margin-bottom: 25px;
 }
  .or-login:before{
    content: '';
    position: absolute;
    left: 0;
    top: 22px;
    z-index: -1;
    width: 100%;
    height: 1px;
    background: #d9d9d9;
  }
  .login-title h2{
    margin: 0;
    font-size: 17px;
    color: #333;
    line-height: 41px;
    font-family: 'Varela Round', sans-serif !important;
  }
  .login-title{
    width: 45px;
    height: 45px;
    color: #333;
    border-radius: 50%;
    background: #fff;
    margin: auto;
    border: 2px solid #333;
  }
  .reg-text{
     position: absolute;
    width: 82%;
    font-family: 'Varela Round', sans-serif !important;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);
}
.reg-text h2, .reg-text p{
   font-family: 'Varela Round', sans-serif !important;
}
.reg-text h2{
    color: #fff;
    font-weight: bold;
    font-size: 56px;
    letter-spacing: 3px;
  }
.reg-text p{  
  font-size: 26px;
    margin-top: 46px;
  }
 .modal-body {
    position: relative;
    padding: 0px 51px;
} 
.confirmBox{
    background:red !important;
}
.confirmBox p{
    color:#fff;
    margin:0;
    margin-top:0 !important;
}
@media only screen and (max-width: 768px) {
  .forgot-link {
    font-size: 20px;
}
.fb, .linkedin{
  margin-bottom: 5px
}
}
</style>
  <div class="container-fluid" style="min-height: 490px;">
   <div style="display:flex" class="row">
    <div style="padding:0;float:inherit" class="col-sm-6">
     <div class="login-bg"><div class="reg-text">
            <h2> Odapto enables to work smarter</h2>
           <p>Whether it’s for work, a side project or even the next family vacation, Odapto helps your team stay organized.</p>
          </div></div>
    </div>
     <div style="float:inherit" class="col-sm-6">
          <div class="col-sm-12 login-logo"><a href="https://www.odapto.com"><img src="https://www.odapto.com/images/logo.png"></a></div>
        <!--   <div class="col-sm-12">
          <h2 class="modal-title text-center"><strong><strong>Log in to Odapto</strong></h2>
        </div> -->
        <div class="clearfix"></div>
        <div class="modal-body">

          <form action="" method="post" id="loginForm" autocomplete="off">   
          
              <div class="alert alert-success alert-dismissable" id="fail_msg_div" style="position:relative; display:none">
                <a href="#" class="close1" data-dismiss="alert" aria-label="close">&times;</a>
                <center><span id="fail_msg">  </span>
                <input type="hidden" id="user_email" value="" >
                &nbsp; <a href="javascript:void(0)" id="resendMail" style="color:blue"  > Resend Mail</a></center>
              </div>
              
           <div class="form-group field">
             <label>Email</label>
           <span><input type="email" id="username" name="username" class="form-control change-control input-lg" placeholder="Someone@mail.com"></span>
           <span class="error"></span>
           </div>
           <div style="margin-top:30px" class="form-group field">
             <label>Password</label>
           <span><input type="password" id="password" name="password" class="form-control change-control input-sm" placeholder="**********"></span>
            <span class="error"></span>
           </div>
           <div class="clearfix"></div>
           <div class="col-sm-12">
           <div style="margin-top:9px" class="form-group">
           <div style="padding-left:0" class="col-lg-5 col-md-12">
         
           <button type="submit" id="login" class="button-login"><span>Login</span></button>
 
           </div>
           <div class="col-lg-7 col-md-12 text-right n-p">
            <a class="forgot-link" href="forgotpassword.php">Forgot your password ? </a></div>
           </div>
          </div>


           <div class="col-sm-12 top n-p" style="">
             <!-- google plus -->
        <p style="color:gray;display: none;"><strong>Did you sign up with your Google Account?</strong></p>
             <!-- facebook -->

           <div class="col-sm-12 or-login text-center"><div class="login-title"><h2>OR</h2></div></div>
           <!--<div class="col-lg-4 col-md-12 col-sm-12 sm-padd"><a style="color:#343f7b;" class="fb"  href="fbconfig.php?scope="email" scope="email"><i class="fa fa-facebook" aria-hidden="true"></i> Login with Facebook</a> </div>-->
             <!-- linked in -->
           <!--  <div class="col-lg-4 col-md-12 col-sm-12 sm-padd"><a style="color: #008080;" class="linkedin" href="linkedinprocess.php"><i class="fa fa-linkedin" aria-hidden="true"></i> Login with Linkedin</a> </div>-->

             <div class="col-lg-4 col-md-12 col-sm-12 sm-padd"><div><?php echo $output; ?></div> </div>

             
             
           </div>
           <div class="clearfix"></div>
           <div class="col-sm-12 boto n-p top">
              <span class="">
                <h3>Don't have an account? <a style="color: #f47442;" href="signup.php">create an Odapto account</a>
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
        $(".confirmBox").css({'display':'block','position':'fixed','top':'10px','height':'auto', 'background' : 'red','padding':'15px', 'BorderRadius' : '4px'});
        $(".yes,.No").hide();
        $(".message").html("Please Enter Email Id").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
        setTimeout(function() {
          $('.confirmBox').fadeOut('fast');
        }, 2000);
        event.preventDefault();
    }else if(!isValidEmailAddress(username)){
          $(".confirmBox").css({'display':'block','position':'fixed','top':'10px','height':'auto', 'background' : 'red','padding':'15px', 'BorderRadius' : '4px'});
          $(".yes,.No").hide();
          $(".message").html("Please Enter Valid Email Id").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','fontWeight':'normal'});
          setTimeout(function() {
            $('.confirmBox').fadeOut('fast');
          }, 2000);
          event.preventDefault();
      }else if(pass == ""){
        $(".confirmBox").css({'display':'block','position':'fixed','top':'10px','height':'auto', 'background' : 'red','padding':'15px', 'BorderRadius' : '4px'});
        $(".yes,.No").hide();
        $(".message").html("Please Enter Password").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','fontWeight':'normal'});
        setTimeout(function() {
          $('.confirmBox').fadeOut('fast');
        }, 2000);
        event.preventDefault();
    }else{
        var data = $("#loginForm").serialize();
        //alert(data);  
        $.ajax({
        url: "getLoginResponse.php",
        type: "POST",
        data: data,
        success: function(rel){
         // alert(rel);
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
  <?php if(isset($_SESSION['logintype']) && $_SESSION['logintype']){ ?>

    window.location.href = "<?php echo 'pricing.php' ?>";
   <?php }else{ ?>
  
       window.location.href = "<?php echo 'dashboard.php?page=home' ?>";
   <?php } ?>

            
          }else if(obj.result=="FALSE"){ 
          //alert(obj.user_email_id);
            if(obj.user_email_id !='')
            {
                $("#user_email").val(obj.user_email_id);
                $("#fail_msg_div").css({'display':'block'});
                $("#fail_msg").html(obj.message);
            }else
            {
                $("#resendMail").css({'display':'none'});
                $("#fail_msg_div").css({'display':'block','color':'red'});
                $("#fail_msg").html(obj.message);
            }
            
            /*$(".confirmBox").css({'display':'block','position':'fixed','top':'10px','height':'auto', 'background' : 'red','padding':'15px', 'BorderRadius' : '4px'});
            $(".yes, .No").hide();
            $(".message").html(obj.message);
            setTimeout(function() {
              $('.confirmBox').fadeOut();
            }, 3000); */
          }
        }
      });        
      return false; 
    }

});
  
});
</script>
<script src="js/jquery.idealforms.min.js"></script>
<script>

    $('form.idealforms').idealforms({

      silentLoad: false,

      rules: {
        
/*        'emailadd': 'required email',
        'password': 'required pass',*/
 },

      errors: {
        'username': {
          ajaxError: 'Username not available'
        }
      },

/*      onSubmit: function(invalid, e) {
        e.preventDefault();
        $('#invalid')
          .show()
          .toggleClass('valid', ! invalid)
          .text(invalid ? (invalid +' invalid fields') : 'All good!');
      }*/
    });



    $('form.idealforms').find('input, select, textarea').on('change keyup', function() {
      $('#invalid').hide();
    });

    $('form.idealforms').idealforms('addRules', {
      'comments': 'required minmax:50:200'
    });

  $('form.idealforms').idealforms('addRules', {
      'username': 'required minmax:2:20'
    });
    $('.prev').click(function(){
      $('.prev').show();
      $('form.idealforms').idealforms('prevStep');
    });
    $('.next').click(function(){
      $('.next').show();
      $('form.idealforms').idealforms('nextStep');
    });
    
    
    $("#resendMail").click(function(){
        var mail = $("#user_email").val();
        //alert(mail);
        $.ajax({
        url: "resend-email.php",
        type: "POST",
        data: {'user_email':mail},
        success: function(rel){
          //alert(rel);
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
  
            $("#fail_msg_div").css({'display':'block'});
            $("#fail_msg").html(obj.message);
            $("#resendMail").css({'display':'none'});
            
          }else if(obj.result=="FALSE"){ 
            $("#fail_msg_div").css({'display':'block','color':'red'});
            $("#fail_msg").html(obj.message);
            $("#resendMail").css({'display':'none'});
            
          }
        }
      });        
      
        
    });

  </script>

</html>
