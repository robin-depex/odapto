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
	$visibility = $data[0];
	$board_id = $data[1];
	$team_id = $data[2];
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
