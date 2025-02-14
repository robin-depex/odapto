<?php
require_once('common/config.php');
class Database
{
	var $rs;
	var $dbh;

	function Database()
	{
		$this->rs = "";
		$this->dbh = "";
	}

	//Connect to Database
	
function connect(){
		
$host = $_SERVER['SERVER_NAME'];       
if($host == "localhost"){
	    // local Dev Environment Setup  
    $this->dbh = mysqli_connect('localhost', 'root','','depexloa_odapto') 
    or die('Not connected');
}else if($host == "www.hxtechnologies.com"){
// LIVE Dev Environment Setup
$this->dbh = mysqli_connect('localhost', 'depexloa_odapto','TWONv,l@-EIx','depexloa_odapto') or die('Not connected');  

}else{
  $this->dbh = mysqli_connect('localhost', 'odapto','M0S*bLROd,6h','odapto') or die('Not connected');  
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

        if( mysqli_query($this->dbh , $sql ) )
        {
            
            return true;
        }
        else
        {
            return false;
        }
		
    }

//copy template isert date

public function my_insert( $table, $id , $uid ,$date )
    {

        $data="SELECT board_name, board_key, board_url,board_bgcolor,board_bgimage,board_fontcolor FROM tbl_tmp_board where id='".$id."'";
        $result = mysqli_query($this->dbh,$data);
        $rowresult = mysqli_fetch_array($result);


       $query="INSERT INTO $table (`admin_id`, `board_title`, `board_key`, `board_url`, `bg_color`, `bg_img`, `board_fontcolor`,`type`, `createDate`, `ud`, `admin_board_id`)
         VALUES ('".$uid."','".$rowresult[0]."','".$rowresult[1]."','".$rowresult[2]."','".$rowresult[3]."','".$rowresult[4]."','".$rowresult[5]."','PB', '".$date."' ,'".$date."','".$id."')";     
          $result = mysqli_query($this->dbh,$query); 



return true;

        
        
        
    }

//end---------------    



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
        
       if(mysqli_query( $this->dbh , $sql ))
		{
			return true;
		}
		else
		{
			return false;
		}

    }


    public function SingleRecordUpdate( $table, $variables = array(), $where )
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
        
            $sql .= ' WHERE  ID = "'.$where.'"';   
           
      
        
       if(mysqli_query( $this->dbh , $sql ))
        {
            return true;
        }
        else
        {
            return false;
        }

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
         //echo $sql;   
        if(mysqli_query( $this->dbh , $sql ))
		{
			return true;
		}
		else
		{
			return false;
		}
    }
 
 
