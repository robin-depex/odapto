<?php

//fetch_user.php

include('database_connection.php');

session_start();


//////////############################################################################////////////////
/////////// To get all users ///////////////
///////////#####################################/////////////////////////



$query = "SELECT * FROM tbl_users WHERE ID != '".$_SESSION['user_id']."' ";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

$output = '
<table id="example" class="table table-bordered table-striped">
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
		<td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['ID'].'" data-tousername="'.$row['Full_Name'].'" style="margin-top:-4px;">Start Chat</button></td>
	</tr>
	';
}

$output .= '</table>'; 

echo $output;

?>