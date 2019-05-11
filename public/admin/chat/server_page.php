<?php
  session_start();
  $chat_id = $_GET["chatId"];
  $message = $_GET["current"];

  $_SESSION["chat_id"] = $chat_id;

  $sql = "INSERT INTO chat_data (message, chat_id) VALUES ('" . $message . "', '" . $chat_id . "');";

  $dsn = "mysql:host=127.0.0.1;dbname=chat";
  $pdo = new PDO($dsn, "chat_admin", "123");

  $pdo->query($sql);

  echo "<br>";

?>
