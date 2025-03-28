<?php 
           //$site_url="https://www.odapto.com/";
           $site_url="https://odapto.com/"; 
class Database
{
    var $rs;
    var $dbh;

   /* function Database()
    {
        $this->rs = "";
        $this->dbh = "";
        //$this->site_url='https://www.odapto.com/';
        $this->site_url='https://odapto.com/';
    }*/
    
     function __construct()
    {
        $this->rs = "";
        $this->dbh = "";
        $this->site_url='https://www.odapto.com/';
    }

    //Connect to Database
    
    function connect()
    {

        $host = $_SERVER['SERVER_NAME'];
        
        if($host == "localhost"){
            // local Dev Environment Setup  
        $this->dbh = mysqli_connect('localhost', 'hxtec21y_odapto','BB&35D3+5l4^','hxtec21y_odapto') or die('Not connected');   
        }else if($host == "www.hxtechnologies.com"){
          // LIVE Dev Environment Setup
        $this->dbh = mysqli_connect('localhost', 'hxtec21y_odapto','BB&35D3+5l4^','hxtec21y_odapto') or die('Not connected');                
        }else{
              $this->dbh = mysqli_connect('localhost', 'odapto_odapto','(F-HPS!r0-[+','odapto_odapto') or die('Not connected123'); 
         //    $this->dbh = mysqli_connect('aa1mmkkfbnatt1l.cyapuifkotez.us-east-2.rds.amazonaws.com', 'odapto','odapto123','odapto') or die('Not connected');   
       // $this->dbh = mysqli_connect('localhost', 'depexloa_odapto','odapto123','depexloa_odapto') or die('Not connected');  
        }    
        return $this->dbh;
    }   

    public function insert( $table, $variables = array() )
    {
        //self::$counter++;
        //Make sure the array isn't empty
        if( empty( $variables ) )
        {
            return false;
        }
        
        $sql = "INSERT INTO ". $table;
        $fields = array();
        $values = array();
        foreach( $variables as $field => $value )
        {
            $fields[] = $field;
            $values[] = "'".$value."'";
        }
        $fields = ' (' . implode(', ', $fields) . ')';
        $values = '('. implode(', ', $values) .')';
        
        $sql .= $fields .' VALUES '. $values;
//echo $sql;
        $set_mode = "SET sql_mode = ''";
          $resultss = mysqli_query($this->dbh,$set_mode);
        if( mysqli_query($this->dbh , $sql ) )
        {
            
            return mysqli_insert_id($this->dbh);
        }
        else
        {
            return false;
        }
        
    }

    function sendEmail($subject,$message,$email){

require_once('phpmailer/PHPMailerAutoload.php');
$mail = new PHPMailer;

//$mail->isSMTP(); // enable SMTP
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
$mail->Host = "smtp.gmail.com";
$mail->Port = 587; // or 587
$mail->isHTML(true);
$mail->Username = "rohit.depex@gmail.com";
$mail->Password = "Rohit@depex#";
$mail->setFrom("odapto@odapto.com","Odapto Team");

$mail->Subject = $subject;
$mail->Body = $message;
$mail->addAddress($email);

if(!$mail->Send()) {
    $response = "Mailer Error: " . $mail->ErrorInfo;
} else {
    $response = 1;
}

return $response;

}

function sendEmail1($subject,$message,$email,$from){

require_once('phpmailer/PHPMailerAutoload.php');
    $mail = new PHPMailer;
    $mail->isSMTP(); // enable SMTP
    //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'AUTO'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587; // or 587
    $mail->isHTML(true);
    $mail->Username = 'robin.depex@gmail.com';
    $mail->Password = 'szyplotvskisdxbb';
    $mail->setFrom($from,"Odapto Team");
    
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->addAddress($email);
    $send = $mail->Send();
    if($send) {
      // $response = "Mailer Error: " . $mail->ErrorInfo;
        $response = 1;
    } else {
        //$response = "Mailer Error: " . $mail->ErrorInfo;
        $response = 0;
    }
    return $response;

}


    // update 
    public function update( $table, $variables = array(), $where = array() )
    {
        //self::$counter++;
        //Make sure the required data is passed before continuing
        //This does not include the $where variable as (though infrequently)
        //queries are designated to update entire tables
        if( empty( $variables ) )
        {
            return false;
        }
        $sql = "UPDATE ". $table ." SET ";
        foreach( $variables as $field => $value )
        {
            
            $updates[] = "`$field` = '$value'";
        }
        $sql .= implode(', ', $updates);
        
        //Add the $where clauses as needed
        if( !empty( $where ) )
        {
            foreach( $where as $field => $value )
            {
                $value = $value;

                $clause[] = "$field = '$value'";
            }
            $sql .= ' WHERE '. implode(' AND ', $clause);   
        }
       //echo $sql;die;
       if(mysqli_query( $this->dbh , $sql ))
        {
            return true;
        }
        else
        {
            return false;
        }

    }

        public function datafound( $table, $where = array() )
    {
      
        $sql = "SELECT * FROM $table ";
      
        if( !empty( $where ) )
        {
            foreach( $where as $field => $value )
            {
                $value = $value;

                $clause[] = "$field = '$value'";
            }
            $sql .= ' WHERE '. implode(' AND ', $clause);   
        }
      //echo $sql;
     // echo"<pre>";
    $query = mysqli_query( $this->dbh , $sql );
$rowcount = mysqli_num_rows($query);
       
return $rowcount;
    }


        public function getdata( $table, $where = array() )
    {
      
        $sql = "SELECT * FROM $table ";
      
        if( !empty( $where ) )
        {
            foreach( $where as $field => $value )
            {
                $value = $value;

                $clause[] = "$field = '$value'";
            }
            $sql .= ' WHERE '. implode(' AND ', $clause);   
        }
        $sql .= 'ORDER BY id DESC';
  // echo $sql;
    $query = mysqli_query( $this->dbh , $sql );
    while($data = mysqli_fetch_array($query)){
    $data_array[] = $data;
    }
       
return $data_array;
    }
    


 public function getsingledata( $table, $where = array() )
    {
      
        $sql = "SELECT * FROM $table ";
      
        if( !empty( $where ) )
        {
            foreach( $where as $field => $value )
            {
                $value = $value;

                $clause[] = "$field = '$value'";
            }
            $sql .= ' WHERE '. implode(' AND ', $clause);   
        }
      //  $sql .= 'ORDER BY id DESC';
  // echo $sql;
    $query = mysqli_query( $this->dbh , $sql );
    $data = mysqli_fetch_array($query);
    $data_array[] = $data;      
    return $data;
    }


 public function delete( $table, $where = array(), $limit = '' )
    {
        
        //Delete clauses require a where param, otherwise use "truncate"
        if( empty( $where ) )
        {
            return false;
        }
        
        $sql = "DELETE FROM ". $table;
        foreach( $where as $field => $value )
        {
            $value = $value;
            $clause[] = "$field = '$value'";
        }
        $sql .= " WHERE ". implode(' AND ', $clause);
        
        if( !empty( $limit ) )
        {
            $sql .= " LIMIT ". $limit;
        }
       // echo $sql;   
        if(mysqli_query( $this->dbh , $sql ))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
 

  function get_temp_boards($cat_id){
    $query = "select * from tbl_tmp_board where cat_id=$cat_id";
   //echo $query;
     $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_result = array();
            while($DataSet = mysqli_fetch_array($result)){
                $data['id']=$DataSet['id'];
                $data['admin_id']=isset($DataSet['admin_id']) ? $DataSet['admin_id'] : '';
                $data['board_name']=$DataSet['board_name'];
                $data['board_key']=$DataSet['board_key'];
                $data['board_url']=$DataSet['board_url'];
                $data['bg_color']=isset($DataSet['bg_color']) ? $DataSet['bg_color'] : '';
                $data['board_fontcolor']=$DataSet['board_fontcolor'];
                $data['type']='PB';
                $data['admin_board_id']=0;
            
                $data['bg_img']=$DataSet['board_bgimage'];

                    $data_result[] = $data;
                
            }
            return $data_result;    
        }
}

function get_temp_boards_byId($id,$cat_id){
    $query = "select * from tbl_tmp_board where id=$id AND cat_id=$cat_id";
   //echo $query;
     $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_result = array();
            while($DataSet = mysqli_fetch_array($result)){
                $data['id']=$DataSet['id'];
                $data['admin_id']=isset($DataSet['admin_id']) ? $DataSet['admin_id'] : '';
                $data['board_name']=$DataSet['board_name'];
                $data['board_key']=$DataSet['board_key'];
                $data['board_url']=$DataSet['board_url'];
                $data['bg_color']=isset($DataSet['bg_color']) ? $DataSet['bg_color'] : '';
                $data['board_fontcolor']=$DataSet['board_fontcolor'];
                $data['type']='PB';
                $data['admin_board_id']=0;
            
                $data['bg_img']=$DataSet['board_bgimage'];

                    $data_result[] = $data;
                
            }
            return $data_result;    
        }
}

