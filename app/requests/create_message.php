<?php
echo "Create Channel Message";

$db = getDb();
// Get the channel id
$channel_id = $_POST['channel_id'];

// Get the user's ID
$user_id = $_SESSION['user_id'];

$root_message_id = $_POST['root_message_id'];

$parent_message_id = $_POST['parent_message_id'];

// Get the message content
$content = $_POST['content'];

$message = new ChannelMessage();

// Set the message content
$message->content = $content;
$message->channel_id = $channel_id;
$message->author_id = $user_id;
$message->date = date('Y-m-d H:i:s');
$message->status = 'active';
$message->root_message_id = $root_message_id;
$message->parent_message_id = $parent_message_id;

// Create the message
$sql = getInsertSql($message);

$db->prepare($sql)->execute(getSqlFields($message));

print_r($message);