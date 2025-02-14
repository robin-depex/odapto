<?php  
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('DBInterface.php');
$db = new Database();
$db->connect();
$username = 'admin@odapto.com';
$password = 'admin';
$response = $db->chkAdminLogin($username,$password);
//echo $response;

function getweek_first_last_date($date)
{
    $cur_date = strtotime($date); // Change to whatever date you need
    // Get the day of the week: Sunday = 0 to Saturday = 6
    $dotw = date('w', $cur_date);
    if($dotw>1)
    {
        $pre_monday  =  $cur_date-(($dotw)*24*60*60);
        $next_sunday = $cur_date+((6-$dotw)*24*60*60);
    }
    else if($dotw==1)
    {
        $pre_monday  = $cur_date;
        $next_sunday =  $cur_date+((6-$dotw)*24*60*60);
    }
    else if($dotw==0)
    {
        $pre_monday  =$cur_date -(5*24*60*60);;
        $next_sunday = $cur_date;
    }

    $date_array =   array();
    $date_array['start_date_of_week'] = $pre_monday;
    $date_array['end_date_of_week'] = $next_sunday;

    return $date_array;
}

$date = date('Y-m-d');
$result= getweek_first_last_date($date);
$fday = date("Y-m-d",$result['start_date_of_week']);
$eday = date("Y-m-d",$result['end_date_of_week']);
echo $fday . " - " .$eday;
?>