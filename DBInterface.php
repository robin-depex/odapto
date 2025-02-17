<?php
require_once('common/config.php');



class Database
{
    var $rs;
    var $dbh;

   
    function __construct()
    {
        $this->rs = "";
        $this->dbh = "";
        $this->site_url='https://www.odapto.com/';
    }

    //Connect to Database
    
function connect(){
        
$host = $_SERVER['SERVER_NAME'];       
//echo $host;die;
if($host == "localhost"){
        // local Dev Environment Setup  
    $this->dbh = mysqli_connect('localhost', 'root','','depexloa_odapto') 
    or die('Not connected');
}else if($host == "www.hxtechnologies.com"){
// LIVE Dev Environment Setup
$this->dbh = mysqli_connect('localhost', 'depexloa_odapto','TWONv,l@-EIx','depexloa_odapto') or die('Not connected');  
}else{
  $this->dbh = mysqli_connect('localhost', 'odapto_odapto','(F-HPS!r0-[+','odapto_odapto') or die('Not connected123');  
 // $this->dbh = mysqli_connect('localhost', 'depexloa_odapto','odapto123','depexloa_odapto') or die('Not connected');  
} 
           
return $this->dbh;
}   

/*Pooja Code start*/

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
    
      function get_sqldata($sql){
        $query = mysqli_query($this->dbh,$sql);
        $rowCount = mysqli_num_rows($query);
        if($rowCount>0){
            while($fetchData = mysqli_fetch_array($query)){
                $dataArray[] = $fetchData;
            }
            return $dataArray;
        }
    }


    function get_data($table,$where){
$sql = "SELECT * FROM $table";

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
        $query = mysqli_query($this->dbh,$sql);
        $rowCount = mysqli_num_rows($query);
        if($rowCount>0){
            while($fetchData = mysqli_fetch_array($query)){
                $dataArray[] = $fetchData;
            }
            return $dataArray;
        }
    }

    function get_single_data($table,$where){
$sql = "SELECT * FROM $table";

 if( !empty( $where ) )
        {
            foreach( $where as $field => $value )
            {
                $value = $value;

                $clause[] = "$field = '$value'";
            }
            $sql .= ' WHERE '. implode(' AND ', $clause);   
           
        }

        $query = mysqli_query($this->dbh,$sql);
        $rowCount = mysqli_num_rows($query);
        if($rowCount>0){
            $fetchData = mysqli_fetch_array($query);
                $dataArray = $fetchData;
                  return $dataArray;
            }
          
        }
        
        
        
         function get_query_data($sql){
//echo $sql;

        $query = mysqli_query($this->dbh,$sql);
        $rowCount = mysqli_num_rows($query);
     //  echo $rowCount;
        if($rowCount>0){
            $fetchData = mysqli_fetch_array($query);
          //  print_r($fetchData);
                $dataArray = $fetchData;
                  return $dataArray;
            }
          
        }

    

    function chkEmail($emailid){
        $sql = "SELECT ID FROM tbl_users WHERE Email_ID = '".$emailid."'";
        $sql_query = mysqli_query($this->dbh,$sql);
        $num_rows =  mysqli_num_rows($sql_query);
        return $num_rows;
    }
    
    // dc code 
    
    function getName($id){
        $sql = "SELECT Full_Name FROM tbl_users WHERE ID = '".$id."'";
        $sql_query = mysqli_query($this->dbh,$sql);
        
        $row=mysqli_fetch_array($sql_query);
       
        return $row['Full_Name'];
    }
    function getEmail($id){
        $sql = "SELECT Email_ID FROM tbl_users WHERE ID = '".$id."'";
        $sql_query = mysqli_query($this->dbh,$sql);
         $row=mysqli_fetch_array($sql_query);
       
        return $row['Email_ID'];
    }
    //end dc code
    
    
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
          
            if($query_result['user_verify_status'] == "1"){
                  if($query_result['status'] == 1){
                      $update = $this->update("tbl_users",$update_data, $cond);
            $_SESSION['user_Id'] = $query_result['Email_ID'];
                $results = array(
                    'result'=>'TRUE',
                    'message'=>'You are successfully loggedin',
                    'userId' => $query_result['ID'],
                    'FullName' => $query_result['Full_Name'],
                    'Tocken' => $query_result['accessTocken'],
                    'membership_plan' => $query_result['membership_plan']
                );
                  }else{
                $results = array(
                    'result'=>'FALSE',
                    'message'=>'Please Activate Your Account, mail sent on your email',
                    'user_email_id' => ''
                    
                );
                  }
                 
            }else{
                $results = array(
                    'result'=>'FALSE',
                    'message'=>'Please Verify Your Account',
                    'user_email_id' => $query_result['Email_ID']
                );
            }
        }else{
            $results =  array(
                'result'=>'FALSE',
                'message'=>'login credential are incorrect please try again !',
                'user_email_id' =>''
                );
        }

        return json_encode($results);   
        }   
    }

