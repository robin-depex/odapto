<?php 

$host = $_SERVER['SERVER_NAME'];
    
if($host == "localhost"){
    // local Dev Environment Setup
	define("HOST","localhost");
	define("USER","M0S*bLROd,6h");
	define("PASS","");
	define("DATABASE","odapto");
	define("TBL_PREFIX", "tbl");
	
	define("ADMIN_URL_FOLDER", "administrator");
	
	define("SITE_URL","http://localhost/odapto/");
	define("LOGIN_SITE_URL","http://localhost/odapto/dashboard.php");
	define("ADMIN_LOGIN_URL","http://localhost/odapto/".ADMIN_URL_FOLDER."/login.php");
	define("ADMIN_URL","http://localhost/odapto/".ADMIN_URL_FOLDER."/");
	define("SERVICE_FOLDER", "service");
	define("SERVICE_URL","http://localhost/odapto/".SERVICE_FOLDER."/");
	
	
}else{
	// Live Dev Environment Setup
	define("HOST","localhost");
	define("USER","M0S*bLROd,6h");
	define("PASS","");
	define("DATABASE","odapto");
	define("TBL_PREFIX", "tbl");
	define("ADMIN_URL_FOLDER", "administrator");

	define("SERVICE_FOLDER", "service");
	define("SERVICE_URL","https://www.odapto.com/".SERVICE_FOLDER."/");
	define("SITE_URL","https://www.odapto.com/");
	define("LOGIN_SITE_URL","https://www.odapto.com/dashboard.php");
	
	define("ADMIN_LOGIN_URL","https://www.odapto.com/".ADMIN_URL_FOLDER."/login.php");
	define("ADMIN_URL","https://www.odapto.com/".ADMIN_URL_FOLDER."/");
}

require_once("db.class.php");

?>