<?php
$db_host_name = 'localhost';
$db_user_name = 'odapto_odapto';
$db_password = '(F-HPS!r0-[+';
$db_name = 'odapto_odapto';

function dbconnect(){
	global $db_host_name, $db_user_name, $db_password, $db_name;
	$con = mysqli_connect($db_host_name,$db_user_name,$db_password,$db_name);
	// Check connection
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}else{
		return $con;
	}
}
?>