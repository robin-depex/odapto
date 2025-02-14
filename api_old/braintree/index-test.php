<?php
ini_set('display_errors', 1);
echo "hello ";
die();
header('content-type: application/json');
$input = file_get_contents('php://input');
if($input!=""){
	$arr = json_decode($input,true);
	$req_type = $arr['RequestData']['requestType'];	
	define("API_LINK","https://www.odapto.com/api/");	
	header("location:".API_LINK.$req_type.".php?data=".$input);
}
?>