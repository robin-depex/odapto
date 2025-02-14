<?php
session_start();
require_once("../../common/config.php");
$arr =$_POST['ids'];
$Submit =$_GET['action'];
if(count($arr)>0){
	echo $str_rest_refs=implode(",",$arr);
	if($Submit=="Delete")
	{$sql="delete from ".TBL_PREFIX."_city where ID in ($str_rest_refs)"; 
		$obj->execute($sql);
		$sess_msg="Selected record(s) has been deleted successfully.";
		$objCommon->Show_message($sess_msg);
	  
    }
	elseif($Submit=="Activate")
	{	
		$sql="update ".TBL_PREFIX."_city set status=1 where ID in ($str_rest_refs)";	
		$obj->execute($sql);
		
		$sess_msg="Selected record(s) has been activated successfully.";
		$objCommon->Show_message($sess_msg);
		
	}
	elseif($Submit=="Deactivate")
	{
		$sql="update ".TBL_PREFIX."_city set status=0 where ID in ($str_rest_refs)";
		$obj->execute($sql);
		$sess_msg="Selected record(s) has been deactivated successfully.";
		$objCommon->Show_message($sess_msg);
	}
	
	elseif($Submit=="Popular")
	{
		$sql="update ".TBL_PREFIX."_city set PopularCities=1 where ID in ($str_rest_refs)";
		$obj->execute($sql);
		$sess_msg="Selected record(s) has been make popular successfully.";
		$objCommon->Show_message($sess_msg);
	}
	
	elseif($Submit=="InPopular")
	{
		$sql="update ".TBL_PREFIX."_city set PopularCities=0 where ID in ($str_rest_refs)";
		$obj->execute($sql);
		$sess_msg="Selected record(s) has been remove from popular list successfully.";
		$objCommon->Show_message($sess_msg);
	}
		
	}
	
else{
	$sess_msg="Please select check box.";
	$objCommon->Push_Error($sess_msg);	
	$objCommon->wtRedirect("../index.php?page=city");	
	}
	$objCommon->wtRedirect("../index.php?page=city");
?>