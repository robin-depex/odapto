<?php  
session_start();
require_once("DBInterface.php");
$db = new Database();
$db->connect();

$senderid = $_SESSION['sess_login_id'];
$name=$db->getName($senderid);
	
if(isset($_REQUEST['data'])){


	$data = explode("&",$_REQUEST['data']);
	
	$card = explode("=",$data[0]);
	$card_id = $card[1];

	$card_desc = explode("=",$data[1]);
	$card_desc = $card_desc[1];

	$data_update = array("card_description"=>$card_desc);
	$cond = array("card_id"=>$card_id);
	$update = $db->update("tbl_board_list_card",$data_update,$cond);

	if($update ){
	    
	    //to push send notification
	    
	     
            
	    $result4 = $db->getsingledata('tbl_board_list_card','card_id',$card_id);
	    $board_id=$result4['board_id'];
	    
	    $dd=$db->getBoardKeyValue($board_id);
            $key = explode(",", $dd['mvalue']);
           $t= $key[0];
            $k= $key[1];
            $url="https://www.odapto.com/dashboard.php?page=board&b=".$board_id."&t=".$t."&k=".$k;
	    
	    
	     
	    $member = $db->getBoardmembers($board_id);
                    $countmember = count($member);
                    //echo $countmember;
                    if($countmember>0){
					$array = explode(",",$member);
					
					foreach ($array as $value) {
						$result = $db->getUserMeta($value);
						$result1 = $db->getsingledata('tbl_users','ID',$value);
    
						$usr_id=$result1['ID'];
						if($senderid != $usr_id)
						{
						    $notify_data=array(
                            'notif_title' => 'New Description added',
                            'notif_msg' => $name.' added a  description',
                            'notif_time' => date('Y-m-d H:i:s'),
                            'notif_repeat' => 1,
                            'notif_loop' => 1,
                            'notif_user_from' =>$senderid,
                            'notif_user_to' => $usr_id,
                            'notif_url' => $url,
                            'notif_for' => 'web',
                            'status' => 1
                        );
                    $insertNotification = $db->insert("tbl_push_notification",$notify_data);
						    
						}
					}
					
					}
	    //end notification
	    
		echo $card_desc;
	}else{
		echo $error;
	}

}



?>