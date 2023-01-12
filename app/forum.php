<?php

// get the forum of the post

// list of channels
$db = getDb();

$channels = $db->query(
  "SELECT * FROM Channel"
)->fetchAll(PDO::FETCH_CLASS, 'Channel');

foreach ($channels as $channel) {
  echo "<div class='channel'>";
  echo "<h3>$channel->name</h3>";
  echo "<p>$channel->description</p>";
  echo "<a href='?p=chat&id=$channel->id'>Join</a>";
  echo "</div>";
  echo "<hr>";
}