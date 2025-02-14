<?php

//fetch_user.php

include('database_connection.php');

session_start();
$cday=date("Y-m-d H:i:s");
//DELETE FROM on_search WHERE search_date < NOW() - INTERVAL N DAY
$q = "DELETE FROM chat_message WHERE timestamp < NOW() - INTERVAL 1 DAY ";
$s = $connect->prepare($q);
$s->execute();

//to delete unactive users morethan one day unactivity

$qd = "DELETE FROM chat_login_details WHERE last_activity < NOW() - INTERVAL 1 DAY ";
$sd = $connect->prepare($qd);
$sd->execute();

$query = "SELECT * FROM chat_login_details WHERE user_id != '".$_SESSION['user_id']."' ORDER BY last_activity DESC ";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

$output = '
<table class="table table-bordered table-striped">
	<tr>
		<th width="50%">Username</td>
		<th width="25%">Status</td>
		<th width="25%">Action</td>
	</tr>
';

foreach($result as $row)
{
	$status = '';
	$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 600 second');
	$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
	$user_last_activity = $row['last_activity'];
	if($user_last_activity > $current_timestamp)
	{
		$status = '<span class="label label-success">Online</span>';
	}
	else
	{
		$status = '<span class="label label-danger">Offline</span>';
	}
	$output .= '
	<tr>
		<td>'.get_name($row['user_id'], $connect).' '.count_unseen_message($row['user_id'], $_SESSION['user_id'], $connect).' '.fetch_is_type_status($row['user_id'], $connect).'</td>
		<td>'.$status.'</td>
		<td><a type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.get_name($row['user_id'], $connect).'" style="margin-top:-4px;">Start Chat</a></td>
	</tr>
	';
}

$output .= '</table>'; 


//////////############################################################################////////////////
/////////// To get all users ///////////////
///////////#####################################/////////////////////////


/*
$query = "SELECT * FROM tbl_users WHERE ID != '".$_SESSION['user_id']."' ";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

$output = '
<table class="table table-bordered table-striped">
	<tr>
		<th width="50%">Username</td>
		<th width="25%">Status</td>
		<th width="25%">Action</td>
	</tr>
';

foreach($result as $row)
{
	$status = '';
	$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 300 second');
	$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
	$user_last_activity = fetch_user_last_activity($row['ID'], $connect);
	if($user_last_activity > $current_timestamp)
	{
		$status = '<span class="label label-success">Online</span>';
	}
	else
	{
		$status = '<span class="label label-danger">Offline</span>';
	}
	$output .= '
	<tr>
		<td>'.$row['Full_Name'].' '.count_unseen_message($row['ID'], $_SESSION['user_id'], $connect).' '.fetch_is_type_status($row['ID'], $connect).'</td>
		<td>'.$status.'</td>
		<td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['ID'].'" data-tousername="'.$row['Full_Name'].'">Start Chat</button></td>
	</tr>
	';
}

$output .= '</table>'; */

echo $output;

?>