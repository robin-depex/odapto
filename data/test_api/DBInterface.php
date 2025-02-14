<?php
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

     function getVcodeEnv($env){
        $sql = "SELECT v_code,APIKey from api_version where env = '$env' ";
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
	function chkUserDevice($uid,$dev_id,$type){
        $query = "select id from tbl_user_device where user_id = $uid and type = '$type' and device_id = '$dev_id' ";
         $sql_query = mysqli_query($this->dbh,$query);
        $result =  mysqli_num_rows($sql_query);
        return $result;
    }

    /* get user token */
    function getUDToken($uid,$dev_id,$type){
        $query = "select token from tbl_user_device where user_id = $uid and type = '$type' and device_id = '$dev_id' ";
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
                    "ErrorMsg"  => "Invalid Verification Code"
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

    public function chkLogin($emailid,$passwd,$type,$dev_id,$push_token){
        
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
        
        $query = "SELECT * FROM tbl_users WHERE Email_ID = '$emailid' AND User_Password = '$passwd'";
        
        $result = mysqli_query($this->dbh,$query);

        if( mysqli_num_rows( $result ) > 0 ){
            $query_result = mysqli_fetch_assoc($result);
            $userid = $query_result['ID'];

        if($query_result['status'] == "1"){
            
            $status = $this->chkUserDevice($userid,$dev_id,$type);
            if($status == 0){
            $data = array(
                'user_id' => $userid,
                'type' => $type,
                'device_id' => $dev_id
            );
            $this->insert('tbl_user_device',$data);

            $date = date("Y-m-d H:i:s");    
            $token = md5($date);
            $cond = array(
                'user_id'   => $userid,
                'type'      => $type,
                'device_id' => $dev_id
            );
            $update_data = array("token" => $token,'add_date' => $date,'status'=>1,'push_token' => $push_token);
            $update = $this->update("tbl_user_device",$update_data, $cond);

            $token = $this->getUDToken($userid,$dev_id,$type);
            
            $result = array(
                "successBool" => true,
                "successCode" => "200",
                "response" => array(
                'message'=>'You are successfully loggedin',
                'user_id' => $query_result['ID'],
                'user_email' => $query_result['Email_ID'],
                'fullname' => $query_result['Full_Name'],
                'userToken' => $token
                ),
                "ErrorObj"   => array(
                    "ErrorCode" => "",
                    "ErrorMsg"  => ""
                )       
            );
             
        }else{

            $date = date("Y-m-d H:i:s");    
            $token = md5($date);
            $cond = array(
                'user_id'   => $userid,
                'type'      => $type,
                'device_id' => $dev_id

            );
            $update_data = array("token" => $token,'add_date' => $date,'status'=>1,'push_token' => $push_token);
            $update = $this->update("tbl_user_device",$update_data, $cond);
             $token = $this->getUDToken($userid,$dev_id,$type);
            
            $result = array(
                "successBool" => true,
                "successCode" => "200",
                "response" => array(
                'message'=>'You are successfully loggedin',
                'user_id' => $query_result['ID'],
                'user_email' => $query_result['Email_ID'],
                'fullname' => $query_result['Full_Name'],
                'userToken' => $token
                ),
                "ErrorObj"   => array(
                    "ErrorCode" => "",
                    "ErrorMsg"  => ""
                )       
            );
             
        }
       
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
        //echo $query; die();
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
        $query = "SELECT GROUP_CONCAT(meta_key) as mkey , GROUP_CONCAT(meta_value) as mvalue FROM tbl_usermeta WHERE user_id = $uid";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
            $key = explode(",", $DataSet['mkey']);
            $value = explode(",", $DataSet['mvalue']);
            $data = array_combine($key, $value);
            return $data;
        }
    }


    function getUserBoard($uid,$pageno){
       
       $return_results_top = array();
       $query = "SELECT count(board_id) as total  FROM `tbl_user_board` WHERE admin_id = $uid";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            
            $result_row = mysqli_fetch_array($result);
            $total = (int)$result_row['total'];
            $limit = 15;
            if($pageno == ""){
            
            $page = 0;
            $offset = 0;

            $pages = ceil($total/$limit);
            $left_rec = $total - ($page * $limit);
            
            $query = "select ub.*, GROUP_CONCAT(ubm.meta_key) as mkey, GROUP_CONCAT(ubm.meta_value) as mvalue from tbl_user_board as ub , tbl_user_boardmeta as ubm where ub.admin_id = $uid and ub.board_id = ubm.board_id group by ub.board_title";    

            }else{
                
            $page = $pageno;
            $offset = $page  * $limit;

            $pages = ceil($total/$limit);
            $left_rec = $total - ($page * $limit);
            
            $query = "select ub.*, GROUP_CONCAT(ubm.meta_key) as mkey, GROUP_CONCAT(ubm.meta_value) as mvalue from tbl_user_board as ub , tbl_user_boardmeta as ubm where ub.admin_id = $uid and ub.board_id = ubm.board_id group by ub.board_title limit $offset , $limit";    
            } 
            
            

            $result = mysqli_query($this->dbh,$query);
            $data_result = array();
            $num_rows = mysqli_num_rows($result);
            if($num_rows > 0){


            while($DataSet = mysqli_fetch_array($result)){
                $key = explode(",", $DataSet['mkey']);
                array_push($key, "board_title","board_id","board_star","board_type");
                $value = explode(",", $DataSet['mvalue']);
                array_push($value, $DataSet['board_title'],(int)$DataSet['board_id'],(int)$DataSet['board_star'],$DataSet['type']);
                $data = array_combine($key, $value);
                $data_result[] = $data;

                $response = array(
                    "successBool"   => true,
                    "successCode"   => "200",
                        "response"  => array(
                            'total' => $total,
                            'pages' => $pages,
                            'pageno'=> (int)$page,    
                            'offset' => (int)$offset,
                            'limit'   => $limit, 
                            'userBoard'=> $data_result
                        ),
                        "ErrorObj"   => array(
                            "ErrorCode" => "",
                            "ErrorMsg"  => ""
                        )
                ); 
               
            }
        }else{
             $response = array(
                "successBool"   => true,
                "successCode"   => "200",
                    "response"  => array(
                        'total' => 0,
                        'pages' => 0,
                        'pageno'=> 0,    
                        'offset' => 0,
                        'limit'   => 0, 
                        'userBoard'=> array()
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            ); 
        }
           
             
        }else{
             $response = array(
                    "successBool"   => false,
                    "successCode"   => "",
                        "response"  => array(),
                        "ErrorObj"   => array(
                            "ErrorCode" => "101",
                            "ErrorMsg"  => "Donot Have any Board !! Create Board"
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

        $query = "select ub.*, GROUP_CONCAT(ubm.meta_key) as mkey, 
                GROUP_CONCAT(ubm.meta_value) as mvalue from tbl_user_board as ub , tbl_user_boardmeta as ubm 
                where ub.board_id = $bid and ub.board_id = ubm.board_id";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
            $key = explode(",", $DataSet['mkey']);
            array_push($key,"board_title" ,"board_star","board_id","board_type");
            $value = explode(",", $DataSet['mvalue']);  
            array_push($value,$DataSet['board_title'] ,(int)$DataSet['board_star'],(int)$DataSet['board_id'],$DataSet['type']);
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
               $data['team_id'] = (int)$DataSet['tmid'];
               $data['team_name'] = $DataSet['tmname'];
               $bid = $this->getboardId($data['team_id']);
               $board = $this->getBoardListByTid($bid);
               $data['team_board'] = $board;
               $data_array[] = $data;
            }
            $response = array(
                    "successBool"   => true,
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


    function getUserTeamList($uid){
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
            $response = array(
                "successBool"   => true,
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
             
        }else{
                $data_result = array();;
        }
        return $data_result;   
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
    $query = "SELECT id,Full_Name FROM `tbl_users` where Email_ID LIKE '%".$search."%'";
    $result = mysqli_query($this->dbh,$query);
    $data_array = array();
    $num_rows = mysqli_num_rows($result);
    if($num_rows > 0){
    while($final_result = mysqli_fetch_array($result)){
        
        $data['id'] = $final_result['id'];
        $data['userDetails'] = $this->getUserMeta($final_result['id']);
        $data_array[] = $data;
    }
    $response = array(
        "successBool" => true,
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
        $response = array(
        "successBool" => false,
        "successCode" => "",
            "response" => array(),
            "ErrorObj"   => array(
                "ErrorCode" => "105",
                "ErrorMsg"  => "No One found with this email id."
            )       
    ); 
    }
    return $response; 
    
   
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





	function getBoardList($bid){
        $query = "SELECT list_title,list_id FROM tbl_board_list WHERE board_id = $bid";
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                $data['list_title'] = $DataSet['list_title'];
                $data['list_id'] = (int)$DataSet['list_id'];
                $data_array[] = $data;
            }
            $response = array(
                "successBool" => true,
                "successCode" => "200",
                    "response" => array(
                        "totalList" => $rowcount,
                        "boardDetails" => $this->getBoardDetails($bid),
                        "boardList" => $data_array
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
        $query = "SELECT card_title,card_id,def,del_status,card_description FROM tbl_board_list_card WHERE list_id = $lid and def != 1 and del_status != 1";
         $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                $data['card_title'] = $DataSet['card_title'];
                $data['card_id'] = (int)$DataSet['card_id'];
                $data['del_status'] = (int)$DataSet['del_status'];
                $data['cardComments'] = (int)$this->getCardCommentsCount($DataSet['card_id']);
                $data_array[] = $data;
            }
            $response = array(
                "successBool" => true,
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



    /* verify forgot password code */

    function verify_fpcode($uid, $fp_code){
        $query = "select status from  tbl_users where  fp_code='".$fp_code."' and ID = $uid ";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;
    }

    /* get data */
    function getEmail($uid){
        $query = "SELECT Email_ID FROM `tbl_users` WHERE ID = '".$uid."' ";
        $result = mysqli_query($this->dbh,$query);
        $rowresult = mysqli_fetch_array($result);
        return $rowresult['Email_ID'];
    }
  
    /* get user details */

    function get_user_details($uid,$fieldname){
        $query = "SELECT $fieldname from tbl_users where ID = $uid";
        $result = mysqli_query($this->dbh,$query);
        $rowresult = mysqli_fetch_array($result);
        return $rowresult[$fieldname];
    }

}    
?>