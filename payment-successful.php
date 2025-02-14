<!DOCTYPE html>
<?php  error_reporting(0);
ini_set('display_errors', 1);
require_once("common/config.php");
session_start();

require_once("DBInterface.php");
$db = new Database();
$db->connect();
if(!empty($_SESSION['auth'])){
$uid = $_SESSION['sess_login_id'];
$result = $db->getUserMeta($uid);

} 
$sql = "SELECT * FROM payments WHERE payment_amount = '".$_SESSION['post_data']['no_note']."' AND itemid = '".$_SESSION['post_data']['item_number']."' ORDER BY id DESC";
//echo $sql;
$gatpayment = $db->get_query_data($sql);
//print_r($gatpayment);
$last_id = $gatpayment['id'];
if($gatpayment['itemid']=='2'){
$plan_id = '2';
}else{
$plan_id = '3';
}
$db->insert('user_payment',array('user_id'=>$_SESSION['sess_login_id'],'pay_id'=>$last_id,'plan_id'=>$plan_id,'status'=>1));

$con = array(
'ID' => $_SESSION['sess_login_id'],
		);
	$expiry_date= date('Y-m-d', strtotime('+1 months'));

				$data_user_device = array(
					'membership_plan' => $plan_id,
					'expiry_date'=>$expiry_date,
				);
				$db->update("tbl_users",$data_user_device,$con);
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> <?php echo $gatpayment['itemid']; ?> - Success</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
     <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
     <style>
        body{
        font-family: 'Montserrat', sans-serif;    
        } 
     </style>
</head>
<body>
 <div class="container">
    <div class="row">
     <div style="    background:#ffffff;padding: 20px 15px;" class="col-sm-12">
            <a style="color:#FFF" href="index.php"><img style="width:150px" src="images/logo.png"></a>
                 <!--  <li class="pull-right"><a style="color:#FFF" href="#">Go to Your Boards →</a></li> -->
         
            </div>    
    </div> 
 </div>    
 <div style="margin-top:50px" class="col-sm-6 col-sm-offset-3">
  <table class="table table-bordered">
    <thead>
      <tr>
     <h1 style="font-size: 22px;
    background: red;
    margin: 0;
    padding: 10px 14px;
    color: #fff;
    background: #00bf00;">Your payment has been successful. <i class="fa fa-check-circle pull-right" aria-hidden="true"></i></h1>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Your Payment Amount is:</td>
        <td>$ <?php echo $_SESSION['post_data']['no_note']; ?></td>
      </tr>
      <tr>
        <td>Plan Name:</td>
        <td><?php $plan_id=$_SESSION['post_data']['item_number'];
                    if($plan_id==2)
                    {
                       echo 'BUSINESS CLASS'; 
                    }
                    if($plan_id==3)
                    {
                        echo 'ENTERPRISE';
                    }
        ?></td>
      </tr>
    </tbody>
  </table>
  <a class="btn btn-primary" href="https://odapto.com/dashboard.php">Go Back</a>
 </div>  
 <div class="clearfix"></div>
   <!-- <h1>Transaction Name: - <?php echo $gatpayment['txnid']; ?></h1>-->



</body>
</html>
