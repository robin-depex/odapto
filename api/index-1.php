<?php  
header('content-type: application/json');
$input = file_get_contents('php://input');
if($input!=""){
	
	$arr = json_decode($input,true);
	//print_r($arr);
	$req_type = $arr['RequestData']['requestType'];
	//echo $req_type;die();
	//echo "data=".$input;die;
	//define("API_LINK","http://depextechnologies.org/odapto/api/");	
	define("API_LINK","https://www.odapto.com/api/");	
	header("location:".API_LINK.$req_type.".php?data=".$input);
/*	if($req_type == "user_register"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "user_login"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "user_logout"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "create_board"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "edit_board_title"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "user_delete"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "get_vcode"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "resend_code"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "verify_code"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "user_board"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "create_list"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "list_board"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "list_card"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "create_card"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "star_board"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "board_privacy"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "create_team"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "team_list"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "user_team"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "update_list_title"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "update_card_title"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "card_comments"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "card_description"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "search_members"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "all_card_comment"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "label_list"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "card_label_list"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "update_card_comment"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "delete_card_comment"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}	else if($req_type == "move_list"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}	else if($req_type == "move_card"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}	else if($req_type == "copy_list"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}
	
	else if($req_type == "copy_card"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}
	else if($req_type == "add_label_text"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "edit_label_text"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}*/
	
	
	
	
}	

?>
