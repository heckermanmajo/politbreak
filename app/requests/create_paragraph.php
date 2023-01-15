<?php

$pdo = getDb();
$paragraph = new PostParagraph();
$paragraph->author_id = $_SESSION['user']->id;
$paragraph->post_id = $_POST['post_id'];
$paragraph->content = $_POST['content'];
$paragraph->type = $_POST["type"];
$paragraph->date = date('Y-m-d H:i:s');
$paragraph->status = 'active';
$sql = getInsertSql($paragraph);
$pdo->prepare($sql)->execute(getSqlFields($paragraph));

print_r($paragraph);