function getStaredBoard($uid){
    $set_mode = "SET sql_mode = ''";
          $resultss = mysqli_query($this->dbh,$set_mode);
    $query = "select ub.*, group_concat(ubm.meta_key) as mkey , group_concat(ubm.meta_value) as mvalue from tbl_user_board as ub , tbl_user_boardmeta as ubm where ub.admin_id = $uid and ub.board_star = 1 and ub.board_id = ubm.board_id group by board_key";
    //echo $query;die;
     $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_result = array();
            while($DataSet = mysqli_fetch_array($result)){
                $key = explode(",", $DataSet['mkey']);
                array_push($key, "title","board_id","board_star","bg_color","bg_img","board_fontcolor");
                $value = explode(",", $DataSet['mvalue']);
                array_push($value, $DataSet['board_title'],$DataSet['board_id'],$DataSet['board_star'],$DataSet['bg_color'],$DataSet['bg_img'],$DataSet['board_fontcolor']);
                $data = array_combine($key, $value);

                $data_result[] = $data;
            }
            return json_encode(array("starBoardData" => $data_result));    
        }
}

function getBoardKeyValue($bid)
{
    $query ="select board_id, GROUP_CONCAT(meta_value) as mvalue from tbl_user_boardmeta where board_id='$bid' group by board_id";
     $result = mysqli_query($this->dbh,$query);
        $DataSet = mysqli_fetch_array($result);
        return $DataSet ;
}


function getInvitedBoard($uid){
    $set_mode = "SET sql_mode = ''";
    $resultss = mysqli_query($this->dbh,$set_mode);
    $query = "SELECT bm.board_id ,ub.board_title,ub.board_star,ub.bg_color,ub.bg_img,ub.board_fontcolor, GROUP_CONCAT(ubm.meta_key) as mkey, GROUP_CONCAT(ubm.meta_value) as mvalue FROM tbl_board_members as bm LEFT outer join tbl_user_boardmeta as ubm on ubm.board_id = bm.board_id LEFT outer join tbl_user_board as ub on ub.board_id = bm.board_id WHERE bm.member_id = $uid AND bm.user_id != bm.member_id  and bm.member_status = 1 group by board_id";
    $result = mysqli_query($this->dbh,$query);
    $rowcount = mysqli_num_rows($result);
    if($rowcount > 0){
        $data_result = array();
        while($DataSet = mysqli_fetch_array($result)){
                $key = explode(",", $DataSet['mkey']);
                array_push($key, "title","board_id","board_star","bg_color","bg_img","board_fontcolor");
                $value = explode(",", $DataSet['mvalue']);
                array_push($value, $DataSet['board_title'],$DataSet['board_id'],$DataSet['board_star'],$DataSet['bg_color'],$DataSet['bg_img'],$DataSet['board_fontcolor']);
                $data = array_combine($key, $value);
                
                $data_result[] = $data;
            }
            return json_encode(array("invitedBoardData" => $data_result));    
        }
}


function getOdaptoBoard(){
    $query = "select * from tbl_templates order by id desc limit 11";
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

/*Pooja Code end*/




     function getlast_insertlist($board_id){
        $query = "select list_id from  tbl_board_list where  board_id='".$board_id."' order by list_id desc";
       // echo $query;die;
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data = mysqli_fetch_array($result);
            $list_id = $data['list_id'];
            return $list_id;
        }

    }

//copy template isert date

