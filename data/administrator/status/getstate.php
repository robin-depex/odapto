<?php
require_once("../../common/config.php");
$countryid =$_REQUEST['country'];
?>
<select name="selectstate" id="selectstate" style="width:194px;">
<option value="0">[State]</option>
<?php
$sqlstate = "SELECT State_Name, ID FROM ".TBL_PREFIX."_state WHERE `Country_ID`=".$countryid." ORDER BY State_Name";
$querystate = $obj->query($sqlstate);
while($RowDatastate = $obj->fetchNextObject($querystate)){
?>
<option value="<?php echo $RowDatastate->ID; ?>" ><?php echo $RowDatastate->State_Name; ?></option>
<?php }  ?>
</select>