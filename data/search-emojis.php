<?php
date_default_timezone_set("Asia/Kolkata");
require_once("DBInterface.php");
$db = new Database();
$db->connect();

if(isset($_REQUEST['data'])){

	$icon = $_REQUEST['data'];

	$result = $db->searchEmoji($icon);
	?>
	<ul style="margin: 0px; padding: 0px; list-style: none;">
	<?php  
	//$result = $db->getEmoji();
	if(sizeof($result) > 0){
	foreach ($result as $value) {
	?>
	<li class="popup-list">
		<span id="profile_initials n-b"><img src="<?php echo $value['icon']; ?>" style="width: 20px;"></span> 
		<span class="popup-text" id="<?php echo $value['code']; ?>" onclick="return addEmoji(this.id);"><?php echo $value['name']; ?></span></li>
	<?php		
	}
	}else{
	?>
	<li class="popup-list">
	<span class="popup-text">Not Found</span>
	</li>
	<?Php			
	}
	?>	
	</ul>
	<?php
}
?>