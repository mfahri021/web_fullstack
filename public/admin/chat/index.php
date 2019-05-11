<?php
  session_start();

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <textarea id="text-area" name="name" rows="8" cols="80"></textarea>
    <form class="" action="index.html" method="get">
      <input id="chat-id" type="text" name="" value="">
      <input id="input-field" type="text" name="" value="">
      <button id="ajax-button" type="button" name="button">Send</button>
    </form>
    <script type="text/javascript">
      var chatId = document.getElementById("chat-id");
      var textArea = document.getElementById("text-area");
      var ajaxButton = document.getElementById("ajax-button");
      var chat_message_id = 0;

      function ajaxRequest() {
        var xhr = new XMLHttpRequest();
        var inputField = document.getElementById('input-field');
        var url = "server_page.php?current=" + inputField.value +"&chatId=" + chatId.value ;
        xhr.open('get', url, true);
        xhr.onreadystatechange = function () {
          if(xhr.readyState == 4 && xhr.status == 200){
            textArea.value += xhr.responseText;
          }
        };
        xhr.send();
      }
      ajaxButton.addEventListener("click", ajaxRequest);

    </script>

    <script type="text/javascript">
      setInterval(function () {
        var xhr = XMLHttpRequest();
        var url = "next_message.php?chatId=" + chatId;

      }, 2000);

    </script>

  </body>
</html>
