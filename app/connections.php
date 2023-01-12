<?php


// get all connections of the user
$db = getDb();
$user = $_SESSION['user'];
$connections = $db->query(
  "SELECT * FROM Connection WHERE user_id = {$user->id} OR partner_id = {$user->id}"
)->fetchAll(PDO::FETCH_CLASS, Connection::class);

// display all connections
foreach ($connections as $connection) {
  echo "<div class='connection'>";
  echo "<h2>$connection->title</h2>";
  echo "<p>$connection->description</p>";
  echo "<p>$connection->date</p>";
  echo "<a href='?p=chat&id={$connection->id}'>Chat</a>";
  echo "<pre>", print_r($connection, true), "</pre>";
  echo "</div>";
  echo "<hr>";
}