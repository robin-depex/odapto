<?php
require_once("classes/City.php");
$objCity = new City();
$editid = $_GET['id'];
if($editid !=""){
$sql_ftch = "SELECT * FROM ".TBL_PREFIX."_city WHERE ID = ".$editid."";
$query9 = $obj->query($sql_ftch);
$RowData = $obj->fetchNextObject($query9);
}


if(isset($_REQUEST['addstatus'])=='yes'){ 
extract($_REQUEST);
if($editid!=""){ 
$objCity->Editcity($editid,$countryid,$selectstate,$cityNm,$cityUrl,$cityCd,$optionalNm,$cityDesc);
}else{ 
$objCity->AddCity($countryid,$selectstate,$cityNm,$cityUrl,$cityCd,$optionalNm,$cityDesc);
}
}
?>
<td class="content-main hidenavlayer">
  <form name="cityFrm" id="cityFrm" method="post" action="" style="margin:0px;" onsubmit="return ValidateCityFrm(this)" >
  <input type="hidden" name="addstatus" id="addstatus" value="yes" />
<table border="0" cellpadding="3" cellspacing="0" class="tabelle1" width="100%">
<tr>
  <td class="titel" colspan="2"><?php echo ($editid!="")?'Edit':'Add';?> City </td>
  <td width="437" class="titel" style="font-weight: bold; text-align: center;"></td>
  <td width="394" class="titel" style="font-weight: bold; text-align: right;"><a href="<?php echo ADMIN_URL;?>index.php?page=city" style="font-size:12px; text-decoration:none; color:#FFFFFF;"><span class="buttons">View All City</span></a></td>
</tr>


<tr>
  <td ><div align="right"><strong>Select Country : </strong></div></td>
  <td colspan="3">
  
  <select name="countryid" id="countryid" style="width:194px;" onchange="return GetState(this.value)">
  <option value="0">[Country]</option>
  <?php
  $sqlCount = "SELECT Country_Name, ID FROM ".TBL_PREFIX."_country WHERE `status`=1 ORDER BY Country_Name";
$queryCount = $obj->query($sqlCount);
while($RowDataCou = $obj->fetchNextObject($queryCount)){
?>

  <option value="<?php echo $RowDataCou->ID; ?>" <?php echo ($RowDataCou->ID==$RowData->Country_ID)?'selected="selected"':'';?>><?php echo $RowDataCou->Country_Name; ?></option>
  
<?php }  ?>
</select>  </td>
</tr>
<tr>
  <td ><div align="right"><strong>Select State : </strong></div></td>
  <td colspan="3">
  <span id="sts">
  <select name="selectstate" id="selectstate" style="width:194px;">
  <option value="0">[State]</option>
    <?php
	if($RowData->Country_ID !=""){
$sqlstate = "SELECT State_Name, ID FROM ".TBL_PREFIX."_state WHERE `Country_ID`=".$RowData->Country_ID." ORDER BY State_Name";
$querystate = $obj->query($sqlstate);
while($RowDatastate = $obj->fetchNextObject($querystate)){
?>
<option value="<?php echo $RowDatastate->ID; ?>"  <?php echo ($RowDatastate->ID==$RowData->State_ID)?'selected="selected"':'';?> ><?php echo $RowDatastate->State_Name; ?></option>
<?php } } ?>
   
  </select>
  </span></td>
</tr>
<tr>
  <td ><div align="right"><strong>City Name : </strong></div></td>
  <td colspan="3"><input type="text" name="cityNm" id="cityNm" size="71" value="<?php echo stripslashes($RowData->City_Name)?>"/></td>
</tr>
<tr> 
  <td ><div align="right"><strong>City URL : </strong></div></td>
  <td colspan="3"><input type="text" name="cityUrl" id="cityUrl" size="71" value="<?php echo stripslashes($RowData->City_Url)?>"/></td>
</tr>

<tr>
  <td valign="top" ><div align="right"><strong>City Code : </strong></div></td>
  <td colspan="3"><input type="text" name="cityCd" id="cityCd" size="71" value="<?php echo stripslashes($RowData->City_Code)?>"/></td>
</tr>
<tr>
  <td valign="top" ><div align="right"><strong>Optional City Name: </strong></div></td>
  <td colspan="3"><input type="text" name="optionalNm" id="optionalNm" size="71" value="<?php echo stripslashes($RowData->City_Optional)?>"/></td>
</tr>
<tr>
  <td valign="top" ><div align="right"><strong>Descritpion : </strong></div></td>
  <td colspan="3">
  <textarea name="cityDesc" id="cityDesc" style="width:710px; height:150px;"><?php echo stripslashes($RowData->City_Desc)?></textarea></td>
</tr>




<tr>
<td width="230">&nbsp;</td>
<td colspan="3"><input type="submit" class="form-button" value="Submit"></td>
</tr>
</table>
</form>
</td>	
<script type="text/javascript">

function GetState(countryid){
var param = 'country='+countryid;
jQuery.post('status/getstate.php',param, function(data){
jQuery("#sts").html(data);
})
}

function ValidateCityFrm(obj) {

	msg = "<font color='red'><strong>Error : Following is missing.</strong><br /></font>";
	str = "";
	if(obj.countryid.value == "0") {
		str += "Please select country.<br />";
	}
	
	if(obj.selectstate.value == "0") {
		str += "Please select state.<br />";
	}
	
	if(obj.cityNm.value == "") {
		str += "Please enter city name.<br />";
	}
	if(str) {
		$.fancybox(msg+str);
		return false;
	}
}
</script>
		
		