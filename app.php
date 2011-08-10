<?php
require('pusher/lib/Pusher.php');

$CONFIG = array(
    'KEY' => '',
    'SECRET' => '',
    'APPID' => ''
);

$pusher = new Pusher\Pusher($CONFIG['KEY'], $CONFIG['SECRET'], $CONFIG['APPID']);


if (!empty($_POST)) {
    $pusher->trigger('CHATROOM', 'message-created', array(
        'user' => $_POST['user'],
        'content' => $_POST['content']
    ));
    echo "Success";
} else {
    header('HTTP/1.0 404 Not Found');
    echo "<h1>404 Not Found</h1>";
    echo "The page that you have requested could not be found.";
}
exit();
?>
