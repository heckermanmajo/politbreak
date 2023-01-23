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
    // check if the field is defined
    if (property_exists($object, $key)) {
      $object->$key = $value;
    } else {
      // mostly deprecated field
      // echo "Property $key does not exist in class " . get_class($object)."<br>";
    }
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
  #echo "<pre>", print_r($post, true), "</pre>";
  echo "<hr>";
  if ($details_button) {
    echo "<a href='?p=one&id=$post->id' class='w3-button w3-blue'> Mehr Details ... </a>";
  }
  if ($post->author_id == $_SESSION["user"]->id) {
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


/**
 * Uploads a file to the server.
 * Returns the file path.
 * @return string the file path after uploading
 *
 * @throws Exception if the file could not be uploaded
 */
function upload_file(
  string $field_name
): string {
  $target_dir = "../uploads/";
  $target_file = $target_dir . basename($_FILES[$field_name]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  // Check if image file is a actual image or fake image
  if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES[$field_name]["tmp_name"]);
    if ($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  }
  // Check if file already exists
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }
  // Check file size
  if ($_FILES[$field_name]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }
  // Allow certain file formats
  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES[$field_name]["tmp_name"], $target_file)) {
      echo "The file " . htmlspecialchars(basename($_FILES[$field_name]["name"])) . " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
  return $target_file;
}







