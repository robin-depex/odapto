<?php
require_once("classes/user.php");
require_once("../common/encryption.php");
$encrypt = new Encryption();
$objCountry = new User();
$editid = $_GET['id'];
if($editid !=""){
$sql_ftch = "SELECT * FROM ".TBL_PREFIX."_users WHERE ID = ".$editid."";
$query9 = $obj->query($sql_ftch);
$RowData = $obj->fetchNextObject($query9);
}


if(isset($_REQUEST['addstatus'])=='yes'){ 

    extract($_REQUEST);

    
    if($editid!=""){ 
      $objCountry->EditUser($editid,$Full_Name,$Email_ID);
    }else{ 
      $objCountry->AddUser($Full_Name,$Email_ID,$password ) ;
    }

}
?>
<td class="content-main hidenavlayer">
  <form name="countryFrm" id="countryFrm" method="post" action="" style="margin:0px;" onsubmit="return ValidateCountryFrm(this)" autocomplete="off">
  <input type="hidden" name="addstatus" id="addstatus" value="yes" />
<table border="0" cellpadding="3" cellspacing="0" class="tabelle1" width="100%">
<tr>
  <td class="titel" colspan="2"><?php echo ($editid!="")?'Edit':'Add';?> User </td>
  <td width="437" class="titel" style="font-weight: bold; text-align: center;"></td>
  <td width="394" class="titel" style="font-weight: bold; text-align: right;"><a href="<?php echo ADMIN_URL;?>index.php?page=user" style="font-size:12px; text-decoration:none; color:#FFFFFF;"><span class="buttons">View All User</span></a></td>
</tr>


<tr>
  <td ><div align="right"><strong>User Name : </strong></div></td>
  <td colspan="3"><input type="text" name="Full_Name" id="Full_Name" size="71" value="<?php echo stripslashes($RowData->Full_Name)?>"/></td>
</tr>
<tr>
  <td ><div align="right"><strong>Email ID: </strong></div></td>
  <td colspan="3"><input type="text" name="Email_ID" id="Email_ID" size="71" value="<?php echo stripslashes($RowData->Email_ID)?>" /></td>
</tr>

<tr>
  <td valign="top" ><div align="right"><strong>Password: </strong></div></td>
  <td colspan="3">
  <input type="password" name="password" id="password" size="71" value="<?php echo stripslashes($RowData->User_Password)?>"/></td>
</tr>

<tr>
<td width="230">&nbsp;</td>
<td colspan="3"><input type="submit" class="form-button" value="Submit"></td>
</tr>
</table>
</form>
</td>	
<script type="text/javascript">


function ValidateCountryFrm(obj) {

	msg = "<font color='red'><strong>Error : Following is missing.</strong><br /></font>";
	str = "";
	if(obj.Full_Name.value == "") {
		str += "Please enter country name.<br />";
	}
	if(str) {
		$.fancybox(msg+str);
		return false;
	}
}
</script>

		
		