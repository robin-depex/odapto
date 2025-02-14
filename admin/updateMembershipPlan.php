<?php
error_reporting(0);
include('dbconfig.php');
//print_r($_POST);
if($_POST['action']=='update_plan')
{
    $fname=$_POST['field_name'];
    $fvalue=$_POST['field_value'];
    $update_data = array($fname => $fvalue);
    
    $cond=array(
        'id'=>$_POST['plan_id']
        );
        
    $update = $db->update("tbl_membership_plan",$update_data, $cond);
    if($update)
    {
        echo "Successfully Updated..";
    }else{
        echo "fail !! Please try again";
    }
}
?>