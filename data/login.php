<?php include("inc/header_1.php");

include_once 'gpConfig.php';
require_once('DBInterface.php');
$db = new Database();
$db->connect();
if(isset($_GET['code'])){

  $gClient->authenticate($_GET['code']);

  $_SESSION['token'] = $gClient->getAccessToken();
echo $redirectURL;
  header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));

}



if (isset($_SESSION['token'])) {

  $gClient->setAccessToken($_SESSION['token']);

}



if ($gClient->getAccessToken()) {

  //Get user profile data from google

  $gpUserProfile = $google_oauthV2->userinfo->get();


  

  //Insert or update user data to the database

    $gpUserData = array(

        'oauth_provider'=> 'google',

        'oauth_uid'     => $gpUserProfile['id'],

        'first_name'    => $gpUserProfile['given_name'],

        'last_name'     => $gpUserProfile['family_name'],

        'email'         => $gpUserProfile['email'],

        'gender'        => $gpUserProfile['gender'],

        'locale'        => $gpUserProfile['locale'],

        'picture'       => $gpUserProfile['picture'],

        'link'          => $gpUserProfile['link']

    );
print_r($gpUserData);

  

  //Storing user data into session

 
  date_default_timezone_set("Asia/Kolkata");
  $date = date("Y-m-d H:i:s");

  $token = md5($date.$fbfullname);
  
  $pass = $db->generateRandomString();
  $data = array(
    'Full_Name' => $gpUserData['first_name'].' '.$gpUserData['last_name'],
    'FBID'    => $gpUserData['oauth_uid'],
    'Email_ID' => $femail,
    'User_Password' => $pass,
    'accessTocken' => $token,
    'status' => 1,
    'AddDate' => $date
  ); 
$insertDataUserTable = $db->insert("tbl_users",$data);
$uid = $db->lastInsertedId($token); 
$profile_id = strtotime(date("Ymdhis"));
$user_meta_pid = array("meta_key" => "profile_id","meta_value"=> $profile_id,"user_id" => $uid);      
$insert = $db->insert("tbl_usermeta",$user_meta_pid);

  //full name
  $user_meta_name = array(
      "meta_key" => "full_name",
      "meta_value"=> $gpUserData['first_name'].' '.$gpUserData['last_name'],
      "user_id" => $uid);     
  $insert = $db->insert("tbl_usermeta",$user_meta_name);

   // username
  $username = explode("@", $femail);
  $user_meta_username = array(
      "meta_key" => "user_name",
      "meta_value"=> "@".$username[0],
       "user_id" => $uid);      
  $insert = $db->insert("tbl_usermeta",$user_meta_username);

   $first = explode(" ", $gpUserData['first_name'].' '.$gpUserData['last_name']);
  $initials = strtoupper(substr($first[0], 0, 1))."".strtoupper(substr($first[1], 0, 1));
  $user_meta_in = array(
      "meta_key" => "initials",
      "meta_value"=> $initials,
       "user_id" => $uid);      
  $insert = $db->insert("tbl_usermeta",$user_meta_in);


  // boi informations
  $user_meta_in = array(
    "meta_key" => "Bio",
    "user_id" => $uid);     
  $insert = $db->insert("tbl_usermeta",$user_meta_in);

  // bg color
  $user_meta_bg = array("meta_key" => "bg_color","meta_value"=>"#f52d39","user_id" => $uid);      
  $insert = $db->insert("tbl_usermeta",$user_meta_bg);

    $id = session_id();
    $cond = array(
      "ID" => $uid
    );
    $update_data = array("accessTocken" => $id);
    $update = $db->update("tbl_users",$update_data, $cond);

    $value = $db->newUserFbData($id,$uid);
    session_start();
    $_SESSION['auth'] = true;
    $_SESSION['FBID'] = $value['FBID'];           
    $_SESSION['sess_login_id'] = $value['ID'];
    $_SESSION['fullname'] = $value['Full_Name'];
    $_SESSION['Tocken'] = $value['accessTocken']; 
   header("Location:dashboard.php?page=home");
  

} else {

  $authUrl = $gClient->createAuthUrl();

  $output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><img src="images/sign-google.jpg" class="img-responsive" alt=""/></a>';

}


?>

  <div class="container" style="min-height: 490px;">
   <div class="row">
     <div class="col-sm-8 col-sm-offset-2" style="margin-top: 80px">
       <div class="col-sm-12">
          <h2 class="modal-title text-center"><strong><strong>Log in to Odapto</strong></h2>
        </div>
        <div class="modal-body">

          <form action="" method="post" id="loginForm" autocomplete="off">   
           <div class="form-group">
             <label>Email</label>
           <span><input type="text" id="username" name="username" class="form-control input-lg" placeholder="Someone@mail.com"></span>
           </div>
           <div class="form-group">
             <label>Password</label>
           <span><input type="password" id="password" name="password" class="form-control input-lg" placeholder="**********"></span>
           </div>
           <div class="form-group">

           <span>
           <input type="button" id="login" value="Login"  class="btn btn-danger">
           </span>

           <div class="col-sm-12 n-p reset top"><a href="forgotpassword.php" style="color: #000">Forgot your password? </a></div>
           </div>
           <div class="col-sm-12 top n-p" style="">
             <!-- google plus -->
             <p style="color:gray;display: none;"><strong>Did you sign up with your Google Account?</strong></p>
             <!-- facebook -->
             <div class="col-sm-4 n-p"><a style="color:#343f7b;" class="fb"  href="fbconfig.php" scope="public_profile,email"><img src="/images/fb.jpg" class="img-responsive"></a> </div>
             <!-- linked in -->
             <div class="col-sm-4 n-p"><a style="color: #008080;" class="linkedin" href="linkedinprocess.php"><img class="img-responsive" src="images/linkdin.jpg" /></a> </div>

             <div class="col-sm-4 n-p"><div><?php echo $output; ?></div> </div>

             
             
           </div>
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
            window.location.href = "<?php echo 'dashboard.php?page=home' ?>";
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
