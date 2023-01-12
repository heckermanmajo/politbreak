<?php

$db = getDb();

// Get the user's ID
$user_id = $_SESSION['user_id'];

$post = new Post();

foreach ($post as $key => $value) {
  if (isset($_POST[$key])) {
    $post->$key = $_POST[$key];
    if (is_string($post->$key)) {
      $post->$key = htmlspecialchars($post->$key);
    }
  }
}
// Set the author
$post->author_id = $user_id;

// Create the post
$sql = getInsertSql($post);

$db->prepare($sql)->execute(getSqlFields($post));