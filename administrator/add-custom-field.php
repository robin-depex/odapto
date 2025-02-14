<?php
require_once("classes/CustomField.php");
$objCustom = new CustomField();
$editid = $_GET['id'];
if($editid !=""){
$sql_ftch = "SELECT * FROM ".TBL_PREFIX."_custom_field WHERE ID = ".$editid."";
$query9 = $obj->query($sql_ftch);
$RowData = $obj->fetchNextObject($query9);
}

if(isset($_REQUEST['addstatus'])=='yes'){ 
extract($_REQUEST);
if($editid!=""){ 
$objCustom->EditCustomField($editid,$category,$fieldvalue);
}else{ 
$objCustom->AddCustomField($category,$fieldvalue);
}
}
?>    
<td class="content-main hidenavlayer">
  <form name="customfieldFrm" id="customfieldFrm" method="post" action="" style="margin:0px;"  >
  <input type="hidden" name="addstatus" id="addstatus" value="yes" />
<table border="0" cellpadding="3" cellspacing="0" class="tabelle1" width="100%">
<tr>
  <td class="titel" colspan="2"><?php echo ($editid!="")?'Edit':'Add';?> Custom Field </td>
  <td width="437" class="titel" style="font-weight: bold; text-align: center;"></td>
  <td width="394" class="titel" style="font-weight: bold; text-align: right;"><a href="<?php echo ADMIN_URL;?>index.php?page=customfield" style="font-size:12px; text-decoration:none; color:#FFFFFF;"><span class="buttons">View All Custom Field</span></a></td>
</tr>


<tr>
  <td ><div align="right"><strong>Select Parent Category </strong></div></td>
  <td colspan="3">
  
  <select name="category" id="category" style="width:194px;">
  <option value="NA">[Select Category]</option>

  <?php
  $sqlCount = "SELECT Category_Name, Parent_ID, ID FROM ".TBL_PREFIX."_category WHERE `status`=1 AND `Parent_Id`!=0 ORDER BY  Category_Name";
$queryCount = $obj->query($sqlCount);
while($RowDataCou = $obj->fetchNextObject($queryCount)){
?>

  <option value="<?php echo $RowDataCou->ID; ?>" <?php echo ($RowDataCou->ID==$RowData->Category_ID)?'selected="selected"':'';?>><?php echo ($RowDataCou->Parent_ID != 0)?'&nbsp;&nbsp;':''; ?><?php echo $RowDataCou->Category_Name; ?></option>
  
<?php }  ?>
</select>  </td>
</tr>



<tr> 
  <td ><div align="right"><strong>Type Name : </strong></div></td>
  <td colspan="3"><input type="text" name="fieldvalue" id="fieldvalue" size="71" value="<?php echo stripslashes($RowData->Field_Value)?>"/></td>
</tr>





<tr>
<td width="230">&nbsp;</td>
<td colspan="3"><input type="submit" class="form-button" value="Submit"></td>
</tr>
</table>
</form>
</td>	
