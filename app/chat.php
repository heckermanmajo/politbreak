<?php

$connection_id = $_GET['id'];
$db = getDb();
$connection = $db->query(
  "SELECT * FROM Connection WHERE id = $connection_id"
)->fetchObject(Connection::class);

$messages = $db->query(
  "SELECT * FROM ChannelMessage WHERE connection_id = $connection_id"
)->fetchAll(PDO::FETCH_CLASS, ChannelMessage::class);

// display all messages
foreach ($messages as $message) {
  echo "<div class='message'>";
  echo "<p>$message->content</p>";
  echo "<p>$message->date</p>";
  echo "</div>";
  echo "<hr>";
}