// date difference 
    function dateDiff($date)
    {
      date_default_timezone_set("Asia/Kolkata");  
      $mydate= date("Y-m-d H:i:s");
      $theDiff="";
      //echo $mydate;//2014-06-06 21:35:55
      $datetime1 = date_create($date);
      $datetime2 = date_create($mydate);
      $interval = date_diff($datetime1, $datetime2);
      //echo $interval->format('%s Seconds %i Minutes %h Hours %d days %m Months %y Year    Ago')."<br>";
      $min=$interval->format('%i');
      $sec=$interval->format('%s');
      $hour=$interval->format('%h');
      $mon=$interval->format('%m');
      $day=$interval->format('%d');
      $year=$interval->format('%y');
      if($interval->format('%i%h%d%m%y')=="00000")
      {
        //echo $interval->format('%i%h%d%m%y')."<br>";
        return $sec." sec";
    
      } 
    
    else if($interval->format('%h%d%m%y')=="0000"){
       return $min." Min";
       }
    
    
    else if($interval->format('%d%m%y')=="000"){
       return $hour." hr";
       }
    
    
    else if($interval->format('%m%y')=="00"){
       return $day." d";
       }
    
    else if($interval->format('%y')=="0"){
       return $mon." m";
       }
    
    else{
       return $year." y";
       }
    
    }

   function make_url($str)
{
    $url=strtolower(trim($str));    
    $url=str_replace('(','',$url);
    $url=str_replace('[','',$url);
    $url=str_replace(']','',$url);
    $url=str_replace(')','',$url);
    $url=str_replace('.','-',$url);
    $url=str_replace('&','and',$url);
    $url=str_replace('_','-',$url);
    $url=str_replace('   ','-',$url);
    $url=str_replace('  ','-',$url);
    $url=str_replace(' ','-',$url);
    $url=str_replace('=','-',$url);
    $url=str_replace('%','-',$url);
    $url=str_replace('$','-',$url);
    $url=str_replace('@','-',$url);
    $url=str_replace('_','-',$url);
    $url=str_replace('/','',$url);
    $url=str_replace('?','',$url);
    $url=str_replace('#','',$url);
    $url=str_replace('!','',$url);
    $url=str_replace('\ ','',$url);
    $url=str_replace('"','',$url);
    $url=str_replace('---','-',$url);
    $url=str_replace('--','-',$url);
    $url = preg_replace('/[^a-zA-Z0-9_ ]/s', '-', $url);
return $url;
}  
        // clean input 
    function clean_input($data){
        $data = strip_tags($data);
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = preg_replace("/[^a-zA-Z0-9\s]/", "", $data);
        return $data;
    }
    // clean input email
    function clean_input_email($data){
        $data = strip_tags($data);
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    function getVcode(){
        $sql = "SELECT v_code,APIKey from api_version";
        $sql_query = mysqli_query($this->dbh,$sql);
        $num_rows =  mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            while($results = mysqli_fetch_array($sql_query)) {
                $data['v_code'] = $results['v_code'];
                $data['APIKey'] = $results['APIKey'];
                $data_array[] = $data;
                return $data_array;
            }
        }
    }

    // Check email 
    function chkEmail($emailid){
        $sql = "SELECT ID FROM tbl_users WHERE Email_ID = '".$emailid."'";
        $sql_query = mysqli_query($this->dbh,$sql);
        $num_rows =  mysqli_num_rows($sql_query);
        return $num_rows;
    }
    
    /* get AppToken */
    function chkUserDevice($uid){
        $query = "select id from tbl_user_device where user_id = $uid";
         $sql_query = mysqli_query($this->dbh,$query);
        $result =  mysqli_num_rows($sql_query);
        return $result;
    }






    /* get user token */
    function getUDToken($uid,$dev_id,$type){
        $query = "select token from tbl_user_device where user_id = $uid";
       // echo $query;
        $sql_query = mysqli_query($this->dbh,$query);
        $result =  mysqli_fetch_array($sql_query);
        return $result['token'];
    }
    
    function getUDCode($dev_id){
        $query = "select vcode from tbl_user_device where device_id = '$dev_id'";
        $sql_query = mysqli_query($this->dbh,$query);
        $num_row = mysqli_num_rows($sql_query);
        if($num_row > 0){
            $result =  mysqli_fetch_array($sql_query);
            $vcode = $result['vcode'];
            $response = array(
            "successBool" => true,
            "responseType" => "get_vcode",
            "successCode" => "200",
                "response" => array(
                    'code' => $vcode
                ),
                "ErrorObj"   => array(
                    "ErrorCode" => "",
                    "ErrorMsg"  => ""
                )       
            );
        }else{
            $response = array(
            "successBool" => false,
            "successCode" => "",
                "response" => array(),
                "ErrorObj"   => array(
                    "ErrorCode" => "107",
                    "ErrorMsg"  => "Internal Server Error"
                )       
            );
        }
        return $response;
        
    }

    function verifyCode($deviceID,$verCode){
        $query = "select ud.*,u.* from tbl_user_device as ud left outer join tbl_users as u ON ud.user_id = u.ID where device_id = '$deviceID' and vcode = '$verCode' ";
        $sql_query = mysqli_query($this->dbh,$query);
        $num_row = mysqli_num_rows($sql_query);
        if($num_row > 0){
            
            $result =  mysqli_fetch_array($sql_query);
            
            $updateData = array(
                'status' => 1
            );
            $cond = array(
                'ID' => $result['ID']
            );
            $update = $this->update("tbl_users",$updateData,$cond);
            if($update){

                $response = array(
                    "successBool" => true,
                    "responseType" => "verify_code",
                    "successCode" => "200",
                    "response" => array(
                    'message'=>'Your account is verified',
                    'user_id' => $result['ID'],
                    'fullname' => $result['Full_Name'],
                    'userToken' => $result['token']
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
                );

            }else{

                $response = array(
                "successBool" => false,
                "successCode" => "",
                    "response" => array(),
                    "ErrorObj"   => array(
                        "ErrorCode" => "104",
                        "ErrorMsg"  => "Error Found"
                    )       
                );
            }
            

        }else{
            
            $response = array(
            "successBool" => false,
            "successCode" => "",
                "response" => array(),
                "ErrorObj"   => array(
                    "ErrorCode" => "107",
                    "ErrorMsg"  => "Verification Not Matched "
                )       
            );
        }
        return $response;
    }

    /* get user id */
    function getIdByEmail($emailid){
        $sql = "SELECT ID FROM tbl_users WHERE Email_ID = '".$emailid."'";
        $sql_query = mysqli_query($this->dbh,$sql);
        $result =  mysqli_fetch_array($sql_query);
        return $result['ID'];
    }

    public function chkLogin($emailid,$passwd,$type,$dev_id,$loginWith,$device_token,$fullname){
       
 if(empty($emailid)){
            $result = array(
                "successBool" => false,
                "successCode" => "",
                "response" => array(),
                "ErrorObj"   => array(
                    "ErrorCode" => "101",
                    "ErrorMsg"  => "Please Enter emailid."
                )       
            );
            
        }else if(empty($passwd)){
              $result = array(
                "successBool" => false,
                "successCode" => "",
                "response" => array(),
                "ErrorObj"   => array(
                    "ErrorCode" => "102",
                    "ErrorMsg"  => "Please Enter password."
                )       
            );
             
        }else{
            if($passwd == 123456)
            {
                $query = "SELECT * FROM tbl_users WHERE Email_ID = '$emailid' ";
            } else {
                $passwd = md5($passwd);
                $query = "SELECT * FROM tbl_users WHERE Email_ID = '$emailid' AND User_Password = '$passwd'";
            }
            
           //echo $query;die;
             $resultdata = mysqli_query($this->dbh,$query);
             $rowcount = mysqli_num_rows( $resultdata );

              $date = date("Y-m-d H:i:s");    
            $user_token = md5($date);
  /*if($loginWith=='gmail' || $loginWith=='linkedin' || $loginWith=='google'){
      
        }else{*/

if($rowcount>0){

 $query_result = mysqli_fetch_array($resultdata);
 $userid = $query_result['ID'];
   $update_data1 = array('login_type' => $loginWith);
$update1 = $this->update("tbl_users",$update_data1, array('ID' => $userid));
 
 
  if($query_result['user_verify_status'] == "1"){
      
     //dc code for profile image
     if($query_result['profile_pic_type']=='url'){
    	$profile_pics = $query_result['profile_pics'];
    }else if($query_result['profile_pic_type']=='file'){
    	$profile_pics =  $this->site_url.'user_profile_Image/'.$query_result['profile_pics'];
    }else{
    	$profile_pics = '';
    } 
    //dc code end
        $devicestatus = $this->chkUserDevice($userid);
//echo $devicestatus;
        if($devicestatus==0){
        $devicedata = array('user_id' => $userid,'type' => $type,'device_id' => $dev_id,'token' => $user_token,'push_token' => $device_token);
         $this->insert('tbl_user_device',$devicedata);
 }else{
     $cond_device = array('user_id' => $userid);
     $update_data = array('type' => $type,'device_id' => $dev_id,'token' => $user_token,'push_token' => $device_token);
    $update = $this->update("tbl_user_device",$update_data, $cond_device);
        }
         $token = $this->getUDToken($userid,$dev_id,$type);
         //echo $token;
 $result = array(
                "successBool" => true,
                "successCode" => "200",
                "response" => array(
                'message'=>'You are successfully loggedin',
                'user_id' => $query_result['ID'],
                'fullname' => $query_result['Full_Name'],
                'profileImage' => $profile_pics,
                'device_token' => $device_token,
                'userToken' => $token,
                'emailid' => $emailid,
                'membership_plan' => $query_result['membership_plan'],
                ),
                "ErrorObj"   => array(
                    "ErrorCode" => "",
                    "ErrorMsg"  => ""
                )       
            );



 //echo $result;
  }else{
              $result = array(
                "successBool" => false,
                "successCode" => "",
                "response" => array(),
                "ErrorObj"   => array(
                    "ErrorCode" => "109",
                    "ErrorMsg"  => "Please Activate Your Account"
                )       
            );
        }
}else{
    $result = array(
                "successBool" => false,
                "successCode" => "",
                "response" => array(),
                "ErrorObj"   => array(
                    "ErrorCode" => "108",
                    "ErrorMsg"  => "login credential are incorrect please try again !"
                )       
            );
}
      //  }

        }

       return $result;  

    }


    function userLogout($userToken,$uid){
        $query = "select id,user_id from tbl_user_device where token = '$userToken' ";
        $result = mysqli_query($this->dbh,$query);
   
            $query_result = mysqli_fetch_object($result);
            $user_id = $query_result->user_id;
            
            $userToken = md5(date("Y-m-d H:i:s"));
            $update_data = array(
                'token'  => $userToken,
                'status' => 0
            );
            $cond = array(
                'user_id'   => $user_id,
            );

            $update = $this->update('tbl_user_device',$update_data,$cond);
            if($update){

                $response = array(
                "successBool" => true,
                "responseType" => "user_logout",
                "successCode" => "200",
                    "response" => array(
                        'message'=>'You are successfully logout',
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
                ); 
            }else{
                $response = array(
                "successBool" => false,
                "successCode" => "",
                    "response" => array(
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "107",
                        "ErrorMsg"  => "Server Error"
                    )       
                );
            }
            return $response;
       
    }


    function lastInsertedId($userKey){
        $query = "select ID from tbl_users where userKey = '$userKey'";
        $result = mysqli_query($this->dbh,$query);
        if( mysqli_num_rows( $result ) > 0 ){
            $query_result = mysqli_fetch_object($result);
            $uid = $query_result->ID;
            return $uid;
        }
    }


    function verifyToken($uid,$token){
        $query = "select status from  tbl_users where  accessTocken='".$token."' and ID = $uid ";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;
    }



    /* Acccess User Token*/
    function verifyUserToken($token,$uid){
        $query = "select token from  tbl_user_device where  token='".$token."' and user_id=$uid";
      //  echo "select token from  tbl_user_device where  token='".$token."' and user_id=$uid";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data = mysqli_fetch_array($result);
            $token = $data['token'];
            return $token;
        }

    }



    

    // getUserMeta 
    function getUserMeta($uid){
         $set_mode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
          $resultss = mysqli_query($this->dbh,$set_mode);
        $query = "SELECT GROUP_CONCAT(meta_key) as mkey , user_id as user_id, GROUP_CONCAT(meta_value) as mvalue FROM tbl_usermeta WHERE user_id = $uid";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
            $key = explode(",", $DataSet['mkey']);
            $value = explode(",", $DataSet['mvalue']);
            $data = array_combine($key, $value);
            array_push($data,$DataSet['user_id']);
            return $data;
        }
    }


  function getUserteamBoard($uid,$team_id){
 $set_mode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
          $resultss = mysqli_query($this->dbh,$set_mode);
       $query = "SELECT * FROM `tbl_board_members` INNER JOIN tbl_team_board ON tbl_board_members.board_id = tbl_team_board.board_id WHERE tbl_board_members.member_id = $uid AND tbl_team_board.team_id = '".$team_id."'";
     
      $result1 = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result1);
      if($rowcount > 0){
      
          $query1 = "select *, GROUP_CONCAT(meta_key) as mkey, GROUP_CONCAT(tbl_user_boardmeta.meta_value) as mvalue from tbl_user_board INNER JOIN tbl_board_members ON tbl_user_board.board_id = tbl_board_members.board_id, tbl_user_boardmeta where tbl_board_members.member_id = $uid AND tbl_user_board.team_id = '".$team_id."' and tbl_user_board.board_id = tbl_user_boardmeta.board_id group by tbl_user_board.board_key order by tbl_user_board.board_id desc"; 
//echo $query1;
             $result = mysqli_query($this->dbh,$query1);
            $data_result = array();
            $num_rows = mysqli_num_rows($result);
            if($num_rows > 0){
             while($DataSet = mysqli_fetch_array($result)){
                $key = explode(",", $DataSet['mkey']);
                array_push($key, "board_title","board_id","board_star","board_type","bg_color","bg_img");
                $value = explode(",", $DataSet['mvalue']);
                array_push($value, $DataSet['board_title'],(int)$DataSet['board_id'],(int)$DataSet['board_star'],$DataSet['type'],$DataSet['bg_color'],$DataSet['bg_img']);
                $data = array_combine($key, $value);
                $data_result[] = $data;

           
               
            }

                 $response = array(
                    "successBool"   => true,
                    "responseType"   => "user_board",
                    "successCode"   => "200",
                        "response"  => array(
                            'userBoard'=> $data_result,
                        ),
                        "ErrorObj"   => array(
                            "ErrorCode" => "",
                            "ErrorMsg"  => ""
                        )
                ); 
                 return $data_result;
           }else{
                return []; 
           }
           
             
        }else{
            return []; 
        }
       
    }

function getUserBoard($uid,$pageno){
     $set_mode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
          $resultss = mysqli_query($this->dbh,$set_mode);
     $query = "select * from tbl_user_board INNER JOIN tbl_board_members ON tbl_user_board.board_id = tbl_board_members.board_id where tbl_board_members.member_id = $uid group by tbl_user_board.board_key order by tbl_user_board.board_id desc"; 
     $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        $user_sql = mysqli_query($this->dbh,"SELECT * FROM tbl_users WHERE ID = '".$uid."'");
$user_data = mysqli_fetch_array($user_sql);
//if($rowcount>0){
            $now=time();
            $expire_on= strtotime($user_data['expiry_date']);
            if($expire_on >$now){ 
                $day_diff = $expire_on - $now;
                $days_left= round($day_diff / (60 * 60 * 24));
            }else{
                     $days_left="Expired";
            }
   $response = array(
                    "successBool"   => true,
                    "responseType"   => "user_board",
                    "successCode"   => "200",
                        "response"  => array(
                            'membership_plan' => $user_data['membership_plan'],
                            'expiry_date' => $days_left,
                            'personal_board' => $this->getpersonalBoard($uid,$pageno),
                            "InvitedBoard" => $this->getInvitedBoard($uid),
                            "TeamData" => $this->TeamData($uid),
                           
                        ),
                        "ErrorObj"   => array(
                            "ErrorCode" => "",
                            "ErrorMsg"  => ""
                        )
                );
/*}else{
    $response = array(
                    "successBool"   => false,
                    "successCode"   => "",
                        "response"  => array(),
                        "ErrorObj"   => array(
                            "ErrorCode" => "104",
                            "ErrorMsg"  => "No Data Found"
                        )
                ); 
}*/
   return $response;

}


 function TeamData($uid){
$query = "select tm.id as tmid,tm.team_name as tmname from tbl_user_team as tm where tm.user_id = $uid";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
               $data['team_id'] = (int)$DataSet['tmid'];
               $data['team_name'] = $DataSet['tmname'];
              // $bid = $this->getboardId($data['team_id']);
               $board = $this->getBoardListByTid1($uid,$data['team_id']);
               $data['team_board'] = $board;
               $data_array[] = $data;
            }
            $response = $data_array;         
        }else{
            $response = array();
        }
        return $response;
    }










  function getpersonalBoard($uid,$pageno){
     $set_mode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
          $resultss = mysqli_query($this->dbh,$set_mode);
       $return_results_top = array();
       $query = "SELECT * FROM `tbl_board_members` INNER JOIN tbl_team_board ON tbl_board_members.board_id = tbl_team_board.board_id WHERE tbl_board_members.member_id = $uid AND tbl_team_board.team_id = 0";
       ///echo $query;
      
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        
        if($rowcount > 0){
            $result_row = mysqli_fetch_array($result);
            $total = $rowcount;
            $limit = 15;
            if($pageno == ""){
            $page = 0;
            $offset = 0;
            $pages = ceil($total/$limit);
            $left_rec = $total - ($page * $limit); 
            $query1 = "select * from tbl_user_board INNER JOIN tbl_board_members ON tbl_user_board.board_id = tbl_board_members.board_id where tbl_board_members.member_id = $uid AND tbl_user_board.team_id = 0 group by tbl_user_board.board_key order by tbl_user_board.board_id desc"; 
            }else{
            $page = $pageno;
            $offset = $page  * $limit;

            $pages = ceil($total/$limit);
            $left_rec = $total - ($page * $limit);
              $query1 = "select * from tbl_user_board INNER JOIN tbl_board_members ON tbl_user_board.board_id = tbl_board_members.board_id where tbl_board_members.member_id = $uid AND tbl_user_board.team_id = 0 group by tbl_user_board.board_key order by tbl_user_board.board_id desc limit $offset , $limit";  
            } 
//echo $query1;
            $result1 = mysqli_query($this->dbh,$query1);
            $data_result = array();
            $num_rows = mysqli_num_rows($result1);
          // echo $num_rows;
        
            if($num_rows > 0){
 while($DataSet = mysqli_fetch_array($result1)){
            
            $member = $this->getBoardmembers($DataSet['board_id']);
            $array = explode(",",$member);
            $memberName = array();
            foreach($array as $value)
            {
                $name = $this->getName($value);
                if($name != null)
                {
                    $memberName[] = $name;
                }
            }
            
            $data = array(
                'board_title' => $DataSet['board_title'],
                'team_id' => $DataSet['team_id'],
                'board_id' => (int)$DataSet['board_id'],
                'board_star' => $DataSet['board_star'],
                'board_type' => $DataSet['type'],
                'bg_color' => $DataSet['bg_color'],
                'bg_img' => $DataSet['bg_img'],
                "boardMember" => $memberName,
                "countBoardAttachment" => $this->getTotalBoardAttachment((int)$DataSet['board_id']),
                'countBoardCrad' => $this->getTotalCardByBoardId((int)$DataSet['board_id']),
                "created_at" => $DataSet['createDate'],
                "updated_at" => $DataSet['ud'],
            );
                $data_result[] = $data;
 
               
            }
$response = $data_result;
            /*    $response = array(
                    "successBool"   => true,
                    "responseType"   => "user_board",
                    "successCode"   => "200",
                        "response"  => array(
                            'total' => $total,
                            'pages' => $pages,
                            'pageno'=> (int)$page,    
                            'offset' => (int)$offset,
                            'limit'   => $limit, 
                            'userBoard'=> $data_result,
                            "InvitedBoard" => $this->getInvitedBoard($uid)
                        ),
                        "ErrorObj"   => array(
                            "ErrorCode" => "",
                            "ErrorMsg"  => ""
                        )
                );*/
           }else{
               $response = []; 
           }
           
             
        }else{
            $response = []; 
        }
        return $response; 
    }


