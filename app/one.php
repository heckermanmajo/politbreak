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
          <label>
            <select name="type">
              <option value="h1"> Header 1 </option>
              <option value="h1"> Header 2 </option>
              <option value="h1"> Header 3 </option>
              <option value="h1"> Header 4 </option>
              <option value="h1"> Header 5 </option>
              <option value="def"> Definition </option>
              <option value="q"> Question </option>
              <option value="text" selected> Text-Paragraph </option>
            </select>
          </label>
          <textarea class="w3-input w3-border" name="content" rows="10"></textarea>
        </label>
      </p>
      <p>
        <button class="w3-btn w3-blue">Absatz hinzufügen</button>
      </p>
    </div>
  </form>
<?php

if ($post->category == "forum") {
  echo "
    <button>
      Join this group.
    </button>
  ";
}

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

$statement = $db->prepare(
  "SELECT * FROM PostComment WHERE post_id = :id ORDER BY id ASC");

$statement->execute(['id' => $id]);

$comments = $statement->fetchAll(PDO::FETCH_ASSOC);
$comments = array_map(
  fn($comment) => populate(new PostComment(), $comment),
  $comments
);

?>

<form method="post">
  <input type="hidden" name="action" value="create_post_comment">
  <div class="w3-container">
    <h2>Neuen Kommentar hinzufügen</h2>
    <p>
      <label class="w3-text-blue"><b>Inhalt</b>
        <textarea class="w3-input w3-border" name="content" rows="10"></textarea>
      </label>
    </p>
    <select name="comment_category">
      <option>Ergänzung</option>
      <option>Frage</option>
      <option>Andere Perspektive</option>
      <option>Kritik</option>
      <option>Zusätzliche Information</option>
    </select>
    <p>
      <button class="w3-btn w3-blue">Kommentar hinzufügen</button>
    </p>
  </div>
</form>

<?php
foreach ($comments as $comment) {
  echo "<div class='w3-card w3-padding'>";
  echo "<p>$comment[content]</p>";
  echo "</div>";
}
