<?php 
class Database
{
    var $rs;
    var $dbh;

    /*function Database()
    {
        $this->rs = "";
        $this->dbh = "";
    }*/
    function __construct()
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
         // $this->dbh = mysqli_connect('aa1mmkkfbnatt1l.cyapuifkotez.us-east-2.rds.amazonaws.com', 'odapto','odapto123','odapto') or die('Not connected');   
		 $this->dbh = mysqli_connect('localhost', 'odapto_odapto','(F-HPS!r0-[+','odapto_odapto') or die('Not connected123'); 
 // $this->dbh = mysqli_connect('localhost', 'depexloa_odapto','odapto123','depexloa_odapto') or die('Not connected');  
          } 
                   
        return $this->dbh;
    }


    /* Insert Query */
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
        
         $set_mode = "SET sql_mode = ''";
          $resultss = mysqli_query($this->dbh,$set_mode);
        //echo $sql;die;
        if( mysqli_query($this->dbh , $sql ) )
        {
            
            return true;
        }
        else
        {
            return false;
        }
        
    }

    /* Update Query */
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
       // echo $sql;die;
       if(mysqli_query( $this->dbh , $sql ))
        {
            return true;
        }
        else
        {
            return false;
        }

    }
    /* Delete Query */
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
    
    /* last inserted token */
     function lastInsertedId($accessToken){
        $query = "select ID from tbl_users where accessTocken = '".$accessToken."'";
        $result = mysqli_query($this->dbh,$query);
        if( mysqli_num_rows( $result ) > 0 ){
            $query_result = mysqli_fetch_object($result);
            $uid = $query_result->ID;
            return $uid;
        }
    }

