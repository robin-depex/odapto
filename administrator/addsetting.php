<?php
require_once("classes/Setting.php");
require_once("../common/SimpleImage.php");

$objImg = new SimpleImage();

$objSetting = new Setting();

$editid = 1;
if($editid !=""){
$sql_ftch = "SELECT * FROM ".TBL_PREFIX."_site_parameter WHERE id = ".$editid;
$query9 = $obj->query($sql_ftch);
$RowData = $obj->fetchNextObject($query9);
}
if(isset($_REQUEST['addstatus'])=='yes'){ 
extract($_REQUEST);




$objSetting->EditSetting($editid,$website_title,$meta_title,$meta_keywords,$meta_desc,$admin_email,$logo_w,$logo_h,$copy_right,$powered_by,$powered_link,$analytic_code,$author_code,$site_varification_code,$favicon_url,$facebook_link,$google_link,$twitter_link,$youtube_link,$pin_link,$linkedin,$blogger_link,$skypid);

}
?>
<span class="message"><?php  echo $_SESSION['sess_error_mess']; echo $_SESSION['sess_mess'];$_SESSION['sess_error_mess']=""; $_SESSION['sess_mess']="";?></span>
<td class="content-main hidenavlayer">
  <form name="reviewFrm" id="reviewFrm" method="post" action="" style="margin:0px;" enctype="multipart/form-data" onSubmit="return validatereviewFrm(this)" >
  <input type="hidden" name="addstatus" id="addstatus" value="yes" />
<table border="0" cellpadding="3" cellspacing="0" class="tabelle1" width="100%">
<tr>
  <td class="titel" colspan="2"><?php echo ($editid!="")?'Edit':'Add';?> Setting </td>
  <td width="437" class="titel" style="font-weight: bold; text-align: center;"></td>
  <td width="394" class="titel" style="font-weight: bold; text-align: right;"><a href="<?php echo ADMIN_URL;?>index.php?page=expert" style="font-size:12px; text-decoration:none; color:#FFFFFF;"><span class="buttons">View All Expert</span></a></td>
</tr>
<tr>
  <td ><div align="right"><strong> Website Title : </strong></div></td>
  <td colspan="3">
  <textarea name="website_title" id="website_title" cols="70" rows="3"><?php echo $RowData->website_title; ?></textarea>
 </td>
</tr>
<tr>
  <td ><div align="right"><strong>Meta Title : </strong></div></td>
  <td colspan="3"><textarea name="meta_title" id="meta_title" cols="70" rows="3"><?php echo $RowData->meta_title; ?></textarea></td>
</tr>
<tr>
  <td ><div align="right"><strong>Meta Keywords : </strong></div></td>
  <td colspan="3">
  <textarea name="meta_keywords" id="meta_keywords" cols="70" rows="3"><?php echo $RowData->meta_keywords; ?></textarea>
   </td>
</tr>
<tr>
  <td ><div align="right"><strong>Meta Desc : </strong></div></td>
  <td colspan="3">
  <textarea name="meta_desc" id="meta_desc" cols="70" rows="3"><?php echo $RowData->meta_desc; ?></textarea>
  </td>
</tr>
<tr>
  <td ><div align="right"><strong> Admin Email : </strong></div></td>
  <td colspan="3">
  
  <textarea name="admin_email" id="admin_email" cols="70" rows="3"><?php echo $RowData->admin_email; ?></textarea>
 </td>
</tr>
<tr>
  <td ><div align="right"><strong>Logo W : </strong></div></td>
  <td colspan="3"><input type="text" name="logo_w" id="logo_w" size="71" value="<?php echo $RowData->logo_w; ?>"/> </td>
</tr>
<tr>
  <td ><div align="right"><strong>Logo H : </strong></div></td>
  <td colspan="3"><input type="text" name="logo_h" id="logo_h" size="71" value="<?php echo $RowData->logo_h; ?>"/> </td>
</tr>
<tr>
  <td ><div align="right"><strong>Copy Right : </strong></div></td>
  <td colspan="3"><input type="text" name="copy_right" id="copy_right" size="71" value="<?php echo $RowData->copy_right; ?>"/> </td>
