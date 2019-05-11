<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat</title>
</head>

<body>
    <textarea id="text-area" name="name" cols="80" rows="8"></textarea>
    <form action="chat.php" method="get">
        <input id="chat-id" type="text">
        <input id="input-field" type="text">
        <button id="ajax-button" type="button" name="button">Send Message</button>
    </form>

    <script type="text/javascript">
        var chatId = document.getElementById("chat-id");
        var textArea = document.getElementById("text-area");
        var ajaxButton = document.getElementById("ajax-button");
        var chat_message_id = 0;

        function ajaxRequest() {
            var xhr = new XMLHttpRequest();
            var inputField = document.getElementById('input-field');
            var url = "server.php?current=" + inputField.value + "&chatId=" + chatId.value;

            xhr.open('get', url, true);
            xhr.onreadystatechange = function(){
                if(xhr.readyState == 4 && xhr.status == 200){
                    textArea.value += xhr.responseText;
                }
            };
            xhr.send();
        }
        ajaxButton.addEventListener("click", ajaxRequest);
    </script>

    <script type="text/javascript">
        setInterval(function() => {
            var xhr = XMLHttpRequest();
            var url = "next_message.php?chatId=" + chatId;
        }, 2000);
    </script>
</body>
</html>