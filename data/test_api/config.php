<?php 

$host = $_SERVER['SERVER_NAME'];
    
if($host == "localhost"){
    // local Dev Environment Setup
	define("HOST","localhost");
	define("USER","root");
	define("PASS","");
	define("DATABASE","depexloa_odapto");
	define("TBL_PREFIX", "tbl");
}else{
	// Live Dev Environment Setup
	define("HOST","localhost");
	define("USER","depexloa_odapto");
	define("PASS","TWONv,l@-EIx");
	define("DATABASE","depexloa_odapto");
	define("TBL_PREFIX", "tbl");
}
?>