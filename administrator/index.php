<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
require_once("../common/config.php");
require_once("../common/function.inc.php");
if($_SESSION['sess_login_id']==""){
$objCommon->wtRedirect(ADMIN_LOGIN_URL);
}
?>
<!DOCTYPE html> 
<head>
<title> odapto | Admin Panel</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo ADMIN_URL;?>css/style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo ADMIN_URL;?>js/jquery-1.4.3.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo ADMIN_URL;?>js/main.js">
$.noConflict();
</script>
<script src="<?php echo ADMIN_URL;?>js/jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_URL;?>fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_URL;?>fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_URL;?>fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">

/* .style1 {
font-size: 18px;
font-weight: bold;
color: #CCCCCC;
} 
.col{
	width:15%; 
	float: left;
	background: #000; 
	border: 1px solid #000; 
	border-radius:12px; 
	padding:15px;
	text-align:center;
	margin: 5px; 
	font-size: 15px;
	color: #fff
}*/

</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height: 100%;">
<tr>
<td height="133" colspan="2" align="left" valign="top" style="background-color:#FFFFFF;">
<div style="position:fixed; background-color:#FFFFFF; border-bottom:#BCBCBC 1px solid; width:100%; padding:0; margin:0px;">

<img src="images/logo.png" style="float:left; padding-left:21px; padding-top:8px;">
<img src="images/welcome.jpg" width="583" height="126" style="  float: right; padding-right: 21px;padding-top: 4px;"></div></td>
</tr>

<tr>
<td width="207" align="left" valign="top">
<div style="padding:0px; float:left;">
<ul id="navigation">
<li class="sub" id="nav-8-list" style="display: block;">
<ul>
<li><a href="<?php echo ADMIN_URL;?>index.php?page=home" onFocus="blur(this)" class="hidenavlayer ">Dashboard</a></li>
<li><a href="<?php echo ADMIN_URL;?>index.php?page=user"  onFocus="blur(this)" class="hidenavlayer ">User Master</a></li>

<!-- <li><a href="<?php //echo ADMIN_URL;?>index.php?page=depart"  onFocus="blur(this)" class="hidenavlayer ">Department Master</a></li>
 -->
<li><a href="<?php echo ADMIN_URL;?>index.php?page=email"  onFocus="blur(this)" class="hidenavlayer ">E-Mail Setting</a></li>
<li><a href="<?php echo ADMIN_URL;?>index.php?page=passwords"  onFocus="blur(this)" class="hidenavlayer ">Change Password</a></li>
<li><a href="<?php echo ADMIN_URL;?>index.php?page=logout"  onFocus="blur(this)" class="hidenavlayer ">Logout</a></li>
</ul>
</li>
</ul>
<div id="navigation-end"></div>
</div></td>
<td align="left" valign="top" style="height: 100%;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height: 100%;">
<tr>
<td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>
<td class="content-title">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="162" align="right" valign="top">&nbsp;</td>
</tr>
</table></td>
</tr>
<tr>
<?php
$pagename = $_REQUEST['page'];
switch ($pagename)
{
// For Country Manager ////////////////////////////////////////////

case "user":
include("user-list.php");
break;
case "user-action":
include("add-user.php");
break;

case "depart":
include("depart-list.php");
break;
case "depart-action":
include("add-depart.php");
break;

case "passwords":
include("change-password.php");
break;
case "logout":
include("logout.php");
break;


case "download":
include("downloads.php");
break;

default:
include("home.php");
}
?> 
</tr>
</table></td>
</tr>
<tr>
<td valign="bottom"></td>
</tr>
</table></td>
</tr>
<tr>
<td colspan="2" style='background-color:#ffffff;'>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>

<td  class="content-bar-bottom">  
<span  class="content-bar-bottom-tipp" style="float: right;    height: 20px;    padding: 11px 20px;" >All Rights Reserved &copy; <a href="<?php echo SITE_URL; ?>" target="_blank" style="margin:0px; padding:0px; 10px 0 0px;" onFocus="blur(this)">Odapto</a></span> 
</td>
</tr>
</table></td>
</tr>
</table>
</body>
</html>