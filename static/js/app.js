$(function() {
    var PUSHER = {
        KEY: ''
    };

    var messageForm = $('#newmessage'),
        messageFormDisplay = $('#messageform'),
        message = $('#message'),
        user = $('#user'),
        messageTemplate = _.template(
            '<p><span class="user"><%= user %></span>: <span><%= content %></span></p>'),
        chatContent = $('#chatroom'),
        // pusher channels
        pusher = new Pusher(PUSHER.KEY),
        socketId = 0,
        chatChannel = pusher.subscribe(CHANNEL);

    socketId = pusher.bind('pusher:connection_established',
        function(ev) {
            socketId = ev.socket_id;
            $('#waiting').hide();
            messageFormDisplay.show();

            // perform all bindings here
            chatChannel.bind('message-created', function(message) {
                console.log(message);
                chatContent.append(messageTemplate({
                    user: message.user,
                    content: message.content
                }));
            });

            messageForm.submit(function(e) {
                e.preventDefault();
                var content = message.val();
                if (content.length > 0) {
                    $.post(messageForm.attr('action'), {
                        user: user.val(),
                        content: content,
                        channel: CHANNEL
                    });
                }
                message.val('').focus();
                return false;
            });
        }
    );
});
