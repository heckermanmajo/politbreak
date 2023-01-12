<?php

$db = getDb();

$id = $_POST['id'];

$post = $db->query("SELECT * FROM Post WHERE id = $id")->fetchObject('Post');

if ($post->author_id != $_SESSION['user_id']) {
  header('Location: ?p=home');
  exit;
}

foreach ($post as $key => $value) {
  if (isset($_POST[$key])) {
    $post->$key = $_POST[$key];
    if (is_string($post->$key)) {
      $post->$key = htmlspecialchars($post->$key);
    }
  }
}

$sql = getUpdateSql($post);

$db->prepare($sql)->execute(getSqlFields($post));