public function my_insert($id , $uid ,$date )
    {

        $data="SELECT board_name, board_key, board_url,board_bgcolor,board_bgimage,board_fontcolor FROM tbl_tmp_board where id='".$id."'";
        $result = mysqli_query($this->dbh,$data);
        while($rowresult = mysqli_fetch_array($result))
        {
            $board_key=$this->generateRandomString();
       //$rowresult[4]='http://www.odapto.com/admin/temp/images/'.$rowresult[4];
        $board_insert=array(
            'admin_id'=>$uid,
            'board_title'=>$rowresult['board_name'],
            'board_key'=>$board_key,
            'board_url'=>$rowresult['board_url'],
            'bg_color'=>$rowresult['board_bgcolor'],
            'board_fontcolor'=>$rowresult['board_fontcolor'],
            'type'=>'PB',
            'admin_board_id'=>$id,
            'bg_img'=>'http://www.odapto.com/admin/temp/images/'.$rowresult['board_bgimage'],

            );
        $this->insert('tbl_user_board',$board_insert);
        $bid = $this->getLastInsertedBoard($uid);

         $listquery="SELECT *from tbl_tmp_board_list where board_id=$id";
        // echo $listquery;die;
        $result = mysqli_query($this->dbh,$listquery);
         $rowcount = mysqli_num_rows($result);
         if($rowcount>0)
         {
            while($rowresult = mysqli_fetch_array($result))
            {

            //$data_array[]=$rowresult;
           // print_r($rowresult);die;
             $list_id=$rowresult['id'];
             $list_insert=array(
            'board_id'=>$bid,
            'list_title'=>$rowresult['list_title'],
            'listkey'=>$rowresult['list_key'],
                  );

        $this->insert('tbl_board_list',$list_insert);
      $last_insertlist = $this->getlast_insertlist($bid);

         $card_insert="SELECT *from tbl_tmp_board_list_card  where list_id=$list_id";
         //echo $card_insert;die;
        $result = mysqli_query($this->dbh,$card_insert);
        $rowcount = mysqli_num_rows($result);
         if($rowcount>0)
         {
              while($rowresult = mysqli_fetch_array($result))
        {
         $card_insertdata=array(
            'list_id'=>$last_insertlist,
            'card_description'=>$rowresult['card_description'],
            'card_title'=>$rowresult['card_name'],
            'stickers'=>$rowresult['stickers'],
                  );

         //print_r($card_insertdata);die;

        $this->insert('tbl_board_list_card',$card_insertdata);

        }
         }
      

        }
         }
        


    }

return true;
   
        
    }

//end---------------    



    // update 
    


    public function SingleRecordUpdate( $table, $where,$variables = array() )
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
    

 
 
/* Sending email*/

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

