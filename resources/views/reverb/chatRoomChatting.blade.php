<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Room</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            height: 80vh;
            display: flex;
            flex-direction: column;
        }
        .messages {
            flex: 1;
            overflow-y: auto;
            margin-bottom: 20px;
        }
        .message {
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .message.sent {
            background-color: #007bff;
            color: white;
            align-self: flex-end;
        }
        .message.received {
            background-color: #f1f1f1;
            align-self: flex-start;
        }
        .message-input {
            display: flex;
        }
        .message-input input {
            flex: 1;
            padding: 10px;
            border-radius: 10px 0 0 10px;
            border: 1px solid #ccc;
        }
        .message-input button {
            padding: 10px 20px;
            border-radius: 0 10px 10px 0;
            border: 1px solid #007bff;
            background-color: #007bff;
            color: white;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="chat-container">
        <div class="card">
            <div class="card-header text-center">
            Chat Room : <b>{{$username}}</b>
            </div>
        </div>
        <div class="messages" id="messages">
        </div>
        <div class="message-input">
            <input type="text" placeholder="Type a message..." id="messageinput">
            <button type="button" onclick="sendMessage()">Send</button>
        </div>
    </div>

    <script
			  src="https://code.jquery.com/jquery-3.7.1.js"
			  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
			  crossorigin="anonymous">
    </script>

    <script>
        function sendMessage() {
            var sender = "{{$username}}";
            var message = $('#messageinput').val();
            var csrfToken = "{{ csrf_token() }}";
            //alert(sernder);
            $.ajax({
                url: "{{ route('chat.room.send') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    sender: sender,
                    message: message,
                    _token: csrfToken
                },
                success: function (response) {
                    $('#messageinput').val("");
                    $('#messages').append('<div class="message sent" style="text-align: right;">' + response.message + '</div>');
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        window.onload = () => {
            Echo.channel('chat-room')
            .listen('ChatSent', (e) => {
                //alert(e.sender);
                if(e.sender != "{{$username}}") {
                    $('#messages').append('<div class="message received" style="text-align: left;">' + e.message + '</div>');
                }

            });
        }



    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
