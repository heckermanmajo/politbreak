<?php

$id = $_GET['id'];

$db = getDb();
$post = $db->query(
  "SELECT * FROM Post WHERE id = $id"
)->fetchObject('Post');

echo "<h3>Edit form</h3>";
echo "<pre>" . print_r($post, true) . "</pre>";
echo "<hr>";
$html = "";
$fields = get_object_vars($post);
print_r($fields);


echo "<form method='post' action='?p=edit&id=$id'>";
echo "<input type='hidden' name='id' value='$id'>";

?>
<input type="hidden" name="action" value="edit_post">

<label>
  <span>Title</span><br>
  <input type="text" name="title" value="<?= $post->title ?>">
</label>

<br>
<label>
  <span>Content</span><br>
  <textarea name="content" rows="10" style="width: 100%"><?= $post->content ?></textarea>
</label>


<?php

echo "<input type='submit' class='w3-button w3-blue' value='Save'>";
echo "</form>";