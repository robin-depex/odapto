<?php

//update_last_activity.php

include('database_connection.php');

session_start();
$last_activity=date("Y-m-d H:i:s");
$query = "
UPDATE chat_login_details  SET last_activity ='".$last_activity."'
WHERE login_details_id = '".$_SESSION["login_details_id"]."'
";

$statement = $connect->prepare($query);

$statement->execute();

?>

