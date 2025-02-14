<?php  
require_once("common/config.php");
session_start();
session_unset($_SESSION['FBID']);
session_unset($_SESSION['auth']);
session_destroy();

header("location: ".SITE_URL);
?>