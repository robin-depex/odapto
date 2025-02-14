<?php
$input = file_get_contents('php://input');
require_once("DBInterface.php");
$db = new Database();
$db->connect();

$arr = json_decode($input, true);
$req_type = $arr['RequestData']['requestType'];
$action = $arr['RequestData']['action'];
$v_code = $arr['RequestData']['v_code'];
$api_key = $arr['RequestData']['apikey'];
$max_attempt = 3;
$param = (isset($arr['RequestData']) && is_array($arr['RequestData'])) ? $arr['RequestData'] : array();
$data = $db->getVcode();
foreach ($data as $value) {
    $code = $value['v_code'];
    $apikey = $value['APIKey'];
}

function reset_pass_text() {
    return '<!doctype html> 
    <html>
        <head>
            <meta charset="utf-8">
            <title>Password Recovery</title>
            <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        </head>

        <body>
            <div style="margin:auto;background: #f7f7f7; float:left;  margin-top: 2px;padding:2px 0; border: 2px solid #8c2d37;
                 border-radius: 10px;">
                <table border="0" style="margin:auto; width:100%; font-size: 13px;color: #666;background: #fff;">
                    <tr>
                        <td colspan="2" style="background-color:#8c2d37; border-radius: 8px 8px 0 0; padding: 7px 0;" align="center">
                            <img  margin:0 auto; display:block" src="https://www.odapto.com/images/logo.png" width="150px">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p>

                                Dear Sir/Madam {{name}},<br><br>

                                Your One Time Password (OTP) is {{otp}} to reset your Password.<br><br>

                                This OTP is valid for 10 minutes and 2 attempt.<br><br>

                                Please do not share this One Time Password with anyone.<br><br>

                            </p>               
                        </td>
                    </tr>

                    </tr>  
                    <tr>
                        <td>
                            <img style="width:650px" width="650" src="https://www.odapto.com/images/mailer.jpg">     
                        </td>     
                    </tr>
                </table>
            </div>
        </body>
    </html>';

}

function rp_sendOtpEmail($name, $otp, $email){
    global $db;
    $subject = "Odapto: Password recovery mail";
    $fromemail = 'admin@odapto.com';
    $msg = str_replace(array('{{name}}', '{{otp}}'), array($name, $otp), reset_pass_text());
    return $db->sendEmail($subject, $msg, $email);
}

function rp_noaction($code, $msg, $res=array(), $flag=false, $success_code='') {
    return array(
        "successBool" => $flag,
        "successCode" => "$success_code",
        "response" => $res,
        "ErrorObj" => array(
            "ErrorCode" => "$code",
            "ErrorMsg" => "$msg"
        )
    );
}

function rp_sendotp($param) {
    global $db;
    $email = isset($param['email']) ? $param['email'] : '';
    if(empty($email)){
        return rp_noaction("108", "Email field is required");
    }
    
    $udata = $db->getUserDataByEmail($email);
    if(count($udata)){
        $tmp_id = md5($udata['ID']);
        $otp = $db->getOtp();
        $time = time();
        $attampt = 0;
        $forgot_pass_otp = implode('|', array($otp, $time, $attampt, $tmp_id));
        $status = $db->update('tbl_users', array('forgot_pass_otp'=>$forgot_pass_otp), array('ID'=>$udata['ID'], 'Email_ID'=>$email));
        $email_status = rp_sendOtpEmail($udata['Full_Name'], $otp, $email);
        if($status && $email_status == 1){
            return rp_noaction("200", "OTP send to your email", array('email'=>$email, 'secret'=>$tmp_id), true, 200);
        }else{
            return rp_noaction("108", "Something went wrong, please try after some time!");
        }
    }else{
        return rp_noaction("108", "Email does not exists!");
    }
    
}

function rp_resetpass($param) {
    global $db;
    global $max_attempt;
    $email = isset($param['email']) ? $param['email'] : '';
    $password = isset($param['password']) ? $param['password'] : '';
    $cnf_password = isset($param['cnf_password']) ? $param['cnf_password'] : '';
    $otp = isset($param['otp']) ? $param['otp'] : '';
    $secret = isset($param['secret']) ? $param['secret'] : '';
    if(empty($email)){
        return rp_noaction("108", "Email field is required");
    }else if(empty ($password)){
        return rp_noaction("108", "Password field is required");
    }else if(empty ($cnf_password)){
        return rp_noaction("108", "Confirm password field is required");
    }else if($password !== $cnf_password){
        return rp_noaction("108", "Password and Confirm password did not match");
    }
    
    $udata = $db->getUserDataByEmail($email);
    if(count($udata)){
        $otp_data = explode('|', $udata['forgot_pass_otp']);
        $min_diff = round(abs(time() - $otp_data[1]) / 60,2);
        if($otp_data[3] != $secret){
            return rp_noaction("108", "Invalid request");
        }else if($min_diff > 10){
            return rp_noaction("108", "OTP is expired");
        }else if($otp_data[2] >  $max_attempt){
            return rp_noaction("108", "OTP is attempt exceeded");
        }else if($otp_data[0] != $otp){
            $otp_data[2] += 1; 
            $forgot_pass_otp = implode('|', $otp_data);
            $db->update('tbl_users', array('forgot_pass_otp'=>$forgot_pass_otp), array('ID'=>$udata['ID'], 'Email_ID'=>$email));
            return rp_noaction("108", "Please enter correct otp");
        }
        
        $status = $db->update('tbl_users', array('forgot_pass_otp'=>'', 'User_Password'=> md5($password)), array('ID'=>$udata['ID'], 'Email_ID'=>$email));
        if($status){
            return rp_noaction("200", "Password reset successfully", array(), true, 200);
        }else{
            return rp_noaction("108", "Something went wrong, please try after some time!");
        }
    }else{
        return rp_noaction("108", "Invalid request");
    }
}

if ($code != $v_code) {
    $response = rp_noaction("105", "Update Your Version");
} else if ($api_key !== $apikey) {
    $response = rp_noaction("106", "Invalid APIkey");
} else {

    switch ($action) {
        case 'sendotp':
            $response = rp_sendotp($param);
            break;
        case 'resetpass':
            $response = rp_resetpass($param);
            break;
        default :
            $response = rp_noaction("107", "Invalid Action");
    }
}
//echo json_encode($response);
$result_response = json_encode($response);
$log_data = array("serviceurl" => $req_type, "request" => $input, "response" => $result_response, "entrydate" => date("Y-m-d H:i:s a"));
$db->insert("error_log", $log_data);
header('content-type: application/json');
echo $result_response;
?>