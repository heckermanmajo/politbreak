<?php

$id = $_POST["id"];

$pdo = getDb();
// get the paragraph
$sql = "SELECT * FROM PostParagraph WHERE id = :id";
$statement = $pdo->prepare($sql);
$statement->execute(["id" => $id]);
$paragraph = $statement->fetchObject(PostParagraph::class);

// check the author
if ($paragraph->author_id != $_SESSION["user"]->id) {
  echo "You are not the author of this paragraph";
  exit();
}

// update the paragraph
$paragraph->content = $_POST["content"];
$sql = getUpdateSql($paragraph);
$statement = $pdo->prepare($sql);
$statement->execute(getSqlFields($paragraph));