function sendEmail($subject,$message,$email){

/*require_once('phpmailer/PHPMailerAutoload.php');
$mail = new PHPMailer;

//$mail->isSMTP(); // enable SMTP
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
 $mail->protocol = 'sendmail';
 $mail->mailpath = '/usr/sbin/sendmail';
$mail->Host = "ssl://smtp.googlemail.com";
$mail->Port = 465; // or 587
$mail->isHTML(true);
$mail->Username = "rohit.depex@gmail.com";
$mail->Password = "Rohit@depex#";
$mail->setFrom("business@odapto.com","Odapto Team");

$mail->Subject = $subject;
$mail->Body = $message;
$mail->addAddress($email);*/

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <admin@odapto.com>' . "\r\n";

//mail($to,$subject,$message,$headers);

$sendmail = mail($email,$subject,$message,$headers);

/*if(!$mail->Send()) {
    $response = "Mailer Error: " . $mail->ErrorInfo;
} else {
    $response = 1;
}*/
return $sendmail;

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


    function newUserFbData($token,$uid){
        $query = "SELECT * FROM `tbl_users` WHERE ID = '".$uid."' ";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data = mysqli_fetch_array($result);
            return $data;
        }
    }

      function gettotalchecklistitem($tbl,$fname,$fval){
        $query = "SELECT * FROM $tbl WHERE $fname = '".$fval."'";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;
    }

      function gettotalchecklistitemcheck($tbl,$fname,$fval){
        $query = "SELECT * FROM $tbl WHERE $fname = '".$fval."' AND status = 1";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;
    }

    function getsingledata($tablname,$fldname,$fldval){
$query = "SELECT * FROM $tablname WHERE $fldname='$fldval'";
//echo $query;
        $result = mysqli_query($this->dbh,$query);
        $data = mysqli_fetch_array($result);
        return $data;
    }
    
    function getAdminId($tablname){
    $query = "SELECT id FROM $tablname order by id desc limit 1";
    //echo $query;
            $result = mysqli_query($this->dbh,$query);
            $data = mysqli_fetch_array($result);
            return $data;
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
    function getIdandAccesstoken($email){
        $query = "select ID,accessTocken from tbl_users where Email_ID = '".$email."'";
        $result = mysqli_query($this->dbh,$query);
        if( mysqli_num_rows( $result ) > 0 ){
            $query_result = mysqli_fetch_array($result);
            
            return $query_result;
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
        //echo $query;die;
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
        $set_mode = "SET sql_mode = ''";
          $resultss = mysqli_query($this->dbh,$set_mode);
       $return_results_top = array();
       $query = "select ub.*, GROUP_CONCAT(ubm.meta_key) as mkey, 
GROUP_CONCAT(ubm.meta_value) as mvalue from tbl_user_board as ub , tbl_user_boardmeta as ubm 
where ub.admin_id = $uid and type='PB' and ub.board_id = ubm.board_id group by ub.board_key";
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
        //echo $query;die;
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
        $set_mode = "SET sql_mode = ''";
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
            array_push($key,"board_title" ,"board_star","board_id","bg_img");
            $value = explode(",", $DataSet['mvalue']);  
            array_push($value,$DataSet['board_title'] ,$DataSet['board_star'],$DataSet['board_id'],$DataSet['bg_img']);
            $data = array_combine($key, $value);
          //  print_r($data);
            return $data;    
        }
    }

    function getfieldvisedata($table,$fname,$fval){
   $query = "select * FROM $table WHERE $fname = '$fval'";
    $result = mysqli_query($this->dbh,$query);
    while($DataSet = mysqli_fetch_array($result)){
        $dataarray[] = $DataSet;
    }
    return $dataarray;
    }


    function getBoardListByTid($bid){
        $set_mode = "SET sql_mode = ''";
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
                array_push($key, "board_star","board_id","board_title","bg_color","bg_img");
                $value = explode(",", $DataSet['mvalue']);  
                array_push($value, $DataSet['board_star'],$DataSet['board_id'],$DataSet['board_title'],$DataSet['bg_color'],$DataSet['bg_img']);
                $data = array_combine($key, $value);
                $data_array[] = $data; 
               }
            }  else {
                $data_array[] = array();
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

       function getbordlistduedate($cardid){
        $query = "select * FROM tbl_board_list_duedate WHERE card_id = '".$cardid."'";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
       
            $data_array = array();
          $DataSet = mysqli_fetch_array($result);
            /*   $data['team_id'] = $DataSet['tmid'];
               $data['team_name'] = $DataSet['tmname'];
               $data_array[] = $data;   */  
          
             return $DataSet;          
      
    }

    function getUserTeamDetails($uid){
        $set_mode = "SET sql_mode = ''";
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


function getUserTeamDetails1($uid){
    $set_mode = "SET sql_mode = ''";
          $resultss = mysqli_query($this->dbh,$set_mode);
        $return_results_top = array();
       // $query = "select tm.* , GROUP_CONCAT(utm.meta_key) as mkey, GROUP_CONCAT(utm.meta_value) as mvalue from tbl_user_team as tm , tbl_user_teammeta as utm INNER JOIN tbl_team_members ON tm.id=tbl_team_members.team_id where tbl_team_members.member_id = $uid and utm.team_id = tm.id group by tm.team_name";
        $query = "select tbl_user_team.* , GROUP_CONCAT(tbl_user_teammeta.meta_key) as mkey, GROUP_CONCAT(tbl_user_teammeta.meta_value) as mvalue from tbl_user_team INNER JOIN tbl_team_members ON tbl_user_team.id=tbl_team_members.team_id, tbl_user_teammeta where tbl_team_members.member_id = $uid and tbl_user_teammeta.team_id = tbl_user_team.id group by tbl_user_team.team_name";
       // echo $query;
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

function getLastInsertedTempBoard(){
    $query = "SELECT id FROM `tbl_tmp_board` ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($this->dbh,$query);
    $DataSet = mysqli_fetch_array($result);
    $tbid = $DataSet['id'];
    return $tbid;
    
}

function getLastInsertedTempId(){
    $query = "SELECT id FROM `tbl_template` ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($this->dbh,$query);
    $DataSet = mysqli_fetch_array($result);
    $tempid = $DataSet['id'];
    return $tempid;
    
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
  $query = "SELECT * FROM `tbl_users` where Email_ID LIKE '".$search."%'";
  // $query = "SELECT * FROM `tbl_users` where Email_ID = '".$search."'";
    $result = mysqli_query($this->dbh,$query);
    $data_array = array();
    $num_rows = mysqli_num_rows($result);
    if($num_rows > 0){
    while($final_result = mysqli_fetch_array($result)){
        
        $data['id'] = $final_result['ID'];
        $data['name'] = $final_result['Full_Name'];
        $data['email'] = $final_result['Email_ID'];
        $data_array[] = $data;
    }
    return json_encode(array("result"=>"TRUE","Details"=>$data_array));   
    }else{
        $data['name'] = $s;
        $data['email'] = $search;
         $data['msg'] = "<b style='margin-left:-10px;'>".$search."?</b></br> We donot know that person. Add a name and click Send and we will add a virtual member and send them an invite email.They'll automatically receive access to the board once they sign up and confirm their email address.";
        $data_array[] = $data;
    }
    return json_encode(array("result"=>"FALSE","Details"=>$data_array));   
}


function filter_cards($search){
    
    $query = "SELECT * FROM `tbl_users` where Email_ID LIKE '%".$search."%'";
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
    $set_mode = "SET sql_mode = ''";
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
    $set_mode = "SET sql_mode = ''";
          $resultss = mysqli_query($this->dbh,$set_mode);
        $return_results_top = array();
        $query = "select tm.* , GROUP_CONCAT(utm.meta_key) as mkey, GROUP_CONCAT(utm.meta_value) as mvalue from tbl_user_team as tm , tbl_user_teammeta as utm where tm.id = $tid and utm.team_id = tm.id group by tm.team_name";
        //echo $query;die;
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                $key = explode(",", $DataSet['mkey']);
                array_push($key, "team_id","team_admin" ,"team_name","teamDesc","team_image");
                $value = explode(",", $DataSet['mvalue']);
                array_push($value, $DataSet['id'],$DataSet['user_id'] ,$DataSet['team_name'], $DataSet['teamDesc'],$DataSet['team_image']);
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
        
        $query = "SELECT list_id,list_title,list_id,list_color,list_icon FROM tbl_board_list WHERE board_id = $bid";
        //$query02 = "SELECT list_title,id as list_id,bgimage,bgcolor FROM tbl_tmp_board_list WHERE board_id = $DataSet1[0]";
        
       
        $result = mysqli_query($this->dbh,$query);
       // $result12 = mysqli_query($this->dbh,$query02);
        //$rowcount1 = mysqli_num_rows($result12);
        $rowcount = mysqli_num_rows($result);
        $data_array = array();
        //$data_array1 = array();
        if($rowcount > 0){
            
            while($DataSet = mysqli_fetch_array($result)){
                $data['list_title'] = $DataSet['list_title'];
                $data['list_id'] = $DataSet['list_id'];
                //$data['bgimage'] = $DataSet['bgimage'];
                $data['bgcolor'] = '#f7f7f7';
                $data_array[] = $data;
            }
         }
         // if($rowcount1>0){
         //    while($DataSet = mysqli_fetch_array($result12)){
         //        $data['list_title'] = $DataSet['list_title'];
         //        $data['list_id'] = $DataSet['list_id'];
         //        $data['bgimage'] = $DataSet['bgimage'];
         //        $data['bgcolor'] = $DataSet['bgcolor'];
         //        $data_array[] = $data;
         //    }
         // }
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
        //$admincard = "SELECT card_name as card_title,id as card_id,def,del_status as del_status,stickers FROM tbl_tmp_board_list_card WHERE list_id = $lid";

        //$admin_result = mysqli_query($this->dbh,$admincard);
        $result = mysqli_query($this->dbh,$query);
       // $admin_rowcount = mysqli_num_rows($admin_result);
        $rowcount = mysqli_num_rows($result);
        $data_array = array();
        if($rowcount > 0){
             //$data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                $data_array[] = $DataSet;
            }
         }

    return array("cardList" => $data_array);   
        
    }
    
    function countListCard($lid)
    {
        $query = "SELECT COUNT(card_id) AS totalCard FROM `tbl_board_list_card` WHERE `list_id` = $lid;";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_fetch_array($result);
        return $rowcount['totalCard'];   
    }
     function getListCard1($lid){
        
        $query = "SELECT * FROM tbl_board_list_card WHERE list_id = $lid";
        //$admincard = "SELECT card_name as card_title,id as card_id,def,del_status as del_status,stickers FROM tbl_tmp_board_list_card WHERE list_id = $lid";

        //$admin_result = mysqli_query($this->dbh,$admincard);
        $result = mysqli_query($this->dbh,$query);
       // $admin_rowcount = mysqli_num_rows($admin_result);
        $rowcount = mysqli_num_rows($result);
        $data_array = array();
        if($rowcount > 0){
             //$data_array = array();
            while($DataSet = mysqli_fetch_array($result)){
                $data_array[] = $DataSet;
            }
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
    
    function ChkInviteMember($mid,$bid){
        $query = "SELECT id FROM tbl_board_invite WHERE member_id = '$mid' and bid = $bid";
        //echo $query;die;
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;   
    }
    function ChkInviteTeamMember($mid,$bid){
        $query = "SELECT id FROM tbl_team_invite WHERE member_id = '$mid' and tid = $bid";
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


      function getLastChecklist1($cardid){
        $query = "SELECT id,userid,checklist,date_time FROM tbl_board_list_card_checklist where cardid = '".$cardid."' order by id DESC"; 
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
            $data['status'] = $results['status'];
            
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
        $query = "SELECT * FROM tbl_team_members where team_id = '$tid' ";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            while($result = mysqli_fetch_array($sql_query)){
                $data['members'] = $result['member_id'];
                $data_array[] = $result;
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
        $set_mode = "SET sql_mode = ''";
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

    /* get All List by boardID*/

    /* get All labels */
    function getAlllabels(){
        $query = "SELECT label_text,color,id FROM tbl_labels order by rand() ";
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
                // $data['labelname'] = $result['labelname'];
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
        $query = "SELECT * FROM tbl_label_users where id = $lid";
        $sql_query = mysqli_query($this->dbh, $query);
        $numrows = mysqli_num_rows($sql_query);
        if($numrows > 0){
            $result = mysqli_fetch_array($sql_query);
            $label_text = $result['label_name'];
            return $result;
        }
    }

     function getlblbyuserid($tblname1,$tblname2,$uid){

        $query = "SELECT * FROM $tblname1 INNER JOIN $tblname2 ON $tblname1.id = $tblname2.label_id  where $tblname2.user_id = $uid ORDER BY $tblname2.id DESC";
     //  echo "SELECT * FROM tbl_label_users INNER JOIN tbl_labels ON tbl_labels.id = tbl_label_users.label_id where tbl_label_users.user_id = $uid";
        $sql_query = mysqli_query($this->dbh, $query);
        $numrows = mysqli_num_rows($sql_query);
        if($numrows > 0){
            while($result = mysqli_fetch_array($sql_query)){
                $labeldata[] = $result;
            }
            return $labeldata;
        }
    }

    function getLabelId($label){
        $query = "SELECT id FROM tbl_labels where id = '$label' ";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            $result = mysqli_fetch_array($sql_query);
            $label_id = $result['id'];
            return $label_id;
        }
    } 

     function getLabeldata($label){
        $query = "SELECT * FROM tbl_labels where id = '$label' ";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            $result = mysqli_fetch_array($sql_query);
            $label_id = $result['id'];
            return $result;
        }
    } 

    /* check label exists */

    function checkCardLabel($uid,$cid,$label){
        $query = "SELECT id FROM tbl_board_list_card_labels
        where userid = $uid and cardid = $cid and labels = '$label' ";
        //echo  $query;die;
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
                 $data['title_name'] = $result['title_name'];
                $data['id'] = $result['id'];
                $data['background'] = $result['background'];
                 $data['ext'] = $result['file_extenstion'];
                $data_array[] = $data;
            }
            return $data_array;
        }
    }

    /* Cover images */

    function getCoverImage($cardid){
        $query = "select attachments,background FROM tbl_board_list_card_attachements where cover_image = 1 and status = 1 and cardid = $cardid";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            while($result = mysqli_fetch_array($sql_query)){
                $data['cover'] = $result['attachments'];
                $data['background'] = $result['background'];
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
  function count_rows_board($uid){
        $query = "SELECT * from tbl_user_board where admin_id = $uid";
        $result = mysqli_query($this->dbh,$query);
        $rescount = mysqli_num_rows($result);
        return $rescount;
    }


    /* board color  */

    function get_board_background($bid){
        $query = "select bg_color, bg_img,bg_type from tbl_user_board where board_id = $bid";
       // echo $query;die;
        $result = mysqli_query($this->dbh,$query);
        $rowresult = mysqli_fetch_array($result);
        return $rowresult;
    }

    /* board background Image */
    function get_board_bg_img(){
        $query = "SELECT `bg_img` FROM `tbl_board_img`  order by id desc";
        $result = mysqli_query($this->dbh,$query);
        $data_array = array();
        while($rowresult = mysqli_fetch_array($result)){
            $data_array[] = $rowresult['bg_img'];
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
        $query = "SELECT * FROM  $table order by id desc";
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


    function BoardCardMembers($value,$cardid){
        $query = "SELECT * FROM tbl_board_card_members where Menber=$value AND card_id = '".$cardid."'";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
           $data=$DataSet['Menber'];
            return $data;
        }
    }


        function BoardCardMemberscount($value,$cardid){
        $query = "SELECT * FROM tbl_board_card_members where Menber=$value AND card_id = '".$cardid."'";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
         return $rowcount;
       
    }

     function BoardCardlabelcount($cardid,$uid,$label_id){
        $query = "SELECT * FROM tbl_board_list_card_labels where cardid='$cardid' AND userid = '$uid' AND labels = '$label_id'";
        //echo $query;
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
       /* if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
           $data=$DataSet['Menber'];
            return $data;
        }*/
        return $rowcount;
    }



     function membersAjax($cardid){
        $query = "SELECT * FROM tbl_board_card_members WHERE card_id = '$cardid'";
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


    /* Get random board background*/
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
    /* End  */


    function all($table){
        $query = "SELECT * FROM  $table order by id desc";
       // echo $query;die;
        $result = mysqli_query($this->dbh,$query);
        $data_array = array();
        while($rowresult = mysqli_fetch_array($result)){
               
                $data_array[] = $rowresult;
         
        }
    return $data_array; 
    }
    function membership_plan($table){
        $query = "SELECT * FROM  $table order by id asc";
       // echo $query;die;
        $result = mysqli_query($this->dbh,$query);
        $data_array = array();
        while($rowresult = mysqli_fetch_array($result)){
               
                $data_array[] = $rowresult;
         
        }
    return $data_array; 
    }

  function cat_board($cat_id,$limit){
    $query = "select tbl_templates.* ,tbl_tmp_category.cat_name from tbl_templates left join tbl_tmp_category  on tbl_tmp_category.id=tbl_templates.cat_id where cat_id=$cat_id order by tbl_templates.id desc limit $limit";
   //echo $query;die;
    $result = mysqli_query($this->dbh,$query);
    $data_array = array();
    while($rowresult = mysqli_fetch_array($result)){
           
            $data_array[] = $rowresult;
     
    }
return $data_array; 
}


  function search_template($key,$limit){
    $query = "select tbl_templates.* ,tbl_tmp_category.* from tbl_templates left join tbl_tmp_category  on tbl_tmp_category.id=tbl_templates.cat_id where cat_name LIKE '%$key%'  order by tbl_templates.id desc limit $limit";
    //echo $query;die;
    $result = mysqli_query($this->dbh,$query);
    $data_array = array();
    while($rowresult = mysqli_fetch_array($result)){
           
            $data_array[] = $rowresult;
     
    }
return $data_array; 
}


   function get_temp_board_detail($bid){

        $query = "select tbl_tmp_board.*,tbl_tmp_category.* from tbl_tmp_board left join  tbl_tmp_category on  tbl_tmp_category.id=tbl_tmp_board.cat_id where tbl_tmp_board.id=$bid";
        $result = mysqli_query($this->dbh,$query);
        $data_array = array();
        while($rowresult = mysqli_fetch_array($result)){
        $data['id']=$rowresult['id'];
        $data['board_name']=$rowresult['board_name'];
        $data['board_url']=$rowresult['board_url'];
        $data['board_bgimage']=$rowresult['board_bgimage'];
        $data['description']=$rowresult['description'];
        $data['cat_name']=$rowresult['cat_name'];
                
                $data_array[] = $data;
         
        }
  return $data_array; 

    }


       function get_temp_detail($bid){

        $query = "select * from tbl_templates where id=$bid";
        //echo $query;die;
        $result = mysqli_query($this->dbh,$query);
        $data_array = array();
        while($rowresult = mysqli_fetch_array($result)){
        $data['id']=$rowresult['id'];
        $data['name']=$rowresult['name'];
        $data['image']=$rowresult['image'];
        $data['description']=$rowresult['description'];
        //$data['cat_name']=$rowresult['cat_name'];
                
                $data_array[] = $rowresult;
         
        }
  return $data_array; 

    }

    function get_temp_boards($cat_id){
    $query = "select * from tbl_tmp_board where cat_id=$cat_id";
   // echo $query;die;
     $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_result = array();
            while($DataSet = mysqli_fetch_array($result)){
                $data['id']=$DataSet['id'];
                $data['admin_id']=$DataSet['admin_id'];
                $data['board_name']=$DataSet['board_name'];
                $data['board_key']=$DataSet['board_key'];
                $data['board_url']=$DataSet['board_url'];
                $data['bg_color']=$DataSet['bg_color'];
                $data['board_fontcolor']=$DataSet['board_fontcolor'];
                $data['type']='PB';
                $data['admin_board_id']=0;
                $data['bg_img']=$DataSet['board_bgimage'];
                  

            // 'admin_id'=>$uid,
            // 'board_title'=>$rowresult['board_name'],
            // 'board_key'=>$board_key,
            // 'board_url'=>$rowresult['board_url'],
            // 'bg_color'=>$rowresult['board_bgcolor'],
            // 'board_fontcolor'=>$rowresult['board_fontcolor'],
            // 'type'=>'PB',
            // 'admin_board_id'=>$id,
            // 'bg_img'=>'http://www.odapto.com/admin/temp/images/'.$rowresult['board_bgimage'],

                    $data_result[] = $data;
                
            }
            return $data_result;    
        }
}

function get_temp_boardsbyId($id,$cat_id){
    $query = "select * from tbl_tmp_board where id=$id AND cat_id=$cat_id";
   // echo $query;die;
     $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $data_result = array();
            while($DataSet = mysqli_fetch_array($result)){
                $data['id']=$DataSet['id'];
                $data['admin_id']=$DataSet['admin_id'];
                $data['board_name']=$DataSet['board_name'];
                $data['board_key']=$DataSet['board_key'];
                $data['board_url']=$DataSet['board_url'];
                $data['bg_color']=$DataSet['bg_color'];
                $data['board_fontcolor']=$DataSet['board_fontcolor'];
                $data['type']='PB';
                $data['admin_board_id']=0;
                $data['bg_img']=$DataSet['board_bgimage'];
                  

                    $data_result[] = $data;
                
            }
            return $data_result;    
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


function gettotalchecklistcount($cardid){
        $query = "select * FROM tbl_board_list_card_checklist INNER JOIN tbl_board_list_card_checklist_item ON tbl_board_list_card_checklist.id=tbl_board_list_card_checklist_item.checklist_id where tbl_board_list_card_checklist.cardid = $cardid";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        
        return  $num_rows;
    }

  function getchecklistcount($cardid){
        $query = "select * FROM tbl_board_list_card_checklist INNER JOIN tbl_board_list_card_checklist_item ON tbl_board_list_card_checklist.id=tbl_board_list_card_checklist_item.checklist_id where tbl_board_list_card_checklist.cardid = $cardid AND tbl_board_list_card_checklist_item.status = 1";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
       
        return  $num_rows;
    }

    function getcarddesciption($cardid){
        $query = "select * FROM tbl_board_list_card where card_id = $cardid";
        $sql_query = mysqli_query($this->dbh, $query);
        $data = mysqli_fetch_array($sql_query);
        $card_desc = $data['card_description'];
       
        return  $card_desc;
    }

    function getcardmmber($cardid){
        $query = "select * FROM tbl_board_card_members where card_id = $cardid";
        $sql_query = mysqli_query($this->dbh, $query);
        $data_array = array();
        while($data = mysqli_fetch_array($sql_query)){
            $data_array[] = $data;
        }
       
        return  $data_array;
    }
    
 
    
    //get notification users
    //get notification users
    public function listNotifUser($user_id){
	
			//$stmt = "SELECT * FROM tbl_push_notification WHERE notif_user_to= ".$user_id." AND notif_loop > 0 AND notif_time <= CURRENT_TIMESTAMP() ";
			$stmt = "SELECT * FROM tbl_push_notification WHERE notif_user_to= ".$user_id." AND notif_loop > 0 AND notif_for='web' ";
			$result = mysqli_query($this->dbh,$stmt);
            $rowcount = mysqli_num_rows($result);
            if($rowcount > 0){
                while($DataSet = mysqli_fetch_array($result)){
                    $stat[] = $DataSet;
                }
                 //$stat[0] = true;
                //$stat[2] = $rowcount;
                return $stat;
            }
		
		
	}
	
	public function updateNotif($id)
	{
	    $sql = "update tbl_push_notification set  notif_loop = notif_loop-1 where id=".$id." ";
        if(mysqli_query( $this->dbh , $sql ))
        {
            $stat[0] = true;
			$stat[1] = 'success';
			return $stat;
        }
        else
        {
           $stat[0] = false;
			$stat[1] = 'failed';
			return $stat;
        }
	    
		
	}
	
	function getUserPrivilage($uid)
	{
	    $sql = "select previlage from tbl_users where id =".$uid." ";
	    $query = mysqli_query($this->dbh,$sql);
	    $result = mysqli_fetch_array($query);
	    return $result['previlage'];
	}


function getAll($tbl, $pageno){
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
          //  echo $query;
            $mysqli_query = mysqli_query($this->dbh, $query);
            $num_rows = mysqli_num_rows($mysqli_query);
          //  echo $num_rows;
            if($num_rows > 0){
                $data_array = array();
                while($result = mysqli_fetch_array($mysqli_query)){

//print_r($result);
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
        //print_r(json_encode( array("Pagination" => $data_pageinfo , "Result" => $data_array)));
        return json_encode( array("Pagination" => $data_pageinfo , "Result" => $data_array));

    }

    function getListIcon($offset,$limit)
    { 
        $query = "SELECT images,id,name FROM tbl_list_icon LIMIT $limit OFFSET $offset";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            while($result = mysqli_fetch_array($sql_query)){
                $data['icon_id'] = $result['id'];
                $data['name'] = $result['name'];
                $data['images'] = $result['images'];
                $data_array[] = $data;
            }
            return $data_array;
        }
        
    }
    
    function getBackgroundColor()
    {
        $query = "SELECT color,id FROM tbl_background_color order by rand()";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            while($result = mysqli_fetch_array($sql_query)){
                $data['color_id'] = $result['id'];
                $data['color'] = $result['color'];
                $data_array[] = $data;
            }
            return $data_array;
        }
        
    }
    
    function getListDetailByListId($list_id)
    {
        $query = "SELECT list_id,board_id,list_title,list_color,list_icon,listkey FROM tbl_board_list where list_id='".$list_id."'";
        $sql_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($sql_query);
        if($num_rows > 0){
            $data_array = array();
            $result = mysqli_fetch_array($sql_query);
                $data['list_id'] = $result['list_id'];
                $data['board_id'] = $result['board_id'];
                $data['list_title'] = $result['list_title'];
                $data['list_color'] = $result['list_color'];
                $data['list_icon'] = $result['list_icon'];
                $data['listkey'] = $result['listkey'];
                $data_array[] = $data;
            
            return $result;
        }
    }

}    
?>