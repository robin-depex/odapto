<?php
function GetFieldValue($fieldname,$tablename,$where,$value){
$result = mysql_query("SELECT ".$fieldname." FROM ".$tablename." WHERE  ".$where."='".$value."'");   
$row = mysql_fetch_array($result);
return ucfirst(stripslashes($row[$fieldname]));
}
function GetFieldExact($fieldname,$tablename,$where,$value){
$result = mysql_query("SELECT ".$fieldname." FROM ".$tablename." WHERE  ".$where."='".$value."'");   
$row = mysql_fetch_array($result);
return $row[$fieldname];
}


function GetPageUrl(){
$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$pos = strrpos($url, "?");
if ($pos === false) { 
 return $url;
}else{
$url = 	strstr($url, '?', true);
return $url;
}

}

function GetPages($loginids){
$urlsArr = array();
$sql = mysql_query("SELECT url_path, status, user_id FROM tbl_user_permission WHERE user_id=".$loginids." AND status=1");
while($rows = mysql_fetch_object($sql)){
array_push($urlsArr,$rows->url_path);
}
return $urlsArr;
}


function Getprojecttype($projecttype){
$sql = mysql_query("SELECT project_type_nm FROM tbl_project_type WHERE type_id in (".$projecttype.")");
$values = array();
while ($rows = mysql_fetch_object($sql)){
array_push($values,$rows->project_type_nm);
}
return implode(", ",$values);
}


function DateFormat($dates){

$years = substr($dates,0,4);
$month = substr($dates,5,2);
$date = substr($dates,8,4);
$array = array('Jan' => '01', 'Feb' => '02', 'Mar' => '03', 'Apr' => '04', 'May' => '05', 'Jun' => '06', 'Jul' => '07', 'Aug' => '08', 'Sep' => '09', 'Oct' => '10', 'Nov' => '11', 'Dec' => '12');
$keyTextMonth = array_search($month, $array);
$datefull = $keyTextMonth.' '.$date.', '.$years;
return $datefull;
}

function GetFirstImagePath($postid){
$result = mysql_query("SELECT Ads_Value FROM tbl_ads_meta WHERE `Ads_Key`='image_0' AND `Ads_ID`=".$postid."");   
$row = mysql_fetch_array($result);
return $row['Ads_Value'];
}

function GetAllId($ids){
$rowId = "";
$result = mysql_query("SELECT ID FROM tbl_category WHERE `Parent_ID`=".$ids."");   
while($row = mysql_fetch_array($result)){
$rowId .= $row['ID'].',';
}
$numchar =  strlen($rowId)-1;
return substr($rowId,0,$numchar);
}

function GetUserDetails($ids){
$result = mysql_query("SELECT * FROM tbl_users WHERE `ID`=".$ids."");   
$row = mysql_fetch_row($result);
return $row;
}

function getTotalads($ids){
$row = GetAllId($ids);

$result = mysql_query( "SELECT ID, Category_ID FROM tbl_ads WHERE `Category_ID` IN (".$row.")"); 
 
$rows = mysql_num_rows($result);
if($rows > 1){
return number_format($rows).' ads';
}else{
return number_format($rows).' ad';
}
}
?>