<?php
session_start();
require_once("DBInterface.php");
$db = new Database();
$db->connect();
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$list_id = $_GET['list_id'];
$limit = 16; // Number of images per request
// Query to fetch images
$list_icons = $db->getListIcon($offset,$limit);
// Output images as HTML
if(!empty($list_icons))
{
    foreach ($list_icons as $icon) 
    {
        echo '<div onclick="userlistIcon(this.id,\''.$list_id.'\')" id="'.$icon['images'].'">';
        echo '<img src="' . $icon['images'] . '" alt="' . htmlspecialchars($icon['name']) . '" style="width:30px; gap">';
        echo '</div>';
    }
} else 
{
    echo "No more images";
}
    


?>