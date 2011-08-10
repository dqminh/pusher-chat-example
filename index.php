<?php
require('pusher/lib/Pusher.php');

$room = (isset($_GET['room']))
    ? 'CHATROOM-' . filter_var($_GET['room'], FILTER_SANITIZE_STRING)
    : 'CHATROOM-0';
$nick = (isset($_GET['nick']))
    ? filter_var($_GET['nick'], FILTER_SANITIZE_STRING)
    : 'user-' . rand();

$CONFIG = array(
    'KEY' => '',
    'SECRET' => '',
    'APPID' => ''
);

$pusher = new Pusher\Pusher($CONFIG['KEY'], $CONFIG['SECRET'], $CONFIG['APPID']);

if (!empty($_POST)
    && array_key_exists('channel', $_POST)
    && array_key_exists('user', $_POST)
    && array_key_exists('content', $_POST)
) {
    $pusher->trigger($_POST['channel'], 'message-created', array(
        'user' => $_POST['user'],
        'content' => $_POST['content']
    ));
    echo "Success";
    exit();
}
?>
<!doctype html>
<html>
    <head>
        <title>Test Chatroom</title>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.1.7/underscore-min.js"></script>
        <script src="http://js.pusherapp.com/1.8/pusher.min.js"></script>
        <style type="text/css">
            #messageform {
                display: none;
            }
            span.user {
                color: green;
                font-weight: bold;
            }
        </style>
        <script type="text/javascript">
            var CHANNEL = '<?= $room ?>';
        </script>
    </head>
    <body>
        <div id="container">
            <div id="chatroom">
            </div>
            <div id="messageform">
                <!-- change this according to your deploy url -->
                <form action="/testchat/index.php" method="POST" id="newmessage">
                    <input type="text" id="message" name="message" />
                    <input type="hidden" id="user" name="user" value="<?= $nick ?>" />
                    <button name="submit" id="submit" type="submit">Post</button>
                </form>
            </div>
            <div id="waiting">
                Waiting to establish connection ...
            </div>
            <!-- change this according to your deploy url -->
            <script type="text/javascript" src="/testchat/static/js/app.js"></script>
        </div>
    </body>
</html>