function sendEmail($subject,$message,$email){

require_once('../phpmailer/PHPMailerAutoload.php');
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

    /* check admin authentication */

    function chkAdminLogin($username,$passwd){
        $password = md5($passwd);
        //echo "select * from tbl_admin as ad where ad.email = '$username' and password = '$password'";
        $query = "select * from tbl_admin as ad where ad.email = '$username' and password = '$password'";
		//$result  = json_encode('result' => 'FALES','data' => "select * from tbl_admin as ad where ad.email = '$username' and password = '$password'");
        $mysqli_query = mysqli_query($this->dbh, $query);
        $num_rows = mysqli_num_rows($mysqli_query);
        if($num_rows > 0){
            $resullt = mysqli_fetch_array($mysqli_query);
            
            session_start();
            $sess_id = session_id();
            $update_token = array(
                'authtoken' => $sess_id
            );
            $cond = array(
                'id' => $resullt['id']
            );
            $update = $this->update('tbl_admin', $update_token, $cond);
            
            $query_token = "select * from tbl_admin as ad where ad.authtoken = '$sess_id'"; 
            $mysqli_query = mysqli_query($this->dbh, $query_token);
            $data_array = array();
            $result = mysqli_fetch_array($mysqli_query);
            $data['admin_id'] = $result['id'];
            $data['username'] = $result['username'];
            $data['email'] = $result['email'];
            $data['authtoken'] = $result['authtoken'];
            
            $result = json_encode(array('result' => 'TRUE','data' => $data ));
        }else{
            $result = json_encode(array('result' => 'FALSE','data' => "Invalid username/password",));
        }
        return $result;
    }

    function getAllUser($pageno){
        $query_count = "select count(ID) as total from tbl_users";
        $result_count = mysqli_query($this->dbh,$query_count);
        $rowcount = mysqli_num_rows($result_count);
        if($rowcount > 0){
            $result_row = mysqli_fetch_array($result_count);
            $total = (int)$result_row['total'];
           
            $limit = 15;

            $page = $pageno;
            $offset = $page  * $limit;

            $pages = ceil($total/$limit);
            $left_rec = $total - ($page * $limit);

            $query = "select * from tbl_users limit $offset , $limit";
            $mysqli_query = mysqli_query($this->dbh, $query);
            $num_rows = mysqli_num_rows($mysqli_query);
            if($num_rows > 0){
                $data_array = array();
                while($result = mysqli_fetch_array($mysqli_query)){
                    

                    $data['id']     = $result['ID'];
                    $data['name']   = $result['Full_Name'];
                    $data['email']   = $result['Email_ID'];
                    $data['status']   = $result['status'];
                    $data['addDate']   = $result['AddDate'];
                    $data['membership_plan']   = $result['membership_plan'];
                    $data['expiry_date']   = $result['expiry_date'];
                    $data['privilege'] = $result['previlage'];
                    
                    $data_pageinfo = array(
                        'total' => $total,
                        'pages' => $pages,
                        'pageno' => (int)$page,
                        'offset' => (int)$offset,
                        'limit'  => $limit
                    );
                    $data_array[] = $data;
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
	function count_all($tbl){
		$total =0;
		$query_count = "select count(id) as total from ".$tbl;
        $result_count = mysqli_query($this->dbh,$query_count);
		$rowcount = mysqli_num_rows($result_count);
		if($rowcount > 0){
            $result_row = mysqli_fetch_array($result_count);
            $total = (int)$result_row['total'];
		}

		return $total;
	}
	
	function getuserbymonth($tbl){
		$total =0;
		$query_count = "select AddDate from ".$tbl." ORDER BY AddDate";
        $result_count = mysqli_query($this->dbh,$query_count);
		$rowcount = mysqli_num_rows($result_count);
		if($rowcount > 0){
			$months = array('01','02','03','04','05','06','07','08','09','10','11','12');
			$av_m = array();
			while($data = mysqli_fetch_array($result_count)){
				$date = explode('-',$data['AddDate']);
					$av_m[]=$date[1];
			}
			$vals = array_count_values($av_m);
			//echo $vals['06'];
			echo $vals;
			$c = 1;
			//foreach($months as $month){
				//echo $month;
				
			//$c++;
			//}

		}
		//die();
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



    function all($tbl, $pageno){
        $query_count = "select count(id) as total from ".$tbl;
        $result_count = mysqli_query($this->dbh,$query_count);
        $rowcount = mysqli_num_rows($result_count);
        if($rowcount > 0){
            $result_row = mysqli_fetch_array($result_count);
            $total = (int)$result_row['total'];
            $limit = 15;

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

//      function all($table){
//     $query = "SELECT * FROM  $table order by id desc";
//    // echo $query;die;
//     $result = mysqli_query($this->dbh,$query);
//     $data_array = array();
//     while($rowresult = mysqli_fetch_array($result)){
           
//             $data_array[] = $rowresult;
     
//     }
// return $data_array; 
// }
    
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

    // getUserData 
    function getUserData($uid){
        $query = "SELECT * FROM tbl_users WHERE ID = $uid";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
            return $DataSet;
        }
    }
    
    // get data by id
        function get_single($table, $uid){
        $query = "SELECT * FROM ".$table." WHERE ID = $uid";
        //echo $query;die;
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
            return $DataSet;
        }
    }
    
    // get data by id
        function get_img_link($table, $uid){
        $query = "SELECT image FROM ".$table." WHERE id=$uid";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
            return $DataSet;
        }
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


    // get data by id
        function pushNotification($pushdata,$boardName){

             require __DIR__ . '/vendor/autoload.php';
              $options = array(
                'cluster' => 'ap2',
                'encrypted' => true
              );
              $pusher = new Pusher\Pusher(
                '082f3cbfe1813c32a88b',
                '51696a7e357df13d9661',
                '394838',
                $options
              );
              $count=count($pushdata);

for ($i=1; $i <=$count; $i++) { 
    $data=array(
            'title'=>'Add New Board by Odapto',
            'body'=>'New Board '.$boardName.' by Admin You Free to use this.',
            'my-channel'=>'my-channel'.$pushdata[$i],
            'my-event'=>'my-event'.$pushdata[$i]
            );


            $pusher->trigger('my-channel'.$pushdata[$i], 'my-event'.$pushdata[$i], $data);

        }
            }



               function my_get_single($table, $bid){
        $query = "SELECT * FROM ".$table." WHERE board_id = $bid";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
            return $DataSet;
        }
    }
    

    function get_single_data($table, $fname,$fval){
        $query = "SELECT * FROM $table WHERE $fname = '".$fval."'";
        $result = mysqli_query($this->dbh,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $DataSet = mysqli_fetch_array($result);
            return $DataSet;
         }
    }
    
    
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



/* class ends */
}
 ?>