<?php


echo "<h2>LOGIN </h2>";

$username = $_POST['username'];

$password = $_POST['password'];

$db = getDb();

$statement = $db->prepare("SELECT * FROM User WHERE username = :username");

$statement -> bindParam(":username", $username);

$statement -> execute();

$user = $statement->fetchObject("User");

if ($user) {
  
  if (password_verify($password, $user->password)) {
    
    $_SESSION['user_id'] = $user->id;
    
  }else{
    
    echo "Incorrect password";
    
  }
  
}else{
  
  echo "Username does not exist";
  
}