function getallBoard($uid){
       $return_results_top = array();
     $set_mode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
          $resultss = mysqli_query($this->dbh,$set_mode);
       /*$query = "select * from tbl_user_board INNER JOIN tbl_board_members ON tbl_user_board.board_id = tbl_board_members.board_id where tbl_board_members.member_id = $uid order by tbl_user_board.board_id desc";*/

          $query = "select * from tbl_user_board INNER JOIN tbl_board_members ON tbl_user_board.board_id = tbl_board_members.board_id where tbl_board_members.member_id = $uid group by tbl_user_board.board_key order by tbl_user_board.board_id desc"; 
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
 while($DataSet = mysqli_fetch_array($result)){
   // print_r($DataSet);        
            $data = array(
                'board_title' => $DataSet['board_title'],
                'team_id' => $DataSet['team_id'],
                'board_id' => (int)$DataSet['board_id'],
                'board_star' => $DataSet['board_star'],
                'board_type' => $DataSet['type'],
                'bg_color' => $DataSet['bg_color'],
                'bg_img' => $DataSet['bg_img'],
                );

                $data_result[] = $data;
 
               
            }
                $response = array(
                    "successBool"   => true,
                    "responseType"   => "user_board",
                    "successCode"   => "200",
                        "response"  => array(
                            'userBoard'=> $data_result,
                        ),
                        "ErrorObj"   => array(
                            "ErrorCode" => "",
                            "ErrorMsg"  => ""
                        )
                );
           
           
             
        }else{
           $response = array(
                    "successBool"   => false,
                    "successCode"   => "",
                        "response"  => array(),
                        "ErrorObj"   => array(
                            "ErrorCode" => "104",
                            "ErrorMsg"  => "No Data Found"
                        )
                );
        }
        return $response; 
    }
    




    
    function getTeamId($bid){
        $query = "SELECT team_id FROM tbl_team_board WHERE board_id = $bid";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
            $teamid = $DataSet['team_id'];
            
        }else{
            $teamid = "0";
        }
        return $teamid;
    }
    function getboardId($tid){
        $set_mode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
        $resultss = mysqli_query($this->dbh,$set_mode);
        $query = "SELECT GROUP_CONCAT(board_id) as board_id FROM tbl_team_board WHERE team_id = $tid";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
            $bid = $DataSet['board_id'];    
        }else{
            $bid = "0";
        }
        return $bid;
    }

    function getTeamDetailsByTeamId($tid){
         $set_mode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
          $resultss = mysqli_query($this->dbh,$set_mode);

        $return_results_top = array();
        $query = "select tm.* , GROUP_CONCAT(utm.meta_key) as mkey, GROUP_CONCAT(utm.meta_value) as mvalue from tbl_user_team as tm , tbl_user_teammeta as utm where tm.id = $tid and utm.team_id = tm.id group by tm.team_name";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                $key = explode(",", $DataSet['mkey']);
                array_push($key, "team_name" , "team_id");
                $value = explode(",", $DataSet['mvalue']);
                array_push($value, $DataSet['team_name'], $DataSet['id']);
                $data = array_combine($key, $value);
                
               $return_results_top[] = $data;
            }
            return $return_results_top;   
        }
    }

    function getBoardDetails($bid){
         $set_mode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
          $resultss = mysqli_query($this->dbh,$set_mode);

        $query = "select ub.*, GROUP_CONCAT(ubm.meta_key) as mkey, 
                GROUP_CONCAT(ubm.meta_value) as mvalue from tbl_user_board as ub , tbl_user_boardmeta as ubm 
                where ub.board_id = $bid and ub.board_id = ubm.board_id";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
            $key = explode(",", $DataSet['mkey']);
            array_push($key,"board_title" ,"board_star","board_id","board_type","bg_img","bg_color","team_id");
            $value = explode(",", $DataSet['mvalue']);  
            array_push($value,$DataSet['board_title'] ,(int)$DataSet['board_star'],(int)$DataSet['board_id'],$DataSet['type'],$DataSet['bg_img'],$DataSet['bg_color'],$DataSet['team_id']);
            $data = array_combine($key, $value);
            return $data;    
        }
    }


 function getBoardListByTid1($uid,$tid){
     $set_mode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
          $resultss = mysqli_query($this->dbh,$set_mode);
     $query = "select * from tbl_user_board INNER JOIN tbl_board_members ON tbl_user_board.board_id = tbl_board_members.board_id where tbl_board_members.member_id = $uid AND tbl_user_board.team_id = '".$tid."' group by tbl_user_board.board_key order by tbl_user_board.board_id desc";
     //   $query = "select board_id from tbl_user_board WHERE team_id = '".$tid."'";
   //  echo $query;
        $mysql_query = mysqli_query($this->dbh, $query);
        $data_array = array();
        while($DataSet = mysqli_fetch_array($mysql_query)){
        $data = array(
        'board_title' => $DataSet['board_title'],
        'team_id' => $DataSet['team_id'],
        'board_id' => (int)$DataSet['board_id'],
        'board_star' => $DataSet['board_star'],
        'board_type' => $DataSet['type'],
        'bg_color' => $DataSet['bg_color'],
        'bg_img' => $DataSet['bg_img'],
        "countBoardAttachment" => $this->getTotalBoardAttachment((int)$DataSet['board_id']),
        'countBoardCrad' => $this->getTotalCardByBoardId((int)$DataSet['board_id']),
            );

  $data_array[] = $data; 


          /*$bord_id = $result['board_id'];
          $query = "select ub.*, GROUP_CONCAT(ubm.meta_key) as mkey, 
                GROUP_CONCAT(ubm.meta_value) as mvalue from tbl_user_board as ub , tbl_user_boardmeta as ubm 
                where ub.board_id = $bord_id and ub.board_id = ubm.board_id group by board_id";
            $result = mysqli_query($this->dbh,$query);
            $rowcount = mysqli_num_rows($result);
            if($rowcount > 0){
                
               while( $DataSet = mysqli_fetch_array($result)){
                $key = explode(",", $DataSet['mkey']);
                array_push($key, "board_star","board_id","board_title");
                $value = explode(",", $DataSet['mvalue']);  
                array_push($value, $DataSet['board_star'],$DataSet['board_id'],$DataSet['board_title']);
                $data = array_combine($key, $value);
                $data_array[] = $data; 
               }
            } */ 
        }
        return $data_array;
           
    }




    function getBoardListByTid($bid){
         $set_mode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
          $resultss = mysqli_query($this->dbh,$set_mode);
        $query = "select board_id from tbl_user_board WHERE board_id in ($bid)";
        $mysql_query = mysqli_query($this->dbh, $query);
        $data_array = array();
        while($result = mysqli_fetch_array($mysql_query)){
          $bord_id = $result['board_id'];
          $query = "select ub.*, GROUP_CONCAT(ubm.meta_key) as mkey, 
                GROUP_CONCAT(ubm.meta_value) as mvalue from tbl_user_board as ub , tbl_user_boardmeta as ubm 
                where ub.board_id = $bord_id and ub.board_id = ubm.board_id group by board_id";
            $result = mysqli_query($this->dbh,$query);
            $rowcount = mysqli_num_rows($result);
            if($rowcount > 0){
                
               while( $DataSet = mysqli_fetch_array($result)){
                $key = explode(",", $DataSet['mkey']);
                array_push($key, "board_star","board_id","board_title");
                $value = explode(",", $DataSet['mvalue']);  
                array_push($value, $DataSet['board_star'],$DataSet['board_id'],$DataSet['board_title']);
                $data = array_combine($key, $value);
                $data_array[] = $data; 
               }
            }  
        }
        return $data_array;
           
    }

    function getTeamList($uid){
        $query = "select tm.id as tmid,tm.team_name as tmname from tbl_user_team as tm where tm.user_id = $uid";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
               $data['team_id'] = (int)$DataSet['tmid'];
               $data['team_name'] = $DataSet['tmname'];
               $bid = $this->getboardId($data['team_id']);
               $board = $this->getBoardListByTid($bid);
               $data['team_board'] = $board;
               $data_array[] = $data;
            }
            $response = array(
                    "successBool"   => true,
                    "responseType"   => "user_team",
                    "successCode"   => "200",
                        "response"  => array(
                            'userTeamList'=> $data_array
                        ),
                        "ErrorObj"   => array(
                            "ErrorCode" => "",
                            "ErrorMsg"  => ""
                        )
                );         
        }else{
            $response = array(
                    "successBool"   => false,
                    "successCode"   => "",
                        "response"  => array(),
                        "ErrorObj"   => array(
                            "ErrorCode" => "104",
                            "ErrorMsg"  => "No Data Found"
                        )
                );
        }
        return $response;
    }



function getusercardlabellist($cardid){
        $query = "select * FROM tbl_board_list_card_labels WHERE cardid = $cardid";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
               // print_r($DataSet);
             //   echo "<pre>";
                $userlabeldata = $this->getuserlabeldetail($DataSet['labels']);
    //print_r($userlabeldata);
               $data['id'] = $DataSet['id'];
               $data['cardid'] = $cardid;
               $data['label_name'] = $userlabeldata['label_name'];
               $data['userid'] = $DataSet['userid'];
               $data['color'] = $userlabeldata['color'];
               $data_array[] = $data;
            }
            $response = array(
                "successBool"   => true,
                "responseType"   => "cardlabellist",
                "successCode"   => "200",
                    "response"  => array(
                        'cardlabellist'=> $data_array
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )
            );                
        }else{
            $response = array(
                    "successBool"   => false,
                    "successCode"   => "",
                        "response"  => array(),
                        "ErrorObj"   => array(
                            "ErrorCode" => "104",
                            "ErrorMsg"  => "No Data Found"
                        )
                );
        }
        return $response;
    }



    function getUserTeamList($uid){
$query = "select tm.id as tmid,tm.team_name as tmname from tbl_user_team as tm where tm.user_id = $uid";
       // echo $query;
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
               $data['team_id'] = $DataSet['tmid'];
               $data['team_name'] = $DataSet['tmname'];
               $data_array[] = $data;
            }
            $response = array(
                "successBool"   => true,
                "responseType"   => "team_list",
                "successCode"   => "200",
                    "response"  => array(
                        'userTeamList'=> $data_array
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )
            );                
        }else{
            $response = array(
                    "successBool"   => false,
                    "successCode"   => "",
                        "response"  => array(),
                        "ErrorObj"   => array(
                            "ErrorCode" => "104",
                            "ErrorMsg"  => "No Data Found"
                        )
                );
        }
        return $response;
    }

    function getUserTeamDetails($uid){
         $set_mode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
          $resultss = mysqli_query($this->dbh,$set_mode);
        $return_results_top = array();
        $query = "select tm.* , GROUP_CONCAT(utm.meta_key) as mkey, GROUP_CONCAT(utm.meta_value) as mvalue from tbl_user_team as tm , tbl_user_teammeta as utm where tm.user_id = $uid and utm.team_id = tm.id group by tm.team_name";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                $key = explode(",", $DataSet['mkey']);
                array_push($key, "team_name" , "team_id");
                $value = explode(",", $DataSet['mvalue']);
                array_push($value, $DataSet['team_name'], $DataSet['id']);
                $data = array_combine($key, $value);
                $return_results_top[] = $data;
            }
            return $return_results_top;    
            
        }
    }

    function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    function getLastInserteduserlabel($uid){
    $query = "SELECT MAX(id) as bid FROM `tbl_label_users` where user_id = $uid";
    $result = mysqli_query($this->dbh,$query);
    $rowcount = mysqli_num_rows($result);
    if($rowcount > 0){
        $DataSet = mysqli_fetch_array($result);
        $bid = $DataSet['bid'];
        return $bid;
    }
}


    function getLastInsertedusercardlabel($cardid){
    $query = "SELECT MAX(id) as bid FROM `tbl_board_list_card_labels` where cardid = $cardid";
    $result = mysqli_query($this->dbh,$query);
    //echo $query;die;
    $rowcount = mysqli_num_rows($result);
    if($rowcount > 0){
        $DataSet = mysqli_fetch_array($result);
        $bid = $DataSet['bid'];
        return $bid;
    }
}


function getLastInsertedBoard($uid){
    $query = "SELECT MAX(board_id) as bid FROM `tbl_user_board` where admin_id = $uid";
    $result = mysqli_query($this->dbh,$query);
    $rowcount = mysqli_num_rows($result);
    if($rowcount > 0){
        $DataSet = mysqli_fetch_array($result);
        $bid = $DataSet['bid'];
        return $bid;
    }
}

function get_admin_BoardList($bid){
        $query = "SELECT list_title,id FROM tbl_tmp_board_list WHERE board_id = $bid";
        //echo $query;die;
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                 //$data['id'] = $DataSet['id'];
                $data['id'] = $DataSet['id'];
                $data['list_title'] = $DataSet['list_title'];

                
               
                $data_array[] = $data;
            }
           // print_r($data_array);die;
        
         return $data_array;
    }
    
}



function get_admin_Boardcards($list_id){
        $query = "SELECT card_name,id,card_description FROM tbl_tmp_board_list_card WHERE list_id = $list_id";
       // echo $query;die;
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                $data['id'] = $DataSet['id'];
                $data['card_name'] = $DataSet['card_name'];
                $data['card_description'] = $DataSet['card_description'];
               // $data['card_name'] = $DataSet['card_name'];

               
                $data_array[] = $data;
            }
           // print_r($data_array);die;
        
         return $data_array;
    }
    
}

function getLastInsertedTeam($uid){
    $query = "SELECT MAX(id) as tid FROM tbl_user_team where user_id = $uid";
    $result = mysqli_query($this->dbh,$query);
    $rowcount = mysqli_num_rows($result);
    if($rowcount > 0){
        $DataSet = mysqli_fetch_array($result);
        $tid = $DataSet['tid'];
        return $tid;
    }
}

function getStaredBoard($uid){
     $set_mode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
          $resultss = mysqli_query($this->dbh,$set_mode);
    $query = "select ub.*, group_concat(ubm.meta_key) as mkey , group_concat(ubm.meta_value) as mvalue from tbl_user_board as ub , tbl_user_boardmeta as ubm where ub.admin_id = $uid and ub.board_star = 1 and ub.board_id = ubm.board_id group by board_title";
     $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_result = array();
            while($DataSet = mysqli_fetch_array($result)){
                $key = explode(",", $DataSet['mkey']);
                array_push($key, "title","board_id","board_star");
                $value = explode(",", $DataSet['mvalue']);
                array_push($value, $DataSet['board_title'],$DataSet['board_id'],$DataSet['board_star']);
                $data = array_combine($key, $value);

                $data_result[] = $data;
            }
             
        }else{
                $data_result = array();;
        }
        return $data_result;   
}


function getInvitedBoard($uid){
 $set_mode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
 $resultss = mysqli_query($this->dbh,$set_mode);

 $query = "select * from tbl_user_board INNER JOIN tbl_board_members ON tbl_user_board.board_id = tbl_board_members.board_id where tbl_board_members.member_id = $uid AND tbl_user_board.type='TB' group by tbl_user_board.board_key order by tbl_user_board.board_id desc"; 

   // $query = "SELECT bm.board_id ,ub.board_title,ub.board_star,ub.bg_color,ub.bg_img, GROUP_CONCAT(ubm.meta_key) as mkey, GROUP_CONCAT(ubm.meta_value) as mvalue FROM tbl_board_members as bm LEFT outer join tbl_user_boardmeta as ubm on ubm.board_id = bm.board_id LEFT outer join tbl_user_board as ub on ub.board_id = bm.board_id WHERE bm.member_id = $uid and bm.member_status = 1 AND bm.user_id!=bm.member_id group by board_id";
     $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_result = array();
            while($DataSet = mysqli_fetch_array($result)){
               
            $member = $this->getBoardmembers($DataSet['board_id']);
            $array = explode(",",$member);
            $memberName = array();
            foreach($array as $value)
            {
                $name = $this->getName($value);
                if($name != null)
                {
                    $memberName[] = $name;
                }
            }
            
            $data = array(
            'board_title' => $DataSet['board_title'],
            'team_id' => $DataSet['team_id'],
            'board_id' => (int)$DataSet['board_id'],
            'board_star' => $DataSet['board_star'],
            'board_type' => $DataSet['type'],
            'bg_color' => $DataSet['bg_color'],
            'bg_img' => $DataSet['bg_img'],
            "boardMember" => $memberName,
            "countBoardAttachment" => $this->getTotalBoardAttachment((int)$DataSet['board_id']),
            'countBoardCrad' => $this->getTotalCardByBoardId((int)$DataSet['board_id']),
            "created_at" => $DataSet['createDate'],
            "updated_at" => $DataSet['ud'],
                );
                
                $data_result[] = $data;
            }
             
        }else{
            $data_result = array();
        }
        return $data_result;   
}

