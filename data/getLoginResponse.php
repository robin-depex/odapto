<?php 
require_once('DBInterface.php');
$db = new Database();
$db->connect();
//echo $db->testToken();

if(!empty($_REQUEST['username']) && !empty($_REQUEST['password'])){
	
	$username = trim($_REQUEST['username']);
	$passwd = md5($db->clean_input($_REQUEST['password']));
	//echo $passwd;die;

	$result = $db->chkLogin($username,$passwd);


	$results = json_decode($result,true);

	if($results['result']=="TRUE"){
		//header("location:add_user.php");
		ini_set('session.gc_maxlifetime', 3600);
		session_set_cookie_params(3600);
		session_start();

		$_SESSION['auth'] = true;
		$_SESSION['sess_login_id'] = $results['userId'];
		$_SESSION['fullname'] = $results['FullName'];
		$_SESSION['Tocken'] = $results['Tocken'];
		echo $result;
	}else{
		echo $result;
	}
}else{
		echo "Wrong Username/Password ?";
}
?>