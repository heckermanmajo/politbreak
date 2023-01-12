<?php


$id = $_GET['id'];

#echo "<a href='?p=forum&id=$id'>Forum</a>";
#echo "<a href='?p=edit&id=$id'>Edit</a>";
$db = getDb();
$post = $db->query("SELECT * FROM Post WHERE id = $id")->fetchObject('Post');

#echo "<pre>" . print_r($post, true) . "</pre>";
put_post(
                  $post,
  details_button: false,
  edit_button:    true,
  forum_button:   true
);

// create a parapgraph
?>
  <form method="post">
    <div class="w3-container">
      <input type="hidden" name="action" value="create_paragraph">
      <input type="hidden" name="post_id" value="<?= $id ?>">
      <h2>Neuen Absatz hinzufügen</h2>
      <p>
        <label class="w3-text-blue"><b>Inhalt</b>
          <textarea class="w3-input w3-border" name="content" rows="10"></textarea>
        </label>
      </p>
      <p>
        <button class="w3-btn w3-blue">Absatz hinzufügen</button>
      </p>
    </div>
  </form>
<?php

// load the paragraphs
$statement = $db->prepare(
  "SELECT * FROM PostParagraph WHERE post_id = :id ORDER BY id ASC");

$statement->execute(['id' => $id]);
$paragraphs = $statement->fetchAll(PDO::FETCH_CLASS, PostParagraph::class);
print_r($paragraphs);
// print the paragraphs
foreach ($paragraphs as $paragraph) {
  echo "<div class='w3-card w3-padding'>";
  echo "<p>$paragraph->content</p>";
  echo "<pre>", print_r($paragraph, true), "</pre>";
  if ($paragraph->author_id == $_SESSION['user']->id) {
    echo "<form method='post'>";
    echo "<input type='hidden' name='id' value='{$paragraph->id}'>";
    echo "<input type='hidden' name='action' value='edit_paragraph'>";
    echo "<textarea style='width: 100%' name='content' rows='5'>{$paragraph->content}</textarea>";
    echo "<button class='w3-btn w3-blue'>Sichern</button>";
    echo "</form>";
  }
  echo "</div>";
}

