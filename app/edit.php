<?php

$id = $_GET['id'];

$db = getDb();
$post = $db->query(
  "SELECT * FROM Post WHERE id = $id"
)->fetchObject('Post');

#echo "<h3>Edit form</h3>";

$html = "";
$fields = get_object_vars($post);



echo "<form method='post' action='?p=edit&id=$id' class='w3-card w3-padding'>";
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
    <textarea
      name="content"
      rows="10"
      style="width: 100%"
    ><?= $post->content ?></textarea>
  </label>

  <br>
  <label>
    <span>Status: </span>
    <select name="draft">
      <option value="1" <?=$post->draft == 1 ? "selected": ""?>> Entwurf</option>
      <option value="0" <?=$post->draft == 0 ? "selected": ""?>> Veröffentlicht</option>
    </select>
  </label>

<br>

<?php

echo "<input type='submit' class='w3-button w3-blue' value='Save'>";
echo "</form>";
echo "<hr>";
echo "<pre>" . print_r($post, true) . "</pre>";
print_r($fields);