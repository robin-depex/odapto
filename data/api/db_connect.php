<?php  
$conn = mysqli_connect('localhost', 'hxtec21y_odapto','BB&35D3+5l4^','hxtec21y_odapto') or die('Not connected');


$query = "select * from tbl_user_device";
$mysql_query = mysqli_query($conn, $query);
$query_result = mysqli_fetch_array($query);
echo json_encode($query_result);


?>