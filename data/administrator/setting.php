<td class="content-main hidenavlayer">
<table border="0" cellpadding="3" cellspacing="0" class="tabelle1" width="100%">
<tr>
<td colspan="2" class="titel">All Setting List</td>

<td width="597" class="titel" style="font-weight: bold; text-align: left;">
<span class="message"><?php  echo $_SESSION['sess_error_mess']; echo $_SESSION['sess_mess'];$_SESSION['sess_error_mess']=""; $_SESSION['sess_mess']="";?></span>
</td>
<td width="244" class="titel" style="font-weight: bold; text-align: right;">
<a href="<?php echo ADMIN_URL;?>index.php?page=addsetting" style="font-size:12px; color:#FFFFFF; text-decoration:none;"><span class="buttons">Add Setting</span></a></td>
</tr>
<tr>
<td colspan="4">
<form name="frm_list" action="" method="post" style="margin:0;padding:0 ">
<table class="greyBorder" align="center" border="0" cellpadding="4" cellspacing="1" width="100%" style="margin-top:6px;">
<tbody>
<tr class="boxheadbg">
<td align="center" width="4%">  <input name="check_all" type="checkbox" id="check_all" value="check_all" onclick="checkall(this.form)" /></td>
<td align="left" width="3%" >No.</td>
<td align="left" width="24%" >Model Name</td>
<td align="left" width="24%" >Review</td>
<td align="left" width="51%">Totall View </td>
<td align="center" width="9%">Date</td>
<td align="center" width="9%" >&nbsp;</td>
</tr>
<?php include_once("../common/php-pagination-class.php");
$paging = new pagination();


/* *********** Pagination Start ********** */
$rows_per_page = 20;

$page_num = $_GET['pages'];

$sqlPaging = "SELECT  * FROM ".TBL_PREFIX."_review ";
$queryPaging = $obj->query($sqlPaging);
$nu_rows = $obj->numRows($queryPaging);
$arrays = $paging->calculate_pages($nu_rows, $rows_per_page, $page_num);								
/* *********** Pagination End ********** */						

$sql1 = "SELECT * FROM ".TBL_PREFIX."_site_parameter ORDER BY id DESC ".$arrays['limit'];


$query1 = $obj->query($sql1);
$numrow = $obj->numRows($query1);
$num = 1;
while($rows = $obj->fetchNextObject($query1)){ 

?>
<tr class="<?php echo ($num%2==0)?"evenrow":"oddrow";?>">
<td class="txtmain" align="center" valign="top"> <input type="checkbox" name="ids[]" value="<?php echo intval($rows->id); ?>" /> </td>
<td class="txtmain" align="left" valign="top"><?php echo ($num);?></td>
<td class="txtmain" align="left" valign="top"><?php echo stripslashes($product->comp_name);?></td>
<td class="txtmain" align="left" valign="top"><?php echo stripslashes($rows->review_title);?></td>
<td align="left" valign="top" class="txtmain"><?php echo substr(strip_tags($rows->desc),0,150);?>..</td>
<td align="center" valign="top" class="txtmain"><strong><?php echo DateFormat($rows->adddate); ?></strong></td>
<td align="center" valign="top" ><a href="<?php echo ADMIN_URL;?>index.php?page=addsetting&id=<?php echo intval($rows->prod_id); ?>"><img src="images/edit-icon.png" border="0" title="Edit" /></a> &nbsp;<img src="images/<?php echo ($rows->status==1)?'icon-active.gif':'inactive.png';?>" border="0" title="<?php echo ($rows->status==1)?'Published':'Unpublished';?>" /></td>
</tr>

<?php $num++; } ?>

<tr>
  <td colspan="6" class="dark_red"  align="right">
  
  
  <select name="action2" id="action2">
<option value="Activate">Publish</option>
	<option value="Deactivate">Unpublish</option>
	<option value="Delete">Delete</option>
</select>
&nbsp;
<input name="Submit" value="Apply" class="button" onclick="return del_prompt(this.form)" type="submit" /> </td>
</tr>
<tr>
<td colspan="6" class="dark_red" valign="top"><table align="center">
<tbody>
<tr>
<td align="center">



<!--  Start of pagination code -->

<?php
if($nu_rows < 1 ){						  
?>
<span style="color:#FF0000; font-weight:bold;"> Records not found..</span> 
<?php                                  
}else{
echo '&nbsp;<a href="'.ADMIN_URL.'index.php?page=review&pages='.$arrays['previous'].'"><span style=" border: 1px solid #C3C3C3; color: #1122CC; font-family: Arial,Helvetica,sans-serif;font-size: 12px; font-weight: bold; padding: 0 3px; margin-right:11px;">Previous</span></a>';

foreach($arrays['pages'] as $numPages){
echo '<a href="'.ADMIN_URL.'index.php?page=review&pages='.$numPages.'">';
?>
<span style=" border: 1px solid #C3C3C3; color: #1122CC; font-family: Arial,Helvetica,sans-serif;font-size: 12px; font-weight: bold; padding: 0 3px; ">
<?php
echo $numPages;


?></span></a>&nbsp;
<?php
} 

echo '&nbsp;<a href="'.ADMIN_URL.'index.php?page=review&pages='.$arrays['next'].'"><span style=" border: 1px solid #C3C3C3; color: #1122CC; font-family: Arial,Helvetica,sans-serif;font-size: 12px; font-weight: bold; padding: 0 3px; ">Next</span></a>';
echo "&nbsp;&nbsp;&nbsp;&nbsp;";

echo $arrays['info'];
}

?>      


<!--  End of pagination code -->                                  </td>
</tr>
</tbody>
</table></td>
</tr>

<tr class="oddRow" align="center">
<td colspan="9" class="warning"></td>
</tr>
</tbody>
</table>
</form></td>
</tr>
</table>

</td>

<script>
	function checkall(objForm)
    {
	len = objForm.elements.length;
	var i=0;
	for( i=0 ; i<len ; i++){
		if (objForm.elements[i].type=='checkbox') 
		objForm.elements[i].checked=objForm.check_all.checked;
	}
   }
   function del_prompt(frmobj)
		{
		
		var comb = frmobj.action2.value;
		
			if(comb=="Delete"){
				if(confirm ("Are you sure you want to delete the record(s)."))
				{
					frmobj.action = "status/review_status.php?action=Delete";
					frmobj.submit();
				}
				else{ 
				return false;
				}
		}
		else if(comb=="Deactivate"){
					frmobj.action="status/review_status.php?action=Deactivate";
			frmobj.submit();
		}
		else if(comb=="Activate"){			
			frmobj.action="status/review_status.php?action=Activate";
			frmobj.submit();
		}
		
	}
</script>