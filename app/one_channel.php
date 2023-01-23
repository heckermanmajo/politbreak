<?php


echo "One Channel";

$channel_id = $_GET['id'];

$db = getDb();

$channel = $db->query(
  "SELECT * FROM Channel WHERE id = $channel_id"
)->fetchObject('Channel');

// check if the user is logged in

$messages = $db->query(
  "SELECT * FROM ChannelMessage WHERE channel_id = $channel->id"
)->fetchAll(PDO::FETCH_ASSOC);

$messages = array_map(
  fn(
    $message
  ) => populate(new ChannelMessage(), $message),
  $messages
);

echo "<h3>$channel->title</h3>";
echo "<p>$channel->description</p>";

echo "<hr>";

echo "<h3>Messages</h3>";

?>


  <form method="post">
    <input type="hidden" name="action" value="create_message">
    <!-- Currently we cannot create a message as a child message -->
    <input type="hidden" name="parent_message_id" value="0">
    <input type="hidden" name="root_message_id" value="0">
    <input type="hidden" name="channel_id" value="<?= $channel->id ?>">
    <label>
      <b>Message</b><br>
      <textarea name="content"></textarea>
    </label>
    <br>
    <input type="submit" value="Send" class="w3-button w3-blue">
  </form>

<?php

// put all messages into their parent messages
// sort the messages by their parent message id
usort(
  $messages,
  fn(
    $a,
    $b
  ) => $a->parent_message_id <=> $b->parent_message_id
);

$messages_on_id = [];
// put all messages into their parents
foreach ($messages as $message) {
  $messages_on_id[$message->id] = $message;
  $messages_on_id[$message->parent_message_id]
    ->j_children[] = $message;
  if ($message->parent_message_id !== 0) {
    $message->j_depth =
      $messages_on_id[$message->parent_message_id]
        ->j_depth + 1;
  }
}

// parents
$parents = array_filter(
  $messages,
  fn(
    $message
  ) => $message->parent_message_id === 0
);

function displayMessage(
  ChannelMessage $message
) {
  global $channel;
  echo "<div class='message' style='margin-left: {$message->j_depth}px'>";
  //echo "<h4>$message->author_name</h4>";
  echo "<p>$message->content</p>";
  ?>
  <form method="post">
    <input type="hidden" name="action" value="create_message">
    <!-- Currently we cannot create a message as a child message -->
    <input type="hidden" name="parent_message_id" value="<?= $message->id ?>">
    <?php if ($message->root_message_id == 0): ?>
      <input type="hidden" name="root_message_id" value="<?= $message->id ?>">
    <?php else: ?>
      <input type="hidden" name="root_message_id"
             value="<?= $message->root_message_id ?>">
    <?php endif; ?>
    <input type="hidden" name="channel_id" value="<?= $channel->id ?>">
    <label>
      <b>Message</b><br>
      <textarea name="content"></textarea>
    </label>
    <br>
    <input type="submit" value="Send" class="w3-button w3-blue">
  </form>
  <?php
  foreach ($message->j_children as $child) {
    displayMessage($child);
  }
  echo "</div>";
  echo "<hr>";
}

foreach ($parents as $message) {
  displayMessage($message);
}
