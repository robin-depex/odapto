<?php include("inc/header_1.php"); ?>

<?php  
session_start();
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

     <div class="container">
       <div class="row">
        
        <div class="col-sm-8 col-sm-offset-2 top">
           <div class="col-sm-12">
           <h2 class="modal-title text-center" style="color: red; margin-top: 10px;"><?php echo $text; ?></h2>
           <h2 class="modal-title text-center" style="display: <?php echo $class; ?>"><strong><strong>Create a Odapto Account</strong></h2>
           
         </div>
        <div class="modal-body">

<form action="<?php echo SITE_URL ?>userRegister.php" method="post" id="registerForm" autocomplete="off">
          
          <?php if(isset($_GET['msg'])){
            echo '<div class="alert alert-success alert-dismissable" style="position:relative">
            <a href="#" class="close1" data-dismiss="alert" aria-label="close">&times;</a>
            <strong> '.$_GET['msg'].' </strong>
          </div>';
           } ?>
          
           <div class="form-group">
            <label>Name</label>
           <span><input type="text" class="form-control input-lg" placeholder="Someone" name="fullname" required="required" id="fullname" ></span>
           <br style="clear: both;">
           </div>
           
           <div class="form-group">
             <label>Email</label>
           <span><input type="email" required="required" class="form-control input-lg" placeholder="Someone@mail.com" name="emailadd" id="emailadd" value="<?php echo $user_email; ?>" <?php echo $disable ?>></span>
           <br style="clear: both;">
  
           </div>
           <div class="form-group">
             <label>Password</label>
           <span><input type="password" required="required" class="form-control input-lg" placeholder="password" name="pass" id="pass"></span>
           <br style="clear: both;">
   

           </div>
           <div class="form-group">
             <label>Confirm Password</label>
           <span><input type="password" class="form-control input-lg" placeholder="password" name="confirmpass" id="confirmpass"></span>
           <br style="clear: both;">
      
           </div>
           <div class="form-group">
           <span>
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
    <input type="hidden" name="bid" id="bid" value="<?php echo $bid; ?>">
    <input type="hidden" name="invited_by" id="invited_by" value="<?php echo $invited_by; ?>">
    <input type="hidden" name="agreestatus" id="agreestatus">
      <input type="submit" value="Create New account"  class="btn btn-danger" style="display: <?php echo $class; ?>"></span>

           </div>
           <div class="col-sm-12 top n-p" style="display: none">
             <p style="color:gray"><strong>Did you sign up with your Google Account?</strong></p>
             <div class="col-sm-6 n-p"><a style="color:#343f7b;" class="fb"  href="#">Log in width Facebook</a> </div>
             <div class="col-sm-6 n-p"><a style="color: #008080;" class="linkedin" href="#">Log in width Linkedin</a></div>
            </div>
           <div class="col-lg-12 boto n-p top">
              <span class=""><h3>Alreay have an account <a style="color: #f47442;" href="login.php">Log in</a></h3></span>
             </div>
            </form> 
        </div>
      </div>
    </div>
  </div>


</body>
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
            $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
            $(".yes,.No").hide();
            $(".message").html("Enter Full Name").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
            setTimeout(function() {
              $('.confirmBox').fadeOut('fast');
            }, 2000);
            event.preventDefault();
        }else if(emailadd == ""){
            $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
            $(".yes,.No").hide();
            $(".message").html("Enter Email Address").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
            setTimeout(function() {
              $('.confirmBox').fadeOut('fast');
            }, 2000);
            event.preventDefault();
        }else if(!isValidEmailAddress(emailadd)){
          $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
          $(".yes,.No").hide();
          $(".message").html("Please Enter Valid Email Id").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
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
        }else if(cmpass == ""){
          $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
          $(".yes,.No").hide();
          $(".message").html("Please Enter Confirm Password").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
          setTimeout(function() {
            $('.confirmBox').fadeOut('fast');
          }, 2000);
          event.preventDefault();
        }else if(cmpass != pass){
          $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
          $(".yes,.No").hide();
          $(".message").html("Please Enter Correct Password").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
          setTimeout(function() {
          $('.confirmBox').fadeOut('fast');
          }, 2000);
          event.preventDefault();
        }else{
        var data = $("#registerForm").serialize();
        //alert(data);  
        $.ajax({
        url: "userRegister.php",
        type: "POST",
        data: data,
        success: function(rel){
          //alert(rel);
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
            $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
            $(".yes,.No").hide();
            $(".message").html(obj.message).delay(10000).fadeOut("slow").css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
            setTimeout(function() {
              $('.confirmBox,#myModal2').fadeOut('fast');
              window.location.href = "<?php echo "/welcome.php?token='".$_SESSION['user_token']."'" ?>";            
            }, 2000);     
          }else if(obj.result=="FALSE"){ 
            $(".message").html(obj.message).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
          }
        }
      });        
    return false; 

        }
});
 
  
});
</script>
</html>
