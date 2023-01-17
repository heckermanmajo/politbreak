<?php

echo "Edit user settings ... <br>";
//echo "<h2> Edit settings </h2>";
//print_r($_POST);

// basicall edit user

$data = $_POST;

$db = getDb();
$user_id = $_SESSION['user']->id;
$user = $db->query(
  "SELECT * FROM User WHERE id = $user_id"
)->fetchObject(User::class);

$_SESSION['user'] = $user;

foreach (get_object_vars($user) as $key => $value) {
  if(array_key_exists($key, ["id", "username"])){
    continue;
  }
  if (isset($data[$key])) {
    if ($key == "password") {
      $user->$key = password_hash($data[$key], PASSWORD_DEFAULT);
    } else {
      $user->$key = $data[$key];
    }
  }
}

$sql = getUpdateSql($user);
$db->prepare($sql)->execute(getSqlFields($user));

