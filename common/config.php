<?php 

$host = $_SERVER['SERVER_NAME'];
if($host == "localhost"){
    // local Dev Environment Setup
	define("HOST","localhost");
	define("USER","odapto_odapto");
	define("PASS","(F-HPS!r0-[+");
	define("DATABASE","odapto_odapto");
	define("TBL_PREFIX", "tbl");
	
	define("ADMIN_URL_FOLDER", "administrator");
	
	define("SITE_URL","https://www.odapto.com/");
	define("LOGIN_SITE_URL","https://www.odapto.com/dashboard.php");
	
	define("ADMIN_LOGIN_URL","https://www.odapto.com/".ADMIN_URL_FOLDER."/login.php");
	define("ADMIN_URL","https://www.odapto.com/".ADMIN_URL_FOLDER."/");
	
	
}else{
	// Live Dev Environment Setup
/*	define("HOST","aa1mmkkfbnatt1l.cyapuifkotez.us-east-2.rds.amazonaws.com");
	define("USER","odapto");
	define("PASS","odapto123");
	define("DATABASE","odapto");
	define("TBL_PREFIX", "tbl");
	define("ADMIN_URL_FOLDER", "administrator");

	define("SERVICE_FOLDER", "service");
	define("SERVICE_URL","https://www.odapto.com/".SERVICE_FOLDER."/");
	define("SITE_URL","https://www.odapto.com/");
	define("LOGIN_SITE_URL","https://www.odapto.com/dashboard.php");
	
	define("ADMIN_LOGIN_URL","https://www.odapto.com/".ADMIN_URL_FOLDER."/login.php");
	define("ADMIN_URL","https://www.odapto.com/".ADMIN_URL_FOLDER."/");*/
	define("HOST","localhost");
	define("USER","odapto_odapto");
	define("PASS","(F-HPS!r0-[+");
	define("DATABASE","odapto_odapto");
	define("TBL_PREFIX", "tbl");
	define("ADMIN_URL_FOLDER", "administrator");


	define("SITE_URL","https://www.odapto.com/");
	define("LOGIN_SITE_URL","https://www.odapto.com/dashboard.php");
	
	define("ADMIN_LOGIN_URL","https://www.odapto.com/".ADMIN_URL_FOLDER."/login.php");
	define("ADMIN_URL","https://www.odapto.com/".ADMIN_URL_FOLDER."/");
}

require_once("db.class.php");

?>