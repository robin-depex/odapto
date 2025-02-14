<?php
require_once("../common/config.php");
session_start();
session_unset();
session_destroy();
header("location:".ADMIN_LOGIN_URL);?>