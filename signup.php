<?php include("inc/header_1.php");
//include("common/config.php");
?>

<?php  
//session_start();
require_once("DBInterface.php");
$db = new Database();
$db->connect();
$id = "";
$bid = "";
$invited_by = "";
$text = "";
$user_email = "";
$disable = "";
if(empty($_REQUEST['page'])){

}else {


if($_REQUEST['page'] == "team"){

    $token = $_REQUEST['token'];
    $chk = $db->ChkTeamInviteToken($token);  
  
  
  if($chk > 0){
    $inviteDetails = $db->getTeamInviteDetails($token);
    $id = $inviteDetails['id'];
    $bid = $inviteDetails['tid'];
    $invited_by = $inviteDetails['invited_by'];
    $burl = $inviteDetails['turl'];
    $bkey = $inviteDetails['tkey'];
    $invite_token = $inviteDetails['invite_token'];
    $user_email = $inviteDetails['user_email'];
    if($bid != $_GET['b'] || $invited_by != $_GET['id'] || $bkey != $_GET['k'] || $burl != $_GET['t'] || $invite_token != $_GET['token'] || $user_email != $_GET['email']){
      header("location:./");
    }else{
      
    }
    
  }else{
    $text = "Your Token is Invalid";
    $class = "none";

  }

}else if($_REQUEST['page'] == "board"){

if(isset($_REQUEST['token'])){
    $token = $_REQUEST['token'];
    $chk = $db->ChkInviteToken($token);  
  if($chk > 0){
    $inviteDetails = $db->getInviteDetails($token);
    $id = $inviteDetails['id'];
    $bid = $inviteDetails['bid'];
    $invited_by = $inviteDetails['invited_by'];
    $burl = $inviteDetails['burl'];
    $bkey = $inviteDetails['bkey'];
    $invite_token = $inviteDetails['invite_token'];
    $user_email = $inviteDetails['user_email'];
    if($bid != $_GET['b'] || $invited_by != $_GET['id'] || $bkey != $_GET['k'] || $burl != $_GET['t'] || $invite_token != $_GET['token'] || $user_email != $_GET['email']){
      header("location:./");
    }
    
  }else{
    $text = "Your Token is Invalid";
    $class = "none";
  }

}

}
} 
if(isset($_GET['email'])){
  $disable = "readonly";
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
  background: url(https://www.odapto.com/img-new/b.jpg) center;
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
    margin-bottom: 0px;
    margin-top: 15px;
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
  #loginForm label, #registerForm label{
    font-family: 'Varela Round', sans-serif !important;
    font-weight: 400 !important;
    font-size: 21px;
    color: #494949;
 }
 #registerForm .form-group{
  margin-bottom: 15px;
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
    padding: 35px 41px;
}

.modal-body {
    position: relative;
    padding: 0px 41px;
}
 </style> 

     <div class="container-fluid">
          <div style="display:flex" class="row">
          <div style="padding:0;float:inherit" class="col-sm-7">
          <div class="login-bg">
            <div class="reg-text">
            <h2> Odapto helps you to get successful.</h2>
           <p>Whether it’s for work, a side project or even the next family vacation, Odapto helps your team stay organized.</p>
          
          </div>
         </div> 
    </div>
        <div style="float:inherit" class="col-sm-6">
            <div class="col-sm-12 login-logo"><a href="https://www.odapto.com"><img src="https://www.odapto.com/images/logo.png"></a></div>
           <div class="col-sm-12">
           <h2 class="modal-title text-center" style="color: red; margin-top: 0px;"><?php echo $text; ?></h2>
        <!--    <h2 class="modal-title text-center" style="display: <?php echo $class; ?>"><strong><strong>Create a Odapto Account</strong></h2> -->
           
         </div>
         <div class="clearfix"></div>
        <div class="modal-body">