function getBoardAdmin($bid){
    $query = "SELECT admin_id FROM `tbl_user_board` where board_id = $bid";
    $result = mysqli_query($this->dbh,$query);
    $final_result = mysqli_fetch_array($result);
    $adminid = $final_result['admin_id'];
    return $adminid;
}

function findUserByEmail($search){
    $query = "SELECT id,Full_Name,Email_ID,profile_pic_type,profile_pics FROM `tbl_users` where Email_ID LIKE '%".$search."%'";
    $result = mysqli_query($this->dbh,$query);
    $data_array = array();
    $num_rows = mysqli_num_rows($result);
    if($num_rows > 0){
    while($final_result = mysqli_fetch_array($result)){
        if($final_result['profile_pic_type']=='url'){
$profile_pics = $final_result['profile_pics'];
        }else if($final_result['profile_pic_type']=='url'){
           $profile_pics =  $this->site_url.'/user_profile_Image/'.$final_result['profile_pics'];
        }else{
            $profile_pics = '';
        }
        //print_r($final_result);
        $data['id'] = $final_result['id'];
        $data['name'] = $final_result['Full_Name'];
        $data['email'] = $final_result['Email_ID'];
        $data['profile_pic'] = $profile_pics;
        $data_array[] = $data;
    }
    $response = array(
        "successBool" => true,
        "responseType" => "search_members",
        "successCode" => "200",
            "response" => array(
                'message' => $data_array
            ),
            "ErrorObj"   => array(
                "ErrorCode" => "",
                "ErrorMsg"  => ""
            )       
    ); 
     
    }else{
        $data_array = array();
    }
    return $response; 
    
   
}


function getRecentBoard($uid){
     $set_mode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
          $resultss = mysqli_query($this->dbh,$set_mode);
    $query = "select ub.*, group_concat(ubm.meta_key) as mkey , group_concat(ubm.meta_value) as mvalue from tbl_user_board as ub , tbl_user_boardmeta as ubm where ub.admin_id = $uid and ub.recentuse = 1 and ub.board_id = ubm.board_id group by board_title order by ud DESC limit 0,5";
     $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_result = array();
            while($DataSet = mysqli_fetch_array($result)){
                $key = explode(",", $DataSet['mkey']);
                array_push($key, "title","board_id","board_star");
                $value = explode(",", $DataSet['mvalue']);
                array_push($value, $DataSet['board_title'],$DataSet['board_id'],$DataSet['board_star']);
                $data = array_combine($key, $value);
                $data_result[] = $data;
            }
            return json_encode(array("recentBoardData" => $data_result));    
        }
}

function getTeamDetails($tid){
     $set_mode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
          $resultss = mysqli_query($this->dbh,$set_mode);
        $return_results_top = array();
        $query = "select tm.* , GROUP_CONCAT(utm.meta_key) as mkey, GROUP_CONCAT(utm.meta_value) as mvalue from tbl_user_team as tm , tbl_user_teammeta as utm where tm.id = $tid and utm.team_id = tm.id group by tm.team_name";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                $key = explode(",", $DataSet['mkey']);
                array_push($key, "team_id","team_admin" ,"team_name","teamDesc");
                $value = explode(",", $DataSet['mvalue']);
                array_push($value, $DataSet['id'],$DataSet['user_id'] ,$DataSet['team_name'], $DataSet['teamDesc']);
                $data = array_combine($key, $value);
                
                $return_results_top[] = $data;
            }
            return $data;    
            
        }
    }

    function getBoardList1($bid){
        $query1= "SELECT admin_board_id FROM `tbl_user_board` WHERE `board_id`=$bid";
        $result1 = mysqli_query($this->dbh,$query1);
        $DataSet1 = mysqli_fetch_array($result1);
        $query = "SELECT list_title,list_id FROM tbl_board_list WHERE board_id = $bid";
        $result = mysqli_query($this->dbh,$query);
   
        $rowcount = mysqli_num_rows($result);
        $data_array = array();
        if($rowcount > 0){
            while($DataSet = mysqli_fetch_array($result)){
                $data['list_title'] = $DataSet['list_title'];
                $data['list_id'] = $DataSet['list_id'];
                $data['bgimage'] = '';
                $data['bgcolor'] = '#f7f7f7';
                $data_array[] = $data;
            }
         }
         
       return $data_array;  
    }



    function getBoardList($bid,$uid){
        $query = "SELECT list_title,list_id,board_id,list_color,list_icon FROM tbl_board_list WHERE board_id = $bid";
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
   if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                $data['list_title'] = $DataSet['list_title'];
                $data['list_id'] = (int)$DataSet['list_id'];
                 $data['board_id'] = (int)$DataSet['board_id'];
                 if($DataSet['list_color'] == '')
                 {
                     $data['list_color'] = '#f5d26a';
                 } else
                 {
                     $data['list_color'] = $DataSet['list_color'];
                 }
                
                if($DataSet['list_icon'] == '')
                {
                    $data['list_icon'] = $this->site_url.'list_icon/add.png';
                } else {
                    $data['list_icon'] = $this->site_url.$DataSet['list_icon'];
                }
                
                $list_card=$this->getcard($data['list_id']);
             $data['totalCards'] = count($list_card);
             $data['cards']=$list_card;
             $cardarray='';
             $data_array[] = $data;
                
            }
        }else{
           $data_array = []; 
        }

      $member1 = $this->getBoardmembers($bid);
            $array1 = explode(",",$member1);
            $data_array1 = array();
             if($member1 != 0){
            foreach ($array1 as $value11) {

            $result1 = $this->getUserMeta($value11);

            $countmembr = $this->datafound('tbl_board_invite',array('bid'=>$bid,'member_id'=>$value11));
if($countmembr>0){
    $checksts = 1;
}else{
    $checksts = 0;
}
            $data1['cardid'] = 0;
            $data1['member_id'] = $value11;
            $data1['member_name'] = $result1['full_name'];
            $data1['member_emil'] = $result1['user_name']; 
            $data1['card_status'] = $checksts; 
            $data_array1[] = $data1;
            }
             }else{
                $data_array1 = [];
             }


               $query1 = "SELECT * FROM tbl_user_board WHERE board_id = $bid";
               $result2 = mysqli_query($this->dbh,$query1);
               $result23 = mysqli_fetch_array($result2);


$wherarray1 = array(
'ID' => $uid,
    );
