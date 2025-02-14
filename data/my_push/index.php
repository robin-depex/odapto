<?php
  require __DIR__ . '/vendor/autoload.php';

  $options = array(
    'cluster' => 'ap2',
    'encrypted' => true
  );
  $pusher = new Pusher\Pusher(
    '082f3cbfe1813c32a88b',
    '51696a7e357df13d9661',
    '394838',
    $options
  );

  $data['message'] = 'hello world';
  $pusher->trigger('my-channel', 'my-event', $data);
?>

<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  
  
</head>
<body>
  <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('082f3cbfe1813c32a88b', {
      cluster: 'ap2',
      encrypted: true
    });

     var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {

    if (!("Notification" in window)) {
      alert("This browser does not support desktop notification");
    }

    else if (Notification.permission === "granted") {
    var notification = new Notification('The New Board', {body: 'this si new Board',icon: 'http://placekitten.com/100/100'});
    } 
    else {
      Notification.requestPermission(function (permission) {

      if(!('permission' in Notification)) {
        Notification.permission = permission;
      }
      if (permission === "granted") {
        var notification = new Notification('The New Board', {body: 'this si new Board', icon: 'http://placekitten.com/100/100'});
      }
    });
  }


//alert(data.message);
    });
  </script>
</body>
</html>