<?php 
$conn = mysqli_connect("localhost","odapto_odapto","(F-HPS!r0-[+","odapto_odapto");
$files = glob("list_icon/*.*"); 
for ($i=1; $i<count($files); $i++) 
{ 
	$image = $files[$i]; 
	
	$fileName = explode('/',$image);
	$name = explode('.',$fileName[1]);

	$resultss = mysqli_query($conn,"INSERT INTO tbl_list_icon (`name`,`images`) VALUES('".$name[0]."','".$fileName[1]."')");
}
?>