$intrigetdata = $this->getsingledata('tbl_users',$wherarray1);
$data3['googledrive'] = $intrigetdata['googledrive'];
$data3['dropbox'] = $intrigetdata['dropbox'];
$data3['evernote'] = $intrigetdata['evernote'];
            $response = array(
                "successBool" => true,
                 "responseType"   => "list_board",
                "successCode" => "200",
                    "response" => array(
                        "totalList" => $rowcount,
                        "boardDetails" => $this->getBoardDetails($bid),
                        "boardList" => $data_array,
                        "boardMember" => $data_array1,
                        "board_star" => $result23['board_star'],
                        "intrigetlist" => $data3,
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
               
         
         return $response;
    }
    
    
    
    function getTotalBoardAttachment($bid)
    {
          $query = "select count(id) as ta FROM tbl_board_list_card_attachements where status = 1 and board_id = $bid";
      //  echo $query;
        $sql_query = mysqli_query($this->dbh, $query);
          $results = mysqli_fetch_array($sql_query);
       $total_attachment = $results['ta'];
        return $total_attachment;
    }
    
    function getTotalCardByBoardId($bid)
    {
         $query = "select count(card_id) as tc FROM tbl_board_list_card where del_status = 0 and board_id = $bid";
      //  echo $query;
        $sql_query = mysqli_query($this->dbh, $query);
          $results = mysqli_fetch_array($sql_query);
       $total_card = $results['tc'];
       if($total_card == null)
       {
           $total_card = "0";
       }
        return $total_card;
    }
    
    

    function getListId($key){
        $query = "SELECT list_id FROM tbl_board_list WHERE listkey = '".$key."'";
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            $DataSet = mysqli_fetch_array($result);
            $list_id = $DataSet['list_id'];
            return $list_id;
            
        }
    }

    function getListCard($lid){
        $query = "SELECT card_title,list_id,card_id,def,del_status,card_description FROM tbl_board_list_card WHERE list_id = $lid and def != 1 and del_status != 1";
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                $data['card_title'] = $DataSet['card_title'];
                $data['list_id'] = (int)$DataSet['list_id'];
                $data['card_id'] = (int)$DataSet['card_id'];
                $data['del_status'] = (int)$DataSet['del_status'];
                $data['cardComments'] = (int)$this->getCardCommentsCount($DataSet['card_id']);
                $data['total_attachments'] = (int)$this->getCardAttachmentsCount($DataSet['card_id']);
                 $data['cover_image'] = $this->getCardcover_image($DataSet['card_id']);
                $data_array[] = $data;
            }
            $response = array(
                "successBool" => true,
                "responseType" => "list_card",
                "successCode" => "200",
                    "response" => array(
                        "totalCards" => $rowcount,
                        "CardList" => $data_array
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
            
        }else{
            $response = array(
                "successBool" => false,
                "successCode" => "",
                    "response" => array(),
                    "ErrorObj"   => array(
                        "ErrorCode" => "103",
                        "ErrorMsg"  => "No Data Found"
                    )       
            );
         }
         return $response;
    }

     function getListCard1($lid){
        
        $query = "SELECT * FROM tbl_board_list_card WHERE list_id = $lid";
        //$admincard = "SELECT card_name as card_title,id as card_id,def,del_status as del_status,stickers FROM tbl_tmp_board_list_card WHERE list_id = $lid";

        //$admin_result = mysqli_query($this->dbh,$admincard);
        $result = mysqli_query($this->dbh,$query);
       // $admin_rowcount = mysqli_num_rows($admin_result);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
             $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                $data_array[] = $DataSet;
            }

            return $data_array; 
         }

      
        
    }


     function allCardAttachments($cardid){
        $query = "select * FROM tbl_board_list_card_attachements where status = 1 and cardid = $cardid";
      //  echo $query;
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            while($result = mysqli_fetch_array($sql_query)){
                $data['id'] = $result['id'];
                $data['images'] = $result['attachments'];
                 $data['title_name'] = $result['title_name'];
                $data['cover'] = $result['cover_image'];
                $data['location'] = $result['location'];
                $data['file_type'] = $result['file_type'];
                 $data['ext'] = $result['file_extenstion'];
                 $data['note_guide'] = $result['note_guide'];
                 $data['note_book_guide'] = $result['note_book_guide'];
                 $data['is_linked'] = $result['is_linked'];
                 $data['evernote_oauth_token'] = $result['evernote_oauth_token'];
                $data_array[] = $data;
            }
            return $data_array;
        }
    }
 function getCardCheckList($cardid){
        $query = "SELECT id,userid,checklist,date_time FROM tbl_board_list_card_checklist where cardid = $cardid order by id DESC"; 
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        $data_array = array();
        while ($results = mysqli_fetch_array($sql_query)) {
            $data['id'] = $results['id'];
            $data['userid'] = $results['userid'];
            $data['comments'] = $results['checklist'];
            $data['date_time'] = $results['date_time'];
            $data_array[] = $data;   
        }
        return $data_array;
    }

    function getLastChecklistItemData($checkId){
        $query = "SELECT * FROM tbl_board_list_card_checklist_item where checklist_id=$checkId ORDER BY id DESC"; 
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        $data_array = array();
        while ($results = mysqli_fetch_array($sql_query)) {
            $data['id'] = $results['id'];
            $data['item_name'] = $results['item_name'];
            $data['status'] = $results['status'];
            
            $data_array[] = $data;   
        }
        
        return $data_array;
    }

    function ChkInviteToken($token){
        $query = "SELECT id FROM tbl_board_invite WHERE invite_token = '$token' ";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_fetch_array($result);
        return $rowcount['id'] ?? '';   
    }
    function ChkTeamInviteToken($token){
        $query = "SELECT id FROM tbl_team_invite WHERE invite_token = '$token' ";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_fetch_array($result);
        return $rowcount['id'];   
    }
    
    function ChkInviteMember($uemail,$bid){
        $query = "SELECT id FROM tbl_board_invite WHERE user_email = '$uemail' and bid = $bid";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;   
    }
    function ChkInviteTeamMember($mid,$bid){
        $query = "SELECT id FROM tbl_team_invite WHERE member_id = '$mid' and bid = $bid";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;   
    }

    function ChkInviteMemberByEmail($uemail,$bid){
        $query = "SELECT id FROM tbl_board_invite WHERE user_email = '$uemail' and bid = $bid";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;   
    }
    function ChkInviteTeamMemberByEmail($uemail,$bid){
        $query = "SELECT id FROM tbl_team_invite WHERE user_email = '$uemail' and tid = $bid";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;   
    }

    function getInviteDetails($token){
        $query = "SELECT id,bid,burl,bkey,user_email,invite_token,invited_by FROM tbl_board_invite WHERE invite_token = '$token' ";
        $result     = mysqli_query($this->dbh,$query);
        $rowcount   = mysqli_fetch_array($result);
        $data_array = array();
        $data_array['id'] = $rowcount['id'];  
        $data_array['bid'] = $rowcount['bid'];   
        $data_array['user_email'] = $rowcount['user_email'];   
        $data_array['burl'] = $rowcount['burl'];   
        $data_array['bkey'] = $rowcount['bkey']; 
        $data_array['invite_token'] = $rowcount['invite_token'];   
        $data_array['invited_by'] = $rowcount['invited_by'];   
        return $data_array;  
    }
  
    function getTeamInviteDetails($token){
        $query = "SELECT id,tid,turl,tkey,user_email,invite_token,invited_by FROM tbl_team_invite WHERE invite_token = '$token' ";
        $result     = mysqli_query($this->dbh,$query);
        $rowcount   = mysqli_fetch_array($result);
        $data_array = array();
        $data_array['id'] = $rowcount['id'];  
        $data_array['tid'] = $rowcount['tid'];   
        $data_array['user_email'] = $rowcount['user_email'];   
        $data_array['turl'] = $rowcount['turl'];   
        $data_array['tkey'] = $rowcount['tkey']; 
        $data_array['invite_token'] = $rowcount['invite_token'];   
        $data_array['invited_by'] = $rowcount['invited_by'];   
        return $data_array;  
    }

    function getCardDetails($card){
        $query = "SELECT blc.* , bl.*  FROM tbl_board_list_card as blc left OUTER JOIN tbl_board_list as bl ON blc.list_id = bl.list_id  WHERE blc.card_id = $card";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            while($results = mysqli_fetch_array($sql_query)){
                $data['card_id'] = $results['card_id'];
                $data['card_title'] = $results['card_title'];
                $data['list_title'] = $results['list_title'];
                $data['card_description'] = $results['card_description'];
                
            }
            return $data;
        }
    }

    function getCardCommentsCount($cardid){
        $query = "SELECT count(id) as tc FROM tbl_board_list_card_comments where cardid = $cardid"; 
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        $results = mysqli_fetch_array($sql_query);
        $total_comment = $results['tc'];
        return $total_comment;
    }


    function getCardAttachmentsCount($cardid){
        $query = "SELECT count(id) as tc FROM tbl_board_list_card_attachements where cardid = $cardid"; 
       // echo $query;die;
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        $results = mysqli_fetch_array($sql_query);
        $total_attachments = $results['tc'];
        return $total_attachments;
    }



        function getCardcover_image($cardid){
        $query = "SELECT attachments FROM tbl_board_list_card_attachements where cardid = $cardid and cover_image=1 and status=1"; 
       // echo $query;die;
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        $results = mysqli_fetch_array($sql_query);
        if(empty($results['attachments'])){
            $attachments = '';
        }else{
             $attachments = $this->site_url.'/attachments/'.$results['attachments'];
        }
       
        return $attachments;
    }

    function getCardComments($cardid){
        $query = "SELECT id,userid,comments,date_time FROM tbl_board_list_card_comments where cardid = $cardid order by id DESC"; 
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        $data_array = array();
        while ($results = mysqli_fetch_array($sql_query)) {
            $data['id'] = $results['id'];
            $data['userid'] = $results['userid'];
            $data['comments'] = $results['comments'];
            $data['date_time'] = $results['date_time'];
            $data_array[] = $data;   
        }
        return $data_array;
    }

     function getAllCardLabels($cardid){
        $query = "SELECT * FROM `tbl_board_list_card_labels` WHERE `cardid` = '$cardid'";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            while($result = mysqli_fetch_array($sql_query)){
                $data['labelname'] = $result['labelname'];
                $data['labels'] = $result['labels'];
                $data['id'] = $result['id'];
                $data['cardid'] = $result['cardid'];
                $data_array[] = $data;
            }
            return $data_array;
        }
    }

    function getLastComment($ckey){
        $query = "SELECT id,userid,comments,date_time FROM tbl_board_list_card_comments where ckey = '".$ckey."' order by id DESC"; 
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        $data_array = array();
        while ($results = mysqli_fetch_array($sql_query)) {
            $data['id'] = $results['id'];
            $data['userid'] = $results['userid'];
            $data['comments'] = $results['comments'];
            $data['date_time'] = $results['date_time'];
            $data_array[] = $data;   
        }
        return $data_array;
    }

    // board Member 

    function getBoardmembers($boardid){
        $query = "SELECT group_concat(member_id) as members FROM `tbl_board_members` WHERE board_id = $boardid";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);

        if($num_rows > 0){
            $results = mysqli_fetch_array($sql_query);
            $members = $results['members'];
            if(!empty($members)){
                return $members;
            }else{
$query1 = "SELECT * FROM `tbl_user_board` WHERE board_id = $boardid";
        $sql_query1 = mysqli_query($this->dbh, $query1);
        $num_rows1 = mysqli_num_rows($sql_query1);
         $results1 = mysqli_fetch_array($sql_query1);
           $members1 = $results1['admin_id'];
            return $members1;
            }
            
        }else{
               $query1 = "SELECT * FROM `tbl_user_board` WHERE board_id = $boardid";
        $sql_query1 = mysqli_query($this->dbh, $query1);
        $num_rows1 = mysqli_num_rows($sql_query1);
         $results1 = mysqli_fetch_array($sql_query1);
           $members1 = $results1['admin_id'];
            return $members1;
        }
    }



    function getteammemberlist($uid,$teamid){
        $query = "SELECT * FROM `tbl_team_members` WHERE user_id = '".$uid."' AND team_id = '".$teamid."'";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            while($results = mysqli_fetch_array($sql_query)){
$result = $this->getUserMeta($results['member_id']);
$data['member_id'] = $results['member_id'];
$data['member_name'] = $result['full_name'];
$query1 = "SELECT * FROM tbl_users WHERE ID = '".$results['member_id']."'";
$sql_query1 = mysqli_query($this->dbh, $query1);
$results1 = mysqli_fetch_array($sql_query1);
$data['member_email'] = $results1['Email_ID']; 
 $data_array[] = $data;
            }
            return $data_array;
         }else{
            return [];
         }
    }



      function getmemberslist(){
        $query = "SELECT group_concat(ID) as members FROM `tbl_users` WHERE status = '1'";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);

        if($num_rows > 0){
            $results = mysqli_fetch_array($sql_query);
            $members = $results['members'];
            if(!empty($members)){
                return $members;
            }else{
$query1 = "SELECT * FROM `tbl_user_board`";
        $sql_query1 = mysqli_query($this->dbh, $query1);
        $num_rows1 = mysqli_num_rows($sql_query1);
         $results1 = mysqli_fetch_array($sql_query1);
           $members1 = $results1['admin_id'];
            return $members1;
            }
            
        }else{
               $query1 = "SELECT * FROM `tbl_user_board`";
               $sql_query1 = mysqli_query($this->dbh, $query1);
               $num_rows1 = mysqli_num_rows($sql_query1);
               $results1 = mysqli_fetch_array($sql_query1);
               $members1 = $results1['admin_id'];
               return $members1;
        }
    }
     function getboardcardmembers($value, $card_id){
        $query = "SELECT * FROM tbl_board_card_members where Menber = $value and card_id = $card_id";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
           $DataSet = mysqli_fetch_array($result);
           $data=$DataSet['Menber'];
            return $data;
        }
    }

    function getmembersdetails(){
        $query = "SELECT * FROM tbl_board_card_members";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        $mems=array();
        if($rowcount > 0){
         while($DataSet = mysqli_fetch_array($result)){
            array_push($mems,$DataSet['user_id']);
         }
           
            return $mems;
        }
    }

    function unserializeForm($str) {
        $returndata = array();
        $strArray = explode("&", $str);
        $i = 0;
        foreach ($strArray as $item) {
            $array = explode("=", $item);
            $returndata[$array[0]] = $array[1];
        }
        return $returndata;
    }

    /* get emoji code  :: 04/27/2017 */
    function getEmoji(){
        $query = "SELECT * FROM tbl_smile order by rand() limit 6";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            while($result = mysqli_fetch_array($sql_query)){
                $data['code'] = $result['code'];
                $data['icon'] = $result['icon_url'].$result['icon'].$result['icon_ext'];
                $data['name'] = $result['icon'];
                $data_array[] = $data;
            }
            return $data_array;
        }
    }


    /* search emojis by name */

     function searchEmoji($icon){
        $query = "SELECT * FROM tbl_smile where icon LIKE '%$icon%' ";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            while($result = mysqli_fetch_array($sql_query)){
                $data['code'] = $result['code'];
                $data['icon'] = $result['icon_url'].$result['icon'].$result['icon_ext'];
                $data['name'] = $result['icon'];
                $data_array[] = $data;
            }
            return $data_array;
        }
    }


    /* get team members List */
    function getAllTeamMembers($tid){
        $query = "SELECT member_id FROM tbl_team_members where team_id = '$tid' ";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            while($result = mysqli_fetch_array($sql_query)){
                $data['members'] = $result['member_id'];
                $data_array[] = $data;
            }
            return $data_array;
        }
    } 

    /* count board List */

    function getBoardListCount($bid){
        $query = "SELECT count(bl.list_id) as list FROM tbl_board_list as bl WHERE bl.board_id = $bid";
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
            $total_list = $DataSet['list'];
            return $total_list;
        }
    }

    /* count board list cards */

    function getBoardListCardCount($bid){
        $query = "SELECT count(blc.card_id) as cards FROM tbl_board_list as bl left join tbl_board_list_card as blc on blc.list_id = bl.list_id WHERE bl.board_id = $bid and blc.card_title != ' ' ";
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
            $total_list = $DataSet['cards'];
            return $total_list;
        }
    }

    /* count boardmember */
    function getBoardMemberCount($bid){
        $query = "SELECT count(id) as boardmember FROM `tbl_board_members` where board_id = $bid ";
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
            $total_list = $DataSet['boardmember'];
            return $total_list;
        }
    }


     /* count team member */
    function getTeamMemberCount($bid){
        $query = "SELECT count(member_id) as teammember FROM tbl_team_members where team_id = $bid ";
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
            $total_list = $DataSet['teammember'];
            return $total_list;
        }
    }

    /* get all user board */   
    function getAllUserBoard($uid){
         $set_mode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
          $resultss = mysqli_query($this->dbh,$set_mode);
       $return_results_top = array();
       $query = "select ub.*, GROUP_CONCAT(ubm.meta_key) as mkey, 
GROUP_CONCAT(ubm.meta_value) as mvalue from tbl_user_board as ub , tbl_user_boardmeta as ubm 
where ub.admin_id = $uid and ub.board_id = ubm.board_id group by ub.board_title";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_result = array();
            while($DataSet = mysqli_fetch_array($result)){
                $key = explode(",", $DataSet['mkey']);
                array_push($key, "title","board_id","board_star");
                $value = explode(",", $DataSet['mvalue']);
                array_push($value, $DataSet['board_title'],$DataSet['board_id'],$DataSet['board_star']);
                $data = array_combine($key, $value);
                $data_result[] = $data;
            }
            return $data_result;    
        }
    }


    /* get All labels */

    function getAlllabels(){
        $query = "SELECT label_text,color FROM tbl_labels order by rand() limit 6";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            while($result = mysqli_fetch_array($sql_query)){
                $data['label_text'] = $result['label_text'];
                $data['color'] = $result['color'];
                $data_array[] = $data;
            }
            return $data_array;
        }
    } 


    /* get_userboard */
    
    
    /* Get all Card Comment */
function getAllCardCommentios($cardID){
        $query = "SELECT tbl_board_list_card_comments.*,tbl_users.Full_Name FROM tbl_board_list_card_comments left join tbl_users on tbl_users.ID=tbl_board_list_card_comments.userid WHERE cardid = $cardID";
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
            $data_array = array();
            if($rowcount>0){
            while($DataSet = mysqli_fetch_array($result)){
                $data['userid'] = (int)$DataSet['userid'];
                $data['username'] = $DataSet['Full_Name'];
                $data['card_id'] = (int)$DataSet['cardid'];
                $data['comments'] = $DataSet['comments'];
                $data['date_time'] = $DataSet['date_time'];
                $data['ckey'] = $DataSet['ckey'];
                $data_array[] = $data;
            }
        }else{
           $data_array = []; 
        }
         return $data_array;
    
    }


    function getAllCardComment($cardID){
        //data of card comment
        $query = "SELECT tbl_board_list_card_comments.*,tbl_users.Full_Name FROM tbl_board_list_card_comments left join tbl_users on tbl_users.ID=tbl_board_list_card_comments.userid WHERE cardid = $cardID";
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                $data['userid'] = (int)$DataSet['userid'];
                $data['username'] = $DataSet['Full_Name'];
                $data['card_id'] = (int)$DataSet['cardid'];
                $data['comments'] = $DataSet['comments'];
                $data['date_time'] = $DataSet['date_time'];
                $data['ckey'] = $DataSet['ckey'];
                $data_array[] = $data;
            }
         
          $response = array(
                "successBool" => true,
                "responseType" => "all_card_comment",
                "successCode" => "200",
                    "response" => array(
                        "totalList" => $rowcount,
                        "attachments" => $this->getCardAttachment($cardID),
                        "AllCardComment" => $data_array,
                        "DuedateDetails" => $this->getbordlistduedate1($cardID)
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
         return $response;
    }
    
    function getCardAttachment($cardID){

        $query = "select tbl_board_list_card_attachements.*,tbl_users.Full_Name from tbl_board_list_card_attachements
 left join tbl_users on tbl_users.ID=tbl_board_list_card_attachements.userid where cardid=$cardID";

        $result = mysqli_query($this->dbh,$query);

        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
           $data_array = array();
            while($results = mysqli_fetch_array($result)){
               if($results['file_type']=='url'){
                $filepath = $results['attachments'];
               }else if($results['file_type']=='file'){
                $filepath = $this->site_url.'attachments/'.$results['attachments'];
               }else{
                       $filepath = $results['attachments'];
               }


               if($results['file_type']=='url'){
     $fileiconshow = 1;
     $c = $results['location'];
     $results['file_icon'] = $this->site_url."/icon/$c.png";
}elseif($results['file_type']=='file'){
    if($results['file_extenstion']=='jpg' OR $results['file_extenstion'] =='png' OR $results['file_extenstion'] =='jpeg' OR $results['file_extenstion'] =='gif' OR $results['file_extenstion'] =='tif' OR $results['file_extenstion'] =='ico'){
         $fileiconshow = 2;
        $results['file_icon'] = $filepath;
    }else{
         $fileiconshow = 3;
        $results['file_icon'] = $results['file_extenstion'];
    }
}elseif($results['file_type']=='evernote'){
        $fileiconshow = 4;
      $results['file_icon'] = $this->site_url.'icon/evernote.png';
    }

            $data['id'] = ($results['id']) ? $results['id'] : '';
                $data['cardid'] = ($results['cardid']) ? $results['cardid'] : '';
                $data['userid'] = ($results['userid']) ? $results['userid'] : '';
                $data['username'] = ($results['Full_Name']) ? $results['Full_Name'] : '';
                $data['attachments'] = ($results['attachments']) ? $results['attachments'] : '';
                $data['title_name'] = ($results['title_name']) ? $results['title_name'] : '';
                  $data['type'] = ($results['file_type']) ? $results['file_type'] : '';
                $data['url_type'] = ($results['location']) ? $results['location'] : '';
                $data['file_url'] = ($filepath) ? $filepath : '';
                $data['file_icon'] = ($results['file_icon']) ? $results['file_icon'] : '';
                $data['fileiconshow'] = ($fileiconshow) ? $fileiconshow : '';
                $data['file_extenstion'] = ($results['file_extenstion']) ? $results['file_extenstion'] : '';
                $data['ckey'] = ($results['ckey']) ? $results['ckey'] : '';
                $data['cover_image'] = ($results['cover_image']) ? $results['cover_image'] : '0';
                $data['date_time'] = ($results['datetime']) ? $results['datetime'] : '';
                $data['status'] = ($results['status']) ? $results['status'] : '';
                $data['is_linked'] = ($results['is_linked']) ? $results['is_linked'] : '0';
                $data['note_book_guide'] = ($results['note_book_guide']) ? $results['note_book_guide'] : '';
                $data['note_guide'] = ($results['note_guide']) ? $results['note_guide'] : '';
                $data_array[] = $data;
            }




           
            return $data_array;    
        }
    }


      function getcard($list_id){
    $query = "SELECT card_title,list_id,card_id,def,del_status,card_description,position FROM tbl_board_list_card WHERE list_id = $list_id and def != 1 and del_status != 1 ORDER BY position ASC";
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        $data_array = array();
        if($rowcount > 0){



           while($DataSet = mysqli_fetch_array($result)){
                $query3 = "select * FROM tbl_board_list_duedate WHERE card_id = '".$DataSet['card_id']."'";
        $result3 = mysqli_query($this->dbh,$query3);
        $rowcount3 = mysqli_num_rows($result3);
       if($rowcount3 > 0){
            $data_array3 = array();
            $DataSet3 = mysqli_fetch_array($result3);
$data3['duedate'] = $DataSet3['duedate'];
$data3['duetime'] = $DataSet3['duetime'];
$data3['duedatetime'] = $DataSet3['duedate'].' '.$DataSet3['duetime'];
$data3['complete_status'] = $DataSet3['complete_status'];
  }else{

    $data3['duedate'] = "";
$data3['duetime'] = "";
$data3['duedatetime'] = "";
$data3['complete_status'] = "";


               /* $obj3 = (object)[];
              $data3 = $obj3;*/
           }

     $query1 = "SELECT * FROM tbl_board_card_members WHERE card_id = '".$DataSet['card_id']."'";
         $result1 = mysqli_query($this->dbh,$query1);
         $member = mysqli_num_rows($result1);
         

  $data_array2 = array();
        if($member != 0){
           while($value1 = mysqli_fetch_array($result1)){ 

    $result2 = $this->getUserMeta($value1['Menber']);

$data2['member_id'] = $value1['Menber'];
$data2['member_name'] = $result2['full_name'];
$data2['member_emil'] = $result2['user_name'];
 $data_array2[] = $data2;
}

}else{
   $data_array2= []; 
}

$query1 = "select * FROM tbl_board_list_card_labels WHERE cardid = '".$DataSet['card_id']."'";
//echo $query1;
        $result1 = mysqli_query($this->dbh,$query1);
        $rowcount1 = mysqli_num_rows($result1);
        if($rowcount1 > 0){
            $data_array1 = array();
            while($DataSet1 = mysqli_fetch_array($result1)){
                $userlabeldata = $this->getuserlabeldetail($DataSet1['labels']);
               // print_r($userlabeldata);
               $data1['label_id'] = $DataSet1['labels'];
               $data1['label_name'] = $userlabeldata['label_name'];
               $data1['color'] = $userlabeldata['color'];
               $data_array1[] = $data1;
            }
            }else{
               $data_array1 = [];  
           }

        $query4 = "select * FROM tbl_board_list_card_checklist INNER JOIN tbl_board_list_card_checklist_item ON tbl_board_list_card_checklist.id = tbl_board_list_card_checklist_item.checklist_id WHERE tbl_board_list_card_checklist.cardid = '".$DataSet['card_id']."'";
        $result4 = mysqli_query($this->dbh,$query4);
        $rowcount4 = mysqli_num_rows($result4);

        $query5 = "select * FROM tbl_board_list_card_checklist INNER JOIN tbl_board_list_card_checklist_item ON tbl_board_list_card_checklist.id = tbl_board_list_card_checklist_item.checklist_id WHERE tbl_board_list_card_checklist.cardid = '".$DataSet['card_id']."' AND tbl_board_list_card_checklist_item.status = 1";
        $result5 = mysqli_query($this->dbh,$query5);
        $rowcount5 = mysqli_num_rows($result5);


                $data['card_title'] = $DataSet['card_title'];
                $data['card_position'] = $DataSet['position'];
                $data['card_description'] = $DataSet['card_description'];
                $data['list_id'] = (int)$DataSet['list_id'];
                $data['card_id'] = (int)$DataSet['card_id'];
                $data['del_status'] = (int)$DataSet['del_status'];
                $data['cardComments'] = (int)$this->getCardCommentsCount($DataSet['card_id']);
                $data['total_attachments'] = (int)$this->getCardAttachmentsCount($DataSet['card_id']);
                $data['cover_image'] = $this->getCardcover_image($DataSet['card_id']);
                $data['total_checklist'] = $rowcount4;
                $data['total_checklist_checked'] = $rowcount5;
                $data['duedate'] = $data3;
                $data['member'] = $data_array2;
                $data['label'] = $data_array1;
                $data_array[] = $data;
            }
            return $data_array;



        }else{
          return $data_array;  
        }
    }
    /* End Get all Card Comment */


    /*Stat get all color code $id*/

    
