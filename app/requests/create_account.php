<?php


$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

if ($password != $confirm_password) {
    echo "Passwords do not match";
    exit();
}

#if (strlen($password) < 8) {
 #   echo "Password must be at least 8 characters long";
 #   exit();
#}

$db = getDb();

$statement = $db->prepare("SELECT * FROM User WHERE username = :username");

$statement -> bindParam(":username", $username);

$statement -> execute();

$user = $statement->fetchObject("User");

if ($user) {
    echo "Username already exists";
    exit();
}

$statement = $db->prepare("SELECT * FROM User WHERE email = :email");

$statement -> bindParam(":email", $email);

$statement -> execute();

$user = $statement->fetchObject("User");

if ($user) {
    echo "Email already exists";
    exit();
}

$password = password_hash($password, PASSWORD_DEFAULT);

$statement = $db->prepare("INSERT INTO User (username, email, password) VALUES (:username, :email, :password)");

$statement -> bindParam(":username", $username);

$statement -> bindParam(":email", $email);

$statement -> bindParam(":password", $password);

$statement -> execute();

$_SESSION["user_id"] = (int) $db->lastInsertId();



