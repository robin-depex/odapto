<?php  
ob_start();
session_start();
require_once("common/config.php");
require_once('DBInterface.php');
$db = new Database();
$db->connect();


if(isset($_REQUEST['data'])){
	$admin_id = $_SESSION['sess_login_id'];
	$data = explode("_",$_REQUEST['data']);
	$visibility = isset($data[0]) ? $data[0] : '';
	$board_id = isset($data[1]) ? $data[1] : '';
	$team_id = isset($data[2]) ? $data[2] : '';
	$temp_catId = isset($data[3]) ? $data[3] : '';
	if( ($visibility == "0") || ($visibility == "2") ){
		$update = array("meta_value"=>$visibility);
		$condition = array("meta_key"=>"board_visibility" , "board_id" => $board_id );
		if($db->update("tbl_user_boardmeta",$update, $condition)){
			$result = $db->getBoardDetails($board_id);
		
			$board_visibility = $result['board_visibility'];
			if($board_visibility == 0){
				$icon = "fa fa-lock";
				$name = "Private";
			}else if($board_visibility == 2){
				$icon = "fa fa-globe";
				$name = "Public";
				
				$tempBoard = $db->get_data('tbl_templates',array('name'=>$result['board_title']));
				if(empty($tempBoard))
				{
				    $lastTempId = $db->insert("tbl_templates",array('name' => $result['board_title'],'image' => $result['bg_img'],'cat_id' => $temp_catId,'board_id' => $board_id,'description' => 'this is test template of board'));
    		
        			$db->insert('tbl_user_template',array('userid' => $admin_id,'template_id' => $lastTempId));
        			$tempbid = $db->insert('tbl_tmp_board',array('cat_id'=>$lastTempId,'board_name'=>$result['board_title'],'board_bgimage'=>$result['bg_img'],'status'=> '1'));
        			
        			$boardList = $db->getBoardList($board_id);
    				foreach($boardList as $list)
    				{
    				    $listCard = $db->getListCard1($list['list_id']);
    				    
    				    $listId = $db->insert('tbl_tmp_board_list',array('cat_id'=>$temp_catId,'board_id'=>$tempbid,'list_title'=>$list['list_title'],'list_color'=>$list['list_color'],'list_icon'=>$list['list_icon'],'bgimage'=>$list['list_icon'],'bgcolor'=>$list['list_color']));
    				    foreach($listCard as $card)
    				    {
    				        $db->insert('tbl_tmp_board_list_card',array('board_id'=>$tempbid,'cat_id'=>$temp_catId,'list_id'=> $listId,'card_name'=> $card['card_title'],'card_description'=>$card['card_description']));
    				    }
    				    
    				}
				}
    			
    		
			}
			?>
			<h4 class="visibility"><i class="<?php echo $icon ?>" aria-hidden="true"></i> <?php echo $name; ?></h4>
			<script type="text/javascript">
				function closeVisibilityDiv()
				{
				  $("#BoardVisibilityDiv").css({'display':'none'}); 
				}

				$(".visibility").click(function(event) {
				  /* Act on the event */
				  $("#BoardVisibilityDiv").css({'display':'block'});
				});
			</script>

			<?php
		}else{
			echo "Error";
		}
	}else{
		$update = array("meta_value"=>$visibility,"team_id" => $team_id);
		$condition = array("meta_key"=>"board_visibility" , "board_id" => $board_id );
		$db->update("tbl_user_boardmeta",$update, $condition);
		
		$condition_team_board = array("board_id"=>$board_id);
		$update_team_baord = array("team_id"=>$team_id);
		$db->update("tbl_team_board",$update_team_baord, $condition_team_board);

		$condition_user_board = array("board_id"=>$board_id,"admin_id"=>$admin_id);
		$update_user_baord = array("type"=>"TB");
		if($db->update("tbl_user_board",$update_user_baord, $condition_user_board)){
			echo "Updated";
		}


	} 
	
	
}
?>
