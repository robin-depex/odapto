<?php
if(!empty($_GET['clientid']))
{
	
	header("Content-type:application/json");
	$lid=$_GET['clientid'];
	$host = "localhost";
$user = "odapto";
$pass = "M0S*bLROd,6h";
$database = "odapto";
$conn = mysqli_connect($host,$user,$pass,$database);
	$query="select * from emp_detail where id='$lid'";
	$runq=mysqli_query($conn,$query);
	$num=mysqli_num_rows($runq);
	if($num>0)
	{	
	$rows=mysqli_fetch_array($runq);
	$ci = $rows['client_id'];
	$fn = $rows['first_name'];
	$ln = $rows['last_name'];
	$em = $rows['email_id'];
	$de = $rows['designation'];
	deliver_response(200,"Contact Data here",$lid,$ci,$fn,$ln,$em,$de);
	}
	else
	{
	deliver_response(200,"No contact Data",NULL,NULL,NULL,NULL,NULL,NULL);
	}
}
else
{
	deliver_response(400,"Invalid request",NULL,NULL,NULL,NULL,NULL,NULL);
	
}
function deliver_response($status,$status_msg,$id,$cli_id,$fn,$ln,$emid,$de)
{
	header("HTTP/1.1 $status $status_msg");
	
	$response=array();
	$response['status']=$status;
	$response['status_msg']=$status_msg;
	$response['id']=$id;
	$response['cliid']=$cli_id;
	$response['fname']=$fn;
	$response['lname']=$ln;
	$response['email']=$emid;
	$response['dsgn']=$de;
	
	echo "\n";
	$json_response=json_encode($response);
	echo $json_response;
}
?>