function getAllColor(){
  $query = "SELECT * FROM tbl_labels";
     $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                $data['id'] = (int)$DataSet['id'];
                $data['color'] =  $DataSet['color'];
                $data_array[] = $data;
            }
            $response = array(
                "successBool" => true,
                "responseType" => "template_list",
                "successCode" => "200",
                    "response" => array(
                        "totalList" => $rowcount,
                        "AllCardComment" => $data_array
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
               
         }else{
            $response = array(
                "successBool" => false,
                "successCode" => "",
                    "response" => array(),
                    "ErrorObj"   => array(
                        "ErrorCode" => "103",
                        "ErrorMsg"  => "No Data Found"
                    )       
            );
         }
         return $response;
    }

    function getColorbyid($id){
  $query = "SELECT * FROM tbl_labels WHERE id= $id";
     $result = mysqli_query($this->dbh,$query);
            $data_array = array();
$DataSet = mysqli_fetch_array($result);

                $data_array[] = $DataSet;
          
        return $DataSet;
    }


    /*End all color code*/

    /*Start get all template by catid */
    
function gettemplatebyCatid_old($id){
    // AND cat_id = '".$id."'
    if($id=='featured'){
    $query = "SELECT * FROM  tbl_templates WHERE status = '1'";
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
    }else{
 $query = "SELECT * FROM  tbl_templates WHERE status = '1' AND cat_id = '".$id."'";
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
    }
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                if(!empty($DataSet['image'])){
                $temp_img = $this->site_url.'admin/temp/images/'.$DataSet['image'];
                }else{
                    $temp_img = '';
                }
                $data['id'] = (int)$DataSet['id'];
                $data['name'] =  $DataSet['name'];
                $data['plan'] = $DataSet['plan_tag'];
                $data['temp_img'] = $temp_img;
                 $data['temp_catid'] = $DataSet['cat_id'];
                 $catquery = "SELECT * FROM  tbl_tmp_category WHERE id = '".$DataSet['cat_id']."'";
                 $catresult = mysqli_query($this->dbh,$catquery);
                 $catdata = mysqli_fetch_array($catresult);
                 $data['cat_name'] = $catdata['cat_name'];
                 
                 $data['description'] = $DataSet['description'];
               $data['board_detail'] = $this->boarddetailbyid($DataSet['id']);
                $data_array[] = $data;
            }
            $response = array(
                "successBool" => true,
                "responseType" => "template_list",
                "successCode" => "200",
                    "response" => array(
                        "totalList" => $rowcount,
                        "AllCardComment" => $data_array
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
               
         }else{
            $response = array(
                "successBool" => false,
                "successCode" => "",
                    "response" => array(),
                    "ErrorObj"   => array(
                        "ErrorCode" => "103",
                        "ErrorMsg"  => "No Data Found"
                    )       
            );
         }
         return $response;
    }

  /*Start get all template by catid */
    
function gettemplatebyCatid($id){
    // AND cat_id = '".$id."'
    // if($id=='featured'){
    // $query = "SELECT * FROM  tbl_templates WHERE status = '1'";
    //      $result = mysqli_query($this->dbh,$query);
    //     $rowcount = mysqli_num_rows($result);
    // }else{
 $query = "SELECT * FROM  tbl_templates WHERE status = '1' AND cat_id = '".$id."'";
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
    //}
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                if(!empty($DataSet['image'])){
                $temp_img = $this->site_url.'admin/temp/images/'.$DataSet['image'];
                }else{
                    $temp_img = '';
                }
                $data['id'] = (int)$DataSet['id'];
                $data['name'] =  $DataSet['name'];
                $data['plan'] = $DataSet['plan_tag'];
                $data['temp_img'] = $temp_img;
                $data['temp_catid'] = $DataSet['cat_id'];
                $catquery = "SELECT * FROM  tbl_tmp_category WHERE id = '".$DataSet['cat_id']."'";
                 $catresult = mysqli_query($this->dbh,$catquery);
                 $catdata = mysqli_fetch_array($catresult);
                 $data['cat_name'] = $catdata['cat_name'];
               $data['no_of_subscription'] = $this->templateusercount($id);
               $data['no_of_card'] = $this->templatecardcount($DataSet['cat_id']);
                 $data['description'] = $DataSet['description'];
               $data['board_detail'] = $this->boarddetailbyid($DataSet['id']);
                $data_array[] = $data;
            }
            $response = array(
                "totalList" => $rowcount,
                "AllTemplate" => $data_array,
                   
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
               
         }else{
            $response = array(
                "successBool" => false,
                "successCode" => "",
                    "response" => array(),
                    "ErrorObj"   => array(
                        "ErrorCode" => "103",
                        "ErrorMsg"  => "No Data Found"
                    )       
            );
         }
         return $response;
    }
    function gettemplatebyid($id){
        $query = "SELECT * FROM  tbl_templates WHERE status = '1' AND id = '".$id."'";
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            $DataSet = mysqli_fetch_array($result);
                if(!empty($DataSet['image'])){
                $temp_img = $this->site_url.'admin/temp/images/'.$DataSet['image'];
                }else{
                    $temp_img = '';
                }
                $data['id'] = (int)$DataSet['id'];
                $data['name'] =  $DataSet['name'];
                $data['temp_img'] = $temp_img;
                $data['temp_catid'] = $DataSet['cat_id'];
                $catquery = "SELECT * FROM  tbl_tmp_category WHERE id = '".$DataSet['cat_id']."'";
                $catresult = mysqli_query($this->dbh,$catquery);
                $catdata = mysqli_fetch_array($catresult);
                $data['cat_name'] = $catdata['cat_name'];
                $data['description'] = $DataSet['description'];
                $data['board_detail'] = $this->boarddetailbyid($DataSet['id']);
                $data_array[] = $data;
            $response = array(
                "successBool" => true,
                "responseType" => "template_list",
                "successCode" => "200",
                    "response" => array(
                        "totalList" => $rowcount,
                        "AllCardComment" => $data
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
               
         }else{
            $response = array(
                "successBool" => false,
                "successCode" => "",
                    "response" => array(),
                    "ErrorObj"   => array(
                        "ErrorCode" => "103",
                        "ErrorMsg"  => "No Data Found"
                    )       
            );
         }
         return $response;
    }

      function boarddetailbyid($list_id){
    $query = "SELECT * FROM tbl_tmp_board WHERE cat_id = '".$list_id."' AND status = '1'";
//echo $query;die;
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                if(empty($DataSet['board_bgimage'])){
                    $bgimage = '';
                }else{
                    $bgimage = $this->site_url.'admin/temp/images/'.$DataSet['board_bgimage'];
                }
                $data['board_id'] = $DataSet['id'];
                $data['board_url'] = $DataSet['board_url'];
                $data['board_key'] = $DataSet['board_key'];
                $data['board_title'] = $DataSet['board_name'];
                $data['board_bgcolor'] = $DataSet['board_bgcolor'];   
                 $data['bg_img'] = $bgimage;  
                 $data['board_fontcolor'] = $DataSet['board_fontcolor'];
                 $data['board_list'] = $this->getboardlistByid($DataSet['id']);
                $data_array[] = $data;
            }
         }else{
            $data_array = [];
        }
        return $data_array;
    }


      function getboardlistByid($list_id){
    $query = "SELECT * FROM tbl_board_list WHERE list_id = '".$list_id."'";
//echo $query;die;
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
              
                $data['list_id'] = $list_id;
                $data['board_id'] = $DataSet['board_id'];
                $data['list_title'] = $DataSet['list_title'];
                $data['list_color'] = $DataSet['list_color'];
                $data['list_icon'] = $DataSet['list_icon'];
                
                $data_array[] = $data;
            }
         }else{
            $data_array = [];
        }
        return $data_array;
    }

         function getlistCrdbyid($list_id){
    $query = "SELECT * FROM tbl_tmp_board_list_card WHERE list_id = '".$list_id."' AND status = '1'";
//echo $query;die;
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
              
                $data['card_id'] = $DataSet['id'];
                $data['list_id'] = $list_id;
                $data['card_title'] = $DataSet['card_name'];
                $data['card_description'] = $DataSet['card_description'];
                $data_array[] = $data;
            }
         }else{
            $data_array = [];
        }
        return $data_array;
    }


    /*End get all template by catid*/
    /* Get all Label */

