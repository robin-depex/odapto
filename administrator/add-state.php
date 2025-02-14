<?php
require_once("classes/State.php");
require_once("../common/SimpleImage.php");
$objImg = new SimpleImage();

$objState = new State();
$editid = $_GET['id'];
if($editid !=""){
$sql_ftch = "SELECT * FROM ".TBL_PREFIX."_state WHERE ID = ".$editid."";
$query9 = $obj->query($sql_ftch);
$RowData = $obj->fetchNextObject($query9);
}


if(isset($_REQUEST['addstatus'])=='yes'){ 
extract($_REQUEST);
if($editid!=""){ 
  $objState->EditState($editid,$countryid,$StateNm,$StateUrl,$StateCd,$StateDesc);
}else{ 

$imgpath = '';

$path = $_FILES['product_img1']['name'];   
if($_FILES['product_img1']['name']!=''){   
  if($objImg->checkImageFile($path)==1){
    $objImg->load($_FILES['product_img1']['tmp_name']);
    $image1=time().$_FILES['product_img1']['name'];
    $imgpath .= $image1;
    $objImg->save("../state_thumbnail/".$RowData->Directory_Name."/".$image1);
    $objImg->load("../state_thumbnail/".$RowData->Directory_Name."/".$image1);
    $objImg->resizeToHeight('122');
    $imgsize = $_REQUEST['size'];
   }
}

$imgpath2 = '';

$path2 = $_FILES['product_img2']['name'];   
if($_FILES['product_img2']['name']!=''){   
  if($objImg->checkImageFile($path2)==1){
    $objImg->load($_FILES['product_img2']['tmp_name']);
    $image2=time().$_FILES['product_img2']['name'];
    $imgpath2 .= $image2;
    $objImg->save("../state_banner/".$RowData->Directory_Name."/".$image2);
    $objImg->load("../state_banner/".$RowData->Directory_Name."/".$image2);
    $objImg->resizeToHeight('122');
    $imgsize2 = $_REQUEST['size'];
   }
} 

  $objState->AddState($countryid,$StateNm,$StateUrl,$StateCd,$StateDesc,$imgpath,$imgpath2);

}
}
?>
<td class="content-main hidenavlayer">
  <form name="stateFrm" id="stateFrm" method="post" action="" style="margin:0px;" onsubmit="return ValidateStateFrm(this)" enctype="multipart/form-data">
  <input type="hidden" name="addstatus" id="addstatus" value="yes" />
<table border="0" cellpadding="3" cellspacing="0" class="tabelle1" width="100%">
<tr>
  <td class="titel" colspan="2"><?php echo ($editid!="")?'Edit':'Add';?> Country </td>
  <td width="437" class="titel" style="font-weight: bold; text-align: center;"></td>
  <td width="394" class="titel" style="font-weight: bold; text-align: right;"><a href="<?php echo ADMIN_URL;?>index.php?page=state" style="font-size:12px; text-decoration:none; color:#FFFFFF;"><span class="buttons">View All State</span></a></td>
</tr>


<tr>
  <td ><div align="right"><strong>Select Country </strong></div></td>
  <td colspan="3">
  
  <select name="countryid" id="countryid" style="width:194px;">
  <option value="0">[Country]</option>
  <?php
  $sqlCount = "SELECT Country_Name, ID FROM ".TBL_PREFIX."_country WHERE status=1 ORDER BY Country_Name";
  $queryCount = $obj->query($sqlCount);
  while($RowDataCou = $obj->fetchNextObject($queryCount)){
?>

  <option value="<?php echo $RowDataCou->ID; ?>" <?php echo ($RowDataCou->ID==$RowData->Country_ID)?'selected="selected"':'';?>><?php echo $RowDataCou->Country_Name; ?></option>
  
<?php }  ?>
</select>
  
  </td>
</tr>
<tr>
  <td ><div align="right"><strong>State Name </strong></div></td>
  <td colspan="3"><input type="text" name="StateNm" id="StateNm" size="71" value="<?php echo stripslashes($RowData->State_Name)?>"/></td>
</tr>
<tr> 
  <td ><div align="right"><strong>State URL: </strong></div></td>
  <td colspan="3"><input type="text" name="StateUrl" id="StateUrl" size="71" value="<?php echo stripslashes($RowData->State_Url)?>"/></td>
</tr>

<tr>
  <td valign="top" ><div align="right"><strong>State Code: </strong></div></td>
  <td colspan="3"><input type="text" name="StateCd" id="StateCd" size="71" value="<?php echo stripslashes($RowData->State_Code)?>"/></td>
</tr>
<tr> 
  <td><div align="right"><strong>State Thumb: </strong></div></td>
  <td colspan="3"><input type="file" name="product_img1" id="product_img1" size="71" value="<?php echo stripslashes($RowData->state_thumbnail)?>"/></td>
</tr>
<tr> 
  <td><div align="right"><strong>State Banner: </strong></div></td>
  <td colspan="3"><input type="file" name="product_img2" id="product_img2" size="71" value="<?php echo stripslashes($RowData->state_banner)?>"/></td>
</tr>
<tr>
  <td valign="top" ><div align="right"><strong>Descritpion : </strong></div></td>
  <td colspan="3">
  <textarea name="StateDesc" id="StateDesc" style="width:710px; height:150px;"><?php echo stripslashes($RowData->State_Desc)?></textarea></td>
</tr>




<tr>
<td width="230">&nbsp;</td>
<td colspan="3"><input type="submit" class="form-button" value="Submit"></td>
</tr>
</table>
</form>
</td>	
<script type="text/javascript">

function ValidateStateFrm(obj) {

	msg = "<font color='red'><strong>Error : Following is missing.</strong><br /></font>";
	str = "";
	if(obj.countryid.value == "0") {
		str += "Please select country.<br />";
	}
	
	if(obj.StateNm.value == "") {
		str += "Please enter state name.<br />";
	}
	if(str) {
		$.fancybox(msg+str);
		return false;
	}
}
</script>
		
		