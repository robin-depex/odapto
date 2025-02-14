<?php
$res = array();
include('config.php');
$con = dbconnect();
$sql = mysqli_query($con, "select email,contactor_email,admin_title,contactor_currency,contactor_price from users");
$data = mysqli_fetch_object($sql);
$c_currency = $data->contactor_currency;

$c_price = $data->contactor_price;

$orderId = time();
if(isset($_POST)){

	$to = $data->contactor_email.', '.$_POST['email']; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    $sal = $_POST['sal'];
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $comment = $_POST['comment'];

    $subject = $data->admin_title . 'Enquiry (order No. '.$orderId. ')';

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$from."\r\n".
	    'Reply-To: '.$from."\r\n" .
	    'X-Mailer: PHP/' . phpversion();
$app_dates = $_POST['appoint_dates'];
$qty = 1;
foreach($app_dates as $app_date){
    $app_date .= '<li>'.$app_date.'</li>';
    $qty++;
}

	$message  = '<html><body>';
	$message .= '<h1 style="color:#f40;">'.$data->admin_title.' Appointment</h1>';
	$message .= '<p style="color:#080;font-size:18px;">There are following Detail:-</p>';
	$message .= '<p>Name : '.$sal.' '.$name.'</p>';
    $message .= '<p>Email :'.$from.'</p>';
    $message .= '<p>Mobile :'.$mobile.'</p><br />';
    $message .= '<p>Appointment Date And Times :</p><ul>'.$app_date.'</ul>';
    $message .= '<p>wrote the following:</p>';
    $message .= '<p>'.$comment.'</p>';

    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http" . "://". $_SERVER['HTTP_HOST']."".$_SERVER['REQUEST_URI'];

    $actual_link = str_replace('ajax.php', '', $actual_link);

    $message .= '<p><br /><br /><em>if you want to check your order history <a href="'.$actual_link.'/?order_id='.$orderId.'">click here</a></em></p>';
	$message .= '</p></body></html>';
    $appoint_dates = implode(",",$_POST['appoint_dates']);

    $sql = "INSERT INTO appointment SET name='".$name."', email='".$from."', mobile='".$mobile."', comment='".$comment."', subject='".$subject."', order_id='".$orderId."', order_qty='".$qty."', appoint_dates='".$appoint_dates."', message='".$message."'";
    mysqli_query($con, $sql);
	if(mail($to,$subject,$message,$headers)){
        //mysqli_query($con, $sql);
	}
    
try {
    require "examples/initialize.php";
    $protocol = isset($_SERVER['HTTPS']) && strcasecmp('off', $_SERVER['HTTPS']) !== 0 ? "https" : "http";
    $hostname = $_SERVER['HTTP_HOST'];
    $path = dirname(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF']);
    $tot_price = ($c_price*$qty);
    $tot_price = number_format($tot_price, 2);

    $payment = $mollie->payments->create([
        "amount" => [
            "currency" => $c_currency,
            "value" => $tot_price // You must send the correct number of decimals, thus we enforce the use of strings
        ],
        "description" => "Order #{$orderId}",
        "redirectUrl" => "{$protocol}://{$hostname}{$path}/?order_id={$orderId}",
        "webhookUrl" => "{$protocol}://{$hostname}{$path}/02-webhook-verification.php",
        "metadata" => [
            "order_id" => $orderId,
        ],
    ]);
    $orderId = intval($orderId);
    $price = $payment->amount->value;
    $currency = $payment->amount->currency;
    $payment_status = $payment->status;
    $order_id = $payment->metadata->order_id;

    $sql_updt = "UPDATE appointment SET price ='".$c_price."', order_total ='".$price."', currency='".$currency."', payment_status='".$payment_status."', order_id='".$order_id."' WHERE order_id='".$orderId."'";
    mysqli_query($con, $sql_updt);
    $res['checkout_url'] = $payment->getCheckoutUrl();
    } catch (\Mollie\Api\Exceptions\ApiException $e) {
        $res['error'] = htmlspecialchars($e->getMessage());
    }

echo json_encode($res);
   
}
?>