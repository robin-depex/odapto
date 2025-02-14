<?php  
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('DBInterface.php');
$db = new Database();
$db->connect();
$response = $db->get_board_bg_img();
foreach ($response as $key => $value) {
?>
<img src="<?php echo $value ?>">
<?php
}
?>