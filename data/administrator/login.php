<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
require_once("../common/config.php");
require_once("../common/encryption.php");
require_once("classes/Admin.php");
$objAdmin = new Admin();
$Encpt = new Encryption();

//For login user
if(isset($_REQUEST['LoginStatus'])=='yes'){
$user = mysql_real_escape_string($_REQUEST['username']);
$pass = mysql_real_escape_string($_REQUEST['password']);



$objAdmin->Admin($user,$pass);
}

//For forget password
if(isset($_GET['status'])){
$sql = "SELECT * FROM ".TBL_PREFIX."_admin";
$query = $obj->query($sql);
$rows = $obj->fetchNextObject($query);
$name = "Admin";
$from = "mail@subillion.com";
$to = $rows->email;
$cc = "";
$bcc = "";
$subject = "Username and password for login the admin panel.";
$body = "This mail is sent from the forgot password section of subillion.com\n ";
$body .= "Username : ".$rows->username."\n";
$body .= "Password : ".$Encpt->decode($rows->password)."\n";
//$objCommon->SentMail($name,$from,$to,$cc,$bcc,$subject,$body);
$objCommon->Show_message("Username and Password sent successfully.");

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome To The Admin Panel</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript">
 function validateAdmin(obj){
 
    if(obj.username.value==""){
	alert("Please enter username.");
	obj.username.focus();
	return false;
	}
	
    else if(obj.password.value==""){
	alert("Please enter password.");
	obj.password.focus();
	return false;
	}
	
	else{
	return true;
	}
 }

</script>




	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	<script>
		!window.jQuery && document.write('<script src="js/jquery-1.4.3.min.js"><\/script>');
	</script>
	<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript">
		$(document).ready(function() {			
			$("a#example1").fancybox();			
		});
	</script>

</head>

<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td height="400">
      <table align="center">
  <tr><td >
  <?php  echo $_SESSION['sess_error_mess']; echo $_SESSION['sess_mess'];$_SESSION['sess_error_mess']=""; $_SESSION['sess_mess']="";?> 
  </td>

  </tr></table>
      <table align="center" border="0" cellpadding="0" cellspacing="0" height="214" width="370" style="background-image:url(images/secu.jpg);background-repeat:no-repeat;">
      <tbody><tr>
        <td class="login_bg" valign="top">
        <form name="loginFrm" id="loginFrm" action="" method="post" onsubmit="return validateAdmin(this)" >
<input type="hidden" name="LoginStatus" id="LoginStatus" value="yes" />
          <table align="center" border="0" cellpadding="10" cellspacing="0" width="328">
        <tr><td colspan="5" align="center"><img src="<?php ADMIN_URL; ?>images/logo.png" /></td></tr>
		<tr><td colspan="2" align="center"><h1>Admin Login form</h1></td>
		</tr>
		<tr>
              <td><table border="0" cellpadding="0" cellspacing="0" width="328">
                  <tbody>
                  <tr>
                    <td class="blackbold" width="70">Username</td>
                    <td class="blackbold" align="left" width="20">:</td>
                    <td><input name="username" class="input" id="username" type="text"></td>
                  </tr>
             </table></td>
            </tr>
            <tr>
              <td><table border="0" cellpadding="0" cellspacing="0" width="328">
                  <tbody><tr>
                    <td class="blackbold" width="70">Password</td>
                    <td class="blackbold" align="left" width="20">:</td>
                    <td><input name="password" class="input" id="password" type="password"></td>
                  </tr>
              </tbody></table></td>
            </tr>
            <tr>
              <td><table border="0" cellpadding="0" cellspacing="0" width="328">
                <tbody>
                  <tr>
                    <td width="90" class="blackbold">&nbsp;</td>
                    <td width="238" align="right" class="pad-right33"><div align="right">
                      <table width="100%" border="0">
                          <tr>
                            <td width="42%"><input name="Submit" src="images/login-button.png" value="Submit" type="image" style="width:140px; background: none;border: none;" /></td>
                            <td width="58%" class="blackbold"><div align="right"><a href="index.php?status=forgot">Forgot Password</a></div></td>
                          </tr>
                                          </table>
                    </div></td>
                  </tr>
              </tbody></table></td>
            </tr>
          </tbody></table>
        </form></td>
      </tr>
    </tbody></table></td>
  </tr>
  <tr>
   <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr>
    <td class="footer">&nbsp;</td>
  </tr>
</tbody></table></td>
   </tr>
</tbody></table>


</body>
</html>