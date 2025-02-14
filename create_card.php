<?php  
ob_start();
session_start();
require_once("DBInterface.php");
$db = new Database();
$db->connect();

$senderid = $_SESSION['sess_login_id'];
$name=$db->getName($senderid);

if(isset($_REQUEST['token'])){
if($_REQUEST['token'] == $_SESSION['Tocken']){
	
	//echo json_encode($_REQUEST); die();
	$list_id = $_REQUEST['list_id'];
	$card_title = $_REQUEST['card_title'];
	$page = $_REQUEST['qstring'];
	$b = $_REQUEST['b'];
	$t = $_REQUEST['t'];
	$k = $_REQUEST['k'];
	$string = $page."&b=".$b."&t=".$t."&k=".$k; 
//	$card_data = $db->getListCard($listid);
	 $querycard = "SELECT * FROM tbl_board_list_card WHERE list_id = $list_id";
        $resultcard = mysqli_query($db->dbh,$querycard);
        $rowcountcard = mysqli_num_rows($resultcard);
        $positioncart = $rowcountcard+1;
        
        
       
        
        
     
	$card_data = array("list_id"=>$list_id,"card_title"=>$card_title,"board_id"=>$b,"position"=>$positioncart);
	$insert_card = $db->insert("tbl_board_list_card",$card_data);
	if($insert_card){
		$url = "https://www.odapto.com/dashboard.php?".$string;
		
		//to insert push notifiocation 
		//to get get id and board members and send notification
        $results_board = mysqli_fetch_array($resultcard);
        $brd_id=isset($results_board['board_id']) ? $results_board['board_id'] : 0;
		 $member = $db->getBoardmembers($brd_id);
                    // $countmember = count($member);
                    // //echo $countmember;
                    // if($countmember>0){
					$array = explode(",",$member);
					
					foreach ($array as $value) {
						$result = $db->getUserMeta($value);
						$result1 = $db->getsingledata('tbl_users','ID',$value);
    
						$usr_id=$result1['ID'];
						if($senderid != $usr_id)
						{
						    $notify_data=array(
                            'notif_title' => 'New card added',
                            'notif_msg' => $name.' created a  new card',
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
					
					//}
		//end notification
		


 $message ='<div class="form-control form-contro input-sm card-Title box-item" id="'.$list_id.'_'.$insert_card.'_'.$b.'" onClick="return openCardModal(this.id)" itemid="'.$list_id.'_'.$insert_card.'_'.$b.'" style="z-index:99; height: auto;" ondrop="drop(event,'.$insert_card.')" ondragover="allowDrop(event)">';


  $message .='<div class="imagePreviewDb52"></div><div style="float:left"><span class="list-span">'.$card_title.'</span></div><div class="clearfix"></div><div class="all-item"><div style="display:none;"><span class="fa fa-comments edit-card">0</span></div><div style="display:none;"><span class="fa fa-paperclip"></span><span class="pull-right">0</span></div><ul class="cardduedatelist list-inline"></ul></div></div>';

		$response = json_encode(array("result"=>"TRUE","url"=>$url,"message"=>$message));
	}else{
		$response = json_encode(array("result"=>"FALSE","message"=>"Error"));
	}
	echo $response;

}
}
?>