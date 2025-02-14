


<?php

//$ip = "189.240.194.147";  //$_SERVER['REMOTE_ADDR']
$ip=$_SERVER['REMOTE_ADDR'];
$ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
$ipInfo = json_decode($ipInfo);
$timezone = $ipInfo->timezone;
date_default_timezone_set($timezone);
echo date_default_timezone_get();
echo date('Y/m/d H:i:s')


















/*
require_once("DBInterface.php");
$db = new Database();
$db->connect();
$uid=18;
$memebr_id=20;
//dc code
	    //to send notification
	    $name= $db->getName($uid);
	    
	    $url='';
           
                   
                   $where=array(
                        'user_id' =>$memebr_id
                       );
                      $user_token= $db->getsingledata('tbl_user_device',$where);
                      $usr_id=$user_token['user_id'];
                      echo $usr_id;
                       $r_name= $db->getName($usr_id);
                      
                      $message= $name .' invited you to join team';
                                  $notification_type='add_team_member';
                                  $device_type=$user_token['type'];
                   echo $user_token['push_token'];  */
                     /* if($uid != $usr_id)
						{
						     if($user_token['push_token'])
                              {
                                  
                                 if($device_type=='ios')
                                 {
                                     $ios_device_token= $user_token['push_token'];
                                        $db->pushNotification($ios_device_token, $device_type, $message,$board_id,$notification_type);
                                      
                                 }
                                 if($device_type=='android')
                                 {
                                     $android_device_token= $user_token['push_token'];
                                     $db->pushNotification($android_device_token, $device_type, $message,$board_id,$notification_type);
                                 }
                                 
                                 
                                     
                              }
                         //insert in database
                                 $notify_data=array(
                                                'notif_title' =>  'Team member invitation',
                                                'notif_msg' => $message,
                                                'notif_time' => date('Y-m-d H:i:s'),
                                                'notif_repeat' => 1,
                                                'notif_loop' => 1,
                                                'notif_user_from' =>$uid,
                                                'notif_user_to' => $usr_id,
                                                'board_id' => $board_id,
                                                'notif_url' => $url,
                                                'notif_for' => 'mobile',
                                                'status' => 1
                                            );
                                 
                                     $insertNotification = $db->insert("tbl_push_notification",$notify_data);
						    
						}
                      
                                
                     
                $activity_data=array(
                     'title' =>  'Team  Member invitation',
                    'msg' => $name .' sent team  invitation to  '.$r_name,
                     'board_id' => $board_id
                      );
                                 
            $insertActivity = $db->insert("tbl_board_activity",$activity_data);*/
                    
	    
	    
        //end dc code
        
        ?>