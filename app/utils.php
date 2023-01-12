<?php

/**
 * Create alter statement for table.
 * @param string $class
 * @return array
 * @throws Exception
 */
function getCreateSql(
  string $class
): array {
  $array = [];
  $sql = "CREATE TABLE IF NOT EXISTS $class (
    id INTEGER PRIMARY KEY AUTOINCREMENT
  )";
  $array[] = $sql;
  $fields = get_class_vars($class);
  // Alter table to add fields
  foreach ($fields as $field => $value) {
    if ($field == 'id') {
      continue;
    }
    if (is_int($value)) {
      $sql = "ALTER TABLE $class ADD COLUMN $field INTEGER DEFAULT 0";
    } else if (is_string($value)) {
      $sql = "ALTER TABLE $class ADD COLUMN $field TEXT DEFAULT ''";
    } else {
      throw new Exception("Unknown type for field $field");
    }
    $array[] = $sql;
  }
  
  return $array;
}

function getInsertSql(
  object $dataClass
): string {
  $class = get_class($dataClass);
  $fields = get_class_vars($class);
  $sql = "INSERT INTO $class (";
  $values = "VALUES (";
  foreach ($fields as $field => $value) {
    if ($field == 'id' or str_starts_with($field, "j_")) {
      continue;
    }
    $sql .= "$field,";
    $values .= ":$field,";
  }
  $sql = rtrim($sql, ',');
  $values = rtrim($values, ',');
  $sql .= ") $values)";
  return $sql;
}

function getUpdateSql(
  object $dataClass
): string {
  $class = get_class($dataClass);
  $fields = get_class_vars($class);
  $sql = "UPDATE $class SET ";
  foreach ($fields as $field => $value) {
    if ($field == 'id' or str_starts_with($field, "j_")) {
      continue;
    }
    $sql .= "$field = :$field,";
  }
  $sql = rtrim($sql, ',');
  $sql .= " WHERE id = {$dataClass->id}";
  return $sql;
}

function getSqlFields(
  $object
): array {
  foreach (get_object_vars($object) as $field => $value) {
    if ($field == 'id' or str_starts_with($field, "j_")) {
      continue;
    }
    $array[$field] = $value;
  }
  return $array ?? [];
}

function getDeleteSql(
  object $dataClass
): string {
  $class = get_class($dataClass);
  $sql = "DELETE FROM $class WHERE id = {$dataClass->id}";
  return $sql;
}


function populate(
  $object,
  array $values
): object {
  foreach ($values as $key => $value) {
    if (is_int($key)) {
      continue;
    }
    $object->$key = $value;
  }
  return $object;
}


class TestClass {
  public int $id = 0;
  public string $name = '';
  public int $age = 0;
}

// test cases
assert(getCreateSql('TestClass') == [
         "CREATE TABLE IF NOT EXISTS TestClass (
    id INTEGER PRIMARY KEY AUTOINCREMENT
  )",
         "ALTER TABLE TestClass ADD COLUMN name TEXT DEFAULT ''",
         "ALTER TABLE TestClass ADD COLUMN age INTEGER DEFAULT 0",
       ], "getCreateSql failed." . print_r(getCreateSql("TestClass"), true));

$testClass = new TestClass();
$testClass->name = "test";
$testClass->age = 10;
assert(getInsertSql($testClass) == "INSERT INTO TestClass (name,age) VALUES (:name,:age)", "getInsertSql failed.");

$testClass->id = 1;
assert(getUpdateSql($testClass) == "UPDATE TestClass SET name = :name,age = :age WHERE id = 1", "getUpdateSql failed.");

assert(getDeleteSql($testClass) == "DELETE FROM TestClass WHERE id = 1", "getDeleteSql failed.");

$db = null;
function getDb(): PDO {
  global $db;
  if ($db) {
    return $db;
  }
  $db = new PDO('sqlite:../database.sqlite');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $db;
}

function put_post(
  Post $post,
  bool $details_button = false,
  bool $edit_button = false,
  bool $forum_button = false
): void {
  
  $color = match ($post->category) {
    'news' => 'red',
    'discussion' => 'blue',
    'question' => 'green',
    'paper' => 'orange',
    'wiki' => 'purple',
    'problem' => 'black',
    default => 'gray',
  };
  $category = match ($post->category) {
    'news' => 'News',
    'discussion' => 'Discussion',
    'question' => 'Question',
    'paper' => 'Paper',
    'wiki' => 'Wiki',
    'problem' => 'Problem',
    default => 'Other',
  };
  echo "<div class='post w3-card w3-padding'>";
  echo "<div style='color: $color'><small>$category</small></div>";
  echo "<h3 style='color: $color'>$post->title dasgsfth</h3>";
  echo "<h2>$post->title</h2>";
  echo "<p>$post->content</p>";
  echo "<p>$post->date</p>";
  echo "<pre>", print_r($post, true), "</pre>";
  if ($details_button) {
    echo "<a href='?p=one&id=$post->id' class='w3-button w3-blue'> Mehr Details ... </a>";
  }
  if ($post->author_id == $_SESSION["user"]->id){
    if ($edit_button) {
      echo "&nbsp;";
      echo "<a href='?p=edit&id=$post->id' class='w3-button w3-blue'> Editieren ... </a>";
    }
  }
  echo "&nbsp;";
  if ($forum_button) {
    echo "<a href='?p=forum&id=$post->id' class='w3-button w3-blue'> Forum ... </a>";
  }
  echo "</div>";
  echo "<hr>";
}