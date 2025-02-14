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
    
    $query1 = "SELECT * FROM tbl_push_notification  WHERE  notif_user_to = '$to_user_id' ORDER by id desc limit 5";
	$statement1 = $connect->prepare($query1);
	$statement1->execute();
	$count1 = $statement1->rowCount();
	$list='';
	if($count1>0)
	{
	    while($row=$statement1->fetch()) :
	        $list.='<li><a class="dropdown-item" href="'.$row['notif_url'].'"><p>'.$row['notif_title'].'<br><small>'.$row['notif_msg'].'</small> </p> </a></li>';
	     endwhile;
	}else{
	     $list.='<li><a class="dropdown-item" href="#"><p>No Notifications </p> </a></li>';
	}
	

	$query = "SELECT * FROM tbl_push_notification  WHERE  notif_user_to = '$to_user_id' AND status ='1'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = $statement->rowCount();
	$output = '';
	
	if($count > 0)
	{
		$output= '<span class="notification" > '.$count.'</span>';
	}
		$results =  array(
                    'result'=>'TRUE',
                    'list'=> $list,
                    'count' =>$output
                    );
        

        echo json_encode($results);  
	//echo $output;
}

if($_POST['action'] == 'seen_notification')
{
    $to_user_id= $_POST['notify_user_to'];
    $update=$connect->prepare("update tbl_push_notification set status=0 where notif_user_to='$to_user_id' AND status=1");
    if($update->execute())
    {
        $query1 = "SELECT * FROM tbl_push_notification  WHERE  notif_user_to = '$to_user_id' ORDER by id desc limit 5";
    	$statement1 = $connect->prepare($query1);
    	$statement1->execute();
    	$count1 = $statement1->rowCount();
    	$list='';
    	if($count1>0)
    	{
    	    while($row=$statement1->fetch()) :
    	        $list.='<li><a class="dropdown-item" href="'.$row['notif_url'].'"><p>'.$row['notif_title'].'<br><small>'.$row['notif_msg'].'</small> </p> </a></li>';
    	     endwhile;
    	}else{
    	     $list.='<li><a class="dropdown-item" href="#"><p>No Notifications </p> </a></li>';
    	}
        $output= '<span class="notification" > </span>';
        $results =  array(
                    'result'=>'TRUE',
                    'count' =>$output,
                    'list' =>$list
                    );
        

        echo json_encode($results);
    }
    
}


?>