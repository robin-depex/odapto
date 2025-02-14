<?php

//database_connection.php

$connect = new PDO("mysql:host=localhost;dbname=odapto_odapto;charset=utf8mb4", "odapto_odapto", "(F-HPS!r0-[+");

date_default_timezone_set('Asia/Kolkata');

function fetch_user_last_activity($user_id, $connect)
{
	$query = "
	SELECT * FROM chat_login_details 
	WHERE user_id = '$user_id' 
	ORDER BY last_activity DESC 
	LIMIT 1
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['last_activity'];
	}
}

function fetch_user_chat_history($from_user_id, $to_user_id, $connect)
{
	$query = "
	SELECT * FROM chat_message 
	WHERE (from_user_id = '".$from_user_id."' 
	AND to_user_id = '".$to_user_id."') 
	OR (from_user_id = '".$to_user_id."' 
	AND to_user_id = '".$from_user_id."') 
	ORDER BY timestamp ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '<ul class="list-unstyled" >';
	foreach($result as $row)
	{
		$user_name = '';
		$seen='';
		$bg='';
		$brds='';
		$mleft='';
		$mright='';
		
		if($row["from_user_id"] == $from_user_id)
		{
			$user_name = '<b class="text-danger">You</b>';
			//$bg='#67b867';
			$bg='#dcf8c5';
			$brds=" 4px 30px";
			$mright="-10px";
			
			if($row['status']==0)
			{
			    $seen='seen';
			}
		}
		else
		{
			//$user_name = '<b class="text-danger pull-right">'.get_user_name($row['from_user_id'], $connect).'</b>';
			$user_name = '<b class="text-success ">Admin</b>';
			$bg='#fef1c2';
			$brds="25px  4px ";
			$mleft="-10px";
		}
		$output .= '
		<li style="border-bottom:1px dotted #ccc; background:'.$bg.'; padding-left:5px; padding-top:7px; border-radius: '.$brds.';margin-bottom:4px; margin-right:'.$mright.'; margin-left:'.$mleft.'">
			<p style="color:#000">'.$user_name.' - '.$row["chat_message"].'
				<div align="right">
					 <small style="color:grey"><em>'. date('H:i', strtotime($row['timestamp'])) .' '.$seen.' </em></small>
				</div>
			</p>
		</li>
		';
	}
	$output .= '</ul>';
	$query = "
	UPDATE chat_message 
	SET status = '0' 
	WHERE from_user_id = '".$to_user_id."' 
	AND to_user_id = '".$from_user_id."' 
	AND status = '1'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $output;
}

function get_user_name($user_id, $connect)
{
	$query = "SELECT Full_Name FROM tbl_users WHERE ID = '$user_id'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['Full_Name'];
	}
}

function count_unseen_message($from_user_id, $to_user_id, $connect)
{
	$query = "
	SELECT * FROM chat_message 
	WHERE from_user_id = '$from_user_id' 
	AND to_user_id = '$to_user_id' 
	AND status = '1'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = $statement->rowCount();
	$output = '';
	if($count > 0)
	{
		$output = '<span class="label label-success">'.$count.'</span>';
	}
	return $output;
}

function fetch_is_type_status($user_id, $connect)
{
	$query = "
	SELECT is_type FROM chat_login_details 
	WHERE user_id = '".$user_id."' 
	ORDER BY last_activity DESC 
	LIMIT 1
	";	
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		if($row["is_type"] == 'yes')
		{
			$output = ' - <small><em><span class="text-muted">Typing...</span></em></small>';
		}
	}
	return $output;
}

function fetch_group_chat_history($connect)
{
	$query = "
	SELECT * FROM chat_message 
	WHERE to_user_id = '0'  
	ORDER BY timestamp DESC
	";

	$statement = $connect->prepare($query);

	$statement->execute();

	$result = $statement->fetchAll();

	$output = '<ul class="list-unstyled">';
	foreach($result as $row)
	{
		$user_name = '';
		if($row["from_user_id"] == $_SESSION["user_id"])
		{
			$user_name = '<b class="text-success">You</b>';
		}
		else
		{
			$user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $connect).'</b>';
		}

		$output .= '

		<li style="border-bottom:1px dotted #ccc">
			<p>'.$user_name.' - '.$row['chat_message'].' 
				<div align="right">
					- <small><em>'.$row['timestamp'].'</em></small>
				</div>
			</p>
		</li>
		';
	}
	$output .= '</ul>';
	return $output;
}


?>