<?php
require_once("classes/Setting.php");

$editid = 1;
$sql_ftch = "SELECT * FROM ".TBL_PREFIX."_admin WHERE id = ".$editid;
$query9 = $obj->query($sql_ftch);
$RowData = $obj->fetchNextObject($query9);
if(isset($_REQUEST['addstatus'])=='yes'){ 
extract($_REQUEST);

$sql = "UPDATE ".TBL_PREFIX."_admin SET `email`='".$emailid."' WHERE id=".$editid."";
$obj->execute($sql);
echo '<script>alert("You have been updated successfully.")</script>';
}
?>


<td class="content-main hidenavlayer">
  <form name="verifyemailFrm" id="verifyemailFrm" method="post" action="" style="margin:0px;">
  <input type="hidden" name="addstatus" value="yes" />
  
<table border="0" cellpadding="3" cellspacing="0" class="tabelle1" width="100%">
<tr>
  <td class="titel" colspan="2">Verify Your E-Mail ID</td>
  <td width="260" class="titel" style="font-weight: bold; text-align: right;"></td>
</tr>
<tr>
  <td><div align="right"><strong>E-mail ID</strong></div></td>
  <td colspan="2"><input type="text" name="emailid" id="emailid" size="45" value="<?php echo $RowData->email; ?>"/></td>
  </tr>
<tr>
<td width="230">&nbsp;</td>
<td colspan="2"><input type="submit" class="form-button" value="Update"></td>
</tr>
</table>
</form>
</td>