</tr>
<tr>
  <td ><div align="right"><strong> Powered By : </strong></div></td>
  <td colspan="3"><input type="text" name="powered_by" id="powered_by" size="71" value="<?php echo $RowData->powered_by; ?>"/> </td>
</tr>
<tr>
  <td ><div align="right"><strong>Powered Link : </strong></div></td>
  <td colspan="3"><input type="text" name="powered_link" id="powered_link" size="71" value="<?php echo $RowData->powered_link; ?>"/> </td>
</tr>
<tr>
  <td ><div align="right"><strong>Analytic Code : </strong></div></td>
  <td colspan="3"><textarea name="analytic_code" cols="70" rows="3" id="analytic_code"><?php echo $RowData->analytic_code; ?></textarea> </td>
</tr>
<tr>
  <td ><div align="right"><strong>Author Code : </strong></div></td>
  <td colspan="3"><textarea name="author_code" cols="70" rows="3" id="author_code"><?php echo $RowData->author_code; ?></textarea> </td>
</tr>
<tr>
  <td ><div align="right"><strong>Site Varification Code : </strong></div></td>
  <td colspan="3"><textarea name="site_varification_code" cols="70" rows="3" id="site_varification_code"><?php echo $RowData->site_varification_code; ?></textarea> </td>
</tr>
<tr>
  <td ><div align="right"><strong>Favicon URL : </strong></div></td>
  <td colspan="3"><input type="text" name="favicon_url" id="favicon_url" size="71" value="<?php echo $RowData->favicon_url; ?>"/> </td>
</tr>
<tr>
  <td ><div align="right"><strong>Facebook URL : </strong></div></td>
  <td colspan="3"><input type="text" name="facebook_link" id="facebook_link" size="71" value="<?php echo $RowData->facebook_link; ?>"/> </td>
</tr>
<tr>
  <td ><div align="right"><strong> Google Link : </strong></div></td>
  <td colspan="3"><input type="text" name="google_link" id="google_link" size="71" value="<?php echo $RowData->google_link; ?>"/> </td>
</tr>
<tr>
  <td ><div align="right"><strong>Twitter Link : </strong></div></td>
  <td colspan="3"><input type="text" name="twitter_link" id="twitter_link" size="71" value="<?php echo $RowData->twitter_link; ?>"/> </td>
</tr>
<tr>
  <td ><div align="right"><strong>Youtube Link : </strong></div></td>
  <td colspan="3"><input type="text" name="youtube_link" id="youtube_link" size="71" value="<?php echo $RowData->youtube_link; ?>"/> </td>
</tr>
<tr>
  <td ><div align="right"><strong>Pin Link : </strong></div></td>
  <td colspan="3"><input type="text" name="pin_link" id="pin_link" size="71" value="<?php echo $RowData->pin_link; ?>"/> </td>
</tr>
<tr>
  <td ><div align="right"><strong> Linkedin : </strong></div></td>
  <td colspan="3"><input type="text" name="linkedin" id="linkedin" size="71" value="<?php echo $RowData->linkedin; ?>"/> </td>
</tr>
<tr>
  <td ><div align="right"><strong>Blogger Link : </strong></div></td>
  <td colspan="3"><input type="text" name="blogger_link" id="blogger_link" size="71" value="<?php echo $RowData->blogger_link; ?>"/> </td>
</tr>
<tr>
  <td ><div align="right"><strong>Skypid : </strong></div></td>
  <td colspan="3"><input type="text" name="skypid" id="skypid" size="71" value="<?php echo $RowData->skypid; ?>"/> </td>
</tr>
<tr>
<td width="230">&nbsp;</td>
<td colspan="3"><input type="submit" class="form-button" value="Submit"></td>
</tr>
</table>
</form>
</td>	
<script type="text/javascript">
function validatecompFrm(obj) {
	msg = "<font color='red'><strong>Error : Following is missing.</strong><br /></font>";
	str = "";
	if(obj.com_name.value == "") {
		str += "Please enter Title.<br />";
	}
	if(str) {
		$.fancybox(msg+str);
		return false;
	}
}
</script>