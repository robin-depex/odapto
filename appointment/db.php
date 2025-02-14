<?php
function database(){
$con = mysqli_connect("localhost","odapto_odapto","(F-HPS!r0-[+","odapto_odapto");
if (mysqli_connect_errno()){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}else{
 	return $con;
}
}