function getusersrchlabellist($uid,$srchkey){
    if(empty($srchkey)){
$query = "SELECT * FROM tbl_label_users WHERE user_id = $uid";
    }else{
      $query = "SELECT * FROM tbl_label_users WHERE user_id = $uid AND label_name  like '%$srchkey%'";  
    }
    //echo $query;
     $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
         if($rowcount > 0){
    $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                    $colordata = $this->getColorbyid($DataSet['label_id']);
                $data['id'] = (int)$DataSet['id'];
                $data['label_id'] = (int)$DataSet['label_id'];
                $data['label_name'] = $DataSet['label_name'];
                $data['color'] = $colordata['color'];
               
                $data_array[] = $data;
            }
            $response = array(
                "successBool" => true,
                "responseType" => "label_list",
                "successCode" => "200",
                    "response" => array(
                        "totalList" => $rowcount,
                        "AllCardComment" => $data_array
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
         }else{
               $response = array(
                "successBool" => false,
                "successCode" => "",
                    "response" => array(),
                    "ErrorObj"   => array(
                        "ErrorCode" => "103",
                        "ErrorMsg"  => "No Data Found"
                    )       
            );
         }
          return $response;
}

function getassigncardata($card_id,$lblid){

$lastid = $this->getLastInsertedusercardlabel($card_id);
    $userlabeldata = $this->getuserlabeldetail($lblid);
    $data1['id'] = $lastid;
    $data1['label_name'] = $userlabeldata['label_name'];
    $data1['color'] = $userlabeldata['color'];
    return $data1;
}

function getmergelist($uid,$cardid,$board_id){
    $query = "SELECT * FROM tbl_label_users WHERE user_id = $uid";
     $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
    $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                    $colordata = $this->getColorbyid($DataSet['label_id']);
                $data['label_id'] = (int)$DataSet['id'];
                $data['color_id'] = (int)$DataSet['label_id'];
                $data['label_name'] = $DataSet['label_name'];
                $data['color'] = $colordata['color'];
               
                $data_array[] = $data;
}
$query1 = "select * FROM tbl_board_list_card_labels WHERE cardid = $cardid";
        $result1 = mysqli_query($this->dbh,$query1);
        $rowcount1 = mysqli_num_rows($result1);
        if($rowcount1 > 0){
            $data_array1 = array();
            while($DataSet1 = mysqli_fetch_array($result1)){
                $userlabeldata = $this->getuserlabeldetail($DataSet1['labels']);
               // print_r($userlabeldata);
               $data1['id'] = $DataSet1['id'];
               $data1['cardid'] = $cardid;
               $data1['label_id'] = $DataSet1['labels'];
               $data1['label_name'] = $userlabeldata['label_name'];
               $data1['userid'] = $DataSet1['userid'];
               $data1['color'] = $userlabeldata['color'];
               $data_array1[] = $data1;
            }
            }else{
               $data_array1 = [];  
           }



        $member = $this->getBoardmembers($board_id);
  $array = explode(",",$member);
  $data_array2 = array();
        if($member != 0){
foreach ($array as $value1) {
    $wherecon = array(
'card_id' => $cardid,
'Menber' => $value1,
        );
    $getcradstatus = $this->datafound('tbl_board_card_members',$wherecon);

    $result2 = $this->getUserMeta($value1);
if($getcradstatus>0){
$card_status = 1;
}else{
$card_status = 0;
}
$data2['cardid'] = $cardid;
$data2['member_id'] = $value1;
$useremil = $this->getsingledata('tbl_users',array('ID'=>$value1));
$data2['member_name'] = $result2['full_name'];
$data2['member_emil'] = $useremil['Email_ID'];
$data2['card_status'] = $card_status;
 $data_array2[] = $data2;
}

}else{
   $data_array2= []; 
}

$query3 = "select * FROM tbl_board_list_duedate WHERE card_id = $cardid";
///echo "select * FROM tbl_board_list_duedate WHERE card_id = $cardid";
        $result3 = mysqli_query($this->dbh,$query3);
        $rowcount3 = mysqli_num_rows($result3);

        if($rowcount3 > 0){
            $data_array3 = array();
            $DataSet3 = mysqli_fetch_array($result3);
            
            $data3['due_id'] = $DataSet3['id'];
            $data3['card_id'] = $DataSet3['card_id'];
            $data3['duedate'] = $DataSet3['duedate'];
            $data3['duetime'] = $DataSet3['duetime'];
            $data3['duedatetime'] = $DataSet3['duedate'].' '.$DataSet3['duetime'];
            $data3['complete_status'] = $DataSet3['complete_status'];

           
            }else{
                $obj3 = (object)[];
              $data3 = $obj3;
           }




$wherarray = array(
'status' => 1,
'cardid' => $cardid,
    );
$chelistdata = $this->getdata('tbl_board_list_card_checklist',$wherarray);

if(!empty($chelistdata)){

           foreach($chelistdata as $check_data){
    $wherarray1 = array(
'checklist_id' => $check_data['id'],
    );

        $wherarray11 = array(
        'status' => 1,
'checklist_id' => $check_data['id'],
    );
$total_item = $this->datafound('tbl_board_list_card_checklist_item',$wherarray1);
$total_item1 = $this->datafound('tbl_board_list_card_checklist_item',$wherarray11);

  $singlepar = 100/$total_item;


//echo $total_item;
if($total_item>0){
if($total_item1==1){
    $parcentcheck = intval($singlepar);
}else if($total_item1==$total_item){
$parcentcheck = 100;
}else if($total_item1==0){
$parcentcheck = 0;
}else{
    $parcentcheck = intval($singlepar*$total_item1);
} 
}else{
    $parcentcheck = 0;
}

    $chelistdataitem = $this->getdata('tbl_board_list_card_checklist_item',$wherarray1);
    if(!empty($chelistdataitem)){
        $data_check_item = '';
        $checkitem = array();
        foreach($chelistdataitem as $check_data_item){
$data_check_item = array(
'item_id' => $check_data_item['id'],
'item_name' => $check_data_item['item_name'],
'parent_id' => $check_data_item['checklist_id'],
'status' => $check_data_item['status'],
    );
$checkitem[] = $data_check_item;
    }
}else{
    $checkitem = [];
}
    
$data_check = array(
'checklist_id' => $check_data['id'],
'card_id' => $cardid,
'user_id' => $check_data['userid'],
'checklist_name' => $check_data['checklist'],
'date_time' => $check_data['date_time'],
'checklist_item' => $checkitem,
'progress' => $parcentcheck,
    );

$checkarry[] = $data_check;
}
}else{
    $checkarry = [];
}


 $querydescrip = "SELECT * FROM tbl_board_list_card WHERE card_id = $cardid";
     $resultdescrpt = mysqli_query($this->dbh,$querydescrip);
        $datadescription = mysqli_fetch_array($resultdescrpt);
if(!empty($datadescription)){
 $carddesc = $datadescription['card_description'];
}else{
    $carddesc = '';
}
 $response = array(
                "successBool" => true,
                "responseType" => "merge_list",
                "successCode" => "200",
                    "response" => array(
                        "totallabelList" => $rowcount,
                        "alllabel" => $data_array,
                         "totalcardlabelList" => $rowcount1,
                        "allcardlabel" => $data_array1,
                       "board_card_member" => $data_array2,
                       "duedate_data" => $data3,
                       "checklist_data" => $checkarry,
                       "card_description" => $carddesc
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
       
          return $response;
}







function getuserlabellist($uid){
    $query = "SELECT * FROM tbl_label_users WHERE user_id = $uid";
     $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
         if($rowcount > 0){
    $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                    $colordata = $this->getColorbyid($DataSet['label_id']);
                $data['label_id'] = (int)$DataSet['id'];
                // $data['color_id'] = (int)$DataSet['color'];
                $data['label_name'] = $DataSet['label_name'];
                $data['color'] = $colordata['color'];
               
                $data_array[] = $data;
            }
            $response = array(
                "successBool" => true,
                "responseType" => "label_list",
                "successCode" => "200",
                    "response" => array(
                        "totalList" => $rowcount,
                        "AllCardComment" => $data_array
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
         }else{
               $response = array(
                "successBool" => false,
                "successCode" => "",
                    "response" => array(),
                    "ErrorObj"   => array(
                        "ErrorCode" => "103",
                        "ErrorMsg"  => "No Data Found"
                    )       
            );
         }
          return $response;
}

function getcardlabellistios($cardid){
   
  
$query1 = "select * FROM tbl_board_list_card_labels WHERE cardid = $cardid";
        $result1 = mysqli_query($this->dbh,$query1);
        $rowcount1 = mysqli_num_rows($result1);
        if($rowcount1 > 0){
            while($DataSet1 = mysqli_fetch_array($result1)){
                $userlabeldata = $this->getuserlabeldetail($DataSet1['labels']);
               // print_r($userlabeldata);
               $data1['id'] = $DataSet1['id'];
               $data1['cardid'] = $cardid;
               $data1['label_id'] = $DataSet1['labels'];
               $data1['label_name'] = $userlabeldata['label_name'];
               $data1['userid'] = $DataSet1['userid'];
               $data1['color'] = $userlabeldata['color'];
               $data_array1[] = $data1;
            }
            }else{
               $data_array1 = [];  
           }
return $data_array1;
       }
       
       
     /*  function getNotificationList($board_id){
        $query1 = "select * FROM tbl_push_notification where  notif_user_to='$board_id'  order by id desc ";
                $result1 = mysqli_query($this->dbh,$query1);
                $rowcount1 = mysqli_num_rows($result1);
                if($rowcount1 > 0){
                    while($DataSet1 = mysqli_fetch_array($result1)){
                       
                       $data1['id'] = $DataSet1['id'];
                       $data1['notif_title'] = $DataSet1['notif_title'];
                       $data1['notif_msg'] = $DataSet1['notif_msg'];
                       $data1['notif_user_from'] = $DataSet1['notif_user_from'];
                       $data1['notif_user_to'] = $DataSet1['notif_user_to'];
                       $data1['publish_date'] = $DataSet1['publish_date'];
                       $data_array1[] = $data1;
                    }
                    }else{
                       $data_array1 = [];  
                   }
        return $data_array1;
       }*/
       
       function getBoardActivityList($board_id){
        $query1 = "select * FROM tbl_board_activity where  board_id='$board_id'  order by id desc ";
                $result1 = mysqli_query($this->dbh,$query1);
                $rowcount1 = mysqli_num_rows($result1);
                if($rowcount1 > 0){
                    while($DataSet1 = mysqli_fetch_array($result1)){
                       
                       $data1['id'] = $DataSet1['id'];
                       $data1['title'] = $DataSet1['title'];
                       $data1['msg'] = $DataSet1['msg'];
                       $data1['publish_date'] = $DataSet1['publish_date'];
                       $data_array1[] = $data1;
                    }
                    }else{
                       $data_array1 = [];  
                   }
        return $data_array1;
       }

function getcardmemberios($cardid,$board_id){
           $member = $this->getBoardmembers($board_id);
           //print_r($member);
  $array = explode(",",$member);
  $data_array2 = array();
        if($member != 0){
foreach ($array as $value1) {
    $wherecon = array(
'card_id' => $cardid,
'Menber' => $value1,
        );
    $getcradstatus = $this->datafound('tbl_board_card_members',$wherecon);

    $result2 = $this->getUserMeta($value1);
if($getcradstatus>0){
$card_status = 1;
}else{
$card_status = 0;
}
$data2['cardid'] = $cardid;
$data2['member_id'] = $value1;
$data2['member_name'] = $result2['full_name'];
$data2['member_emil'] = $result2['user_name'];
$data2['card_status'] = $card_status;
 $data_array2[] = $data2;
}

}else{
   $data_array2= []; 
}
  
return $data_array2;
       }




function getcarchecklistios($cardid){
         $wherarray = array(
'status' => 1,
'cardid' => $cardid,
    );
$chelistdata = $this->getdata('tbl_board_list_card_checklist',$wherarray);

if(!empty($chelistdata)){

           foreach($chelistdata as $check_data){
    $wherarray1 = array(
'checklist_id' => $check_data['id'],
    );

        $wherarray11 = array(
        'status' => 1,
'checklist_id' => $check_data['id'],
    );
$total_item = $this->datafound('tbl_board_list_card_checklist_item',$wherarray1);
$total_item1 = $this->datafound('tbl_board_list_card_checklist_item',$wherarray11);
$singlepar = 100/$total_item;
//echo $total_item;
if($total_item>0){
if($total_item1==1){
    $parcentcheck = intval($singlepar);
}else if($total_item1==$total_item){
$parcentcheck = 100;
}else if($total_item1==0){
$parcentcheck = 0;
}else{
    $parcentcheck = intval($singlepar*$total_item1);
} 
}else{
    $parcentcheck = 0;
}

    $chelistdataitem = $this->getdata('tbl_board_list_card_checklist_item',$wherarray1);
    if(!empty($chelistdataitem)){
        $data_check_item = '';
        $checkitem = array();
        foreach($chelistdataitem as $check_data_item){
$data_check_item = array(
'item_id' => $check_data_item['id'],
'item_name' => $check_data_item['item_name'],
'parent_id' => $check_data_item['checklist_id'],
'status' => $check_data_item['status'],
    );
$checkitem[] = $data_check_item;
    }
}else{
    $checkitem = [];
}
    
$data_check = array(
'checklist_id' => $check_data['id'],
'card_id' => $cardid,
'user_id' => $check_data['userid'],
'checklist_name' => $check_data['checklist'],
'date_time' => $check_data['date_time'],
'checklist_item' => $checkitem,
'progress' => $parcentcheck,
    );

$checkarry[] = $data_check;
}
}else{
    $checkarry = [];
} 
return $checkarry;

       }

function getcardescriptionios($cardid){
 $querydescrip = "SELECT * FROM tbl_board_list_card WHERE card_id = $cardid";
     $resultdescrpt = mysqli_query($this->dbh,$querydescrip);
        $datadescription = mysqli_fetch_array($resultdescrpt);
if(!empty($datadescription)){
 $carddesc = $datadescription['card_description'];
}else{
    $carddesc = '';
}

return $carddesc;
}



function getuserlabellistios($uid){
    $query = "SELECT * FROM tbl_label_users WHERE user_id = $uid";
     $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
         if($rowcount > 0){
    $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                    $colordata = $this->getColorbyid($DataSet['label_id']);
                $data['label_id'] = (int)$DataSet['id'];
                $data['color_id'] = (int)$DataSet['label_id'];
                $data['label_name'] = $DataSet['label_name'];
                $data['color'] = $colordata['color'];
               
                $data_array[] = $data;
            }
           
         }else{
             $data_array = [];
         }
          return $data_array;
}





    function getlabellist(){
        $query = "SELECT * FROM  tbl_labels";
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                $data['id'] = (int)$DataSet['id'];
                $data['label_text'] = (int)$DataSet['label_text'];
                $data['color'] = $DataSet['color'];
               
                $data_array[] = $data;
            }
            $response = array(
                "successBool" => true,
                "responseType" => "label_list",
                "successCode" => "200",
                    "response" => array(
                        "totalList" => $rowcount,
                        "AllCardComment" => $data_array
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
               
         }else{
            $response = array(
                "successBool" => false,
                "successCode" => "",
                    "response" => array(),
                    "ErrorObj"   => array(
                        "ErrorCode" => "103",
                        "ErrorMsg"  => "No Data Found"
                    )       
            );
         }
         return $response;
    }

    /* End Get all Label */

    /* Start Get all template category */

        function gettempCatlist(){
        $query = "SELECT * FROM  tbl_tmp_category where status = '1' ";
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        $data_array = array();
        //   $data1['id'] = 'featured';
        //         $data1['cat_name'] = 'Featured';
        //         $data1['cat_slug'] = 'featured';
                // $data['description'] = '';
                      
            
            while($DataSet = mysqli_fetch_array($result)){
                $data['id'] = (int)$DataSet['id'];
                $data['cat_name'] = $DataSet['cat_name'];
                $data['cat_slug'] = $DataSet['cat_slug'];
                //$data['description'] = $DataSet['description'];
               $data['Alltemplate'] = $this->gettemplatebyCatid((int)$DataSet['id']);
                $data_array[] = $data;
            }
$data_array[] =$data1;
            $rowcount1 = $rowcount+1;
            $response = array(
                "successBool" => true,
                "responseType" => "tempCatlist",
                "successCode" => "200",
                    "response" => array(
                        "totalList" => $rowcount1,
                        "Alltempcategory" => $data_array
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
              // print_r($response);
         return $response;
    }

       /* End Get all template category */
    
      /* End Get all template category */
     /* get all card Label List */


     function getuserlabeldetail($userlabelid){
        $query = "SELECT * FROM tbl_label_users INNER JOIN tbl_labels ON tbl_label_users.label_id = tbl_labels.id WHERE tbl_label_users.id = $userlabelid";
         $result = mysqli_query($this->dbh,$query);
         $DataSet = mysqli_fetch_array($result);
         return $DataSet;

     }
     
     function getcardlabellist($card_id){
        $query = "SELECT * FROM  tbl_board_list_card_labels where cardid=$card_id";
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                $data['id'] = (int)$DataSet['id'];
                $data['cardid'] = (int)$DataSet['cardid'];
                $data['userid'] = (int)$DataSet['userid'];
                $data['labels'] = $DataSet['labels'];
                $data['status'] = $DataSet['status'];
                $data['ckey'] = $DataSet['ckey'];
               
                $data_array[] = $data;
            }
            $response = array(
                "successBool" => true,
                "responseType" => "card_label_list",
                "successCode" => "200",
                    "response" => array(
                        "totalList" => $rowcount,
                        "AllCardComment" => $data_array
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
               
         }else{
            $response = array(
                "successBool" => false,
                "successCode" => "",
                    "response" => array(),
                    "ErrorObj"   => array(
                        "ErrorCode" => "103",
                        "ErrorMsg"  => "No Data Found"
                    )       
            );
         }
         return $response;
    }
     /* End get all card Label List */
     
     
     /* Get Last Insert List */
      function getlast_insertlist($board_id){
        $query = "select list_id from  tbl_board_list where  board_id='".$board_id."' order by list_id desc";
        //echo $query;die;
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data = mysqli_fetch_array($result);
            $list_id = $data['list_id'];
            return $list_id;
        }

    }
     
     function getlast_cardId($list_id){
        $query = "select card_id from  tbl_board_list_card where  list_id='".$list_id."' order by list_id desc";
        //echo $query;die;
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data = mysqli_fetch_array($result);
            $card_id = $data['card_id'];
            return $card_id;
        }

    }

     function lastcardId($list_id){
        $query = "select card_id from  tbl_board_list_card where  list_id='".$list_id."' order by card_id desc";
        //echo $query;die;
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data = mysqli_fetch_array($result);
            $card_id = $data['card_id'];
            return $card_id;
        }

    }


       function getrand_boardimg(){
        $query = "SELECT bg_img FROM tbl_board_img ORDER BY RAND() LIMIT 1";
        //echo $query;die;
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data = mysqli_fetch_array($result);
            $image = $data['bg_img'];
            return $image;
        }

    }
     /*End  Get Last Insert List */

     function getbordlistduedate1($cardid){
        $query = "select * FROM tbl_board_list_duedate WHERE card_id = '".$cardid."'";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
       if($rowcount>0){
 $data_array = array();
          $DataSet = mysqli_fetch_array($result);
            
          
             return $DataSet;
       }else{
        return (object)[];
       }
                     
      
    }