<!--<form class="idealforms" action="<?php echo SITE_URL ?>userRegister.php" method="post" id="registerForm" autocomplete="off">-->
          <form class="idealforms"  method="post" id="registerForm" autocomplete="off">
          <?php if(isset($_GET['msg'])){
            echo '<div class="alert alert-success alert-dismissable" style="position:relative">
            <a href="#" class="close1" data-dismiss="alert" aria-label="close">&times;</a>
            <strong> '.$_GET['msg'].' </strong>
          </div>';
           } ?>
           <div class="alert alert-success alert-dismissable" id="msg_div" style="position:relative; display:none" >
            <a href="#" class="close1" data-dismiss="alert" aria-label="close">&times;</a>
            <strong id="msg">  </strong>
          </div>
          
           <div class="form-group field">
            <label>Name</label>
           <span><input type="text" class="form-control change-control input-lg" placeholder="Someone" name="fullname" id="fullname" ></span>
           <span class="error"></span>
           <!-- <br style="clear: both;"> -->
           </div>
           
           <div class="form-group field">
             <label>Email</label>
           <span><input type="email" class="form-control change-control input-lg" placeholder="Someone@mail.com" name="emailadd" id="emailadd" value="<?php echo $user_email; ?>" <?php echo $disable ?>></span>
           <span class="error"></span>
           <!-- <br style="clear: both;"> -->
  
           </div>
           <div class="form-group field">
             <label>Password</label>
           <span><input type="password" class="form-control change-control input-lg" placeholder="password" name="pass" id="pass"></span>
            <span class="error"></span>
           <!-- <br style="clear: both;"> -->
   

           </div>
           <div class="form-group field">
             <label>Confirm Password</label>
           <span><input type="password" class="form-control change-control input-lg" placeholder="password" name="confirmpass" id="confirmpass"></span>
            <span class="error"></span>
          <!--  <br style="clear: both;"> -->
      
           </div>
           
            <div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="6LeSFNwUAAAAAAp21-BJciCSlgfpYsOKuQobZ6G4"></div>
           <div class="form-group field">
           <span>
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
    <input type="hidden" name="bid" id="bid" value="<?php echo $bid; ?>">
    <input type="hidden" name="invited_by" id="invited_by" value="<?php echo $invited_by; ?>">
    <input type="hidden" name="agreestatus" id="agreestatus">
      <button style="width:100%" type="submit" value="Create New account" id="register"  class="button-login" style="display: <?php echo $class; ?>"><span>Create New account</span>

           </div>
           <div class="col-sm-12 top n-p" style="display: none">
             <p style="color:gray"><strong>Did you sign up with your Google Account?</strong></p>
             <div class="col-sm-6 n-p"><a style="color:#343f7b;" class="fb"  href="#">Log in width Facebook</a> </div>
             <div class="col-sm-6 n-p"><a style="color: #008080;" class="linkedin" href="#">Log in width Linkedin</a></div>
            </div>
           <div class="col-lg-12 boto n-p">
              <span class=""><h3 style="margin:0">Alreay have an account <a style="color: #f47442;" href="login.php">Log in</a></h3></span>
             </div>
            </form> 
        </div>
      </div>
    </div>
  </div>


</body>
<script>
    function recaptchaCallback() {
    $('#submit').removeAttr('disabled');
};
</script>
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
            $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
            $(".yes,.No").hide();
            $(".message").html("Enter Full Name").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
            setTimeout(function() {
              $('.confirmBox').fadeOut('fast');
            }, 2000);
            //event.preventDefault();
            return false;
        }
        else if(emailadd == ""){
            $("#emailadd").focus();
            $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
            $(".yes,.No").hide();
            $(".message").html("Enter Email Address").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
            setTimeout(function() {
              $('.confirmBox').fadeOut('fast');
            }, 2000);
            //event.preventDefault();
            return false;
        }else if(!isValidEmailAddress(emailadd)){
          $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
          $(".yes,.No").hide();
          $(".message").html("Please Enter Valid Email Id").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
          setTimeout(function() {
            $('.confirmBox').fadeOut('fast');
          }, 2000);
          //event.preventDefault();
          return false;
      }else if(pass == ""){
          $("#pass").focus();
         $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
          $(".yes,.No").hide();
          $(".message").html("Please Enter Password").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
          setTimeout(function() {
            $('.confirmBox').fadeOut('fast');
          }, 2000);
          //event.preventDefault();
          return false;
        }else if(cmpass == ""){
            $("#cmpass").focus();
          $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
          $(".yes,.No").hide();
          $(".message").html("Please Enter Confirm Password").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
          setTimeout(function() {
            $('.confirmBox').fadeOut('fast');
          }, 2000);
          //event.preventDefault();
          return false;
        }else if(cmpass != pass){
          $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
          $(".yes,.No").hide();
          $(".message").html("Please Enter Correct Password").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
          setTimeout(function() {
          $('.confirmBox').fadeOut('fast');
          }, 2000);
          //event.preventDefault();
          return false;
        }
        else{
        var data = $("#registerForm").serialize();
        //alert(data);  
        $.ajax({
        url: "userRegister.php",
        type: "POST",
        data: data,
        success: function(rel){
          //alert(rel);
          //console.log(rel);
          var obj = jQuery.parseJSON(rel);
          
          if(obj.result=="TRUE")
          {
              $("#msg_div").css({'display':'block'});
              $("#msg_div").text(obj.message);
              setTimeout(function() {
              $('.confirmBox').fadeOut('fast');
              }, 2000);
            
          }else if(obj.result=="FALSE"){ 
            $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
            $(".yes,.No").hide();
            $(".message").html(obj.message).delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
          }
        }
      });        
    return false; 

        }
});
 
  
});
</script>
<script src="js/jquery.idealforms.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>

    $('form.idealforms').idealforms({

      silentLoad: false,

      rules: {
        'fullname': 'required fullname',
        'emailadd': 'required email',
        'pass': 'required pass',
        'confirmpass': 'required equalto:pass',
        'date': 'required date',
        'picture': 'required extension:jpg:png',
        'website': 'url',
        'hobbies[]': 'minoption:2 maxoption:3',
        'phone': 'required phone',
        'zip': 'required zip',
        'options': 'select:default',
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

  </script>
</html>
