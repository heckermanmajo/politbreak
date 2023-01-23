<?php

// get the forum of the post

// list of channels
$db = getDb();

$post_id= $_GET["id"];

$statement = $db->prepare(
  "SELECT * FROM Channel WHERE post_id = :post_id; "
);
$statement->execute([
  "post_id" => $post_id
]);
$data = $statement->fetchAll(PDO::FETCH_ASSOC);
$channels = array_map(
  fn($channel) => populate(new Channel(), $channel),
  $data
);

?>

<form method="post" class="w3-card w3-padding">
  <input type="hidden" name="action" value="create_channel">
  <input type="hidden" name="post_id" value="<?= $post_id ?>">
  <label>
    <b>Titel</b><br>
    <small> Der Titel des Channels. </small> <br>
    <input type="text" name="title">
  </label>
  <br>
  <label>
    <b>Text</b><br>
    <small> Kurze Beschreibung des Channels </small> <br>
    <textarea name="description"></textarea>
  </label>
  <br>
  <input type="submit" value="Create" class="w3-button w3-blue">
</form>

<?php

foreach ($channels as $channel) {
  echo "<div class='channel w3-card w3-padding' >";
  echo "<h3>$channel->title</h3>";
  echo "<p>$channel->description</p>";
  echo "<a href='?p=one_channel&id=$channel->id'>Join</a>";
  echo "</div>";
  echo "<hr>";
}