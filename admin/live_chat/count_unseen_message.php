<?php
include('database_connection.php');
//print_r($_POST);
if($_POST['action'] == 'unseen_message')
{
    $to_user_id= $_POST['user_id'];

	$query = "SELECT * FROM chat_message  WHERE  to_user_id = '$to_user_id' AND status = '1'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = $statement->rowCount();
	$output = '';
	if($count > 0)
	{
		$output= '<span class="notification" > '.$count.'</span>';
	}
	echo $output;
    
}
if($_POST['action'] == 'unseen_notification')
{
    $to_user_id= $_POST['notify_user_to'];

	$query = "SELECT * FROM tbl_push_notification  WHERE  notif_user_to = '$to_user_id'  AND status ='1' AND role='admin'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = $statement->rowCount();
	$output = '';
	$list='';
	if($count > 0)
	{
	    while($row=$statement->fetch()) :
	        $list.='<li><a class="dropdown-item" href="'.$row['notif_url'].'"><p>'.$row['notif_title'].'<br><small>'.$row['notif_msg'].'</small> </p> </a></li>';
	   endwhile;
		$output= '<span class="notification" > '.$count.'</span>';
		
		$results =  array(
                    'result'=>'TRUE',
                    'list'=> $list,
                    'count' =>$output
                    );
        

        echo json_encode($results);   
	}
	//echo $output;
}


?>