/* Sending email*/

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
   

    
    // Check email 
    function chkEmail($emailid){
        $sql = "SELECT ID FROM tbl_users WHERE Email_ID = '".$emailid."'";
        $sql_query = mysqli_query($this->dbh,$sql);
        $num_rows =  mysqli_num_rows($sql_query);
        return $num_rows;
    }
    
      public function chkLogin($emailid,$passwd){
        
        if(empty($emailid)){
            return json_encode(array('result'=>'FALSE','message'=>'Please Enter emailid.'));
        }else if(empty($passwd)){
            return json_encode(array('result'=>'FALSE','message'=>'Please Enter password.'));
        }else{
        

        $query = "SELECT * FROM tbl_users WHERE Email_ID = '$emailid' AND User_Password = '$passwd'";
        $result = mysqli_query($this->dbh,$query);
        if( mysqli_num_rows( $result ) > 0 ){
            $query_result = mysqli_fetch_assoc($result);

            session_start();
            $id = session_id();

            $cond = array(
                    "ID" => $query_result['ID']
                );
            $update_data = array("accessTocken" => $id);
            $update = $this->update("tbl_users",$update_data, $cond);
            $_SESSION['user_Id'] = $query_result['Email_ID'];
            if($query_result['status'] == "1"){
                 $results = array(
                    'result'=>'TRUE',
                    'message'=>'You are successfully loggedin',
                    'userId' => $query_result['ID'],
                    'FullName' => $query_result['Full_Name'],
                    'Tocken' => $query_result['accessTocken']
                );
            }else{
                $results = array(
                    'result'=>'FALSE',
                    'message'=>'Please Activate Your Account'
                );
            }
        }else{
            $results =  array('result'=>'FALSE','message'=>'login credential are incorrect please try again !');
        }

        return json_encode($results);   
        }   
    }

    function newUserFbData($token,$uid){
        $query = "SELECT * FROM `tbl_users` WHERE accessTocken = '".$token."' and ID = '".$uid."' ";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data = mysqli_fetch_array($result);
            return $data;
        }
    }


    function getsinglerow($table,$uid){
        $query = "SELECT * FROM $tabl WHERE id=$uid";
        $result = mysqli_query($this->dbh,$query);
        $data = mysqli_fetch_array($result);
        return $data;
       
    }

    function userFbData($fbid){
        $query = "SELECT * FROM `tbl_users` WHERE FBID = '".$fbid."' ";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data = mysqli_fetch_array($result);
            return $data;
        }
    }

    function lastInsertedId($accessToken){
        $query = "select ID from tbl_users where accessTocken = '".$accessToken."'";
        $result = mysqli_query($this->dbh,$query);
        if( mysqli_num_rows( $result ) > 0 ){
            $query_result = mysqli_fetch_object($result);
            $uid = $query_result->ID;
            return $uid;
        }
    }


    function verifyToken($token,$uid){
        $query = "SELECT * FROM `tbl_users` WHERE accessTocken = '".$token."' and ID = '".$uid."' ";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;
    }

    function verifyFpToken($email,$token){
        $query = "SELECT * FROM `tbl_users` WHERE fp_token = '".$token."' and Email_ID = '".$email."' ";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;
    }

    function getData($email){
        $query = "SELECT * FROM `tbl_users` WHERE Email_ID = '".$email."' ";
        $result = mysqli_query($this->dbh,$query);
        $rowresult = mysqli_fetch_array($result);
        return $rowresult['Email_ID'];
    }

     function getNumRows($id,$table){
        $query = "SELECT * FROM $table WHERE board_id = '".$id."' ";
        $result = mysqli_query($this->dbh,$query);
        $rowresult = mysqli_num_rows($result);
        return $rowresult;
    }

     function testToken(){
        $query = "select * from  api_version";
        $result = mysqli_query($this->dbh,$query);
        return $result; 
    }


    // getUserMeta 
    function getUserMeta($uid){
    
        $query = "SELECT GROUP_CONCAT(meta_key) as mkey ,user_id as user_id, GROUP_CONCAT(meta_value) as mvalue FROM tbl_usermeta WHERE user_id = $uid";
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


    function getUserBoard($uid){
       $return_results_top = array();
       $query = "select ub.*, GROUP_CONCAT(ubm.meta_key) as mkey, 
GROUP_CONCAT(ubm.meta_value) as mvalue from tbl_user_board as ub , tbl_user_boardmeta as ubm 
where ub.admin_id = $uid and type='PB' and ub.board_id = ubm.board_id group by ub.board_title";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_result = array();
            while($DataSet = mysqli_fetch_array($result)){
                // echo "<pre/>";
                // var_dump($DataSet);
                $key = explode(",", $DataSet['mkey']);
                array_push($key, "title","board_id","board_star","bg_color","board_fontcolor","bg_img");
                $value = explode(",", $DataSet['mvalue']);
                array_push($value, $DataSet['board_title'],$DataSet['board_id'],$DataSet['board_star'],$DataSet['bg_color'],$DataSet['board_fontcolor'],$DataSet['bg_img']);
                $data = array_combine($key, $value);
                $data_result[] = $data;
            }

            return json_encode(array("BoardData" => $data_result));    
        }
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

    function getTeamDetailsByBoardId($tid){

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
                
               // $return_results_top[] = $data;
            }
            return $data;   
        }
    }

    function getBoardDetails($bid){

        $query = "select ub.*, GROUP_CONCAT(ubm.meta_key) as mkey, 
                GROUP_CONCAT(ubm.meta_value) as mvalue from tbl_user_board as ub , tbl_user_boardmeta as ubm 
                where ub.board_id = $bid and ub.board_id = ubm.board_id";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
            $key = explode(",", $DataSet['mkey']);
            array_push($key,"board_title" ,"board_star","board_id");
            $value = explode(",", $DataSet['mvalue']);  
            array_push($value,$DataSet['board_title'] ,$DataSet['board_star'],$DataSet['board_id']);
            $data = array_combine($key, $value);
            return $data;    
        }
    }


    function getBoardListByTid($bid){
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
               $data['team_id'] = $DataSet['tmid'];
               $data['team_name'] = $DataSet['tmname'];
               $data_array[] = $data;     
            }
             return $data_array;          
        }
    }

    function getUserTeamDetails($uid){
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
            return json_encode(array("starBoardData" => $data_result));    
        }
}
function getOdaptoBoard(){
    $query = "select * from tbl_tmp_board";
     $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_result = array();
            while($DataSet = mysqli_fetch_object($result)){
				if(($DataSet->status) == 1){            
					$data_result[] = $DataSet;
				}
            }
            return json_encode($data_result);    
        }
}

