<?php

$db = getDb();
$channel = new Channel();
$channel->title = $_POST["title"];
$channel->post_id = $_POST["post_id"];
$channel->author_id = $_SESSION["user"]->id;
$channel->description = $_POST["description"];
$channel->date = date("Y-m-d H:i:s");
$channel->tags = $_POST["tags"] ?? "";
$channel->status = "active";

$db->prepare(
  getInsertSql($channel)
)->execute(getSqlFields($channel));

