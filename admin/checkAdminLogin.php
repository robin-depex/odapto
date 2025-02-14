<?php 
include('dbconfig.php');
//echo $db->testToken();

if($_REQUEST['action'] == "admin_log"){
	
	$username = trim($_REQUEST['username']);
	$passwd = $_REQUEST['password'];
	//echo $passwd;die;

	$result = $db->chkAdminLogin($username,$passwd);


	$results = json_decode($result,true);

	if($results['result']=="TRUE"){
		//header("location:add_user.php");
		ini_set('session.gc_maxlifetime', 3600);
		session_set_cookie_params(3600);
		
		$_SESSION['admin_auth'] = true;
		$_SESSION['admin_id'] = $results['data']['admin_id'];
		$_SESSION['username'] = $results['data']['username'];
		$_SESSION['email'] = $results['data']['email'];
		$_SESSION['authtoken'] = $results['data']['authtoken'];
		echo $result;
	}else{
		echo $result;
	}
}else{
		echo "Wrong Username/Password ?";
}
?>