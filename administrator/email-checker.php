<?php  
require_once("../DBInterface.php");
$db = new Database();
$db->connect();

if(!empty($_REQUEST['username'])){
	$emailid = $_REQUEST['username'];
	$check = $db->chkEmail($emailid);
	if($check == "1"){
		echo "Email Already Exists";
	}	
}



?>