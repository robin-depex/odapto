<?php
date_default_timezone_set("Asia/Kolkata");
require_once("DBInterface.php");
$db = new Database();
$db->connect();

//$decodevalue = json_decode($_POST);

		$result = $db->getLastChecklist1($_POST['cardid']);
		//print_r($result);

echo '<option  value="'.$result[0]['comments'].','.$result[0]['id'].'">'.$result[0]['comments'].'</option>';