function getInvitedBoard($uid){
    $query = "SELECT bm.board_id ,ub.board_title,ub.board_star, GROUP_CONCAT(ubm.meta_key) as mkey, GROUP_CONCAT(ubm.meta_value) as mvalue FROM tbl_board_members as bm LEFT outer join tbl_user_boardmeta as ubm on ubm.board_id = bm.board_id LEFT outer join tbl_user_board as ub on ub.board_id = bm.board_id WHERE bm.member_id = $uid and bm.member_status = 1 group by board_id";
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
            return json_encode(array("invitedBoardData" => $data_result));    
        }
}

function getBoardAdmin($bid){
    $query = "SELECT admin_id FROM `tbl_user_board` where board_id = $bid";
    $result = mysqli_query($this->dbh,$query);
    $final_result = mysqli_fetch_array($result);
    $adminid = $final_result['admin_id'];
    return $adminid;
}

function findUserByEmail($search){
    $searchemail = explode("@",$search);
    $s = $searchemail[0];
    $query = "SELECT id,Full_Name FROM `tbl_users` where Email_ID LIKE '%".$search."%'";
    $result = mysqli_query($this->dbh,$query);
    $data_array = array();
    $num_rows = mysqli_num_rows($result);
    if($num_rows > 0){
    while($final_result = mysqli_fetch_array($result)){
        
        $data['id'] = $final_result['id'];
        $data['name'] = $final_result['Full_Name'];
        $data_array[] = $data;
    }
    return json_encode(array("result"=>"TRUE","Details"=>$data_array));   
    }else{
        $data['name'] = $s;
        $data['email'] = $search;
         $data['msg'] = "<b style='margin-left:-10px;'>".$search."?</b> We donot know that person. Add a name and click Send and we will add a virtual member and send them an invite email. They'll automatically receive access to the board once they sign up and confirm their email address.";
        $data_array[] = $data;
    }
    return json_encode(array("result"=>"FALSE","Details"=>$data_array));   
}


