<?php  
require("vendor/autoload.php");
 $options = array(
    'cluster' => 'us2',
    'encrypted' => true
  );
  $pusher = new Pusher(
    'ed00024a271d9d5aa734',
    '2da0f9e5a1e7238ab712',
    '358343',
    $options
  );

  $data['message'] = 'hello world';
  $pusher->trigger('my-channel', 'my-event', $data);

?>