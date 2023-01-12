<?php
assert(isset($user_defined_classes));
echo "<h1>Create Database</h1>";

$db = getDb();
// Create tables

foreach ($user_defined_classes as $class) {
  #echo $class."<br>";
  #print_r(getCreateSql($class));
  foreach (getCreateSql($class) as $sql) {
    try{
      $db->exec($sql);
    }catch(Exception $e){
      echo $e->getMessage();
    }
  }
}