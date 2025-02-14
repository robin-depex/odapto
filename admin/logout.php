<?php  
session_start();
session_unset($_SESSION['admin_auth']);
session_destroy();
$url = "https://www.odapto.com/admin/";
header("location: ".$url);
?>