function getRecentBoard($uid){
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

//single record
	function getBoardList($bid){
        $query1= "SELECT admin_board_id FROM `tbl_user_board` WHERE `board_id`=$bid";
        $result1 = mysqli_query($this->dbh,$query1);
        $DataSet1 = mysqli_fetch_array($result1);
        
        $query = "SELECT list_title,list_id FROM tbl_board_list WHERE board_id = $bid";
        $query02 = "SELECT list_title,id as list_id,bgimage,bgcolor FROM tbl_tmp_board_list WHERE board_id = $DataSet1[0]";
        
       
        $result = mysqli_query($this->dbh,$query);
        $result12 = mysqli_query($this->dbh,$query02);
        $rowcount1 = mysqli_num_rows($result12);
        $rowcount = mysqli_num_rows($result);
        $data_array = array();
        //$data_array1 = array();
        if($rowcount > 0){
            
            while($DataSet = mysqli_fetch_array($result)){
                $data['list_title'] = $DataSet['list_title'];
                $data['list_id'] = $DataSet['list_id'];
                $data['bgimage'] = '';
                $data['bgcolor'] = '#f7f7f7';
                $data_array[] = $data;
            }
         }
         if($rowcount1>0){
            while($DataSet = mysqli_fetch_array($result12)){
                $data['list_title'] = $DataSet['list_title'];
                $data['list_id'] = $DataSet['list_id'];
                $data['bgimage'] = $DataSet['bgimage'];
                $data['bgcolor'] = $DataSet['bgcolor'];
                $data_array[] = $data;
            }
         }
       return $data_array;  
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
        
        $query = "SELECT card_title,card_id,def,del_status,stickers FROM tbl_board_list_card WHERE list_id = $lid";
        $admincard = "SELECT card_name as card_title,id as card_id,def,del_status as del_status,stickers FROM tbl_tmp_board_list_card WHERE list_id = $lid";

        $admin_result = mysqli_query($this->dbh,$admincard);
        $result = mysqli_query($this->dbh,$query);
        $admin_rowcount = mysqli_num_rows($admin_result);
        $rowcount = mysqli_num_rows($result);
        $data_array = array();
        if($rowcount > 0){
             //$data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                $data['card_title'] = $DataSet['card_title'];
                $data['card_id'] = $DataSet['card_id'];
                $data['def'] = $DataSet['def'];
                $data['del_status'] = $DataSet['del_status'];
                $data['stickers'] = $DataSet['stickers'];
                $data_array[] = $data;
            }
         }

        if($admin_rowcount > 0){
            //$data_array = array();
            while($DataSet = mysqli_fetch_array($admin_result)){

                $data['card_title'] = $DataSet['card_title'];
                $data['card_id'] = $DataSet['card_id'];
                $data['def'] = $DataSet['def'];
                $data['del_status'] = $DataSet['del_status'];
                $data['stickers'] = $DataSet['stickers'];
                $data_array[] = $data;

                    
              }
            
     }
    return array("cardList" => $data_array);   
        
    }

    function ChkInviteToken($token){
        $query = "SELECT id FROM tbl_board_invite WHERE invite_token = '$token' ";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_fetch_array($result);
        return $rowcount['id'];   
    }
    function ChkTeamInviteToken($token){
        $query = "SELECT id FROM tbl_team_invite WHERE invite_token = '$token' ";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_fetch_array($result);
        return $rowcount['id'];   
    }
    
    function ChkInviteMember($mid,$bid){
        $query = "SELECT id FROM tbl_board_invite WHERE member_id = '$mid' and bid = $bid";
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
                $data['list_id'] = $results['list_id'];
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

    function getLastChecklist($ckey){
        $query = "SELECT id,userid,checklist,date_time FROM tbl_board_list_card_checklist where ckey = '".$ckey."' order by id DESC"; 
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


     function getLastChecklistItem(){
        $query = "SELECT * FROM tbl_board_list_card_checklist_item
 ORDER BY id DESC 
LIMIT 1"; 
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        $data_array = array();
        while ($results = mysqli_fetch_array($sql_query)) {
            $data['id'] = $results['id'];
            $data['item_name'] = $results['item_name'];
            
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
            return $members;
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

    /* get All List by boardID*/

    /* get All labels */
    function getAlllabels(){
        $query = "SELECT label_text,color,id FROM tbl_labels order by rand() limit 6";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            while($result = mysqli_fetch_array($sql_query)){
                $data['label_text'] = $result['label_text'];
                $data['color'] = $result['color'];
                $data['label_id'] = $result['id'];
                $data_array[] = $data;
            }
            return $data_array;
        }
    } 

    /* get Label Details */

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

    /* Last Inserted Label */
    function getLastInsertedLabels($ckey){
        $query = "SELECT * FROM `tbl_board_list_card_labels` WHERE `ckey` = '$ckey'";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            while($result = mysqli_fetch_array($sql_query)){
                $data['labels'] = $result['labels'];
                $data['id'] = $result['id'];
                $data['cardid'] = $result['cardid'];
                $data_array[] = $data;
            }
            return $data_array;
        }
    }


    /* get All labels */
    function EditAlllabels(){
        $query = "SELECT label_text,color,id FROM tbl_labels";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            while($result = mysqli_fetch_array($sql_query)){
                $data['label_text'] = $result['label_text'];
                $data['color'] = $result['color'];
                $data['label_id'] = $result['id'];
                $data_array[] = $data;
            }
            return $data_array;
        }
    } 

    /* check label text exists */

    function checkLabelText($uid,$lid){
        $query = "SELECT id FROM tbl_label_users where user_id = $uid and label_id = $lid";
        $sql_query = mysqli_query($this->dbh, $query);
        $numrows = mysqli_num_rows($sql_query);
        return $numrows;
    }


    /* get label text exists */

    function getLabelText($uid,$lid){
        $query = "SELECT label_name FROM tbl_label_users where user_id = $uid and label_id = $lid";
        $sql_query = mysqli_query($this->dbh, $query);
        $numrows = mysqli_num_rows($sql_query);
        if($numrows > 0){
            $result = mysqli_fetch_array($sql_query);
            $label_text = $result['label_name'];
            return $label_text;
        }
    }

    function getLabelId($label){
        $query = "SELECT id FROM tbl_labels where color = '$label' ";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            $result = mysqli_fetch_array($sql_query);
            $label_id = $result['id'];
            return $label_id;
        }
    } 

    /* check label exists */

    function checkCardLabel($uid,$cid,$label){
        $query = "SELECT id FROM tbl_board_list_card_labels
        where userid = $uid and cardid = $cid and labels = '$label' ";
        $sql_query = mysqli_query($this->dbh, $query);
        $numrows = mysqli_num_rows($sql_query);
        return $numrows;
    }

    /* last inserted Image */
    function getLastImage($ckey){
        $query = "SELECT * FROM tbl_board_list_card_attachements WHERE ckey = '$ckey'";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            while($result = mysqli_fetch_array($sql_query)){
                $data['image'] = $result['attachments'];
                $data['id'] = $result['id'];
                $data_array[] = $data;
            }
            return $data_array;
        }
    }

    /* Cover images */

    function getCoverImage($cardid){
        $query = "select attachments FROM tbl_board_list_card_attachements where cover_image = 1 and status = 1 and cardid = $cardid";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            while($result = mysqli_fetch_array($sql_query)){
                $data['cover'] = $result['attachments'];
                $data_array[] = $data;
            }
            return $data_array;
        }
    }


    /* Get cardImageCount */
    function cardImageCount($cardid){
        $query = "select count(attachments) as total FROM tbl_board_list_card_attachements where status = 1 and cardid = $cardid";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $result = mysqli_fetch_array($sql_query);
            $total = $result['total'];
            return $total;
        }
    }

    /* AllCardAttachments */
    function allCardAttachments($cardid){
        $query = "select attachments,id,cover_image FROM tbl_board_list_card_attachements where status = 1 and cardid = $cardid";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            while($result = mysqli_fetch_array($sql_query)){
                $data['id'] = $result['id'];
                $data['cover'] = $result['cover_image'];
                $data['images'] = $result['attachments'];
                $data_array[] = $data;
            }
            return $data_array;
        }
    }

    /* update cover */
    public function cover_update($table,$ckey,$cardid){
        $sql = "UPDATE  $table SET cover_image = 0 WHERE ckey !=  '$ckey' AND cardid =$cardid";
        if(mysqli_query( $this->dbh , $sql ))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    
    function get_user_details($uid,$fieldname){
        $query = "SELECT $fieldname from tbl_users where ID = $uid";
        $result = mysqli_query($this->dbh,$query);
        $rowresult = mysqli_fetch_array($result);
        return $rowresult[$fieldname];
    }


    /* board color  */

    function get_board_background($bid){
        $query = "select bg_color, bg_img,bg_type from tbl_user_board where board_id = $bid";
        $result = mysqli_query($this->dbh,$query);
        $rowresult = mysqli_fetch_array($result);
        return $rowresult;
    }

    /* board background Image */
    function get_board_bg_img(){
        $query = "SELECT `image` FROM `tbl_templates`  where status = 1";
        $result = mysqli_query($this->dbh,$query);
        $data_array = array();
        while($rowresult = mysqli_fetch_array($result)){
            $data_array[] = $rowresult['image'];
        }
       
        return $data_array; 
    }


    function userdata(){
        $query = "SELECT * FROM  `tbl_users`   where id = '".$_SESSION['sess_login_id']."'";
        $result = mysqli_query($this->dbh,$query);
        
        while($rowresult = mysqli_fetch_array($result)){
          return $rowresult;  
        }
       
        
    }


    function my_data($table){
        $query = "SELECT * FROM  $table";
        $result = mysqli_query($this->dbh,$query);
        $data_array = array();
        while($rowresult = mysqli_fetch_array($result)){
                $data['id'] = $rowresult['id'];
                $data['images'] = $rowresult['images'];
                
                $data_array[] = $data;
         
        }
  return $data_array; 

            
            }


    function AlldataUser(){
        $query = "SELECT * FROM tbl_users  WHERE `status`=1";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $userId = array();
                while($userData = mysqli_fetch_array($result)){
                  array_push($userId,$userData['ID']);

                } 
                 return $userId;
        }
    }


    function BoardCardMembers($value){
        $query = "SELECT * FROM tbl_board_card_members where Menber=$value";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
           $data=$DataSet['Menber'];
            return $data;
        }
    }


     function membersAjax(){
        $query = "SELECT * FROM tbl_board_card_members";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        $membersAjax=array();
        if($rowcount > 0){
         while($DataSet = mysqli_fetch_array($result)){
            array_push($membersAjax,$DataSet['user_id']);
         }
           
            return $membersAjax;
        }
    }


    // getUserMeta 
    function ajaxrecord($uid){
   
        $query = "SELECT GROUP_CONCAT(meta_key) as mkey , GROUP_CONCAT(meta_value) as mvalue FROM tbl_usermeta as tbu JOIN tbl_board_card_members as cdm on cdm.user_id=tbu.user_id where ";

        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        $mydata=array();
        if($rowcount > 0){
           while( $DataSet = mysqli_fetch_array($result)){
            $key = explode(",", $DataSet['mkey']);
            $value = explode(",", $DataSet['mvalue']);
            $data = array_combine($key, $value);
            $mydata[]=$data;
           }

           return $mydata; 
        }
    }
    
}    
?>