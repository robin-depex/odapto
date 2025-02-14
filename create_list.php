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
	
	$board_id = $_REQUEST['bid'];
	$list_name = $_REQUEST['list_name'];
	$string = $_REQUEST['qstring'];
	$rand = $db->generateRandomString();
	$list_data = array("board_id"=>$board_id,"list_title"=>$list_name,"list_color"=>'#FF0000',"listkey"=> $rand);
	$countlist = mysqli_num_rows(mysqli_query($db->dbh,"SELECT * FROM tbl_board_list WHERE board_id = '".$board_id."'"));
$countlistnew = $countlist+1;
	$insert_list = $db->insert("tbl_board_list",$list_data);

	if($insert_list){
	    
	$list_id = $db->getListId($rand);	
    $list_data = $db->getBoardList($board_id);
     $count = sizeof($list_data);
     $width = (288*$count)+50;

		$listcard = array("list_id"=>$list_id,"def"=>1,"del_status"=>1);
 $message = '<div class="out'.$insert_list.'"><div class="in1'.$insert_list.'" id="first'.$insert_list.'" style="width:288px;height:auto;margin-left: 10px;float: left; display: inline-block;"><div class="col-sm-12" style="padding-left:0px;"><div class="board-title-input"><form action="" method="post"><input type="text" class="form-control list-Title n-p" id="'.$countlistnew.'_'.$insert_list.'" onblur="return editListTitle(this.id)" value="'.$list_name.'" style="height:27px;width: 90%"></form></div>';
        $message .= '<div class="col-sm-12 task" style="background-color: #f7f7f7; padding:8px 10px;position: relative;"><div style="max-height: 350px; margin-top:6px; border:1px solid #fdfdfd;overflow-y: scroll" id="list_'.$insert_list.'" class="scrolly"></div><a href="javascript:void(0)" id="'.$countlistnew.'" onclick="return addCard(this.id);" class="list-btn">Add a card...</a>

<div class="save-board"><div style="display:none;position:relative;left: 0px;bottom:0px;width:100%;background-color: #f1f1f1;height:102px;border-top: 1px solid #f1f1f1;padding:7px;z-index: 99" id="Boardlist_'.$countlistnew.'" class="cardboxnew_'.$insert_list.'  col-sm-12 status"><div style="width: 100%;">';
         $message .= '<form action="" method="post" id="addCardForm_'.$insert_list.'" enctype="multipart/data"><div class="form-group" style="margin-bottom: 0px;"><textarea rows="3" id="cardName_'.$insert_list.'" class="form-control" style="height: 50px;"></textarea>
         </div><div class="col-sm-12 n-p"><a id="'.$countlistnew.'_'.$insert_list.'" href="javascript:void(0)" class="list-btn save_card" onclick="return createCard(this.id);">Save</a><a href="jabascript:void(0)" id="'.$countlistnew.'_closeList" onclick="return close_list(this.id)" style="width:16px; height: 16px;display: inline-block; margin-left: 10px;color: #000"><span class="fa fa-times"></span></a></div></form></div></div></div></div></div></div></div>';


	//	$db->insert("tbl_board_list_card",$listcard);
		$url = "https://www.odapto.com/dashboard.php?".$string;
		
		//to push send notification
	    $member = $db->getBoardmembers($board_id);
                    // $countmember = count(str_split($member));
                    // if($countmember>0){
					$array = explode(",",$member);
					
					foreach ($array as $value) {
						$result = $db->getUserMeta($value);
						$result1 = $db->getsingledata('tbl_users','ID',$value);
    
						$usr_id=$result1['ID'];
						if($senderid != $usr_id)
						{
						    $notify_data=array(
                            'notif_title' => 'New List added',
                            'notif_msg' => $name.' created a  new List',
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
		
		$response = json_encode(array("result"=>"TRUE","divwidth"=>$width,"message"=>$list_name,"msgdata"=>$message,"url"=>$url));
	}else{
		$response = json_encode(array("result"=>"FALSE","message"=>"Error"));
	}
	echo $response;

}
}
?>