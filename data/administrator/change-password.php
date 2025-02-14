<?php 
require_once("classes/ChangePassword.php");
require_once("../common/encryption.php");
$objEncpt = new Encryption();
$objpass = new ChangePassword();
$sql = "SELECT username, password FROM ".TBL_PREFIX."_admin";
$query = $obj->query($sql);
$row = $obj->fetchNextObject($query);
if(isset($_REQUEST['PStatus'])=='yes'){
extract($_REQUEST);
$objpass->ChangePassword($user,$objEncpt->safe_b64encode($oldpass),$objEncpt->safe_b64encode($newpass),$objEncpt->safe_b64encode($confirmpass)); 
}
?>
<td class="content-main hidenavlayer">
  <form name="passFrm" id="passFrm" method="post" action="" style="margin:0px;" onsubmit="return validateChangePassFrm(this)">
  <input type="hidden" name="PStatus" id="PStatus" value="yes" />  
<table border="0" cellpadding="3" cellspacing="0" class="tabelle1" width="100%">
<tr>
  <td class="titel" colspan="2">Change Your Password</td>
  <td width="666" class="titel" style="font-weight: bold; text-align: right;">
  <span class="message">
  
<?php  echo $_SESSION['sess_error_mess']; echo $_SESSION['sess_mess'];$_SESSION['sess_error_mess']=""; $_SESSION['sess_mess']="";?> </span></td>
  <td width="260" class="titel" style="font-weight: bold; text-align: right;"></td>
</tr>
<tr>
  <td><div align="right"><strong>Username : </strong></div></td>
  <td colspan="3"><input type="text" name="user" id="user" size="45" value="<?php echo stripslashes($row->username);?>"/></td>
  </tr>
  
  <tr>
  <td><div align="right"><strong>Old Password : </strong></div></td>
  <td colspan="3"><input type="password" name="oldpass" id="oldpass" size="45"/></td>
  </tr>
  
  <tr>
  <td><div align="right"><strong>New Password : </strong></div></td>
  <td colspan="3"><input type="password" name="newpass" id="newpass" size="45"/></td>
  </tr>
  
  <tr>
  <td><div align="right"><strong>Confirm Password : </strong></div></td>
  <td colspan="3"><input type="password" name="confirmpass" id="confirmpass" size="45"/></td>
  </tr>
  
<tr>
<td width="372">&nbsp;</td>
<td colspan="3"><input type="submit" class="form-button" value="Submit"></td>
</tr>
</table>
</form>
</td>
<script language="javascript" type="text/javascript">
function validateChangePassFrm(obj) {
	msg = "<font color='red'><strong>Error : Following is missing.</strong><br /></font>";
	str = "";
	if(obj.user.value=="") {
		str += "Please enter the username.<br />";
	}
	if(obj.oldpass.value=="") {
		str += "Please enter old password.<br />";
	}
	if(obj.newpass.value=="") {
		str += "Please enter new password.<br />";
	}
	if(obj.confirmpass.value=="") {
		str += "Please confirm new password.<br />";
	}
	if(obj.confirmpass.value != obj.newpass.value){
	str += "Confirm password does not match.<br />";
	}	
	if(str) {
		$.fancybox(msg+str);
		return false;
	}
}
</script>