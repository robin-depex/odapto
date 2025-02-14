<?php
session_start();
session_unset('appoint_email');
header("Location: auth.php");

?>