<?php


echo "One Channel";

$channel_id = $_GET['id'];

$db = getDb();

$channel = $db->query(
  "SELECT * FROM Channel WHERE id = $channel_id"
)->fetchObject('Channel');

// check if the user is logged in

$messages = $db->query(
  "SELECT * FROM Message WHERE channel_id = $channel->id"
)->fetchAll(PDO::FETCH_CLASS, 'Message');

echo "<h3>$channel->name</h3>";
echo "<p>$channel->description</p>";

echo "<hr>";

echo "<h3>Messages</h3>";

foreach ($messages as $message) {
  echo "<div class='message'>";
  echo "<h4>$message->author_name</h4>";
  echo "<p>$message->content</p>";
  echo "</div>";
  echo "<hr>";
}
