<?php
  session_start();
  $chat_id = $_GET["chatId"];
  $message = $_GET["current"];

  $_SESSION["chat_id"] = $chat_id;

  $sql = "INSERT INTO chat (message, chat_id) VALUES ('" . $message . "', '" . $chat_id . "');";
  $dsn = "mysql:host=127.0.0.1; dbname=pickdb";

  $pdo = new PDO($dsn, "pickuser", "9!(k@f@c3@n6n!(K");
  $pdo->query($sql);
  echo "<br>";
?>
