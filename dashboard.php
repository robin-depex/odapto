<?php  
session_start();
require_once("common/config.php");
require_once("DBInterface.php");
$db = new Database();
$db->connect();
if(isset($_SESSION['sess_login_id'])){
$uid = $_SESSION['sess_login_id'];
$result = $db->getUserMeta($uid);

if(isset($_REQUEST['page']) && $_REQUEST['page'] == "home"){
	$bg_color = $result['bg_color'];
	$span_dis = "none";	
}
else if(isset($_REQUEST['page']) && $_REQUEST['page'] == "board")
{
	$bid = $_REQUEST['b'];
	$backgound = $db->get_board_background($bid);
	$bg_type = $backgound['bg_type'];

	if($backgound['bg_color']!='' AND $backgound['bg_img']!=""){
		$bg_img = $backgound['bg_img'];
		$bg_color = "url('".$bg_img."')";
	}
	
	elseif ($backgound['bg_img']!="") {
		$bg_img = $backgound['bg_img'];
		$bg_color = "url('".$bg_img."')";
	}

	elseif ($backgound['bg_img']=='' AND $backgound['bg_color']!='') {
		$bg_color = $backgound['bg_color'];	
		$span_dis = "none";
		
	}
	
	else{
		$bg_color = $backgound['bg_color'];	
		$span_dis = "none";
	}
}else{
	$bg_color = $result['bg_color'];
	$span_dis = "none";	
}
include("inc/dashboard-header.php");
include("inc/dashboard-menu.php");
if(!empty($_SERVER['QUERY_STRING'])){
if(!empty($_REQUEST['page'])){
$pagename = $_REQUEST['page'];	
	switch ($pagename)
	{
		
		case "home":
		include("home.php");
		break;	

		case "board":
		include("dashboard-content.php");
		break;	

		case "profile":
		include("profile.php");
		break;	

		case "team":
		include("team.php");
		break;

		case "single_view":
		include("single-temp-view.php");
		break;
		case "live_chat":
		include("live-chat.php");
		break;

		default:
		include("404.php");
	}	 
	 

}else{
	include("404.php");

}
}else{
	include("home.php");
}
include("inc/dashboard-footer.php");
}else{
	unset($_SESSION['OAUTH_ACCESS_TOKEN']);
unset($_SESSION['user_detaile']);
header("location:".SITE_URL);
}

?>
