<?php
require_once("classes/Country.php");
$objCountry = new Country();
$editid = $_GET['id'];
if($editid !=""){
$sql_ftch = "SELECT * FROM ".TBL_PREFIX."_country WHERE ID = ".$editid."";
$query9 = $obj->query($sql_ftch);
$RowData = $obj->fetchNextObject($query9);
}


if(isset($_REQUEST['addstatus'])=='yes'){ 
extract($_REQUEST);
if($editid!=""){ 
$objCountry->EditCountry($editid,$CountryNm,$CountryUrl,$CountryCd,$CountryDesc);
}else{ 
$objCountry->AddCountry($CountryNm,$CountryUrl,$CountryCd,$CountryDesc);
}
}
?>
<td class="content-main hidenavlayer">
  <form name="countryFrm" id="countryFrm" method="post" action="" style="margin:0px;" onsubmit="return ValidateCountryFrm(this)" >
  <input type="hidden" name="addstatus" id="addstatus" value="yes" />
<table border="0" cellpadding="3" cellspacing="0" class="tabelle1" width="100%">
<tr>
  <td class="titel" colspan="2"><?php echo ($editid!="")?'Edit':'Add';?> Country </td>
  <td width="437" class="titel" style="font-weight: bold; text-align: center;"></td>
  <td width="394" class="titel" style="font-weight: bold; text-align: right;"><a href="<?php echo ADMIN_URL;?>index.php?page=country" style="font-size:12px; text-decoration:none; color:#FFFFFF;"><span class="buttons">View All Country</span></a></td>
</tr>


<tr>
  <td ><div align="right"><strong>Country Name : </strong></div></td>
  <td colspan="3"><input type="text" name="CountryNm" id="CountryNm" size="71" value="<?php echo stripslashes($RowData->Country_Name)?>"/></td>
</tr>
<tr>
  <td ><div align="right"><strong>Country URL: </strong></div></td>
  <td colspan="3"><input type="text" name="CountryUrl" id="CountryUrl" size="71" value="<?php echo stripslashes($RowData->Country_Url)?>"/></td>
</tr>

<tr>
  <td valign="top" ><div align="right"><strong>Country Code: </strong></div></td>
  <td colspan="3"><input type="text" name="CountryCd" id="CountryCd" size="71" value="<?php echo stripslashes($RowData->Country_Code)?>"/></td>
</tr>
<tr>
  <td valign="top" ><div align="right"><strong>Descritpion : </strong></div></td>
  <td colspan="3">
  <textarea name="CountryDesc" id="CountryDesc" style="width:710px; height:150px;"><?php echo stripslashes($RowData->Country_Desc)?></textarea>
  
</td>
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
	if(obj.CountryNm.value == "") {
		str += "Please enter country name.<br />";
	}
	if(str) {
		$.fancybox(msg+str);
		return false;
	}
}
</script>
		
		