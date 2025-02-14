<?php  
$conn = mysqli_connect('localhost', 'depexloa_odapto','odapto123','depexloa_odapto') or die('Not connected');

$query = "select * from tbl_user_device";
$mysql_query = mysqli_query($conn, $query);
$query_result = mysqli_fetch_array($query);
echo json_encode($query_result);


?>