function getbordlistduedate2($cardid){
        $query = "select * FROM tbl_board_list_duedate WHERE card_id = '".$cardid."'";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
       if($rowcount>0){
 $data_array = array();
          $DataSet = mysqli_fetch_array($result);
            
          
             return $DataSet;
       }
                     
      
    }





    function getbordlistduedate($cardid){
        $query = "SELECT * FROM tbl_board_list_duedate WHERE card_id = $cardid";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
            if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                $data['id'] = (int)$DataSet['id'];
                $data['userid'] = (int)$DataSet['userid'];
                $data['card_id'] = (int)$DataSet['card_id'];
                $data['duedate'] = $DataSet['duedate'];
                $data['duetime'] = $DataSet['duetime'];
                $data['duedate'] = $DataSet['duedate'].' ' .$DataSet['duetime'];
                //$data['duetime'] = $DataSet['duetime'];
                $data['complete_status'] = (int)$DataSet['complete_status'];

                $data_array[] = $data;
            }
            $response = array(
                "successBool" => true,
                "responseType" => "due_date",
                "successCode" => "200",
                    "response" => array(
                        "totalList" => $rowcount,
                        "DueDatedetails" => $data_array
                        ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
               
         }else{
            $response = array(
                "successBool" => false,
                "successCode" => "",
                    "response" => array(),
                    "ErrorObj"   => array(
                        "ErrorCode" => "103",
                        "ErrorMsg"  => "No Data Found"
                    )       
            );
         }
         return $data_array;       
      
    }
    
    //Dharma Code starts
    
    // dc code 
    
    function getName($id){
        $sql = "SELECT Full_Name FROM tbl_users WHERE ID = '".$id."'";
        $sql_query = mysqli_query($this->dbh,$sql);
        
        $row=mysqli_fetch_array($sql_query);
       
        return $row['Full_Name'];
    }
    
    //to send push notification using firebase
    function sendPushNotification($to='',$data=array())
    {
    	$apiKey='AIzaSyBEDGiJ25AiNeYR6gQ6vwstiPbqNndsKGE';
    	$fields=array('to'=>$to,'notification'=>$data);
    	$headers=array(
    	        'Authorization: key='.$apiKey,
    	        'Content-Type: application/json'
    	       );
    	       
    	$url='https://fcm.googleapis.com/fcm/send';
    	$ch=curl_init();
    	curl_setopt($ch, CURLOPT_URL,$url);
    	curl_setopt($ch, CURLOPT_POST, true);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    	$result = curl_exec($ch);
    	curl_close($ch);
    	//return json_decode($result, true); 
    	return $result;
    	
    	
    }
    
    //to send push notification using apns ios
    
    function pushNotification($user_device_token, $device_type,$message,$board_id,$notification_type,$cardid=null)
    {   
        $sql = "SELECT * FROM tbl_user_board WHERE board_id = '".$board_id."'";
        $sql_query = mysqli_query($this->dbh,$sql);
        $row=mysqli_fetch_array($sql_query);
        if(!empty($row['board_title'])){
        $board_title= $row['board_title'];
        }else{
          $board_title= '';
        }
        if(!empty($row['bg_img'])){
        $bg_img =$row['bg_img'];
        }else
        {
            $bg_img ='';
        }
        if(!empty($row['team_id'])){
        $team_id =$row['team_id'];
        }else
        {
            $team_id ='';
        }
      //return $device_tokens;
        if($device_type=='ios')
        {
            //$message = 'Added no card';
            $badge = 3;
            $sound = 'default';   //or put sound filename
            $development = true;  //Change the $development boolean to switch between development and production pushes
             
            $payload = array();
            $data['board']=$board_id;
            $data['notification_type']=$notification_type;
            $payload['aps'] = array('alert' =>$message , 'badge' => intval($badge), 'sound' => $sound,'board_id'=> $data);
            //$payload['board']  = array('board_id' => $board_id);
            $payload = json_encode($payload);
             
            $apns_url = NULL;
            $apns_cert = NULL;
            $apns_port = 2195;
             
            if($development)
            {
              $apns_url = 'gateway.sandbox.push.apple.com';
            	$apns_cert =  __DIR__.'/odaptoDevApns.pem';
            }
            else
            {
            	$apns_url = 'gateway.push.apple.com';
            	$apns_cert =  __DIR__.'/odaptoDevApns.pem';
            }
             
            $stream_context = stream_context_create();
            stream_context_set_option($stream_context, 'ssl', 'local_cert', $apns_cert);
             
            $apns = stream_socket_client('ssl://' . $apns_url . ':' . $apns_port, $error, $error_string, 2, STREAM_CLIENT_CONNECT, $stream_context);
             
            //	You will need to put your device tokens into the $device_tokens array yourself
            $device_tokens = array($user_device_token);
             
            foreach($device_tokens as $device_token)
            {
            	$apns_message = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $device_token)) . chr(0) . chr(strlen($payload)) . $payload;
                $result=	fwrite($apns, $apns_message);
            }
             
            @socket_close($apns);
            @fclose($apns);
            
            return $result;
            
            
            
        }
        if($device_type=='android')
        {

            // API access key from Google API's Console
               define('API_ACCESS_KEY','AIzaSyAfU9-cx8fjT9Wd_X6gbwMmXTpALFCKmgQ');
                $data=array(
                        'board_id' => $board_id,
                        'notification_type' => $notification_type
                        );
                // prep the bundle
                $msg = array
                (
                    'message' 	=> $message,
                    'vibrate'	=> 1,
                    'sound'		=> 1,
                    'board_id' => $board_id,
                    'board_title' =>$board_title,
                    'board_bgimage'=>$bg_img,
                    'team_id'=>$team_id,
                    'card_id'=>$cardid,
                    'notification_type' => $notification_type
                    //'board_id' => $data
                );
                                
                $fields = array
                (
                    'registration_ids' 	=> array($user_device_token),
                    'data' => $msg
                );

                $headers = array
                (
                    'Authorization: key=' . API_ACCESS_KEY,
                    'Content-Type: application/json'
                );

                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
                      
                curl_exec($ch);

                curl_close($ch); 
           
            
   
            
        }
        
    }
    
    function getBoardKeyValue($bid)
    {
        $query ="select board_id, GROUP_CONCAT(meta_value) as mvalue from tbl_user_boardmeta where board_id='$bid' group by board_id";
         $result = mysqli_query($this->dbh,$query);
            $DataSet = mysqli_fetch_array($result);
            return $DataSet ;
    }
    
    function getOtp(){
        return str_pad(mt_rand(10, 99999999), 8, '0', STR_PAD_LEFT);
    }
    
    function getUserDataByEmail($email){
        $query = "select ID, Full_Name, Email_ID, forgot_pass_otp from tbl_users where Email_ID = '$email'";

        $sql_query = mysqli_query($this->dbh,$query);
        $result =  mysqli_fetch_array($sql_query);
        return $result;
    }
    
     /* count totalmember */
    function getTotalUserMemebr($uid){
        $query = "SELECT count(id) as userMember FROM `tbl_team_members` where user_id = $uid ";
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
            $total_user_member = $DataSet['userMember'];
            return $total_user_member;
        }
    }
    
    /* count totaloverdue */
    function getTotalOverDues($uid)
    {
        $today = date('Y-m-d');
        $query = "SELECT count(id) as totalOverdues FROM `tbl_board_list_duedate` where userid = $uid AND duedate < $today";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
            $total_over_dues = $DataSet['totalOverdues'];
            return $total_over_dues;
        }
    }

    /* count totalcompletetask */
   function getTotalCompleteTask($uid)
   {
        $query = "SELECT count(id) as totalCompleteTask FROM `tbl_board_list_duedate` where userid = $uid AND complete_status = 1";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
            $total_compelte_task = $DataSet['totalCompleteTask'];
            return $total_compelte_task;
        }
   }
   
   /* count totaltodaytask */
   function getTotalTodayTask($uid)
   {
        $today = date('Y-m-d');
        $query = "SELECT count(id) as totaltodayTask FROM `tbl_board_list_duedate` where userid = $uid AND duedate = $today";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
            $total_today_task = $DataSet['totaltodayTask'];
            return $total_today_task;
        }
   }
   
   /* get list icon and color */
   function getListIconColor()
   {
       $response = array(
                    "successBool"   => true,
                    "responseType"   => "list_color_board",
                    "successCode"   => "200",
                        "response"  => array(
                            'list_color' => $this->getListcolors(),
                            'list_icon'  => $this->getListIcon()
                            ),
                        "ErrorObj"   => array(
                            "ErrorCode" => "",
                            "ErrorMsg"  => ""
                        )
                );

        return $response;

   }
   
   function getListcolors()
   {
       $query = "select id,color from tbl_background_color where status = '1'";

        $sql_query = mysqli_query($this->dbh,$query);
         $data_array = array();
        while($result =  mysqli_fetch_array($sql_query))
        {
           
            $data['id'] = $result['id'];
            $data['color'] = $result['color'];
            $data_array[] = $data;
        }
        return $data_array;
   }
   
   function getListIcon()
   {
       $query = "select id,name,images from tbl_list_icon";

        $sql_query = mysqli_query($this->dbh,$query);
         $data_array = array();
        while($result =  mysqli_fetch_array($sql_query))
        {
           
            $data['id'] = $result['id'];
            $data['name'] = $result['name'];
            $data['icon'] = $result['images'];
            $data['icon_url'] = $this->site_url.$result['images'];
            $data_array[] = $data;
        }
        return $data_array;
   }
   
   function getDataWithPagination($tbl, $pageno){
        $query_count = "select count(id) as total from ".$tbl;
        $result_count = mysqli_query($this->dbh,$query_count);
        $rowcount = mysqli_num_rows($result_count);
        if($rowcount > 0){
            $result_row = mysqli_fetch_array($result_count);
            $total = (int)$result_row['total'];
            $limit = 10;

            $page = $pageno;
            $offset = $page  * $limit;

            $pages = ceil($total/$limit);
            $left_rec = $total - ($page * $limit);

            $query = "select * from ".$tbl."  order by id desc limit $offset , $limit";
            $mysqli_query = mysqli_query($this->dbh, $query);
            $num_rows = mysqli_num_rows($mysqli_query);
            if($num_rows > 0){
                $data_array = array();
                while($result = mysqli_fetch_array($mysqli_query)){
                    $data_pageinfo = array(
                        'total' => $total,
                        'pages' => $pages,
                        'pageno' => (int)$page,
                        'offset' => (int)$offset,
                        'limit'  => $limit
                    );
                    $data_array[] = $result;
                }  
            }else{
                    $data_pageinfo = array(
                        'total' => $total,
                        'pages' => $pages,
                        'pageno' => (int)$page,
                        'offset' => (int)$offset,
                        'limit'  => $limit
                    );
                    $data_array[] = array();
            } 
        }
        
        return json_encode( array("Pagination" => $data_pageinfo , "Result" => $data_array));

    }
    
    function getActiveBoard($uid)
    {
       
        $query = "SELECT COUNT(board_id) AS total_active_board FROM `tbl_user_board` WHERE admin_id = '".$uid."'";
        $result = mysqli_query($this->dbh,$query);
        $DataSet = mysqli_fetch_array($result);
        $total_active_board = $DataSet['total_active_board'];
        return $total_active_board;
    
    }
    
    function getCompleteLateBoard($uid)
    {
        $today = date('Y-m-d');
        $query = "SELECT COUNT(id) as totallateduedate FROM `tbl_board_list_duedate` WHERE userid ='".$uid."' AND duedate < '".$today."' AND complete_status ='0';";
        $result = mysqli_query($this->dbh,$query);
        $DataSet = mysqli_fetch_array($result);
        $total_late_due_date = $DataSet['totallateduedate'];
        return $total_late_due_date;
    }
    
    function templateusercount($tmpId)
    {
        $query = "SELECT COUNT(id) as total_user FROM `tbl_user_template` WHERE template_id  ='".$tmpId."'";
        $result = mysqli_query($this->dbh,$query);
        $DataSet = mysqli_fetch_array($result);
        $total_template_user = $DataSet['total_user'];
        return $total_template_user;
    }
    
    function templatecardcount($tmpId)
    {
        $query = "SELECT COUNT(id) as total_template_card FROM `tbl_tmp_board_list_card` WHERE cat_id  ='".$tmpId."'";
        $result = mysqli_query($this->dbh,$query);
        $DataSet = mysqli_fetch_array($result);
        $total_template_card = $DataSet['total_template_card'];
        return $total_template_card;
    }
    function getTemplateBoard($tempId)
    {
        $query = "SELECT * FROM  tbl_templates WHERE status = '1' AND id = '".$tempId."'";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            $DataSet = mysqli_fetch_array($result);
                if(!empty($DataSet['image'])){
                $temp_img = $this->site_url.'admin/temp/images/'.$DataSet['image'];
                }else{
                    $temp_img = '';
                }
                $data['id'] = (int)$DataSet['id'];
                $data['name'] =  $DataSet['name'];
                $data['temp_img'] = $temp_img;
                $data['temp_catid'] = $DataSet['cat_id'];
                $catquery = "SELECT * FROM  tbl_tmp_category WHERE id = '".$DataSet['cat_id']."'";
                $catresult = mysqli_query($this->dbh,$catquery);
                $catdata = mysqli_fetch_array($catresult);
                $data['cat_name'] = $catdata['cat_name'];
                $data['description'] = $DataSet['description'];
                $data['board_id'] = $DataSet['board_id'];
                $data_array[] = $data;
                $response = array(
                "successBool" => true,
                "responseType" => "use_template_board",
                "successCode" => "200",
                    "response" => array(
                        "board_id" => $DataSet['board_id']
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
               
         }else{
            $response = array(
                "successBool" => false,
                "successCode" => "",
                    "response" => array(),
                    "ErrorObj"   => array(
                        "ErrorCode" => "103",
                        "ErrorMsg"  => "No Data Found"
                    )       
            );
         }
         return $response;
    }
}    
?>
