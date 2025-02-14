<?php
require_once("classes/Category.php");
require_once("../common/SimpleImage.php");
$objImg = new SimpleImage();

$objCategory = new Category();
$editid = $_GET['id'];
if($editid !=""){
$sql_ftch = "SELECT * FROM ".TBL_PREFIX."_category WHERE ID = ".$editid."";
$query9 = $obj->query($sql_ftch);
$RowData = $obj->fetchNextObject($query9);
}

if(isset($_REQUEST['addstatus'])=='yes'){ 
extract($_REQUEST);
if($editid!=""){ 

$objCategory->EditCategory($editid,$Parentcategory,$CategoryNm,$product_img1,$CategoryDesc);
}else{ 
  
$imgpath = '';

$path = $_FILES['product_img1']['name'];   
if($_FILES['product_img1']['name']!=''){   
  if($objImg->checkImageFile($path)==1){
    $objImg->load($_FILES['product_img1']['tmp_name']);
    $image1=time().$_FILES['product_img1']['name'];
    $imgpath .= $image1;
    $objImg->save("../cat_icon/".$RowData->Directory_Name."/".$image1);
    $objImg->load("../cat_icon/".$RowData->Directory_Name."/".$image1);
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
    $objImg->save("../cat_banner/".$RowData->Directory_Name."/".$image2);
    $objImg->load("../cat_banner/".$RowData->Directory_Name."/".$image2);
    $objImg->resizeToHeight('122');
    $imgsize2 = $_REQUEST['size'];
   }
}   

$objCategory->AddCategory($Parentcategory,$CategoryNm,$CategoryUrl,$imgpath,$imgpath2,$CategoryDesc);
}
}
?>
<td class="content-main hidenavlayer">
  <form name="categoryFrm" id="categoryFrm" method="post" action="" style="margin:0px;" onsubmit="return ValidateCategoryFrm(this)" enctype="multipart/form-data">
  <input type="hidden" name="addstatus" id="addstatus" value="yes" />
<table border="0" cellpadding="3" cellspacing="0" class="tabelle1" width="100%">
<tr>
  <td class="titel" colspan="2"><?php echo ($editid!="")?'Edit':'Add';?> Department </td>
  <td width="437" class="titel" style="font-weight: bold; text-align: center;"></td>
  <td width="394" class="titel" style="font-weight: bold; text-align: right;"><a href="<?php echo ADMIN_URL;?>index.php?page=category" style="font-size:12px; text-decoration:none; color:#FFFFFF;"><span class="buttons">View All Department</span></a></td>
</tr>


<tr>
  <td ><div align="right"><strong>Select Parent Category </strong></div></td>
  <td colspan="3">
  
  <select name="Parentcategory" id="Parentcategory" style="width:194px;">
  <option value="NA">[Select Category]</option>
  <option value="0">[Make Parent]</option>
  <?php
  $sqlCount = "SELECT Category_Name, Parent_ID, ID FROM ".TBL_PREFIX."_category WHERE `status`=1  GROUP BY ID ORDER BY Parent_ID";
$queryCount = $obj->query($sqlCount);
while($RowDataCou = $obj->fetchNextObject($queryCount)){
?>

  <option value="<?php echo $RowDataCou->ID; ?>" <?php echo ($RowDataCou->ID==$RowData->Parent_ID)?'selected="selected"':'';?>><?php echo ($RowDataCou->Parent_ID != 0)?'&nbsp;&nbsp;':''; ?><?php echo $RowDataCou->Category_Name; ?></option>
  
<?php }  ?>
</select>  </td>
</tr>
<tr>
  <td ><div align="right"><strong>Category Name </strong></div></td>
  <td colspan="3"><input type="text" name="CategoryNm" id="CategoryNm" size="71" value="<?php echo stripslashes($RowData->Category_Name)?>"/></td>
</tr>
<tr> 
  <td ><div align="right"><strong>Category URL: </strong></div></td>
  <td colspan="3"><input type="text" name="CategoryUrl" id="CategoryUrl" size="71" value="<?php echo stripslashes($RowData->Category_Url)?>"/></td>
</tr>
<tr> 
  <td><div align="right"><strong>Category Icon: </strong></div></td>
  <td colspan="3"><input type="file" name="product_img1" id="product_img1" size="71" value="<?php echo stripslashes($RowData->Category_Icon)?>"/></td>
</tr>
<tr> 
  <td><div align="right"><strong>Category Banner: </strong></div></td>
  <td colspan="3"><input type="file" name="product_img2" id="product_img2" size="71" value="<?php echo stripslashes($RowData->category_banner)?>"/></td>
</tr>
<tr>
  <td valign="top" ><div align="right"><strong>Descritpion : </strong></div></td>
  <td colspan="3">
  <textarea name="CategoryDesc" id="CategoryDesc" style="width:710px; height:150px;"><?php echo stripslashes($RowData->Category_Desc)?></textarea></td>
</tr>




<tr>
<td width="230">&nbsp;</td>
<td colspan="3"><input type="submit" class="form-button" value="Submit"></td>
</tr>
</table>
</form>
</td>	
<script type="text/javascript">

function ValidateCategoryFrm(obj) {

	msg = "<font color='red'><strong>Error : Following is missing.</strong><br /></font>";
	str = "";
	if(obj.Parentcategory.value == "NA") {
		str += "Please select Category.<br />";
	}
	
	if(obj.CategoryNm.value == "") {
		str += "Please enter category name.<br />";
	}
	if(str) {
		$.fancybox(msg+str);
		return false;
	}
}
</script>
		
		    